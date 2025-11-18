<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - App Estación</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <h1>Iniciar Sesión</h1>
            
            <?php if (isset($_GET['activated'])): ?>
                <div class="success">Cuenta activada correctamente. Ya puedes iniciar sesión.</div>
            <?php endif; ?>
            
            <?php if (isset($_GET['reset'])): ?>
                <div class="success">Contraseña restablecida correctamente.</div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary">Acceder</button>
            </form>
            
            <div class="auth-links">
                <a href="recovery">¿Olvidaste tu contraseña?</a>
                <a href="register">¿No tienes una cuenta? Registrarse</a>
            </div>
        </div>
    </div>
</body>
</html>