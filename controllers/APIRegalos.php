<?php

namespace Controllers;

use Model\Regalo;
use Model\Registro;

class APIRegalos{

    public static function regalos(){
        if(!is_admin()){
            echo json_encode([
                'error' => 'No tiene permisos para acceder a esta API'
            ]);
            return;
        }
        $regalos = Regalo::all();
        foreach($regalos as $regalo){
            $regalo->total = Registro::totalArray(['regalo_id' => $regalo->id, 'paquete_id' => "1"]);
        }

        echo json_encode($regalos);
        return;
    }
}