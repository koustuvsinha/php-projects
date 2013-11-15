<?php
session_start();
require_once 'class/dataManager.php';


$html = '';
$dm = new dataManager();
if(isset($_GET['citylist'])) {
    $citylist = $dm->getAllCity($_GET['state']);
    if($citylist!=null) {
      $html .= '<select class="form-control"  name="ad_city" id="ad_city">';
      $html .= '<option value="0">Select</option>';
      while($row = $citylist->fetch()) {  
                            
                            
           $html .= '<option value="' . $row['city_id'] . '">' . $row['city_name'] . '</option>';
      }
      $html .= '</select>';
    } 
    
}
if(isset($_GET['stationlist'])) {
    $police_list = $dm->getPoliceStationsByCity($_GET['city']);
    if($police_list!=null) {
      $html .= '<select class="form-control"  name="ad_police" id="ad_police">';  
      $html .= '<option value="0">Select</option>';
      while($row = $police_list->fetch()) {  
                            
                            
           $html .= '<option value="' . $row['police_id'] . '">' . $row['station_name'] . '</option>';
      }
      $html .= '</select>';
    } 
}
if(isset($_GET['policelist'])) {
    $police_list = $dm->getPoliceOfficers($_GET['station']);
    if($police_list!=null) {
      $html .= '<select class="form-control"  name="ad_police_officer" id="ad_police_officer">';  
      $html .= '<option value="0">Select</option>';
      while($row = $police_list->fetch()) {  
                            
           $user = $dm->getUser($row['user_id']);                 
           $html .= '<option value="' . $user->user_id . '">' . $user->name . '</option>';
      }
      $html .= '</select>';
    } 
}
if(isset($_GET['departmentlist'])) {
    $police = $dm->getPoliceOfficer($_GET['police_id']);
    if($police!=null) {
           
    $html .= '<select class="form-control"  name="ad_department" id="ad_department">';    
    $html .= '<option value="0">Operator</option>';
    $ct = 1;
    while($ct < 6) {
        if($ct == $police->designation) {
                $html .= '<option value="' . $police->designation . '" selected="selected">' . $dm->getDepartment($police->designation) . '</option>';
        }else {
            $html .= '<option value="' . $ct . '">' . $dm->getDepartment($ct) . '</option>';
        }
        $ct ++;
    }
    $html .= '</select>';
    }
}



echo $html;

?>
