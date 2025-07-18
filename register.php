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
    
echo "
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
<link href='css/estilo4.css?v=1.1' rel='stylesheet'>

<div class='container my-5'>
    <div class='row justify-content-center'>
        <div class='col-md-6 text-center'>
            <div class='alert alert-custom d-flex align-items-center justify-content-center position-relative'>
                <i class='bi bi-info-circle-fill me-2 bi-3x icon-beat'></i>
                <div>
                    <h4 class='fw-bold'>$mensaje</h4>
                </div>
                <button type='button' class='btn-close btn-close-white position-absolute top-0 end-0 m-2' data-bs-dismiss='alert'></button>
            </div>
            ".($claseAlerta === "success" ? "
            <div class='my-4 d-flex justify-content-center align-items-center gap-4 flex-wrap'>
                <img src='img/imagen6.png' alt='Icono' style='max-width: 300px; height: auto; border-radius: 10px;'>
                <img src='$qrDataUri' alt='Código QR' class='img-fluid' style='max-width:180px; border: 5px solid var(--mostaza-oscuro); border-radius:10px;'>
            </div>" : "")."
            <a href='login.php' class='btn btn-volver w-100 mt-3'>
                <i class='bi bi-arrow-left-circle me-2'></i>Volver
            </a>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
";


}
?>
