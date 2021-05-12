
<?php
ob_start();
include_once 'lib/Session.php';
 //start session when accessing pages
 //session set and get can be initialized in all pages
 Session::init();


include 'helpers/Request.php';
/**
  * This built in function takes a function
  that allows all the classes in the classes 
  folder to be included
  */
  spl_autoload_register(function($class){
    include_once "classes/".$class.".php";
 
   });
?>


<?php
//instantiate all the classes so they can be
//accessed from all pages
$movie = new Movies(); 
$format = new Format();
$data = new Database();
$request = new Request();
$actor = new Actor();
$category = new Category();
$director = new Director();
$genre = new Genre();
$user = new User();
$admin = new Admin();
$message = new Message();
$watchlist = new Watchlist();
$watchlater = new Watchlater();
?>




<!DOCTYPE HTML>
<head>
<title>Movie DB</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<link rel="stylesheet" href="styles/styles.css">
<link 
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" 
    crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
 integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
 crossorigin="anonymous"/>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
 integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
 crossorigin="anonymous"/>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
crossorigin="anonymous"></script>
<script type="text/javascript">
//asynchronous methods


function details(id) {
	//console.log($("#movieid").val());
    jQuery.ajax({
      url: "details.php",
	  data:'movieid='+ id,
      type: "GET",
	  cache: false,
      success: function(data)
        {
      $("body").html(data);
        },
        error: function() 
        {}           
     });
	}

function categories(id) {
	//console.log($("#movieid").val());
    jQuery.ajax({
      url: "moviesByCategory.php",
	  data:'categoryId='+ id,
      type: "GET",
	  cache: false,
      success: function(data)
        {
      $("body").html(data);
        },
        error: function() 
        {}           
     });
	}

  function genres(id) {
	//console.log($("#movieid").val());
    jQuery.ajax({
      url: "moviesByGenre.php",
	  data:'genreId='+ id,
      type: "GET",
	  cache: false,
      success: function(data)
        {
      $("body").html(data);
        },
        error: function() 
        {}           
     });
	}

  function directors(id) {
	//console.log($("#movieid").val());
    jQuery.ajax({
      url: "moviesByDirector.php",
	  data:'directorId='+ id,
      type: "GET",
	  cache: false,
      success: function(data)
        {
      $("body").html(data);
        },
        error: function() 
        {}           
     });
	}

  function actors(id) {
	//console.log($("#movieid").val());
    jQuery.ajax({
      url: "moviesByActor.php",
	    data:'actorid='+ id,
      type: "GET",
	    cache: false,
      success: function(data)
        {
      $("body").html(data);
        },
        error: function() 
        {}           
     });
	}

  $(document).keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        var valid;  
        valid = validateForm();
        if(valid) {
            jQuery.ajax({
            url: "processRequests.php",
            data:'firstname='+$("#firstname").val()+'&lastname='+$("#lastname").val()+
            '&city='+$("#city").val()+'&country='+$("#country").val()+'&zip='+$("#zip").val()+
            '&username='+$("#username").val()+'&email='+$("#email").val()+'&password='+$("#password").val()+
            '&register='+"register",
            success:function(data){
            $("#message").html(data);
            },
            error:function (){}
            });
        }
    }
});

function registerUser() {
  var valid;  
  valid = validateForm();
  if(valid) {
    jQuery.ajax({
    url: "processRequests.php",
    data:'firstname='+$("#firstname").val()+'&lastname='+$("#lastname").val()+
    '&city='+$("#city").val()+'&country='+$("#country").val()+'&zip='+$("#zip").val()+
    '&username='+$("#username").val()+'&email='+$("#email").val()+'&password='+$("#password").val()+
    '&register='+"register",
    type: "POST",
    success:function(data){
    $("#message").html(data);
    },
    error:function (){}
    });
  }
}

// function updateEmail() {
//   var valid;  
//   valid = validateForm();
//   if(valid) {
//     jQuery.ajax({
//     url: "updateEmail.php",
//     data:'email='+$("#email").val(),
//     type: "POST",
//     success:function(data){
//     $("#message").html(data);
//     },
//     error:function (){}
//     });
//   }
// }

function search() {
    jQuery.ajax({
    url: "search.php",
    data:'search='+$("#search").val(),
    type: "POST",
    success:function(data){
    $("#message").html(data);
    },
    error:function (){}
    });
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

function deleteWatchlist(id){
  jQuery.ajax({
      url: "processRequests.php",
	    data:'watchlistid='+ id,
      type: "GET",
	    cache: false,
      success: function(data)
        {
      $("#addwatchlist").html(data);
        },
        error: function() 
        {}           
     });
}

function deleteWatchlater(id){
  jQuery.ajax({
      url: "processRequests.php",
	    data:'watchlaterid='+ id,
      type: "GET",
	    cache: false,
      success: function(data)
        {
      $("#addwatchlist").html(data);
        },
        error: function() 
        {}           
     });
}

function addToWatchlist(movieid, userid){
  jQuery.ajax({
      url: "processRequests.php",
	    data:'movieid='+ movieid+'&userid='+userid+'&addToWatchlist='+"watchlist",
      type: "GET",
	    cache: false,
      success: function(data)
        {
      $("#addwatchlist").html(data);
        },
        error: function() 
        {}           
     });
}

</script>
</head>
<body class="style">
  <div >
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Movie DB</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <?php
                //check if the get request is set
                if(isset($_GET["userid"])){
                    //call method in cart class to delete
                    //cart data upon logging out
                    //$delData = $cart->deleteCustomerCart(); 

                    //destroy the session if the ID is obtained
                    //the redirection screen location will be the login.php page 
                    Session::destroy(); 
                }
            ?>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a href="watchlist.php" class="nav-link">Watchlist</a>
      </li>
      <li class="nav-item">
        <a href="wishlist.php" class="nav-link">Watchlater</a>
      </li>
      <li class="nav-item">
        <a href="contactus.php" class="nav-link">Contact Us</a>
      </li>
      <?php 
        if(!(Session::get("userLogin"))){
      ?>
      <li class="nav-item">
        <a href="register.php" class="nav-link">Register</a>
      </li>
      <li class="nav-item">
        <a href="login.php" class="nav-item nav-link">Sign In</a>
      </li>
      <?php }?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Movie Options
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="movieCategories.php">Categories</a>
		    <a class="dropdown-item" href="movieGenres.php">Genres</a>
			<a class="dropdown-item" href="movieDirectors.php">Directors</a>
			<a class="dropdown-item" href="movieActors.php">Actors</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="movies.php">All Movies</a>
          <a class="dropdown-item" href="allMovieRankings.php">All Movies Ranked</a>
        </div>
      </li>
      <?php 
        if((Session::get("userLogin"))){
          $userId = Session::get("userid"); 
          $selectDetails = $user->selectUserDetails($userId); 
          $details = $selectDetails->fetch(); 
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $details["f_name"]?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a  class="dropdown-item" href="profile.php"> Your Profile</a>
            <a class="dropdown-item" href="watchlist.php">Your Watchlist</a>
		        <a class="dropdown-item" href="wishlist.php">Your Watchlater</a>
            <a  class="dropdown-item" href="?userid=<?php Session::get('userId');?>">Sign out</a>
        </div>
      </li>
      <?php }?>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="post">
        <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success btn-sm my-2 my-sm-0" value="SEARCH" type="submit">Search</button>
    </form>
  </div>
</nav>
    
</div>
</div>
<div class="container card border-success mb-3" id="container">
