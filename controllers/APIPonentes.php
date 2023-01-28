<?php

namespace Controllers;

use Model\Ponente;

//ESTA API SE CREA PARA QUE NUESTRO JS CONSULTE DATOS QUE SE ENCUENTRAN EL BASE DE DATOS Y EVALUAR LOS TIPO DE DATOS QUE REQUIERA MOSTRAR ETC.
class APIPonentes {
    public static function index() {
        $ponentes = Ponente::all();
        echo json_encode($ponentes);
    }
}