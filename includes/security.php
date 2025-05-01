<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/database.php");

session_start();

function isLogged(){
    return (int) $_SESSION["user_id"] > 0;
}

/**
 * Revisa si los campos de usuario y contraseña son correctos
 * @param email - string
 * @param pass - string
 * @return boolean
 */
function login($email, $pass){
    global $conn;

    $query = "SELECT * FROM usuario WHERE email = ? AND contrasena = ?";

    $stmt = $conn -> prepare($query);
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if(mysqli_num_rows($result) > 0){
        $data = $result->fetch_assoc();
        $_SESSION["user_id"] = $data["id_usuario"];
        return array("success" => true, "message" => "Login correcto");
    } else{
        return array("success" => false, "message" => "Usuario o contraseña incorrectos");
    }
}

function logOut(){
    session_unset();
    session_destroy();
}