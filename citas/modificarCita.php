<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$id = intval($_POST["id"] ?? 0);
$medicoId = trim($_POST["idMedico"] ?? "");
$fechaHora = $_POST["fechaHora"] ?? "";
$tipoCita = trim($_POST["tipoCita"] ?? "");

if ($id <= 0 || !$medicoId || !$fechaHora || !$tipoCita) {
    echo json_encode(["ok" => false, "mensaje" => "Datos incompletos"]);
    exit;
}

$sql = "UPDATE citas SET idMedico=?, fechaHora=?, tipoCita=? WHERE id=?";
$stmt = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($stmt, "ssss", $medicoId, $fechaHora, $tipoCita, $id);
mysqli_stmt_execute($stmt);

echo json_encode(["ok" => true, "mensaje" => "Cita actualizada correctamente"]);