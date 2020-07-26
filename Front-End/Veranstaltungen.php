<?php  require_once('DB.php');?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>
<?php require_once('timerscript.php'); ?>
<?php

  //Search View Query
  if(isset($_GET["Search"])){
    $Search = $_GET["Search"];
    $ViewQuery = "SELECT * FROM admin_panel WHERE datetime LIKE '%$Search%' OR title LIKE '%$Search%' OR category LIKE '%$Search%' OR author LIKE '%$Search%' OR post LIKE '%$Search%'";
  }
  elseif (isset($_GET["Page"])) {
    // Query for Pagination
    $Page = $_GET["Page"];
    $ShowPostFrom = ($Page * 4)-4;
    if($ShowPostFrom < 0){
      $ShowPostFrom = 0;
    }
    $ViewQueryOld = "SELECT * FROM admin_panel WHERE vergangen ='True' ORDER BY id DESC LIMIT $ShowPostFrom,4";
    $ViewQueryNew = "SELECT * FROM admin_panel WHERE vergangen ='False' ORDER BY id DESC LIMIT $ShowPostFrom,4";
  }
  // // Category Filter
  // elseif (isset($_GET["category"])) {
  //   $Page = 1;
  //
  //   $Category = $_GET["category"];
  //   $ViewQuery = "SELECT * FROM admin_panel WHERE category = '$Category' ORDER BY id DESC";
  // }
  else{
    //Default View Query
    $Page = 1;
    $ShowPostFrom = ($Page * 4)-4;
    if($ShowPostFrom < 0){
      $ShowPostFrom = 0;
    }
    $ViewQueryOld = "SELECT * FROM admin_panel WHERE vergangen ='True' ORDER BY id DESC LIMIT $ShowPostFrom,4";
    $ViewQueryNew = "SELECT * FROM admin_panel WHERE vergangen ='False' ORDER BY id DESC LIMIT $ShowPostFrom,4";
  }


  $SlideQuery = "SELECT * FROM admin_panel WHERE important = 'True' ORDER BY id DESC LIMIT 4";
  $ExecuteSlide = mysqli_query($Connection, $SlideQuery);
  ?>


<!--Definierung des Dokuments als HTML 5-->
<!DOCTYPE html>
<html lang="de">

