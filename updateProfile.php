<?php
include("inc/pageheader.php"); 
?>

<style>
 .tblone{width: 550px; margin: 0 auto; border: 2px solid #ddd; } 
 .tblone tr td{text-align: justify;} 
 .tblone input[type="text"]{width:400px; padding: 5px; font-size: 15px; }

</style>

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


<?php

    //get the user id
    $userId = Session::get("userid"); 

    //chec if the post and submit post are requested
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])){

        //call the update CustomerData Method from the user class
        $updateDetails = $user->updateUserDetails($_POST, $userId); 
    }

?>

<div>
    <div>
        <?php 
        //check if the updateData is set
        //to show the return value
        if(isset($updateDetails)){
            echo $updateDetails;
        }
        ?>
    <div>
    <?php 
    //get the current user id for the user in the session
    $id = Session::get("userid"); 
    //call the getCustomerData method to display data
    $selectDetails = $user->selectUserDetails($id); 

    //check if anything is returned
    if($selectDetails){

        //run while loop to display data from the row
        while ($userData = $selectDetails->fetch()){
    
    ?>
   <form action=" "  method="post" enctype="multipart/form-data">   
    <table class = "table container center table-bordered  align-middle">
       <tr>
          <td colspan="2"> <h2>Update Profile Details</h2> </td>   
      </tr>
      <tr>
          <td width="20%"> First Name  </td>  
          <td> <input type="text" name="f_name" value="<?php echo $userData["f_name"];?>"> </td>
      </tr>
      <tr>
          <td> Last Name</td>
          <td> <input type="text" name="l_name" value="<?php  echo $userData["l_name"];?>">  </td>
      </tr>
      <tr>
          <td> City  </td>
          <td><input type="text" name="city" value="<?php echo $userData["city"];?>">  </td>
      </tr>
      <tr>
          <td> Zipcode  </td> 
          <td> <input type="text" name="zip" value="<?php echo $userData["zip"];?>">  </td>
      </tr>
      <tr>
          <td> Country  </td> 
          <td> <input type="text" name="country" value="<?php echo $userData["country"];?>">  </td>
      </tr>
      <tr>
          <td> </td>
          <td><input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Save Profile"> </td>
      </tr>
    </table>
   </form>
   <?php } } else{?>
   <p>User data is not available.</p>
   <?php }?>
</div>
</div>
</div>
</div>

<?php
include("inc/footer.php"); 
?>


