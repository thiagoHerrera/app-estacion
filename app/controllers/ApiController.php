<?php
require_once 'app/models/TrackerModel.php';

class ApiController {
    private $trackerModel;
    
    public function __construct() {
        $this->trackerModel = new TrackerModel();
    }
    
    public function handleRequest() {
        header('Content-Type: application/json');
        
        if (isset($_GET['list-clients-location'])) {
            $this->listClientsLocation();
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
        }
    }
    
    private function listClientsLocation() {
        try {
            $clientes = $this->trackerModel->obtenerClientesUbicacion();
            echo json_encode($clientes);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }
}
?>