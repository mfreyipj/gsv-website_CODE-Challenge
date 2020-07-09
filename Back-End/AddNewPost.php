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
    $Admin=$_SESSION["Username"];
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

      $Query="INSERT INTO admin_panel(datetime,title,category,author,image,post) VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
      $Execute=mysqli_query($Connection,$Query);
      move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      if($Execute){
        $_SESSION["SuccessMessage"] = "Added Post Successfully";
        Redirect_to("AddNewPost.php");
      }
      else{
        $_SESSION["ErrorMessage"] = "Something went wrong";
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
          <h1>Add New Post</h1>
          <?php echo Message();
          echo SuccessMessage();?>
          <div class="">
            <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="form-group">
                  <label for="Title">Title:</label>
                  <input type="text" name="Title" value="" id="Title" placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="categoryselect"><span class="FieldInfo">Category: </span></label>
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
                  <label for="imageselect">Select Image:</label>
                  <input type="File" name="Image" id="imageselect" value="">
                </div>
                <div class="form-group">
                  <label for="postarea">Post:</label>
                  <textarea class="form-control" name="Post" id="postarea" rows=10></textarea>
                </div>


                <input class="btn btn-default" type="submit" name="Submit" value="Add New Post">
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
