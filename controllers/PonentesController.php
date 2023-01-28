<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Ponente;
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {
    public static function index(Router $router) {
        // if(!isAuth()) redireccionarAuth();
        $alertas = [];
        $mensaje = $_GET['mensaje'] ?? null;
        $tipo = $_GET['tipo'] ?? null;
        if($mensaje && $tipo){
            $mensaje = filter_var($mensaje, FILTER_VALIDATE_INT);
            $tipo = s($tipo);
            if(!$mensaje || !$tipo) header('Location: /admin/ponentes?page=1');
            $mensaje = mostrarMensaje($mensaje);
            Ponente::setAlerta($tipo, $mensaje);
        }
        $alertas = Ponente::getAlertas();

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        $registros_por_pagina = 4;
        $total_registros = Ponente::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        if(!$pagina_actual || $pagina_actual < 1 || $pagina_actual > $paginacion->total_paginas()) header('Location: /admin/ponentes?page=1');

        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());


        $router->render('admin/ponentes/index', [
            'titulo' => 'Usuarios Ponentes',
            'ponentes' => $ponentes,
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function crear(Router $router) {
        // if(!isAuth()) redireccionarAuth();
        $alertas = [];
        $ponente = new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // if(!isAuth()) redireccionarAuth();

            //leer imagen dentro del formulario
            if(!empty($_FILES['imagen']['tmp_name'])){
                //ruta donde guardar estas imagenes
                $carpeta_ponentes = '../public/img/ponentes';
                //crear la carpeta si no existe
                if(!is_dir($carpeta_ponentes)) mkdir($carpeta_ponentes, 0777, true);

                //crear las imagenes con la ayuda de interventionImage (paqueteria de composer)
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_aletorio = md5( uniqid( rand() , true ) );

                //le damos el nombre a la imagen que viene de post
                $_POST['imagen'] = $nombre_aletorio;
            }

            //DEBIDO A QUE LAS REDES SE ENCUENTRAN EN UN ARREGLO, y nuestra arquitectura solo lee los elementos de un objeto por string y no por erreglo debemos,
            //convertir el arreglo redes[] en cadena de texto
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);

            // validar
            $alertas = $ponente->validar();

            //guardar registro
            if(empty($alertas)){
                //guardar las imagenes
                $imagen_png->save($carpeta_ponentes.'/'.$nombre_aletorio.'.png');
                $imagen_webp->save($carpeta_ponentes.'/'.$nombre_aletorio.'.webp');

                //guardar el bd
                $resultado = $ponente->guardar();

                if($resultado) header('Location: /admin/ponentes?mensaje=1&tipo=exito');
            }
        }

        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router) {
        // if(!isAuth()) redireccionarAuth();
        $alertas = [];
        //validar id
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) header('Location: /admin/ponentes');

        //buscamos por id
        $ponente = Ponente::find($id);
        if(!$ponente) header('Location: /admin/ponentes');

        $ponente->imagen_actual = $ponente->imagen;

        $redes = json_decode($ponente->redes);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // if(!isAuth()) redireccionarAuth();

            //leer imagen dentro del formulario
            if(!empty($_FILES['imagen']['tmp_name'])){
                //ruta donde guardar estas imagenes
                $carpeta_ponentes = '../public/img/ponentes';
                //crear la carpeta si no existe
                if(!is_dir($carpeta_ponentes)) mkdir($carpeta_ponentes, 0777, true);

                //crear las imagenes con la ayuda de interventionImage (paqueteria de composer)
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                $nombre_aletorio = md5( uniqid( rand() , true ) );

                //le damos el nombre a la imagen que viene de post
                $_POST['imagen'] = $nombre_aletorio;
            } else {
                $_POST['imagen'] = $ponente->imagen_actual;
            }
            //convertir el arreglo redes[] en cadena de texto
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $ponente->sincronizar($_POST);

            $alertas = $ponente->validar();

            if(empty($alertas)){
                if(isset($nombre_aletorio)){
                    //se inserto una imagen, entonces:
                    //guardar las imagenes
                    $imagen_png->save($carpeta_ponentes.'/'.$nombre_aletorio.'.png');
                    $imagen_webp->save($carpeta_ponentes.'/'.$nombre_aletorio.'.webp');
                    //eliminando imagen a reemplazar
                    unlink($carpeta_ponentes . '/' . $ponente->imagen_actual . ".png" );
                    unlink($carpeta_ponentes . '/' . $ponente->imagen_actual . ".webp" );
                }
            }
            //guardar el bd
            $resultado = $ponente->guardar();

            if($resultado) header('Location: /admin/ponentes?mensaje=2&tipo=exito');
        }

        $router->render('admin/ponentes/editar', [
            'titulo' => 'Usuario Ponente',
            'ponente' => $ponente,
            'alertas' => $alertas,
            'redes' => $redes
        ]);
    }

    public static function eliminar() {
        // if(!isAuth()) redireccionarAuth();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // if(!isAuth()) redireccionarAuth();
            //validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if(!$id) header('Location: /admin/ponentes');

            //buscamos por id
            $ponente = Ponente::find($id);
            if(!$ponente) header('Location: /admin/ponentes');

            $resultado = $ponente->eliminar();

            if($resultado) header('Location: /admin/ponentes?mensaje=3&tipo=exito');
        }
    }
}