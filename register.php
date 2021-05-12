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
 
    // if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])){

    //     $registerUser = $user->registerUser($_POST);
    // }
?>

<div class="container">
  <div class="">
      <div id="message">
            <?php 
                // if(isset($registerUser)){
                //     echo $registerUser;
                // }
              ?>
      </div>
          <h3>Register New Account</h3>
        <form class="row g-3" action=" "  method="post">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input class="form-control" type="text" id="firstname" name="firstname" placeholder="First Name" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Last Name" />
            </div>
            <div class="col-md-6">
                <label class="form-label">City</label>
                <input class="form-control" type="text" id="city" name="city" placeholder="City" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Country</label>
                <input class="form-control" type="text" id="country" name="country" placeholder="Country" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Zip</label>
                <input class="form-control" type="text" id="zip" name="zip" placeholder="Zip" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Username</label>
                <input class="form-control" type="text" id="username" name="username" placeholder="Username" />
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input class="form-control" type="text" id="email" name="email"
                placeholder="Email" />
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input class="form-control" type="text" id="password" name="password" placeholder="password" />
            </div>
         <div class="col-12">
            <div>
                <input type="button" id="register" name="register" onClick="registerUser();"
                class="btn btn-outline-success my-2 my-sm-0" value="Create Account"></input>
            </div>
         </div>
        </form>
    </div>
 </div>
</div>
<?php include 'inc/footer.php'; ?>