<?php
require __DIR__ . "/../baseDatos.php";

$idMedico = $_GET['idMedico'] ?? "";

if ($idMedico === "") {
    echo "No se recibió identificación";
    exit;
}

// Obtener datos del médico
$respuest = "SELECT * FROM medico WHERE idMedico=?";
$stmt = mysqli_prepare($conexionBd, $respuest);
mysqli_stmt_bind_param($stmt, "s", $idMedico);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$medico = mysqli_fetch_assoc($result);

if (!$medico) {
    header("Location: ../medicos/medicos.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Modificar Médico</title>
     <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../medicos/medico.css">
</head>

<body class="imagen-body">

    <main>
        <div class="titulo">
            Modificar Médico
        </div>
        <section class="form-section">
            <h2>Actualizar Médico</h2>

            <form action="../medicos/actualizarMedi.php" method="post">

                <input type="hidden" name="idMedico" value="<?php echo $medico['idMedico']; ?>">

                <div class="campo">
                    <label>ID Médico</label>
                    <input type="text" value="<?php echo $medico['idMedico']; ?>" disabled>
                </div>

                <div class="campo">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="<?php echo $medico['nombre']; ?>">
                </div>

                <div class="campo">
                    <label>Apellido</label>
                    <input type="text" name="apellido" value="<?php echo $medico['apellido']; ?>">
                </div>

                <div class="campo">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="<?php echo $medico['telefono']; ?>">
                </div>

                <div class="campo">
                    <label>Tipo de médico</label>
                    <select name="tipoMedico">
                        <option value="">Seleccione</option>
                        <option value="general" <?php echo ($medico['tipoMedico'] == 'general') ? 'selected' : ''; ?>>
                            General</option>
                        <option value="especialista" <?php echo ($medico['tipoMedico'] == 'especialista') ? 'selected' : ''; ?>>Especialista</option>
                    </select>
                </div>

                <div class="campo">
                    <label>Estado</label>
                    <select name="estado">
                        <option value="activo" <?php echo ($medico['estado'] == 'activo') ? 'selected' : ''; ?>>Activo
                        </option>
                        <option value="inactivo" <?php echo ($medico['estado'] == 'inactivo') ? 'selected' : ''; ?>>
                            Inactivo</option>
                    </select>
                </div>

                <div class="botones">
                    <button type="submit">Guardar</button>
                    <button type="button" onclick="window.location.href='../medicos/medicos.html'">Cancelar</button>
                </div>

            </form>
        </section>
    </main>
</body>

</html>