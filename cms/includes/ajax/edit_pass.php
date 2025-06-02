<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");

// Permite al alumno cambiarse su contraseña

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $conn;
    $id_usuario = $_SESSION["user_id"];
    $pass = $_POST["pass"];
    $password = password_hash($pass, PASSWORD_DEFAULT) ?? "";
    $mensaje = [
        "message" => "Ocurrió un error",
        "code" => "500"
    ];
    
    if($id_usuario <= 0 || $id_usuario == ""){
        $mensaje = [
            "message" => "Ocurrió un error al intentar editar la contraseña",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    if($pass == ""){
        $mensaje = [
            "message" => "Contraseña no válida",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    $query = "UPDATE usuario SET contrasena = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $password, $id_usuario);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $mensaje = [
            "message" => "Contraseña cambiada exitosamente",
            "code" => "200"
        ];
    } else{
        $mensaje = [
            "message" => "Ocurrió un error al intentar cambiar la contraseña",
            "code" => "500"
        ];
    }

    $stmt->close();
    echo json_encode($mensaje);
}