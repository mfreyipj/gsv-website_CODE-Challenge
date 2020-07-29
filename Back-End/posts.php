<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>

    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/adminstyles.css">
    <!-- <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script> -->
    <link rel="stylesheet" href="css/weirdflex.css">
    <link rel=stylesheet href="css/stylesForAllMobile.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <link rel="stylesheet" href="css/stylesForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/messages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">

  </head>
  <body>
    <!--bookmark to scroll up to-->
    <div id="sanfang"> Copyright &copy; Innovative Programming JTown </div>


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

<!-- -------------------------------------- main content ---------------------------------------------- -->
    <!--
      In this container, the main content of the "all post"-page is defined.
    -->
    <div class="wrapper">



      <!-- In this container, the navigation bar at the left of every admin panel page is defined.
          It consists of a basic unordered list of links to the main pages of the admin panel.
          The only uncommon feature is a count of unapproved comments right of the comments link.
          As the name suggests, it shows the logged in admin if there are any comments to approved and if there are, how many.
      -->
      <div class="side-nav">

        <ul>
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="posts.php" class="<?php if($_GET["drafts"]){ echo "";} else{ echo "active";}?>">Alle Artikel</a></li>
          <li><a href="posts.php?drafts=true" class="<?php if($_GET["drafts"]){ echo "active";} else{ echo "";}?>">Entwürfe</a></li>
          <li><a href="createPost.php">Neuer Artikel</a></li>
          <li><a href="categories.php">Post-Kategorien</a></li>
          <li><a href="contactMessages.php">Kontakt-Inbox</a></li>
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


      <!-- In this container, the main content (right of the left side navigation) is stored.
        On this page, the main content consists of two tables which contain data about approved and unapproved comments.
      -->
      <div class="mainContent">

        <!-- below the top navigation bar, possible success or error messages will pop up -->
        <?php echo Message();
        echo SuccessMessage();?>

        <!-- table-containers are divs in which the various tables of the admin-panel together with their headings are stored -->

        <!-- This table-container contains the table of posts -->
        <div class="table-container">
          <!-- heading of the table -->
          <h3>Alle <?php if($_GET["drafts"]){ echo "Entwürfe";} else{ echo "Posts";}?> </h3>
          <table>
            <!-- the table head which contains the column's names
                Some column names have classes connected with them that define column-specific margins to the next column.
            -->
            <thead>
              <tr>
                <th>Nr.</th>
                <th><span class="tableTitleHeadingSpan">Titel</span></th>
                <th><span class="tableDateHeadingSpan">Datum</span></th>
                <th><span class="tableNameHeadingSpan">Author</span></th>
                <th><span class="tableCategoryHeadingSpan">Kategorie</span></th>
                <th>Kommentar-Anzahl</th>
                <th>Bearbeiten</th>
                <th>Löschen</th>
                <th>Details</th>
              </tr>
            </thead>

            <!-- the table's body which contains the data rows -->
            <tbody>
              <!-- script to fetch the wanted data from the db -->
              <?php

                if($_GET["drafts"]){
                  $ViewQuery = "SELECT * FROM admin_panel WHERE hidden = 1 ORDER BY id DESC;";
                }
                else{
                  // query that fetches all posts
                  $ViewQuery = "SELECT * FROM admin_panel WHERE hidden = 0 ORDER BY id DESC;";
                }


                $Execute = mysqli_query($Connection, $ViewQuery);
                // upcounting number at the beginning of each row
                $PostNr = 0;
                // as long as there still is data to be fetched this loop
                //will echo the fetched data into the assigned table cells
                // table cells are assigned with the given variables
                while($DataRows = mysqli_fetch_array($Execute)){

                  $Id = $DataRows["id"];
                  $DateTime = $DataRows["datetime"];
                  $Title = $DataRows["title"];
                  $Category = $DataRows["category"];
                  $Admin = $DataRows["author"];
                  $Post = $DataRows["post"];
                  $PostNr++;
                  ?>
                  <!-- table row into which the fetched data will be echoed -->
                  <tr>
                    <td><?php echo $PostNr; ?></td>
                    <td><?php
                      // function that shortens the table cells content to
                      // a length of 20 characters and adds ... to it if the
                      //limit is reached
                      if(strlen($Title)>20){
                        $Title = substr($Title,0,20)."...";
                      }echo $Title;
                     ?>
                   </td>
                    <td>
                      <?php
                      //same as above with 22 characters
                      if(strlen($DateTime)>22){
                        $DateTime = substr($DateTime,0,22)."..";
                      }echo $DateTime; ?>
                    </td>
                    <td><?php
                    //same as above with 20 characters
                    if(strlen($Admin)>20){
                      $Admin = substr($Admin,0,20)."..";
                    }echo $Admin; ?></td>
                    <td><?php
                    //same as above with 8 characters
                    if(strlen($Category)>8){
                      $Category = substr($Category,0,8)."..";
                    }
                    echo $Category; ?></td>
                    <td>
                    <?php
                        // query that fetches how many approved comments there
                        // are that are connected with the given article
                        $QueryApproved = "SELECT count(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'ON'";
                        $ExecuteApproved = mysqli_query($Connection, $QueryApproved);
                        $RowsApproved = mysqli_fetch_array($ExecuteApproved);
                        $TotalApproved =array_shift($RowsApproved);?>
                        <?php
                          // if there are unapproved comments, their count will be
                          // echoed
                          if($TotalApproved > 0){
                        ?>
                      <span class="count success"><?php echo $TotalApproved;?></span>
                    <?php } ?>
                    <?php
                      // query that fetches how many unapproved comments there
                      // are that are connected with the given article
                      $QueryUnApproved = "SELECT count(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'OFF'";
                      $ExecuteUnApproved = mysqli_query($Connection, $QueryUnApproved);
                      $RowsUnApproved = mysqli_fetch_array($ExecuteUnApproved);
                      $TotalUnApproved =array_shift($RowsUnApproved);?>
                      <?php
                        // if there are unapproved comments, their count will be
                        // echoed
                        if($TotalUnApproved > 0){
                      ?>
                    <span class="count failure"><?php echo $TotalUnApproved;?></span>
                    <?php } ?>

                    </td>
                    <td><a href="createPost.php?id=<?php echo $Id; ?>"><span class="">Bearbeiten</span> </a></td>
                    <td><a href="createPost.php?id=<?php echo $Id."&delete=true"; ?>"><span class="">Löschen</span> </a></td>
                    <td><a href="../Front-End/FullPost.php?id=<?php echo $Id; ?>&preview=true" target="_blank"> <span class="">Vorschau</span> </a></td>
                </tr>
                <?php } ?>
            </tbody>

          </table>
        </div>
      </div>

    </div>

<!-- ------------------------------------ scripts ------------------------------------------------ -->

    <script src="js/script.js"></script>



  </body>
</html>
