<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        //leer el url, dependiendo del url le unimos el layout
        $url_actual = $_SERVER['PATH_INFO'] ?? '/';

        if(str_contains($url_actual, '/admin')){
            //quiere decir que en la url se encuentra un '/admin' por lo tanto la autenticacion dice que es admin
            include_once __DIR__ . '/views/admin-layout.php';
        } else{
            //flujo normal, le mostramos el layout con header y footer publicos
            include_once __DIR__ . '/views/layout.php';
        }

    }
}