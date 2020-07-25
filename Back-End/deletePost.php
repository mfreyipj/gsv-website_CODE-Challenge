<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php
  

  if(isset($_POST["EndPreview"])){
    $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
    $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
    $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);

    $currentTime= time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $DateTime;
    $Admin="Matthias Frey";
    $Image = $_FILES["Image"]["name"];
    $Target="Upload/".basename($_FILES["Image"]["name"]);


      $id = $_GET["Delete"];
      // $Query= "DELETE FROM admin_panel WHERE id = '$id';";
      // $Execute=mysqli_query($Connection,$Query);
      // move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      $Query= "UPDATE admin_panel SET hidden = '1' WHERE id = '$id';";
      $Execute=mysqli_query($Connection,$Query);
      if($Execute){

        // $_SESSION["SuccessMessage"] = "Post deleted successfully";
        Redirect_to("createPost.php?id=".$_GET["Delete"]);
      }
      else{
        $_SESSION["ErrorMessage"] = "Something went wrong, the preview could not be ended";
        // Redirect_to("allPosts.php");
      }

  }
?>
