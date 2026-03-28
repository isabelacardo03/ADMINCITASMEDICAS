<?php
header("Content-type: application/json");

require __DIR__ . "/../baseDatos.php";

$tipo = $_GET["tipo"] ?? "";

if ($tipo === "") {
    echo json_encode(["ok" => false, "mensaje" => "Tipo no definido"]);
    exit;
}

if ($tipo === "paciente") {

    $resultado = mysqli_query($conexionBd, 
    "SELECT * FROM paciente ORDER BY idPaciente DESC");

    $pacientes = [];

    while ($fila = mysqli_fetch_assoc($resultado)){
        $pacientes[] = $fila;
    }

    echo json_encode([
        "ok" => true,
        "pacientes" => $pacientes
    ]);
}

if ($tipo === "buscar") {

    $id = $_GET['idPaciente'] ?? "";

    if ($id == "") {
        echo json_encode(["ok" => false, "mensaje" => "ID vacío"]);
        exit;
    }

    $resultado = mysqli_query($conexionBd, 
        "SELECT nombre, apellido, estado 
         FROM paciente 
         WHERE idPaciente = '$id'"
    );

    if (mysqli_num_rows($resultado) === 0) {
        echo json_encode(["ok" => false, "mensaje" => "Paciente no encontrado"]);
        exit;
    }

    $paciente = mysqli_fetch_assoc($resultado);

    echo json_encode([
        "ok" => true,
        "paciente" => $paciente
    ]);
}