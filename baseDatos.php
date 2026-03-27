<?php
$conexionBd = mysqli_connect("localhost", "root", "", "sistema_citas");

if (!$conexionBd) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>