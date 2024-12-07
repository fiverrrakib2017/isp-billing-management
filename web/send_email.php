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

    /* SMTP Configuration*/
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->Port = 465; 
    $mail->SMTPAuth = true;
    $mail->Username = 'rakibas375@gmail.com'; 
    $mail->Password = 'gwjufuyqfilbwfez'; 
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->setFrom('rakibas375@gmail.com','Received Web Mail');

    /* Email content*/
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
