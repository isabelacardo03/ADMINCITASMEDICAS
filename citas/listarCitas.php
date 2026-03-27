<?php
header("Content-type: application/json");

require __DIR__ . "/../baseDatos.php";

$tipo = $_GET["tipo"] ?? "";

if ($tipo === "cita") {

    $filtros = [];
    $params = [];

    if (!empty($_GET["paciente"])) {
        $filtros[] = "paciente LIKE ?";
        $params[] = "%" . $_GET["paciente"] . "%";
    }

    if (!empty($_GET["medico"])) {
        $filtros[] = "medico LIKE ?";
        $params[] = "%" . $_GET["medico"] . "%";
    }

    if (!empty($_GET["fecha"])) {
        $filtros[] = "fecha = ?";
        $params[] = $_GET["fecha"];
    }

    $sql = "SELECT * FROM citas";
    if ($filtros) {
        $sql .= " WHERE " . implode(" AND ", $filtros);
    }

    $stmt = mysqli_prepare($conexionBd, $sql);

    if ($params) {
        // Crear tipos de parámetros dinámicamente (todos strings en este caso)
        $tipos = str_repeat("s", count($params));
        mysqli_stmt_bind_param($stmt, $tipos, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    $citas = [];
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $citas[] = $fila;
    }

    echo json_encode([
        "ok" => true,
        "citas" => $citas
    ]);

    mysqli_stmt_close($stmt);
}