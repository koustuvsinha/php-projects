<?php
session_start();
require_once 'class/dataManager.php';


if(isset($_POST['complaint_submit'])) {
    $dm = new dataManager();
    $complaint_id = $dm->addComplaint($_POST['complaint_type'], $_POST['complaint_description'], $_POST['user_id']);
    
}
?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Complaint Form
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
      
        <h1>Complaint Form <small>register your complaint here!</small></h1>
        <hr>
        <div class="col-md-1"></div>
        <div class="col-md-10">
            
            <?php if(isset($complaint_id)) {
                echo '<div class="well"><h4 class="text-success">Your Complaint has been registered in the system!<br> Please note down the Complaint ID <strong>' . $complaint_id . '</strong> for future reference! Your complaint has been forwarded to the Respective Police Department</h4></div>';
            } ?>
            
            <div class="well">
            <form class="form-horizontal" name="add_complaint" method="post" action="">
                <div class="form-group">
                    <label for="complaint_type" class="col-sm-3 control-label">
                         Select Complaint Type :
                    </label>
                    <div class="col-sm-9">
                        <select class="form-control" name="complaint_type" id="complaint_type" >
                            <option value="Theft">Theft</option>
                            <option value="Murder">Murder</option>
                            <option value="Fraud">Fraud</option>
                            <option value="Traffic">Traffic</option>
                            <option value="Rape">Rape</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="complaint_description" class="col-sm-3 control-label">
                         Describe your complaint :
                    </label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="complaint_description" id="complaint_description" rows="7"></textarea>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label class="col-sm-3 control-label">
                    </label>
                    <div class="col-sm-9 checkbox"><label>
                        <input type="checkbox" id="agree" name="agree" > I, <?php echo $_COOKIE['law_name']; ?> hereby acknowledge that this complaint is true to my best knowledge.
                        </label>
                    </div>
                </div>
                <div class="form-group">
              <div class="col-sm-3">
              </div>
                    <input type="hidden" name="user_id" value="<?php echo $_COOKIE['law_user_id']; ?>"/>
              <div class="col-sm-9">
                <input type="submit" name="complaint_submit" class="btn btn-primary btn-lg" value="Submit Complaint"/>
              </div>
            </div>
            </form>
            </div> 
        </div>
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>
    <script src="includes/scripts.js"></script>
  </body>

</html>