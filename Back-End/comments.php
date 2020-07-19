<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyles.css">
    <link rel="stylesheet" href="css/stylesForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="css/weirdflex.css">
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
                        <li id="userMenuListItem"><button id = "userMenuButton" class = "dropdownbtn" onclick="dropDownUser()"><?php echo   substr($_SESSION["Username"], 0, 1) ?></button></li>
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





    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2">
          <h1>MyBlog</h1>
          <ul id="Side_Menu" class="nav nav-pills flex-column">
            <li class="active"><a href="dashboard.php">Dashboard</a></li>
            <li><a href="AddNewPost.php">Add New Post</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="#">Add New Post</a></li>
            <li><a href="#">Manage Admins</a></li>
            <li><a href="#">Comments</a></li>
            <li><a href="#">Live-Blog</a></li>
            <li><a href="#">Logout</a></li>
          </ul>
        </div>
        <div class="col-sm-10">
          <?php echo Message();
          echo SuccessMessage();?>
          <h1>Unapproved Comments</h1>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Date</th>
                <th>Comment</th>
                <th>Approve</th>
                <th>Delete</th>
                <th>Details</th>
              </tr>
              <?php
                $Query = "SELECT * FROM comments WHERE status = 'OFF' ORDER BY id DESC";
                $Execute = mysqli_query($Connection, $Query);
                $SrNr = 0;
                while($DataRows = mysqli_fetch_array($Execute)){
                  $CommentId = $DataRows["id"];
                  $CommentDate = $DataRows["datetime"];
                  $CommentAuthor = $DataRows["name"];
                  $Comment = $DataRows["comment"];
                  $PostId = $DataRows["admin_panel_id"];
                  $SrNr++;


               ?>
               <tr>
                 <td><?php echo htmlentities($SrNr); ?></td>
                 <td><?php echo htmlentities($CommentAuthor); ?></td>
                 <td><?php echo htmlentities($CommentDate); ?></td>
                <td><?php echo htmlentities($Comment); ?></td>
                   <td> <a href="ApproveComments.php?id=<?php echo $CommentId; ?>"> <span class="btn btn-success">Approve</span> </a> </td>
                   <td> <a href="DeleteComments.php?id=<?php echo $CommentId; ?>"> <span class="btn btn-danger">Delete</span> </a> </td>
                   <td> <a href="../Front-End/FullPost.php?id=<?php echo $PostId; ?>" target="_blank"> <span class="btn btn-primary">Live-Preview</span> </a> </td>
               </tr>
             <?php } ?>
            </table>
          </div>
          <h1>Approved Comments</h1>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Date</th>

                <th>Comment</th>
                <th>Approved By</th>
                <th>Disapprove</th>
                <th>Delete</th>
                <th>Details</th>
              </tr>
              <?php
                $Admin = "Matthias Frey";
                $Query = "SELECT * FROM comments WHERE status = 'ON' ORDER BY id DESC";
                $Execute = mysqli_query($Connection, $Query);
                $SrNr = 0;
                while($DataRows = mysqli_fetch_array($Execute)){
                  $CommentId = $DataRows["id"];
                  $CommentDate = $DataRows["datetime"];
                  $CommentAuthor = $DataRows["name"];
                  $Comment = $DataRows["comment"];
                  $ApprovedBy = $DataRows["approvedby"];
                  $PostId = $DataRows["admin_panel_id"];
                  $SrNr++;


               ?>
               <tr>
                 <td><?php echo htmlentities($SrNr); ?></td>
                 <td><?php echo htmlentities($CommentAuthor); ?></td>
                 <td><?php echo htmlentities($CommentDate); ?></td>

                <td><?php echo htmlentities($Comment); ?></td>
                <td><?php echo htmlentities($ApprovedBy); ?></td>
                   <td> <a href="DisapproveComments.php?id=<?php echo $CommentId; ?>"> <span class="btn btn-warning">Disapprove</span> </a> </td>
                   <td> <a href="DeleteComments.php?id=<?php echo $CommentId; ?>"> <span class="btn btn-danger">Delete</span> </a> </td>
                   <td> <a href="../Front-End/FullPost.php?id=<?php echo $PostId; ?>" target="_blank"> <span class="btn btn-primary">Live-Preview</span> </a> </td>
               </tr>
             <?php } ?>
            </table>
          </div>
          </div>
        </div>



      </div>

      <script src="js/script.js"></script>



  </body>
</html>
