<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");


header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $conn;
    $id = (int)$_POST["id"];
    $mensaje = [
        "message" => "Ocurrió un error",
        "code" => "500"
    ];
    
    if($id <= 0 || $id == ""){
        $mensaje = [
            "message" => "Ocurrió un error al intentar borrar",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    $query = "DELETE FROM ficha WHERE id_ficha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $mensaje = [
            "message" => "Ficha eliminada exitosamente",
            "code" => "200"
        ];
    } else{
        $mensaje = [
            "message" => "Ocurrió un error al intentar borrar",
            "code" => "500"
        ];
    }

    $stmt->close();
    echo json_encode($mensaje);
}