<?php  require_once('DB.php');?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>
<?php require_once('../Back-End/html2text/html2text.php'); ?>
<?php require_once('timerscript.php'); ?>
<?php

  //Search View Query
  if(isset($_GET["SearchButton"])){
    $Search = $_GET["Search"];
    $ViewQuery = "SELECT * FROM admin_panel WHERE
    datetime LIKE '%$Search%'
    OR title LIKE '%$Search%'
    OR category LIKE '%$Search%'
    OR author LIKE '%$Search%'
    OR post LIKE '%$Search%'";

  }
  if (isset($_GET["Page"])) {
    // Query for Pagination
    $Page = $_GET["Page"];
    $ShowPostFrom = ($Page * 4)-4;
    if($ShowPostFrom < 0){
      $ShowPostFrom = 0;
    }
    //LIMIT (number of rows to be skipped), (maximum number of rows that shall be returned)
    $ViewQuery = "SELECT * FROM admin_panel WHERE hidden = 0 ORDER BY id DESC LIMIT $ShowPostFrom, 4";
  }
  else{
    //Default View Query
    $Page = 1;
    $ShowPostFrom = ($Page * 4)-4;
    if($ShowPostFrom < 0){
      $ShowPostFrom = 0;
    }
    $ViewQuery = "SELECT * FROM admin_panel WHERE hidden = 0 ORDER BY id DESC LIMIT $ShowPostFrom,4";
  }


  $SlideQuery = "SELECT * FROM admin_panel WHERE important = 'True' AND hidden = 0 ORDER BY id DESC LIMIT 4";
  $ExecuteSlide = mysqli_query($Connection, $SlideQuery);
  ?>
<!--Definierung des Dokuments als HTML 5-->
<!DOCTYPE html>
<html lang="de">

<!--Metadaten-->
<head>

    <!--Name der Seite im Tab-->
    <title>Start | GSV Gemont</title>

    <!--Aktuelles Charset-->
    <meta charset="utf-8">

    <!--Anpassung an Bildschirmgröße-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Icon Einbindung-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!--JQuery Einbindung-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!--Icon Einbindung-->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!--Stylesheet für Smartphones (10-2018)-->
    <link rel=stylesheet href="CSS/CSSforAll/mobileCssForAll.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <link rel=stylesheet href="CSS/1-Start/startMobile.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >

    <!--Stylesheet für Tablets (10-2018)-->
    <!-- <link rel="stylesheet" href="#" media="screen and (min-width: 601px) and (max-width: 1000px)" > -->

    <!--Stylesheets für Desktops (10-2018)-->

    <link rel="stylesheet" href="CSS/CSSforAll/cssForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="CSS\1-Start\start.css" media="screen and (min-width: 1000px) and (max-width: 5000px)" >


</head>


