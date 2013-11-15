<?php
session_start();
require_once 'class/dataManager.php';




?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Open Case
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
      
        <h1>Open Case <small> open case based on FIR</small></h1>
        <hr>
      
        <div class="col-md-1"></div>
        <div class="col-md-10">
            
            <?php
            if(isset($_POST['open_case'])) {
                
                $dmm = new dataManager();
                $case_id = $dmm->openCase($_POST['fir_id'], $_POST['notes'], $_POST['user_id']);
                echo '<div class="well"><h4 class="text-info">Case has been opened! Case No : <strong>' . $case_id . '</strong></h4></div>';
                
            }
            
            ?>
            <?php if(isset($_GET['c_id'])) {
                
                $dm = new dataManager();
                $obj = $dm->getFIR($_GET['c_id']);
              
                $comp = $dm->getComplaint($obj->complaint_id);
                $user = $dm->getUser($comp->user_id);
                
                ?>
            
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <label for="fir_id" class="col-sm-3 control-label">
                         FIR ID :
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="fir_id" id="fir_id" value="<?php echo $obj->fir_id; ?>" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="complaint_id" class="col-sm-3 control-label">
                         Complaint ID :
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="complaint_id" value="<?php echo $obj->complaint_id; ?>" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="complaint_type" class="col-sm-3 control-label">
                         Complaint Type :
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="complaint_type" value="<?php echo $comp->complaint_type; ?>" readonly/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="complaint_description" class="col-sm-3 control-label">
                         Complaint Description :
                    </label>
                    <div class="col-sm-9">
                        <textarea  class="form-control" id="complaint_description" rows="3" readonly><?php echo $comp->complaint_description; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="complained_by" class="col-sm-3 control-label">
                         Complained By :
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"  id="complained_by" value="<?php echo $user->name; ?>" readonly />
                    </div>
                </div>
                <hr>
                
                <div class="form-group">
                    <label for="notes_by_police" class="col-sm-3 control-label">
                         Additional Notes by Police :
                    </label>
                    <div class="col-sm-9">
                        <textarea  class="form-control" id="notes_by_police" name="notes_by_police" rows="3" readonly><?php echo $obj->notes; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes" class="col-sm-3 control-label">
                         Additional Notes :
                    </label>
                    <div class="col-sm-9">
                        <textarea  class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                <div class="col-sm-3">
                </div>
                  <input type="hidden" name="user_id" value="<?php echo $_COOKIE['law_user_id']; ?>"/>    
                <div class="col-sm-9">
                  <input type="submit" name="open_case" class="btn btn-primary btn-lg" value="Open Case"/>
                  <input type="reset" class="btn btn-lg" value="Reset"/>
                </div>
            </div>
                
            </form>
            <?php
            }
            
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