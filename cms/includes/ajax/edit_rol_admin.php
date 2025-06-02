<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");

// Cambia el rol del usuario, esta opción solamente es para los administradores

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $conn;
    $id_usuario = (int)$_POST["idUser"];
    $id_rol = (int)$_POST["idRol"];
    $mensaje = [
        "message" => "Ocurrió un error",
        "code" => "500"
    ];
    
    if($id_usuario <= 0 || $id_usuario == "" || $id_rol <= 0 || $id_rol == ""){
        $mensaje = [
            "message" => "Ocurrió un error al intentar editar el rol",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    $query = "UPDATE usuario SET rol_id = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_rol, $id_usuario);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $mensaje = [
            "message" => "Rol modificado exitosamente",
            "code" => "200"
        ];
    } else{
        $mensaje = [
            "message" => "Ocurrió un error al intentar editar el rol",
            "code" => "500"
        ];
    }

    $stmt->close();
    echo json_encode($mensaje);
}