<?php
include("inc/pageheader.php"); 
?>


<?php 

//since session will be set upon logging in, use
//the get method to retrieve the user login already set
//which will check if a session is set and if not, it will return false
$login = Session::get("userLogin"); 

//if it is true, redirect to order.php and the login will
//not be accessible to users upon logging in
if(!($login)){
  //redirect to the order.php
  header("Location:login.php"); 
}
?>

<?php
    //get the userid for the current user by accessing the user id for the session
    $userId = Session::get("userid"); 
    //if the server request is a post and the post array at submit is set do this
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

        //call the message class instance variable insert user message
        //and mass the post data array and unique user id for the session
        //to insert the users current message
        $sendMessage = $message->insertUserMessage($_POST, $userId); 
    }
?>

<div>
    <div>
    	<div>
  			<div>
  				<h3>Live Support</h3>
  				<p><span>24 hours | 7 days a week | 365 days a year &nbsp;&nbsp;</span></p>
  				<p> 
                Contact us if you encounter any issues or need additional information. We have someone available to 
                help you solve any issues you encounter 24 hours daily.  
                </p>
  			</div>
  			<div></div>
  		</div>
    	    <div>
				  	<h2>Contact Us</h2>
                      <?php 
                        if(isset($sendMessage)){
                            echo $sendMessage;
                        }
                    ?>
                      <form action="" method="post">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input class="form-control" type="text" name="subject" placeholder="Enter Subject" />
                        </div>
                        <div class="form-group">
                            <label for="subject" class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="8"></textarea>
                        </div>
                        <button type="submit" name="submit" class="btn btn-outline-success my-2 my-sm-0">Submit</button>
                    </form>
      			    <div>
				    <h2>Company Information:</h2>
						<p>City: Hays</p>
						<p>State: Kansas</p>
						<p>USA</p>
				   		<p>Phone:000-000-0000</p>
				   		<p>Fax: (000) 000 00 00 0</p>
				 	 	<p>Email: <span>email5@gmail.com</span></p>
			     </div>   	
         </div>
    </div>
</div>
</div>

<?php
include("inc/footer.php"); 
?>