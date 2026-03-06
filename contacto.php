<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

header('Content-Type: application/json');

$nombre  = htmlspecialchars(trim($_POST['nombre']  ?? ''));
$email   = htmlspecialchars(trim($_POST['email']   ?? ''));
$asunto  = htmlspecialchars(trim($_POST['asunto']  ?? ''));
$mensaje = htmlspecialchars(trim($_POST['mensaje'] ?? ''));

if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    echo json_encode(['ok' => false, 'error' => 'Rellena todos los campos.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['ok' => false, 'error' => 'El correo no es válido.']);
    exit;
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'SQLite123@gmail.com';   
    $mail->Password   = 'hmnhiyyvptvsksok'; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('SQLite123@gmail.com', 'ADROMI Tech Web');
    $mail->addAddress('SQLite123@gmail.com');
    $mail->addReplyTo($email, $nombre);

    $mail->Subject = "[ADROMI Tech] $asunto — de $nombre";
    $mail->Body    = "Has recibido un mensaje desde el formulario de ADROMI Tech.\n\nNombre: $nombre\nEmail: $email\nAsunto: $asunto\n\nMensaje:\n$mensaje";

    $mail->send();
    echo json_encode(['ok' => true]);

} catch (Exception $e) {
echo json_encode(['ok' => false, 'error' => $e->getMessage()]);}
?>