<?php
require_once 'app/models/EstacionModel.php';
require_once 'app/models/TrackerModel.php';
require_once 'app/utils/Session.php';

class EstacionController {
    private $model;
    private $trackerModel;
    
    public function __construct() {
        $this->model = new EstacionModel();
        $this->trackerModel = new TrackerModel();
        Session::start();
    }
    
    public function landing() {
        $this->render('landing', [
            'title' => 'App Estación Meteorológica'
        ]);
    }
    
    public function panel() {
        // Registrar acceso del cliente
        $this->registrarAccesoCliente();
        
        $this->render('panel', [
            'title' => 'Panel de Estaciones'
        ]);
    }
    
    public function detalle($chipid) {
        if (!Session::isLoggedIn()) {
            header('Location: login');
            exit;
        }
        
        $this->render('detalle', [
            'title' => 'Detalle de Estación',
            'chipid' => $chipid,
            'user' => Session::getUser()
        ]);
    }
    
    private function registrarAccesoCliente() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        // Extraer información del navegador y sistema
        $navegador = $this->extraerNavegador($userAgent);
        $sistema = $this->extraerSistema($userAgent);
        
        $this->trackerModel->registrarAcceso($ip, $navegador, $sistema);
    }
    
    private function extraerNavegador($userAgent) {
        if (strpos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (strpos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (strpos($userAgent, 'Safari') !== false) return 'Safari';
        if (strpos($userAgent, 'Edge') !== false) return 'Edge';
        return 'Desconocido';
    }
    
    private function extraerSistema($userAgent) {
        if (strpos($userAgent, 'Windows') !== false) return 'Windows';
        if (strpos($userAgent, 'Mac') !== false) return 'macOS';
        if (strpos($userAgent, 'Linux') !== false) return 'Linux';
        if (strpos($userAgent, 'Android') !== false) return 'Android';
        if (strpos($userAgent, 'iOS') !== false) return 'iOS';
        return 'Desconocido';
    }
    
    private function render($view, $data = []) {
        extract($data);
        require_once "app/views/{$view}.php";
    }
}
?>