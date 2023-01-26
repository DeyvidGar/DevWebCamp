<?php

namespace Controllers;

use Model\Categorias;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use MVC\Router;

class EventosController {
    public static function index(Router $router) {
        $alertas = [];
        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y workshop',
            'alertas' => $alertas
        ]);
    }
    public static function crear(Router $router) {
        $alertas = [];
        $categorias = Categorias::all('ASC');
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
}