<?php
$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "default";
// $action = (isset($_GET['action'])) ? $_GET['action'] : "index";

$controllerClassName = ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
// if (method_exists($ct, $action)) {
//     $ct->$action();
// } else {
//     $ct->index();
// }
$ct->route();
