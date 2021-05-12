
<?php include 'inc/pageheader.php';?>
<?php  
//check if the category id is not set or if it is null and if it is,
//rediret to the movie categories screen
    if(!isset($_GET["categoryId"]) || $_GET["categoryId"] == "NULL"){
        echo "<script>window.location = 'movieCategories.php'</script>";
    }
    //set the category id equal to the category id get array value
    $categoryId = $_GET["categoryId"]; 

?>

    <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Movies</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php 
                    $categoryName = $category->selectCategoryById($categoryId);

                    if($categoryName){
                        $result = $categoryName->fetch();
                ?>
				    <h2><?php echo $result["name"]?> Movies</h2>
                <?php }?>
            <div class="row table-responsive">
                <div class="col-sm">
                <?php 
                    $selectMovies = $movie->selectMovieByCategoryId($categoryId);     
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
                            <td>No category of this type in the system.</td>
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