<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión - Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

 <link href="css/estilo.css?v=1.0" rel="stylesheet"> 
</head>
<body class="bg-light">

<?php
$message = $_GET['message'] ?? '';
$type = $_GET['type'] ?? '';
?><!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
  <div class="container">
    <a class="navbar-brand navbar-brand-custom" href="index.php">
      CLÍNICA PEDIÁTRICA PEQUEÑINES
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link nav-link-custom" href="index.html">
            <i class="bi bi-house-gear-fill" style="color:#e5760e; font-size:1.7em; filter: drop-shadow(0 2px 6px #ffb6d5);"></i> Inicio
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-custom" href="login.php">
            <i class="bi bi-person-vcard-fill" style="color:#4f8cff; font-size:1.7em; filter: drop-shadow(0 2px 6px #b3d1ff);"></i> Inicio Sesión Administrativo
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-custom" href="registro.html">
            <i class="bi bi-person-plus-fill" style="color:#28a745; font-size:1.7em; filter: drop-shadow(0 2px 6px #a8e6b1);"></i> Registro Administrativo
          </a>
        </li>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br><br>
<div class="container vh-100 d-flex align-items-center justify-content-center">
  <div class="row w-100" style="max-width: 800px;">
    <!-- Columna de la imagen -->
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
      <img src="img/imagen6.png" alt="Imagen de inicio de sesión" class="img-fluid rounded-start" style="max-height:500px;">
    </div>
    <!-- Columna del formulario -->
    <div class="col-md-6">
      <div class="card p-4 shadow w-100 h-100">
        <h3 class="text-center text-pink mb-4">🔐 Iniciar Sesión</h3>
        <form action="procesar_login.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" name="email" placeholder="sara@gmail.com" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" placeholder="********" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Token</label>
            <input type="text" class="form-control" name="codigo" placeholder="6 dígitos" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-main"> Acceder </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal opcional -->
<?php if ($message): ?>
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">Aviso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="alert <?php echo htmlspecialchars($type); ?>">
          <?php echo htmlspecialchars($message); ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script>
  <?php if ($message): ?>
    document.addEventListener('DOMContentLoaded', function () {
      var myModal = new bootstrap.Modal(document.getElementById('messageModal'), {
        keyboard: false
      });
      myModal.show();
    });
  <?php endif; ?>
</script>

</body>
</html>
