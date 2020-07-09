<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php


if(isset($_POST["Submit"])){
  $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
  $currentTime= time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
  $DateTime;
  $Admin=$_SESSION["Username"];
  if(empty($Category)){
    $_SESSION["ErrorMessage"] = "All Fields must be filled out";
    Redirect_to("categories.php");
  }elseif(strlen($Category)>99) {
    $_SESSION["ErrorMessage"] = "Name too long for Category";
    Redirect_to("categories.php");
  }
  else{

    $Query= "INSERT INTO category(datetime,name,creatorname) VALUES('$DateTime','$Category', '$Admin')";
    $Execute=mysqli_query($Connection,$Query);
    if($Execute){
      $_SESSION["SuccessMessage"] = "Added Category Successfully";
      Redirect_to("categories.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Category failed to add";
      Redirect_to("categories.php");
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
          <ul id="Side_Menu" class="nav nav-pills nva-stacked">
            <li ><a href="dashboard.php">Dashboard</a></li>
            <li><a href="AddNewPost.php">Add New Post</a></li>
            <li class="active"><a href="categories.php" >Categories</a></li>
            <li><a href="#">Add New Post</a></li>
            <li><a href="#">Manage Admins</a></li>
            <li><a href="#">Comments</a></li>
            <li><a href="#">Live-Blog</a></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </div>
        <div class="col-sm-10">
          <h1>Manage Categories</h1>
          <?php echo Message();
          echo SuccessMessage();?>
          <div class="">
            <form class="" action="categories.php" method="post">
              <fieldset>
                <label for="categoryname">Name:</label>
                <input type="text" name="Category" value="" id="categoryname" placeholder="Name">
                <input class="btn btn-default" type="submit" name="Submit" value="Add New Category">
              </fieldset>
            </form>
          </div>
          <div class="table-responsive">
            <table class="table table-striped">
              <tr>
                <th>Nr</th>
                <th>Date & Time</th>
                <th>Category Name</th>
                <th> Creator Name</th>
                <th>Action</th>
              </tr>
              <?php
                $ViewQuery = "SELECT * FROM category ORDER BY id DESC";
                $Execute = mysqli_query($Connection, $ViewQuery);
                $CrNr = 0;
                while($DataRows = mysqli_fetch_array($Execute)){
                  $Id = $DataRows["id"];
                  $DateTime = $DataRows["datetime"];
                  $CategoryName = $DataRows["name"];
                  $CreatorName = $DataRows["creatorname"];
                  $CrNr++;

               ?>
               <tr>
                 <td><?php echo $CrNr; ?></td>
                 <td><?php echo $DateTime; ?></td>
                 <td><?php echo $CategoryName; ?></td>
                 <td><?php echo $CreatorName; ?></td>
                 <td><a href="DeleteCategory.php?id=<?php echo $Id ?> "><span class="btn btn-danger">Delete</span> </a> </td>
               </tr>
               <?php } ?>
            </table>
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
