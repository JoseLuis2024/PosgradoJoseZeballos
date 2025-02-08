<?php
require '../vendor/autoload.php';
$config = require '../config/config.php';

$controller = new \Controller\UsuarioController(new PDO(
    'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'], 
    $config['db_user'], 
    $config['db_pass']
));

if (isset($_POST['contraseñaNew']) && !empty($_POST['contraseñaNew'])) {
    // Verificamos si se ha ingresado la contraseña actual
    if (!isset($_POST['contraseñaOld']) || empty($_POST['contraseñaOld'])) {
        echo "<script>alert('Por favor, ingrese la contraseña actual.');
        window.location.href='lista_usuarios.php';</script>";
        return;
    }

    // Obtener el usuario de la base de datos
    $usuario = $controller->usuarioModel->obtenerPorId($_POST['id']);
    
    // Verifica si existe el usuario (en caso de que no se encuentre en la base de datos)
    if (!$usuario) {
        echo "<script>alert('Usuario no encontrado.');
        window.location.href='lista_usuarios.php';</script>";
        return;
    }

    // El usuario recuperado es un array, acceder correctamente a la contraseña
    $usuario = $usuario[0];  // Asumimos que obtenerPorId devuelve un array con un solo usuario

    // Comprobar si la contraseña actual coincide
    if (password_verify($_POST['contraseñaOld'], $usuario['contraseña'])) {
        // Actualizar usuario con nueva contraseña
        $controller->actualizarUsuario($_POST['id'], $_POST['nombre'], $_POST['email'], $_POST['contraseñaNew']);
        echo "<script>alert('Contraseña actualizada correctamente.');
        window.location.href='lista_usuarios.php';</script>";
    } else {
        echo "<script>alert('La contraseña actual es incorrecta.');
        window.location.href='lista_usuarios.php';</script>";
    }
} else {
    // Si no se está intentando actualizar la contraseña, solo actualizamos el nombre y el email
    $controller->actualizarUsuario($_POST['id'], $_POST['nombre'], $_POST['email']);
    echo "<script>alert('Datos actualizados correctamente.');
    window.location.href='lista_usuarios.php';</script>";
}
