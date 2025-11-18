<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - App Estación</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Panel Administrador</h1>
            <div class="admin-header">
                <a href="admin-logout" class="btn-logout">Cerrar Sesión</a>
            </div>
        </header>
        
        <main class="admin-panel">
            <div class="admin-actions">
                <a href="map" class="btn-primary admin-btn">Mapa de Clientes</a>
            </div>
            
            <div class="admin-stats">
                <div class="stat-card">
                    <h3>👥 Usuarios Registrados</h3>
                    <div class="stat-number"><?= $totalUsuarios ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>🌍 Clientes Únicos</h3>
                    <div class="stat-number"><?= $totalClientes ?></div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>