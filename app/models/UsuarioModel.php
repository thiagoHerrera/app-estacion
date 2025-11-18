<?php
require_once 'app/config/Database.php';

class UsuarioModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function crearUsuario($email, $nombres, $password) {
        $token = bin2hex(random_bytes(32));
        $token_action = bin2hex(random_bytes(32));
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO usuarios (token, email, nombres, contraseña, token_action) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$token, $email, $nombres, $password_hash, $token_action]);
    }
    
    public function obtenerPorEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorToken($token) {
        $sql = "SELECT * FROM usuarios WHERE token = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorTokenAction($token_action) {
        $sql = "SELECT * FROM usuarios WHERE token_action = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$token_action]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function activarUsuario($token_action) {
        $sql = "UPDATE usuarios SET activo = 1, token_action = NULL, active_date = NOW() WHERE token_action = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$token_action]);
    }
    
    public function bloquearUsuario($token) {
        $token_action = bin2hex(random_bytes(32));
        $sql = "UPDATE usuarios SET bloqueado = 1, token_action = ?, blocked_date = NOW() WHERE token = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$token_action, $token]);
    }
    
    public function iniciarRecupero($email) {
        $token_action = bin2hex(random_bytes(32));
        $sql = "UPDATE usuarios SET recupero = 1, token_action = ?, recover_date = NOW() WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$token_action, $email]);
    }
    
    public function resetPassword($token_action, $new_password) {
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET contraseña = ?, token_action = NULL, recupero = 0, bloqueado = 0 WHERE token_action = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$password_hash, $token_action]);
    }
}
?>