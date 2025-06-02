<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    global $conn;

    $fecha = $_POST["inp-fecha"];
    $semana = (int)$_POST["inp-semana"];
    $id = $_SESSION["user_id"];
    $respuesta = [
        "message" => "Ocurrió un error.",
        "code" => "500",
    ];
    $dia_semana = date("w", strtotime($fecha));

    if($semana <= 0){
        $respuesta = [
            "message" => "El campo semana tiene que ser superior a 0.",
            "code" => "500",
        ];
        echo json_encode($respuesta);
        return;
    }

    if(empty($fecha) || empty($semana)){
        $respuesta = [
            "message" => "Por favor rellene los campos.",
            "code" => "500",
        ];
        echo json_encode($respuesta);
        return;
    }

    if($dia_semana != 1){
        $respuesta = [
            "message" => "Solo puedes seleccionar los lunes",
            "code" => "500",
        ];
        echo json_encode($respuesta);
        return;
    }

    if(filter_var($semana, FILTER_VALIDATE_INT) === false){
        $respuesta = [
            "message" => "El campo semana solo puede ser numérico.",
            "code" => "500",
        ];
        echo json_encode($respuesta);
        return;
    }

    $query_repetido = "SELECT * FROM ficha WHERE id_alumno = ?";
    $stmt = $conn->prepare($query_repetido);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while($ficha = $result->fetch_assoc()){
        if($ficha["fecha"] == $fecha){
            $respuesta = [
                "message" => "Ya existe una ficha de esa semana",
                "code" => "500",
            ];
            echo json_encode($respuesta);
            return;
        }
        if($ficha["semana"] == $semana){
            $respuesta = [
                "message" => "Ya existe una ficha de ese número semana",
                "code" => "500",
            ];
            echo json_encode($respuesta);
            return;
        }
    }

    $query = "INSERT INTO ficha(id_alumno, fecha, semana) VALUES  (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isi", $id, $fecha, $semana);
    $stmt->execute();

    if($stmt->affected_rows > 0){
        $id_ficha = $stmt->insert_id;
        $stmt->close();

        $query = "INSERT INTO actividades(id_ficha, id_dia) VALUES  (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_ficha, $id_dia);
        for($i = 1; $i <= 5; $i++){
            $id_dia = $i;
            $stmt->execute();
        }

        $query = "SELECT id_ficha, semana, fecha FROM ficha WHERE id_ficha = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_ficha);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos_ficha = $result->fetch_assoc();
        $stmt->close();

        $respuesta = [
            "message" => "Creado correctamente.",
            "code" => "200",
            "datos" => $datos_ficha
        ];
    }

    echo json_encode($respuesta);
}