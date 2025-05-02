<?php

 // --- Datos de conexión a la base de datos ---
 $servername = "localhost"; // Reemplaza con tu DB_HOST
 $username = "u360954448_formulario_php";     // Reemplaza con tu DB_USER
 $password = "Tatunis2616_"; // Reemplaza con tu DB_PASSWORD
 $dbname = "u360954448_formulario_php";          // Reemplaza con tu DB_NAME

 $conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['email']);
    $opcion = $conn->real_escape_string($_POST['opcion']);
    $mensaje = $conn->real_escape_string($_POST['mensaje']);
    $fecha_creacion = date("Y-m-d H:i:s");

    $sql = "INSERT INTO contactos (nombre, email, mensaje, opcion, fecha_creacion) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $mensaje, $opcion);

    if ($stmt->execute()) {
        // Éxito al guardar en la base de datos
        // No necesitamos imprimir un mensaje aquí si vamos a redirigir
    } else {
        // Error al guardar en la base de datos
        echo "Ocurrió un error al guardar tu mensaje. Por favor, intenta nuevamente.";
        exit();
    }

    // --- Código para enviar el correo electrónico ---
    $destinatario = "contacto.facumoyano@gmail.com"; // Reemplaza con tu dirección de correo
    $asunto = "Nuevo mensaje de contacto desde tu sitio web";
    $cuerpo = "Has recibido un nuevo mensaje de contacto:\n\n";
    $cuerpo .= "Nombre: " . $nombre . "\n";
    $cuerpo .= "Email: " . $email . "\n";
    $cuerpo .= "¿Cómo quieres hacer tu sitio web?: " . $opcion . "\n";
    $cuerpo .= "Mensaje:\n" . $mensaje . "\n\n";
    $cuerpo .= "Enviado el: " . date("d-m-Y");

    $cabeceras = "From: contacto@facumoyano.com\r\n"; // Ajusta si es necesario
    $cabeceras .= "Reply-To: " . $email . "\r\n";
    $cabeceras .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($destinatario, $asunto, $cuerpo, $cabeceras)) {
        // El correo electrónico se envió correctamente
        header("Location: gracias.html");
        exit();
    } else {
        // Hubo un error al enviar el correo electrónico
        echo "Ocurrió un error al enviar el correo electrónico. Por favor, intenta nuevamente.";
        exit();
    }
    // --- Fin del código para enviar el correo electrónico ---

    $stmt->close();
} else {
    echo "Método no permitido.";
}

$conn->close();

?>