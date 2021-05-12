<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Register</title>
<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
 	integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
 	crossorigin="anonymous"/>  
	<script src="js/jquerymain.js"></script>
	<script src="js/script.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
	<script type="text/javascript" src="js/nav.js"></script>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script> 
	<script type="text/javascript" src="js/nav-hover.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
	integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
	crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
	crossorigin="anonymous"></script>
  <script>
$(document).keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        var valid;  
        valid = validateForm();
        if(valid) {
            jQuery.ajax({
            url: "processAdminRequests.php",
            data:'name='+$("#name").val()+'&username='+$("#username").val()+
            '&email='+$("#email").val()+'&password='+$("#password").val()+
            '&register='+"register",
            type: "POST",
            success:function(data){
            $("#message").html(data);
            },
            error:function (){}
            });
        }
    }
});

function registerAdmin() {
  var valid;  
  valid = validateForm();
  if(valid) {
    jQuery.ajax({
    url: "processAdminRequests.php",
    data:'name='+$("#name").val()+'&username='+$("#username").val()+
    '&email='+$("#email").val()+'&password='+$("#password").val()+
    '&register='+"register",
    type: "POST",
    success:function(data){
    $("#message").html(data);
    },
    error:function (){}
    });
  }
}

function validateForm() {
  var valid = true;  
  if(!$("#email").val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)) {
    $("#message").html("Invalid email.");
    $("#message").css('color','Red');
    valid = false;
  }
  return valid;
}
</script>

	</head>
<body class="p-3 mb-2 bg-dark">
<div class="conainer p-3 mb-2 bg-light text-dark" id="container">
<div class="row">
	<div class="col align-self-center">
	<form action="" method="post">
		<h1 class="text-center">Admin Registration</h1>
		<span id="message" style="color:red; font-size: 18px;"> 
		</span>
      <div class="form-group">
    		<label for="adminUser">Name</label>
			  <input class="form-control" type="text" id="name" placeholder="Name" name="adminName"/>
  		</div>
      <div class="form-group">
    		<label for="adminUser">Username</label>
			  <input class="form-control" type="text" id="username" placeholder="Username" name="adminUser"/>
  		</div>
  		<div class="form-group">
    		<label for="adminUser">Email</label>
			<input class="form-control" type="text" id="email" placeholder="Email" name="adminEmail"/>
  		</div>
  		<div class="form-group">
    		<label for="adminPass">Password</label>
			<input class="form-control" type="password" id="password" placeholder="Password" name="adminPass"/>
  		</div>
      <div>
        <input type="button" id="register" name="register" onClick="registerAdmin();"
        class="btn btn-outline-success my-2 my-sm-0" value="Create Account"></input>
      </div>
	</form>
	</div>
	</div>
</div><!-- container -->
</body>
</html>