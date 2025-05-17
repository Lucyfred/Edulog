<?php

$dir = $_SERVER["DOCUMENT_ROOT"];

include_once($dir . "/includes/general.php");
include_once($dir . "/cms/includes/showErrors.php");


if (!isLogged()) {
    header("LOCATION: login");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json");

    $nombre = $_POST["inp-nombre"] . " " . $_POST["inp-apellidos"] ?? "";
    $apellidos = $_POST["inp-apellidos"] ?? "";
    $fp = $_POST["inp-fp"] ?? "";
    $grado = $_POST["inp-grado"] ?? "";
    $pass = $_POST["inp-pass"] ?? "";
    $password = password_hash($pass, PASSWORD_DEFAULT) ?? "";
    $nombre_esc = $_POST["inp-nombre-esc"] ?? "";
    $tutor_esc = $_POST["inp-tutor-esc"] ?? "";
    $nombre_lab = $_POST["inp-nombre-lab"] ?? "";
    $tutor_lab = $_POST["inp-tutor-lab"] ?? "";
    $id = $_SESSION["user_id"] ?? "";
    $message = ([
        "success" => "false",
        "message" => "Ocurrió un error en el servidor."
    ]);

    if (empty($nombre) || empty($apellidos) || empty($fp) || empty($grado) || empty($pass) || empty($nombre_esc) || empty($tutor_esc) || empty($nombre_lab) || empty($tutor_lab)) {
        $message = ([
            "success" => "false",
            "message" => "Por favor, rellene todos los campos."
        ]);
        echo json_encode($message);
        exit;
    }

    global $conn;

    // Update datos centro
    try {
        $query = "INSERT INTO centro(nombre, tutor, id_usuario) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nombre_esc, $tutor_esc, $id);
        $stmt->execute();
        $id_centro = $conn->insert_id;
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        error_log("Ocurrió un error: " . $e->getMessage());
        $message = ([
            "success" => "false",
            "message" => "Ocurrió un error al actualizar los datos."
        ]);
        echo json_encode($message);
        exit;
    }

    // Update datos laboral
    try {
        $query = "INSERT INTO empresa(nombre, tutor_empresa, id_usuario) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nombre_lab, $tutor_lab, $id);
        $stmt->execute();
        $id_lab = $conn->insert_id;
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        error_log("Ocurrió un error: " . $e->getMessage());
        $message = ([
            "success" => "false",
            "message" => "Ocurrió un error al actualizar los datos." . $e->getMessage()
        ]);
        echo json_encode($message);
        exit;
    }

    // Update datos alumno
    try {
        $query = "UPDATE usuario SET nombre = ?, fp = ?, id_grado = ?, contrasena = ?, id_centro = ?, id_empresa = ?, alta = 1 WHERE id_usuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssisiii", $nombre, $fp, $grado, $password, $id_centro, $id_lab, $id);
        $stmt->execute();
        $stmt->close();
        $message = ([
            "success" => "true",
            "redirect" => "/index"
        ]);
        echo json_encode($message);
        exit;
    } catch (mysqli_sql_exception $e) {
        error_log("Ocurrió un error: " . $e->getMessage());
        $message = ([
            "success" => "false",
            "message" => "Ocurrió un error al actualizar los datos."
        ]);
        echo json_encode($message);
        exit;
    }
}
