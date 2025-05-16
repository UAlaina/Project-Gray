<?php
ini_set('session.cookie_path', '/');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = isset($_GET['controller']) ? $_GET['controller'] : "default";

if ($controller === 'payment') {
    $controller = 'patient';
}

$controllerClassName = ucfirst($controller) . "Controller";

include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();
?>
