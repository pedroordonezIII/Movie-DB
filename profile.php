<?php include 'inc/pageHeader.php'; ?>

<?php 
 //will check the session login
  $login =  Session::get("userLogin");
  //if no session is set, redirect to the login
  //page. Profile page will not be accessible when logging out
  //but this method is better since those fields can be updated
  //and if they are updated, the session will still contain the old
  //user data
  if ($login == false) {
  	header("Location:login.php");
  }

  ?>
<div class="container">
   <div class="row">
   <div class="table-responsive">
  <?php
  //get the current session ID set in the User class
  //login method
  $id = Session::get("userid");

  //get the data based on the ID of the user from user
  //class, so can access all data by using the session get method
  $selectDetails = $user->selectUserDetails($id); 

  //check if the data is returned
  if($selectDetails){
     //go through the entire row based on the user
     while($userData = $selectDetails->fetch()){
  ?>
<table class="table container center table-bordered align-middle">
   <tr>
      <td colspan="3"> <h2> Profile Details </h2> </td>
   </tr>
   <tr>
      <td width="20%"> First Name  </td>
      <td width="5%"> : </td>
      <td><?php echo $userData["f_name"];?></td>
   </tr>
   <tr>
      <td> Last Name  </td>
      <td> : </td>
      <td><?php echo $userData["l_name"];?></td>
   </tr>
   <tr>
      <td> Email  </td>
      <td> : </td>
      <td><?php echo $userData["email"];?> </td>
   </tr>
   <tr>
      <td> Username  </td>
      <td> : </td>
      <td> <?php echo $userData["username"];;?> </td>
   </tr>
   <tr>
      <td> City  </td>
      <td> : </td>
      <td><?php echo $userData["city"];;?></td>
   </tr>
   <tr>
      <td> Zipcode  </td>
      <td> : </td>
      <td><?php echo $userData["zip"];;?></td>
   </tr>
   <tr>
      <td> Country  </td>
      <td> : </td>
      <td><?php echo $userData["country"];?></td>
   </tr>
   <tr>
      <td>   </td>
      <td>  </td>
      <td>
      <a  class="btn btn-outline-success my-2 my-sm-0" href="updateProfile.php">Update Details
      <a  class="btn btn-outline-success my-2 my-sm-0" href="updateEmail.php">Update Email
      <a  class="btn btn-outline-success my-2 my-sm-0" href="updateUsername.php">Update Username
      </td>
   </tr>
</table>
<?php } } else{?>
    <p>No user profile information.</p>
<?php } ?>
   </div>
   </div>
</div>
</div>
</div>
</div>


<?php
include("inc/footer.php"); 
?>