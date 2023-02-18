<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class EventosController {
    public static function index(Router $router) {
        // if(!isAuth()) redireccionarAuth();
        $alertas = [];
        $mensaje = $_GET['mensaje'] ?? null;
        $tipo = $_GET['tipo'] ?? null;
        if($mensaje && $tipo){
            $mensaje = filter_var($mensaje, FILTER_VALIDATE_INT);
            $tipo = s($tipo);
            if(!$mensaje || !$tipo) header('Location: /admin/eventos?page=1');
            $mensaje = mostrarMensaje($mensaje);
            Evento::setAlerta($tipo, $mensaje);
        }
        $alertas = Evento::getAlertas();

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        $registros_por_pagina = 10;
        $total_registros = Evento::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        if(!$pagina_actual || $pagina_actual < 1) header('Location: /admin/eventos?page=1');

        $eventos = Evento::paginar($registros_por_pagina, $paginacion->offset());

        foreach($eventos as $evento){
            $evento->categoria_id = Categoria::selectFind('nombre', $evento->categoria_id);
            $evento->dia_id = Dia::selectFind('nombre', $evento->dia_id);
            $evento->hora_id = Hora::selectFind('hora', $evento->hora_id);
            $evento->ponente_id = Ponente::selectFind('nombre, apellido', $evento->ponente_id);
        }

        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y workshop',
            'alertas' => $alertas,
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    public static function crear(Router $router) {
        $alertas = [];
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');
        $evento = new Evento;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();
                if($resultado) header('Location: /admin/eventos');
            }
        }

        $router->render('admin/eventos/crear', [
            'alertas' => $alertas,
            'titulo' => 'Crear un nuevo evento',
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function editar(Router $router) {
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) header('Location: /admin/eventos?page=1');
        $evento = Evento::find($id);
        if(!$evento) header('Location: /admin/eventos?page=1');


        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento->sincronizar($_POST);
            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();
                if($resultado) header('Location: /admin/eventos');
            }
        }

        $router->render('admin/eventos/editar', [
            'alertas' => $alertas,
            'titulo' => 'Editando evento',
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $evento = Evento::find($_POST['id']);

            if( !isset($evento) ) header('Location: /admin/eventos');

            $resul = $evento->eliminar();

            if($resul) header('Location: /admin/eventos');
        }
    }
}