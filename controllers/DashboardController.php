<?php 

namespace Controllers;

use Model\Evento;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController{
    public static function index(Router $router){
        
        if(!is_admin()){
            header('Location: /');
            return;
        }

        $registros = Registro::get(5);
        foreach($registros as $registro){
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        //calcular los ingresos 
        $virtuales = Registro::total('paquete_id',2);
        $presenciales= Registro::total('paquete_id',1);

        $ingresos = ( $virtuales * 47.00) + ($presenciales * 188.90);


        //Eventos con mas y menos lugares

        $eventos_mas = Evento::ordenarLimite('disponibles','DESC',5);
        $eventos_menos = Evento::ordenarLimite('disponibles','ASC',5);
        $router->render('admin/dashboard/index',[
            'titulo' => 'Panel de Administración',
            'registros' => $registros,
            'ingresos' => $ingresos,
            'eventos_mas' => $eventos_mas,
            'eventos_menos' => $eventos_menos
        ]);
    }
}