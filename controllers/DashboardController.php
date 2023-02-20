<?php

namespace Controllers;

use Model\Evento;
use Model\Registro;
use Model\Usuario;
use MVC\Router;

class DashboardController {
    public static function index(Router $router) {

        // obtenemos los ultimos 5 registros
        $registros = Registro::get(5);
        foreach($registros as $registro){
            $registro->usuario = Usuario::selectFind('nombre, apellido', $registro->usuario_id);
        }

        // calcular los registros
        $num_presencial = Registro::total('paquete_id', 1);
        $num_virtuales = Registro::total('paquete_id', 2);
        //total costo neto
        $total = ($num_presencial * 189.54) + ($num_virtuales * 46.41);

        // Obtener eventos con mas y menos lugares disponibles
        $menos_disponibles = Evento::ordenarLimite('disponibles', 'ASC', 5);
        $mas_disponibles = Evento::ordenarLimite('disponibles', 'DESC', 5);
        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de administracion',
            'registros' => $registros,
            'num_presencial' => $num_presencial,
            'num_virtuales' => $num_virtuales,
            'total' => $total,
            'mas_disponibles' => $mas_disponibles,
            'menos_disponibles' => $menos_disponibles,
        ]);
    }
}