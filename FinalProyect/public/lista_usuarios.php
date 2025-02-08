<?php
session_start();
require '../vendor/autoload.php';
$config = require '../config/config.php';

$controller = new \Controller\LoginController(new PDO(
    'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], 
    $config['db_user'], 
    $config['db_pass']
));

$controller->mostrarListaUsuarios();
