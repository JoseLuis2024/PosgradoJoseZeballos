<?php

namespace Model;

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrar($nombre, $email, $contraseña) {
        
        $checkSql = "SELECT * FROM usuarios WHERE email = ?";
        $checkStmt = $this->pdo->prepare($checkSql);
        $checkStmt->execute([$email]);
        $exists = $checkStmt->fetchColumn();

        if ($exists) {
            return false;
        }else{

            $sql = "INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$nombre, $email, password_hash($contraseña, PASSWORD_DEFAULT)]);

            return true;
        }
    }

    

    public function verificarUsuario($email, $contraseña) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            return $usuario;
        }
        return false;
    }

    public function obtenerTodos()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function actualizar($id, $nombre, $email, $contraseña = null)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);

        if ($stmt->fetch()) {
            return false;
        }   

        if ($contraseña) {
            $stmt = $this->pdo->prepare("UPDATE usuarios SET nombre = ?, email = ?, contraseña = ? WHERE id = ?");
            return $stmt->execute([$nombre, $email, password_hash($contraseña, PASSWORD_DEFAULT), $id]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
            return $stmt->execute([$nombre, $email, $id]);
        }
    }

    public function emailEnUso($email, $id)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        return $stmt->fetch() ? true : false;
    }



    public function eliminar($id) {
        
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return true;
    }
    public function obtenerPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
}
