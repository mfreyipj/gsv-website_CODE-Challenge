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
    <link rel="stylesheet" href="css/dashboard.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
  </head>
  <body>
    <!--Bookmark zum Seitenanfang-->
    <div id="sanfang"> Copyright &copy; Innovative Programming JTown </div>

    <!--- Navigations-/Menubar-->
    <nav>

        <!--DropdownContainer-->
        <div class="dropdown navElement">

            <!--Hamburger Button, bei Klick wird Dropdown dargestellt-->
            <button id="hamburgerButton" onclick="dropDown(hamburger)"class="hamburger hamburger--slider" type="button">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>

            <!--Container für die Elemente der Navbar, in der Desktopvariante klassisch dargestellt-->
            <div class="dropdown-content" id="myDropdown">

              <img class="logonav hiddenOnMobile"  src="Upload/gsvGemontLogoWeissTransparent.png" alt="gemontlogo">

                <!--Linkliste-->
                <ul>


                    <li><span><a href="../Front-End/ueberuns.php">Über Uns</a></span></li>
                    <li id="userMenuListItem"><button id = "userMenuButton" class = "dropdownbtn" onclick="dropDownUser()"><?php echo   substr($_SESSION["Username"], 0, 1) ?></button></li>
                    <!-- <li><span><a href="#">Projekte und Inhalte</a></span>
                    </li> -->
                    <!--<li>GSV Logo (nur für den Desktop relevant)-->
                <!-- <img src="../Front-End/IMG/gsvGemontLogo.jpg" alt="gemontlogo" class="logonav" id="logodesktop" ></li>
                    <li><span><a href="../Front-End/Veranstaltungen.php" >Veranstaltungen</a></span></li>
                    <li><span><a href="../Front-End/newsletter.php" >Newsletter</a></span></li>
                    <li><span><a href="../Front-End/Kontakt.php" >Kontakt</a></span></li> -->
                </ul>

                <div id="userMenuDropDown" class = "divUserMenu">
                  <ul>
                    <li>Profilbild</li>
                    <li>Kontoeinstellungen</li>
                    <li><a href="logout.php">Abmelden</a></li>
                  </ul>
                </div>


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

    </nav>

    <div class="wrapper">
      <div class="side-nav">
        <ul class="Side-nav-list">
          <li class="active"><a href="dashboard.php">Alle Artikel</a></li>
          <li><a href="AddNewPost.php">Neuer Artikel</a></li>
          <li><a href="categories.php">Kategorien</a></li>
          <li><a href="#">Neue Kategorie</a></li>
          <li><a href="#">Admin-Verwaltung</a></li>
          <li><a href="comments.php">Comments <?php
            $QueryTotal= "SELECT count(*) FROM comments WHERE status = 'OFF'";
            $ExecuteTotal = mysqli_query($Connection, $QueryTotal);
            $RowsTotal = mysqli_fetch_array($ExecuteTotal);
            $Total =array_shift($RowsTotal);?>
            <?php if($Total > 0){ ?>
          <span class="alert alert-warning "><?php echo $Total;?></span>
        <?php } ?></a>
          </li>
          <li><a href="#">Startseite</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>

          <div class="table-posts">
            <?php echo Message();
            echo SuccessMessage();?>
            <p>Alle Posts</p>
              <table class="">
                <tr>
                  <th>No</th>
                  <th>Post Title</th>
                  <th>Date & Time</th>
                  <th>Author</th>
                  <th>Category</th>
                  <th>Banner</th>
                  <th>Comments</th>
                  <th>Action</th>
                  <th>Details</th>
                </tr>
                <?php
                  $ViewQuery = "SELECT * FROM admin_panel ORDER BY id DESC;";
                  $Execute = mysqli_query($Connection, $ViewQuery);
                  $PostNr = 0;
                  while($DataRows = mysqli_fetch_array($Execute)){

                    $Id = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $Title = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $Post = $DataRows["post"];
                    $PostNr++;
                    ?>

                    <tr>
                      <td><?php echo $PostNr; ?></td>
                      <td><?php
                        if(strlen($Title)>20){
                          $Title = substr($Title,0,20)."...";
                        }echo $Title;
                       ?>
                     </td>
                      <td>
                        <?php
                        if(strlen($DateTime)>22){
                          $DateTime = substr($DateTime,0,22)."..";
                        }echo $DateTime; ?>
                      </td>
                      <td><?php
                      if(strlen($Admin)>20){
                        $Admin = substr($Admin,0,20)."..";
                      }echo $Admin; ?></td>
                      <td><?php
                      if(strlen($Category)>8){
                        $Category = substr($Category,0,8)."..";
                      }

                      echo $Category; ?></td>
                      <td><img class="DashboardImage" src="Upload/<?php echo $Image; ?>"></td>
                      <td>
                        <?php
                          $QueryUnApproved = "SELECT count(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'OFF'";
                          $ExecuteUnApproved = mysqli_query($Connection, $QueryUnApproved);
                          $RowsUnApproved = mysqli_fetch_array($ExecuteUnApproved);
                          $TotalUnApproved =array_shift($RowsUnApproved);?>
                          <?php if($TotalUnApproved > 0){ ?>
                        <span class="alert alert-danger"><?php echo $TotalUnApproved;?></span>
                      <?php } ?>
                        <?php
                          $QueryApproved = "SELECT count(*) FROM comments WHERE admin_panel_id = '$Id' AND status = 'ON'";
                          $ExecuteApproved = mysqli_query($Connection, $QueryApproved);
                          $RowsApproved = mysqli_fetch_array($ExecuteApproved);
                          $TotalApproved =array_shift($RowsApproved);?>
                          <?php if($TotalApproved > 0){ ?>
                        <span class="alert alert-success "><?php echo $TotalApproved;?></span>
                      <?php } ?>


                      </td>
                      <td><a href="EditPost.php?Edit=<?php echo $Id; ?>"><span class="btn btn-warning">Bearbeiten</span> </a> <a href="DeletePost.php?Delete=<?php echo $Id; ?>"><span class="btn btn-danger">Löschen</span> </a></td>
                      <td><a href="../Front-End/FullPost.php?id=<?php echo $Id; ?>" target="_blank"> <span class="btn btn-primary">Vorschau</span> </a></td>



                  </tr>

                  <?php } ?>
              </table>


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
    <script src="js/script.js"></script>



  </body>
</html>
