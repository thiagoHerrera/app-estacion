<?php
class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function login($usuario) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_token'] = $usuario['token'];
        $_SESSION['user_email'] = $usuario['email'];
        $_SESSION['user_nombres'] = $usuario['nombres'];
    }
    
    public static function logout() {
        session_destroy();
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public static function getUser() {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'token' => $_SESSION['user_token'],
                'email' => $_SESSION['user_email'],
                'nombres' => $_SESSION['user_nombres']
            ];
        }
        return null;
    }
}
?>