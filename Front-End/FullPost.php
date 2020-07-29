<?php require_once('DB.php');?>
<?php require_once('../Back-End/include/Sessions.php'); ?>
<?php require_once('../Back-End/include/Functions.php'); ?>
<?php require_once('timerscript.php'); ?>
<?php require_once('../Back-End/include/countingScript.php'); ?>
<?php
  $PostId = $_GET["id"];
  if(isset($_POST["submit"])){

    $Name = mysqli_real_escape_string($Connection,$_POST["name"]);
    $Email = mysqli_real_escape_string($Connection,$_POST["email"]);
    $Comment = mysqli_real_escape_string($Connection,$_POST["comment"]);

    $currentTime= time();
    $day = strftime("%d", $currentTime);
    $year = strftime("%Y", $currentTime);
    $monthnames = array(
      1=>"Januar",
      2=>"Februar",
      3=>"März",
      4=>"April",
      5=>"Mai",
      6=>"Juni",
      7=>"Juli",
      8=>"August",
      9=>"September",
      10=>"Oktober",
      11=>"November",
      12=>"Dezember");
    $monthNumber = intval(strftime("%m", $currentTime));
    $monthNameGer = $monthnames[$monthNumber];

    $DateTime = $day.". ".$monthNameGer." ".$year;

    if(empty($Name)||empty($Email)||empty($Comment)){
      $_SESSION["ErrorMessage"] = "All fields are required";

    }elseif(strlen($Comment)>500) {
      $_SESSION["ErrorMessage"] = "Comment can't be longer than 500 characters";

    }
    else{
      $Query="INSERT INTO comments(datetime, name, email, comment, status, admin_panel_id) VALUES('$DateTime', '$Name', '$Email', '$Comment', 'ON', '$PostId');";
      $ExecuteQuery = mysqli_query($Connection, $Query);
      if($ExecuteQuery){
        $_SESSION["SuccessMessage"] = "Wir haben deinen Kommentar empfangen! Vielen Dank!";
        Redirect_to("FullPost.php?id={$PostId}");
      }
      else{
        $_SESSION["ErrorMessage"] = "Something went wrong";
        Redirect_to("FullPost.php?id={$PostId}");
      }

    }



  }
