<?php require_once('DB.php'); ?>
<?php require_once('Sessions.php'); ?>
<?php

function Redirect_to($New_Location){
   header("Location:".$New_Location);
   exit;
}

if (mysqli_connect_errno($Connection))
{
echo "Failed to connect to MySQL:" . mysqli_connect_error();
}

function Login_Attempt($Username, $Password, $Connection){

  $Query = "SELECT * FROM registration WHERE username = '$Username' AND password = '$Password' ";
  $Execute = mysqli_query($Connection, $Query);
  $admin = mysqli_fetch_assoc($Execute);
  if($admin){
    return $admin;
  }else{
    return null;
  }

}

function Login(){
  if(isset(  $_SESSION["User_Id"])){
    return true;
  }
}
function confirmLogin(){
  if(!Login()){
    Redirect_to("loginpage.php");
  }
}




?>
