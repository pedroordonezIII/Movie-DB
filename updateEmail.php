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

    // //get the user id
    $userId = Session::get("userid"); 

    //chec if the post and submit post are requested
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["update"])){

        //call the update CustomerData Method from the user class
        $updateEmail = $user->updateUserEmail($_POST, $userId); 
        
    }

?>

<div>
    <div>
    <div id="message">
        <?php 
        //check if the updateData is set
        //to show the return value
        if(isset($updateEmail)){
            echo $updateEmail;
        }
        ?>
    </div>
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
   <form action=" "  method="post" enctype="">   
    <table class = "table container center table-bordered  align-middle">
       <tr>
          <td colspan="2"> <h2>Update Email</h2> </td>   
      </tr>
      <tr>
          <td> Email  </td>
          <td> <input type="text" id="email" name="email" value="<?php echo $userData["email"];?>">   </td>
      </tr>
      <tr>
          <td> </td>
          <td>
          <input type="submit" id="update" name="update"
                class="btn btn-outline-success my-2 my-sm-0" value="Save email"></input>
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

