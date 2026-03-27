<?php
include('../baseDatos.php'); 
session_start();

// Seguridad básica
if (!isset($_SESSION['admin_id'])) {
    header("Location: login/login.html");
    exit();
}

// Consulta 1: Estados de citas
$res_est = mysqli_query($conexionBd, "SELECT estado, COUNT(*) as total FROM citas GROUP BY estado");
$labels_est = []; $data_est = [];
while($f = mysqli_fetch_assoc($res_est)){
    $labels_est[] = $f['estado'];
    $data_est[] = $f['total'];
}

// Consulta 2: Citas por médico
$res_med = mysqli_query($conexionBd, "SELECT m.nombre, COUNT(c.id) as total FROM medico m LEFT JOIN citas c ON m.idMedico = c.idMedico GROUP BY m.idMedico");
$labels_med = []; $data_med = [];
while($f = mysqli_fetch_assoc($res_med)){
    $labels_med[] = $f['nombre'];
    $data_med[] = $f['total'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes - Hospital San Vicente</title>
    <link rel="stylesheet" href="graficos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="header-graficos">
        <h1>Estadísticas Hospitalarias</h1>
    </div>

    <div class="container">
        <div class="chart-card">
            <h3>Estado de las Citas</h3>
            <canvas id="chartEstados"></canvas>
        </div>
        <div class="chart-card">
            <h3>Citas por Médico</h3>
            <canvas id="chartMedicos"></canvas>
        </div>
    </div>

    <a href="../portal/portal.html" class="btn-volver">Volver al Panel</a>

    <script>
        // Pasamos datos de PHP a variables globales de JS
        const datosEstados = <?php echo json_encode($data_est); ?>;
        const labelsEstados = <?php echo json_encode($labels_est); ?>;
        const datosMedicos = <?php echo json_encode($data_med); ?>;
        const labelsMedicos = <?php echo json_encode($labels_med); ?>;
    </script>
    <script src="graficos.js"></script>
</body>
</html>