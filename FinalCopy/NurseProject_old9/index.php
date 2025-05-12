<?php
// Optional: set session cookie path BEFORE starting the session
ini_set('session.cookie_path', '/');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$controller = isset($_GET['controller']) ? $_GET['controller'] : "default";
$controllerClassName = ucfirst($controller) . "Controller";

include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();
?>
