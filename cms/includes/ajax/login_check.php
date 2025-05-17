<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/security.php");

header('Content-Type: application/json');

$resp = ["success" => false, "message" => "Hubo un error, inténtelo de nuevo más tarde."];

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = $_POST["email"];
    $pass = $_POST["passLogin"];

    if(strlen($_POST["email"]) == 0){
        $resp["message"] = "Campo email incompleto";
        echo json_encode($resp);
        exit;
    }

    if(strlen($_POST["passLogin"]) == 0){
        $resp["message"] = "Campo contraseña es obligatorio";
        echo json_encode($resp);
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $resp["message"] = "Campo email inválido";
        echo json_encode($resp);
        exit;
    }

    try{
        $resp = login($email, $pass);
    } catch (Exception $e){
        $resp["message"] = "Error: " . $e->getMessage();
    }

}

echo json_encode($resp);