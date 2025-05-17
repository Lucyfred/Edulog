<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");


header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    global $conn;
    $id_ficha = $_POST["id"];

    $query = "SELECT *,
    s.dia AS dia
    FROM actividades a
    INNER JOIN dias s ON a.id_dia = s.id_dia
    WHERE id_ficha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_ficha);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = [];

    while ($dato = $result->fetch_assoc()) {
        $datos[] = $dato;
    }

    $stmt->close();
    echo json_encode($datos);
}
