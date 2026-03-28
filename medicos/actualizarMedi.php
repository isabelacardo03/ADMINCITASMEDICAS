<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";


$idMedico   = $_POST["idMedico"] ?? "";
$nombre     = $_POST["nombre"] ?? "";
$apellido   = $_POST["apellido"] ?? "";
$telefono   = $_POST["telefono"] ?? "";
$estado     = $_POST["estado"] ?? "";
$tipoMedico = $_POST["tipoMedico"] ?? "";


if ($idMedico == "" || $nombre == "" || $apellido == "") {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Campos obligatorios vacíos"
    ]);
    exit;
}

try {
    $sql = "UPDATE medico SET nombre=?, apellido=?, telefono=?, estado=?, tipoMedico=? WHERE idMedico=?";

    $stmt = mysqli_prepare($conexionBd, $sql);

    mysqli_stmt_bind_param($stmt, "ssssss",
        $nombre,
        $apellido,
        $telefono,
        $estado,
        $tipoMedico,
        $idMedico
    );

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode([
            "ok" => true,
            header("Location: ../medicos/medicos.html")
        ]);
    } else {
        echo json_encode([
            "ok" => false,
            "mensaje" => "No se realizaron cambios"
        ]);
    }

    mysqli_stmt_close($stmt);

} catch (Exception $error) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error: " . $error->getMessage()
    ]);
}
