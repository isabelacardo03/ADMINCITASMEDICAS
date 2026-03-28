<?php
header("Content-type: application/json");

require __DIR__ . "/../baseDatos.php";


$idMedico = intval($_POST['idMedico'] ?? 0);


if ($idMedico <= 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "ID inválido"
    ]);
    exit;
}

try {
    $consulta = mysqli_prepare($conexionBd, 
        "DELETE FROM medico WHERE idMedico=?"
    );

    mysqli_stmt_bind_param($consulta, "i", $idMedico);
    mysqli_stmt_execute($consulta);

    $filas = mysqli_stmt_affected_rows($consulta);
    mysqli_stmt_close($consulta);

    if ($filas > 0) {
        echo json_encode([
            "ok" => true,
            "mensaje" => "Médico eliminado correctamente"
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "mensaje" => "No se encontró el médico"
        ]);
    }

} catch (mysqli_sql_exception $error) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al eliminar: " . $error->getMessage()
    ]);
}
?>