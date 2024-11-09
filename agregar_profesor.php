<?php
require 'config.php';
session_start();

// Verificar si el usuario tiene rol de Administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Administrador') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $clase_asignada = $_POST['clase_asignada'];

    try {
        // Insertar nuevo profesor en la base de datos
        $stmt = $pdo->prepare("INSERT INTO Profesores (nombre, clase_asignada) VALUES (:nombre, :clase_asignada)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':clase_asignada', $clase_asignada);
        $stmt->execute();

        echo "Profesor agregado exitosamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Profesor</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Agregar Profesor</h1>
    <form method="post" action="agregar_profesor.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="clase_asignada">Clase Asignada:</label>
        <select name="clase_asignada" required>
            <?php
            // Obtener las clases disponibles desde la base de datos
            require 'config.php';
            $stmt = $pdo->query("SELECT id, nombre FROM Clases");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Agregar Profesor">
    </form>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
