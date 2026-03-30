<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";



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