<?php
include('../baseDatos.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['archivo'])) {
    $tipo = $_POST['tipo'];
    $tmpName = $_FILES['archivo']['tmp_name'];
    
    if (($handle = fopen($tmpName, "r")) !== FALSE) {
        fgetcsv($handle, 1000, ",");
        
        $contador = 0;

        while (($fila = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (empty($fila[0])) continue;

            if ($tipo == 'pacientes') {

                $sql = "INSERT INTO paciente (idPaciente, tipoIdenti, nombre, apellido, fechaNacimiento, direccion, telefono, estado) 
                        VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]', '$fila[4]', '$fila[5]', '$fila[6]', '$fila[7]')";
            } else {

                $sql = "INSERT INTO citas (fechaHora, estado, idMedico, tipoCita) 
                        VALUES ('$fila[0]', '$fila[1]', '$fila[2]', '$fila[3]')";
            }

            if(mysqli_query($conexionBd, $sql)) {
                $contador++;
            } else {
                echo "Error en fila: " . mysqli_error($conexionBd);
            }
        }
        fclose($handle);
        header("Location: importar_exportar.php?msg=Se importaron $contador registros exitosamente");
    }
}
?>