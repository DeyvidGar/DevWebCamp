<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;
use Model\EventoRegistro;
use Model\Regalo;

class RegistroController {
    public static function registro(Router $router) {
        if(!isAuth()) redireccionarAuth();

        // verificar si el usuario esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if(isset($registro) && $registro->paquete_id === '3')
            header('Location: /boleto?id='.urlencode($registro->token));

        $router->render('registro/index', [
            'titulo' => 'Finalizar registro'
        ]);
    }
    public static function gratis() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!isAuth()) redireccionarAuth();

            // verificar si el usuario esta registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(isset($registro) && $registro->paquete_id === '3')
                header('Location: /boleto?id='.urlencode($registro->token));

            $token = substr( md5(uniqid( rand(), true) ), 0, 8);
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id'],
            ];

            $registro = new Registro($datos);
            $resul = $registro->guardar();
            if($resul) header('Location: /boleto?id='.urlencode($registro->token));
        }
    }
    public static function boleto(Router $router) {
        $token = $_GET['id'];
        if(!$token || !strlen($token) === 8) header('Location: /');

        $registro = Registro::where('token', $token);
        if(!$registro) header('Location: /');

        // concatenar datos de con id de referencia
        $registro->paquete = Paquete::find($registro->paquete_id);
        $registro->usuario = Usuario::find($registro->usuario_id);

        $router->render('registro/boleto', [
            'titulo' => 'Registro exitoso',
            'registro' => $registro
        ]);
    }
    public static function pagar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!isAuth()) redireccionarAuth();
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }

            $datos = $_POST;
            $datos['token'] = substr( md5(uniqid( rand(), true) ), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];

            try {
                $registro = new Registro($datos);
                $resul = $registro->guardar();
                echo json_encode($resul);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error '.$th
                ]);
            }
        }
    }
    public static function conferencias(Router $router) {
        if(!isAuth()) redireccionarAuth();
        // validar que el usuario tenga el plan presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);
        if($registro->paquete_id !== '1' || !$registro) header('Location: /');

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

        $regalos = Regalo::all('ASC');

        // manejando el registro mediante POST
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!isAuth()) redireccionarAuth();

            $eventos = explode(',', $_POST['evento_id']);
            if(empty($eventos)){
                echo json_encode([
                    'resultado' => false
                ]);
                return;
            }

            // obtener el registro del usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(!isset($registro) || $registro->paquete_id !== '1'){
                echo json_encode([
                    'resultado' => false
                ]);
                return;
            }

            //este arreglo nos permite guardar en memoria los eventos disponibles en caso de no estar disponible algun evento el return detiene todo el codigo en php
            $eventos_array = [];
            foreach ($eventos as $evento_id) {
                $evento = Evento::find($evento_id);
                //encaso de entrar en esta condicion el proceso no continua por lo tando el usuario debe cambiar de evento que no este disponible
                if(!$evento || $evento->disponibles === '0'){
                    echo json_encode([
                        'resultado' => false
                    ]);
                    return;
                }
                //encaso de validar todos los eventos que selecciono el usuario los guardamos en el espacio en memoria para guardar los id
                $eventos_array[] = $evento;
            }
            foreach($eventos_array as $evento){
                $evento->disponibles -= 1;
                $evento->guardar();
                $datos = [
                    'evento_id' => $evento->id,
                    'registro_id' => $registro->id
                ];
                $registro_evento = new EventoRegistro($datos);
                $registro_evento->guardar();
            }
            //sincronizamos el objeto de registro y solo actulizamos la columna de regalo
            $registro->sincronizar([ 'regalo_id' => $_POST['regalo_id'] ]);
            $resul = $registro->guardar();
            if($resul){
                echo json_encode([
                    'resultado' => $resul
                ]);
            }
            return; // para evitar que en consola>red nos muestre el render en preview
        }

        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshop y conferencias',
            'eventos' => $evento_agrupar,
            'regalos' => $regalos
        ]);
    }
}