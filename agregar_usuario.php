<?php
require 'config.php';
session_start();

// Verificar si el usuario tiene rol de Secretaria o Administrador
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Secretaria' && $_SESSION['rol'] != 'Administrador')) {
    // Redireccionar si no tienen permiso
    header("Location: login.php");
    exit;
}

$mensaje = ""; // Variable para almacenar mensajes

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $password = $_POST['password'];
    $email = $_POST['email']; // Capturar el correo electrónico del formulario

    // Verificar si la contraseña cumple con los requisitos de seguridad
    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Agregar el campo email en la consulta SQL
            $stmt = $pdo->prepare("INSERT INTO Usuarios (nombre, rol, password, email) VALUES (:nombre, :rol, :password, :email)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email); // Vincular el parámetro email
            $stmt->execute();

            $mensaje = "Usuario agregado exitosamente.";
        } catch (PDOException $e) {
            $mensaje = "Error: " . $e->getMessage();
        }
    } else {
        $mensaje = "La contraseña no cumple con los requisitos de seguridad.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>Agregar Usuario</h1>
    <form method="post" action="agregar_usuario.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required><br> <!-- Nuevo campo para el correo -->

        <label for="rol">Rol:</label>
        <select name="rol" required>
            <option value="Profesor">Profesor</option>
            <option value="Administrador">Administrador</option>
            <option value="Secretaria">Secretaria</option>
        </select><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>
        <div id="password-requirements" style="color: black; font-size: 0.9em; margin-top: 10px;">
            Debe cumplir con los siguientes requisitos:
            <ul>
                <li>Al menos 8 caracteres.</li>
                <li>Al menos una letra mayúscula.</li>
                <li>Al menos una letra minúscula.</li>
                <li>Al menos un número.</li>
                <li>Al menos un carácter especial.</li>
            </ul>
        </div><br>

        <!-- Botón para mostrar/ocultar la contraseña -->
        <button type="button" id="togglePassword" class="show-password">Mostrar Contraseña</button><br>

        <input type="submit" value="Agregar Usuario">
    </form>

    <!-- Mensaje de éxito o error debajo del botón -->
    <?php if ($mensaje != ""): ?>
        <p class="mensaje"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <button onclick="window.location.href='index.php';">Menú</button>
</div>

<script>
    // Función para mostrar/ocultar la contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            this.textContent = 'Ocultar Contraseña';
        } else {
            passwordField.type = 'password';
            this.textContent = 'Mostrar Contraseña';
        }
    });
</script>

</body>
</html>
