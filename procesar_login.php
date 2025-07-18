<?php
require_once __DIR__ . '/vendor/autoload.php';
include "db.php"; // Conexión a la base de datos

use RobThree\Auth\TwoFactorAuth;

session_start();
$mensaje = "";
$claseAlerta = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $passwordRaw = $_POST['password'] ?? '';
    $codigo2FA = $_POST['codigo'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "❌ El correo ingresado no es válido.";
        $claseAlerta = "alert-danger";
    } elseif (empty($passwordRaw) || empty($codigo2FA)) {
        $mensaje = "❌ Todos los campos son obligatorios.";
        $claseAlerta = "alert-danger";
    } else {
        $stmt = $conn->prepare("SELECT id, password, secret FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hashedPassword, $secret);
            $stmt->fetch();

            if (password_verify($passwordRaw, $hashedPassword)) {
                $tfa = new TwoFactorAuth('Mi Sitio');
                if ($tfa->verifyCode($secret, $codigo2FA)) {
                    $_SESSION['usuario_id'] = $id;
                    $_SESSION['email'] = $email;
                    $mensaje = "✅ Login exitoso .";
                    $claseAlerta = "alert-success";
                    
                        header("Location: bienvenida.php");
                        exit;
                  
                    
                } else {
                    $mensaje = "❌ Código de verificación 2FA incorrecto.";
                    $claseAlerta = "alert-danger";
                }
            } else {
                $mensaje = "❌ Contraseña incorrecta.";
                $claseAlerta = "alert-danger";
            }
        } else {
            $mensaje = "❌ Este correo no está registrado.";
            $claseAlerta = "alert-danger";
        }
    }

    header("Location: login.php?message=" . urlencode($mensaje) . "&type=" . urlencode($claseAlerta));
    exit;
}
?>
