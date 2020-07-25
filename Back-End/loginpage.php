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
      Redirect_to("posts.php");
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

    <link rel="stylesheet" href="css/adminstyles.css">
    <link rel="stylesheet" href="css/stylesForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/messages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/loginpageD.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">

  </head>
  <body>
    <div class="mainContent">
      <?php echo Message();
      echo SuccessMessage();?>

      <div class="form-container">
          <h3>Login</h3>
          <form class="" action="loginpage.php" method="post">
                <label for="Username"></label>
                <input type="text" name="Username" id="Username" placeholder="Username" class="form-control"><br>

                <label for="Password"></label>
                <input type="password" name="Password" id="Password" placeholder="Password" class="form-control">


            <br>
            <input class="btnSubmit" type="submit" name="Submit" value="Weiter">


          </form>
      </div>
    </div>







  </body>
</html>
