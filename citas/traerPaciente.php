<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$id = $_GET['id'] ?? "";
if (!$id) { echo json_encode([]); exit; }

$stmt = mysqli_prepare($conexionBd, "SELECT nombre FROM medico WHERE idMedico=?");
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

echo json_encode($data ?? []);