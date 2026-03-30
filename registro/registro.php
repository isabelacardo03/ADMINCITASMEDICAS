<?php
include '../baseDatos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = mysqli_real_escape_string($conexionBd, $_POST['fullname']);
    $identificacion = mysqli_real_escape_string($conexionBd, $_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($pass !== $confirm_pass) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit();
    }

    $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (identificacion, nombre, contrasena, estado) 
            VALUES ('$identificacion', '$nombre', '$pass_hash', 'activo')";

    if (mysqli_query($conexionBd, $sql)) {
        echo "<script>alert('Registro de usuario exitoso'); window.location.href = '../login/login.html';</script>";
    } else {

        echo "Error al registrar: " . mysqli_error($conexionBd);
    }
}
?>