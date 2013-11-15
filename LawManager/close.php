<?php
session_start();
require_once('class/dataManager.php');

if(isset($_GET['type'])&&isset($_GET['id'])) {
    
    $dm = new dataManager();
    $dm->close($_GET['type'], $_GET['id']);
    
    header('Location:index.php?m=closed');
    
}


?>
