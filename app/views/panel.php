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
            <h1><?= $title ?></h1>
            <a href="landing" class="btn-back">← Volver</a>
        </header>
        
        <main class="panel">
            <div id="loading">Cargando estaciones...</div>
            <div id="estaciones-list" class="estaciones-grid"></div>
        </main>
    </div>

    <template id="estacion-template">
        <div class="estacion-card" data-chipid="">
            <h3 class="apodo"></h3>
            <p class="ubicacion"></p>
            <span class="visitas">Visitas: <span class="count"></span></span>
        </div>
    </template>

    <script src="public/js/panel.js"></script>
</body>
</html>