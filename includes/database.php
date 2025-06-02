<?php 

// Parámetros de conexión a la base de datos MariaDB
$server = "127.0.0.1";
$user = "edulog";
$pass = "edulog";
$dbname = "edulog";

// Conexión a MariaDB usando mysqli y verificación de error
$conn = new mysqli($server, $user, $pass, $dbname);

if($conn->connect_error){
    die("Error en la conexión: " . $conn->connect_error);
}
