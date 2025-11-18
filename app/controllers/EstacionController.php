<?php
require_once 'app/models/EstacionModel.php';

class EstacionController {
    private $model;
    
    public function __construct() {
        $this->model = new EstacionModel();
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
        $this->render('detalle', [
            'title' => 'Detalle de Estación',
            'chipid' => $chipid
        ]);
    }
    
    private function render($view, $data = []) {
        extract($data);
        require_once "app/views/{$view}.php";
    }
}
?>