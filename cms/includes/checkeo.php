<?php

// Se revisa si el usuario está logueado y ha completado el formulario de bienvenida

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/includes/security.php");

if(!isLogged()){
    header("LOCATION: /login");
}

if(first_login($_SESSION["user_id"]) === 0){
    header("LOCATION: /datos");
}