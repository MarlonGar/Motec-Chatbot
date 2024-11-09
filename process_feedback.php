<?php
// process_feedback.php

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "sistema_educativo");

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtén los datos enviados desde JavaScript
$data = json_decode(file_get_contents("php://input"), true);
$feedback = mysqli_real_escape_string($conn, $data['feedback']);

// Inserta la retroalimentación en la base de datos
$sql = "INSERT INTO feedback (respuesta) VALUES ('$feedback')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

// Cierra la conexión
$conn->close();
?>
