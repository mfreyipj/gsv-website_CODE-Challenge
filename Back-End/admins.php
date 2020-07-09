<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php


if(isset($_POST["Submit"])){
  $Username = mysqli_real_escape_string($Connection,$_POST["Username"]);
  $Password = mysqli_real_escape_string($Connection,$_POST["Password"]);
  $ConfirmPassword = mysqli_real_escape_string($Connection,$_POST["ConfirmPassword"]);
  $currentTime= time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
  $DateTime;
  $Admin=$_SESSION["Username"];
  if(empty($Username)||empty($Password)||empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"] = "All Fields must be filled out";

  }elseif(strlen($Password)<4) {
    $_SESSION["ErrorMessage"] = "At least 4 Characters are required";

  }
  elseif($Password !== $ConfirmPassword) {
    $_SESSION["ErrorMessage"] = "The Password must be equal";

  }
  else{

    $Query= "INSERT INTO registration(datetime,username,password, addedby) VALUES('$DateTime','$Username','$Password', '$Admin')";
    $Execute=mysqli_query($Connection,$Query);
    if($Execute){
      $_SESSION["SuccessMessage"] = "Added Admin Successfully";
      Redirect_to("admins.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Category failed to add";
      Redirect_to("admins.php");
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
          <h1>Manage Admin Access</h1>
          <?php echo Message();
          echo SuccessMessage();?>
          <div class="">
            <form class="" action="admins.php" method="post">

                <fieldset>
                  <div class="form-group">
                  <label for="Username">Username:</label>
                  <input type="text" name="Username" value="" id="Username" placeholder="Username" class="form-control">
                  </div>
              <div class="form-group">
                  <label for="Password">Name:</label>
                  <input type="password" name="Password" value="" id="Password" placeholder="Password" class="form-control">
              </div>
              <div class="form-group">
                  <label for="ConfirmPassword">Name:</label>
                  <input class="form-control" type="password" name="ConfirmPassword" value="" id="ConfirmPassword" placeholder="Retype your Password">

                </fieldset>
              </div>
              <br>
              <input class="btn btn-default" type="submit" name="Submit" value="Add New Admin">


            </form>
            <br>
            <div class="table-responsive">
              <br>
              <table class="table table-striped">
                <tr>
                  <th>Nr</th>
                  <th>Date & Time</th>
                  <th>Admin</th>
                  <th> Added By</th>
                  <th>Action</th>
                </tr>
                <?php
                  $ViewQuery = "SELECT * FROM registration ORDER BY id DESC";
                  $Execute = mysqli_query($Connection, $ViewQuery);
                  $SrNr = 0;
                  while($DataRows = mysqli_fetch_array($Execute)){
                    $Id = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $Username = $DataRows["username"];
                    $AddedBy = $DataRows["addedby"];
                    $SrNr++;

                 ?>
                 <tr>
                   <td><?php echo $SrNr; ?></td>
                   <td><?php echo $DateTime; ?></td>
                   <td><?php echo $Username; ?></td>
                   <td><?php echo $AddedBy; ?></td>
                   <td><a href="DeleteAdmin.php?id=<?php echo $Id ?> "><span class="btn btn-danger">Delete</span> </a> </td>
                 </tr>
                 <?php } ?>
              </table>
            </div>
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
