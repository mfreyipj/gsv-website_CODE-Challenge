<?php
  $Connection = mysqli_connect('localhost', 'ipjtestpage_db', 'CashAintKlay69', 'ipjtestpage_phpcms');
  if ($Connection->connect_error) {
    die("Connection failed: " . $Connection->connect_error);
}
// echo 'Worked';
 ?>
