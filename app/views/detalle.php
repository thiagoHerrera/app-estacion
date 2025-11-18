<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $title ?></h1>
            <a href="panel" class="btn-back">← Volver al Panel</a>
        </header>
        
        <main class="detalle">
            <div id="loading">Cargando datos de la estación...</div>
            <div id="estacion-detalle" class="estacion-info" style="display: none;">
                <div class="estacion-header">
                    <h2 id="apodo"></h2>
                    <p id="ubicacion"></p>
                    <div class="chip-info">
                        <strong>Chip ID:</strong> <span id="chipid"><?= $chipid ?></span>
                    </div>
                    <div class="last-update">
                        <small>Última actualización: <span id="last-update"></span></small>
                    </div>
                </div>
                
                <div class="charts-grid">
                    <div class="chart-container">
                        <h3>🌡️ Temperatura</h3>
                        <canvas id="tempChart"></canvas>
                        <div class="current-value" id="tempValue">--°C</div>
                    </div>
                    
                    <div class="chart-container">
                        <h3>💧 Humedad</h3>
                        <canvas id="humChart"></canvas>
                        <div class="current-value" id="humValue">--%</div>
                    </div>
                    
                    <div class="chart-container">
                        <h3>💨 Viento</h3>
                        <canvas id="windChart"></canvas>
                        <div class="current-value" id="windValue">-- km/h</div>
                    </div>
                    
                    <div class="chart-container">
                        <h3>🌪️ Presión Atmosférica</h3>
                        <canvas id="pressChart"></canvas>
                        <div class="current-value" id="pressValue">-- hPa</div>
                    </div>
                    
                    <div class="chart-container">
                        <h3>🔥 Riesgo de Incendio</h3>
                        <canvas id="fireChart"></canvas>
                        <div class="current-value" id="fireValue">--</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const chipid = '<?= $chipid ?>';
    </script>
    <script src="public/js/detalle.js"></script>
</body>
</html>