<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar método y existencia de campos
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nombre'], $_POST['cedula'], $_POST['edad'], $_POST['motivo'])) {
    
    // Limpiar y validar entradas
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $edad = trim($_POST['edad']);
    $motivo = trim($_POST['motivo']);

    $errores = [];

    // Validación del nombre (solo letras y espacios)
    if (empty($nombre) || !preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,100}$/u", $nombre)) {
        $errores[] = "Nombre inválido. Solo letras y mínimo 3 caracteres.";
    }

    // Validación de cédula (formato: 00-0000-0000)
    if (!preg_match("/^\d{2}-\d{4}-\d{4}$/", $cedula)) {
        $errores[] = "Cédula inválida. Use el formato 00-0000-0000.";
    }

    // Validación de edad (solo entre 0 y 17)
    if (!filter_var($edad, FILTER_VALIDATE_INT) || $edad < 0 || $edad > 17) {
        $errores[] = "Edad inválida. Debe estar entre 0 y 17 años.";
    }

    // Validación del motivo (no vacío y máximo 255 caracteres)
    if (empty($motivo) || strlen($motivo) > 255) {
        $errores[] = "Motivo inválido. No puede estar vacío ni exceder los 255 caracteres.";
    }

    // Si hay errores, mostrarlos
    if (!empty($errores)) {
        foreach ($errores as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit();
    }

    // Convertir edad a entero
    $edad = (int)$edad;

    // Preparar e insertar
    $stmt = $conn->prepare("INSERT INTO pacientes (nombre, cedula, edad, motivo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nombre, $cedula, $edad, $motivo);

    if ($stmt->execute()) {
        $mensaje = "Registro guardado exitosamente.";
        ?>
        <div id="myModal" class="modal" style="display: block;">
            <div class="modal-content" style="box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37); background: linear-gradient(135deg, #e0ffe8 0%, #f0f9ff 100%);">
                <span class="close" onclick="document.getElementById('myModal').style.display='none'" title="Cerrar">&times;</span>
                <img src="img/imegen4.jpg" alt="Éxito" class="success-img" style="border-radius: 50%; border: 4px solid #efb108ff; box-shadow: 0 4px 12px rgba(175, 149, 76, 0.2);">
                <h2 style="color: #aa7d03ff; margin-bottom: 10px;">¡Éxito!</h2>
                <p style="font-size: 25px; color: #333;"><?php echo htmlspecialchars($mensaje); ?></p>
                <p style="color: #888; font-size: 20px;">Redirigiendo en 3 segundos...</p>
            </div>
        </div>
        <script>
            setTimeout(() => {
                window.location.href = "index.php"; // o donde quieras redirigir
            }, 3000);

            window.onclick = function(event) {
                var modal = document.getElementById('myModal');
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <?php
    } else {
        echo "<p style='color:red;'>Error al guardar el registro: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p style='color:red;'>Acceso no autorizado o campos incompletos.</p>";
}

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
