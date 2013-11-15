<?php
session_start();
require_once 'class/dataManager.php';

?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Complaint Status
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
      
        <h1>Complaint Status <small>track your complaint here!</small></h1>
        <hr>
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="well">
                <form name="status_track" method="post" action="">
                    <div class="form-group">
                    <label class="col-sm-3 control-label">Enter Complaint ID :
                    </label>
                        <div class="input-group col-sm-4">
                        <input type="text" name="complaint_id" class="form-control">
                        <span class="input-group-btn">
                          <input class="btn btn-default" name="status_track" type="submit" value="Go!"/>
                        </span>
                      </div>
                    </div>
                </form>
                <br><br>
            </div>
            <br>
            <?php
            if(isset($_POST['status_track'])) {
                
                $dm = new dataManager();
                $c_obj = $dm->getComplaintStatus($_POST['complaint_id'],$_COOKIE['law_user_id']);
            
                if($c_obj != null) {
                ?>
            
            <table class="table table-hover">
                <tr><td><strong>Complaint Status :</strong></td><td><strong><?php echo $c_obj->status; ?></strong></td></tr>
                <tr><td><strong>Complaint Booked on :</strong></td><td><?php echo $c_obj->date; ?></td></tr>
                <tr><td><strong>Complaint Type :</strong></td><td><?php echo $c_obj->complaint_type; ?></td></tr>
                <tr><td><strong>Complaint Description :</strong></td><td><?php echo $c_obj->complaint_description; ?></td></tr>
                
            </table>
                
                <?php
            }else {
                ?>
            
            <div class="well col-md-6"><h4 class="text-danger">Sorry! The Complaint No is invalid!</h4></div>
            
                <?php
            } }
            
            ?>
        </div>
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>
    <script src="includes/scripts.js"></script>
  </body>

</html>