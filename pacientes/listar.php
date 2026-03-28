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