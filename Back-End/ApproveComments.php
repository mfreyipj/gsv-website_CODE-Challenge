<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php
  if(isset($_GET["id"])){
    $IdFromURL = $_GET["id"];
    $Admin = $_SESSION["Username"];
    $Query = "UPDATE comments SET status = 'ON', approvedby = '$Admin' WHERE id = '$IdFromURL'";
    $Execute = mysqli_query($Connection, $Query);
    if($Execute){
      $_SESSION["SuccessMessage"] = "Comment Approved Successfully";
      Redirect_to("Comments.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Something went wrong, try again";
      Redirect_to("Comments.php");
    }
  }


?>
