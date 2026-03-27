<?php
include('../baseDatos.php'); // Asegúrate que aquí esté $conexionBd
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Limpiamos los datos de entrada
    // Si el usuario ingresa su cédula/ID en el campo "email" del formulario:
    $identificacion = mysqli_real_escape_string($conexionBd, $_POST['email']);
    $password = $_POST['password'];

    // 2. Consulta a la tabla 'usuario'
    $sql = "SELECT * FROM usuario WHERE identificacion = '$identificacion' AND estado = 'activo' LIMIT 1";
    $resultado = mysqli_query($conexionBd, $sql);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        
        // 3. Verificamos la contraseña (asumiendo que usaste password_hash al registrar)
        if (password_verify($password, $fila['contrasena'])) {
            
            // 4. Creamos las variables de sesión con los datos de la tabla usuario
            $_SESSION['admin_id'] = $fila['id']; 
            $_SESSION['admin_nombre'] = $fila['nombre'];
            $_SESSION['user_rol'] = $fila['rol']; // Opcional: por si tienes roles

            // 5. Redirección al portal exitosa
            header("Location: ../portal/portal.html"); 
            exit(); 
            
        } else {
            // Contraseña incorrecta
            header("Location: login.html?error=password");
            exit();
        }
    } else {
        // Usuario no encontrado o inactivo
        header("Location: login.html?error=user");
        exit();
    }
}
?>