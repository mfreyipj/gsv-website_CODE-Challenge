<?php  require_once('DB.php');?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>
<?php

  $gsvAppointment = 0;
  $gsvAppointmentSet = true;

// Spielerei
function countdownfunction1(){
  if($gsvAppointmentSet){

    $date = strtotime("December 1, 2020 8:00 AM");
    $remaining = $date - time();
    $days_remaining = floor($remaining / 86400);
    $hours_remaining = floor(($remaining % 86400) / 3600);
    $alarm = "Es sind noch $days_remaining Tage & $hours_remaining Stunden bis zum Beginn der nächsten GSV!";
    return $alarm;
  }
}

function countdownfunction2($Connection){
    date_default_timezone_set("Europe/Berlin");
    setlocale(LC_TIME, 'deu_deu');
    $newAppointment = time() + (7 * 24 * 60 * 60);
    // $dateAppointment = date("d.m.Y - H:i", $newAppointment);
    $insertExampleQuery = "INSERT INTO gsvAppointment(datetime) VALUES ('$newAppointment')";
    $Execute = mysqli_query($Connection, $insertExampleQuery);
    //Fetch time from db
    // calculate the german date from the fetched date
    //
    $appointmentQuery = "SELECT * FROM gsvAppointment ORDER BY id DESC LIMIT 1";
    $Execute = mysqli_query($Connection, $appointmentQuery);
    while($DataRows = mysqli_fetch_array($Execute)){
      $fetchedTime = $DataRows["datetime"];
    }

  $monthnames = array(
    1=>"Januar",
    2=>"Februar",
    3=>"März",
    4=>"April",
    5=>"Mai",
    6=>"Juni",
    7=>"Juli",
    8=>"August",
    9=>"September",
    10=>"Oktober",
    11=>"November",
    12=>"Dezember");

    $monat = date("n");
    echo $monatsnamen[$monat];
    $day = strftime("%d", $fetchedTime);
    $monthNumber = intval(strftime("%m", $fetchedTime));
    $monthNameGer = $monthnames[$monthNumber];
    $hour = strftime("%H", $fetchedTime);;
    $minute = strftime("%M", $fetchedTime);
    $alarm = "Die nächste GSV findet am $day. $monthNameGer um $hour:$minute Uhr statt!";
    return $alarm;
}



?>
