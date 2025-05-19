<?php 

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");
include_once($dir . "/cms/includes/showErrors.php");


header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $conn;
    $nombre = $_POST["inp-nombre-centro"];
    $tutor = $_POST["inp-tutor-centro"];
    $fp = $_POST["inp-fp"];
    $id = $_SESSION["user_id"];
    $mensaje = [
        "message" => "Ocurrió un error",
        "code" => "500"
    ];

    if(strlen($nombre) === 0){
        $mensaje = [
            "message" => "Por favor rellene el campo nombre",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    if(strlen($nombre) > 70){
        $mensaje = [
            "message" => "El campo nombre no puede contener más de 100 caracteres",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    if(strlen($tutor) === 0){
        $mensaje = [
            "message" => "Por favor rellene el campo tutor",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    if(strlen($tutor) > 100){
        $mensaje = [
            "message" => "El campo tutor no puede contener más de 100 caracteres",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    if(strlen($fp) === 0){
        $mensaje = [
            "message" => "Por favor rellene el campo ciclo formativo",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    if(strlen($fp) > 100){
        $mensaje = [
            "message" => "El campo ciclo formativo no puede contener más de 100 caracteres",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    $query_centro = "UPDATE centro c
    INNER JOIN usuario u
    ON u.id_centro = c.id_centro
    SET c.nombre = ?, c.tutor = ?
    WHERE u.id_usuario = ?";

    $stmt = $conn->prepare($query_centro);
    $stmt->bind_param("ssi", $nombre, $tutor, $id);
    $stmt->execute();

    $query_usuario = "UPDATE usuario u
    SET u.fp = ?
    WHERE u.id_usuario = ?";

    $stmt2 = $conn->prepare($query_usuario);
    $stmt2->bind_param("si", $fp, $id);
    $stmt2->execute();
    
    if($stmt->affected_rows > 0 || $stmt2->affected_rows > 0){
        $mensaje = [
            "message" => "Datos modificados correctamente",
            "code" => "200"
        ];
    }

    echo json_encode($mensaje);
    $stmt->close();
    $stmt2->close();
}