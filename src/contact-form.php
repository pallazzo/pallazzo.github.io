<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$nameSanitized = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$emailSanitized = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$messageSanitized = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

// Validate $emailSanitized
if (!filter_var($emailSanitized, FILTER_VALIDATE_EMAIL) === false) {
    echo ("$emailSanitized is a valid email address <br>");

	$submission = array(
        'message' => $messageSanitized,
        'name' => $nameSanitized,
        'email' => $emailSanitized
    );
      sendEmail($submission);

  } else {
    echo ("$emailSanitized is not a valid email address");
  }

function getUserIpAddr(){
  if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      //ip from share internet
      $ip = $_SERVER['HTTP_CLIENT_IP'];
  }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      //ip pass from proxy
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }else{
      $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
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






$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->Username = 'h.palleis@gmail.com';
$mail->Password = 'ktru rvfb rfsk nwlq';
$mail->setFrom('h.palleis@gmail.com');
$mail->addAddress('henri.palleis@tuta.io');
$mail->Subject = 'Hello from PHPMailer!';
$mail->Body = 'This is a test.';
//send the message, check for errors
if (!$mail->send()) {
    echo "ERROR: " . $mail->ErrorInfo;
} else {
    echo "SUCCESS";
}


