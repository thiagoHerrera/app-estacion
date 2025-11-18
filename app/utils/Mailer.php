<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once 'vendor/autoload.php';

class Mailer {
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->configurar();
    }
    
    private function configurar() {
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'tu-email@gmail.com'; // Cambiar por tu email
        $this->mail->Password = 'tu-app-password'; // Cambiar por tu app password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = 587;
        $this->mail->setFrom('tu-email@gmail.com', 'App Estación');
        $this->mail->isHTML(true);
    }
    
    public function enviarActivacion($usuario) {
        $this->mail->addAddress($usuario['email'], $usuario['nombres']);
        $this->mail->Subject = 'Activar cuenta - App Estación';
        
        $activateUrl = BASE_URL . "validate/" . $usuario['token_action'];
        
        $this->mail->Body = "
            <h2>¡Bienvenido a App Estación!</h2>
            <p>Hola {$usuario['nombres']},</p>
            <p>Gracias por registrarte. Para activar tu cuenta, haz clic en el siguiente botón:</p>
            <a href='{$activateUrl}' style='background: #667eea; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                Click aquí para activar tu usuario
            </a>
        ";
        
        $this->mail->send();
        $this->mail->clearAddresses();
    }
    
    public function enviarNotificacionLogin($usuario, $clientInfo) {
        $this->mail->addAddress($usuario['email'], $usuario['nombres']);
        $this->mail->Subject = 'Inicio de sesión - App Estación';
        
        $blockUrl = BASE_URL . "blocked/" . $usuario['token'];
        
        $this->mail->Body = "
            <h2>Inicio de sesión detectado</h2>
            <p>Hola {$usuario['nombres']},</p>
            <p>Se ha iniciado sesión en tu cuenta desde:</p>
            <ul>
                <li>IP: {$clientInfo['ip']}</li>
                <li>Navegador: {$clientInfo['user_agent']}</li>
            </ul>
            <p>Si no fuiste tú, haz clic en el botón:</p>
            <a href='{$blockUrl}' style='background: #ff6b6b; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                No fui yo, bloquear cuenta
            </a>
        ";
        
        $this->mail->send();
        $this->mail->clearAddresses();
    }
    
    public function enviarIntentoAcceso($usuario, $clientInfo) {
        $this->mail->addAddress($usuario['email'], $usuario['nombres']);
        $this->mail->Subject = 'Intento de acceso fallido - App Estación';
        
        $blockUrl = BASE_URL . "blocked/" . $usuario['token'];
        
        $this->mail->Body = "
            <h2>Intento de acceso con contraseña inválida</h2>
            <p>Hola {$usuario['nombres']},</p>
            <p>Se detectó un intento de acceso con contraseña incorrecta desde:</p>
            <ul>
                <li>IP: {$clientInfo['ip']}</li>
                <li>Navegador: {$clientInfo['user_agent']}</li>
            </ul>
            <p>Si no fuiste tú, haz clic en el botón:</p>
            <a href='{$blockUrl}' style='background: #ff6b6b; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                No fui yo, bloquear cuenta
            </a>
        ";
        
        $this->mail->send();
        $this->mail->clearAddresses();
    }
    
    public function enviarConfirmacionActivacion($usuario) {
        $this->mail->addAddress($usuario['email'], $usuario['nombres']);
        $this->mail->Subject = 'Cuenta activada - App Estación';
        
        $this->mail->Body = "
            <h2>¡Cuenta activada exitosamente!</h2>
            <p>Hola {$usuario['nombres']},</p>
            <p>Tu cuenta ha sido activada correctamente. Ya puedes iniciar sesión en App Estación.</p>
        ";
        
        $this->mail->send();
        $this->mail->clearAddresses();
    }
    
    public function enviarNotificacionBloqueo($usuario) {
        $this->mail->addAddress($usuario['email'], $usuario['nombres']);
        $this->mail->Subject = 'Cuenta bloqueada - App Estación';
        
        $resetUrl = BASE_URL . "reset/" . $usuario['token_action'];
        
        $this->mail->Body = "
            <h2>Cuenta bloqueada</h2>
            <p>Hola {$usuario['nombres']},</p>
            <p>Tu cuenta ha sido bloqueada por seguridad. Para cambiar tu contraseña:</p>
            <a href='{$resetUrl}' style='background: #667eea; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                Click aquí para cambiar contraseña
            </a>
        ";
        
        $this->mail->send();
        $this->mail->clearAddresses();
    }
    
    public function enviarRecuperacion($usuario) {
        $this->mail->addAddress($usuario['email'], $usuario['nombres']);
        $this->mail->Subject = 'Recuperar contraseña - App Estación';
        
        $resetUrl = BASE_URL . "reset/" . $usuario['token_action'];
        
        $this->mail->Body = "
            <h2>Restablecer contraseña</h2>
            <p>Hola {$usuario['nombres']},</p>
            <p>Se inició el proceso de restablecimiento de contraseña:</p>
            <a href='{$resetUrl}' style='background: #667eea; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                Click aquí para restablecer contraseña
            </a>
        ";
        
        $this->mail->send();
        $this->mail->clearAddresses();
    }
    
    public function enviarConfirmacionReset($usuario, $clientInfo) {
        $this->mail->addAddress($usuario['email'], $usuario['nombres']);
        $this->mail->Subject = 'Contraseña restablecida - App Estación';
        
        $blockUrl = BASE_URL . "blocked/" . $usuario['token'];
        
        $this->mail->Body = "
            <h2>Contraseña restablecida</h2>
            <p>Hola {$usuario['nombres']},</p>
            <p>Tu contraseña ha sido restablecida desde:</p>
            <ul>
                <li>IP: {$clientInfo['ip']}</li>
                <li>Navegador: {$clientInfo['user_agent']}</li>
            </ul>
            <p>Si no fuiste tú, haz clic en el botón:</p>
            <a href='{$blockUrl}' style='background: #ff6b6b; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;'>
                No fui yo, bloquear cuenta
            </a>
        ";
        
        $this->mail->send();
        $this->mail->clearAddresses();
    }
}
?>