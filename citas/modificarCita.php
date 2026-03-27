<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$id       = intval($_POST["id"] ?? 0);
$paciente = trim($_POST["paciente"] ?? "");
$medico   = trim($_POST["medico"] ?? "");
$fecha    = $_POST["fecha"] ?? "";
$hora     = $_POST["hora"] ?? "";

if ($id <= 0 || !$paciente || !$medico || !$fecha || !$hora) {
    echo json_encode(["ok" => false, "mensaje" => "Datos incompletos"]);
    exit;
}

$fecha = date("Y-m-d", strtotime($fecha));
$hora  = date("H:i:s", strtotime($hora));

$consulta = mysqli_prepare(
    $conexionBd, 
    "UPDATE citas SET paciente=?, medico=?, fecha=?, hora=? WHERE id=?"
);
mysqli_stmt_bind_param($consulta, "ssssi", $paciente, $medico, $fecha, $hora, $id);

if (mysqli_stmt_execute($consulta)) {
    echo json_encode(["ok" => true, "mensaje" => "Cita actualizada"]);
} else {
    echo json_encode(["ok" => false, "mensaje" => "Error al actualizar: ".mysqli_error($conexionBd)]);
}
mysqli_stmt_close($consulta);
?>