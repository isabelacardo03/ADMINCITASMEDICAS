<?php
header("Content-Type: application/json");
require "../baseDatos.php";

$idPaciente = $_GET["idPaciente"] ?? '';
$idCita     = $_GET["idCita"] ?? '';
$estado     = $_GET["estado"] ?? '';

if ($idPaciente == '' || $idCita == '' || $estado == '') {
    echo json_encode(["ok" => false, "mensaje" => "Faltan datos"]);
    exit;
}

// 1. Revisar si ya existe la asignación
$consulta = "SELECT * FROM asignacion_cita WHERE idCita='$idCita' AND identiPaciente='$idPaciente'";
$resultado = mysqli_query($conexionBd, $consulta);

// 2. Si existe → actualizar, si no → insertar
if (mysqli_num_rows($resultado) > 0) {
    $sql = "UPDATE asignacion_cita SET estado='$estado' WHERE idCita='$idCita' AND identiPaciente='$idPaciente'";
} else {
    $sql = "INSERT INTO asignacion_cita (idCita, identiPaciente, estado) VALUES ('$idCita', '$idPaciente', '$estado')";
}

$ejecutar = mysqli_query($conexionBd, $sql);

echo json_encode(["ok" => $ejecutar]);
?>