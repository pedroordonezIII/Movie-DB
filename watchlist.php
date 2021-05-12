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
//check if the movied get value is set
	if(isset($_GET["movieid"])){
		//set the movie id as the movieid get value
		$movieid = $_GET["movieid"];
	}
	//check if the post request and the watchlist post are set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["watchlist"])){
		//set the user id to the user id set for the user in the session
        $userId = Session::get("userid"); 
		//call the insert to watchlist function and pass the user id and movieid
        $addToWatchList = $watchlist->insertToWatchlist($userId, $movieid);
    }
?>
 

 <div class="">
    <div class="">	
			<div class="table-responsive">
			    	<h2>Your Watchlist</h2>
					<div id="addwatchlist">
                    <?php
                        if(isset($addToWatchList)){
                            echo $addToWatchList;
                        }
                    ?>
                    </div>
					<?php 
					$userId = Session::get("userid"); 
					$selectWatchlist = $watchlist->selectUserWatchlist($userId);

					if($selectWatchlist){
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
								while($result = $selectWatchlist->fetch()){
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
											<a class ="btn btn-outline-success my-2 my-sm-0" onClick="deleteWatchlist('<?php echo $result['id'];?>')">Remove</a>
										</div>
									</td>
								</tr>
 							 

							<?php } ?>
							 
							
						</table>
								         
							<?php } else{?>
								<p>Watchlist is currently empty.</p>
							<?php }?>
					</div>
    	</div>  	
    </div>
</div>
   
<?php include 'inc/footer.php'; ?>