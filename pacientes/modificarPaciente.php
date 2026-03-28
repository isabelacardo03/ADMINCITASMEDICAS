<?php
require __DIR__ . "/../baseDatos.php";

$identificacion = $_GET['idPaciente'] ?? "";

if ($identificacion === "") {
    echo "No se recibió identificación";
    exit;
}

// Obtener datos del paciente
$sql = "SELECT * FROM paciente WHERE idPaciente=?";
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
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <section class="form">
        <h2>Actualizar Paciente</h2>

        <form id="formPaciente" action="actualizarPaciente.php" method="post"> 
            <input type="hidden" name="tipo" value="paciente">
            <input type="text" placeholder="Identificación" id="identificacion" name="idPaciente" value="<?php echo $paciente['idPaciente']; ?>">
            
            <select id="tipoDocumento" name="tipoIdenti">
                <option value="">Tipo de documento</option>
                <option value='CC' <?php echo ($paciente['tipoIdenti'] == 'CC') ? 'selected' : ''; ?>>CC</option>
                <option value='TI' <?php echo ($paciente['tipoIdenti'] == 'TI') ? 'selected' : ''; ?>>TI</option>
                <option value='CE' <?php echo ($paciente['tipoIdenti'] == 'CE') ? 'selected' : ''; ?>>CE</option>
            </select>
            
            <input type="text" placeholder="Nombre" id="nombre" name="nombre" value="<?php echo $paciente['nombre']; ?>">
            <input type="text" placeholder="Apellido" id="apellido" name="apellido" value="<?php echo $paciente['apellido']; ?>">
            <input type="date" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $paciente['fechaNacimiento']; ?>">
            <input type="text" placeholder="Dirección" id="direccion" name="direccion" value="<?php echo $paciente['direccion']; ?>">
            <input type="text" placeholder="Teléfono" id="telefono" name="telefono" value="<?php echo $paciente['telefono']; ?>">

            <select id="estado" name="estado">
            <option value='activo'>Activo</option>
            <option value='inactivo'>Inactivo</option>
        </select>

            <div class="botones">
                <button type="submit">Guardar</button>
                <button type="button">Cancelar</button>
            </div>
        </form>
    </section>
</body>
</html>