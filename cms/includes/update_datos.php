<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");

if (!isLogged()) {
    header("LOCATION: login");
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $nombre = $_POST["inp-nombre"];
    $apellidos = $_POST["inp-apellidos"];
    $fp = $_POST["inp-fp"];
    $grado = $_POST["inp-grado"];
    $tutor_esc = $_POST["inp-tutor-esc"];
    $tutor_lab = $_POST["inp-tutor-lab"];
    $pass = $_POST["inp-pass"];

    
}