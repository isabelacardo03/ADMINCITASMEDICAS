<?php
header("Content-type: application/json");

require __DIR__ . "/baseDatos.php";

$tipo = $_POST["tipo"] ?? ""; 

if ($tipo === "") {
    echo json_encode(["ok" => false, "mensaje" => "Tipo no definido"]);
    exit;
}

if ($tipo === "paciente") {

    $identificacion = trim($_POST["identificacion"] ?? "");
    $tipoDocumento  = trim($_POST["tipoDocumento"] ?? "");
    $nombre         = trim($_POST["nombre"] ?? "");
    $apellido       = trim($_POST["apellido"] ?? "");
    $fechaNacimiento= trim($_POST["fechaNacimiento"] ?? "");
    $direccion      = trim($_POST["direccion"] ?? "");
    $telefono       = trim($_POST["telefono"] ?? "");
    $contrasena     = trim($_POST["contrasena"] ?? "");
    $estado         = trim($_POST["estado"] ?? "");
    $preSeguridad   = trim($_POST["preSeguridad"] ?? "");
    $reSeguridad    = trim($_POST["reSeguridad"] ?? "");

if ($identificacion === "" || $nombre === "" || $apellido === "" || $contrasena === "") {
        echo json_encode(["ok" => false, "mensaje" => "Campos obligatorios vacíos"]);
        exit;
    }

    $contrasena = md5($contrasena);

    $modo = $_POST["modo"] ?? ""; 
     if ($modo === "editar") {

        $consulta = mysqli_prepare($conexionBd,
        "UPDATE usuario SET 
            tipoDocumento=?, 
            nombre=?, 
            apellido=?, 
            fechaNacimiento=?, 
            direccion=?, 
            telefono=?, 
            contrasena=?, 
            estado=?, 
            preSeguridad=?, 
            reSeguridad=? 
        WHERE identificacion=?");

        mysqli_stmt_bind_param($consulta, "sssssssssss",
            $tipoDocumento,
            $nombre,
            $apellido,
            $fechaNacimiento,
            $direccion,
            $telefono,
            $contrasena,
            $estado,
            $preSeguridad,
            $reSeguridad,
            $identificacion
        );

        mysqli_stmt_execute($consulta);

        echo json_encode(["ok" => true, "mensaje" => "Paciente actualizado correctamente"]);
        exit;
     }

     try {
        $consulta = mysqli_prepare($conexionBd, 
        "INSERT INTO usuario 
        (identificacion, tipoDocumento, nombre, apellido, fechaNacimiento, direccion, telefono, contrasena, estado, preSeguridad, reSeguridad) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param($consulta, "sssssssssss",
            $identificacion,
            $tipoDocumento,
            $nombre,
            $apellido,
            $fechaNacimiento,
            $direccion,
            $telefono,
            $contrasena,
            $estado,
            $preSeguridad,
            $reSeguridad
        );

        mysqli_stmt_execute($consulta);
        mysqli_stmt_close($consulta);

        echo json_encode(["ok" => true, "mensaje" => "Paciente guardado correctamente"]);

    } catch (mysqli_stmt_exeption $error) {
        echo json_encode(["ok" => false, "mensaje" => "Error: " . $error->getMessage()]);
    }
}

if ($tipo === "medico") {

    $idMedico   = trim($_POST["idMedico"] ?? "");
    $nombre     = trim($_POST["nombre"] ?? "");
    $apellido   = trim($_POST["apellido"] ?? "");
    $telefono   = trim($_POST["telefono"] ?? "");
    $estado     = trim($_POST["estado"] ?? "");
    $tipoMedico = trim($_POST["tipoMedico"] ?? "");

    if ($idMedico === "" || $nombre === "" || $apellido === "") {
        echo json_encode(["ok" => false, "mensaje" => "Campos obligatorios vacíos"]);
        exit;
    }

    try {
        $consulta = mysqli_prepare($conexionBd, 
        "INSERT INTO medico 
        (idMedico, nombre, apellido, telefono, estado, tipoMedico) 
        VALUES (?, ?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param($consulta, "ssssss",
            $idMedico,
            $nombre,
            $apellido,
            $telefono,
            $estado,
            $tipoMedico
        );

        mysqli_stmt_execute($consulta);
        mysqli_stmt_close($consulta);

        echo json_encode(["ok" => true, "mensaje" => "Médico guardado correctamente"]);

    } catch (Exception $error) {
        echo json_encode(["ok" => false, "mensaje" => "Error: " . $error->getMessage()]);
    }
}

	
	
var_dump($estado);
exit;