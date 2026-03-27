<?php
include '../baseDatos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = mysqli_real_escape_string($conexion, $_POST['fullname']);
    $email  = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass   = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($pass !== $confirm_pass) {
        die("Las contraseñas no coinciden.");
    }

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO administrador (idAdministrador, nombre, contrasena, estado) 
            VALUES ('$email', '$nombre', '$pass_hash', 'activo')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('Registro exitoso'); window.location.href = 'index.html';</script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

