<?php

include_once($dir . "/includes/security.php");

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$dominio = $_SERVER['HTTP_HOST'];

$url_site = $protocolo . "://" . $dominio;

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