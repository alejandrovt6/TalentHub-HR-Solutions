<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/style-index.css">
</head>
<body>
    <div class="login-container">
        <main class="container">
            <form action="./actions/login.php" method="POST" class="login-form">
                <h1>Bienvenido a Talent Hub</h1>
                <h2>Login</h2>
                <div class="form-group">
                    <label for="dni">DNI empleado:</label>
                    <input type="text" id="dni" name="dni" required>
                </div>
                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" required>
                </div>
                <button type="submit">Login</button>
                <a href=""><p>¿Olvidaste la contraseña?</p></a>
            </form>
        </main>
    </div>
</body>
</html>