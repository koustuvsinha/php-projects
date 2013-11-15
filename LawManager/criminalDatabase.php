<?php
session_start();
require_once 'class/dataManager.php';




?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <title>Criminal Database
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
      
        <h1>Criminal Database <small> the most comprehensive criminal database</small></h1>
        <hr>
      
        
        <div class="col-md-6">
              <div id="carousel-example-generic" class="carousel slide" >
                 

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <div class="item active">
                      <img src="img/denzel.jpg" alt="">
                      <div class="carousel-caption">
                          <h3>Denzel Washington</h3>
                      </div>
                      
                    </div>
                    <div class="item">
                      <img src="img/leo.jpg" alt="">
                      <div class="carousel-caption">
                          <h3>Leonardo Di Caprio</h3>
                      </div>
                    </div>  
                  </div>

                  <!-- Controls -->
                  <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                </div>
           
        </div>
        <div class="col-md-6">
            <p>These are the list of known Criminals in your area. If any sightings are reported please contact 00112-11221</p>
            
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script src="bootstrap/js/bootstrap.min.js">
    </script>
    <script src="includes/scripts.js"></script>
  </body>

</html>