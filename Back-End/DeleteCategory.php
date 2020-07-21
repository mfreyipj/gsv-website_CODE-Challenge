<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php
  if(isset($_GET["id"])){
    $IdFromURL = $_GET["id"];
    $Query = "DELETE FROM category WHERE id = '$IdFromURL'";
    $Execute = mysqli_query($Connection, $Query);
    if($Execute){
      $_SESSION["SuccessMessage"] = "Category deleted successfully";
      Redirect_to("categories.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Something went wrong, the category could not be deleted";
      Redirect_to("categories.php");
    }
  }


?>
