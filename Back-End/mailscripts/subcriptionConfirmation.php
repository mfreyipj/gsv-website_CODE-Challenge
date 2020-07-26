<?php require_once('../include/DB.php'); ?>
<?php require_once('../include/Sessions.php'); ?>
<?php require_once('../include/Functions.php'); ?>
<?php require_once('../phpMailer/PHPMailerAutoload.php');?>
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


  $mail->Subject = $subject;
  $mail->Body = $body;

  $mail->send();


  // if(!$mail->send()) {
  //     echo 'Message could not be sent.';
  //     //echo 'Mailer Error: ' . $mail->ErrorInfo;
  // } else {
  //     echo 'Message has been sent';
  // }
}


if(isset($_POST["subscribe"])){
  $mailAddress = $_POST["eMail"];
  echo $mailAddress;
  $alreadySubscribedQuery = "SELECT * FROM newsletterSubscribers WHERE mailaddress = '$mailAddress'";
  $execute = mysqli_query($Connection, $alreadySubscribedQuery);
  if (!$execute) {
     printf("Error: %s\n", mysqli_error($Connection));
     exit();
  }
  else{
     if(intval(mysqli_num_rows($execute))===0){
       $insertMailQuery = "INSERT INTO newsletterSubscribers(mailaddress) VAlUES ('$mailAddress');";
       $execute = mysqli_query($Connection, $insertMailQuery);
       if (!$execute) {
         printf("Error: %s\n", mysqli_error($Connection));
         exit();
       }
       else{
         $_SESSION["SuccessMessage"] = "Deine Anmeldung war erfolgreich!";
         $subject = "Newsletter-Anmeldung erfolgreich!";
         $body = "Du bist nun für den GSV-Newsletter angemeldet. Wir freuen uns sehr über dein Interesse!";
         sendMail($mailAddress, $subject, $body);
         echo "mail sent";
         Redirect_to("../../Front-End/newsletter.php");
       }
     }
     else{
       $_SESSION["ErrorMessage"] = "Du bist schon für den Newsletter angemeldet";
       Redirect_to("../../Front-End/newsletter.php");
     }
  }


}
else{
  echo "I did not receive data!";
}




?>
