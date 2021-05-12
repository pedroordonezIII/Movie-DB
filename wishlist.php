<?php include 'inc/pageHeader.php'; ?>
 
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
//check if the movieid get is set
	if(isset($_GET["movieid"])){
		//set the movie id to the movie id get array value
		$movieid = $_GET["movieid"];
	}
	//check if the request is the post and if the watchlater post value is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["watchlater"])){

		//get the user id from the current session
        $userId = Session::get("userid"); 

		//call the insert to watchlater function and pass the user id 
		//and the movie id as paramters.
		//
        $addToWatchlater = $watchlater->insertToWatchlater($userId, $movieid);
    }
?>
 

 <div class="">
    <div class="">	
			<div class="table-responsive">
			    	<h2>Your Watchlater List</h2>
					<div id="addwatchlist">
                    <?php
                        if(isset($addToWatchlater)){
                            echo $addToWatchlater;
                        }
                    ?>
                    </div>
					<?php 
					$userId = Session::get("userid"); 
					$selectWatchlater = $watchlater->selectUserWatchlater($userId);

					if($selectWatchlater){
					?>
						<table class = "table container center table-bordered  align-middle">
							<tr>
								<th width="5%">#</th>
								<th width="30%">Movie Title</th>
								<th width="10%">Rank</th>
								<th width="15%">Image</th>
								<th width="10%">Action</th>
							</tr>
                    			<?php
								$i = 0; 
								while($result = $selectWatchlater->fetch()){
								$i++; 
 						    	?>
 								<tr>
									<td> <?php echo $i; ?></td>
									<td><?php echo $result["title"];?></td>
									<td><?php echo $result["rank"]?></td>
									<td><img src="system_admin/<?php echo $result["image"];?>" class="img-fluid img-thumbnail" alt=""/></td>
									<td>
										<div>
											<a class ="btn btn-outline-success my-2 my-sm-0" onClick="details('<?php echo $result['movieId'];?>')">Details</a> 
										</div>
										<div>
											<a class ="btn btn-outline-success my-2 my-sm-0" onClick="deleteWatchlater('<?php echo $result['id'];?>')">Remove</a>
										</div>
									</td>
								</tr>
 							 

							<?php } ?>
							 
							
						</table>
								         
							<?php } else{?>
								<p>Watchlater list is currently empty.</p>
							<?php }?>
					</div>
    	</div>  	
    </div>
</div>
   
<?php include 'inc/footer.php'; ?>