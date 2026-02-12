<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize input
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        exit("All fields are required.");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email address.");
    }

    // Prevent header injection
    $pattern = "/(content-type|bcc:|cc:|to:)/i";
    if (preg_match($pattern, $name . $email . $message)) {
        exit("Invalid input detected.");
    }

    $to = "roveedsiddiqui456@gmail.com";

    $body = "
        <strong>Name:</strong> {$name}<br>
        <strong>Email:</strong> {$email}<br><br>
        <strong>Message:</strong><br>{$message}
    ";

    $headers  = "From: {$name} <{$email}>\r\n";
    $headers .= "Reply-To: {$email}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>