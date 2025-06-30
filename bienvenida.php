<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  header("Location: login.html");
  exit;
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clínica Pediátrica Sonrisitas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/estilo3.css?v=1.0" rel="stylesheet"> 
</head>
<body>

<!-- Estilos personalizados -->

<!-- Confeti generado dinámicamente -->
<?php for ($i = 0; $i < 50; $i++): ?>
  <div class="confetti" style="
  left: <?= rand(0, 100) ?>vw;
  animation-delay: <?= rand(0, 3000) / 1000 ?>s;
  background-color: <?= ['#ff69b4', '#ffc0cb', '#ffb6c1'][rand(0,2)] ?>;
  "></div>
<?php endfor; ?>

<!-- Fondo modal -->
<div class="modal-backdrop-custom"></div>

<!-- Modal centrado y estilizado -->
<div class="d-flex justify-content-center align-items-center position-fixed top-0 start-0 w-100 h-100" style="z-index: 1060;">
  <div class="welcome-box shadow-lg">
  <h1 class="mb-3">¡Bienvenid@!</h1>
  <p class="lead mb-4">
    Hola <strong><?= htmlspecialchars($email) ?></strong>, tu acceso fue exitoso.<br>
    ¡Nos alegra tenerte aquí! 
  </p>
  <div class="d-grid gap-2">
    <a href="admin.php" class="btn btn-primary btn-lg">
    Ir a Administración
    </a>
    <a href="logout.php" class="btn btn-outline-danger btn-lg">
    Cerrar sesión
    </a>
  </div>
  </div>
</div>
</body>
</html>
