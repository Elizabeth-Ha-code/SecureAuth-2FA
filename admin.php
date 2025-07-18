<?php
// Conexión a base de datos
$servername = "localhost";
$username = "root";
$password = "cereza_08";
$dbname = "clinica";

$conn = new mysqli($servername, $username, $password, $dbname);

// Se verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar registros
$sql = "SELECT nombre, cedula, edad, motivo FROM pacientes ORDER BY fecha_registro DESC";
$result = $conn->query($sql);

// Guardar resultados en un array
$registros = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Citas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 4.6.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    
    <!-- Estilos personalizados -->
    <link href="css/estilo1.css?v=1.0" rel="stylesheet">
</head>
<body>

  <!-- Barra de navegación -->
 <!-- Barra de navegación -->
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

  <header class="text-center mt-4 mb-3">
    <h1>Listado de Citas de Pacientes</h1>
  </header>

  <div class="container my-4">
    <?php if (!empty($registros)): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover custom-table">
          <thead class="thead-custom">
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Cédula</th>
              <th scope="col">Edad</th>
              <th scope="col">Motivo de Consulta</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($registros as $registro): ?>
              <tr>
                <td><?= htmlspecialchars($registro["nombre"] ?? "") ?></td>
                <td><?= htmlspecialchars($registro["cedula"] ?? "") ?></td>
                <td><?= htmlspecialchars($registro["edad"] ?? "") ?></td>
                <td><?= htmlspecialchars($registro["motivo"] ?? "") ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-warning custom-alert mt-4" role="alert">
        No hay registros disponibles.
      </div>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS + dependencias -->

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
