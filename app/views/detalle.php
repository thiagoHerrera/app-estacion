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
            <a href="panel" class="btn-back">← Volver al Panel</a>
        </header>
        
        <main class="detalle">
            <div id="loading">Cargando datos de la estación...</div>
            <div id="estacion-detalle" class="estacion-info" style="display: none;">
                <h2 id="apodo"></h2>
                <p id="ubicacion"></p>
                <div class="chip-info">
                    <strong>Chip ID:</strong> <span id="chipid"><?= $chipid ?></span>
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