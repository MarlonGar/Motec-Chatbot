<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $estudiante_id = $_POST['estudiante_id'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];

    try {
        $stmt = $pdo->prepare("INSERT INTO Pagos (estudiante_id, monto, fecha) VALUES (:estudiante_id, :monto, :fecha)");
        $stmt->bindParam(':estudiante_id', $estudiante_id);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();

        echo "Pago agregado exitosamente.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<form method="post" action="agregar_pago.php">
    <label for="estudiante_id">ID Estudiante:</label>
    <input type="text" name="estudiante_id" required><br>
    <label for="monto">Monto:</label>
    <input type="number" step="0.01" name="monto" required><br>
    <label for="fecha">Fecha:</label>
    <input type="date" name="fecha" required><br>
    <input type="submit" value="Agregar Pago">
</form>
