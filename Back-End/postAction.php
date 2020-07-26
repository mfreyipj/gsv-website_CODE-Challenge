<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php

  if(isset($_POST["deletePost"])){
    $DeleteFromURL = $_POST["id"];
    $Query= "DELETE FROM admin_panel WHERE id = '$DeleteFromURL';";
    $Execute=mysqli_query($Connection,$Query);
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
    if($Execute){
      $_SESSION["SuccessMessage"] = "Post deleted successfully";
      Redirect_to("posts.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Something went wrong, the post could not be deleted";
      Redirect_to("postAction.php?id=$DeleteFromURL");
    }
  }



  $givenid = mysqli_real_escape_string($Connection,$_POST["id"]);
  // fetch form text data from post statement
  $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
  $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
  $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);
  if(isset($_POST["spotlight"])){
    
    $important = "True";
  }
  else{
    $important = "False";
  }
  $postDescription = mysqli_real_escape_string($Connection,$_POST["postDescription"]);
  $Author = mysqli_real_escape_string($Connection,$_POST["author"]);
  // get post-time
  date_default_timezone_set("Europe/Berlin");
  setlocale(LC_TIME, 'deu_deu');
  $currentTime= time();
  $DateTime = strftime("%d. %B %Y", $currentTime);
  $DateTime;

  // fetch image and save image name in $imageName
  $image = $_FILES['Image'];
  $imageName = $_FILES['Image']['name'];


  // if no image was uploaded, upload the default image
  if(empty($imageName)){
    // if the post already has an id assigned to it that gets returned in the
    // url of createNewPost it is already saved in the db
    // if this is the case, do only update it and do not insert a new entry
    // into the db
    if($givenid){

      // Update query
      // Note: image does not need to be updated since no new image was uploaded
      $Query="UPDATE admin_panel SET datetime = '$DateTime',title = '$Title',category = '$Category',author = '$Author',post = '$Post', postDescription = '$postDescription', important='$important' WHERE id = '$givenid'";
    }
    else{
      $Query="INSERT INTO admin_panel(datetime,title,category,author,image,post, postDescription, important) VALUES('$DateTime','$Title','$Category','$Author','gsvGemontLogo.jpg','$Post','$postDescription', '$important')";
    }
    $Execute=mysqli_query($Connection,$Query);

  }
  // Wenn ein Bild mitgeschickt wurde
  else{
    //fetch other image data
    $imageTmpName = $_FILES['Image']['tmp_name'];
    $imageSize = $_FILES['Image']['size'];
    $imageError = $_FILES['Image']['error'];
    $imageFileType = $_FILES['Image']['type'];
    // seperating the image name into an array with two elements,
    // one being its name and the other its file extension
    $imageExt = explode('.', $imageName);
    // converting the file extension to lowercase
    $imageActualExt = strtolower(end($imageExt));
    // array of allowed file extensions
    $allowed = array('jpg', 'jpeg', 'png');
    // if the uploaded image has an allowed file type
    if(in_array($imageActualExt, $allowed)){
      // if there were no errors in the upload (errors would return 1)
      if($imageError === 0){
        // if the filesize is smalller than 500kb
          if($imageSize < 500000){
            if($givenid){
              $Query="UPDATE admin_panel SET datetime = '$DateTime',title = '$Title',category = '$Category',author = '$Author',image = '$imageName',post = '$Post', postDescription = '$postDescription', important='$important' WHERE id = '$givenid'";
            }
            else{
              $Query="INSERT INTO admin_panel(datetime,title,category,author,image,post, postDescription, important) VALUES('$DateTime','$Title','$Category','$Author','$imageName','$Post', '$postDescription', '$important')";
            }
            $Execute=mysqli_query($Connection,$Query);
            // $imageNameNew = uniqid('', true).".".$imageActualExt;
            $imageUploadDestination="Upload/".$imageName;
            // upload function
            move_uploaded_file($imageTmpName, $imageUploadDestination);
          }
          else {
            echo "Your file is too big!";
          }
      }
      else {
        echo "There was an error uploading your file!";
      }
    }
    else {
      echo "You cannot upload images of this type!";
    }
  }



  // incomplete update query
  $hideQuery = "UPDATE admin_panel SET hidden = 1 WHERE id = ";

  $showQuery = "UPDATE admin_panel SET hidden = 0 WHERE id = ";

  function getNewId($Connection){
    $getIdQuery="SELECT * FROM admin_panel ORDER BY id DESC LIMIT 1;";
    $result=mysqli_query($Connection,$getIdQuery);
    if (!$result) {
      printf("Error: %s\n", mysqli_error($Connection));
      exit();
    }
    while($row = mysqli_fetch_array($result)){
      $newid = $row["id"];
      return $newid;
    }
    return 0;
  }

  if($Execute){
    if(isset($_POST["Preview"])){
      if($givenid){
        $hideQuery = $hideQuery.$givenid;

      }
      else{
        $newid = getNewId($Connection);
        $hideQuery = $hideQuery.$newid;
      }
      $executeHide = mysqli_query($Connection,$hideQuery);
      Redirect_to("../Front-End/FullPost.php?id=$givenid&preview=true");
    }


    elseif(isset($_POST["Submit"])){

      if($givenid){
        $showQuery = $showQuery.$givenid;
      }
      else{
        $newid = getNewId($Connection);
        $showQuery = $showQuery.$newid;
      }
      $executeShow = mysqli_query($Connection,$showQuery);
      $_SESSION["SuccessMessage"] = "Added post successfully";
      Redirect_to("posts.php");
    }

    elseif(isset($_POST["saveAsDraft"])){
      if($givenid){
        $hideQuery = $hideQuery.$givenid;
      }
      else{
        $newid = getNewId($Connection);
        $hideQuery = $hideQuery.$newid;
      }
      $executeHide = mysqli_query($Connection,$hideQuery);
      Redirect_to("posts.php?drafts=true"); //TODO zukünftig allDrafts

    }

  }












