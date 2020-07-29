<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php confirmLogin(); ?>

<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="css/adminstyles.css">
    <link rel="stylesheet" href="css/stylesForAll.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/messages.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <link rel="stylesheet" href="css/createNewPostD.css"  media="screen and (min-width: 1000px) and (max-width: 5000px)">
    <script src="https://cdn.tiny.cloud/1/tzq2o85s4sy6w1wuy9fn4q9eyy60mz302wwpxji33z8r5l1h/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
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




        <!-- In this container, the navigation bar at the left of every admin panel page is defined.
            It consists of a basic unordered list of links to the main pages of the admin panel.
            The only uncommon feature is a count of unapproved comments right of the comments link.
            As the name suggests, it shows the logged in admin if there are any comments to approved and if there are, how many.
        -->
        <div class="side-nav">

          <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="posts.php">Alle Artikel</a></li>
            <li><a href="posts.php?drafts=true">Entwürfe</a></li>
            <li><a href="createPost.php" class="active">Neuer Artikel</a></li>
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
          On this page, the main content consists of a form that is used to
          create new posts.
        -->
        <div class="mainContent">

          <!-- below the top navigation bar, possible success or error
          messages will pop up -->
          <?php echo Message();
          echo SuccessMessage();?>


          <!-- form-containers are divs in which the various forms of the
          admin-panel are stored -->

          <!-- This form-container contains a form which is used to
          create new posts -->

          <?php
            date_default_timezone_set("Europe/Berlin");
            setlocale(LC_TIME, 'deu_deu');
            $currentTime= time();
            $DateTime = strftime("%d. %B %Y", $currentTime);
            // Default value for checkbox spotlight
            $SpotlightToBeUpdated = "true";
            if($_GET["id"]){
              $SearchQueryParameter = $_GET['id'];
              $Query = "SELECT * FROM admin_panel WHERE id = '$SearchQueryParameter';";
              $ExecuteQuery = mysqli_query($Connection, $Query);
              while($DataRows = mysqli_fetch_array($ExecuteQuery)){
                $TitleToBeUpdated = $DataRows["title"];
                $CategoryToBeUpdated = $DataRows["category"];
                $SpotlightToBeUpdated = $DataRows["important"];
                $AuthorToBeUpdated = $DataRows["author"];
                $ImageToBeUpdated = $DataRows["image"];
                $PostToBeUpdated = $DataRows["post"];
                $PostDescriptionToBeUpdated = $DataRows["postDescription"];
              }
            }



          ?>

          <div class="form-container">
            <?php if($_GET["delete"]){ echo "Möchtest du den folgenden Post wirklich löschen?";} ?>
            <form id="addNewPostForm"class="" action="postAction.php" method="post" enctype="multipart/form-data">
              <fieldset>
                <div class="title-container">
                  <h2><input type="text" name="Title" value="<?php echo $TitleToBeUpdated;?>" id="title" placeholder="Titel" autocomplete="off"required <?php if($_GET["delete"]){ echo "disabled";} ?>>
                  <span class="timestamp"><?php echo htmlentities($DateTime); ?><span></h2>


                </div>

                  <!-- Select field to give the article a category -->
                 <!-- input field for the post banner -->

                 <div class="image-container">
                   <img id="uploadPreview" style="border: 1px solid #ddd;" src="Upload/<?php if(!$_GET["id"]){ echo "gsvGemontLogo.jpg"; }else{ echo $ImageToBeUpdated;}  ?>"/><br>
                   <span id="watermark"><span>(Standard)</span></span>

                   <!-- <br>
                   <label for="Post">Post:</label><br> -->
                 </div>
                 <label for="imageselect">Banner: </label>
                 <input type="File" name="Image" id="imageselect" value="<?php echo $ImageToBeUpdated; ?>" onChange="previewImage();" <?php if($_GET["delete"] == 'true'){ echo "disabled";} ?>><br>
                <!-- tinyMCE rich text editor that is used to
                create the posts main content-->
                <textarea id="tinyPostDescription" name="postDescription" rows="8" cols="80" placeholder="Post-Teaser/Beschreibung"><?php echo $PostDescriptionToBeUpdated; ?></textarea><br>
                <textarea id="tinyPostTextArea" name="Post" rows="20" cols="60">
                  <?php echo $PostToBeUpdated ?>
                </textarea>

               <div class="author-container">
                 <label for="inputAuthor">geschrieben von</label>
                 <input type="text" id="inputAuthor" name="author" value="<?php echo $AuthorToBeUpdated ?>" placeholder="Author" <?php if($_GET["delete"]){ echo "disabled";} ?>><br>
               </div>


               <div class="additionalInput-container">
                 <label>Zusätzliche Postinformationen:</label><br>
                 <label for="categoryselect"><span class="FieldInfo ">Kategorie: </span></label>
                 <select class="form-control" id="categoryselect" name="Category" <?php if($_GET["delete"]){ echo "disabled";} ?>>
                   <?php
                     $ViewQuery = "SELECT * FROM category ORDER BY id DESC";
                     $Execute = mysqli_query($Connection, $ViewQuery);

                     while($DataRows = mysqli_fetch_array($Execute)){
                       $Category = $DataRows["name"];
                    ?>
                    <option <?php if($Category == $CategoryToBeUpdated){ echo "selected";} ?>><?php echo $Category; ;?></option>
                  <?php } ?>
                </select><br>

                <label for="spotlightCheck" >Soll der Artikel teil des Bild-Sliders auf der Startseite sein? </label>
                <input id="spotlightCheck" type="checkbox" name="spotlight" <?php if($SpotlightToBeUpdated == 'True'){ echo "checked ";} if($_GET["delete"]){ echo "disabled";} ?>><br>
               </div>



               <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" >
                <!-- submit button -->
                <input class="btnSubmit <?php if($_GET["delete"]){ echo "hiddenOnDesktop";} ?>" type="submit" name="Submit" value="<?php if($_GET["id"]){ echo "Speichern/Posten  ";}else{ echo "Posten";} ?>">
                <input class="btnSubmit <?php if($_GET["delete"]){ echo "hiddenOnDesktop";} ?>" type="submit" name="Preview" value="Vorschau">
                <input class="btnSubmit <?php if($_GET["delete"]){ echo "hiddenOnDesktop";} ?>" type="submit" name="saveAsDraft" value="Als Entwurf speichern">
                <input class="btnSubmit" type="submit" name="deletePost" value="Löschen">

                <!-- <button class="btnSubmit" name="deletePost" onclick="window.location.href='deletePost.php?Delete=<?php echo $_GET["id"];  ?>'"type="button" name="button"></button> -->
              </fieldset>
            </form>


          </div>
        </div>
      </div>



    <script src="js/script.js"></script>
    <script type="text/javascript">

      function previewImage() {
          // initiating a new file reader
          var oFReader = new FileReader();

          // if the the created filereader has received an input
          // a progressEvent is triggered by the fileReader (target) on which the
          // following function is based
          oFReader.onload = function (event) {
            // change the source of the given element to the result of the event
            // which is the data of the base64 encoded image data Url
            document.getElementById("uploadPreview").src = event.target.result;
            var span = document.getElementById('watermark');
            while( span.firstChild ) {
                span.removeChild( span.firstChild );
            }
            // span.appendChild( document.createTextNode("some new content") );
          };

          //if the read operation is finished, the result attribute of the event
          // contains the data as a dataUrl which represents it as a base64 encoded string
          oFReader.readAsDataURL(document.getElementById("imageselect").files[0]);


      };

    </script>
    <!-- initiation and config script of the tinyMCE editor -->
    <script>
      if(window.location.search.search("delete") != -1){

        tinymce.init({
          selector: '#tinyPostTextArea',
          placeholder: 'Post-Teaser/Beschreibung...',
          content_css: '/website-repo/Back-End/css/createNewPostD.css',
          plugins: 'lists image imagetools',
          menubar: 'edit view insert format',
          toolbar: 'fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor | bullist numlist | indent outdent | alignleft aligncenter alignjustify alignright | removeformat',
          readonly : true,
        });


        tinymce.init({
          selector: '#tinyPostDescription',
          placeholder: 'Post-Teaser/Beschreibung...',
          content_css: '/website-repo/Back-End/css/createNewPostD.css',
          plugins: 'lists image imagetools',
          menubar: 'edit view insert format',
          toolbar: 'fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor | bullist numlist | indent outdent | alignleft aligncenter alignjustify alignright | removeformat',
          readonly : true
        });


      }
      else{
        tinymce.init({
          selector: '#tinyPostTextArea',
          placeholder: 'Post-Inhalt...',
          content_css: '/website-repo/Back-End/css/createNewPostD.css',
          plugins: 'lists image imagetools',
          menubar: 'edit view insert format',
          toolbar: 'fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor | bullist numlist | indent outdent | alignleft aligncenter alignjustify alignright | image | removeformat',
        });
        tinymce.init({
          selector: '#tinyPostDescription',

          placeholder: 'Post-Teaser/Beschreibung...',
          content_css: '/website-repo/Back-End/css/createNewPostD.css',
          plugins: 'lists image imagetools',
          menubar: 'edit view insert format',
          toolbar: 'fontselect fontsizeselect | bold italic underline strikethrough | forecolor backcolor | bullist numlist | indent outdent | alignleft aligncenter alignjustify alignright | removeformat',

        });
      }


    </script>


  </body>
</html>