<!--Metadaten-->
<head>

    <!--Name der Seite im Tab-->
    <title>Veranstaltungen | GSV Gemont</title>

    <!--Aktuelles Charset-->
    <meta charset="utf-8">

    <!--Anpassung an Bildschirmgröße-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Stylesheet für Smartphones (10-2018)-->
    <link rel=stylesheet href="CSS/4-Veranstaltungen/Mobile/Mobilestyles.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <link rel=stylesheet href="CSS/CSSforAll/mobileCssForAll.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <!--Stylesheet für Tablets (10-2018)-->
    <!-- <link rel="stylesheet" href="CSS/4-Veranstaltungen/Desktop/events.css" media="screen and (min-width: 601px) and (max-width: 1000px)"> -->

    <!--Stylesheet für Desktops (10-2018)-->
    <link rel="stylesheet" href="CSS/4-Veranstaltungen/Desktop/events.css" media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="CSS/CSSforAll/cssForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">

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
            <button id="hamburgerButton" onclick="dropDown()"class=" dropdownbtn hamburger hamburger--slider hiddenOnDesktop" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>

            <!--Container für die Elemente der Navbar, in der Desktopvariante klassisch dargestellt-->
            <div class="dropdown-content" id="myDropdown">



                <!--Linkliste-->
                <ul>

                    <li><span><a href="Start.php">Startseite</a></span></li>
                    <li><span><a href="ueberuns.php">Über Uns</a></span></li>
                    <!-- <li><span><a href="#">Projekte und Inhalte</a></span>
                    </li> -->
                    <li><!--GSV Logo (nur für den Desktop relevant)-->
                <img src="IMG/gsvGemontLogo.jpg" alt="gemontlogo" class="logonav hiddenMobile" id="logodesktop" ></li>
                <!-- link to events that is marked as active only if no search was done-->
                    <li><span><a href="Veranstaltungen.php" class="<?php if(isset($_GET['Search'])){echo '';} else{echo 'active';} ?>">Veranstaltungen</a></span></li>
                    <li><span><a href="newsletter.php" >Newsletter</a></span></li>
                    <li><span><a href='Kontakt.php'>Kontakt</a></span></li>
                </ul>
            </div>



        </div>

        <!--Name der aktuellen Seite mittig in der Navbar (Tablet&Smartphone)-->
        <div class="navUeberschrift navElement hiddenOnDesktop">
            <h3>Veranstaltungen</h3>
        </div>

        <!--GSV Logo Rechts oben in der Navbar (Tablet & Smartphone)-->
        <div class="navElement divLogoNav">
            <!--GSV Logo-->
            <img class="logonav" id="logomobile" src="IMG/gsvGemontLogoWeissTransparent.png" alt="gemontlogo">
        </div>

        <!--Container des Timerbanners-->
        <div class="timerbanner">
            <!--Timer im Timerbanner-->
            <div id="timerdesktop"><?php

            // function countdownfunction2(int $nDay, string $nMonth, int $nHour, int $nMinute, bool $gsvAppointmentSet){
            //   if($gsvAppointmentSet){
            //
            //     $day = $nDay;
            //     $month = $nMonth;
            //     $hour = $nHour;
            //     $minute = $nMinute;
            //     $remaining = $date - time();
            //     $days_remaining = floor($remaining / 86400);
            //     $hours_remaining = floor(($remaining % 86400) / 3600);
            //     $alarm = "Die nächste GSV findet am $day. $month um $nHour:$nMinute Uhr statt!";
            //     return $alarm;
            //   }
            // }

            echo countdownfunction2($Connection); ?></div>
        </div>
        <div class="searchbar-container">
          <form class="searchNavTop" action="Veranstaltungen.php" method="get" id="searchform">

            <input class="searchInput" type="text" name="Search" value="" placeholder="Suche nach Posts" autocomplete="off">
            <button form="searchform"type="submit" name="submitSearch" class="searchbarSubmit"><i class= ' fas fa-search '></i> </button>

          </form>

        </div>


    </nav>


    <!--linke Seitennavigation (Tablet und Desktop)-->
     <div class="sidenav hiddenMobile <?php if(isset($_GET['Search'])){echo ' hiddenOnDesktop';} else{echo '';} ?>" id="desktopside" >
        <ul class= "hiddenMobile">
            <li><a href="#" onclick="showcontent('new'); return false;"><span>Zukünftiges</span> <i class="far fa-hand-point-right sidenavIcon"></i> </a></li>
            <li><a href="#" onclick="showcontent('old'); return false;" ><span>Berichte</span> <i class="far fa-hand-point-left sidenavIcon"></i> </a></li>
            <li><a href="calendar.php" ><span>Kalender</span> <i class="fas fa-calendar-alt sidenavIcon"></i></a></li>
        </ul>

    </div>

    <!--Timerfenster für Tablet und Smartphone-->
        <div id="timermobile"></div>
    <!--Wrapper -->


    <div class="wrapper">

      <!-- <form action="newsletter.php" class="e-mail-form" method="post">
        <div class="email-box">
          <i class="fas fa-envelope"></i>
          <input type="text" id="e-mail" class="e-mail-form input" name="suche" value="" placeholder="Suche...">

          <input type="submit" class="e-mail-form submit hiddenOnMobile" name="SearchButton" value="Go">

        </div>
        <br class="hiddenOnDesktop">
        <input type="submit" class="e-mail-form submit hiddenOnDesktop" name="SearchButton" value="Go">
      </form> -->




        <!--Container mit den beiden Buttons zur Auswahl ob man Vergangenes oder Kommendes sehen möchte-->
        <div class="Auswahlcontainer hiddenOnDesktop" id="auswahlmobile" >
            <button onclick="showcontent('oldMobile')" type="button" class="categorychooser">Vergangene Veranstaltungen</button>
            <button onclick="showcontent('newMobile')" type="button" class="categorychooser">Kommende Veranstaltungen</button>
        </div>

        <br>

        <br>
        <div id="old" class="content-container hidden">


            <!--Seitenüberschrift für die ausgewählte Seite-->

            <h2>
              <?php
              if($_GET["Search"]){
                $Execute = mysqli_query($Connection, $ViewQuery);
                echo "Posts die \"".$_GET['Search']."\" enthalten";
              }else{
                echo "Vergangene Veranstaltungen";
                $Execute = mysqli_query($Connection, $ViewQueryOld);}?>
            </h2>
            <?php

            ?>
            <hr class="hiddenOnDesktop"/>


            <!--Platzschaffer unterm Trennstrich-->
            <br/>

            <?php
            if($_GET["Search"]){
              $Execute = mysqli_query($Connection, $ViewQuery);
            }
            else{
              $Execute = mysqli_query($Connection, $ViewQueryOld);
            }

             while($DataRows = mysqli_fetch_array($Execute)){
              $Id = $DataRows["id"];
              $DateTime = $DataRows["datetime"];
              $Title = $DataRows["title"];
              $Category = $DataRows["category"];
              $author = $DataRows["author"];
              $Image = $DataRows["image"];
              $Post = $DataRows["post"];
              $PostDescription = $DataRows["postDescription"];
              ?>
            <!--Div für den ersten Report-->
            <div class="report">

                    <!--Report-Überschrift-->
                <!-- <span class="flexHeader">
                    <span style="visibility: hidden">30.11.2018</span><h3><?php echo htmlentities($Title); ?></h3><span><?php echo $author." | ".htmlentities($DateTime); ?></span></span> -->

                    <!--Bild als Link-->
                    <div>
                      <a href="FullPost.php?id=<?php echo $Id; ?>"><img src="../Back-End/Upload/<?php echo $Image; ?>" class="picturereport"></a>
                      <span>
                        <h3><?php echo htmlentities($Title); ?></h3>
                        <br>
                        <br>
                        <p><?php echo $author." | ".htmlentities($DateTime); ?></p>
                      </span>

                    </div>

                    <!--Reportbeschreibung-->
                    <span class="reportdescription"><p ><br/> <?php echo htmlentities($PostDescription); ?></p>

                    <!--Weiterlesen Link-->
                    <p><a href="FullPost.php?id=<?php echo $Id; ?>" class="readmore">&#10132; Bericht lesen</a></p>
                        </span>
            </div>
          <?php } ?>


          <!--Pagination-->
          <div class="pagination">
              <ul>
                <?php
                 $QueryPagination = "SELECT COUNT(*) FROM admin_panel WHERE vergangen = 'True'";
                 $ExecutePagination = mysqli_query($Connection, $QueryPagination);
                 $RowPagination = mysqli_fetch_array($ExecutePagination);
                 $TotalPosts = array_shift($RowPagination);
                 $numberOfLinks = ($TotalPosts/4);
                 $numberOfLinks = ceil($numberOfLinks);
                 if($Page <= 0){
                   $i =1;
                 }
                 ?>
                 <li class="
                 <?php
                  if($Page<=1){
                    // if the page count is set lower than or equal to 1 disable the backward li
                    echo 'disabled';
                  }
                  ?>">
                    <a href="Start.php?Page=<?php echo $Page-1; ?>">&laquo;</a>
                  </li>
                 <?php
                   for($i=1; $i<=$numberOfLinks; $i++){

                     if($Page <= 0){
                       $Page = 1;
                     }

                     //if the pagination count equals the page number mark it active
                    if($i == $Page){
                  ?>
                  <li><a class="active"href="Start.php?Page=<?php echo $i; //echo the page number into the href ?>">
                    <?php echo $i; //echo the page number into the anchor as well  ?>
                  </a></li>
                  <?php
                        }
                        //if the pagination count does not equal the page number return a normal anchor
                        else{
                  ?>
                  <li ><a class=""href="Start.php?Page=<?php echo $i; //echo the page number into the href ?>">
                    <?php echo $i; //echo the page number into the anchor as well ?>
                  </a></li>
                <?php } } ?>
                <li class="
                <?php
                  // if the pagenumber is equal to the number of links, disable the forward li
                  if($Page==$numberOfLinks){ echo 'disabled';
                  }
                  ?>"><a href="Start.php?Page=<?php echo $Page+1; ?>">&raquo;</a>
                </li>
              </ul>
          </div>

        </div>

        <!--------------------Ausklappbarer Content Kommende Veranstaltungen----------------------->


        <div id="new" class="content-container hidden" style="display: none;">

            <br>

            <br>
            <!--Seitenüberschrift für die ausgewählte Seite-->
            <h2>Kommende Veranstaltungen</h2>

            <hr/ class="hiddenOnDesktop">


            <!--Platzschaffer unterm Trennstrich-->
            <br/>


            <?php
            $Execute = mysqli_query($Connection, $ViewQueryNew);
             while($DataRows = mysqli_fetch_array($Execute)){
              $Id = $DataRows["id"];
              $DateTime = $DataRows["datetime"];
              $Title = $DataRows["title"];
              $Category = $DataRows["category"];
              $author = $DataRows["author"];
              $Image = $DataRows["image"];
              $Post = $DataRows["post"];
              $PostDescription = $DataRows["postDescription"];
              ?>
            <!--Div für den ersten Report-->
            <div class="report">

                    <!--Report-Überschrift-->
                <!-- <span class="flexHeader">
                    <span style="visibility: hidden">30.11.2018</span><h3><?php echo htmlentities($Title); ?></h3><span><?php echo $author." | ".htmlentities($DateTime); ?></span></span> -->

                    <!--Bild als Link-->
                    <div>
                      <a href="FullPost.php?id=<?php echo $Id; ?>"><img src="../Back-End/Upload/<?php echo $Image; ?>" class="picturereport"></a>
                      <span>
                        <h3><?php echo htmlentities($Title); ?></h3>
                        <br>
                        <br>
                        <p><?php echo $author." | ".htmlentities($DateTime); ?></p>
                      </span>

                    </div>

                    <!--Reportbeschreibung-->
                    <span class="reportdescription"><p ><br/> <?php echo htmlentities($PostDescription); ?></p>

                    <!--Weiterlesen Link-->
                    <p><a href="FullPost.php?id=<?php echo $Id; ?>" class="readmore">&#10132; Bericht lesen</a></p>
                        </span>
            </div>
          <?php } ?>


            <!--Pagination-->
            <div class="pagination">
                <ul>
                  <?php
                   $QueryPagination = "SELECT COUNT(*) FROM admin_panel WHERE vergangen = 'False'";
                   $ExecutePagination = mysqli_query($Connection, $QueryPagination);
                   $RowPagination = mysqli_fetch_array($ExecutePagination);
                   $TotalPosts = array_shift($RowPagination);
                   $PostPerPage = ($TotalPosts/4);
                   $PostPerPage = ceil($PostPerPage);
                   if($Page <= 0){
                     $i =1;
                   }
                   ?>
                   <li><a href="Veranstaltungen.php?Page=<?php echo $Page-1; ?>">&laquo;</a></li>
                   <?php
                     for($i=1; $i<=$PostPerPage; $i++){

                       if($Page <= 0){
                         $Page = 1;
                       }
                      if($i == $Page){
                    ?>
                    <li><a class="active"href="Veranstaltungen.php?Page=<?php echo $i; ?>"><?php echo $i;  ?></a></li>
                <?php }else{ ?>
                  <li ><a class=""href="Veranstaltungen.php?Page=<?php echo $i; ?>"><?php echo $i;  ?></a></li>
                <?php } } ?>
                    <li><a href="Veranstaltungen.php?Page=<?php echo $Page+1; ?>">&raquo;</a></li>
                </ul>
            </div>

        </div>












    </div>
    <!----------------Footer----------------->


    <footer id="footer">

        <!--Impressum-->
        <div><p> <a href="#" class="impressum">Impressum</a></p></div>

        <!--Copyright-->

        <div><p>Copyright &copy; Innovative Programming JTown</p></div>

        <!--Zum Seitenanfang-->
        <p><a href="#sanfang"><i id="arrowup" class="fas fa-angle-up"></i></a></p>
    </footer>


    <script src="JS/script.js"></script>
    <script src="JS/veranstaltungen.js"></script>




</body>
</html>
