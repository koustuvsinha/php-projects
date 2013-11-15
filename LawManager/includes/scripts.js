function change_nav() {
    var title = document.title;
    if(title==='Index') {
        document.getElementById("nav_index").setAttribute("class","active");
    }
    if(title==='Register') {
        document.getElementById("nav_register").setAttribute("class","active");
    }
    if(title==='Login') {
        document.getElementById("nav_login").setAttribute("class","active");
    }
    if(title==='Logout') {
        document.getElementById("nav_logout").setAttribute("class","active");
    }
}

$(window).load(function(){
        change_nav();
        show_register();
    });
    
function show_register() {
           
          if(document.getElementById("result").innerHTML !== '-1') {
              if(document.getElementById("result").innerHTML == "1") {
                  document.getElementById("regisModalLabel").innerHTML = 'Success!';
                  document.getElementById("regisbody").innerHTML = '<p class="text-success">You have been successfully registered in the system!</p>\n\
                    <p>Click on the Login button to continue</p>';
                  document.getElementById("successButton").innerHTML = '<a href="login.php" class="btn btn-primary">Login</a>&nbsp;<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>';                  
              }
              else if(document.getElementById("result").innerHTML == '-2') {
                  document.getElementById("regisModalLabel").innerHTML = 'Duplicate Username!';
                  document.getElementById("regisbody").innerHTML = '<p class="error">Sorry, but this username is already registered!</p>';
				  document.getElementById("successButton").innerHTML = '<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>';
              }
              else {
                  document.getElementById("regisModalLabel").innerHTML = 'Oops! Something went wrong!';
                  document.getElementById("regisbody").innerHTML = '<p class="error">Sorry an error occurred while processing your request!</p>';
				  document.getElementById("successButton").innerHTML = '<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Close</a>';
              }
              
              $('#regismodal').modal();
              //document.getElementById("regismodal").modal('show');
          }
           
       }    
    