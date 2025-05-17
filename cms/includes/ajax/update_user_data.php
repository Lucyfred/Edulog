<?php 

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");
include_once($dir . "/cms/includes/showErrors.php");


header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $conn;
    $nombre = $_POST["inp-nombre-usuario"];
    $email = $_POST["inp-email-usuario"];
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
            "message" => "El campo no puede contener más de 100 caracteres",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    if(strlen($email) === 0){
        $mensaje = [
            "message" => "Por favor rellene el campo email",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $mensaje = [
            "message" => "El formato del email introducido no es correcto",
            "code" => "500"
        ];
        echo json_encode($mensaje);
        return;
    }

    $query = "UPDATE usuario SET nombre = ?, email = ? WHERE id_usuario = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $nombre, $email, $id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0){
        $mensaje = [
            "message" => "Datos modificados correctamente",
            "code" => "200"
        ];
    }

    echo json_encode($mensaje);
    $stmt->close();
}