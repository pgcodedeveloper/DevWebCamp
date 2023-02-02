<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIEventos;
use Controllers\APIRegalos;
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
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);


//Area de administración
$router->get('/admin/dashboard', [DashboardController::class, 'index']);


//Ponentes
$router->get('/admin/ponentes', [PonentesController::class, 'index']);
$router->get('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->post('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->get('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/eliminar', [PonentesController::class, 'eliminar']);


//Eventos
$router->get('/admin/eventos', [EventosController::class, 'index']);
$router->get('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->post('/admin/eventos/crear', [EventosController::class, 'crear']);
$router->get('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/editar', [EventosController::class, 'editar']);
$router->post('/admin/eventos/eliminar', [EventosController::class, 'eliminar']);


//API
$router->get('/api/eventos-horario',[APIEventos::class,'eventos_horario']);
$router->get('/api/ponentes',[APIEventos::class,'ponentes']);
$router->get('/api/ponente',[APIEventos::class,'ponente']);
$router->get('/api/regalos',[APIRegalos::class,'regalos']);


//Registrados y Regalos
$router->get('/admin/registrados', [RegistradosController::class, 'index']);
$router->get('/admin/regalos', [RegalosController::class, 'index']);


//Registro de usuarios
$router->get('/finalizar-registro',[RegistroController::class, 'crear']);
$router->post('/finalizar-registro/gratis',[RegistroController::class, 'gratis']);
$router->post('/finalizar-registro/pagar',[RegistroController::class, 'pagar']);
$router->get('/finalizar-registro/conferencias',[RegistroController::class, 'conferencias']);
$router->post('/finalizar-registro/conferencias',[RegistroController::class, 'conferencias']);
$router->get('/boleto',[RegistroController::class,'boleto']);


//Area publica
$router->get('/',[PaginasController::class,'index']);
$router->get('/devwebcamp',[PaginasController::class,'evento']);
$router->get('/paquetes',[PaginasController::class,'paquetes']);
$router->get('/workshops',[PaginasController::class,'conferencias']);
$router->get('/workshops/evento',[PaginasController::class,'evento_id']);
$router->get('/404',[PaginasController::class,'error']);


$router->comprobarRutas();