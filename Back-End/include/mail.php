<?php require_once('phpMailer/PHPMailerAutoload.php');?>
<?php


function sendMail($mailAddress, $subject, $body){
  $mail = new PHPMailer();

  $mail-> IsSMTP();
  //$mail->SMTPDebug = 1;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'ssl';
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465;
  $mail->isHTML(true);

  $mail->Username = "gsvtestpage@gmail.com";
  $mail->Password = "WeAreTheGSV-2020";
  $mail->SetFrom("matthiasfrey.ipj@gmail.com");
  $mail->AddAddress($mailAddress);


  $mail->Subject = nl2br($subject);
  $mail->Body = nl2br($body);

  $mail->send();


  // if(!$mail->send()) {
  //     echo 'Message could not be sent.';
  //     //echo 'Mailer Error: ' . $mail->ErrorInfo;
  // } else {
  //     echo 'Message has been sent';
  // }
}

?>
