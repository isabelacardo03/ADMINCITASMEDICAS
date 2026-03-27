<?php
header("Content-type: application/json");

require __DIR__ . "/../baseDatos.php";

$tipo = $_POST["tipo"] ?? ""; 

if ($tipo === "cita") {

    $paciente = trim($_POST["paciente"] ?? "");
    $medico   = trim($_POST["medico"] ?? "");
    $fecha    = trim($_POST["fecha"] ?? "");
    $hora     = trim($_POST["hora"] ?? "");

    if ($paciente === "" || $medico === "" || $fecha === "" || $hora === "") {
        echo json_encode(["ok" => false, "mensaje" => "Campos vacíos"]);
        exit;
    }

    try {
        $consulta = mysqli_prepare($conexionBd,
        "INSERT INTO citas (paciente, medico, fecha, hora) VALUES (?, ?, ?, ?)");

        mysqli_stmt_bind_param($consulta, "ssss",
            $paciente,
            $medico,
            $fecha,
            $hora
        );

        mysqli_stmt_execute($consulta);
        mysqli_stmt_close($consulta);

        echo json_encode(["ok" => true, "mensaje" => "Cita guardada correctamente"]);

    } catch (Exception $error) {
        echo json_encode(["ok" => false, "mensaje" => "Error: " . $error->getMessage()]);
    }
}