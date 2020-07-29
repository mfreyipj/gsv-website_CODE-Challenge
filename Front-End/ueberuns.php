<?php  require_once('DB.php');?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>
<?php require_once('timerscript.php'); ?>
<?php

  $Query = "SELECT * FROM ueberuns ORDER BY jahr DESC";
  $Execute = mysqli_query($Connection, $Query);

  $DataRows = mysqli_fetch_array($Execute);
    $Jahr = $DataRows["jahr"];

    $Image = $DataRows["image"];
    $werSindWir = $DataRows["werSindWir"];

 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Über Uns | GSV Gemont</title>

    <link rel="stylesheet" href="CSS/2-UeberUns/styles.css" media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="CSS/CSSforAll/cssForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <!--Stylesheet für Smartphones (10-2018)-->
    <link rel=stylesheet href="CSS/2-UeberUns/mobileStyles.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <link rel=stylesheet href="CSS/CSSforAll/mobileCssForAll.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <!--Icon Einbindung-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!--JQuery Einbindung-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--Icon Einbindung-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">



  </head>
  <body>
  <!--Bookmark zum Seitenanfang-->
    <div id="sanfang"> Copyright &copy; Innovative Programming JTown </div>

    <!--- Navigations-/Menubar-->
    <nav>

        <!--DropdownContainer-->
        <div class="dropdown navElement">

            <!--Hamburger Button, bei Klick wird Dropdown dargestellt-->
            <button id="hamburgerButton" onclick="dropDown()"class="dropdownbtn hamburger hamburger--slider hiddenOnDesktop" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>

            <!--Container für die Elemente der Navbar, in der Desktopvariante klassisch dargestellt-->
            <div class="dropdown-content" id="myDropdown">



                <!--Linkliste-->
                <ul>

                    <li><span><a href="Start.php">Startseite</a></span></li>
                    <li><span><a href="ueberuns.php" class="active">Über Uns</a></span></li>
                    <!-- <li><span><a href="#">Projekte und Inhalte</a></span>
                    </li> -->
                    <li><!--GSV Logo (nur für den Desktop relevant)-->
                <img src="IMG/gsvGemontLogo.jpg" alt="gemontlogo" class="logonav hiddenMobile" id="logodesktop" ></li>
                    <li><span><a href="Veranstaltungen.php" >Veranstaltungen</a></span></li>
                    <li><span><a href="newsletter.php" >Newsletter</a></span></li>
                    <li><span><a href='Kontakt.php'>Kontakt</a></span></li>
                </ul>
            </div>



        </div>

        <!--Name der aktuellen Seite mittig in der Navbar (Tablet&Smartphone)-->
        <div class="navElement navUeberschrift hiddenOnDesktop">
            <h3>Über Uns</h3>
        </div>

        <!--GSV Logo Rechts oben in der Navbar (Tablet & Smartphone)-->
        <div class="navElement divLogoNav">
            <!--GSV Logo-->
            <img class="logonav" id="logomobile" src="IMG/gsvGemontLogoWeissTransparent.png" alt="gemontlogo">
        </div>

        <!--Container des Timerbanners-->
        <div class="timerbanner">
            <!--Timer im Timerbanner-->
            <div id="timerdesktop"><?php echo gsvAppointmentAlert($Connection); ?></div>
        </div>
        <div class="searchbar-container">
          <form class="searchNavTop" action="Veranstaltungen.php" method="get" id="searchform">

            <input class="searchInput" type="text" name="Search" value="" placeholder="Suche nach Posts" autocomplete="off">
            <button form="searchform"type="submit" name="submitSearch" class="searchbarSubmit"><i class= ' fas fa-search '></i> </button>

          </form>

        </div>
    </nav>


    <!---------------Page Content---------------------------->

    <div class="wrapper">


        <h3 class="hiddenOnDesktop">Das GSV-Team</h3>

        <img src="../Back-End/Upload/<?php echo $Image; ?>" alt="Gruppenbild" id="groupImage">
        <br>


        <h2 class="hiddenOnMobile">Das GSV-Team</h2>
        <br>
        <br>

        <div class="nVorstellung">
            <div class="vorstellungContent">
                <h2>Wer sind Wir?</h2>
                <p id="vorstellung"><?php echo htmlentities($werSindWir); ?></p>
            </div>

        </div>




    <section class="schuelersprecherVorstellung">
        <h3 class="hiddenOnDesktop">Unsere Schulsprecher</h3>
        <h2 class="hiddenOnMobile">Unsere Schulsprecher</h2>
        <ul class="schuelersprecherListe">
          <?php
            $QueryGuys = "SELECT * FROM schuelersprecher ";
            $ExecuteGuys = mysqli_query($Connection, $QueryGuys);

            while($DataRows = mysqli_fetch_array($ExecuteGuys)){
              $Image = $DataRows["image"];
              $Name = $DataRows["name"];
              $Klasse = $DataRows["klasse"];
              $Hobbys = $DataRows["hobbys"];
              $Ziele = $DataRows["ziel/e"];
              $Projekte = $DataRows["projekte"];
              $Motivation = $DataRows["motivation"];


          ?>
            <li>
                <h4 class="hiddenOnDesktop"><?php echo htmlentities($Name); ?></h4>
                <br class="hiddenOnDesktop">
                <div class="schuelersprecherContainer">
                    <h3 class="hiddenOnMobile"><?php echo htmlentities($Name); ?></h3>
                    <br>
                    <img src="../Back-End/Upload/<?php echo $Image; ?>" class="schuelersprecherImage">
                    <div class="schuelersprecherBeschreibung">
                        <p>
                            <span>Klasse:</span>
                            <br>
                            <?php echo htmlentities($Klasse); ?>
                            <br>
                            <span>Hobbys: </span>
                            <br>
                            <?php echo htmlentities($Hobbys); ?>

                            <br>
                            <span>Ziel/e: </span>
                            <br>
                            <?php echo htmlentities($Ziele); ?>
                            <br>
                            <span>Projekte: </span>
                            <br>
                            <?php echo htmlentities($Projekte); ?>
                            <br>
                            <span>Motivation:</span>
                            <br>
                            <?php echo htmlentities($Motivation); ?>
                        </p>
                    </div>


                </div>
            </li>
          <?php } ?>
        </ul>
    </section>

    </div>





    <footer id="footer">

        <!--Impressum-->
        <div><p> <a href="#" class="impressum">Impressum</a></p></div>

        <!--Copyright-->

        <div><p>Copyright &copy; Innovative Programming JTown</p></div>

        <!--Zum Seitenanfang-->
        <p><a href="#sanfang"><i id="arrowup" class="fas fa-angle-up"></i></a></p>
    </footer>
    <script src="JS/script.js"></script>
  </body>
</html>
