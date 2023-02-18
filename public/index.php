<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIEventos;
use Controllers\APIPonentes;
use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\EventosController;
use Controllers\PaginasController;
use Controllers\PonentesController;
use Controllers\RegalosController;
use Controllers\RegistradosController;
use Controllers\RegistroController;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/recuperar', [AuthController::class, 'reestablecer']);
$router->post('/recuperar', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

// Panel de adminstracion
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/ponentes', [PonentesController::class, 'index']);
$router->get('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->post('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->get('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/eliminar', [PonentesController::class, 'eliminar']);

$router->get('/admin/eventos', [EventosController::class, 'index']);
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
// $router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);

$router->get('/api/eventos-horario', [APIEventos::class, 'index']);
$router->get('/api/ponentes', [APIPonentes::class, 'index']);
$router->get('/api/ponente', [APIPonentes::class, 'ponente']);

$router->get('/admin/registrados', [RegistradosController::class, 'index']);
$router->get('/admin/regalos', [RegalosController::class, 'index']);

// area de registro
$router->get('/finalizar-registro', [RegistroController::class, 'registro']);
$router->post('/finalizar-registro/gratis', [RegistroController::class, 'gratis']);
$router->post('/finalizar-registro/pagar', [RegistroController::class, 'pagar']);
$router->get('/finalizar-registro/conferencias', [RegistroController::class, 'conferencias']);
$router->post('/finalizar-registro/conferencias', [RegistroController::class, 'conferencias']);
// boleto virtual
$router->get('/boleto', [RegistroController::class, 'boleto']);

// area publica
$router->get('/', [PaginasController::class, 'index']);
$router->get('/devwebcamp', [PaginasController::class, 'evento']);
$router->get('/paquetes', [PaginasController::class, 'paquetes']);
$router->get('/workshops-conferencias', [PaginasController::class, 'conferencias']);
$router->get('/404', [PaginasController::class, 'error']);

$router->comprobarRutas();

// Para usar paypal como metodo de pago debemos saber que paypal cuenta con un entorno de desarrollo paypal Developer
// SANDBOX.PAYPAL.COM / solo para hacer pruebas de compras pagos etc. con cuentas que se crean para este entorno de desarrollo
// cuentas busness (cuenta que se encarga de resibir pagos administra la app y sus movimientos) y cuentas personales (usuarios que pagan dicho servicio/producto)
// dentro de este entorno podemos crear aplicaciones(solo cunetas busness) y dependiendo de la app podemos gestionar los precios que se le asignaran
// ejemplo cuentas de sanbox:
// busnes
// email: sb-fu5o125064640@business.example.com
// pass: 123123123
// personal
// email: sb-ctqz125064715@personal.example.com
// pass: @4?^aV0&
//
// LIVE / ya no forma parte del testeo enfocado para un entorno de produccion