<?php
session_start();
require_once 'class/dataManager.php';
$dm_nav = new dataManager();

?>
<nav class="navbar navbar-default navbar-inverse" role="navigation">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">LawManager</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav">
            <li id="nav_index">
              <a href="index.php">Home</a>
            </li>
            <?php
            if($dm_nav->isLogged()) {
              if($_COOKIE['law_user_role']=='citizen') {
                  ?>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Complaint <b class="caret"></b></a>
               <ul class="dropdown-menu">
                <li><a href="complaintForm.php">File Complaint</a></li>
                <li><a href="complaint_status.php">Complaint Status</a></li>
                <li class="divider"></li>
                <li><a href="#">Remove Complaint</a></li>
              </ul>
            </li>  
            <li id="fir_status">
                <a href="fir_status.php">FIR Status</a>
            </li>
             
                      
              <?php
              }
             if($_COOKIE['law_user_role']=='police') {
                 ?>
              <li id="view_complaint">
                <a href="viewComplaints.php">View Complaints</a>
            </li>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">FIR <b class="caret"></b></a>
               <ul class="dropdown-menu">
                <li><a href="openFIR.php">Open FIR</a></li>
                <li><a href="fir_status.php">FIR Status</a></li>
                <li class="divider"></li>
                <li><a href="#">Cancel FIR</a></li>
              </ul>
            </li> 
            
                 
                 
             <?php
             $police = $dm_nav->getPoliceOfficer($_COOKIE['law_user_id']);
             $dept = $dm_nav->getDepartment($police->designation);
             
             
             
             }if($_COOKIE['law_user_role']=='magistrate') {
             ?>
             <li id="view_fir">
                <a href="fir_status.php">View FIR Status</a>
            </li>    
             <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Case Management <b class="caret"></b></a>
               <ul class="dropdown-menu">
                <li><a href="newCases.php">View Pending Case</a></li>
                <li class="divider"></li>
                <li><a href="#">Remove Case</a></li>
              </ul>
            </li>  
             <?php    
             }if($_COOKIE['law_user_role']=='admin') {
                 ?>
                 <li id="admin_panel">
                <a href="admin.php">Admin Panel</a>
            </li> 
            
            
                 <?php
            }
                ?>
            <li class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">Database <b class="caret"></b></a>
               <ul class="dropdown-menu">
                <li><a href="criminalDatabase.php">Criminal Database</a></li>
                
              </ul>
            </li>
            <li id="nav_logout">
                <a href="logout.php">Logout</a>
            </li>
            <?php } else { ?>
            <li id="nav_register">
              <a href="register.php">Register</a>
            </li>
            <li id="nav_login">
              <a href="login.php">Sign In</a>
            </li>
            <?php } ?>
          </ul>
            <?php
            if($dm_nav->isLogged()) {
            ?>    
            <ul class="nav navbar-nav navbar-right">
            <li class="pull-right">
                <a href=""><?php echo $_COOKIE['law_name']; ?>
                <?php if(isset($dept)) echo ', ' .  $dept . ' Department' ; ?>
                </a>
            </li>
            </ul>
            <?php }
            ?>
        </div>
      </nav>