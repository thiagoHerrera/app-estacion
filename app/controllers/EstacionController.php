<?php
require_once 'app/models/EstacionModel.php';
require_once 'app/utils/Session.php';

class EstacionController {
    private $model;
    
    public function __construct() {
        $this->model = new EstacionModel();
        Session::start();
    }
    
    public function landing() {
        $this->render('landing', [
            'title' => 'App Estación Meteorológica'
        ]);
    }
    
    public function panel() {
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
    
    private function render($view, $data = []) {
        extract($data);
        require_once "app/views/{$view}.php";
    }
}
?>