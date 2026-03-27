<?php
// Recibimos los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Para este ejemplo, validaremos un usuario estático
    if ($email == "admin@clinicalsanctuary.com" && $password == "123456") {
        echo "<h1>¡Bienvenido al Dashboard!</h1>";
        echo "Has ingresado correctamente como: " . htmlspecialchars($email);
    } else {
        echo "<script>alert('Credenciales incorrectas'); window.location.href='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Hospital San Vicente de Paul</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="card">
        <div class="barra-color">
            <div class="logo">
                <h1>Hospital San Vicente de Paul</h1>
            </div>
            <img src="img/favicon.png" width="40">
        </div>

        <div class="form-section">
            <h2>Bienvenido</h2>
            <p class="subtitle">Ingresa tus credenciales para acceder.</p>

            <form action="login.php" method="POST">
                <label>Correo electrónico</label>
                <input type="email" name="email" placeholder="correo@electronico.com" required>

                <div class="password-header">
                    <label>Contraseña</label>
                    <a href="#">¿Olvido su contraseña?</a>
                </div>
                <input type="password" name="password" placeholder="••••••••" required>

                <button type="submit" class="btn-signin">Iniciar sesión</button>
            </form>

            <div class="divider"><span></span></div>

            <p class="signup-text">¿No tienes cuenta?<a href="registro.php"> Regístrate</a></p>
        </div>
    </div>
</div>

</body>
</html>