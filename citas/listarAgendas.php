<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$idmedico = $_GET["idMedico"] ?? "";


if ($idmedico == "") {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Id médico vacío",
        "agendas" => []
    ]);
    exit;
}

$resultado = mysqli_query($conexionBd, 
    "SELECT c.id, c.fechaHora, c.estado
     FROM citas c
     WHERE c.idMedico = '$idmedico' 
     AND c.fechaHora >= NOW() AND (c.estado IS NULL OR c.estado = 'confirmada')
     AND not exists (SELECT 1 FROM asignacion_cita a WHERE c.id = a.idCita AND a.estado = 'confirmada' )
     ORDER BY c.fechaHora DESC"
);


$agendas = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $agendas[] = $fila;
}

echo json_encode([
    "ok" => true,
    "agendas" => $agendas
]);
exit;