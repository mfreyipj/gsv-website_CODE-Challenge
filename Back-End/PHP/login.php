<?php
session_start();
function Redirect_to($New_Location){
  header("Location:".$New_Location);
  exit;
}
function Message(){
  if(isset($_SESSION["ErrorMessage"])){
    $Output="<div class=\"alert alert-danger\">";
    $Output .= htmlentities($_SESSION["ErrorMessage"]);
    $Output.="</div>";
    $_SESSION["ErrorMessage"] = null;
    return $Output;
  }
}
function SuccessMessage(){
  if(isset($_SESSION["SuccessMessage"])){
    $Output="<div class=\"alert alert-success\">";
    $Output .= htmlentities($_SESSION["SuccessMessage"]);
    $Output.="</div>";
    $_SESSION["SuccessMessage"] = null;
    return $Output;
  }
}

$username = "ipjtestpage_db";
$password = "CashAintKlay69";

$link = mysqli_connect('localhost', 'ipjtestpage_db', 'CashAintKlay69', 'ipjtestpage_testdb');
if (!$link) {
  echo "Fehler: konnte nicht mit MySQL verbinden." . PHP_EOL;
  echo "Debug-Fehlernummer: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debug-Fehlermeldung: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

if(isset($_GET['login'])) {
  $email = $_POST['email'];
  $passwort = $_POST['passwort'];



}


function Login_Attempt($Username, $Password, $Connection){
  $Query = "SELECT * FROM Loginpage WHERE Username = '$Username' AND Passwort = '$Password' ";
  $Execute = mysqli_query($Connection, $Query);
  $admin = mysqli_fetch_assoc($Execute);
  if($admin){
    return $admin;
  }else{
    return null;
  }

}

function Login(){
  if(isset( $_SESSION["User_Id"])){
    return true;
  }
}
function confirmLogin(){
  if(!Login()){
    Redirect_to("loginpage.php");
  }
}






?>
