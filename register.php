<?php
require_once __DIR__ . '/vendor/autoload.php';  // Asegúrate de que este archivo existe
include "db.php";  // Conexión a la base de datos

use RobThree\Auth\TwoFactorAuth;

$mensaje = "";
$claseAlerta = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir datos del formulario
    $email = $_POST['email'] ?? '';
    $passwordRaw = $_POST['password'] ?? '';
    $password = password_hash($passwordRaw, PASSWORD_BCRYPT);  // Encriptar contraseña

    // Verificar si el correo ya está registrado
    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Si el correo ya está registrado
        $mensaje = "¡Este correo ya está registrado!";
        $claseAlerta = "danger";
    } else {
        // Si el correo no está registrado, proceder a crear el usuario y el secreto
        $tfa = new TwoFactorAuth("MiAplicacion", 6, 30, 'sha1');  // Configurar 2FA

        // Crear un secreto y obtener el código QR
        $secret = $tfa->createSecret();
        $qrDataUri = $tfa->getQRCodeImageAsDataUri("$email", $secret);  // Generar imagen QR como URI de datos

        // Insertar el usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (email, password, secret) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $password, $secret);
        $stmt->execute();

        // Mensaje de éxito
        $mensaje = "¡Registro exitoso! Escanea el código QR con Google Authenticator 💕";
        $claseAlerta = "success";
    }

    // Mostrar resultado (mensaje y código QR si aplica)
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo " <link href='css/estilo.css?v=1.0' rel='stylesheet' >";
    echo "<div class='container mt-5'><div class='row justify-content-center'><div class='col-md-6'>";
    echo "<div class='alert alert-$claseAlerta text-center'>$mensaje</div>";
    if ($claseAlerta === "success") {
        echo "<div class='text-center mb-3'><img src='$qrDataUri' alt='Código QR'></div>";
    }
    echo "<a href='registro.html' class='btn btn-primary w-100'>⬅️ Volver</a>";
    echo "</div></div></div>";
}
?>
