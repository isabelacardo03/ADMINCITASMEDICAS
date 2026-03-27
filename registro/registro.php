<?php
include '../baseDatos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // 1. Recibimos y limpiamos los datos del formulario
    $nombre = mysqli_real_escape_string($conexionBd, $_POST['fullname']);
    // Usamos el campo 'email' del formulario como la 'identificacion' en la BD
    $identificacion = mysqli_real_escape_string($conexionBd, $_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // 2. Validación de contraseñas iguales
    if ($pass !== $confirm_pass) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit();
    }

    // 3. Encriptamos la contraseña (Seguridad)
    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    // 4. Insertamos en la tabla 'usuario'
    // IMPORTANTE: Verifica que los nombres de las columnas (identificacion, nombre, contrasena, estado) 
    // sean idénticos en tu phpMyAdmin.
    $sql = "INSERT INTO usuario (identificacion, nombre, contrasena, estado) 
            VALUES ('$identificacion', '$nombre', '$pass_hash', 'activo')";

    if (mysqli_query($conexionBd, $sql)) {
        echo "<script>alert('Registro de usuario exitoso'); window.location.href = '../login/login.html';</script>";
    } else {
        // Si sale error aquí, probablemente es porque la identificación ya existe
        echo "Error al registrar: " . mysqli_error($conexionBd);
    }
}
?>