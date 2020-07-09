<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>

<?php
  if(isset($_POST["Submit"])){
    $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
    $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
    $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);

    $currentTime= time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $DateTime;
    $Admin="Matthias Frey";
    $Image = $_FILES["Image"]["name"];
    $Target="Upload/".basename($_FILES["Image"]["name"]);


      $DeleteFromURL = $_GET["Delete"];
      $Query= "DELETE FROM admin_panel WHERE id = '$DeleteFromURL';";
      $Execute=mysqli_query($Connection,$Query);
      move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      if($Execute){
        $_SESSION["SuccessMessage"] = "Post Deleted Successfully";
        Redirect_to("dashboard.php");
      }
      else{
        $_SESSION["ErrorMessage"] = "Something went wrong, try again";
        Redirect_to("AddNewPost.php");
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
          <h1>Delete Post</h1>
          <?php echo Message();
          echo SuccessMessage();?>
          <div class="">
            <?php
              $SearchQueryParameter = $_GET['Delete'];
              $Query = "SELECT * FROM admin_panel WHERE id = '$SearchQueryParameter';";
              $ExecuteQuery = mysqli_query($Connection, $Query);
              while($DataRows = mysqli_fetch_array($ExecuteQuery)){
                $TitleToBeUpdated = $DataRows["title"];
                $CategoryToBeUpdated = $DataRows["category"];
                $ImageToBeUpdated = $DataRows["image"];
                $PostToBeUpdated = $DataRows["post"];
              }

            ?>
            <form class="" action="DeletePost.php?Delete=<?php echo $_GET["Delete"];  ?>" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="form-group">
                  <label for="Title">Title:</label>
                  <input disabled class="form-control"type="text" name="Title" value="<?php echo $TitleToBeUpdated; ?>" id="Title" placeholder="Title" >
                </div>
                <div class="form-group">
                  <span class="FieldInfo">Category: <?php echo $CategoryToBeUpdated; ?></span>
                  <br>

                </div>
                <div class="form-group">
                  <span class="FieldInfo">Image:</span>
                  <img src="Upload/<?php echo $ImageToBeUpdated; ?>" height: "70px" width: "200px">
                  <br>

                </div>
                <div class="form-group">
                  <label for="postarea">Post:</label>
                  <textarea disabled class="form-control" name="Post" id="postarea" rows=10><?php echo $PostToBeUpdated; ?></textarea>
                </div>


                <input class="btn btn-danger" type="submit" name="Submit" value="Delete Post">
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
