<?php
session_start();

$config = require '../config/config.php';  
require '../vendor/autoload.php';

$controller = new \Controller\LoginController(new PDO(
    'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], 
    $config['db_user'], 
    $config['db_pass']
));

if (isset($_GET['action']) && $_GET['action'] == 'login') {
    $controller->login($_POST['email'], $_POST['contraseña']);
} else if(isset($_GET['action']) && $_GET['action'] == 'register'){
    $controller->registrar($_POST['nombre'], $_POST['email'], $_POST['contraseña']);
} else {
    $controller->mostrarLogin();
}
