<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//mostrar mensaje dependiendo del metodo GET de la pagina
function mostrarMensaje($codigo) : string {
    $mensaje = '';
    switch($codigo){
        case 1:
            $mensaje = 'Registro creado correctamente';
            break;
        case 2:
            $mensaje = 'Registro actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Registro eliminado correctamente';
            break;
        default:
            $mensaje = '';
            break;
    }

    return $mensaje;
}

//esta funcion retorna un true o false si la ubicacion de la pagina actual contiene el valor de la variable path
function pagina_actual($path) : bool {
    return str_contains($_SERVER['PATH_INFO'] ?? '/', $path) ? true : false;;
}

function isAdmin() : bool {
    if(!isset($_SESSION)) session_start();
    return !is_null($_SESSION['admin']) && !empty($_SESSION['admin']);
}
function isAuth() : bool {
    if(!isset($_SESSION)) session_start();
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function redireccionarAuth() : void {
    header('Location: /finalizar-registro');//TODO: DIRECCION DE UN USUARIO AUTENTICADO
}
function redireccionarLogin() : void {
    header('Location: /login');
}

//funcion para imprimir un valor aleatorio
function aos_animation() : void {
    $animaciones = ['fade-up','fade-down','fade-left','fade-right','flip-left','flip-right','zoom-out','zoom-out-up'];
    $animacion = array_rand($animaciones, 1);
    echo ' echo data-aos="'.$animaciones[$animacion].'" ';
}