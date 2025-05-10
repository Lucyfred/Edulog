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
    $nombre = $_POST["inp-nombre"] . " " . $_POST["inp-apellidos"];
    $fp = $_POST["inp-fp"];
    $grado = $_POST["inp-grado"];
    $pass = $_POST["inp-pass"];
    $password = password_hash($pass, PASSWORD_DEFAULT);
    $nombre_esc = $_POST["inp-nombre-esc"];
    $tutor_esc = $_POST["inp-tutor-esc"];
    $nombre_lab = $_POST["inp-nombre-lab"];
    $tutor_lab = $_POST["inp-tutor-lab"];
    $id = $_SESSION["user_id"];

    
    global $conn;

    // Update datos centro
    try{
        $query_select = "SELECT * FROM centro WHERE nombre = ? AND tutor = ?";
        $stmt = $conn->prepare($query_select);
        $stmt->bind_param("ss", $nombre_esc, $tutor_esc);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows > 0){
            $fila = $result->fetch_assoc();
            $id_centro = $fila["id_centro"];
        } else{
            $query = "INSERT INTO centro(nombre, tutor) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $nombre_esc, $tutor_esc);
            $stmt->execute();
            $id_centro = $conn->insert_id;
            $stmt->close();
        }

    } catch (mysqli_sql_exception $e){
        error_log("Ocurrió un error: " . $e->getMessage());
        echo "Ocurrió un error al actualizar los datos." . $e->getMessage();
    }

    // Update datos laboral
    try{
        $query_select = "SELECT * FROM empresa WHERE nombre = ? AND tutor_empresa = ?";
        $stmt = $conn->prepare($query_select);
        $stmt->bind_param("ss", $nombre_lab, $tutor_lab);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if($result->num_rows > 0){
            $fila = $result->fetch_assoc();
            $id_lab = $fila["id_empresa"];
        } else{
            $query = "INSERT INTO empresa(nombre, tutor_empresa) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $nombre_lab, $tutor_lab);
            $stmt->execute();
            $id_lab = $conn->insert_id;
            $stmt->close();
        }
    } catch (mysqli_sql_exception $e){
        error_log("Ocurrió un error: " . $e->getMessage());
        echo "Ocurrió un error al actualizar los datos." . $e->getMessage();
    }

    // Update datos alumno
    try{
        $query = "UPDATE usuario SET nombre = ?, fp = ?, id_grado = ?, contrasena = ?, id_centro = ?, id_empresa = ?, alta = 1 WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssisiii", $nombre, $fp, $grado, $password, $id_centro, $id_lab, $id);
        $stmt->execute();
        $stmt->close();
        header("LOCATION: /index");
    } catch (mysqli_sql_exception $e){
        error_log("Ocurrió un error: " . $e->getMessage());
        echo "Ocurrió un error al actualizar los datos." . $e->getMessage();
    }

    
}