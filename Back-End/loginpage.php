<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php


if(isset($_POST["Submit"])){
  $Username = mysqli_real_escape_string($Connection,$_POST["Username"]);
  $Password = mysqli_real_escape_string($Connection,$_POST["Password"]);

  if(empty($Username)||empty($Password)){
    $_SESSION["ErrorMessage"] = "All fields must be filled out";
    Redirect_to("loginpage.php");
  }
  else{
    $FoundAccount = Login_Attempt($Username, $Password, $Connection);
    $_SESSION["User_Id"] = $FoundAccount["id"];
    $_SESSION["Username"] = $FoundAccount["username"];
    if($FoundAccount){
      $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]} !";
      Redirect_to("allPosts.php");
    }
    else{
      $_SESSION["ErrorMessage"] = "Invalid username/password";
      Redirect_to("loginpage.php");
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
    <link rel="stylesheet" href="css/stylesForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script>
  </head>
  <body style="width: 40%; margin: auto;  background-color: white;">


        <br>
        <br>
        <br>
        <br>
        <br>
          <h1>Login</h1>
          <?php echo Message();
          echo SuccessMessage();?>

            <form class="" action="loginpage.php" method="post">


                  <div class="form-group">
                  <label for="Username">Username:</label>
                  <input type="text" name="Username" id="Username" placeholder="Username" class="form-control">
                  </div>
              <div class="form-group">
                  <label for="Password">Name:</label>
                  <input type="password" name="Password" id="Password" placeholder="Password" class="form-control">
              </div>

              <br>
              <input class="btn btn-default" type="submit" name="Submit" value="Weiter">


            </form>





  </body>
</html>
