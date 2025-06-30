<?php
$host = "localhost";
$user = "root";
$password = "Edlyn.Perez*1405";
$database = "clinica";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
