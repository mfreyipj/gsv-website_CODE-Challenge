<?php  require_once('DB.php');?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>
<?php

function gsvAppointmentAlert($Connection){
    date_default_timezone_set("Europe/Berlin");
    setlocale(LC_TIME, 'deu_deu');
    // $newAppointment = time() + (7 * 24 * 60 * 60);
    // // $dateAppointment = date("d.m.Y - H:i", $newAppointment);
    // $insertExampleQuery = "INSERT INTO gsvAppointment(datetime) VALUES ('$newAppointment')";
    // $Execute = mysqli_query($Connection, $insertExampleQuery);
    //Fetch time from db
    // calculate the german date from the fetched date
    //
    $appointmentQuery = "SELECT * FROM gsvAppointment ORDER BY id DESC LIMIT 1";
    $Execute = mysqli_query($Connection, $appointmentQuery);
    while($DataRows = mysqli_fetch_array($Execute)){
      $fetchedDate = $DataRows["date"];
      $fetchedTime = $DataRows["time"];
      $unixTime = $DataRows["unixTime"];
    }
  //
  // $monthnames = array(
  //   1=>"Januar",
  //   2=>"Februar",
  //   3=>"März",
  //   4=>"April",
  //   5=>"Mai",
  //   6=>"Juni",
  //   7=>"Juli",
  //   8=>"August",
  //   9=>"September",
  //   10=>"Oktober",
  //   11=>"November",
  //   12=>"Dezember");
  //
  //   $monat = date("n");
  //   echo $monatsnamen[$monat];
  //   $day = strftime("%d", $fetchedTime);
  //   $monthNumber = intval(strftime("%m", $fetchedTime));
  //   $monthNameGer = $monthnames[$monthNumber];
  //   $hour = strftime("%H", $fetchedTime);;
  //   $minute = strftime("%M", $fetchedTime);
    $fetchedDay = substr($fetchedDate,0, -4); ;
    $fetchedYear = substr($fetchedDate,-4);
  //  echo intval($fetchedYear).": ".intval(strftime('%Y', time())  );
    //echo $fetchedYear;
    if($unixTime < time()){
         $alarm = "";
    }
    elseif (intval($fetchedYear) > intval(strftime('%Y', time()))) {
        $alarm = "Die nächste GSV findet am ".$fetchedDay." ".$fetchedYear." um ".$fetchedTime." Uhr statt!";
    }
    else{
      $alarm = "Die nächste GSV findet am ".$fetchedDay." um ".$fetchedTime." Uhr statt!";
    }
    return $alarm;
}



?>
