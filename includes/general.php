<?php

include_once($dir . "/includes/security.php");

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$dominio = $_SERVER['HTTP_HOST'];

$url_site = $protocolo . "://" . $dominio;

/**
 * Revisa si el usuario es admin
 * @param id - Int - ID del usuario
 * @return bool - Devuelve un booleano
 */
function is_admin($id){
    global $conn;

    $query = "SELECT rol_id
        FROM usuario
        WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $bool = $result->fetch_assoc();

    if($bool["rol_id"] === 1){
        return true;
    } else{
        return false;
    }
}

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
        (SELECT tutor_empresa FROM empresa e WHERE e.id_empresa = u.id_empresa) as tutor_empresa,
        (SELECT nombre FROM centro c WHERE c.id_centro = u.id_centro) as centro,
        (SELECT tutor FROM centro c WHERE c.id_centro = u.id_centro) as tutor_centro
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

    $query = "SELECT u.id_usuario, u.nombre, u.email, u.id_empresa, fp,
    (SELECT nombre FROM empresa e WHERE id_empresa = u.id_empresa) as empresa,
    (SELECT tutor_empresa FROM empresa e WHERE id_empresa = u.id_empresa) as tutor_e,
    (SELECT nombre FROM centro c WHERE id_centro = u.id_centro) as centro,
    (SELECT tutor FROM centro c WHERE id_centro = u.id_centro) as tutor_c,
    (SELECT nombre FROM grado g WHERE id_grado = u.id_grado) as grado
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

/**
 * Obtiene todas las fichas del alumno
 * @param id - Int - ID del alumno
 * @return array - Devuelve un array con las fichas
 */
function get_fichas($id){
    global $conn;

    $query = "SELECT * FROM ficha WHERE id_alumno = ? ORDER BY semana ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fichas = [];

    while ($ficha = $result->fetch_assoc()) {
        $fichas[] = $ficha;
    }

    return $fichas;
}

function fecha_normal($fecha){
    $fecha_mod = explode("-", $fecha);
    $fecha_new = $fecha_mod[2] . "/" . $fecha_mod[1] . "/" . $fecha_mod[0];
    return $fecha_new;
}

function fecha_normal_hora($fecha){
    $fecha_mod = date("d/m/Y H:i:s", strtotime($fecha));
    return $fecha_mod;
}

/**
 * Hace la suma de todas las horas de la semana seleccionada y devuelve las horas totales
 * @param id - Int - ID de la ficha
 * @return Int - Retorna la cantidad de horas
 */
function get_horas_semana($id){
    global $conn;

    $query = "SELECT horas FROM actividades WHERE id_ficha = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_horas = 0;

    while($hora = $result->fetch_assoc()){
        $total_horas += $hora["horas"];
    }

    return $total_horas;
}

/**
 * Revisa el rol del usuario
 * @param id - Int - ID del usuario
 * @return int - Retorna el id del rol
 */
function rol($id){
    global $conn;

    $query = "SELECT rol_id FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rol = $result->fetch_assoc()["rol_id"];

    return $rol;
}

/**
 * Devuelve todos los centros
 * @return array - Array con todas las fichas
 */
function get_all_schools(){
    global $conn;

    $query = "SELECT id_centro, nombre
    FROM centro";
    $stmt = $conn->query($query);
    $centros = [];

    while($centro = $stmt->fetch_assoc()){
        $centros[] = $centro;
    }

    return $centros;
}


/**
 * Devuelve todos los alumnos según el centro
 * @param centro - Int - ID del centro
 * @return array - Array con todas las fichas
 */
function get_all_students($centro){
    global $conn;

    $query = "SELECT id_usuario, nombre
    FROM usuario
    WHERE rol_id = 3
    AND id_centro = ?
    ORDER BY nombre ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $centro);
    $stmt->execute();
    $result = $stmt->get_result();
    $alumnos = [];

    while($alumno = $result->fetch_assoc()){
        $alumnos[] = $alumno;
    }

    return $alumnos;
}

/**
 * Devuelve todas las fichas para el usuario administrador
 * @param id - Int -ID del alumno
 * @return array - Array con todas las fichas
 */
function get_all_sheets($id){
    global $conn;

    $query = "SELECT *
    FROM ficha f
    WHERE id_alumno = ?
    ORDER BY semana ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fichas = [];

    while($ficha = $result->fetch_assoc()){
        $fichas[] = $ficha;
    }

    return $fichas;
}

/**
 * Devuelve todas las fichas según filtro
 * @param id - Int -ID del alumno
 * @return array - Array con todas las fichas
 */
function get_all_sheets_filter($id){
    global $conn;

    $query = "SELECT *
    FROM ficha f
    WHERE id_alumno = ?
    ORDER BY fecha_creacion DESC
    LIMIT 4";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fichas = [];

    while($ficha = $result->fetch_assoc()){
        $fichas[] = $ficha;
    }

    return $fichas;
}

/**
 * Devuelve todos los usuarios
 * @param centro - Int - ID del centro
 * @return array - Array con todas las fichas
 */
function get_all_users(){
    global $conn;
    $id_usuario = $_SESSION["user_id"];

    $query = "SELECT u.id_usuario, u.nombre, u.email, u.rol_id,
    r.nombre as nombre_rol,
    c.nombre as nombre_centro,
    e.nombre as nombre_empresa
    FROM usuario u
    INNER JOIN rol r ON u.rol_id = r.id_rol
    INNER JOIN centro c ON u.id_centro = c.id_centro
    INNER JOIN empresa e ON u.id_empresa = e.id_empresa
    WHERE u.id_usuario != 1
    AND u.alta = 1
    ORDER BY nombre ASC";
    $stmt = $conn->query($query);
    $usuarios = [];

    while($usuario = $stmt->fetch_assoc()){
        $usuarios[] = $usuario;
    }

    return $usuarios;
}

/**
 * Devuelve todos los usuarios que aún no rellenaron la ficha de alta
 * @return array - Array con todos los usuarios
 */
function get_all_users_nr(){
    global $conn;

    $query = "SELECT u.id_usuario, u.email, u.rol_id,
    r.nombre as nombre_rol
    FROM usuario u
    INNER JOIN rol r ON u.rol_id = r.id_rol
    WHERE u.id_usuario != 1
    AND u.alta = 0
    ORDER BY u.nombre ASC";
    $stmt = $conn->query($query);
    $usuarios = [];

    while($usuario = $stmt->fetch_assoc()){
        $usuarios[] = $usuario;
    }

    return $usuarios;
}

/**
 * Devuelve todos roles
 * @param centro - Int - ID del centro
 * @return array - Array con todas las fichas
 */
function get_all_rols(){
    global $conn;

    $query = "SELECT *
    FROM rol
    ORDER BY nombre ASC";
    $stmt = $conn->query($query);
    $roles = [];

    while($rol = $stmt->fetch_assoc()){
        $roles[] = $rol;
    }

    return $roles;
}

/**
 * Devuelve los último usuario logueados
 * @return array - Devuelve un array con los datos de los usuarios
 */
function last_login_users_list(){
    global $conn;

    $query = "SELECT u.nombre, u.email, u.last_login,
        (SELECT nombre FROM centro c WHERE u.id_centro = c.id_centro) AS centro,
        (SELECT nombre FROM empresa e WHERE u.id_empresa = e.id_empresa) AS empresa
        FROM usuario u 
        WHERE u.id_usuario != 1
        ORDER BY u.last_login DESC
        LIMIT 6";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $users = [];

    while($user = $result->fetch_assoc()){
        $users[] = $user;
    }

    return $users;
}