<?php

// Se revisa si el usuario está logueado y si es administrador

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");

if(!isLogged()){
    header("LOCATION: login");
}

if(is_admin($_SESSION["user_id"]) === false){
    header("LOCATION: /404");
}