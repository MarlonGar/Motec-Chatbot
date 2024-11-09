<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $respuesta = $_POST['suma'];

    // Verificar la respuesta de la suma
    if ($respuesta != $_SESSION['respuesta_correcta']) {
        $_SESSION['error_respuesta'] = true;
        header("Location: login.php"); // Redirige de vuelta al login si la respuesta es incorrecta
        exit();
    }

    // Si la respuesta es correcta, eliminar el error de sesión
    unset($_SESSION['error_respuesta']);

    // Aquí deberías verificar las credenciales del usuario con la base de datos
    // Ejemplo básico:
    if ($username === "admin" && $password === "1234") {
        // Credenciales correctas
        header("Location: index.php"); // Redirige al usuario a la página principal
        exit();
    } else {
        // Credenciales incorrectas
        echo "Usuario o contraseña incorrectos.";
    }
}
