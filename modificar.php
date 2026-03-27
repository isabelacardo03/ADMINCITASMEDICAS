<?php
header("Content-type: application/json");

require __DIR__ . "/baseDatos.php";

$tipo = $_POST["tipo"] ?? "";

if ($tipo === "paciente") {

    // Recibimos todos los campos del formulario
    $identificacion  = trim($_POST["identificacion"] ?? "");
    $tipoDocumento   = trim($_POST["tipoDocumento"] ?? "");
    $nombre          = trim($_POST["nombre"] ?? "");
    $apellido        = trim($_POST["apellido"] ?? "");
    $fechaNacimiento = trim($_POST["fechaNacimiento"] ?? "");
    $direccion       = trim($_POST["direccion"] ?? "");
    $telefono        = trim($_POST["telefono"] ?? "");
    $contrasena      = trim($_POST["contrasena"] ?? "");
    $estado          = trim($_POST["estado"] ?? "");
    $preSeguridad    = trim($_POST["preSeguridad"] ?? "");
    $reSeguridad     = trim($_POST["reSeguridad"] ?? "");

    // Validación básica
    if ($identificacion === "" || $nombre === "" || $apellido === "") {
        echo json_encode(["ok" => false, "mensaje" => "Campos obligatorios vacíos"]);
        exit;
    }

    // Solo actualizamos la contraseña si el usuario escribió una nueva
    // Si no escribió nada, la dejamos como está (no la tocamos)
    if ($contrasena !== "") {
        // El usuario escribió nueva contraseña, la ciframos
        $contrasena = md5($contrasena);

        // UPDATE incluyendo contraseña
        $consulta = mysqli_prepare($conexionBd,
            "UPDATE usuario SET 
                tipoDocumento = ?, 
                nombre = ?, 
                apellido = ?, 
                fechaNacimiento = ?, 
                direccion = ?, 
                telefono = ?, 
                contrasena = ?, 
                estado = ?, 
                preSeguridad = ?, 
                reSeguridad = ? 
            WHERE identificacion = ?"
        );

        // 11 parámetros, todos texto = 11 "s"
        mysqli_stmt_bind_param($consulta, "sssssssssss",
            $tipoDocumento,
            $nombre,
            $apellido,
            $fechaNacimiento,
            $direccion,
            $telefono,
            $contrasena,   // nueva contraseña cifrada
            $estado,
            $preSeguridad,
            $reSeguridad,
            $identificacion
        );

    } else {
        // El usuario NO escribió contraseña, no la tocamos en la BD
        $consulta = mysqli_prepare($conexionBd,
            "UPDATE usuario SET 
                tipoDocumento = ?, 
                nombre = ?, 
                apellido = ?, 
                fechaNacimiento = ?, 
                direccion = ?, 
                telefono = ?, 
                estado = ?, 
                preSeguridad = ?, 
                reSeguridad = ? 
            WHERE identificacion = ?"
        );

        // 10 parámetros = 10 "s"
        mysqli_stmt_bind_param($consulta, "ssssssssss",
            $tipoDocumento,
            $nombre,
            $apellido,
            $fechaNacimiento,
            $direccion,
            $telefono,
            $estado,
            $preSeguridad,
            $reSeguridad,
            $identificacion
        );
    }

    // Ejecutamos la consulta
    $ejecutado = mysqli_stmt_execute($consulta);

    if ($ejecutado) {
        echo json_encode(["ok" => true, "mensaje" => "Paciente actualizado correctamente"]);
    } else {
        echo json_encode(["ok" => false, "mensaje" => "No se pudo actualizar: " . mysqli_error($conexionBd)]);
    }

} else {
    echo json_encode(["ok" => false, "mensaje" => "Tipo no válido"]);
}
?>