/*
  // if the query was executed
  if($Execute){
    //if the preview-Button has been clicked
    if(isset($_POST["Preview"])){

      // incomplete update query
      $hideQuery = "UPDATE admin_panel SET hidden = 1 WHERE id = ";

      // if the post already had an id, redirect to the fullpost
      // of the given id
      if($givenid){
        // Update to hidden
        $hideQuery = $hideQuery.$givenid;
        $executeHide = mysqli_query($Connection,$hideQuery);
        Redirect_to("../Front-End/FullPost.php?id=$givenid&preview=true");
      }
      // if the post did not have an id before uploading it, it now
      //(after uploading) has the highest id
      // in this case, fetch the new id and redirect to the
      // fullpost of the new id
      else{
        $getIdQuery="SELECT * FROM admin_panel ORDER BY id DESC LIMIT 1;";
        $result=mysqli_query($Connection,$getIdQuery);
        if (!$result) {
          printf("Error: %s\n", mysqli_error($Connection));
          exit();
        }
          while($row = mysqli_fetch_array($result)){
            $newid = $row["id"];
            $hideQuery = $hideQuery.$newid;
            $executeHide = mysqli_query($Connection,$hideQuery);
            Redirect_to("../Front-End/FullPost.php?id=$newid&preview=true");
          }
      }

    }
    elseif(isset($_POST["Submit"])){
      $showQuery = "UPDATE admin_panel SET hidden = 0 WHERE id = ";

      // if the post already had an id, redirect to the fullpost
      // of the given id
      if($givenid){
        // Update to hidden
        $showQuery = $showQuery.$givenid;
        $executeShow = mysqli_query($Connection,$showQuery);

        $_SESSION["SuccessMessage"] = "Added post successfully";
        Redirect_to("allPosts.php");
      }
      // if the post did not have an id before uploading it, it now
      //(after uploading) has the highest id
      // in this case, fetch the new id and redirect to the
      // fullpost of the new id
      else{
        $getIdQuery="SELECT * FROM admin_panel ORDER BY id DESC LIMIT 1;";
        $result=mysqli_query($Connection,$getIdQuery);
        if (!$result) {
          printf("Error: %s\n", mysqli_error($Connection));
          exit();
        }
          while($row = mysqli_fetch_array($result)){
            $newid = $row["id"];
            $hideQuery = $showQuery.$newid;
            $executeHide = mysqli_query($Connection,$showQuery);
            $_SESSION["SuccessMessage"] = "Added post successfully";
            Redirect_to("allPosts.php");
          }
      }
    }
  }
  */
  $_SESSION["ErrorMessage"] = "Something went wrong, your post could not be added";
  Redirect_to("createPost.php");


?>
