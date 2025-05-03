<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$location = $dir . "/cms/assets/img/avatar/";
$nombre_avatar = "avatar" . $_SESSION["user_id"];
$extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
$files = glob($location . $nombre_avatar . ".*");

foreach($files as $file){
    if(is_file($file)){
        unlink($file);
    }
}

if(isset($_FILES["archivo"])){
    move_uploaded_file($_FILES["archivo"]["tmp_name"], $dir . "/cms/assets/img/avatar/" . $nombre_avatar . "." . $extension);
    return "200";
} else{
    http_response_code(400);
    return "500";
}