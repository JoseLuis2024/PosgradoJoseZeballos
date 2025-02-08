<?php
$config = require '../config/config.php';

require '../vendor/autoload.php';
// Instancia el controlador LoginController
$controller = new Controller\LoginController(new PDO(
    'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], 
    $config['db_user'], 
    $config['db_pass']
));

$controller->mostrarSign();

?>
