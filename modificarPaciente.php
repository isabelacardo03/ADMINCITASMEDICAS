<?php
require "baseDatos.php";

$identificacion = $_GET['identificacion'] ?? "";

if ($identificacion === "") {
    echo "No se recibió identificación";
    exit;
}

// Obtener datos del paciente
$sql = "SELECT * FROM usuario WHERE identificacion=?";
$stmt = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($stmt, "s", $identificacion);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$paciente = mysqli_fetch_assoc($result);

if (!$paciente) {
    echo "Paciente no encontrado";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Paciente</title>
</head>
<body>
    <h1>Modificar Paciente</h1>
    <form action="actualizarPaciente.php" method="post">
        <input type="hidden" name="identificacion" value="<?php echo $paciente['identificacion']; ?>">

        <label>Tipo Documento:</label>
        <input type="text" name="tipoDocumento" value="<?php echo $paciente['tipoDocumento']; ?>"><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $paciente['nombre']; ?>"><br>

        <label>Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $paciente['apellido']; ?>"><br>

        <label>Fecha Nacimiento:</label>
        <input type="date" name="fechaNacimiento" value="<?php echo $paciente['fechaNacimiento']; ?>"><br>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $paciente['direccion']; ?>"><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $paciente['telefono']; ?>"><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" placeholder="Dejar en blanco para no cambiar"><br>

        <label>Estado:</label>
        <input type="text" name="estado" value="<?php echo $paciente['estado']; ?>"><br>

        <label>Pregunta Seguridad:</label>
        <input type="text" name="preSeguridad" value="<?php echo $paciente['preSeguridad']; ?>"><br>

        <label>Respuesta Seguridad:</label>
        <input type="text" name="reSeguridad" value="<?php echo $paciente['reSeguridad']; ?>"><br>

        <button type="submit">Actualizar Paciente</button>
    </form>
</body>
</html>