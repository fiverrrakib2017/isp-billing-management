<?php
 use PHPMailer\PHPMailer\Exception;
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 include 'PHPMailer/src/SMTP.php';
 include 'PHPMailer/src/PHPMailer.php';
 include 'PHPMailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = htmlspecialchars($_POST['username']);
    // $email = htmlspecialchars($_POST['useremail']);
    // $subject = htmlspecialchars($_POST['subject']);
    // $message = htmlspecialchars($_POST['message']);

    $email_address = htmlspecialchars($_POST['useremail']);
    $email_subject = htmlspecialchars($_POST['subject']);
    $email_body =htmlspecialchars($_POST['message']);

    $mail= new PHPMailer(true);

    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server address
    $mail->Port = 465; // Replace with your SMTP server port
    $mail->SMTPAuth = true;
    $mail->Username = 'rakibas375@gmail.com'; // Replace with your SMTP username
    $mail->Password = 'gwjufuyqfilbwfez'; // Replace with your SMTP password
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->setFrom('rakibas375@gmail.com','Account Successful register');

    // // Email content
    $mail->isHTML(true);
    $mail->addAddress($email_address);
    $mail->Subject = $email_subject;
    $mail->Body = $email_body;
  /* Send the email*/
    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo "Error sending email: " . $mail->ErrorInfo;
    }
  
} else {
    http_response_code(403); 
    echo "Invalid request.";
}
?>
