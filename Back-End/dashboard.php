<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<?php

// total page views
$viewsCountQuery = "SELECT views FROM admin_panel";
$ExecuteQuery = mysqli_query($Connection, $viewsCountQuery);
while($resultArray = mysqli_fetch_array($ExecuteQuery)){
    $views = intval($resultArray["views"]);
    $viewsTotal = $viewsTotal + $views;
}

// post count
$postCountQuery = "SELECT COUNT(*) FROM admin_panel";
$ExecuteQuery = mysqli_query($Connection, $postCountQuery);
$resultArray = mysqli_fetch_array($ExecuteQuery);
if($resultArray){
  $postCount = array_shift($resultArray);
}
// comment count
$commentsCountQuery = "SELECT COUNT(*) FROM comments";
$ExecuteQuery = mysqli_query($Connection, $commentsCountQuery);
$resultArray = mysqli_fetch_array($ExecuteQuery);
if($resultArray){
  $commentsCount = array_shift($resultArray);
}
// approvedCommentsCount
$commentsCountQuery = "SELECT COUNT(*) FROM comments WHERE STATUS = 'ON'";
$ExecuteQuery = mysqli_query($Connection, $commentsCountQuery);
$resultArray = mysqli_fetch_array($ExecuteQuery);
if($resultArray){
  $approvedCommentsCount = array_shift($resultArray);
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
    <link rel="stylesheet" href="css/dashboard.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/messages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">

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
          <li><a href="dashboard.php" class="active">Dashboard</a></li>
          <li><a href="posts.php">Alle Artikel</a></li>
          <li><a href="posts.php?drafts=true">Entwürfe</a></li>
          <li><a href="createPost.php">Neuer Artikel</a></li>
          <li><a href="categories.php">Post-Kategorien</a></li>
          <li><a href="contactMessages">Kontakt-Inbox</a></li>
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

        <?php echo Message();
        echo SuccessMessage();?>
        <div class="stat-surrounding-container">
          <div class="stat-surrounding-container-col">
            <div class="stat-surrounding-container-row">
              <div class="stat-containerTop">
                <span>
                  <p class="number"><?php echo $viewsTotal; ?></p>
                <p class="numberExplanation">Aufrufe auf allen Seiten</p>
              </span>
              </div>

              <div class="stat-containerTop">
                <span>
                  <p class="number"><?php echo $postCount; ?></p>
                <p class="numberExplanation">Veröffentlichte Artikel</p>
                </span>
              </div>

              <div class="stat-containerTop">
                <span>
                  <p class="number"><?php echo $commentsCount; ?></p>
                <p class="numberExplanation">Kommentare</p>
              </span>
              </div>
            </div>
            <br>
            <div class="stat-surrounding-container-row">
              <div class="stat-containerDetails">
                  <table>
                    <thead>
                      <tr>
                        <th>Aufrufart</th>
                        <th>Aufrufe</th>
                      </tr>
                    </thead>
                    <?php
                      $ViewQuery = "SELECT * FROM admin_panel";
                      $Execute = mysqli_query($Connection, $ViewQuery);
                      $SrNr = 0;
                      // As long as there still is data to be fetched this loop will
                      // echo the fetched data into the assigned table cells.
                      // table cells are assigned with the given variables
                      while($DataRows = mysqli_fetch_array($Execute)){
                        $Id = $DataRows["id"];
                        $views = $DataRows["views"];

                        $admin_views = intval($DataRows["admin_views"]);
                        $admin_viewsTotal = $admin_viewsTotal + $admin_views;
                        $CreatorName = $DataRows["creatorname"];
                        $SrNr++;
                        }

                        $viewsTotalAdminPercentage = ($admin_viewsTotal/$viewsTotal);
                    ?>
                    <tbody>
                      <tr>
                        <td><?php echo "Normale Aufrufe"; ?></td>
                        <td><?php
                        if(intval(strlen($viewsTotalAdminPercentage))==3){
                          echo substr(1-$viewsTotalAdminPercentage, 2, 2)."0%";
                        }else{
                          echo substr(1-$viewsTotalAdminPercentage, 2, 2)."%";
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <td><?php echo "Admin-Aufrufe"; ?></td>
                        <td><?php
                        if(intval(strlen($viewsTotalAdminPercentage))==3){
                          echo substr($viewsTotalAdminPercentage, 2, 2)."0%";
                        }else{
                          echo substr($viewsTotalAdminPercentage, 2, 2)."%";
                        }
                        ?></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
              <div class="stat-containerDetails">
                <table>
                    <thead>
                      <tr>
                        <th>Meistgesehene Posts</th>
                        <th>Aufrufe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $ViewQuery = "SELECT * FROM admin_panel ORDER BY views DESC LIMIT 3";
                        $Execute = mysqli_query($Connection, $ViewQuery);
                        $SrNr = 0;
                        // As long as there still is data to be fetched this loop will
                        // echo the fetched data into the assigned table cells.
                        // table cells are assigned with the given variables
                        while($DataRows = mysqli_fetch_array($Execute)){
                          $Id = $DataRows["id"];
                          $views = $DataRows["views"];
                          $title = $DataRows["title"];
                          $CreatorName = $DataRows["creatorname"];
                          $SrNr++;
                      ?>
                      <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $views; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
              </div>
              <div class="stat-containerDetails">
                  <table>
                    <?php
                      $ViewQuery = "SELECT COUNT(*) FROM comments WHERE STATUS = 'OFF'";
                      $Execute = mysqli_query($Connection, $ViewQuery);
                      $ViewQuery = "SELECT COUNT(*) FROM comments WHERE STATUS = 'OFF'";
                      $Execute = mysqli_query($Connection, $ViewQuery);
                      $SrNr = 0;
                      // As long as there still is data to be fetched this loop will
                      // echo the fetched data into the assigned table cells.
                      // table cells are assigned with the given variables
                      while($DataRows = mysqli_fetch_array($Execute)){
                        $Id = $DataRows["id"];
                        $views = $DataRows["views"];

                        $admin_views = intval($DataRows["admin_views"]);
                        $admin_viewsTotal = $admin_viewsTotal + $admin_views;
                        $CreatorName = $DataRows["creatorname"];
                        $SrNr++;
                        }

                        $commentsApprovedPercentage = ($approvedCommentsCount/$commentsCount);
                    ?>
                    <tbody>
                      <tr>
                        <td><?php echo "Freigegeben"; ?></td>
                        
                        <td><?php
                        if(intval(strlen($commentsApprovedPercentage))==3){
                          echo substr($commentsApprovedPercentage, 2, 2)."0%";
                        }else{
                          echo substr($commentsApprovedPercentage, 2, 2)."%";
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <td><?php echo "Gesperrt"; ?></td>
                        <td><?php
                        if(intval(strlen($commentsApprovedPercentage))==3){
                          echo substr(1-$commentsApprovedPercentage, 2, 2)."0%";
                        }else{
                          echo substr(1-$commentsApprovedPercentage, 2, 2)."%";
                        }
                        ?></td>
                      </tr>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
          <script src="js/script.js"></script>
  </body>
</html>
