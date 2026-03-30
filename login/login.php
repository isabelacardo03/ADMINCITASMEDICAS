<?php
include('../baseDatos.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificacion = mysqli_real_escape_string($conexionBd, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE identificacion = '$identificacion' AND estado = 'activo' LIMIT 1";
    $resultado = mysqli_query($conexionBd, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        
        if (password_verify($password, $fila['contrasena'])) {

            $_SESSION['admin_id'] = $fila['id']; 
            $_SESSION['admin_nombre'] = $fila['nombre'];
            $_SESSION['user_rol'] = $fila['rol'];

            header("Location: ../portal/portal.html"); 
            exit(); 
            
        } else {
            header("Location: login.html?error=password");
            exit();
        }
    } else {
        echo "<script>alert('Las contraseñas es incorrecta.'); window.location.href = '../login/login.html';</script>";
        exit();
    }
}
?>