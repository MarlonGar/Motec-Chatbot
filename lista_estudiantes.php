<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudiantes</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Lista de Estudiantes</h1>

    <!-- Tabla para mostrar los estudiantes existentes -->
    <table border="1" cellpadding="10" cellspacing="0">
    <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Estado de Pago</th>
            <th>Jornada</th>
            <th>Horario</th>
        </tr>
        <?php
        require 'config.php';
        session_start();

        // Verificar si el usuario tiene rol de Profesor, Administrador o Secretaria
        if (!isset($_SESSION['usuario'])) {
            header("Location: login.php");
            exit;
        }

        // Obtener todos los estudiantes desde la base de datos
        $stmt = $pdo->query("SELECT * FROM Estudiantes");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['direccion']}</td>";
            echo "<td>{$row['estado_de_pago']}</td>";
            echo "<td>{$row['jornada']}</td>";
            echo "<td>{$row['horario']}</td>";
            
            // Permitir la edición de estudiantes solo para Profesores y Administradores
            if ($_SESSION['rol'] == 'Profesor' || $_SESSION['rol'] == 'Administrador') {
                echo "<td><a href='editar_estudiantes.php?id={$row['id']}'>Editar</a></td>";
            }
            echo "</tr>";
        }
        ?>
    </table>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
