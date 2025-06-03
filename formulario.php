<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$host = "mi-bd-formulario.mysql.database.azure.com";
$usuario = "adminuser@mi-bd-formulario";
$contrasena = "Flower0311"; 
$bd = "formulario_db";

$conn = new mysqli($host, $usuario, $contrasena, $bd);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesamiento del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $correo);
    $stmt->execute();
    $stmt->close();
}

// Mostrar formulario y registros
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro</title>
</head>
<body>
    <h1>Formulario</h1>
    <form method="post">
        Nombre: <input type="text" name="nombre" required><br>
        Correo: <input type="email" name="correo" required><br>
        <button type="submit">Enviar</button>
    </form>

    <h2>Registros guardados</h2>
    <?php
    $resultado = $conn->query("SELECT nombre, correo FROM usuarios");
    while ($fila = $resultado->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($fila["nombre"]) . "</strong> – " . htmlspecialchars($fila["correo"]) . "</p>";
    }
    $conn->close();
    ?>
</body>
</html>