?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <!--Stylesheet für Smartphones (07-2019)-->
    <link rel=stylesheet href="CSS/FullPost/fullPostMobile.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <link rel=stylesheet href="CSS/CSSforAll/mobileCssForAll.css" media="screen and (min-width: 200px) and (max-width: 1000px)" >
    <!--Stylesheet für Desktops (07-2019)-->
    <link rel="stylesheet" href="CSS/FullPost/fullPost.css" media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="CSS/CSSforAll/cssForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="../Back-End/css/messages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/weirdflex.css">
    <!--Icon Einbindung-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script>
  </head>
  <body>




      <!--Bookmark zum Seitenanfang-->
      <div id="sanfang"> Copyright &copy; Innovative Programming JTown </div>

      <!--- Navigations-/Menubar-->
      <nav>


        <?php
          if($_GET["preview"] == 'true'){
            $PostId = $_GET["id"];
            echo '<form class="" action="../Back-End/createPost.php?id='.$PostId.'" method="post">
              <input type="submit" name="EndPreview" value="Preview Beenden">
            </form>';
          }

        ?>

          <!--DropdownContainer-->
          <div class="dropdown navElement">

              <!--Hamburger Button, bei Klick wird Dropdown dargestellt-->
              <button id="hamburgerButton" onclick="dropDown()"class=" dropdownbtn  hamburger hamburger--slider hiddenOnDesktop" type="button">
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
                      <li><span><a href="Veranstaltungen.php" class="active">Veranstaltungen</a></span></li>
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


          <div class="mainContent">
            <div class="mainContentWrapper">


            <?php
              if(isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];
                $ViewQuery = "SELECT * FROM admin_panel WHERE
                datetime LIKE '%$Search%'
                OR title LIKE '%$Search%'
                OR category LIKE '%$Search%'
                OR author LIKE '%$Search%'
                OR post LIKE '%$Search%'";

              }
              else{
                $PostIdFromURL=$_GET["id"];
                $ViewQuery = "SELECT * FROM admin_panel WHERE id = '$PostIdFromURL' ORDER BY id DESC";
              }

              $Execute = mysqli_query($Connection, $ViewQuery);

              while($DataRows = mysqli_fetch_array($Execute)){

                $Id = $DataRows["id"];
                $DateTime = $DataRows["datetime"];
                $Title = $DataRows["title"];
                $SubTitle = $DataRows["subtitle"];
                $Category = $DataRows["category"];
                $author = $DataRows["author"];
                $Image = $DataRows["image"];
                $Post = $DataRows["post"];
                $PostDescription = $DataRows["postDescription"];

             ?>
             <?php echo Message();
             echo SuccessMessage();?>
             <div class="title-container">
               <h2 class="postTitle"><?php echo htmlentities($Title); ?> <span class="timestamp"><?php echo htmlentities($DateTime); ?><span></h2>
                 <br>
               <h3><?php echo htmlentities($SubTitle); ?></h3>
             </div>

                <!-- <br> -->




                <img class ="thumbnail"src="../Back-End/Upload/<?php echo $Image ?>" alt="">
                <h4 class="postDescription"> <?php echo $PostDescription; ?></h4>
                 <p class="post">
                   <?php
                    echo nl2br($Post);
                    ?>
                </p>
                <p class="author"><span>geschrieben von: <?php echo $author; ?></span></p>


             <br>
           <?php } ?>
           <form class="contact-form" action="FullPost.php?id=<?php echo $PostId;?>" method="post" enctype="multipart/form-data">

               <input class="form-control" type="text" name="name"  placeholder="Dein Name..." required > <br>

               <input class="form-control"type="email" name="email"  placeholder="Deine Email Adresse..." required> <br>

               <textarea rows="4" cols="50" class="form-control" name="comment" placeholder="Dein Kommentar..."></textarea> <br>

               <input class="form-control submit" type="submit" name="submit" value="Senden"> <br>
           </form>


           <?php
            $PostId;
            $CommentQuery = "SELECT * FROM comments WHERE admin_panel_id = '$PostId' AND status = 'ON';";
            $Execute = mysqli_query($Connection, $CommentQuery);
            while($DataRows = mysqli_fetch_array($Execute)){
              $CommentDate = $DataRows["datetime"];
              $CommentName = $DataRows["name"];
              $Comment = $DataRows["comment"];


           ?>


           <section class="comment">
             <br>
             <p class="commentHeading"><?php echo $CommentName." - ".$CommentDate;?></p>
             <p class="commentText"><?php echo nl2br($Comment);}?></p>

           </section>



           </div>
      </div>
      <div class="sideContent">
        <div class="sideContentWrapper">


          <div class="panel-heading">
            <h2 class="panel-title">Letzte Berichte</h2>
          </div>
          <br>
          <div class="panel-body">
            <?php
              $Query = "SELECT * FROM admin_panel ORDER BY id DESC LIMIT 4";
              $Execute = mysqli_query($Connection, $Query);
              while($DataRows = mysqli_fetch_array($Execute)){
                $Id = $DataRows["id"];
                $Title = $DataRows["title"];
                $DateTime = $DataRows["datetime"];
                $Image = $DataRows["image"];

            ?>
            <a href="FullPost.php?id=<?php echo $Id; ?>">
              <div class="link-container">

                <img class="imageSideNav" src="../Back-End/Upload/<?php echo $Image; ?>" alt="">


                <span "titleSideNav"><h3><?php echo htmlentities($Title); ?></h3><br><p> <?php echo htmlentities($DateTime); ?></p></span>


              </div>
            </a>


          <?php } ?>
          </div>
          <div class="panel-footer">

          </div>


        </div><!-- SideContentWrapper Ende -->
      </div><!-- SideContent Ende -->
    </div> <!-- Wrapper-Ende -->
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

  </body>
</html>
