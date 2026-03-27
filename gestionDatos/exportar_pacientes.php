<?php
include('../baseDatos.php');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=lista_pacientes.csv');

$salida = fopen('php://output', 'w');
// Encabezados
fputcsv($salida, array('ID', 'Nombre', 'Email', 'Telefono', 'Estado'));

$query = "SELECT id, nombre, email, telefono, estado FROM paciente";
$resultado = mysqli_query($conexionBd, $query);

while ($fila = mysqli_fetch_assoc($resultado)) {
    fputcsv($salida, $fila);
}
fclose($salida);
exit();
?>