<?php require_once('include/Functions.php');?>
<?php require_once('include/Sessions.php'); ?>
<?php

  $_SESSION["User_Id"] = null;
  // session_unset(); ?????
  session_destroy();
  Redirect_to("loginpage.php");



?>
