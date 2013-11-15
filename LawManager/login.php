<?php
session_start();
require_once 'class/dataManager.php';

if(isset($_POST['submit'])) {
    $dm = new dataManager();
    $res = $dm->loginUser($_POST['username'], $_POST['password']);
    if($res===1) header ('Location:index.php');
    else if($res==2) header('Location:personal.php');
}

?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">
    <title>
      Login
    </title>
    <link href="bootstrap/css/bootstrap.min.css"
    rel="stylesheet">
  </head>
  
  <body>
      <div class="container">
          <?php include 'includes/navbar.php'; ?>
         <div class="starter-template">
        <h1>
          Login
        </h1>
        <hr>
      </div>
          <div class="col-sm-3"></div>
          <div class="col-sm-6">
      <div class="well">
        <form method="post" action="">
          <div class="form-group" >
            <label>
              Enter your username
            </label>
            <input type="text" class="form-control" name="username" placeholder="Enter your username">
          </div>
        
        <div class="form-group">
          <label>
            Enter password
          </label>
          <input type="password" class="form-control" name="password">
        </div>
        <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Submit!"/>
       </form>
      </div>

          </div>
          <div class="col-sm-3"></div>
    </div>
    <!-- /.container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>
    <script src="includes/scripts.js"></script>
  </body>

</html>
