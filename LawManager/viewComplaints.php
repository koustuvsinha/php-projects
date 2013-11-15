<?php
session_start();
require_once 'class/dataManager.php';

?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>View Complaints
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
      
        <h1>View Open Complaints <small>view all the complaints in your area</small></h1>
        <hr>
        <div class="col-md-1"></div>
        <div class="col-md-10">
                        <div class="btn-group">
                            <a type="button" class="btn btn-primary" href="viewComplaints.php">Open Complaints</a>
                            <a type="button" class="btn btn-default" href="viewComplaints.php?flag=1">FIR allotted Complaints</a>
                            <a type="button" class="btn btn-default" href="viewComplaints.php?flag=2">Closed Complaints</a>
                        </div>
            <br><br>
                <?php
                $result = null;
                $dm = new dataManager();
                if(isset($_GET['flag'])) {
                    $result = $dm->getComplaints($_GET['flag'], $_COOKIE['law_user_id']);
                    
                }else {
                    $result = $dm->getComplaints(0, $_COOKIE['law_user_id']);
                }
                
                if(($result !=null)||($result->rowCount()==0)) {
                    ?>
            <table class="table table-bordered">
                <th><td>Complaint ID</td><td>Complaint Type</td><td>Complaint Description</td><td>Complained by</td><td><?php if($_GET['flag']==1) echo 'FIR No.'; else echo 'Action'; ?></td></th>
                <?php
                $ct = 1;
                    while($row = $result->fetch()) {
                    $user = $dm->getUser($row['user_id']);
                        ?>
            
            <tr><td><?php echo $ct; ?></td><td><?php echo $row['complaint_id']; ?></td><td><?php echo $row['complaint_type']; ?></td><td><?php echo $row['complaint_description']; ?></td>
                <td><?php echo $user->name; ?></td><td>
                    <?php if(isset($_GET['flag'])) {
                        $fir = $dm->getFIRByComplaintID($row['complaint_id']);
                        echo $fir->fir_id;
                    } else { ?>
                    <div class="btn-group">
                            <a type="button" class="btn btn-primary" href="addFIR.php?c_id=<?php echo $row['complaint_id'];?>">Lodge FIR</a>
                            <a type="button" class="btn btn-default" href="close.php?type=complaint&id=<?php echo $row['complaint_id'];?>">Close Complaint</a>
                        </div>
                    <?php } ?>
                </td>
            </tr>    
                                
                            <?php
                            $ct++;
                    }
                
                
                ?>
            </table>    
                        
                        
                    <?php
                }else {
                    echo '<div class=well><p class="text-info">No complaints found!</p></div>';
                }
                
                ?>    
            
                <br><br>
            </div>
            <br>
            
        </div>
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>
    <script src="includes/scripts.js"></script>
  </body>

</html>