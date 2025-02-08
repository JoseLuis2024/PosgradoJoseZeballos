<?php

$config = require '../config/config.php';  
require '../vendor/autoload.php';

$controller = new \Controller\UsuarioController(new PDO(
    'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], 
    $config['db_user'], 
    $config['db_pass']
));

$controller->mostrarDatosUsuario($_GET['id']);