<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class PaginasController{

    public static function index(Router $router){
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

        $ponente_total = Ponente::total();
        $conferencias = Evento::total('categoria_id','1');
        $workshops= Evento::total('categoria_id', '2');

        $ponentes = Ponente::all('ASC');

        $router->render('paginas/index',[
            'titulo' => 'Inicio',
            'eventos' => $eventos_format,
            'ponente_total' => $ponente_total,
            'conferencias' => $conferencias,
            'workshops' => $workshops,
            'ponentes' => $ponentes
        ]);
    }

    public static function evento(Router $router){
        $router->render('paginas/devwebcamp',[
            'titulo' => 'Sobre DevWebCamp'
        ]);
    }

    public static function paquetes(Router $router){
        $router->render('paginas/paquetes',[
            'titulo' => 'Paquetes DevWebCamp'
        ]);
    }

    public static function conferencias(Router $router){

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

        $router->render('paginas/conferencias',[
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_format
        ]);
    }


    public static function evento_id(Router $router){

        $id= $_GET['id'];
        $id= filter_var($id,FILTER_VALIDATE_INT);

        if(!$id){
            header('Location: /workshops');
        }

        $evento = Evento::find($id);

        if(empty($evento)){
            header('Location: /workshops');
        }

        $evento->categoria = Categoria::find($evento->categoria_id);
        $evento->dia= Dia::find($evento->dia_id);
        $evento->hora = Hora::find($evento->hora_id);
        $evento->ponente = Ponente::find($evento->ponente_id);   
        

        $router->render('paginas/evento',[
            'titulo' => 'Conferencias & Workshops',
            'evento' => $evento
        ]);
    }

    public static function error(Router $router){

        $router->render('paginas/error',[
            'titulo' => 'Página no encontrada o ruta no válida'
        ]);
    }

}