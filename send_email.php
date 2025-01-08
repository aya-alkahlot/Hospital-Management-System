<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';
require 'phpmailer/SMTP.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $to = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = '235380@ppu.edu.ps'; 
        $mail->Password = '408365070'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('235380@ppu.edu.ps', 'Hospital'); 
        $mail->addAddress($to); 

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();

        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Email Sent!',
                text: 'Email sent successfully to $to.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'doctor-panel.php'; 
            });
        </script>";
    } catch (Exception $e) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: 'Failed to send email. Error: {$mail->ErrorInfo}',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'doctor-panel.php'; 
            });
        </script>";
    }
}
?>
</body>
</html>
