<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\DashboardController;
$router = new Router();

//Login
$router->get('/', [LoginController::class,'Login']);
$router->post('/', [LoginController::class,'Login']);
$router->get('/logout', [LoginController::class,'Logout']);

//crear usuarios
$router->get('/crear', [LoginController::class,'crear']);
$router->post('/crear', [LoginController::class,'crear']);

//olvide mi password
$router->get('/olvide', [LoginController::class,'olvide']);
$router->post('/olvide', [LoginController::class,'olvide']);

//colocar nuevo password
$router->get('/restablecer', [LoginController::class,'restablecer']);
$router->post('/restablecer', [LoginController::class,'restablecer']);

//confirmar cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar',[LoginController::class, 'confirmar']);

//zona, che que zona ? la ca be zo naaaaa!
//ya aqui van los poryectos
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/crear-proyecto', [DashboardController::class, 'crear']);
$router->post('/crear-proyecto', [DashboardController::class, 'crear']);
$router->get('/proyecto', [DashboardController::class, 'proyecto']);
$router->get('/perfil', [DashboardController::class, 'perfil']);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();