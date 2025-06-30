<?php
// Conexión a base de datos
$servername = "localhost";
$username = "root";
$password = "Edlyn.Perez*1405";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilo1.css?v=1.0" rel="stylesheet">
</head>
<body>
  <!-- Barra de navegación rosada -->
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
            <a class="nav-link nav-link-custom" href="index.html">Inicio 🏠</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="login.php">Inicio Sesión Administrativo📂</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="registro.html">Registro Administrativo📝</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="text-center mt-4 mb-3">
      <h1>Listado de Citas de Pacientes</h1>
  </header>

  <div class="container">
    <?php if (!empty($registros)): ?>
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Edad</th>
                    <th>Motivo de Consulta</th>
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
    <?php else: ?>
        <div class="alert alert-info mt-4">No hay registros disponibles.</div>
    <?php endif; ?>
  </div>

</body>
</html>
