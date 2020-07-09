<?php require_once('include/DB.php'); ?>
<?php require_once('include/Sessions.php'); ?>
<?php require_once('include/Functions.php'); ?>
<?php
  $PostId = $_GET["id"];
  if(isset($_POST["Submit"])){
    $Name = mysqli_real_escape_string($Connection,$_POST["Name"]);
    $Email = mysqli_real_escape_string($Connection,$_POST["Email"]);
    $Comment = mysqli_real_escape_string($Connection,$_POST["Comment"]);

    $currentTime= time();
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $DateTime;

    if(empty($Name)||empty($Email)||empty($Comment)){
      $_SESSION["ErrorMessage"] = "All Fields are required";

    }elseif(strlen($Comment)>500) {
      $_SESSION["ErrorMessage"] = "Comment can't be longer than 500 characters";

    }
    else{

      $Query="INSERT INTO comments(datetime, name, email, comment, approvedby, status, admin_panel_id) VALUES('$DateTime', '$Name', '$Email', '$Comment','pending', 'OFF', '$PostId');";
      $ExecuteQuery = mysqli_query($Connection, $Query);
      if($ExecuteQuery){
        $_SESSION["SuccessMessage"] = "Comment Submitted Successfully";
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/weirdflex.css">
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script>
  </head>
  <body>

    <div class="wrapper">
      <nav class="navbar navbar-inverse" role="navigation">

          <ul class="nav navbar-nav">
            <li><a href="Blog.php">Home</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Feature</a></li>
          </ul>
          <form class="navbar-form navbar-right" action="Blog.php" method="get">
            <div class="form-group">
              <input type="text" class="form-control" name="Search" value="" placeholder="Search">
              <button type="submit" class="btn btn-default" name="SearchButton">Go</button>
            </div>
          </form>

      </nav>
      <div class="container">
        <div class="blog-header">
          <h1>MyBlog</h1>
          <p class="lead">The Complete Blog</p>
        </div>
        <div class="row">
          <div class="col-sm-8">
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
                $Category = $DataRows["category"];
                $Admin = $DataRows["author"];
                $Image = $DataRows["image"];
                $Post = $DataRows["post"];

             ?>
             <?php echo Message();
             echo SuccessMessage();?>
             <div class="img-thumbnail">
               <img src="Upload/<?php echo $Image ?>" alt="">
               <div class="caption">
                 <h1><?php echo htmlentities($Title); ?></h1>
                 <p>Category: <?php echo htmlentities($Category); ?>, Published on <?php echo htmlentities($DateTime); ?></p>
                 <p>
                   <?php
                    echo nl2br($Post);
                    ?>
                </p>
               </div>

             </div>
             <br>
           <?php } ?>

           <form class="" action="FullPost.php?id=<?php echo $PostId;?>" method="post" enctype="multipart/form-data">
             <fieldset>
               <div class="form-group">
                 <label for="Name">Name:</label>
                 <input type="text" name="Name" value="" id="Name" placeholder="Name" class="form-control">
               </div>
               <div class="form-group">
                 <label for="Email">E-Mail:</label>
                 <input type="email" name="Email" value="" id="Email" placeholder="E-Mail" class="form-control">
               </div>

               <div class="form-group">
                 <label for="commentarea">Post:</label>
                 <textarea class="form-control" name="Comment" id="commentarea" rows=5></textarea>
               </div>
               <input class="btn btn-primary" type="submit" name="Submit" value="Submit">
             </fieldset>
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


           <section class="">
             <br>
             <img  src="Upload\170420-weed-prices.jpg">
             <p><?php echo $CommentName;?></p>
             <p><?php echo $CommentDate;?></p>
             <p class=""><?php echo nl2br($Comment);}?></p>
             <hr>
           </section>




      </div>
      <div class="col-sm-offset-1 col-sm-3">
        <h2>About Me</h2>
        <img src="Upload/170420-weed-prices.jpg" alt="">
        <p>Four loko literally chillwave, drinking vinegar vinyl ennui migas next level hoodie cold-pressed. Chillwave hella readymade portland adaptogen aesthetic +1, knausgaard fashion axe YOLO. Polaroid air plant authentic hell of quinoa butcher, ennui meh marfa yr. Hammock kogi disrupt, butcher photo booth adaptogen ramps dreamcatcher typewriter stumptown meditation cornhole aesthetic forage you probably haven't heard of them.</p>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2 class="panel-title">Categories</h2>
          </div>
          <div class="panel-body">
            <?php
              $Query = "SELECT * FROM category";
              $Execute = mysqli_query($Connection, $Query);
              while($DataRows = mysqli_fetch_array($Execute)){
                $Id = $DataRows["id"];
                $Category = $DataRows["name"];
            ?>
            <a href="Blog.php?category=<?php echo $Category; ?>"><span><?php echo $Category."<br>";?></span></a>

          <?php } ?>
          </div>
          <div class="panel-footer">

          </div>
        </div>
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2 class="panel-title">Recent Posts</h2>
          </div>
          <div class="panel-body">
            <?php
              $Query = "SELECT * FROM admin_panel ORDER BY id DESC LIMIT 5";
              $Execute = mysqli_query($Connection, $Query);
              while($DataRows = mysqli_fetch_array($Execute)){
                $Id = $DataRows["id"];
                $Title = $DataRows["title"];
                $DateTime = $DataRows["datetime"];
                $Image = $DataRows["image"];
                if(strlen($DateTime)>12){
                  $DateTime = substr($DateTime, 0, 12);
                }
            ?>
            <div class="">

              <img src="Upload/<?php echo $Image; ?>" alt="">
              <a href="FullPost.php?id=<?php echo $Id; ?>"><p><?php echo htmlentities($Title); ?></p></a>

              <p><?php echo htmlentities($DateTime); ?></p>
            </div>


          <?php } ?>
          </div>
          <div class="panel-footer">

          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </body>
</html>
