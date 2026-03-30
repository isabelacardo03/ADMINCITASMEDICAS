<?php
require __DIR__ . "/../baseDatos.php";

$id = $_GET['id'] ?? "";

if ($id === "") {
    echo "No se recibió identificación de la cita";
    exit;
}

// Obtener datos de la cita
$sql = "SELECT c.*, m.nombre AS nombreMedico FROM citas c 
        LEFT JOIN medico m ON c.idMedico = m.idMedico
        WHERE c.id=?";
$stmt = mysqli_prepare($conexionBd, $sql);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$cita = mysqli_fetch_assoc($result);

if (!$cita) {
    echo "Cita no encontrada";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Cita</title>
     <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../citas/style.css">
</head>
<body>

    <h1>Modificar</h1>
    <section class="formu">
        <h2>Actualizar Cita</h2>

       <form action="../citas/actualizarCita.php" method="post"> 

    <input type="hidden" name="id" value="<?php echo $cita['id']; ?>">

    <div class="campo">
        <label>ID Médico</label>
        <input type="text" name="idMedico" id="medicoId" value="<?php echo $cita['idMedico']; ?>">
    </div>

    <div class="campo">
        <label>Nombre Médico</label>
        <input type="text" id="medicoNombre" value="<?php echo $cita['nombreMedico']; ?>" disabled>
    </div>

    <div class="campo">
        <label>Fecha y Hora</label>
        <input type="datetime-local" name="fechaHora" value="<?php echo date('Y-m-d\TH:i', strtotime($cita['fechaHora'])); ?>">
    </div>

    <div class="campo">
        <label>Tipo de Cita</label>
        <select name="tipoCita" id="tipoCita">
            <option value="">Seleccione</option>
            <option value="general" <?php echo ($cita['tipoCita']=='general')?'selected':''; ?>>General</option>
            <option value="especializada" <?php echo ($cita['tipoCita']=='especializada')?'selected':''; ?>>Especializada</option>
        </select>
    </div>

    <div class="campo">
        <label>Estado</label>
        <select name="estado">
            <option value="confirmada" <?php echo ($cita['estado']=='confirmada')?'selected':''; ?>>Confirmada</option>
            <option value="cancelada" <?php echo ($cita['estado']=='cancelada')?'selected':''; ?>>Cancelada</option>
        </select>
    </div>

    <div class="botones">
        <button type="submit">Actualizar</button>
        <button type="button" onclick="window.location.href='../citas/citas.html'">Cancelar</button>
    </div>

</form>
    </section>
</body>
</html>