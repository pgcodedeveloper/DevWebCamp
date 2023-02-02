<?php

namespace Controllers;

use MVC\Router;

class RegalosController{
    public static function index(Router $router){
        if(!is_admin()){
            header('Location: /');
        }
        $router->render('admin/regalos/index',[
            'titulo' => 'Regalos para Clientes'
        ]);
    }
}