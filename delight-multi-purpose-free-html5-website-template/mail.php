<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

header('Content-Type: application/json; charset=utf-8');

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function check_data() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["email"]) || empty($_POST["message"])) {
            return false;
        }
    
        $email = test_input($_POST["email"]);
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
    
        return true;    
    } else {
        return false;
    }
}

function send_mail() {
    if (!check_data()) {
        return ['success' => false, 'error' => 'Invalid input data'];
    }

    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $subject = test_input($_POST["subject"]);
    $message = test_input($_POST["message"]);

    $mail = new PHPMailer;
    // Set PHPMailer to use SMTP.
    $mail->isSMTP();
    // Set SMTP host name                      
    $mail->Host = "smtp.gmail.com";
    // Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;                      
    // Provide username and password
    $mail->Username = "batuhandonmezweb@gmail.com";             
    $mail->Password = "wtxt mcko carz mlbo";                       
    // If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "tls";   
    $mail->CharSet = "UTF-8";                    
    // Set TCP port to connect to
    $mail->Port = 587;                    
    $mail->From = $email;
    $mail->FromName = $name;
    $mail->addAddress("batuhandonmez17@gmail.com", "neta");
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = "from:  " . $email . " </br>". $message;
    $mail->AltBody = $message;

    if (!$mail->send()) {
        return ['success' => false, 'error' => $mail->ErrorInfo];
    } else {
        return ['success' => true];
    }
}

echo json_encode(send_mail());
?>
