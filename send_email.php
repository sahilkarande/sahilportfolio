<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    // Sanitize and retrieve form data
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'skarande248@gmail.com';
        $mail->Password = 'uxwvmjcfyhlvxynl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Send notification to the recipient
        $mail->setFrom($email, $fullname);
        $mail->addAddress('recipient_email@gmail.com', 'Recipient Name'); // Replace with the recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $body = '<h2>Contact Form Submission</h2>';
        $body .= '<p><strong>Full Name:</strong> ' . $fullname . '</p>';
        $body .= '<p><strong>Email:</strong> ' . $email . '</p>';
        $body .= '<p><strong>Message:</strong> ' . nl2br($message) . '</p>';

        $mail->Body = $body;

        // Send the email
        $mail->send();

        // Send confirmation email to the user
        $mail->clearAddresses(); // Clear previous addresses
        $mail->addAddress($email, $fullname); // Add user's email

        $mail->Subject = 'We Have Received Your Message';
        $confirmationBody = '<h2>Thank You for Contacting Us!</h2>';
        $confirmationBody .= '<p>Dear ' . $fullname . ',</p>';
        $confirmationBody .= '<p>Thank you for reaching out to us. Your message has been successfully received. We will get back to you shortly.</p>';
        $confirmationBody .= '<p><strong>Your Message:</strong><br>' . nl2br($message) . '</p>';
        $confirmationBody .= '<p>Best regards,<br>Your Company Name</p>'; // Customize with your company name

        $mail->Body = $confirmationBody;

        // Send the confirmation email
        $mail->send();

        // Success message for form submission
        echo '<div style="background-color: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; border-radius: 5px; padding: 10px;"><strong>Success!</strong> Your message has been successfully sent.</div>';
    } catch (Exception $e) {
        echo '<div style="background-color: #f2dede; color: #a94442; border: 1px solid #ebccd1; border-radius: 5px; padding: 10px;">Oops! Something went wrong and your message could not be sent. Please try again later.<br>Error Message: ' . $mail->ErrorInfo . '</div>';
    }
}
?>
