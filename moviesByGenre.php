<?php include 'inc/pageheader.php';?>
<?php  
//check if the genre id is not set or if it is null and if it is, 
//redirect the user to the movie genres screen in the database
    if(!isset($_GET["genreId"]) || $_GET["genreId"] == "NULL"){
        echo "<script>window.location = 'movieGenres.php'</script>";
    }   

    //get the genre id from the get array data and set it equal to the genre id
    $genreId = $_GET["genreId"]; 

?>


    <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Genres</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php 
                    $genreName = $genre->selectGenreById($genreId);

                    if($genreName){
                        $result = $genreName->fetch();
                ?>
				    <h2><?php echo $result["name"]?> Movies</h2>
                <?php }?>
            <div class="row table-responsive">
                <div class="col-sm">
                <?php 
                    $selectMovies = $movie->selectMovieByGenreId($genreId);     
                    if ($selectMovies) {
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
          	            while ($result = $selectMovies->fetch() ) {
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
                            <td>No genre of this type in the system.</td>
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