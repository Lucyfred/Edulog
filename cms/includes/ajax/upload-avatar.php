<?php

// session_start();

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");
include_once($dir . "/cms/includes/showErrors.php");


header("Content-Type: application/json");

$location = $dir . "/cms/assets/img/avatar/";
$nombre_avatar = "avatar" . $_SESSION["user_id"];
$extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
$files = glob($location . $nombre_avatar . ".*");
$location_public = "/cms/assets/img/avatar/" . $nombre_avatar . "." . $extension;
$respuesta = [
    "message" => "Ocurrió un error.",
    "code" => "500",
    "url" => ""
];

global $conn;

$query = 'UPDATE usuario SET avatar = "'. $nombre_avatar . "." . $extension . '" WHERE id_usuario = ' . $_SESSION["user_id"];
$stmt = $conn -> query($query);

foreach($files as $file){
    if(is_file($file)){
        unlink($file);
    }
}

if(isset($_FILES["archivo"])){
    move_uploaded_file($_FILES["archivo"]["tmp_name"], $dir . "/cms/assets/img/avatar/" . $nombre_avatar . "." . $extension);
    $respuesta = [
        "message" => "Correcto",
        "code" => "200",
        "url" => $location_public
    ];
    echo json_encode($respuesta);
} else{
    http_response_code(400);
    $respuesta = [
        "message" => "Ocurrió un error.",
        "code" => "500",
        "url" => ""
    ];
    echo json_encode($respuesta);
}