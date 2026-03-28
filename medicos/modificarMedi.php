<?php
require __DIR__ . "/../baseDatos.php";

$idMedico = $_GET['idMedico'] ?? "";

if ($idMedico === "") {
    echo "No se recibió identificación";
    exit;
}

// Obtener datos del médico
$respuest= "SELECT * FROM medico WHERE idMedico=?";
$stmt = mysqli_prepare($conexionBd, $respuest);
mysqli_stmt_bind_param($stmt, "s", $idMedico);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$medico = mysqli_fetch_assoc($result);

if (!$medico) {
    echo "Médico no encontrado";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Médico</title>
    <link rel="stylesheet" href="../medicos/medico.css">
</head>
<body class="imagen-body">
    <section class="formu">
        <h2>Actualizar Médico</h2>

        <form action="../medicos/actualizarMedi.php" method="post"> 
            <input type="hidden" name="idMedico" value="<?php echo $medico['idMedico']; ?>">

            <input type="text" disabled value="<?php echo $medico['idMedico']; ?>">

            <input type="text" name="nombre" value="<?php echo $medico['nombre']; ?>">
            <input type="text" name="apellido" value="<?php echo $medico['apellido']; ?>">
            <input type="text" name="telefono" value="<?php echo $medico['telefono']; ?>">

            <select name="tipoMedico">
                <option value="">Tipo de médico</option>
                <option value="general" <?php echo ($medico['tipoMedico'] == 'general') ? 'selected' : ''; ?>>General</option>
                <option value="especialista" <?php echo ($medico['tipoMedico'] == 'especialista') ? 'selected' : ''; ?>>Especialista</option>
            </select>

            <select name="estado">
                <option value="activo" <?php echo ($medico['estado'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                <option value="inactivo" <?php echo ($medico['estado'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
            </select>

            <div class="botones">
                <button type="submit">Guardar</button>
                <button type="button" onclick="history.back()">Cancelar</button>
            </div>
        </form>
    </section>
</body>
</html>