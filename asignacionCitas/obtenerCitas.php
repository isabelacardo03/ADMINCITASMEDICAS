<?php
header("Content-Type: application/json");
require "../baseDatos.php";

$sql = "SELECT id, fechaHora FROM citas ORDER BY fechaHora DESC LIMIT 50";
$resultado = mysqli_query($conexionBd, $sql);

if (!$resultado) {
    echo json_encode([
        "ok" => false,
        "error" => mysqli_error($conexionBd)
    ]);
    exit;
}

$citas = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $citas[] = $fila;
}

echo json_encode([
    "ok" => true,
    "citas" => $citas
]);
?>