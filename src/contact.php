<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



$errors = [];
$errorMessage = '';

$secret = '6LdiOocoAAAAAE8RLpf_yugZxRyam0cL2nb6aHQU';

if (!empty($_POST)) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptchaResponse}";
    $verify = json_decode(file_get_contents($recaptchaUrl));

    if (!$verify->success) {
      $errors[] = 'Recaptcha failed';
    }

    if (empty($name)) {
        $errors[] = 'Name is empty';
    }

    if (empty($email)) {
        $errors[] = 'Email is empty';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    if (empty($message)) {
        $errors[] = 'Message is empty';
    }


    if (!empty($errors)) {
        $allErrors = join('<br/>', $errors);
        $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
    } else {

        $submission = array(
            'message' => $message,
            'name' => $name,
            'email' => $email
        );
        sendEmail($submission);
    }
}

function sendEmail($submission) {


    $mail = new PHPMailer(true);
  
    //PHPMailer Object
    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
    $mail->isSMTP();
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = 'h.palleis@gmail.com';
    $mail->Password = 'ktru rvfb rfsk nwlq';
  
    //From email address and name
    $mail->From = "h.palleis@gmail.com";
    $mail->FromName = "Henri Palleis";
  
    //To address and name
    $mail->addAddress($submission["email"], $submission["name"]);
    // $mail->addAddress($data); //Recipient name is optional
  
    //Address to which recipient will reply
    // $mail->addReplyTo("someonewithgmail@gmail.com", "Reply");
  
    //CC and BCC
    // $mail->addCC("cc@example.com");
    // $mail->addBCC("bcc@example.com");
  
    //Send HTML or Plain Text email
    $mail->isHTML(true);
  
    $mail->Subject = "New contact form submission from example.com";
    $mailContent = "<p>From: </p>".$submission["email"].
    "<p>Name: </p>".$submission["name"].
    "<p>Message: </p>".$submission["message"];
  
    echo $mailContent;
  
    $mail->Body = $mailContent;
  
    try {
        $mail->send();
        echo "Message has been sent successfully";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
  }

?>