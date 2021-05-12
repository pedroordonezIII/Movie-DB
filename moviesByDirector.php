<?php include 'inc/pageheader.php';?>
<?php  
//chec if the director id value is not set or if it null and if it is
//redirect to the movie directors page
    if(!isset($_GET["directorId"]) || $_GET["directorId"] == "NULL"){
        echo "<script>window.location = 'movieDirectors.php'</script>";
    }
    //set the director id equal to the value 
    $directorId = $_GET["directorId"]; 

?>


    <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Directors</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php 
                    $directorName = $director->selectDirectorById($directorId);

                    if($directorName){
                        $result = $directorName->fetch();
                ?>
				    <h2><?php echo $result["first_name"]?> <?php echo $result["last_name"]?>  Movies</h2>
                <?php }?>
            <div class="row table-responsive">
                <div class="col-sm">
                <?php 
                    $directorMovies = $director->selectDirectorMovies($directorId);
                    if($directorMovies){
                ?>
                    <table class="table table-bordered border-success style_margin table_style2">
                        <thead>
						    <tr>
                                <th>#</th>
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
          	            while ($result = $directorMovies->fetch() ) {
          	            $i++;//increment
                        ?>
                        <tr>
                            <td><a><?php echo $i; ?></a></td>
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
                            <td>No director movies in the system.</td>
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