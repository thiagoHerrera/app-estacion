<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Clientes - App Estación</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        body { margin: 0; padding: 0; }
        #map { height: 100vh; width: 100%; }
        .map-header {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }
        .btn-back {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="map-header">
        <a href="administrator" class="btn-back">Volver</a>
    </div>
    
    <div id="map"></div>
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inicializar mapa
        const map = L.map('map').setView([-34.6037, -58.3816], 2);
        
        // Agregar tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Cargar datos de clientes
        fetch('api?list-clients-location')
            .then(response => response.json())
            .then(data => {
                data.forEach(cliente => {
                    if (cliente.latitud && cliente.longitud) {
                        const marker = L.marker([cliente.latitud, cliente.longitud])
                            .addTo(map);
                        
                        marker.bindPopup(`
                            <b>IP:</b> ${cliente.ip}<br>
                            <b>Accesos:</b> ${cliente.accesos}
                        `);
                    }
                });
            })
            .catch(error => {
                console.error('Error cargando datos:', error);
            });
    </script>
</body>
</html>