<body>




    <!--Bookmark zum Seitenanfang-->
    <div id="sanfang"> Copyright &copy; Innovative Programming JTown </div>

    <!--- Navigations-/Menubar-->
    <nav>

        <!--DropdownContainer-->
        <div class="dropdown navElement">

            <!--Hamburger Button, bei Klick wird Dropdown dargestellt-->
            <button id="hamburgerButton" onclick="dropDownHamburger()"class="dropdownbtn hamburger hamburger--slider" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>

            <!--Container für die Elemente der Navbar, in der Desktopvariante klassisch dargestellt-->
            <div class="dropdown-content" id="myDropdown">



                <!--Linkliste-->
                <ul>

                    <li><span><a href="Start.php" class="active">Startseite</a></span></li>
                    <li><span><a href="ueberuns.php">Über Uns</a></span></li>
                    <!-- <li><span><a href="#">Projekte und Inhalte</a></span>
                    </li> -->
                    <li><!--GSV Logo (nur für den Desktop relevant)-->
                <img src="IMG/gsvGemontLogo.jpg" alt="gemontlogo" class="logonav" id="logodesktop" ></li>
                    <li><span><a href="Veranstaltungen.php" >Veranstaltungen</a></span></li>
                    <li><span><a href="newsletter.php" >Newsletter</a></span></li>
                    <li><span><a href="Kontakt.php" >Kontakt</a></span></li>
                </ul>
            </div>


        </div>

        <!--Name der aktuellen Seite mittig in der Navbar (Tablet&Smartphone)-->
        <div class="navElement hiddenOnDesktop">
            <h3>Start</h3>
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




    <div class="wrapper">

      <div class="slideContainer">

        <div class="carousel">

          <div class="slider" style = "transform: translateX(0%);">

              <?php
              while($DataRows = mysqli_fetch_array($ExecuteSlide)){
                $Id = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $Title = $DataRows["title"];
                $Image = $DataRows["image"];
                $Author = $DataRows["author"];
             ?>
            <div><a href="FullPost.php?id=<?php echo $Id; ?>"><img src="../Back-End/Upload/<?php echo $Image; ?>" alt=""></a>
              <span><span><h2><?php echo $Title; ?></h2><br class="hiddenOnMobile"><br>
              <p> <?php echo $Author; ?> | <?php echo $DateTime; ?></p></span>

              </span>
            </div>
          <?php } ?>
          </div>
          <div class="control">
            <span class="arrow left">
              <i class="material-icons">
              keyboard_arrow_left
              </i>
            </span>
            <span class="arrow right">
              <i class="material-icons">
              keyboard_arrow_right
              </i>
            </span>
            <ul>
              <li class="selected"></li>
              <li></li>
              <li></li>
              <li></li>
            </ul>
          </div>
        </div>
      </div>
      <script src="JS/StartJS.js"></script>
      <div class="mottoBanner" >
        <span>Freiheit, Freude und Demokratie</span>
      </div>
      <hr id="news">
      <br>
      <br>
      <h3>Das Neueste</h3>
      <br>
      <br>

      <section class="newsContainer">
        <!--Bookmark zum Seitenanfang-->
        <div id="newsFeed">Copyright &copy; Innovative Programming JTown </div>
           <ul class="newsList" >
             <?php
             $Execute = mysqli_query($Connection, $ViewQuery);
              while($DataRows = mysqli_fetch_array($Execute)){
               $Id = $DataRows["id"];
               $DateTime = $DataRows["datetime"];
               $Title = $DataRows["title"];
               $Category = $DataRows["category"];
               $author = $DataRows["author"];
               $Image = $DataRows["image"];
               $PostDescription = $DataRows["postDescription"];
               ?>

            <li>
              <a class="feedLinks" href="FullPost.php?id=<?php echo $Id; ?>">
              <img src="../Back-End/Upload/<?php echo $Image ?>" alt="">
              <br>
              <br>
              <h4><?php echo htmlentities($Title); ?> </h4>
              <br>
              <div class="postTeaser">
                <p><?php

                   echo $PostDescription;


                 ?></p>
              </div>

              <span> <?php
               echo $author." | ".$DateTime; ?></span>
               </a>
             </li>

            <?php } ?>

          </ul>
    </section>

      <br>
      <br>
      <!--Pagination-->
      <div class="pagination">
          <ul>
            <?php
            // query that counts the number of existings posts
             $QueryPagination = "SELECT COUNT(*) FROM admin_panel";
             $ExecutePagination = mysqli_query($Connection, $QueryPagination);
             $RowPagination = mysqli_fetch_array($ExecutePagination);
             // save the first element of the result array in $TotalPosts
             $TotalPosts = array_shift($RowPagination);

             $numberOfLinks = ($TotalPosts/4);
             // rundet die berechnete Zahl auf
             $numberOfLinks = ceil($numberOfLinks);
             // example : 10 existing posts/4=2.5 -> $numberOfLinks = 3
             if ($numberOfLinks > 4){
               $numberOfLinks = 4;
             }
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
              //
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


    <footer id="footer">

        <!--impressum-->
        <div><p> <a href="#" class="impressum">Impressum</a></p></div>

        <!--Copyright-->

        <div><p>Copyright &copy; Innovative Programming JTown</p></div>

        <!--Zum Seitenanfang-->
        <p><a href="#sanfang"><i id="arrowup" class="fas fa-angle-up"></i></a></p>
    </footer>


    <!---Javascript-Skripte-->
    <script src="JS/script.js"></script>
    <?php if(isset($_GET["Page"])){ echo "<script type=\"text/javascript\">window.onload = function(){document.getElementById(\"newsFeed\").scrollIntoView();}</script>";} ?>
</body>
</html>
