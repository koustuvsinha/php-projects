<?php
session_start();

require_once 'class/dataManager.php';

if(isset($_POST['citizen_submit'])) {
    
    $dm = new dataManager();
    $res = $dm->enterUserDetails($_COOKIE['law_user_role'], $_POST['user_id'], $_POST['address'], $_POST['ad_state'], $_POST['ad_city'], $_POST['ad_police']);
    
    if($res == 1) header ('Location:index.php?m=update_success');
}

?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Personal Details
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
      
        <div><h3>Enter your Details here</h3></div>
        <hr>
        <br>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">
                         Name :
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $_COOKIE['law_name']; ?>" readonly/>
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
                    <label for="ad_state" class="control-label col-sm-3">
                          Select State :
                    </label>
                    
                        
                    <div class="col-sm-9">
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
                    <label for="ad_city" class="control-label col-sm-3">
                          Select City :
                    </label>    
                    <div class="col-sm-9">
                        <div id="city_select">
                        <select class="form-control"  name="ad_city" id="ad_city" onchange="onSelect('police');">
                            
                            <option value="0">Select</option>
                            
                        </select>
                        </div>    
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="ad_police" class="control-label col-sm-3">
                          Select Police Station :
                    </label>
                    <div class="col-sm-9">
                        <div id="police_select">
                        <select class="form-control"  name="ad_police" id="ad_police" onchange="onSelect('officer');">
                            <option value="0">Select</option>
                        </select>
                        </div>    
                    </div>
                    </div>
                <input type="hidden" name="user_id" value="<?php echo $_COOKIE['law_user_id']; ?>"/>
                    <div class="form-group">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-9">
                    <input type="submit" name="citizen_submit" class="btn btn-primary" value="Save"/>
                  </div>
                </div>
            </form>
            
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
            
        }
    </script>  
  </body>

</html>