<?php
  $id = $_GET["id"];
  if($_GET["preview"]){

    $getCurrentCountQuery = "SELECT admin_views FROM admin_panel WHERE id = '$id'";
    $Execute=mysqli_query($Connection,$getCurrentCountQuery);
    if($Execute){
      $executeArray = mysqli_fetch_array($Execute);
      //get the first value of the array
      $currentCount = array_shift($executeArray);
      $incrementedCount = $currentCount+1;

      $increaseCountQuery = "UPDATE admin_panel SET admin_views = '$incrementedCount' WHERE id = '$id'";
      $Execute=mysqli_query($Connection,$increaseCountQuery);

    }
  }

  $getCurrentCountQuery = "SELECT views FROM admin_panel WHERE id = '$id'";
  $Execute=mysqli_query($Connection,$getCurrentCountQuery);
  if($Execute){
    $executeArray = mysqli_fetch_array($Execute);
    //get the first value of the array
    $currentCount = array_shift($executeArray);
    $incrementedCount = $currentCount+1;
    $increaseCountQuery = "UPDATE admin_panel SET views = '$incrementedCount' WHERE id = '$id'";
    $Execute=mysqli_query($Connection,$increaseCountQuery);
  }

?>
