<?php
require 'config.php';
session_start();

// Verificar si el usuario tiene rol de Administrador o Secretaria
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Secretaria' && $_SESSION['rol'] != 'Administrador')) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $estado_de_pago = $_POST['estado_de_pago'];
    $jornada = $_POST['jornada'];
    $horario = $_POST['horario'];

    try {
        // Insertar nuevo estudiante en la base de datos
        $stmt = $pdo->prepare("INSERT INTO Estudiantes (nombre, direccion, estado_de_pago, jornada, horario) 
                               VALUES (:nombre, :direccion, :estado_de_pago, :jornada, :horario)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':estado_de_pago', $estado_de_pago);
        $stmt->bindParam(':jornada', $jornada);
        $stmt->bindParam(':horario', $horario);
        $stmt->execute();

        echo "Estudiante agregado exitosamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Estudiante</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Agregar Estudiante</h1>
    <form method="post" action="agregar_estudiante.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" required><br>

        <label for="estado_de_pago">Estado de Pago:</label>
        <select name="estado_de_pago" required>
            <option value="Al dia">Al día</option>
            <option value="Atrasado">Atrasado</option>
        </select><br>

        <label for="jornada">Jornada:</label>
        <select name="jornada" required>
            <option value="Sábado">Sábado</option>
            <option value="Domingo">Domingo</option>
        </select><br>

        <label for="horario">Horario:</label>
        <select name="horario" required>
            <option value="Matutino">Matutino</option>
            <option value="Vespertino">Vespertino</option>
        </select><br>

        <input type="submit" value="Agregar Estudiante">
    </form>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
