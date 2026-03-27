<?php
include('../baseDatos.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    $tipo = $_POST['tipo'];
    $tmpName = $_FILES['archivo']['tmp_name'];
    $csvAsArray = array_map('str_getcsv', file($tmpName));
    
    // Quitamos la primera fila (encabezados)
    array_shift($csvAsArray);
    $contador = 0;

    foreach ($csvAsArray as $fila) {
        if ($tipo == 'pacientes') {
            // Suponiendo: Nombre, Email, Teléfono, Estado
            $sql = "INSERT INTO paciente (nombre, email, telefono, estado) 
                    VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]')";
        } else {
            // Suponiendo: idMedico, idPaciente, fecha, hora, estado
            $sql = "INSERT INTO citas (idMedico, idPaciente, fecha, hora, estado) 
                    VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]', '$fila[4]')";
        }
        if(mysqli_query($conexionBd, $sql)) $contador++;
    }

    header("Location: importar_exportar.php?msg=Se importaron $contador registros exitosamente");
} else {
    header("Location: importar_exportar.php?error=Archivo no válido");
}
?>