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
    $horario = $_POST['horario'];
    $jornada = $_POST['jornada'];

    try {
        // Insertar nueva clase en la base de datos
        $stmt = $pdo->prepare("INSERT INTO Clases (nombre, horario, jornada) VALUES (:nombre, :horario, :jornada)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':jornada', $jornada);
        $stmt->execute();

        echo "Clase agregada exitosamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Clase</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Agregar Clase</h1>
    <form method="post" action="agregar_clase.php">
        <label for="nombre">Nombre de la Clase:</label>
        <input type="text" name="nombre" required><br>

        <label for="horario">Horario:</label>
        <select name="horario" required>
            <option value="Matutino">Matutino</option>
            <option value="Vespertino">Vespertino</option>
        </select><br>

        <label for="jornada">Jornada:</label>
        <select name="jornada" required>
            <option value="Sábado">Sábado</option>
            <option value="Domingo">Domingo</option>
        </select><br>

        <input type="submit" value="Agregar Clase">
    </form>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
