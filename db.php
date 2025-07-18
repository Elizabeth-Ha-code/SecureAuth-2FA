<?php
$host = "localhost";
$user = "root";
$password = "cereza_08";
$database = "clinica";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
