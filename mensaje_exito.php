<?php
$servername = "localhost";
$username = "root";
$password = "Edlyn.Perez*1405";
$dbname = "clinica";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Preparar y vincular
$stmt = $conn->prepare("INSERT INTO pacientes (nombre, cedula, edad, motivo) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $nombre, $cedula, $edad, $motivo);

// Obtener datos del formulario de forma segura
$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$edad = (int)$_POST['edad'];
$motivo = $_POST['motivo'];

// Ejecutar la sentencia
if ($stmt->execute()) {
    echo "Registro guardado exitosamente.";
} else {
    echo "Error al guardar el registro: " . $stmt->error;
}

// Cerrar conexiones
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje de Éxito</title>
    <style>
        .modal {
            display: block;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
        .success-img {
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
        }
    </style>
    <script>
        // Redirigir después de 3 segundos
        setTimeout(function() {
            window.location.href = "index.html";
        }, 3000);
    </script>
</head>
<body>
<?php if (!empty($mensaje)): ?>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('myModal').style.display='none'">&times;</span>
            <img src="img/imagen4.png" alt="Éxito" class="success-img">
            <p><?php echo htmlspecialchars($mensaje); ?></p>
            <p>Redirigiendo en 3 segundos...</p>
        </div>
    </div>
    <script>
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
<?php endif; ?>
</body>
</html>
