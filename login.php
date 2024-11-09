<?php
require 'config.php';
session_start();

// Incluye PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';

// Generar dos números aleatorios entre 1 y 10 solo cuando se carga la página por primera vez
if (!isset($_POST['suma'])) {
    $_SESSION['numero1'] = rand(1, 10);
    $_SESSION['numero2'] = rand(1, 10);
    $_SESSION['respuesta_correcta'] = $_SESSION['numero1'] + $_SESSION['numero2'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    $respuesta = $_POST['suma'];

    // Verificar si la respuesta de la suma es correcta
    if ($respuesta != $_SESSION['respuesta_correcta']) {
        $error_respuesta = true;
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE nombre = :nombre");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['usuario'] = $user['nombre'];
                    $_SESSION['rol'] = $user['rol'];

                    // Generar y guardar el código 2FA
                    $codigo_2fa = rand(100000, 999999);
                    $_SESSION['2fa_code'] = $codigo_2fa;

                    // Enviar el correo usando PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host = 'localhost';
                        $mail->SMTPAuth = false;
                        $mail->Port = 25;

                        $mail->setFrom('no-reply@motec.com', 'MOTEC');
                        $mail->addAddress($user['email']);

                        $mail->isHTML(true);
                        $mail->Subject = 'Codigo de verificacion 2FA para MOTEC';
                        $mail->Body = 'Tu codigo de verificacion es: ' . $codigo_2fa;

                        $mail->send();

                        header("Location: verificar_2fa.php");
                        exit;
                    } catch (Exception $e) {
                        $error_login = "Error al enviar el correo de verificación: " . $mail->ErrorInfo;
                    }
                } else {
                    $error_login = "Contraseña incorrecta.";
                }
            } else {
                $error_login = "Usuario no encontrado.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="motec.jpg" alt="Logo MOTEC">
    </div>
    
    <h1>Iniciar Sesión</h1>
    <form method="post" action="login.php">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <button type="button" id="togglePassword">Mostrar contraseña</button><br>
            
        <label for="suma">¿Cuánto es <?php echo $_SESSION['numero1']; ?> + <?php echo $_SESSION['numero2']; ?>?</label>
        <input type="number" name="suma" required><br>

        <?php if (isset($error_respuesta)): ?>
            <div class="error-message">Respuesta Incorrecta</div>
        <?php endif; ?>

        <?php if (isset($error_login)): ?>
            <div class="error-message"><?php echo $error_login; ?></div>
        <?php endif; ?>

        <input type="submit" value="Iniciar Sesión">
    </form>
</div>

<script>
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

<!-- Asistente Virtual -->
<div id="chatbot-container" class="minimizado">
    <div id="chatbot-header" onclick="toggleChatbot()">Asistente Virtual</div>
    <div id="chatbot-messages"></div>
    <input type="text" id="user-input" placeholder="Escribe un mensaje...">
    <button onclick="sendMessage()">Enviar</button>
</div>

<style>
    #chatbot-container {
        position: fixed;
        bottom: 10px;
        right: 10px;
        width: 300px;
        background-color: #f1f1f1;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    }
    #chatbot-header {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        cursor: pointer;
    }
    #chatbot-messages {
        height: 200px;
        padding: 10px;
        overflow-y: auto;
        background-color: white;
        display: none; /* Se oculta inicialmente */
    }
    #user-input {
        width: 80%;
        padding: 10px;
        border: none;
    }
    .minimizado #chatbot-messages, .minimizado #user-input, .minimizado button {
        display: none;
    }
</style>

<script>
    function toggleChatbot() {
        var chatbotContainer = document.getElementById("chatbot-container");
        chatbotContainer.classList.toggle("minimizado");
        var messages = document.getElementById("chatbot-messages");
        if (chatbotContainer.classList.contains("minimizado")) {
            messages.style.display = "none";
        } else {
            messages.style.display = "block";
        }
    }

    function sendMessage() {
        var message = document.getElementById("user-input").value;
        document.getElementById("user-input").value = '';

        var messageContainer = document.createElement("div");
        messageContainer.innerHTML = "<strong>Usuario:</strong> " + message;
        document.getElementById("chatbot-messages").appendChild(messageContainer);

        fetch("chatbot.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "message=" + encodeURIComponent(message)
        })
        .then(response => response.json())
        .then(data => {
            var botResponse = document.createElement("div");
            botResponse.innerHTML = "<strong>Asistente:</strong> " + data.response;
            document.getElementById("chatbot-messages").appendChild(botResponse);
            document.getElementById("chatbot-messages").scrollTop = document.getElementById("chatbot-messages").scrollHeight;
        })
        .catch(error => console.error("Error:", error));
    }
</script>

</body>
</html>
