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
    <script src="js/bootstrap.min.js" charset="utf-8"></script>
    <script src="js/jquery-3.4.1.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="css/weirdflex.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg" role="navigation">
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="Blog.php" target:"_blank">Home</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Feature</a></li>
        </ul>
        <form class="navbar-form navbar-right form-inline" action="Blog.php" method="get">
          <div class="form-group">
            <input type="text" class="form-control" name="Search" value="" placeholder="Search">
            <button type="submit" class="btn btn-default" name="SearchButton">Go</button>
          </div>
        </form>
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


    <div id="Footer">
      <br>
      <br>
      footer
      <br>
    </div>




  </body>
</html>
