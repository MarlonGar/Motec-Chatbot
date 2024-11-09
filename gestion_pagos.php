<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pagos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Gestión de Pagos</h1>

    <!-- Tabla para mostrar los pagos existentes -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Pago</th>
            <th>Estudiante</th>
            <th>Monto</th>
            <th>Fecha</th>
        </tr>
        <?php
        require 'config.php';
        session_start();

        // Verificar si el usuario tiene rol de Secretaria o Administrador
        if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Secretaria' && $_SESSION['rol'] != 'Administrador')) {
            header("Location: index.php");
            exit;
        }

        // Obtener los pagos desde la base de datos
        $stmt = $pdo->query("SELECT Pagos.*, Estudiantes.nombre AS estudiante_nombre FROM Pagos JOIN Estudiantes ON Pagos.estudiante_id = Estudiantes.id");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['estudiante_nombre']}</td>";
            echo "<td>{$row['monto']}</td>";
            echo "<td>{$row['fecha']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Formulario para agregar nuevos pagos -->
    <h2>Agregar Nuevo Pago</h2>
    <form method="post" action="gestion_pagos.php">
        <label for="estudiante_id">Estudiante:</label>
        <select name="estudiante_id" required>
            <?php
            // Obtener la lista de estudiantes
            $stmt = $pdo->query("SELECT id, nombre FROM Estudiantes");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
            }
            ?>
        </select><br>

        <label for="monto">Monto:</label>
        <input type="number" name="monto" step="0.01" required><br>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required><br>

        <input type="submit" value="Agregar Pago">
    </form>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
