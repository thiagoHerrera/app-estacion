<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - App Estación</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <h1><?= $title ?></h1>
            <div class="message"><?= $message ?></div>
            <div class="auth-links">
                <a href="login">Volver al login</a>
            </div>
        </div>
    </div>
</body>
</html>