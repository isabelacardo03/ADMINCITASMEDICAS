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
    <section class="forms">
        <h1 class="titulo">Modificar</h1>

        <div class="card">
            <h2>Actualizar Paciente</h2>

            <form id="formPaciente" action="actualizarPaciente.php" method="post">
                <input type="hidden" name="tipo" value="paciente">

                <div class="campo">
                    <label>Identificación</label>
                    <input type="text" name="idPaciente" value="<?php echo $paciente['idPaciente']; ?>">
                </div>

                <div class="campo">
                    <label>Tipo de documento</label>
                    <select name="tipoIdenti">
                        <option value="">Seleccione</option>
                        <option value='CC' <?php echo ($paciente['tipoIdenti'] == 'CC') ? 'selected' : ''; ?>>CC
                        </option>
                        <option value='TI' <?php echo ($paciente['tipoIdenti'] == 'TI') ? 'selected' : ''; ?>>TI
                        </option>
                        <option value='CE' <?php echo ($paciente['tipoIdenti'] == 'CE') ? 'selected' : ''; ?>>CE
                        </option>
                    </select>
                </div>

                <div class="campo">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="<?php echo $paciente['nombre']; ?>">
                </div>

                <div class="campo">
                    <label>Apellido</label>
                    <input type="text" name="apellido" value="<?php echo $paciente['apellido']; ?>">
                </div>

                <div class="campo">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="fechaNacimiento" value="<?php echo $paciente['fechaNacimiento']; ?>">
                </div>

                <div class="campo">
                    <label>Dirección</label>
                    <input type="text" name="direccion" value="<?php echo $paciente['direccion']; ?>">
                </div>

                <div class="campo">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="<?php echo $paciente['telefono']; ?>">
                </div>

                <div class="campo">
                    <label>Estado</label>
                    <select name="estado">
                        <option value='activo' <?php echo ($paciente['estado'] == 'activo') ? 'selected' : ''; ?>>
                            Activo</option>
                        <option value='inactivo' <?php echo ($paciente['estado'] == 'inactivo') ? 'selected' : ''; ?>>
                            Inactivo</option>
                    </select>
                </div>

                <div class="botones">
                    <button type="submit">Guardar</button>
                    <button type="button" onclick="window.location.href='../pacientes/paciente.html'">Cancelar</button>
                </div>
            </form>
        </div>
    </section>
</body>

</html>