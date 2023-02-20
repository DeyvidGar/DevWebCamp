<?php

namespace Controllers;

use MVC\Router;
use Classes\Paginacion;
use Model\Paquete;
use Model\Regalo;
use Model\Registro;
use Model\Usuario;

class RegistradosController {
    public static function index(Router $router) {
        if(!isAdmin()) redireccionarAuth();

        $alertas = [];
        $mensaje = $_GET['mensaje'] ?? null;
        $tipo = $_GET['tipo'] ?? null;
        if($mensaje && $tipo){
            $mensaje = filter_var($mensaje, FILTER_VALIDATE_INT);
            $tipo = s($tipo);
            if(!$mensaje || !$tipo) header('Location: /admin/registrados?page=1');
            $mensaje = mostrarMensaje($mensaje);
            Registro::setAlerta($tipo, $mensaje);
        }
        $alertas = Registro::getAlertas();

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        $registros_por_pagina = 4;
        $total_registros = Registro::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        if(!$pagina_actual || $pagina_actual < 1 ) header('Location: /admin/registrados?page=1');

        $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());

        foreach($registros as $registro){
            $registro->paquete = Paquete::selectFind('nombre', $registro->paquete_id);
            $registro->usuario = Usuario::selectFind('nombre, apellido, email', $registro->usuario_id);
            if($registro->paquete_id === '1')
                $registro->regalo = Regalo::find($registro->regalo_id);
        }

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios registrados',
            'registros' => $registros,
            'alertas' => $alertas,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}