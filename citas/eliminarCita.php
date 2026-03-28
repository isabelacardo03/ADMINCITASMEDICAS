<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$id = intval($_POST["id"] ?? 0);
if ($id <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "ID inválido"]);
    exit;
}

$sql = "UPDATE citas SET estado='cancelada' WHERE id=?";
$stmt = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);

echo json_encode(["ok" => true, "mensaje" => "Cita cancelada"]);