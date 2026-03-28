<?php
require "../baseDatos.php";

$identificacion = $_POST['idPaciente'] ?? "";
$tipoDocumento  = $_POST['tipoIdenti'] ?? "";
$nombre         = $_POST['nombre'] ?? "";
$apellido       = $_POST['apellido'] ?? "";
$fechaNacimiento= $_POST['fechaNacimiento'] ?? "";
$direccion      = $_POST['direccion'] ?? "";
$telefono       = $_POST['telefono'] ?? "";
$estado         = $_POST['estado'] ?? "";

if ($identificacion === "" || $nombre === "" || $apellido === "") {
    echo "Campos obligatorios vacíos";
    exit;
}

    $sql = "UPDATE paciente SET tipoIdenti=?, nombre=?, apellido=?, fechaNacimiento=?, direccion=?, telefono=?, estado=? WHERE idPaciente=?";
    $stmt = mysqli_prepare($conexionBd, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $tipoDocumento, $nombre, $apellido, $fechaNacimiento, $direccion, $telefono, $estado, $identificacion);


if (mysqli_stmt_execute($stmt)) {
    header("Location: ../pacientes/paciente.html");
} else {
    echo "Error al actualizar: " . mysqli_stmt_error($stmt);
}