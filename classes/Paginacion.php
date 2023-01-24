<?php

namespace Classes;

class Paginacion {

    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;

    public function __construct($pagina_actual = 0, $registros_por_pagina = 10, $total_registros = 0)
    {
        $this->pagina_actual = (int) $pagina_actual; //casteamos el valor / similar a parcear
        $this->registros_por_pagina = (int) $registros_por_pagina; //casteamos el valor / similar a parcear
        $this->total_registros = (int) $total_registros; //casteamos el valor / similar a parcear
    }

    //en caso de estar en la pagina uno, el valor de la
    public function offset() {
        return $this->registros_por_pagina * ($this->pagina_actual - 1);
    }

    //esta funcion retorna el numero de paginaciones que deberia aver dependiendo del total de registros y los registros por pagina, redonde el calculo hacia arriba
    public function total_paginas() {
        return ceil($this->total_registros/$this->registros_por_pagina);
    }

    public function pagina_anterior() {
        $pagina_anterior = $this->pagina_actual - 1;
        return ($pagina_anterior > 0 ) ? $pagina_anterior : false;
    }

    public function pagina_siguiente() {
        $pagina_siguiente = $this->pagina_actual + 1;
        return ($pagina_siguiente <= $this->total_paginas() ) ? $pagina_siguiente : false; //validar que no exista una paginacion despues del limite
    }

    public function enlace_siguiente() {
        $html = '';
        if($this->pagina_siguiente()){
            $html = "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }
    public function enlace_anterior() {
        $html = '';
        if($this->pagina_anterior()){
            $html = "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}\">&laquo; Anterior</a>";
        }
        return $html;
    }

    public function numeros_pagina() {
        $html = '';
        if($this->total_paginas() > 10){
            if($this->pagina_actual > 5){
                //para lso ultimos 10 registros
                $rangoFinal = $this->total_paginas() - 9;
                if( $this->pagina_actual >= $rangoFinal ){
                    for ($i=(int)$rangoFinal; $i <= $this->total_paginas() ; $i++) {
                        if($i === $this->pagina_actual) {
                            $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">${i}</span>";
                        } else {
                            $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page=${i}\">${i}</a>";
                        }
                    }
                } else {
                    //para los registros que son mayores a los primeros 10 y antes de los ultimos 10 registros
                    $rangoMenor = $this->pagina_actual -4;
                    while ($rangoMenor < $this->pagina_actual) {
                        $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page=${rangoMenor}\">${rangoMenor}</a>";
                        $rangoMenor++;
                    }
                    $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero paginacion__enlace--actual\" href=\"?page=$this->pagina_actual\">$this->pagina_actual</a>";
                    $rangoMayor = ($this->total_registros > 9) ?  $this->pagina_actual + 4 : $this->total_registros;
                    $actual = $this->pagina_actual;
                    while ($actual <= $rangoMayor) {
                        $actual++;
                        $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page=${actual}\">${actual}</a>";
                    }
                }
            } else {
                //para los primeros 10 registros cuando son mayores a 11 numeros de pagiancion
                for ($i=1; $i < 11; $i++) {
                    if($i === $this->pagina_actual) {
                        $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">${i}</span>";
                    } else {
                        $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page=${i}\">${i}</a>";
                    }
                }
            }
        } else {
            //cuando son solo 10 o menos numeros de paginaciones
            for ($i=1; $i <= $this->total_paginas(); $i++) {
                if($i === $this->pagina_actual) {
                    $html .= "<span class=\"paginacion__enlace paginacion__enlace--actual\">${i}</span>";
                } else {
                    $html .= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page=${i}\">${i}</a>";
                }
            }
        }
        return $html;
    }

    public function paginacion() {
        $html = '';
        if($this->total_registros > 1){
            $html = '<div class="paginacion">';
            $html .= $this->enlace_anterior();
            $html .= $this->numeros_pagina();
            $html .= $this->enlace_siguiente();
            $html .= '</div>';
        }
        return $html;
    }
}