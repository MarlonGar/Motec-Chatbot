<?php
require 'config.php';
session_start();

// Verificar si el usuario tiene rol de Profesor o Administrador
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Profesor' && $_SESSION['rol'] != 'Administrador')) {
    header("Location: lista_estudiantes.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener la información del estudiante
    $stmt = $pdo->prepare("SELECT * FROM Estudiantes WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $estado_de_pago = $_POST['estado_de_pago'];
        $jornada = $_POST['jornada'];
        $horario = $_POST['horario'];

        // Actualizar información del estudiante
        $stmt = $pdo->prepare("UPDATE Estudiantes SET nombre = :nombre, direccion = :direccion, estado_de_pago = :estado_de_pago, jornada = :jornada, horario = :horario WHERE id = :id");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':estado_de_pago', $estado_de_pago);
        $stmt->bindParam(':jornada', $jornada);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo "Información actualizada correctamente.";
        header("Location: lista_estudiantes.php");
        exit;
    }
} else {
    echo "Estudiante no encontrado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Editar Estudiante</h1>
    <form method="post" action="editar_estudiantes.php?id=<?php echo $_GET['id']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $estudiante['nombre']; ?>" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo $estudiante['direccion']; ?>" required><br>

        <label for="estado_de_pago">Estado de Pago:</label>
        <select name="estado_de_pago" required>
            <option value="Al dia" <?php if ($estudiante['estado_de_pago'] == 'Al dia') echo 'selected'; ?>>Al día</option>
            <option value="Atrasado" <?php if ($estudiante['estado_de_pago'] == 'Atrasado') echo 'selected'; ?>>Atrasado</option>
        </select><br>

        <label for="jornada">Jornada:</label>
        <select name="jornada" required>
            <option value="Sábado" <?php if ($estudiante['jornada'] == 'Sábado') echo 'selected'; ?>>Sábado</option>
            <option value="Domingo" <?php if ($estudiante['jornada'] == 'Domingo') echo 'selected'; ?>>Domingo</option>
        </select><br>

        <label for="horario">Horario:</label>
        <select name="horario" required>
            <option value="Matutino" <?php if ($estudiante['horario'] == 'Matutino') echo 'selected'; ?>>Matutino</option>
            <option value="Vespertino" <?php if ($estudiante['horario'] == 'Vespertino') echo 'selected'; ?>>Vespertino</option>
        </select><br>

        <input type="submit" value="Guardar Cambios">
    </form>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

</body>
</html>
