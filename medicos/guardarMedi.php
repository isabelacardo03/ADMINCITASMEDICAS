<?php
header("Content-type: application/json");
require __DIR__ . "/../baseDatos.php";

$idMedico   = trim($_POST["idMedico"] ?? "");
$nombre     = trim($_POST["nombre"] ?? "");
$apellido   = trim($_POST["apellido"] ?? "");
$telefono   = trim($_POST["telefono"] ?? "");
$estado     = trim($_POST["estado"] ?? "");
$tipoMedico = trim($_POST["tipoMedico"] ?? "");

// Validación simple
if ($idMedico === "" || $nombre === "" || $apellido === "") {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Campos obligatorios vacíos"
    ]);
    exit;
}

try {
    $consulta = mysqli_prepare($conexionBd, 
        "INSERT INTO medico 
        (idMedico, nombre, apellido, telefono, estado, tipoMedico) 
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param($consulta, "ssssss",
        $idMedico,
        $nombre,
        $apellido,
        $telefono,
        $estado,
        $tipoMedico
    );

    mysqli_stmt_execute($consulta);
    mysqli_stmt_close($consulta);

    echo json_encode([
        "ok" => true,
        header("Location: ../medicos/medicos.html")

    ]);

} catch (Exception $error) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error: " . $error->getMessage()
    ]);
}
?>