<?php
header("Content-type: application/json");

require __DIR__ . "/../baseDatos.php";

$tipo = $_POST["tipo"] ?? "";

if ($tipo === "") {
    echo json_encode(["ok" => false, "mensaje" => "Tipo no definido"]);
    exit;
}

if ($tipo === "paciente") {

    $identificacion = intval($_POST['idPaciente'] ?? 0);

    if ($identificacion <= 0) {
        echo json_encode(["ok" => false, "mensaje" => 'Identificación Invalida']);
        exit;
    }
    try {
        $consulta = mysqli_prepare($conexionBd, "DELETE FROM paciente WHERE idPaciente=?");
        mysqli_stmt_bind_param($consulta, "i", $identificacion);
        mysqli_stmt_execute($consulta);

        $filas = mysqli_stmt_affected_rows($consulta);
        mysqli_stmt_close($consulta);

        if ($filas > 0) {
            echo json_encode(["ok" => true, "mensaje" => 'pacientet eliminado correctamente']);
        } else {
            echo json_encode(["ok" => false, "mensaje" => 'No se encontró el paciente']);
        }

    } catch (mysqli_sql_exception $error) {
        echo json_encode(["ok" => false, "mensaje" => 'Error al eliminar: ' . $error->getMessage()]);
    }
}
