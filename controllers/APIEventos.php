<?php

namespace Controllers;

use Model\EventoHorario;

//ESTA API SE CREA PARA QUE NUESTRO JS CONSULTE DATOS QUE SE ENCUENTRAN EL BASE DE DATOS Y EVALUAR LOS TIPO DE DATOS QUE REQUIERA MOSTRAR ETC.
class APIEventos {
    public static function index() {
        $dia_id = $_GET['dia_id'] ?? '';
        $categoria_id = $_GET['categoria_id'] ?? '';

        $dia_id =  filter_var($dia_id, FILTER_VALIDATE_INT);
        $categoria_id =  filter_var($categoria_id, FILTER_VALIDATE_INT);

        if(!$dia_id || !$categoria_id) {
            echo json_encode([]);
            return;
        } //encaso de no tener valores en los metodos, retornamos un arreglo vacio

        //consultar la base de datos
        //esta funcion recibe un arreglo asiciativo, en donde el valor de la KEY debe ser igual al que se desea buscar en la base de datos y el VALUE el valor a buscar.
        $eventos = EventoHorario::whereArray([
            'dia_id' => $dia_id,
            'categoria_id' => $categoria_id
        ]) ?? [];

        echo json_encode($eventos);

    }
}