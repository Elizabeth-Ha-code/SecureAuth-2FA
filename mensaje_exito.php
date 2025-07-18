<?php
$servername = "localhost";
$username = "root";
$password = "cereza_08";
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
    // Mostrar modal solo si el registro fue exitoso
    if ($stmt && $stmt->affected_rows > 0): 
        $mensaje = "Registro guardado exitosamente.";
        ?>
        <div id="myModal" class="modal">
            <div class="modal-content" style="box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); background: linear-gradient(135deg, #e0ffe8 0%, #f0f9ff 100%);">
            <span class="close" onclick="document.getElementById('myModal').style.display='none'" title="Cerrar">&times;</span>
            <img src="img/imegen4.jpg" alt="Éxito" class="success-img" style="border-radius: 50%; border: 4px solid #efb108ff; box-shadow: 0 4px 12px rgba(175, 149, 76, 0.2);">
            <h2 style="color: #aa7d03ff; margin-bottom: 10px;">¡Éxito!</h2>
            <p style="font-size: 25px; color: #333;"><?php echo htmlspecialchars($mensaje); ?></p>
            <p style="color: #888; font-size: 20px;">Redirigiendo en 3 segundos...</p>
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
        <?php
    endif;
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

</body>
</html>
