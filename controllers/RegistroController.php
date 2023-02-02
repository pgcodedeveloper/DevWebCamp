<?php 

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\EventosRegistros;
use Model\Hora;
use Model\Paquete;
use Model\Ponente;
use Model\Regalo;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class RegistroController{


    public static function crear(Router $router){

        if(!is_auth()){
            header('Location: /');
            return;
        }

        //verificar si el usuario ya eligio un plan
        $registro = Registro::where('usuario_id',$_SESSION['id']);
        if(isset($registro) && $registro->paquete_id === "3"){
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

        if(isset($registro) && $registro->paquete_id === "2"){
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

        if(isset($registro) && $registro->paquete_id === "1"){
            header('Location: /finalizar-registro/conferencias');
            return;
        }
        $router->render('registro/crear',[
            'titulo' => 'Finalizar Registro'
        ]);
        
    }

    public static function gratis(Router $router){
        if(!is_auth()){
            header('Location: /');
            return;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /');
                return;
            }
            //verificar si el usuario ya eligio un plan
            $registro = Registro::where('usuario_id',$_SESSION['id']);
            if(isset($registro) && $registro->paquete_id === "3"){
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //Crear registro
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado){
                header('Location: /boleto?id=' . urlencode($registro->token));
                return;
            }

        }
    }

    public static function boleto(Router $router){
        $id = $_GET['id'];

        if(!$id || !strlen($id) === 8 ){
            header('Location: /');
            return;
        }

        $registro = Registro::where('token',$id);
        if(!$registro){
            header('Location: /');
            return;
        }

        //Llenar el registro con los demas datos de las demas tablas 
        $registro->paquete = Paquete::find($registro->paquete_id);
        $registro->usuario = Usuario::find($registro->usuario_id);


        $router->render('registro/boleto',[
            'titulo' => 'Boleto para asistir al evento',
            'registro' => $registro
        ]);

    }

    public static function pagar(Router $router){
        if(!is_auth()){
            header('Location: /');
            return;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_auth()){
                header('Location: /');
                return;
            }
            
            //Validar que POST no venga vacio
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }


            $token = substr(md5(uniqid(rand(), true)), 0, 8);

            //Crear registro
            $datos = $_POST;
            $datos['token'] = $token;
            $datos['usuario_id'] = $_SESSION['id'];

            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }
        }
    }

    public static function conferencias(Router $router){
        
        if(!is_auth()){
            header('Location: /login');
            return;
        }

        //Validar el plan
        $user = $_SESSION['id'];
        $registro = Registro::where('usuario_id',$user);

        if(isset($registro) && $registro->paquete_id === "2"){
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

        if($registro->paquete_id !== "1"){
            header('Location: /');
            return;
        }

        //Revisar si el usuario ya tiene sus conferencias elegidas
        if(isset($registro->regalo_id) && $registro->regalo_id !== "1" && $registro->paquete_id === "1"){
            header('Location: /boleto?id=' . urlencode($registro->token));
            return;
        }

        $eventos = Evento::ordenar('hora_id','ASC');

        $eventos_format = [];
        foreach($eventos as $evento){
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia= Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
            
            if($evento->dia_id === "1" && $evento->categoria_id === "1"){
                $eventos_format['conferencias_v'][] = $evento;
            }
            if($evento->dia_id === "2" && $evento->categoria_id === "1"){
                $eventos_format['conferencias_s'][] = $evento;
            }

            if($evento->dia_id === "1" && $evento->categoria_id === "2"){
                $eventos_format['workshops_v'][] = $evento;
            }
            if($evento->dia_id === "2" && $evento->categoria_id === "2"){
                $eventos_format['workshops_s'][] = $evento;
            }
        }

        $regalos = Regalo::all('ASC');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if(!is_auth()){
                header('Location: /login');
                return;
            }
    
            $eventos = explode(',',$_POST['eventos']);
            
            if(empty($eventos)){
                echo json_encode(['resultado' => false]);
                return;
            }

            //Registro del usuario
            $user = $_SESSION['id'];
            $registro = Registro::where('usuario_id',$user);
    
            if(!isset($registro) || $registro->paquete_id !== "1"){
                echo json_encode(['resultado' => false]);
                return;
            }

            $eventos_array = [];
            //Validar la disponibilidad
            foreach( $eventos as $eventoID){
                $evento = Evento::find($eventoID);
                if(!isset($evento) || $evento->disponibles === "0"){
                    echo json_encode(['resultado' => false]);
                    return;
                }
                $eventos_array[] = $evento;
            }

            foreach( $eventos_array as $evento){
                $evento->disponibles -= 1;
                $evento->guardar();

                //Almacenar el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                $registro_user = new EventosRegistros($datos);
                $registro_user->guardar();
                
            }

            //Almaceno el registro con su regalo
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();
            if($resultado){
                echo json_encode([
                    'resultado' => $resultado,
                    'token' => $registro->token
                ]);       
            }
            else{
                echo json_encode(['resultado' => false]);
            }

            return;
        }

        $router->render('registro/conferencias',[
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_format,
            'regalos' => $regalos
        ]);


    }
}