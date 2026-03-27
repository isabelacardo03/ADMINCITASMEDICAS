<?php
header("Content-type: application/json");

require __DIR__ . "/../baseDatos.php";

$id = intval($_POST["id"] ?? 0);

if ($id <= 0) {
    echo json_encode(["ok" => false, "mensaje" => "ID inválido"]);
    exit;
}

$consulta = mysqli_prepare($conexionBd, "DELETE FROM citas WHERE id = ?");

mysqli_stmt_bind_param($consulta, "i", $id);
mysqli_stmt_execute($consulta);

$filas = mysqli_stmt_affected_rows($consulta);

mysqli_stmt_close($consulta);

if ($filas > 0) {
    echo json_encode(["ok" => true, "mensaje" => "Cita eliminada"]);
} else {
    echo json_encode(["ok" => false, "mensaje" => "No se encontró la cita"]);
}