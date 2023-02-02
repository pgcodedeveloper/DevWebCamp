<?php


namespace Controllers;

use Model\Evento;
use Model\EventoHorario;
use Model\Ponente;

class APIEventos {

    public static function eventos_horario(){
        if(!is_admin()){
            echo json_encode(['error' => 'No tienes permisos para usar esta API']);
            return;
        }
        $dia_id = $_GET['dia_id'] ?? '';
        $categoria_id = $_GET['categoria_id'] ?? '';

        $dia_id = filter_var($dia_id, FILTER_VALIDATE_INT);
        $categoria_id = filter_var($categoria_id, FILTER_VALIDATE_INT);

        if(!$dia_id || !$categoria_id){
            echo json_encode([]);
            return;
        }

        //Consultar

        $eventos = EventoHorario::whereArray(['dia_id' => $dia_id, 'categoria_id' => $categoria_id]) ?? [];

        echo json_encode($eventos);
    }

    public static function ponentes(){
        $ponentes = Ponente::all();
        echo json_encode($ponentes);
    }

    public static function ponente(){
        if(!is_admin()){
            echo json_encode(['error' => 'No tienes permisos para usar esta API']);
            return;
        }
        $id = $_GET['id'];
        $id = filter_var($id,FILTER_VALIDATE_INT);

        if(!$id || $id < 1){
            echo json_encode([]);
            return;
        }

        $ponente = Ponente::find($id);
        echo json_encode($ponente);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            if(!is_admin()){
                echo json_encode(['error' => 'No tienes permisos para usar esta API']);
                return;
            }

            $id = $_POST['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);

            if(!$id || $id < 1){
                echo json_encode([]);
                return;
            }
            $evento = Evento::find($id);

            $resultado = $evento->eliminar();
            
            if($resultado){
                $respuesta = [
                    'tipo' => "exito"
                ];
                echo json_encode($respuesta);
            }
            
        }
    }
}