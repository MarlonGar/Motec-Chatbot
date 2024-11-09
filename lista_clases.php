<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clases</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Lista de Clases</h1>

    <!-- Tabla para mostrar las clases existentes -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Clase</th>
            <th>Nombre</th>
            <th>Horario</th>
            <th>Jornada</th>
        </tr>
        <?php
        require 'config.php';
        session_start();

        // Verificar si el usuario tiene rol de Profesor o Administrador
        if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Profesor' && $_SESSION['rol'] != 'Administrador')) {
            header("Location: index.php");
            exit;
        }

        // Obtener las clases desde la base de datos
        $stmt = $pdo->query("SELECT * FROM Clases");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['horario']}</td>";
            echo "<td>{$row['jornada']}</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
