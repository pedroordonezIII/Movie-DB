<?php
ob_start();
include_once '../lib/Session.php';
//check the session at the start
Session::checkSession();


//include '../classes/Contact.php';
// include_once '../classes/Admin.php';
include_once '../helpers/Format.php';
include_once '../lib/Database.php';
spl_autoload_register(function($class){
  include_once "../classes/".$class.".php";

 });
?>

<?php
//instantiate all class objects to make them accessable
//$contact = new Contact(); 
//$order = new Order();
$data = new Database();
$format = new Format();
$admin = new Admin();
$movie = new Movies(); 
$actor = new Actor();
$director = new Director();
$genre = new Genre(); 
$category = new Category(); 
$message = new Message();

//get all the message, order, and order history count
$messageCount = $message->countMessages();

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <title>Movie DB Administrator</title>

    <!-- Bootstrap core CSS -->
    <link 
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" 
    crossorigin="anonymous">
      <!-- BEGIN: load jquery -->
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
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
    crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
    crossorigin="anonymous"></script>

  <script type="text/javascript">
  function details(id) {
	//console.log($("#movieid").val());
    $.ajax({
      url: "editmovie.php",
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
</script>
  </head>

  <body>
    <div class="container-fluid">
      <div class="row bg-dark text-light border border-success">
        <div class="col-6 col-md-8">
          <h1>Showplace Movie DB</h1>
					<p>Administrator</p>
        </div>
          <div class="col-6 col-md-4">
              <div class="">
                <ul class="list-group list-group-horizontal-sm">
                <?php
                     $adminId = Session::get("adminId"); 

                     $adminData = $admin->selectAdminData($adminId); 
 
                     $result = $adminData->fetch(); 
                  ?>
                  <li class="list-group-item list-group-item-dark nav-item nav-link">Hello <?php echo $result["name"]?></li>
                  <?php
                  //check if the get request is set
                  if(isset($_GET["action"])){
                    //call method in cart class to delete
                    //cart data upon logging out
                    //$delData = $cart->deleteCustomerCart(); 

                    //destroy the session if the ID is obtained
                    //the redirection screen location will be the login.php page 
                    Session::destroyAdmin();
                  }
                ?>
                  <a href="?action=logout" class=" list-group-item list-group-item-dark nav-item nav-link">Sign Out</a>
                </ul>
              </div>
          </div>
      </div>
      </div>
    <div>
        <nav class="navbar sticky-top navbar-expand-lg justify-content-between navbar-dark bg-dark">
            <a class="navbar-brand" href="dashboard.php">Administrator</a>
             <button class="navbar-toggler" data-toggle="collapse" data-target="#expandme">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="expandme">
                <div class="navbar-nav">
                     <a href="dashboard.php" class="nav-item nav-link"> <span data-feather="home"></span>Dashboard<span class="sr-only">(current)</span></a>
                     <a href="adminprofile.php" class="nav-item nav-link">Admin Profile</a>
                    <a href="inbox.php" class="nav-item nav-link">Inbox <span class="badge badge-light"><?php echo $messageCount?></span>
                    <span class="sr-only">unread messages</span>
                    </a>
                  </a>
                 </div>
            </div>
        </nav>
    </div>