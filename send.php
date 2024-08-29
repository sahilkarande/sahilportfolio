<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php mailer\phpmailer\Exception.php';
require 'php mailer\phpmailer\PHPMailer.php';
require 'php mailer\phpmailer\SMTP.php';
if (isset($_POST["send"])) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'skarande220@gmail.com'; // Your email address
        $mail->Password = 'modhrmxuijppjhul'; // Your email password or app-specific password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom($_POST["email"], $_POST["fullname"]); // Set the sender's email and name
        $mail->addAddress('skarande220@gmail.com'); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Message from ' . htmlspecialchars($_POST["fullname"]); // Subject line
        $mail->Body    = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; }
                    .container { margin: 20px; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                    .header { font-size: 18px; font-weight: bold; }
                    .content { margin-top: 10px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">Message from ' . htmlspecialchars($_POST["fullname"]) . '</div>
                    <div><strong>Email:</strong> ' . htmlspecialchars($_POST["email"]) . '</div>
                    <div class="content">' . nl2br(htmlspecialchars($_POST["message"])) . '</div>
                </div>
            </body>
            </html>
        ';

        // Send email
        $mail->send();

        echo "
        <script>
        alert('Your message has been sent successfully. Thank you for contacting us!');
        document.location.href = 'index.php';
        </script>
        ";
    } catch (Exception $e) {
        echo "
        <script>
        alert('There was an error sending your message. Please try again later.');
        document.location.href = 'index.php';
        </script>
        ";
    }
}
?>