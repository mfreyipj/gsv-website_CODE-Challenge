<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php
  if(isset($_GET["id"])){
    $IdFromURL = $_GET["id"];
    $Query = "UPDATE comments SET status = 'OFF' WHERE id = '$IdFromURL'";
    $Execute = mysqli_query($Connection, $Query);
    if($Execute){
      $_SESSION["SuccessMessage"] = "Comment disapproved successfully";
      Redirect_to("comments.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Something went wrong, the comment could not be disapproved";
      Redirect_to("comments.php");
    }
  }


?>
