<?php
include('../baseDatos.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexionBd, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM administrador WHERE idAdministrador = '$email' AND estado = 'activo'";
    $resultado = mysqli_query($conexionBd, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        
        if (password_verify($password, $fila['contrasena'])) {
            $_SESSION['admin_id'] = $fila['id'];
            $_SESSION['admin_nombre'] = $fila['nombre'];

            header("Location: ../portal/portal.html"); 
            exit(); 
            
        } else {
            header("Location: ../login/login.html?error=password");
            exit();
        }
    } else {
        header("Location: login.html?error=user");
        exit();
    }
}
?>