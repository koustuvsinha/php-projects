<?php
session_start();
require 'class/dataManager.php';

if(isset($_POST['police_submit'])) {
    
   $dm = new dataManager();
   $res = $dm->addPoliceStation($_POST['police_station'], $_POST['address'], $_POST['state'], $_POST['city']);
}
    
if(isset($_POST['assign_department'])) {
    $dmv = new dataManager();
    $res1 = $dmv->updateDepartment($_POST['ad_police_officer'], $_POST['ad_department']);
}

?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Admin Panel
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
        <h1>Admin Panel</h1>
        <hr>
        
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php if(isset($res)) {
                if($res==1) echo '<div class="well"><p class="text-success">Police Station added succesfully!</p></div>';
                else echo '<div class="well"><p class="text-error">Sorry, the Police Station could not be added this time!</p></div>';
            }
            if(isset($res1)) {
               if($res1==1) echo '<div class="well"><p class="text-success">Department Updated succesfully!</p></div>';
                else echo '<div class="well"><p class="text-error">Sorry, Department could not be updated this time!</p></div>';
            
            }
            
                ?>
            
            <div class="well">
            <h4>Add Police Station</h4>
            <hr>
            
            
            
            <form class="form-horizontal" name="add_police" method="post" action="">
                <div class="form-group">
                    <label for="police_station" class="col-sm-3 control-label">
                         Name :
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="police_station" id="police_station" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="col-sm-3 control-label">
                         Address :
                    </label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="3" name="address" id="address"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="state" class="col-sm-3 control-label">
                          Select State :
                    </label>
                    <div class="col-sm-9">
                        <select class="form-control"  name="state" id="state">
                            <option value="1">West Bengal</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="city" class="col-sm-3 control-label">
                         City :
                    </label>
                    <div class="col-sm-9">
                        <select class="form-control" name="city" id="city">
                            <option value="1">Kolkata</option>
                        </select>
                    </div>
                </div>
             <div class="form-group">
              <div class="col-sm-3">
              </div>
              <div class="col-sm-9">
                <input type="submit" name="police_submit" class="btn btn-primary" value="Create"/>
              </div>
            </div>
               
            </form>
            </div>
            
            <hr> 
            <div class="well">
                <h4>Assign Department</h4>
                <hr>
                
                <form name="assign_dept" class="form-horizontal" action="" method="post">
                    <div class="form-group">
                    <label for="ad_state" class="control-label col-sm-4">
                          Select State :
                    </label>
                    
                        
                    <div class="col-sm-4">
                        <select class="form-control"  name="ad_state" id="ad_state" onchange ="onSelect('city');">
                            <option value="0">Select</option>
                            <?php 
                            $cdm = new dataManager();
                            $statelist = $cdm->getAllState();
                            if($statelist!=null) {
                                while($row = $statelist->fetch()) {  
                            
                            ?>
                            <option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="ad_city" class="control-label col-sm-4">
                          Select City :
                    </label>    
                    <div class="col-sm-4">
                        <div id="city_select">
                        <select class="form-control"  name="ad_city" id="ad_city" onchange="onSelect('police');">
                            
                            <option value="0">Select</option>
                            
                        </select>
                        </div>    
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="ad_police" class="control-label col-sm-4">
                          Select Police Station :
                    </label>
                    <div class="col-sm-4">
                        <div id="police_select">
                        <select class="form-control"  name="ad_police" id="ad_police" onchange="onSelect('officer');">
                            <option value="0">Select</option>
                        </select>
                        </div>    
                    </div>    
                    </div>
                    <div class="form-group">
                    <label for="ad_police_officer" class="control-label col-sm-4">
                          Select Police Officer :
                    </label>
                    <div class="col-sm-4">
                        <div id="officer_select">
                        <select class="form-control"  name="ad_police_officer" id="ad_police_officer" onchange="onSelect('department');">
                            <option value="0">Select</option>
                        </select>
                        </div>    
                    </div>    
                    </div>
                    <hr>
                    <div class="form-group">
                    <label for="ad_department" class="control-label col-sm-4">
                          Assign Department :
                    </label>
                    <div class="col-sm-4">
                        <div id="department_select">
                        <select class="form-control"  name="ad_department" id="ad_department">
                            <option value="0">Operator</option>
                        </select>
                        </div>    
                    </div>    
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4">
                        </div>
                          <div class="col-sm-4">
                          <input type="submit" name="assign_department" class="btn btn-primary" value="Assign Department"/>
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
    <script type="text/javascript">
        function onSelect(type) {
            var xmlhttp;
            
            if (window.XMLHttpRequest)
              {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            
            if(type === 'city') {
              
              var state = document.getElementById("ad_state");
              var st = state.options[state.selectedIndex].value;
              
              xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("city_select").innerHTML=xmlhttp.responseText;
                document.getElementById('ad_city').setAttribute("onchange","onSelect('police');");
                }
              }
              xmlhttp.open("GET","api.php?citylist=yes&state="+st,true);
              xmlhttp.send();
              
              
            }
            if(type === 'police') {
              var city = document.getElementById("ad_city");
              var ct = city.options[city.selectedIndex].value;
              
              xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("police_select").innerHTML=xmlhttp.responseText;
                document.getElementById('ad_police').setAttribute("onchange","onSelect('officer');");
                }
              }
              xmlhttp.open("GET","api.php?stationlist=yes&city="+ct,true);
              xmlhttp.send();
              
              
            }
            if(type === 'officer') {
              var station = document.getElementById("ad_police");
              var st = station.options[station.selectedIndex].value;
              
              xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("officer_select").innerHTML=xmlhttp.responseText;
                document.getElementById('ad_police_officer').setAttribute("onchange","onSelect('department');");
                }
              }
              xmlhttp.open("GET","api.php?policelist=yes&station="+st,true);
              xmlhttp.send();
              
              
            }
            if(type === 'department') {
              var officer = document.getElementById("ad_police_officer");
              var of = officer.options[officer.selectedIndex].value;
              
              xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                document.getElementById("department_select").innerHTML=xmlhttp.responseText;
                }
              }
              xmlhttp.open("GET","api.php?departmentlist=yes&police_id="+of,true);
              xmlhttp.send();
              
              
            }
        }
    </script>    
  </body>

</html>