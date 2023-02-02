<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Evento;

class PonentesController{
    public static function index(Router $router){
        if(!is_admin()){
            header('Location: /');
        }

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1){
            header('Location: /admin/ponentes?page=1');
        }
        $registros_por_pagina = 10;
        $total = Ponente::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        
        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/ponentes?page=1');
        }
        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/ponentes/index',[
            'titulo' => 'Ponentes / Conferencistas',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }


    public static function crear(Router $router){
        
        if(!is_admin()){
            header('Location: /');
        }
        $alertas = [];

        $ponente= new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Leer Imagen

            if(!empty($_FILES['imagen']['tmp_name'])){
                $carpeta_img= '../public/img/speakers';

                //Crear la carpeta
                if(!is_dir($carpeta_img)){
                    mkdir($carpeta_img,0777,true);
                }

                $img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
                $img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);

                $nombre_img= md5(uniqid(rand(),true));

                $_POST['imagen'] = $nombre_img;

            }

            $_POST['redes'] = json_encode( $_POST['redes'], JSON_UNESCAPED_SLASHES);
            
            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            //Guardar
            if(empty($alertas)){
                //Guardar la imagen
                $img_png->save($carpeta_img . '/' . $nombre_img . ".png");
                $img_webp->save($carpeta_img . '/' . $nombre_img . ".webp");

                //registro en la BD
                $resultado = $ponente->guardar();

                if($resultado){
                    header('Location: /admin/ponentes');
                }
            }
        }
        $router->render('admin/ponentes/crear',[
            'titulo' => 'Registrar un nuevo Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router){
        
        if(!is_admin()){
            header('Location: /');
        }
        $alertas = [];

        $id= $_GET['id'];
        $id_val = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id_val){
            header('Location: /admin/ponentes');
        }

        $ponente = Ponente::find($id);

        if(!$ponente){
            header('Location: /admin/ponentes');
        }

        $ponente->imagen_actual = $ponente->imagen;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            if(!empty($_FILES['imagen']['tmp_name'])){
                $carpeta_img= '../public/img/speakers';

                //Crear la carpeta
                if(!is_dir($carpeta_img)){
                    mkdir($carpeta_img,0777,true);
                }

                $img_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png',80);
                $img_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp',80);

                $nombre_img= md5(uniqid(rand(),true));

                $_POST['imagen'] = $nombre_img;

            }
            else{
                $_POST['imagen'] = $ponente->imagen_actual;
            }
            
            $_POST['redes'] = json_encode( $_POST['redes'], JSON_UNESCAPED_SLASHES);
            
            $ponente->sincronizar($_POST);
            
            $alertas = $ponente->validar();
            if(empty($alertas)){
                if(isset($nombre_img)){
                    $img_png->save($carpeta_img . '/' . $nombre_img . ".png");
                    $img_webp->save($carpeta_img . '/' . $nombre_img . ".webp");
                    
                }

                $resultado = $ponente->guardar();

                if($resultado){
                    header('Location: /admin/ponentes');
                }
            }
        }
        $router->render('admin/ponentes/editar',[
            'titulo' => 'Editar Orador',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function eliminar(){

        if(!is_admin()){
            echo json_encode(['resultado' => 'No tienes acceso a esta API']);
            return;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()){
                echo json_encode(['resultado' => 'No tienes acceso a esta API']);
                return;
            }

            $id= $_POST['id'];
            $ponente = Ponente::find($id);
            $tiene_eventos = Evento::where('ponente_id',$ponente->id);

            if(isset($tiene_eventos)){
                echo json_encode(['resultado' => false]);
                return;
            }

            if(!isset($ponente)){
                echo json_encode(['error' => 'No se pudo realizar la operacion']);
                return;
            }

            if ($ponente->imagen) {
                $carpeta_imagenes = '../public/img/speakers';
                unlink($carpeta_imagenes . '/' . $ponente->imagen . ".png");
                unlink($carpeta_imagenes . '/' . $ponente->imagen . ".webp");
            }
            $resultado = $ponente->eliminar();

            if($resultado){
                echo json_encode(['resultado' => $resultado]);
                return;
            }
        }
    }
}