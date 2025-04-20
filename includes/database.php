<?php 

$server = "192.168.1.130";
$user = "edulog";
$pass = "usu+2010";
$dbname = "edulog";

$conn = new mysqli($server, $user, $pass, $dbname);

if($conn->connect_error){
    die("Error en la conexión: " . $conn->connect_error);
}
