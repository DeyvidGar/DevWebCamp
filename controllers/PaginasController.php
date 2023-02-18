<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Evento;
use Model\Hora;
use Model\Ponente;
use MVC\Router;

class PaginasController {
    public static function index(Router $router) {
        // if(!isAuth()) redireccionarAuth();
        $eventos = Evento::ordenar('hora_id', 'ASC');
        //agrupar
        $evento_agrupar = [];
        foreach($eventos as $evento){
            //agregamos las relaciones
            $evento->categoria = Categoria::selectFind('id, nombre', $evento->categoria_id);
            $evento->dia = Dia::selectFind('id, nombre', $evento->dia_id);
            $evento->hora = Hora::selectFind('id, hora', $evento->hora_id);
            $evento->ponente = Ponente::selectFind('id, nombre, apellido, imagen', $evento->ponente_id);

            //un arreglo para cada dia de un determinado evento
            if($evento->categoria_id === '1' && $evento->dia_id === '1')
                $evento_agrupar['conferencias_viernes'][] = $evento;
            if($evento->categoria_id === '1' && $evento->dia_id === '2')
                $evento_agrupar['conferencias_sabado'][] = $evento;
            if($evento->categoria_id === '2' && $evento->dia_id === '1')
                $evento_agrupar['workshops_viernes'][] = $evento;
            if($evento->categoria_id === '2' && $evento->dia_id === '2')
                $evento_agrupar['workshops_sabado'][] = $evento;
        }

        $num_ponentes = Ponente::total();
        $num_coferencias = Evento::total('categoria_id', 1);
        $num_workshops = Evento::total('categoria_id', 2);

        // obtener ponentes
        $ponentes = Ponente::all();

        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $evento_agrupar,
            'num_ponentes' => $num_ponentes,
            'num_conferencias' => $num_coferencias,
            'num_workshops' => $num_workshops,
            'ponentes' => $ponentes
        ]);
    }

    public static function evento(Router $router) {
        // if(!isAuth()) redireccionarAuth();
        $router->render('paginas/devwebcamp', [
            'titulo' => 'Sobre DebWebCamp'
        ]);
    }

    public static function paquetes(Router $router) {
        // if(!isAuth()) redireccionarAuth();

        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes DebWebCamp'
        ]);
    }

    public static function conferencias(Router $router) {
        // if(!isAuth()) redireccionarAuth();
        $eventos = Evento::ordenar('hora_id', 'ASC');
        //agrupar
        $evento_agrupar = [];
        foreach($eventos as $evento){
            //agregamos las relaciones
            $evento->categoria = Categoria::selectFind('id, nombre', $evento->categoria_id);
            $evento->dia = Dia::selectFind('id, nombre', $evento->dia_id);
            $evento->hora = Hora::selectFind('id, hora', $evento->hora_id);
            $evento->ponente = Ponente::selectFind('id, nombre, apellido, imagen', $evento->ponente_id);

            //un arreglo para cada dia de un determinado evento
            if($evento->categoria_id === '1' && $evento->dia_id === '1')
                $evento_agrupar['conferencias_viernes'][] = $evento;
            if($evento->categoria_id === '1' && $evento->dia_id === '2')
                $evento_agrupar['conferencias_sabado'][] = $evento;
            if($evento->categoria_id === '2' && $evento->dia_id === '1')
                $evento_agrupar['workshops_viernes'][] = $evento;
            if($evento->categoria_id === '2' && $evento->dia_id === '2')
                $evento_agrupar['workshops_sabado'][] = $evento;
        }
        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $evento_agrupar
        ]);
    }

    public static function error( Router $router ){
        $router->render('paginas/error', [
            'titulo' => 'Pagina no encontrada'
        ]);
    }
}