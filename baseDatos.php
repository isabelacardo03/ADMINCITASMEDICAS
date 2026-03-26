<?php
$conexion = mysqli_connect("localhost", "root", "", "sistema_citas");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>