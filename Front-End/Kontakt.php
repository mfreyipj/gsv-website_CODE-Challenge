<?php require_once('../Back-End/include/DB.php'); ?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>


<!--Definierung des Dokuments als HTML 5-->
<!DOCTYPE html>
<html lang="de">

<!--Metadaten-->
<head>

    <!--Name der Seite im Tab-->
    <title>Kontakt | GSV Gemont</title>

    <!--Aktuelles Charset-->
    <meta charset="utf-8">

    <!--Anpassung an Bildschirmgröße-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Stylesheet für Smartphones (10-2018)-->
    <link rel=stylesheet href="CSS/6-Kontakt/mobileContact.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <link rel=stylesheet href="CSS/CSSforAll/mobileCssForAll.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <!--Stylesheet für Tablets (10-2018)-->
    <!-- <link rel="stylesheet" href="#" media="screen and (min-width: 601px) and (max-width: 1000px)"> -->

    <!--Stylesheet für Desktops (10-2018)-->
    <link rel="stylesheet" href="CSS/6-Kontakt/contact.css" media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="CSS/CSSforAll/cssForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="../Back-End/css/messages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel=stylesheet href="CSS/messagesUserEnd.css" media="screen and (min-width: 1000px) and (max-width: 5000px)" >
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
            <button id="hamburgerButton" onclick="dropDown()"class="dropdownbtn hamburger hamburger--slider" type="button">
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
                    <li><span><a href="Kontakt.php" class="active">Kontakt</a></span></li>
                </ul>
            </div>
        </div>

        <!--Name der aktuellen Seite mittig in der Navbar (Tablet&Smartphone)-->
        <div class="navElement hiddenOnDesktop">
            <h3 >Kontakt</h3>
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

    <!-- below the top navigation bar, possible success or error
    messages will pop up -->
    <?php
    echo Message();
    echo SuccessMessage();?>


    <div class="wrapper">


        <div class="contactIntro text">
            <h2>Sende uns auch Deine Ideen!</h2>
            <br>
            <p>Liebe Schülerin oder lieber Schüler, <br> gerne würden wir mehr mit dir in Kontakt treten und noch genauer auf deine Wünsche und Probleme eingehen können. <br/>
                Um dir dies zu ermöglichen, haben wir ein Kontaktformular eingerichtet, über das du deine Fragen, Anregungen etc. direkt an uns stellen kannst.<br>
                Wir freuen uns schon auf dich!<br>



        </div>

        <br>

        <form class="contact-form" method="post" action="sendMessage.php" >

            <input class="form-control" type="text" name="name"  placeholder="Dein Name..." required > <br>

            <input class="form-control"type="email" name="email"  placeholder="Deine Email Adresse..."> <br>

            <textarea rows="4" cols="50" maxlength="250"class="form-control contactmessage" placeholder="Deine Nachricht (max 250 Zeichen)..." name="message"></textarea> <br>

            <input class="form-control submit" type="submit" name="sendContactMessage" value="Senden"> <br>
        </form>



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
