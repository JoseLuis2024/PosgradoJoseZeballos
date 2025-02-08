<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sign-in</title>
</head>
<body>
    <h1>Registro</h1>
    <form action="index.php?action=register" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="email" name="email" placeholder="Correo" required><br>
        <input type="password" name="contraseña" placeholder="Contraseña" required><br>
        <button type="submit">Confirmar Registro</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="../public/index.php">Iniciar Sesión</a></p>
</body>
</html>
