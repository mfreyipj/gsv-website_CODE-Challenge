<?php require_once('login.php'); ?>
<?php

if(isset($_POST["Submit"])){
  $Username = mysqli_real_escape_string($link,$_POST["Username"]);
  $Password = mysqli_real_escape_string($link,$_POST["Password"]);

  if(empty($Username)||empty($Password)){
    $_SESSION["ErrorMessage"] = "All Fields must be filled out";
    echo "All Fields must be filled out";
    Redirect_to("Start.html");
  }
  else{
    $FoundAccount = Login_Attempt($Username, $Password, $link);
    $_SESSION["User_Id"] = $FoundAccount["id"];
    $_SESSION["Username"] = $FoundAccount["username"];
    if($FoundAccount){
      $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]} !";
      Redirect_to("Kontakt.html");
    }
    else{
      $_SESSION["ErrorMessage"] = "Invalid Username/Password";
      echo "Invalid Username/Password";
        Redirect_to("Start.html");
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
  <body style="width: 40%; margin: auto;  background-color: white;">


        <br>
        <br>
        <br>
        <br>
        <br>
          <h1>Login</h1>
          <?php echo Message();
          echo SuccessMessage();?>

            <form class="" action="loginSite.php" method="post">


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
