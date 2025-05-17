<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

require_once($dir . "/includes/general.php");
require_once($dir . "/vendor/autoload.php");
include_once($dir . "/cms/includes/showErrors.php");


header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    global $conn;
    $act_lunes = $_POST["act-lunes"];
    $h_lunes = $_POST["h-lunes"];
    $act_martes = $_POST["act-martes"];
    $h_martes = $_POST["h-martes"];
    $act_miercoles = $_POST["act-miercoles"];
    $h_miercoles = $_POST["h-miercoles"];
    $act_jueves = $_POST["act-jueves"];
    $h_jueves = $_POST["h-jueves"];
    $act_viernes = $_POST["act-viernes"];
    $h_viernes = $_POST["h-viernes"];
    $id_ficha = $_POST["id"];
    $modificado = false;

    $respuesta = [
        "message" => "Ocurrió un error.",
        "code" => "500",
    ];

    if(strlen($act_lunes) > 255 || strlen($act_martes) > 255 || strlen($act_miercoles) > 255 || strlen($act_jueves) > 255 || strlen($act_viernes) > 255){
        $respuesta = [
            "message" => "Los textos no pueden contenter más de 210 caracteres.",
            "code" => "500",
        ];
        echo json_encode($respuesta);
        return;
    }

    $actividades = [
        1 => ["actividad" => (!empty($act_lunes)) ? $act_lunes : NULL, "horas" => (!empty($h_lunes)) ? $h_lunes : NULL],
        2 => ["actividad" => (!empty($act_martes)) ? $act_martes : NULL, "horas" => (!empty($h_martes)) ? $h_martes : NULL],
        3 => ["actividad" => (!empty($act_miercoles)) ? $act_miercoles : NULL, "horas" => (!empty($h_miercoles)) ? $h_miercoles : NULL],
        4 => ["actividad" => (!empty($act_jueves)) ? $act_jueves : NULL, "horas" => (!empty($h_jueves)) ? $h_jueves : NULL],
        5 => ["actividad" => (!empty($act_viernes)) ? $act_viernes : NULL, "horas" => (!empty($h_viernes)) ? $h_viernes : NULL],
    ];

    $query = "UPDATE actividades SET actividad = ?, horas = ? WHERE id_dia = ? AND id_ficha = ?";
    $stmt = $conn->prepare($query);

    for($i = 1; $i <= 5; $i++){
        $actividad = $actividades[$i]["actividad"];
        $horas = $actividades[$i]["horas"];
        $stmt->bind_param("siii", $actividad, $horas, $i, $id_ficha);
        $stmt->execute();

        if($stmt->affected_rows > 0){
            $modificado = true;
        }
    }

    if($modificado === true){
        $respuesta = [
            "message" => "Cambios realizados correctamente.",
            "code" => "200",
        ];
    }

    $stmt->close();
    echo json_encode($respuesta);
    exit;
}
