<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <!-- Logo de la empresa -->
    <div class="logo">
        <img src="motec.jpg" alt="Logo MOTEC">
    </div>
    
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?>!</h1>
    <h2>Menú Principal</h2>

    <ul>
        <li><a href="lista_estudiantes.php">Estudiantes</a></li>

        <?php if ($rol == 'Profesor' || $rol == 'Administrador'): ?>
            <li><a href="lista_clases.php">Clases</a></li>
        <?php endif; ?>

        <?php if ($rol == 'Secretaria'): ?>
            <li><a href="agregar_estudiante.php">Agregar estudiante</a></li>
        <?php endif; ?>

        <?php if ($rol == 'Secretaria' || $rol == 'Administrador'): ?>
            <li><a href="gestion_pagos.php">Gestión de pagos</a></li>
            <li><a href="capacitacion_personal.php">Capacitación del personal</a></li>
        <?php endif; ?>

        <?php if ($rol == 'Administrador'): ?>
            <li><a href="agregar_profesor.php">Agregar Profesor</a></li>
            <li><a href="agregar_clase.php">Agregar Clase</a></li>
	        <li><a href="agregar_estudiante.php">Agregar Estudiante</a></li>
            <li><a href="agregar_usuario.php">Agregar Usuario</a></li>
        <?php endif; ?>
    </ul>

    <form method="post" action="logout.php">
        <input type="submit" value="Cerrar sesión">
    </form>

</div>
</body>
</html>



