<?php

include_once($dir . "/includes/security.php");

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$dominio = $_SERVER['HTTP_HOST'];

$url_site = $protocolo . "://" . $dominio;

/**
 * Revisa si el usuario hizo el primer login
 * @param id - Int - ID del usuario
 * @return bool - Devuelve un booleano
 */
function first_login($id){
    global $conn;

    $query = "SELECT alta
        FROM usuario
        WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $bool = $result->fetch_assoc();

    return $bool["alta"];
}

/**
 * Devuelve todos los datos del usuario a través de su ID
 * @param id - Int - ID del usuario
 * @return array - Devuelve un array con los datos del usuario
 */
function user_info($id){
    global $conn;

    $query = "SELECT *, 
        (SELECT nombre FROM empresa e WHERE e.id_empresa = u.id_empresa) as empresa,
        (SELECT tutor_empresa FROM empresa e WHERE e.id_empresa = u.id_empresa) as tutor,
        (SELECT contacto FROM empresa e WHERE e.id_empresa = u.id_empresa) as contacto 
        FROM usuario u 
        WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->fetch_assoc();
}

/**
 * Revisa si existe un avatar en el usuario
 * @param id - int - ID del usuario
 * @return boolean
 */
function check_avatar($id){
    global $conn;

    $query = "SELECT avatar 
        FROM usuario
        WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $data = $result->fetch_assoc();

    if($data["avatar"] !== NULL){
        return true;
    } else{
        return false;
    }
}

/**
 * Obtiene todos los datos del usuario
 * @param id - Int - ID del usuario
 * @return array - Devuelve un array con todos los datos
 */
function get_student_data($id){
    global $conn;

    $query = "SELECT u.nombre, u.email, u.id_empresa,
    (SELECT nombre FROM empresa e WHERE id_empresa = u.id_empresa) as empresa,
    (SELECT tutor_empresa FROM empresa e WHERE id_empresa = u.id_empresa) as tutor_e,
    (SELECT nombre FROM centro c WHERE id_centro = u.id_centro) as centro,
    (SELECT tutor FROM centro c WHERE id_centro = u.id_centro) as tutor_c
    FROM usuario u
    WHERE id_usuario = ?";
    $stmt = $conn -> prepare($query);

    if (!$stmt) {
        return false;
    }

    $stmt -> bind_param("i", $id);
    $stmt -> execute();
    $result = $stmt -> get_result();
    $stmt -> close();

    return $result->fetch_assoc();
}