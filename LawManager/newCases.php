<?php
session_start();
require_once 'class/dataManager.php';

?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Pending Cases
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
      
        <h1>Pending Cases <small> view all the pending cases here </small></h1>
        <hr>
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="btn-group">
                            <a type="button" class="btn btn-primary" href="newCases.php">Pending Cases</a>
                            <a type="button" class="btn btn-default" href="newCases.php?flag=1">Closed Cases</a>
                            
                        </div>
            <br>
            <?php
            $result = null;
                $dm = new dataManager();
                if(isset($_GET['flag'])) {
                    $result = $dm->getCases($_GET['flag'], $_COOKIE['law_user_id']);
                    
                }else {
                    $result = $dm->getCases(0, $_COOKIE['law_user_id']);
                }
                
                if(($result !=null)||($result->rowCount()==0)) {
                    ?>
            <table class="table table-bordered">
                <th><td>Case ID</td><td>FIR ID</td><td>Notes</td><td>Action</td></th>
                <?php
                $ct = 1;
                    while($row = $result->fetch()) {
                    $user = $dm->getUser($row['user_id']);
                        ?>
            
            <tr><td><?php echo $ct; ?></td><td><?php echo $row['case_id']; ?></td><td><?php echo $row['fir_id']; ?></td><td><?php echo $row['notes']; ?></td>
                <td><div class="btn-group">
                            <a type="button" class="btn btn-default" href="close.php?type=case&id=<?php echo $row['fir_id'];?>">Close Case</a>
                        </div></td>
            </tr>    
                                
                            <?php
                            $ct++;
                    }
                
                
                ?>
            </table>    
                        
                        
                    <?php
                }else {
                    echo '<div class=well><p class="text-info">No Cases found!</p></div>';
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