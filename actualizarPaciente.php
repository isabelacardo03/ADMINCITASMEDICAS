<?php
require "baseDatos.php";

$identificacion = $_POST['identificacion'] ?? "";
$tipoDocumento  = $_POST['tipoDocumento'] ?? "";
$nombre         = $_POST['nombre'] ?? "";
$apellido       = $_POST['apellido'] ?? "";
$fechaNacimiento= $_POST['fechaNacimiento'] ?? "";
$direccion      = $_POST['direccion'] ?? "";
$telefono       = $_POST['telefono'] ?? "";
$contrasena     = $_POST['contrasena'] ?? "";
$estado         = $_POST['estado'] ?? "";
$preSeguridad   = $_POST['preSeguridad'] ?? "";
$reSeguridad    = $_POST['reSeguridad'] ?? "";

if ($identificacion === "" || $nombre === "" || $apellido === "") {
    echo "Campos obligatorios vacíos";
    exit;
}

// Contraseña solo se cambia si se ingresó algo
$pass_sql = "";
if ($contrasena !== "") {
    $pass_sql = md5($contrasena);
}

if ($pass_sql !== "") {
    $sql = "UPDATE usuario SET tipoDocumento=?, nombre=?, apellido=?, fechaNacimiento=?, direccion=?, telefono=?, contrasena=?, estado=?, preSeguridad=?, reSeguridad=? WHERE identificacion=?";
    $stmt = mysqli_prepare($conexionBd, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssss", $tipoDocumento, $nombre, $apellido, $fechaNacimiento, $direccion, $telefono, $pass_sql, $estado, $preSeguridad, $reSeguridad, $identificacion);
} else {
    $sql = "UPDATE usuario SET tipoDocumento=?, nombre=?, apellido=?, fechaNacimiento=?, direccion=?, telefono=?, estado=?, preSeguridad=?, reSeguridad=? WHERE identificacion=?";
    $stmt = mysqli_prepare($conexionBd, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $tipoDocumento, $nombre, $apellido, $fechaNacimiento, $direccion, $telefono, $estado, $preSeguridad, $reSeguridad, $identificacion);
}

if (mysqli_stmt_execute($stmt)) {
    echo "Paciente actualizado correctamente";
} else {
    echo "Error al actualizar: " . mysqli_stmt_error($stmt);
}