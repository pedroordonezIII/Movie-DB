<?php include 'inc/pageHeader.php'; ?>

<?php 

//since session will be set upon logging in, use
//the get method to retrieve the user login already set
//which will check if a session is set and if not, it will return false
$login = Session::get("userLogin"); 

//if it is true, redirect to order.php and the login will
//not be accessible to users upon logging in
if($login){
  //redirect to the order.php
  header("Location:index.php"); 
}
?>


<?php 
//check if the request method is a post request and if the login post array value is set
 if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){
    
  //obtain the username from the post array value username
    $username = $_POST["username"];
  
  //perform a select query from the admins table where the username
  //is equal to the input username and pass the query to the prepare function
    $query = $data->link->prepare("SELECT * FROM admins
                                    WHERE username = (?)"); 

  //pass the input username to the execute function to set the values
    $query->execute([$username]); 
  //if more than zero rows are returned, then the user is an admin and the 
  //admin instance class function admin login will be called with the post array data
    if($query->rowCount() > 0){
      $login = $admin->adminLogin($_POST);
    } 
    //otherwise, the user class instance function is called and the post array
    //data is passed as input
    else{
      $login = $user->userLogin($_POST); 
    }
 }

?>


<div class="container">
  <div class="">


              <?php 
              if(isset($login)){
                echo $login;
              }
              ?>

          <h3>Existing Customers</h3>
          <p>Sign in with the form below.</p>
          <form class="row g-3" action=" " method="post">
            <div class="col-md-12">
                <label class="form-label">Username</label>
                <input class="form-control" name="username" placeholder="Username" type="text">
            </div>
            <div class="col-md-12">
                 <label class="form-label">Password</label>
                 <input class="form-control" name="password" placeholder="Password" type="password" >
            </div>
            <div class="col-12">
            <div>
                <button type="submit" name="login"
                class="btn btn-outline-success my-2 my-sm-0">Sign In</button>
            </div>
         </div>
        </form>
  </div>
</div>
</div>
  <?php include 'inc/footer.php'; ?>  