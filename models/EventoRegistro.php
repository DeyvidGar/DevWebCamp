<?php

namespace Model;
//TABLA PIBOTE M:M DEBIDO A QUE NUESTRA TABLA DE REGISTRO DE USUARIOS Y LA TABLA DE EVENTO DEBEN TENER UNA RELACION USAMOS UNA TABLA PIBOTE
class EventoRegistro extends ActiveRecord {
    protected static $tabla = 'eventos_registros';
    protected static $columnasDB = ['id', 'evento_id', 'registro_id'];

    public $id;
    public $evento_id;
    public $registro_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->evento_id = $args['evento_id'] ?? '';
        $this->registro_id = $args['registro_id'] ?? '';
    }
}