<?php 

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\EventosRegistros;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class EventosController{
    public static function index(Router $router){
        if(!is_admin()){
            header('Location: /');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if(!$pagina_actual || $pagina_actual < 1){
            header('Location: /admin/eventos?page=1');
        }

        $por_pagina = 10;
        $total = Evento::total();

        $paginacion = new Paginacion($pagina_actual,$por_pagina,$total);
        $eventos = Evento::paginar($por_pagina,$paginacion->offset());
        foreach($eventos as $evento){
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia= Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }
        


        $router->render('admin/eventos/index',[
            'titulo' => 'Workshops / Conferencias',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){
        if(!is_admin()){
            header('Location: /');
        }
        $alertas = [];

        $categorias = Categoria::all("ASC");
        $dias = Dia::all("ASC");
        $horas = Hora::all("ASC");
        $evento = new Evento;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()){
                header('Location: /');
            }
            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();

                if($resultado){
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/crear',[
            'titulo' => 'Registrar nuevo Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function editar(Router $router){
        if(!is_admin()){
            header('Location: /');
        }
        $alertas = [];

        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);
        if(!$id){
            header('Location: /admin/eventos');
        }

        $categorias = Categoria::all("ASC");
        $dias = Dia::all("ASC");
        $horas = Hora::all("ASC");
        $evento = Evento::find($id);

        if(!$evento){
            header('Location: /admin/eventos');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()){
                header('Location: /');
            }
            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();

                if($resultado){
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/editar',[
            'titulo' => 'Editar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function eliminar(){
        if(!is_auth()){
            echo json_encode(['error' => 'No tienes permisos para usar esta API']);
            return;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            if(!is_admin()){
                echo json_encode(['error' => 'No tienes permisos para usar esta API']);
                return;
            }

            $id = $_POST['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);

            if(!$id || $id < 1){
                echo json_encode(['resultado' => false]);
                return;
            }
            $evento = Evento::find($id);
            //Evaluar si el evento esta registrado por alguien
            $registro_evento = EventosRegistros::where('evento_id',$evento->id);

            if(!isset($evento) || isset($registro_evento)){
                echo json_encode(['resultado' => false]);
                return;
            }
            $resultado = $evento->eliminar();
            
            if($resultado){
                echo json_encode(['resultado' => $resultado]);
                return;
            }
            
        }
    }
}