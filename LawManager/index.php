<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Index
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="bootstrap/css/bootstrap.min.css"
    rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css"
    rel="stylesheet">
  </head>
  
  <body>
    <div class="container">
      <?php include 'includes/navbar.php'; ?>
      <div class="jumbotron">
        <img src="https://s3.amazonaws.com/media.jetstrap.com/FI5GV8r5RcOpDCDqBkU0_Taxidermy_Law_-_Everything_Taxidermy"
        width="200" height="" class="pull-right">
        <h1>
          "Law must prevail"
        </h1>
        <p>
          Welcome to the most comprehensive law and order management portal!
        </p>
        <p>
          <a class="btn btn-primary btn-lg" href="#">Learn more</a>
        </p>
      </div>
        
        <?php 
        
if(isset($_GET['m'])&&($_GET['m']=='update_success')) {
    
    echo '<div class="well"><p class="text-success">Thank you! Your details has been updated succesfully!</p></div>';
    
}
if(isset($_GET['m'])&&($_GET['m']=='closed')) {
    
    echo '<div class="well"><p class="text-success">FIR/Complaint has been closed successfully!</p></div>';
    
}
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>
    <script src="includes/scripts.js"></script>
  </body>

</html>