<?php include 'inc/pageheader.php';?>
<?php  
//check if the request method is get and the movieid get request is set
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movieid"])){

    //set user id equal to the user id set for the session
    $userId = Session::get("userid"); 
    //set the movie id equal to the get request movie id
    $movieid = $_GET["movieid"];

    //call the insert to watchlist function from the watchlist
    //class instance and pass the user id and movie id
    $addToWatchList = $watchlist->insertToWatchlist($userId, $movieid);
} 
//otherwise, if the method is a get request and the request is to add to the watch later, do this
else if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["watchlatermovieid"])){

    //set the userid variable equal to the user id of the current session
    $userId = Session::get("userid"); 
    //set the movie id equal to the get movie id in the get array
    $movieid = $_GET["watchlatermovieid"];

    //call the watchlater class instance fucntion insert to watchlater
    //and pass the user id and the movie id as inputs
    $addToWatchLater = $watchlater->insertToWatchlater($userId, $movieid);
} 
?>


    <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Movies</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
				<h2>Movie Rankings</h2>
                <div id="addwatchlist">
                    <?php
                        if(isset($addToWatchList)){
                            echo $addToWatchList;
                        }
                        if(isset($addToWatchLater)){
                            echo $addToWatchLater;
                        }
                    ?>
            </div>
            <div class="row table-responsive">
                <div class="col-sm">
                <?php 
                   $selectMovies = $movie->selectAllMovies();     
                   if ($selectMovies) {
                ?>
                    <table class="table table-bordered border-success style_margin table_style2">
                        <thead>
						    <tr>
                                <th>#</th>
					            <th>Title</th>
                                <th>Rating</th>
                                <th>Rank</th>
                                <th>Image</th>
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
                            <td><a><?php echo $result["rating"]; ?></a></td>
                            <td><a><?php echo $result["rank"]; ?></a></td>
                            <td><a href="details.php?movieid=<?php echo $result["id"] ?>">
		                    <img src="<?php echo "system_admin/".$result['image'];?>" class="img-fluid img-thumbnail" width="200px" alt="" /></a></td>
                            <td><a class="btn btn-outline-success my-2 my-sm-0" href="details.php?movieid=<?php echo $result['id']; ?>">Details</a>
                            <?php if(Session::get("userLogin")){?>
                            <div><span><a class="btn btn-outline-success my-2 my-sm-0" href="?movieid=<?php echo $result['id']; ?>" class="details">Add to Watchlist</a></span></div>
                            <div><span><a class="btn btn-outline-success my-2 my-sm-0" href="?watchlatermovieid=<?php echo $result['id']; ?>" class="details">Add to Watchlater</a></span></div>
                            <?php }?>
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