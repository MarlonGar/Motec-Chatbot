<?php
session_start();
require 'config.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userInput = strtolower(trim($_POST['message']));

    $response = '';

    // Definir respuestas basadas en palabras clave
    if (strpos($userInput, 'ayuda') !== false || strpos($userInput, 'guía') !== false) {
        $response = '¿En qué área necesitas ayuda? Puedes preguntar sobre procesos de registro, pago o calificaciones.';
    } elseif (strpos($userInput, 'registro') !== false) {
        $response = 'Para registrarte, dirígete a la sección "Registro de Usuario". Sigue las instrucciones en pantalla para completar tu registro.';
    } elseif (strpos($userInput, 'pago') !== false) {
        $response = 'Para realizar pagos, ve a la sección "Gestión de Pagos". Ahí podrás ver el estado de tus pagos y realizar abonos.';
    } elseif (strpos($userInput, 'calificaciones') !== false) {
        $response = 'En "Gestión Académica" podrás consultar tus calificaciones. Si tienes dudas, comunícate con el profesor encargado.';
    } else {
        $response = 'Hola, Escribe una de las siguientes opciones para ayudarte:
        ayuda, registro, pago, calificaciones';
    }

    // Obtener el nombre del usuario de la sesión o establecer como 'anonimo' si no está disponible
    $usuario = $_SESSION['usuario'] ?? 'anonimo';

    // Guardar en la base de datos el mensaje del usuario y la respuesta del asistente
    try {
        $stmt = $pdo->prepare("INSERT INTO feedback (usuario, mensaje_usuario, respuesta_asistente, fecha_hora) VALUES (:usuario, :mensaje_usuario, :respuesta_asistente, NOW())");
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':mensaje_usuario', $userInput);
        $stmt->bindParam(':respuesta_asistente', $response);
        $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode(['response' => 'Error al guardar el mensaje en la base de datos: ' . $e->getMessage()]);
        exit;
    }

    // Enviar la respuesta al frontend
    echo json_encode(['response' => $response]);
}
