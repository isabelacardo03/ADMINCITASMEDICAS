<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$medicoId = trim($_POST["idMedico"] ?? "");
$fechaHora = trim($_POST["fechaHora"] ?? "");
$tipoCita = trim($_POST["tipoCita"] ?? "");

if (!$medicoId || !$fechaHora || !$tipoCita) {
    echo json_encode(["ok" => false, "mensaje" => "Todos los campos son obligatorios"]);
    exit;
}

$sql = "INSERT INTO citas (idMedico, fechaHora, tipoCita, estado) 
        VALUES (?, ?, ?, 'pendiente')";
$stmt = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($stmt, "sss", $medicoId, $fechaHora, $tipoCita);
mysqli_stmt_execute($stmt);

echo json_encode(["ok" => true, "mensaje" => "Cita guardada correctamente"]);