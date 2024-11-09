<?php
session_start();

// Si el formulario es enviado, verifica el código ingresado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_ingresado = $_POST['codigo_2fa'];

    // Compara el código ingresado con el código en la sesión
    if ($codigo_ingresado == $_SESSION['2fa_code']) {
        // Código correcto, redirige a la página principal
        header("Location: index.php");
        exit;
    } else {
        $error = "Código incorrecto. Inténtalo de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación 2FA</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <h2>Verificación 2FA</h2>
    <form action="verificar_2fa.php" method="POST">
        <label for="codigo_2fa">Ingresa el código de verificación:</label>
        <input type="text" id="codigo_2fa" name="codigo_2fa" required>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <input type="submit" value="Verificar">
    </form>
</div>
</body>
</html>