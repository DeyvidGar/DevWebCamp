<?php

namespace Controllers;

use Model\Ponente;

//ESTA API SE CREA PARA QUE NUESTRO JS CONSULTE DATOS QUE SE ENCUENTRAN EL BASE DE DATOS Y EVALUAR LOS TIPO DE DATOS QUE REQUIERA MOSTRAR ETC.
class APIPonentes {
    public static function index() {
        $ponentes = Ponente::all();
        echo json_encode($ponentes);
    }

    public static function ponente(){
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id || $id < 1) {
            echo json_encode([]);
            return;
        }
        $ponente = Ponente::selectFind('nombre, apellido', $id);
        echo json_encode($ponente, JSON_UNESCAPED_SLASHES);
    }
}