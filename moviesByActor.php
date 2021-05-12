<?php include 'inc/pageheader.php';?>
<?php  

//check if the actor id is set or null and if it is, redirect to the
//movies actors page
    if(!isset($_GET["actorid"]) || $_GET["actorid"] == "NULL"){
        echo "<script>window.location = 'movieActors.php'</script>";
    }
    //get the actor id from the get array 
    $actorId= $_GET["actorid"]; 

?>


    <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Actors</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php 
                    $actorName = $actor->selectActorById($actorId);

                    if($actorName){
                        $result = $actorName->fetch();
                ?>
				    <h2><?php echo $result["first_name"]?> <?php echo $result["last_name"]?>  Movies</h2>
                <?php }?>
            <div class="row table-responsive">
                <div class="col-sm">
                <?php 
                    $actorMovies = $actor->selectActorMovies($actorId);
                    if($actorMovies){
                ?>
                    <table class="table table-bordered border-success style_margin table_style2">
                        <thead>
						    <tr>
                                <th>#</th>
                                <th>Role</th>
					            <th>Title</th>
			                    <th>Image</th>
                                <th>Rating</th>
                                <th>Rank</th>
                                <th>Action</th>
						    </tr>
			            </thead>       
                        <?php 
			            //post number
           	            $i = 0;
			            //fetch assoc array for all table items
          	            while ($result = $actorMovies->fetch() ) {
          	            $i++;//increment
                        ?>
                        <tr>
                            <td><a><?php echo $i; ?></a></td>
                            <td><a><?php echo $result["role"]; ?></a></td>
                            <td><a><?php echo $result["title"]; ?></a></td>
                            <td><a href="details.php?movieid=<?php echo $result["movie_id"] ?>">
		                    <img src="<?php echo "system_admin/".$result['image'];?>" class="img-fluid img-thumbnail" width="200px" alt="" /></a></td>
                            <td><a><?php echo $result["rating"]; ?></a></td>
                            <td><a><?php echo $result["rank"]; ?></a></td>
                            <td>
                                <div>
				                    <input type="button"  onClick="details('<?php echo $result['movie_id'];?>')" id="details" 
                                    class="btn btn-outline-success my-2 my-sm-0" value="Details" class="btnSubmit" />
			                    </div>
                                <form action="watchlist.php?movieid=<?php echo $result["movie_id"]?>" method="post">
                                    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="watchlist" value="Add to Watchlist"/>
                                </form>
                                <form action="wishlist.php?movieid=<?php echo $result["movie_id"]?>" method="post">
                                    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="watchlater" value="Add to Watchlater"/>
                                </form>
                            </td>
                        </tr>
                        <?php } } else{?>
                        <tr>
                            <td>No actor movies in the system.</td>
                        </tr>
                        <?php }?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include 'inc/footer.php'; ?>