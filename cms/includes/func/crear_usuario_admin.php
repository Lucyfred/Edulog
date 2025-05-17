<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");


header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $conn;
    $email = $_POST["email-usuario"];
    $pass = $_POST["pass-usuario"];
    $password = password_hash($pass, PASSWORD_DEFAULT);
    $rol = $_POST["rol-usuario"] ?? "";
    $mensaje = [
        "message" => "Ocurrió un error",
        "code" => "500"
    ];
    
    if($email == ""){
        $mensaje = [
            "message" => "Por favor rellene el campo email",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mensaje = [
            "message" => "Email no válido",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    if(!$rol){
        $mensaje = [
            "message" => "Por favor rellene el campo rol",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    if($pass == ""){
        $mensaje = [
            "message" => "Por favor rellene el campo contraseña",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        exit;
    }

    $query = "INSERT INTO usuario(email, rol_id, contrasena) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sis", $email, $rol, $password);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $mensaje = [
            "message" => "Usuario creado exitosamente",
            "code" => "200"
        ];
    } else{
        $mensaje = [
            "message" => "Ocurrió un error al intentar crear al usuario",
            "code" => "500"
        ];
    }

    $stmt->close();
    echo json_encode($mensaje);
}