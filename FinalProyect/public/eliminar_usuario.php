<?php
require '../vendor/autoload.php';
$config = require '../config/config.php';

$controller = new \Controller\UsuarioController(new PDO(
    'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], 
    $config['db_user'], 
    $config['db_pass']
));


$valid = $controller->eliminarUsuario($_GET['id']);

if ($valid) {
    echo "<script>
        alert('Usuario eliminado exitosamente.');
        window.location.href='lista_usuarios.php';
    </script>";
} else {
    echo "<script>
        alert('Error al eliminar el usuario.');
        window.location.href='lista_usuarios.php';
    </script>";
}