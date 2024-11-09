<?php
require 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM Estudiantes");
    echo "<h1>Lista de Estudiantes</h1>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Estado de Pago</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>{$row['direccion']}</td>";
        echo "<td>{$row['estado_de_pago']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
