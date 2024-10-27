<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send'])) {
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Check if any of the fields are empty
    if (empty($fullname) || empty($email) || empty($phone) || empty($message)) {
        echo 'All fields are required. Please fill them in.';
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('EMAIL_USERNAME'); // Use your email address
        $mail->Password = getenv('EMAIL_PASSWORD'); // Use the app password if applicable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465; // For SSL
        

        // Send notification to the recipient
        $mail->setFrom($email, $fullname);
        $mail->addAddress('your-email@gmail.com', 'Recipient Name');

        // Email Content for the recipient
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission from ' . $fullname;

        $body = '<div style="font-family: Arial, sans-serif; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">';
        $body .= '<img src="https://yourdomain.com/logo.png" alt="Your Company Logo" style="max-width: 150px;">'; // Logo
        $body .= '<h2 style="color: #4CAF50;">New Contact Form Submission</h2>';
        $body .= '<p><strong>Full Name:</strong> ' . $fullname . '</p>';
        $body .= '<p><strong>Email:</strong> ' . $email . '</p>';
        $body .= '<p><strong>Phone:</strong> ' . $phone . '</p>';
        $body .= '<p><strong>Message:</strong></p>';
        $body .= '<p>' . nl2br($message) . '</p>';
        $body .= '<p style="font-weight: bold;">This email was generated from the contact form on your website. We will respond as soon as possible.</p>';
        $body .= '<p>Thank you for reaching out to us!</p>';
        $body .= '<hr>';
        $body .= '<p style="font-style: italic;">If you have any questions, feel free to contact us at <a href="mailto:support@yourdomain.com">support@yourdomain.com</a>.</p>';
        $body .= '<p style="text-align: center;">Follow us on:</p>';
        $body .= '<p style="text-align: center;">';
        $body .= '<a href="https://facebook.com/yourprofile" style="margin: 0 10px;">Facebook</a>';
        $body .= '| <a href="https://twitter.com/yourprofile" style="margin: 0 10px;">Twitter</a>';
        $body .= '| <a href="https://instagram.com/yourprofile" style="margin: 0 10px;">Instagram</a>';
        $body .= '</p>';
        $body .= '<p>Best regards,<br>Your Company Name</p>'; // Customize
        $body .= '</div>';

        $mail->Body = $body;

        // Send the email to the recipient
        $mail->send();

        // Clear previous addresses for the confirmation email
        $mail->clearAddresses();
        $mail->addAddress($email, $fullname);

        // Confirmation email content
        $mail->Subject = 'Thank You for Contacting Us, ' . $fullname;
        $confirmationBody = '<div style="font-family: Arial, sans-serif; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f9f9f9;">';
        $confirmationBody .= '<img src="https://yourdomain.com/logo.png" alt="Your Company Logo" style="max-width: 150px;">'; // Logo
        $confirmationBody .= '<h2 style="color: #4CAF50;">Thank You for Your Message!</h2>';
        $confirmationBody .= '<p>Dear ' . $fullname . ',</p>';
        $confirmationBody .= '<p>Thank you for contacting us. We have received your message and will get back to you shortly.</p>';
        $confirmationBody .= '<p><strong>Your Message:</strong></p>';
        $confirmationBody .= '<p>' . nl2br($message) . '</p>';
        $confirmationBody .= '<p>If you require immediate assistance, please do not hesitate to reach out to us at our contact number.</p>';
        $confirmationBody .= '<hr>';
        $confirmationBody .= '<p style="font-style: italic;">For more information, visit our website: <a href="https://yourwebsite.com">yourwebsite.com</a>.</p>';
        $confirmationBody .= '<p style="text-align: center;">Follow us on:</p>';
        $confirmationBody .= '<p style="text-align: center;">';
        $confirmationBody .= '<a href="https://facebook.com/yourprofile" style="margin: 0 10px;">Facebook</a>';
        $confirmationBody .= '| <a href="https://twitter.com/yourprofile" style="margin: 0 10px;">Twitter</a>';
        $confirmationBody .= '| <a href="https://instagram.com/yourprofile" style="margin: 0 10px;">Instagram</a>';
        $confirmationBody .= '</p>';
        $confirmationBody .= '<p>Best regards,<br>Your Company Name</p>'; // Customize
        $confirmationBody .= '</div>';

        $mail->Body = $confirmationBody;

        // Send the confirmation email
        $mail->send();

        // Set success message
        $_SESSION['success'] = 'Your message has been sent successfully! Please check your email for more details.';
        header("Location: index.html");
        exit;

    } catch (Exception $e) {
        echo 'Oops! Something went wrong and your message could not be sent. Please try again later.<br>';
        echo 'Error Message: ' . $mail->ErrorInfo;
    }
}

// Display success message from session if set
if (isset($_SESSION['success'])) {
    echo '<script>document.getElementById("message").innerText = "' . $_SESSION['success'] . '";</script>';
    unset($_SESSION['success']);
}
