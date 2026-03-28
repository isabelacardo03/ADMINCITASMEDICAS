<?php
header("Content-Type: application/json");
require __DIR__ . "/../baseDatos.php";

$estado = $_GET['estado'] ?? 'confirmada'; // por defecto confirmadas

$sql = "SELECT id, idCita, identiPaciente, estado 
        FROM citas 
        WHERE estado = ?";

$consulta = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($consulta, "s", $estado);
mysqli_stmt_execute($consulta);

$resultado = mysqli_stmt_get_result($consulta);

$citas = [];

while ($fila = mysqli_fetch_assoc($resultado)) {
    $citas[] = $fila;
}

echo json_encode($citas);
?>