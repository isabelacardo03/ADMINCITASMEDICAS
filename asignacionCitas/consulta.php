<?php
header("Content-Type: application/json");
require "../baseDatos.php";

$estado = $_GET["estado"] ?? '';
$idPaciente = $_GET["idPaciente"] ?? '';

// Consulta base
$sql = "SELECT 
            a.id,
            a.idCita,
            a.identiPaciente,
            CONCAT(p.nombre, ' ', p.apellido) AS nombrePaciente,
            a.estado
        FROM asignacion_cita a
        JOIN paciente p ON a.identiPaciente = p.idPaciente";

$where = [];
$params = [];

if ($estado != '') {
    $where[] = "a.estado = '$estado'";
}

if ($idPaciente != '') {
    $where[] = "a.identiPaciente = '$idPaciente'";
}

if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY a.id DESC";

$resultado = mysqli_query($conexionBd, $sql);

if (!$resultado) {
    echo json_encode([
        "ok" => false,
        "error" => mysqli_error($conexionBd)
    ]);
    exit;
}

$datos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $datos[] = $fila;
}

echo json_encode([
    "ok" => true,
    "datos" => $datos
]);
?>