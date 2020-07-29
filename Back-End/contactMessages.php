<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php require_once('include/mail.php'); ?>
<?php confirmLogin(); ?>
<?php

if(isset($_POST["sendAnswer"])){
  $id = $_POST["id"];
  $answer = $_POST["answer"];
  $mailQuery = "SELECT * FROM contactMessages WHERE id = '$id'";
  $execute = mysqli_query($Connection, $mailQuery);
  if (!$execute) {
     printf("Error: %s\n", mysqli_error($Connection));
     exit();
  }
  else{
    while($DataRows = mysqli_fetch_array($execute)){
      $mailAddress = $DataRows["mailAddress"];
      $datetime = $DataRows["datetime"];
      $name = $DataRows["name"];
      $message = $DataRows["message"];
    }
  }
  $subject = "Antwort auf deine Nachricht vom ".$datetime;
  $body = "Deine Nachricht: \n".$message."\n \n Unsere Antwort: \n".$answer;
  sendMail($mailAddress,$subject,$body);
  $_SESSION["SuccessMessage"] = "Du hast erfolgreich geantwortet! Falls du deine Antwort noch einmal lesen möchtest, dann findest du sie in unserem gemeinsamen Email-Konto in den ausgegangenen Mails";

}
?>


<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/adminstyles.css">
    <link rel="stylesheet" href="css/stylesForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">

    <link rel="stylesheet" href="css/messages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/contactMessages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <!-- <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script> -->
  </head>
  <body>


    <!-- -------------------------------------- navbar top -------------------------------------- -->
          <!--- In this container, the navigation bar at the top of every admin panel page is defined.

                On mobile devices, the navbar consist of three main elements -
                the menu button (also called hamburger button), the page heading and the logo (from left to right).

                On the desktop the navigation bar consists of the gsv logo in the top left corner,
                a list of links to all user-end pages and a user-icon that activates a dropdown when clicked.
          -->

        <nav>


            <!--(mobile: container of the dropdown menu; of of three navelements(dropdown, heading, logo))-->
            <div class="dropdown navElement">

                <!--mobile: menu-button ("hamburger") - On click a dropdown menu with links to the main pages of the website will show up-->
                <button id="hamburgerButton" onclick="dropDown(hamburger)"class="hamburger hamburger--slider hiddenOnDesktop" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>

                <!--(mobile: container of the dropdown list) (desktop: container for all elements of the navbar) -->
                <div class="dropdown-content" id="myDropdown">

                  <!-- desktop: logo top left admin panel navbar-->
                  <img class="logonavDesktop hiddenOnMobile"  src="Upload/gsvGemontLogoWeissTransparent.png" alt="gemontlogo">


                    <ul>

                        <!--all devices: links to the user-end (both dropped down (mobile) and horizontally arranged (desktop))-->
                        <li><span><a href="../Front-End/Start.php" class="active">Startseite</a></span></li>
                        <li><span><a href="../Front-End/ueberuns.php">Über Uns</a></span></li>
                        <li><span><a href="../Front-End/Veranstaltungen.php" >Veranstaltungen</a></span></li>
                        <li><span><a href="../Front-End/newsletter.php" >Newsletter</a></span></li>
                        <li><span><a href="../Front-End/Kontakt.php" >Kontakt</a></span></li>
                        <!-- desktop: user icon in the top right corner of the admin panel navbar -->
                        <li id="userMenuListItem"><span id = "userMenuButton" onclick="dropDownUser()"><span><a ><?php echo   substr($_SESSION["Username"], 0, 1) ?></a></span> </span></li>
                    </ul>

                    <!-- desktop: menu that drops down when the admin clicks his round icon on the admin panel navbar -->
                    <div id="userMenuDropDown" class = "divUserMenu">
                      <ul>
                        <li><a href="#">Mein Profil</a></li>
                        <li><a href="#">Einstellungen</a></li>
                        <li><a href="logout.php">Abmelden</a></li>
                      </ul>
                    </div>
                </div>


            </div>

            <!-- mobile & tablet: name of the active page-->
            <div class="navElement hiddenOnDesktop">
                <h3>Alle Posts</h3>
            </div>

            <!--mobile & tablet GSV logo upper right corner-->
            <div class="navElement divLogoNav hiddenOnDesktop">
                <!--gsv logo-->
                <img class="logonavMobile" src="IMG/gsvGemontLogoWeissTransparent.png" alt="gemontlogo">
            </div>
        </nav>


    <div class="wrapper">


      <!-- In this container, the navigation bar at the left of every
        admin panel page is defined. It consists of a basic unordered list
        of links to the main pages of the admin panel. The only uncommon
        feature is a count of unapproved comments right of the comments link.
        As the name suggests, it shows the logged in admin if there are
        any comments to approved and if there are, how many.
      -->
      <div class="side-nav">

        <ul>
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="posts.php">Alle Artikel</a></li>
          <li><a href="posts.php?drafts=true">Entwürfe</a></li>
          <li><a href="createPost.php">Neuer Artikel</a></li>
          <li><a href="categories.php" >Post-Kategorien</a></li>
          <li><a href="contactMessages.php" class="active">Kontakt-Inbox</a></li>
          <li><a href="admins.php">Admin-Verwaltung</a></li>
          <li><a href="newGSV.php">GSV ankündigen</a></li>
          <li><a href="comments.php">Kommentare
            <!--fetch number of unapproved comments and display it right of the comments hyperlink-->
            <?php
              $QueryTotal= "SELECT count(*) FROM comments WHERE status = 'OFF'";
              $ExecuteTotal = mysqli_query($Connection, $QueryTotal);
              $RowsTotal = mysqli_fetch_array($ExecuteTotal);
              $Total =array_shift($RowsTotal);?>
              <!--Only show the number if there are any unapproved comments-->
            <?php if($Total > 0){ ?>
          <span class="count warning"><?php echo $Total;?></span>
        <?php } ?></a>
          </li>
          <li><a href="../Front-End/calendar.php">Kalender</a></li>
          <li><a href="logout.php">Abmelden</a></li>
        </ul>
      </div>

      <!-- In this container, the main content (right of the
        left side navigation) is stored. On this page, the main content
        consists of a table which contains data about the existing post
        categories and of a form with which the user can add a
        new category to the db.
      -->
      <div class="mainContent">

        <!-- below the top navigation bar, possible success or error
        messages will pop up -->
        <?php echo Message();
        echo SuccessMessage();?>

        <!-- heading of the page -->
        <h3>Empfangene Nachrichten</h3>

        <!-- table-containers are divs in which the various tables of the
        admin-panel together with their headings are stored -->

        <!-- This table-container contains the table of post categories -->
         <div class="table-container">
          <table>
            <!-- the table head which contains the column's name -->
            <thead>
              <tr>
                <th>Nr.</th>
                <th><span class="tableApprovedByHeadingSpan">Datum</span></th>
                <th><span class="tableApprovedByHeadingSpan">Absender</span></th>
                <th><span class="tableMessageHeadingSpan">Nachricht</span></th>
                <th>Komplette Nachricht lesen</th>
              </tr>
            </thead>
            <!-- the table's body which contains the data rows -->
            <tbody>
              <?php
                // query that fetches the categories from the db
                $ViewQuery = "SELECT * FROM contactMessages ORDER BY id DESC";
                $Execute = mysqli_query($Connection, $ViewQuery);
                $SrNr = 0;
                // As long as there still is data to be fetched this loop will
                // echo the fetched data into the assigned table cells.
                // table cells are assigned with the given variables
                while($DataRows = mysqli_fetch_array($Execute)){
                  $Id = $DataRows["id"];
                  $DateTime = $DataRows["datetime"];
                  $MailAddress = $DataRows["mailAddress"];
                  $CreatorName = $DataRows["name"];
                  $Message = $DataRows["message"];
                  if(strlen($Message)>40){
                    $Message = substr($Message ,0,40)."..";
                  }
                  $SrNr++;
               ?>
               <!-- table row in which the fetched data will be echoed -->
                <tr>
                 <td><?php echo $SrNr; ?></td>
                 <td><?php echo $DateTime; ?></td>
                 <td><?php echo $CreatorName; ?></td>
                 <td><?php echo "\"".$Message."\""; ?></td>
                 <td><a href="contactMessages.php?id=<?php echo $Id; ?>"><span class="">Komplette Nachricht lesen</span> </a> </td>
               </tr>

            </tbody>
            <?php } ?>
          </table>
        </div>


         <div class="message-container <?php if($_GET["id"]){ echo "showMessage";} ?>">

          <?php
             $Id = $_GET["id"];
             $ViewQuery = "SELECT * FROM contactMessages WHERE id = '$Id' ORDER BY id DESC";
             $Execute = mysqli_query($Connection, $ViewQuery);
             while($DataRows = mysqli_fetch_array($Execute)){
               $DateTime = $DataRows["datetime"];
               $MailAddress = $DataRows["mailAddress"];
               $CreatorName = $DataRows["name"];
               $Message = $DataRows["message"];

            }


          ?>

          <span class="fullMessageHeading"><p><?php echo $CreatorName." schrieb am ".$DateTime.":";?></p></span>
          <span class="fullMessage"><p><?php echo "\"".$Message."\"";?></p></span>
          <button class="btnSubmit answerButton"type="button" name="button" onclick="showAnswerForm()">Antworten</button>
          <form class="answer-form" id="answerForm" action="contactMessages.php" method="post">
            <textarea class="answerTextArea" name="answer" rows="8" cols="80" placeholder="Deine Antwort..."></textarea>
            <input type="hidden" name="id" value="<?php echo $Id; ?>">
            <input class="btnSubmit answerSubmit" type="submit" name="sendAnswer" value="Senden">
          </form>


        </div>


      </div>
    </div>



    <script src="js/script.js"></script>

  </body>
</html>
