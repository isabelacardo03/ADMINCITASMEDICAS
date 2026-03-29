<?php
include('../baseDatos.php');

$msg = isset($_GET['msg']) ? $_GET['msg'] : "";
$error = isset($_GET['error']) ? $_GET['error'] : "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Datos - Hospital</title>
    <link rel="stylesheet" href="gestionDatos.css">
</head>
<body>

    <header class="container">
        <div class="header">
            <h1>Centro de Importación y Exportación</h1>
        </div>
    </header>

    <div class="boton-volver">
        <a href="../portal/portal.html" class="boton-volver">← Volver al Panel Principal</a>
    </div>

    <div class="grid">
        <div class="card">
            <h2>Pacientes</h2>
            <div class="acciones">
                <a href="exportar_pacientes.php" class="boton boton-exportar">Descargar Pacientes (Excel)</a>
                <hr>
                <form action="procesar_importar.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="pacientes">
                    <label>Subir archivo CSV:</label>
                    <input type="file" name="archivo" accept=".xlsx, .xls" required>
                    <button type="submit" class="boton boton-importar">Cargar en Bloque</button>
                </form>
            </div>
        </div>

        <div class="card">
            <h2>Citas Médicas</h2>
            <div class="acciones">
                <a href="exportar_citas.php" class="boton boton-exportar">Descargar Citas (Excel)</a>
                <hr>
                <form action="procesar_importar.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tipo" value="citas">
                    <label>Subir archivo Excel (.xlsx, .xls):</label>
                    <input type="file" name="archivo" accept=".xlsx, .xls" required>
                    <button type="submit" class="boton boton-importar">Cargar en Bloque</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>