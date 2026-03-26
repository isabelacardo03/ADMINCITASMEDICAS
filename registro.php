<?php
// 1. CONFIGURACIÓN DE LA BASE DE DATOS (Comentado para el futuro)
/*
$host = "localhost";
$user = "root";
$pass = "";
$db   = "hospital_db";

$conexion = mysqli_connect($host, $user, $pass, $db);
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $pass     = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    // Validación básica
    if ($pass !== $confirm) {
        echo "<script>alert('Las contraseñas no coinciden'); window.history.back();</script>";
        exit;
    }

    // 2. LÓGICA DE INSERCIÓN (Lo que harías cuando tengas DB)
    /*
    $password_encriptada = password_hash($pass, PASSWORD_DEFAULT);
    $query = "INSERT INTO usuarios (nombre, email, password) VALUES ('$fullname', '$email', '$password_encriptada')";
    $resultado = mysqli_query($conexion, $query);
    
    if($resultado) {
        header("Location: index.php?registro=exito");
    }
    */

    // Por ahora, solo simulamos el éxito:
    echo "<h1>Registro recibido (Modo Amateur)</h1>";
    echo "Nombre: " . htmlspecialchars($fullname) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "<p>Próximo paso: Conectar estos datos a MySQL.</p>";
    echo "<a href='index.php'>Volver al Login</a>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Hospital San Vicente de Paul</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="registro.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="main-container">
    <div class="login-card">
        <div class="sidebar register-bg">
            <div class="logo">
                <img src="https://cdn-icons-png.flaticon.com/512/3063/3063176.png" width="30" style="filter: brightness(0) invert(1);"> 
                <span>Hospital San Vicente de Paul</span>
            </div>
            <div class="sidebar-content">
                <h1>Tu camino hacia el bienestar comienza en la tranquilidad.</h1>
                <p>Únase a nuestra comunidad de atención médica de precisión y experimente la serenidad del santuario.</p>
            </div>
        </div>

        <div class="form-section">
            <h2>Crear cuenta</h2>
            <p class="subtitle">Ingresa las credenciales para continuar.</p>

            <form action="procesar_registro.php" method="POST">
                <label>Nombre completo</label>
                    <input type="text" name="fullname" placeholder="Dr. Juan Rojas" required>
                

                <label>Dirección de correo</label>
                <input type="email" name="email" placeholder="juan.rojas@hospital.com" required>

                <div class="row">
                    <div class="col">
                        <label>Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="col">
                        <label>Confirmar contraseña</label>
                        <input type="password" name="confirm_password" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-signin">Crear cuenta &rarr;</button>
            </form>

            <p class="signup-text">¿Ya tienes una cuenta? <a href="login.php">Acceder</a></p>
            
            <div class="footer-form">
                <span>Portal de Atención Médica</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>