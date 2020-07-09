<?php
session_start();

$username = "ipjtestpage_db";
$password = "CashAintKlay69";

$pdo= new PDO('mysql:host=localhost;dbname=ipjtestpage_testdb', "ipjtestpage_db", $password = "CashAintKlay69");

if(isset($_GET['login'])) {
    $Username = $_POST['user'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE Username = ':Username' AND Passwort = ':Passwort'");
    $result = $statement->execute(array(':Username' => $Username));
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    //Überprüfung des Passworts
    if ($user) {
        $_SESSION['userid'] = $user['ID'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="CSS/7-Loginpage/styles.css">
</head>
<body>
<?php
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
<form action="?login=1" method="post">
E-Mail:<br>
<input type="text" size="40" maxlength="250" name="user"><br><br>

Dein Passwort:<br>
<input type="password" size="40"  maxlength="250" name="passwort"><br>

<input type="submit" value="Abschicken">
</form>

</body>
</html>
