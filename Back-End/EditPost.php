<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php
  if(isset($_POST["Submit"])){
    $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
    $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
    $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);
    date_default_timezone_set("Europe/Berlin");
    setlocale(LC_TIME, 'deu_deu');
    $currentTime= time();
    $DateTime = strftime("%d. %B %Y", $currentTime);
    $DateTime;
    $Admin="Matthias Frey";
    $Image = $_FILES["Image"]["name"];
    $Target="Upload/".basename($_FILES["Image"]["name"]);
    if(empty($Title)){
      $_SESSION["ErrorMessage"] = "Title can't be empty";
      Redirect_to("AddNewPost.php");
    }elseif(strlen($Title)<3) {
      $_SESSION["ErrorMessage"] = "Title should be longer than 2 characters";
      Redirect_to("AddNewPost.php");
    }
    else{
      $EditFromURL = $_GET["Edit"];
      $Query= "UPDATE admin_panel SET datetime ='$DateTime', title = '$Title', category = '$Category', author = '$Admin', image = '$Image', post = '$Post' WHERE id = '$EditFromURL';";

      $Execute=mysqli_query($Connection,$Query);
      move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      if($Execute){
        $_SESSION["SuccessMessage"] = "Post Updated Successfully";
        Redirect_to("dashboard.php");
      }
      else{
        $_SESSION["ErrorMessage"] = "Something went wrong, try again";
        Redirect_to("AddNewPost.php");
      }

    }



  }
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2">
          <h1>MyBlog</h1>
          <ul id="Side_Menu" class="nav nav-pills nav-stacked">
            <li ><a href="dashboard.php">Dashboard</a></li>
            <li class="active"><a href="AddNewPost.php">Add New Post</a></li>
            <li ><a href="categories.php" >Categories</a></li>
            <li ><a href="#">Add New Post</a></li>
            <li><a href="#">Manage Admins</a></li>
            <li><a href="#">Comments</a></li>
            <li><a href="Blog.php">Live-Blog</a></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </div>
        <div class="col-sm-10">
          <h1>Edit Post</h1>
          <?php echo Message();
          echo SuccessMessage();?>
          <div class="">
            <?php
              $SearchQueryParameter = $_GET['Edit'];
              $Query = "SELECT * FROM admin_panel WHERE id = '$SearchQueryParameter';";
              $ExecuteQuery = mysqli_query($Connection, $Query);
              while($DataRows = mysqli_fetch_array($ExecuteQuery)){
                $TitleToBeUpdated = $DataRows["title"];
                $CategoryToBeUpdated = $DataRows["category"];
                $ImageToBeUpdated = $DataRows["image"];
                $PostToBeUpdated = $DataRows["post"];
              }

            ?>
            <form class="" action="EditPost.php?Edit=<?php echo $_GET["Edit"];  ?>" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="form-group">
                  <label for="Title">Title:</label>
                  <input class="form-control"type="text" name="Title" value="<?php echo $TitleToBeUpdated; ?>" id="Title" placeholder="Title" >
                </div>
                <div class="form-group">
                  <span class="FieldInfo">Existing Category: <?php echo $CategoryToBeUpdated; ?></span>
                  <br><br>
                  <label for="categoryselect"><span class="FieldInfo">New Category: </span></label>
                  <select class="form-control" id="categoryselect" name="Category">
                    <?php
                      $ViewQuery = "SELECT * FROM category ORDER BY id DESC";
                      $Execute = mysqli_query($Connection, $ViewQuery);

                      while($DataRows = mysqli_fetch_array($Execute)){
                        $Category = $DataRows["name"];
                     ?>
                     <option><?php echo $Category; ?></option>
                   <?php } ?>
                 </select>
                </div>
                <div class="form-group">
                  <span class="FieldInfo">Existing Image:</span>
                  <img src="Upload/<?php echo $ImageToBeUpdated; ?>" height: "70px" width: "200px">
                  <br>
                  <label for="imageselect">Select Image:</label>
                  <input type="File" name="Image" id="imageselect" value="">
                </div>
                <div class="form-group">
                  <label for="postarea">Post:</label>
                  <textarea class="form-control" name="Post" id="postarea" rows=10><?php echo $PostToBeUpdated; ?></textarea>
                </div>


                <input class="btn btn-default" type="submit" name="Submit" value="Update Post">
              </fieldset>
            </form>
          </div>




        </div>
      </div>
    </div>

    <div id="Footer">
      <br>
      <br>
      footer
      <br>
    </div>




  </body>
</html>
