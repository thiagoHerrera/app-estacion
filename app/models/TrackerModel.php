<?php
require_once 'app/config/Database.php';

class TrackerModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function registrarAcceso($ip, $navegador, $sistema) {
        $token = bin2hex(random_bytes(16));
        
        // Obtener información de geolocalización
        $geoData = $this->obtenerGeolocalizacion($ip);
        
        $sql = "INSERT INTO tracker (token, ip, latitud, longitud, pais, navegador, sistema) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            $token,
            $ip,
            $geoData['lat'] ?? null,
            $geoData['lon'] ?? null,
            $geoData['country'] ?? null,
            $navegador,
            $sistema
        ]);
    }
    
    public function obtenerClientesUbicacion() {
        $sql = "SELECT ip, latitud, longitud, COUNT(*) as accesos 
                FROM tracker 
                WHERE latitud IS NOT NULL AND longitud IS NOT NULL 
                GROUP BY ip, latitud, longitud";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function contarClientes() {
        $sql = "SELECT COUNT(DISTINCT ip) as total FROM tracker";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    
    private function obtenerGeolocalizacion($ip) {
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return [
                'lat' => '-34.6037',
                'lon' => '-58.3816',
                'country' => 'Argentina'
            ];
        }
        
        try {
            $url = "http://ipwho.is/{$ip}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            
            if ($data && $data['success']) {
                return [
                    'lat' => $data['latitude'],
                    'lon' => $data['longitude'],
                    'country' => $data['country']
                ];
            }
        } catch (Exception $e) {
            // En caso de error, usar coordenadas por defecto
        }
        
        return [
            'lat' => null,
            'lon' => null,
            'country' => null
        ];
    }
}
?>