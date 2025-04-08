<?php

// include_once "Util/cdebug.php";

$controller = (isset($_GET['controller'])) ? $_GET['controller'] : "default";


$controllerClassName = ucfirst($controller) . "Controller";
include_once "Controllers/$controllerClassName.php";

$ct = new $controllerClassName();
$ct->route();
