<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Capacitación del Personal</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Capacitación del Personal</h1>

    <!-- Tabla para mostrar las capacitaciones existentes -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nombre del Personal</th>
            <th>Capacitación</th>
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

        // Obtener las capacitaciones desde la base de datos
        $stmt = $pdo->query("SELECT * FROM Capacitacion");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nombre_personal']}</td>";
            echo "<td>{$row['capacitacion']}</td>";
            echo "<td>{$row['fecha']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Formulario para agregar nueva capacitación -->
    <h2>Agregar Capacitación</h2>
    <form method="post" action="capacitacion_personal.php">
        <label for="nombre_personal">Nombre del Personal:</label>
        <input type="text" name="nombre_personal" required><br>

        <label for="capacitacion">Capacitación:</label>
        <input type="text" name="capacitacion" required><br>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required><br>

        <input type="submit" value="Agregar Capacitación">
    </form>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
