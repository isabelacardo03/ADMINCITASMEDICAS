<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$tipo = $_GET["tipo"] ?? "";


if ($tipo === "buscar") {

    $id = $_GET['idMedico'] ?? "";

    if ($id == "") {
        echo json_encode([
            "ok" => false,
            "mensaje" => "ID vacío"
        ]);
        exit;
    }

    $resultado = mysqli_query($conexionBd, 
        "SELECT nombre, apellido, estado 
         FROM medico 
         WHERE idMedico = '$id'"
    );

    if (mysqli_num_rows($resultado) === 0) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "Médico no encontrado"
        ]);
        exit;
    }

    $medico = mysqli_fetch_assoc($resultado);

    echo json_encode([
        "ok" => true,
        "medico" => $medico
    ]);
    exit;
}


$resultado = mysqli_query($conexionBd, 
    "SELECT * FROM medico ORDER BY idMedico DESC"
);

$medicos = [];

while ($fila = mysqli_fetch_assoc($resultado)){
    $medicos[] = $fila;
}

echo json_encode([
    "ok" => true,
    "medicos" => $medicos
]);