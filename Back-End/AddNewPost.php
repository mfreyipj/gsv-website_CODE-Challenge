<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>

<?php
  if(isset($_POST["Submit"])){
    $Title = mysqli_real_escape_string($Connection,$_POST["Title"]);
    $Category = mysqli_real_escape_string($Connection,$_POST["Category"]);
    $Post = mysqli_real_escape_string($Connection,$_POST["Post"]);

    date_default_timezone_set("Europe/Berlin");
    setlocale(LC_TIME, 'deu_deu');
    $currentTime= time();
    $DateTime = strftime("%d. %B %Y", $currentTime);
    $DateTime;
    $Admin=$_SESSION["Username"];
    $Image = $_FILES["Image"]["name"];
    $Target="Upload/".basename($_FILES["Image"]["name"]);
    if(empty($Title)){
      $_SESSION["ErrorMessage"] = "Title can't be empty";
      Redirect_to("AddNewPost.php");
    }elseif(strlen($Title)<3) {
      $_SESSION["ErrorMessage"] = "Title should be longer than 2 characters";
      Redirect_to("AddNewPost.php");
    }
    else{

      $Query="INSERT INTO admin_panel(datetime,title,category,author,image,post) VALUES('$DateTime','$Title','$Category','$Admin','$Image','$Post')";
      $Execute=mysqli_query($Connection,$Query);
      move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      if($Execute){
        $_SESSION["SuccessMessage"] = "Added Post Successfully";
        Redirect_to("AddNewPost.php");
      }
      else{
        $_SESSION["ErrorMessage"] = "Something went wrong";
        Redirect_to("AddNewPost.php");
      }

    }



  }
?>
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
                        <li id="userMenuListItem"><span id = "userMenuButton"><span><a onclick="dropDownUser()"><?php echo   substr($_SESSION["Username"], 0, 1) ?></a></span> </span></li>
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



        <!-- In this container, the navigation bar at the left of every admin panel page is defined.
            It consists of a basic unordered list of links to the main pages of the admin panel.
            The only uncommon feature is a count of unapproved comments right of the comments link.
            As the name suggests, it shows the logged in admin if there are any comments to approved and if there are, how many.
        -->
        <div class="side-nav">

          <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="allPosts.php">Alle Artikel</a></li>
            <li><a href="AddNewPost.php" class="active">Neuer Artikel</a></li>
            <li><a href="categories.php">Post-Kategorien</a></li>
            <li><a href="#">Kontakt-Inbox</a></li>
            <li><a href="admins.php">Admin-Verwaltung</a></li>
            <li><a href="#">Über Uns</a></li>
            <li><a href="comments.php">Comments
              <!--fetch number of unapproved comments and display it right of the comments hyperlink-->
              <?php
                $QueryTotal= "SELECT count(*) FROM comments WHERE status = 'OFF'";
                $ExecuteTotal = mysqli_query($Connection, $QueryTotal);
                $RowsTotal = mysqli_fetch_array($ExecuteTotal);
                $Total =array_shift($RowsTotal);?>
                <!--Only show the number if there are any unapproved comments-->
              <?php if($Total > 0){ ?>
            <span class="alert alert-warning "><?php echo $Total;?></span>
          <?php } ?></a>
            </li>
            <li><a href="../Front-End/calendar.html">Kalender</a></li>
            <li><a href="logout.php">Abmelden</a></li>
          </ul>
        </div>


        <div class="mainContent">
          <h1>Add New Post</h1>
          <?php echo Message();
          echo SuccessMessage();?>
          <div class="">
            <form class="" action="AddNewPost.php" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="form-group">
                  <label for="Title">Title:</label>
                  <input type="text" name="Title" value="" id="Title" placeholder="Title">
                </div>
                <div class="form-group">
                  <label for="categoryselect"><span class="FieldInfo">Category: </span></label>
                  <select class="form-control" id="categoryselect" name="Category">
                    <?php
                      $ViewQuery = "SELECT * FROM category ORDER BY id DESC";
                      $Execute = mysqli_query($Connection, $ViewQuery);

                      while($DataRows = mysqli_fetch_array($Execute)){
                        $Category = $DataRows["name"];
                     ?>
                     <option><?php echo $Category; ?></option>
                   <?php } ?>
                 </select>
                </div>
                <div class="form-group">
                  <label for="imageselect">Select Image:</label>
                  <input type="File" name="Image" id="imageselect" value="">
                </div>
                <div class="form-group">
                  <label for="postarea">Post:</label>
                  <textarea class="form-control" name="Post" id="postarea" rows=10></textarea>
                </div>


                <input class="btn btn-default" type="submit" name="Submit" value="Add New Post">
              </fieldset>
            </form>
          </div>




        </div>
      </div>
    </div>

    <script src="js/script.js"></script>


  </body>
</html>
