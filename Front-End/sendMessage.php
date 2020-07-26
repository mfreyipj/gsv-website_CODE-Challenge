<?php require_once('../Back-End/include/DB.php'); ?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>
<?php
if(isset($_POST["sendContactMessage"])){
  $name = $_POST["name"];
  $mailAddress = $_POST["email"];
  $message = $_POST["message"];

  $insertQuery = "INSERT INTO contactMessages(name, mailAddress, message) VALUES ('$name', '$mailAddress', '$message')";
  $execute = mysqli_query($Connection, $insertQuery);

  if(!$execute){
    printf("Error: %s\n", mysqli_error($Connection));
    exit();
  }
  else{
    $_SESSION["SuccessMessage"] = "Wir haben deine Nachricht erhalten, vielen Dank!";
    Redirect_to("Kontakt.php");
  }

}


?>
