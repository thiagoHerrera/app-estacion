<?php
require_once 'app/models/UsuarioModel.php';
require_once 'app/models/TrackerModel.php';
require_once 'app/utils/Session.php';

class AdminController {
    private $usuarioModel;
    private $trackerModel;
    
    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        $this->trackerModel = new TrackerModel();
        Session::start();
    }
    
    public function administrator() {
        if (!$this->isAdminLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';
                
                if ($username === 'admin-estacion' && $password === 'admin1234') {
                    $_SESSION['admin_logged'] = true;
                    header('Location: administrator');
                    exit;
                } else {
                    $error = 'Credenciales incorrectas';
                }
            }
            
            $this->render('admin_login', ['error' => $error ?? null]);
            return;
        }
        
        // Contar usuarios y clientes
        $totalUsuarios = $this->contarUsuarios();
        $totalClientes = $this->trackerModel->contarClientes();
        
        $this->render('administrator', [
            'totalUsuarios' => $totalUsuarios,
            'totalClientes' => $totalClientes
        ]);
    }
    
    public function map() {
        if (!$this->isAdminLoggedIn()) {
            header('Location: panel');
            exit;
        }
        
        $this->render('map', []);
    }
    
    public function logout() {
        unset($_SESSION['admin_logged']);
        header('Location: panel');
        exit;
    }
    
    private function isAdminLoggedIn() {
        return isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;
    }
    
    private function contarUsuarios() {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios";
            $db = Database::getInstance();
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }
    
    private function render($view, $data = []) {
        extract($data);
        require_once "app/views/admin/{$view}.php";
    }
}
?>