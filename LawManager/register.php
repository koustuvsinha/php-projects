<?php
session_start();
require_once 'class/dataManager.php';
if(isset($_POST['submit'])) {
    
    $dm = new dataManager();
    if(!$dm->checkDuplicateUser($_POST['username'])) {
    $rs = $dm->registerUser($_POST['username'], $_POST['password'], $_POST['name'], $_POST['user_role']);
    }else $rs = -2;
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
      Register
    </title>
    <link href="bootstrap/css/bootstrap.min.css"
    rel="stylesheet">
  </head>
  
  <body>
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
      <div class="starter-template">
        <h1>
          Register here to enjoy the features!
        </h1>
        <hr>
        <div id="result" style="display:none;"><?php if(isset($rs)) echo $rs; else echo '-1'; ?></div>
        <div class="well">
          <form class="form-horizontal" role="form" action="" method="post">
            <div class="form-group">
              <label class="col-sm-3">
                Enter your name :
              </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="Enter your name"
                name="name" id="name">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3">
                Enter username :
              </label>
              <div class="col-sm-9">
                <input type="text" class="form-control" placeholder="username" name="username"
                id="username">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3">
                Password :
              </label>
              <div class="col-sm-9">
                <input type="password" class="form-control" placeholder="" name="password"
                id="password">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3">
                Re-type Password :
              </label>
              <div class="col-sm-9">
                <input type="password" class="form-control" placeholder="" name="re-password"
                id="re-password">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3">
                Select your Role :
              </label>
              <div class="col-sm-9">
                <select class="form-control" name="user_role" id="user_role">
                  <option value="citizen">
                    Citizen
                  </option>
                  <option value="police">
                    Police Officer
                  </option>
                  <option value="magistrate">
                    Magistrate
                  </option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-3">
              </div>
              <div class="col-sm-9">
                <input type="submit" name="submit" class="btn btn-primary" value="Register"/>
              </div>
            </div>
          </form>
        </div>
        
        <div id="regismodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="regisModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
            <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h3 id="regisModalLabel"></h3>
		</div>
		<div class="modal-body" id="regisbody">
                </div>
                <div class="modal-footer">
                    <div id="successButton"></div>
                   <div id="retry"></div>
		</div>
                </div>
            </div>
        </div>
        
      </div>
    </div>
    <!-- /.container -->
    <script src="bootstrap/js/jquery-1.10.2.min.js">
    </script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>
       <script src="bootstrap/js/bootstrap.js">
    </script>
    <script src="includes/scripts.js"></script>
  </body>

</html>