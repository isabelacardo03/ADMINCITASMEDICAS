<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$medicoId = trim($_POST["idMedico"] ?? "");
$fechaHora = trim($_POST["fechaHora"] ?? "");
$tipoCita = trim($_POST["tipoCita"] ?? "");

$estado = trim($_POST["estado"] ?? "");

if (!$medicoId || !$fechaHora || !$tipoCita || !$estado) {
    echo json_encode(["ok" => false, "mensaje" => "Todos los campos son obligatorios"]);
    exit;
}

$sql = "INSERT INTO citas (idMedico, fechaHora, tipoCita, estado) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $medicoId, $fechaHora, $tipoCita, $estado);
mysqli_stmt_execute($stmt);

echo json_encode(["ok" => true, "mensaje" => "Cita guardada correctamente"]);