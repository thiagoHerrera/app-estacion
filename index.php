<?php
require_once 'env.php';
require_once 'app/controllers/EstacionController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/ApiController.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = explode('/', $url);

$estacionController = new EstacionController();
$authController = new AuthController();
$adminController = new AdminController();
$apiController = new ApiController();

switch ($url[0]) {
    case '':
    case 'landing':
        $estacionController->landing();
        break;
    case 'panel':
        $estacionController->panel();
        break;
    case 'detalle':
        $chipid = $url[1] ?? null;
        $estacionController->detalle($chipid);
        break;
    case 'login':
        $authController->login();
        break;
    case 'register':
        $authController->register();
        break;
    case 'validate':
        $token_action = $url[1] ?? null;
        $authController->validate($token_action);
        break;
    case 'blocked':
        $token = $url[1] ?? null;
        $authController->blocked($token);
        break;
    case 'recovery':
        $authController->recovery();
        break;
    case 'reset':
        $token_action = $url[1] ?? null;
        $authController->reset($token_action);
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'administrator':
        $adminController->administrator();
        break;
    case 'map':
        $adminController->map();
        break;
    case 'admin-logout':
        $adminController->logout();
        break;
    case 'api':
        $apiController->handleRequest();
        break;
    default:
        $estacionController->landing();
        break;
}
?>