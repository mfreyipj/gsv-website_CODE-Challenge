<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php
  if(isset($_GET["id"])){
    $IdFromURL = $_GET["id"];
    $Query = "DELETE FROM registration WHERE id = '$IdFromURL'";
    $Execute = mysqli_query($Connection, $Query);
    if($Execute){
      $_SESSION["SuccessMessage"] = "Admin Deleted Successfully";
      Redirect_to("admins.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Something went wrong, try again";
      Redirect_to("admins.php");
    }
  }


?>
