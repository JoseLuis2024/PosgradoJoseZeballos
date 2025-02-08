<?php

namespace Controller;

use Model\Usuario;

class UsuarioController
{
    public $usuarioModel;

    public function __construct($db)
    {
        $this->usuarioModel = new Usuario($db);
    }

    // Listar todos los usuarios

    // Actualizar usuario
    public function actualizarUsuario($id, $nombre, $email, $contraseña = null)
    {
        $resultado = $this->usuarioModel->actualizar($id, $nombre, $email, $contraseña);
    
        if ($resultado) {
            echo "<script>alert('Usuario actualizado exitosamente.');
            window.location.href='lista_usuarios.php';</script>";
        } else {
            // Detectar si el problema es por un email duplicado
            if ($this->usuarioModel->emailEnUso($email, $id)) {
                echo "<script>alert('El correo electrónico ya está registrado por otro usuario. Por favor, intente con otro.');
                window.location.href='lista_usuarios.php';</script>";
            } else {
                echo "<script>alert('Ocurrió un error inesperado al actualizar el usuario. Inténtelo de nuevo más tarde.');
                window.location.href='lista_usuarios.php';</script>";
            }
        }
    }
    

    // Eliminar usuario
    public function eliminarUsuario($id)
    {
        return $this->usuarioModel->eliminar($id);
    }

    public function mostrarDatosUsuario($id)
    {
        include "../src/View/editar_usuario.view.php";
        $usser=$this->usuarioModel->obtenerPorId($id);
        foreach ($usser as $user) {
            echo "<form action='review_dates.php' method='POST'>";
            echo "<input type='text' name='id' value='$user[id]' readonly>";
            echo "<input type='text' name='nombre' value='$user[nombre]'>";
            echo "<input type='text' name='email' value='$user[email]'>";
            echo "<input type='text' name='contraseñaOld' placeholder='contraseña actual'>";
            echo "<input type='text' name='contraseñaNew' placeholder='Nueva contraseña'>";
            echo "<input type='submit' value='Actualizar'>";
            echo "</form>";
        };
        echo "</body></html>";
    }
}
