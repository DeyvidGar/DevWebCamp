<?php

namespace Controllers;

use Model\Regalo;
use Model\Registro;

//ESTA API SE CREA PARA QUE NUESTRO JS CONSULTE DATOS QUE SE ENCUENTRAN EL BASE DE DATOS Y EVALUAR LOS TIPO DE DATOS QUE REQUIERA MOSTRAR ETC.
class APIRegalos {
    public static function index() {
        $regalos = Regalo::all();
        //por cada regalos le agregamos cuantos son lo que estan registraod con el paquete 1 es decir el paquete premium
        foreach($regalos as $regalo){
            $regalo->total = Registro::totalArray(['regalo_id' => $regalo->id, 'paquete_id' => '1']);
        }
        echo json_encode($regalos);
        return;
    }
}