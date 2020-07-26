<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8' />

    <!--Name der Seite im Tab-->
    <title>Kalender | GSV Gemont</title>

    <!--Aktuelles Charset-->
    <meta charset="utf-8">

    <!--Anpassung an Bildschirmgröße-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Stylesheet für Smartphones (10-2018)-->
    <link rel=stylesheet href="CSS/fullcalendar/fullcalendarMobile.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <link rel=stylesheet href="CSS/CSSforAll/mobileCssForAll.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <!--Stylesheet für Tablets (10-2018)-->
    <!-- <link rel="stylesheet" href="#" media="screen and (min-width: 601px) and (max-width: 5000px)"> -->

    <!--Stylesheet für Desktops (10-2018)-->
    <link rel="stylesheet" href="CSS/fullcalendar/fullcalendar.css" media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="CSS/CSSforAll/cssForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <!--Icon Einbindung-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!--JQuery Einbindung-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <link href='fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
    <link href='fullcalendar/packages/timegrid/main.css' rel='stylesheet' />

    <link href='fullcalendar/packages/list/main.css' rel='stylesheet' />
    <script src='fullcalendar/packages/core/main.js'></script>
    <script src='fullcalendar/packages/interaction/main.js'></script>
    <script src='fullcalendar/packages/daygrid/main.js'></script>
    <script src='fullcalendar/packages/timegrid/main.js'></script>
    <script src='fullcalendar/packages/list/main.js'></script>
    <script src='fullcalendar/packages/google-calendar/main.js'></script>

    <script src = 'JS/fullcalendar.js'></script>

  </head>
  <body>

        <!--Bookmark zum Seitenanfang-->
        <div id="sanfang"> Copyright &copy; Innovative Programming JTown </div>

        <!--- Navigations-/Menubar-->
        <nav>

            <!--DropdownContainer-->
            <div class="dropdown navElement">

                <!--Hamburger Button, bei Klick wird Dropdown dargestellt-->
                <button id="hamburgerButton" onclick="dropDown()"class="hamburger hamburger--slider" type="button">
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
                    <img src="IMG/gsvGemontLogo.jpg" alt="gemontlogo" class="logonav" id="logodesktop" ></li>
                        <li><span><a href="Veranstaltungen.php" >Veranstaltungen</a></span></li>
                        <li><span><a href="newsletter.php" >Newsletter</a></span></li>
                        <li><span><a href="Kontakt.php">Kontakt</a></span></li>
                    </ul>
                </div>
            </div>

            <!--Name der aktuellen Seite mittig in der Navbar (Tablet&Smartphone)-->
            <div class="navElement hiddenOnDesktop">
                <h3>Kontakt</h3>
            </div>

            <!--GSV Logo Rechts oben in der Navbar (Tablet & Smartphone)-->
            <div class="divLogoNav navElement">
                <!--GSV Logo-->
                <img class="logonav" id="logomobile" src="IMG/gsvGemontLogoWeissTransparent.png" alt="gemontlogo">
            </div>

            <!--Container des Timerbanners-->
            <div class="timerbanner">
                <!--Timer im Timerbanner-->
                <div id="timerdesktop"></div>
            </div>

            <div class="searchbar-container">
              <form class="searchNavTop" action="Veranstaltungen.php" method="get" id="searchform">

                <input class="searchInput" type="text" name="Search" value="" placeholder="Suche nach Posts" autocomplete="off">
                <button form="searchform"type="submit" name="submitSearch" class="searchbarSubmit"><i class= ' fas fa-search '></i> </button>

              </form>

            </div>
        </nav>

    <div class="pageInfo">
      <h2>Unser Kalender!</h2>
      <p>Auf dieser Seite könnt ihr alle Termine der GSV und (wenn wir es schaffen) auch <br>alle anderen möglichen Termine für Schülervertreter nachschlagen. <br><br>
        Wenn ihr einen Termin findet, den wir hier noch nicht eingetragen haben, <br> gebt ihn uns doch bitte einfach über die Kontakt-Seite durch. <br>
        Vielen Dank!
      </p>
    </div>

    <div class="fullcalendar">
      <div id='loading'>loading...</div>

      <div id='calendar'></div>

    </div>


    <footer id="footer">

        <!--Impressum-->
        <div><p> <a href="#" class="impressum">Impressum</a></p></div>

        <!--Copyright-->

        <div><p>Copyright &copy; Innovative Programming JTown</p></div>

        <!--Zum Seitenanfang-->
        <p><a href="#sanfang"><i id="arrowup" class="fas fa-angle-up"></i></a></p>
    </footer>

    <script type="text/javascript" src="JS/script.js"></script>
  </body>
</html>
