<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= APP_NAME ?></h1>
        </header>
        
        <main class="landing">
            <div class="hero">
                <h2>Monitoreo de Estaciones Meteorológicas</h2>
                <p>Accede a datos en tiempo real de estaciones meteorológicas distribuidas en diferentes ubicaciones. Consulta temperatura, humedad y otros parámetros climáticos.</p>
                
                <div class="features">
                    <div class="feature">
                        <h3>🌡️ Datos en Tiempo Real</h3>
                        <p>Información actualizada de temperatura y humedad</p>
                    </div>
                    <div class="feature">
                        <h3>📍 Múltiples Ubicaciones</h3>
                        <p>Estaciones distribuidas en diferentes zonas</p>
                    </div>
                    <div class="feature">
                        <h3>📊 Estadísticas</h3>
                        <p>Historial y análisis de datos meteorológicos</p>
                    </div>
                </div>
                
                <a href="panel" class="btn-primary">Ver Panel de Estaciones</a>
            </div>
        </main>
    </div>
</body>
</html>