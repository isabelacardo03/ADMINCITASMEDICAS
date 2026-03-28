<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$sql = "SELECT c.id, c.fechaHora, c.estado, c.tipoCita, m.nombre AS medico, m.idMedico
        FROM citas c
        JOIN medico m ON c.idMedico = m.idMedico
        ORDER BY c.fechaHora";

$result = mysqli_query($conexionBd, $sql);

$citas = [];
while ($fila = mysqli_fetch_assoc($result)) {
    $citas[] = $fila;
}

echo json_encode(["ok" => true, "citas" => $citas]);