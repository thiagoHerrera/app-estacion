<?php
require_once 'app/models/UsuarioModel.php';
require_once 'app/utils/Mailer.php';
require_once 'app/utils/Session.php';

class AuthController {
    private $usuarioModel;
    private $mailer;
    
    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        $this->mailer = new Mailer();
        Session::start();
    }
    
    public function login() {
        if (Session::isLoggedIn()) {
            header('Location: panel');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $usuario = $this->usuarioModel->obtenerPorEmail($email);
            
            if (!$usuario) {
                $error = "Credenciales no válidas";
            } elseif (!password_verify($password, $usuario['contraseña'])) {
                $this->mailer->enviarIntentoAcceso($usuario, $this->getClientInfo());
                $error = "Credenciales no válidas";
            } elseif (!$usuario['activo']) {
                $error = "Su usuario aún no se ha validado, revise su casilla de correo";
            } elseif ($usuario['bloqueado'] || $usuario['recupero']) {
                $error = "Su usuario está bloqueado, revise su casilla de correo";
            } else {
                Session::login($usuario);
                $this->mailer->enviarNotificacionLogin($usuario, $this->getClientInfo());
                header('Location: panel');
                exit;
            }
        }
        
        $this->render('login', ['error' => $error ?? null]);
    }
    
    public function register() {
        if (Session::isLoggedIn()) {
            header('Location: panel');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $nombres = $_POST['nombres'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if ($password !== $confirm_password) {
                $error = "Las contraseñas no coinciden";
            } elseif ($this->usuarioModel->obtenerPorEmail($email)) {
                $error = "El email ya está registrado. <a href='login'>Iniciar sesión</a>";
            } else {
                if ($this->usuarioModel->crearUsuario($email, $nombres, $password)) {
                    $usuario = $this->usuarioModel->obtenerPorEmail($email);
                    $this->mailer->enviarActivacion($usuario);
                    $success = "Usuario registrado. Revise su correo para activar la cuenta.";
                } else {
                    $error = "Error al registrar usuario";
                }
            }
        }
        
        $this->render('register', [
            'error' => $error ?? null,
            'success' => $success ?? null
        ]);
    }
    
    public function validate($token_action) {
        if (Session::isLoggedIn()) {
            header('Location: panel');
            exit;
        }
        
        $usuario = $this->usuarioModel->obtenerPorTokenAction($token_action);
        
        if ($usuario && !$usuario['activo']) {
            $this->usuarioModel->activarUsuario($token_action);
            $this->mailer->enviarConfirmacionActivacion($usuario);
            header('Location: login?activated=1');
            exit;
        }
        
        $this->render('message', [
            'title' => 'Error',
            'message' => 'El token no corresponde a un usuario'
        ]);
    }
    
    public function blocked($token) {
        $usuario = $this->usuarioModel->obtenerPorToken($token);
        
        if ($usuario) {
            $this->usuarioModel->bloquearUsuario($token);
            $usuario = $this->usuarioModel->obtenerPorToken($token);
            $this->mailer->enviarNotificacionBloqueo($usuario);
            
            $this->render('message', [
                'title' => 'Usuario bloqueado',
                'message' => 'Usuario bloqueado, revise su correo electrónico'
            ]);
        } else {
            $this->render('message', [
                'title' => 'Error',
                'message' => 'El token no corresponde a un usuario'
            ]);
        }
    }
    
    public function recovery() {
        if (Session::isLoggedIn()) {
            header('Location: panel');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $usuario = $this->usuarioModel->obtenerPorEmail($email);
            
            if ($usuario) {
                $this->usuarioModel->iniciarRecupero($email);
                $usuario = $this->usuarioModel->obtenerPorEmail($email);
                $this->mailer->enviarRecuperacion($usuario);
                $success = "Se envió un correo para restablecer la contraseña";
            } else {
                $error = "El email no se encuentra registrado. <a href='register'>Registrarse</a>";
            }
        }
        
        $this->render('recovery', [
            'error' => $error ?? null,
            'success' => $success ?? null
        ]);
    }
    
    public function reset($token_action) {
        if (Session::isLoggedIn()) {
            header('Location: panel');
            exit;
        }
        
        $usuario = $this->usuarioModel->obtenerPorTokenAction($token_action);
        
        if (!$usuario) {
            $this->render('message', [
                'title' => 'Error',
                'message' => 'Token no válido'
            ]);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            if ($password !== $confirm_password) {
                $error = "Las contraseñas no coinciden";
            } else {
                $this->usuarioModel->resetPassword($token_action, $password);
                $this->mailer->enviarConfirmacionReset($usuario, $this->getClientInfo());
                header('Location: login?reset=1');
                exit;
            }
        }
        
        $this->render('reset', [
            'error' => $error ?? null,
            'token_action' => $token_action
        ]);
    }
    
    public function logout() {
        Session::logout();
        header('Location: login');
        exit;
    }
    
    private function getClientInfo() {
        return [
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ];
    }
    
    private function render($view, $data = []) {
        extract($data);
        require_once "app/views/auth/{$view}.php";
    }
}
?>