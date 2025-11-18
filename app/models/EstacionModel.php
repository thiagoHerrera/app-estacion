<?php
class EstacionModel {
    private $apiUrl;
    
    public function __construct() {
        $this->apiUrl = API_URL;
    }
    
    public function getAllEstaciones() {
        // Este método será usado por JavaScript para obtener datos de la API
        return $this->apiUrl . 'api/estaciones';
    }
}
?>