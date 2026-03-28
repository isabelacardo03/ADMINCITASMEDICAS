<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$id = intval($_POST['id'] ?? 0);
$idMedico = trim($_POST['idMedico'] ?? '');
$fechaHora = $_POST['fechaHora'] ?? '';
$tipoCita = trim($_POST['tipoCita'] ?? '');
$estado = trim($_POST['estado'] ?? '');

if ($id <= 0 || !$idMedico || !$fechaHora || !$tipoCita || !$estado) {
    echo json_encode(["ok" => false, "mensaje" => "Datos incompletos"]);
    exit;
}

$sql = "UPDATE citas SET idMedico=?, fechaHora=?, tipoCita=?, estado=? WHERE id=?";
$stmt = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $idMedico, $fechaHora, $tipoCita, $estado, $id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode(["ok" => true, header("Location: ../citas/citas.html")]);
} else {
    echo json_encode(["ok" => false, "mensaje" => "No se pudo actualizar la cita"]);
}