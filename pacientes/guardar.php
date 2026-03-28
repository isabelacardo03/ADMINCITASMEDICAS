<?php
header("Content-type: application/json");

require __DIR__ . "/../baseDatos.php";

$tipo = $_POST["tipo"] ?? ""; 

if ($tipo === "") {
    echo json_encode(["ok" => false, "mensaje" => "Tipo no definido"]);
    exit;
}

if ($tipo === "paciente") {

    $identificacion = trim($_POST["idPaciente"] ?? "");
    $tipoDocumento  = trim($_POST["tipoIdenti"] ?? "");
    $nombre         = trim($_POST["nombre"] ?? "");
    $apellido       = trim($_POST["apellido"] ?? "");
    $fechaNacimiento= trim($_POST["fechaNacimiento"] ?? "");
    $direccion      = trim($_POST["direccion"] ?? "");
    $telefono       = trim($_POST["telefono"] ?? "");
    $estado         = trim($_POST["estado"] ?? "");

if ($identificacion === "" || $nombre === "" || $apellido === "") {
        echo json_encode(["ok" => false, "mensaje" => "Campos obligatorios vacíos"]);
        exit;
    }

     try {
        $consulta = mysqli_prepare($conexionBd, 
        "INSERT INTO paciente 
        (idPaciente, tipoIdenti, nombre, apellido, fechaNacimiento, direccion, telefono, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param($consulta, "ssssssss",
            $identificacion,
            $tipoDocumento,
            $nombre,
            $apellido,
            $fechaNacimiento,
            $direccion,
            $telefono,
            $estado
        );

        mysqli_stmt_execute($consulta);
        mysqli_stmt_close($consulta);

        echo json_encode(["ok" => true, "mensaje" => "Paciente guardado correctamente"]);
        header("Location: ../pacientes/paciente.html");

    } catch (mysqli_stmt_exeption $error) {
        echo json_encode(["ok" => false, "mensaje" => "Error: " . $error->getMessage()]);
    }
}


	
	
