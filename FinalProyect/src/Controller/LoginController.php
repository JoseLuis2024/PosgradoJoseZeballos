<?php

namespace Controller;

use Model\Usuario;

class LoginController {
    private $pdo;
    private $usuarioModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->usuarioModel = new Usuario($pdo);
    }

    public function mostrarLogin() {
        include '../src/view/login.view.php';
    }

    public function mostrarSign(){
        include '../src/View/sign_in.view.php';
    }
    public function mostrarListaUsuarios(){
        include '../src/View/lista_usuarios.view.php';
        echo $this->crearListaUsuarios();
        echo "</body>
            </html>";
    }
    public function crearListaUsuarios(){
        $usuarios= $this->usuarioModel->obtenerTodos();
        echo "<table border='1'>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha/Hora de registro</th>
                    <th>Acciones</th>
                </tr>";
                foreach($usuarios as $usuario){
                    echo "<tr>
                            <td>".$usuario['id']."</td> 
                            <td>".$usuario['nombre']."</td>
                            <td>".$usuario['email']."</td>
                            <td>".$usuario['creado']."</td>
                            <td>
                                <a href='editar_usuario.php?id=".$usuario['id']."'>Editar</a>
                                <a href='eliminar_usuario.php?id=".$usuario['id']."'>Eliminar</a>
                            </td>
                        </tr>";
                }
    }

    public function login($email, $contraseña) {
        $usuario = $this->usuarioModel->verificarUsuario($email, $contraseña);
        
        if ($usuario) {
            session_start();
            $_SESSION['usuario'] = $usuario['id'];
            header('Location: lista_usuarios.php');
        } else {
            echo "Usuario o contraseña incorrectos.";
        }
    }

    public function registrar($nombre,$email, $contraseña) {
        $valid=$this->usuarioModel->registrar($nombre, $email, $contraseña);
        if($valid){
            echo "<script>alert('Usuario registrado exitosamente.');
                    window.location.href='lista_usuarios.php';
                </script>";
    
        }else{
            echo "<script>alert('El correo ya está registrado, intente con otro correo.');
                    window.location.href='register.php';
                </script>";
        };
    }
    
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /index.php');
    }
    
}
