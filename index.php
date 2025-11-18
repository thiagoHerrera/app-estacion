<?php
require_once 'env.php';
require_once 'app/controllers/EstacionController.php';

$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = explode('/', $url);

$controller = new EstacionController();

switch ($url[0]) {
    case '':
    case 'landing':
        $controller->landing();
        break;
    case 'panel':
        $controller->panel();
        break;
    case 'detalle':
        $chipid = $url[1] ?? null;
        $controller->detalle($chipid);
        break;
    default:
        $controller->landing();
        break;
}
?>