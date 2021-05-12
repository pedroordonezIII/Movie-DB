
<?php include 'inc/pageheader.php'; ?>

<?php 
//call the select all movies function to select all movies
    $selectAllMovies = $movie->selectAllMovies(); 
//check if the request method is a get method and the movie id get array value is set
    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movieid"])){
//set the user id equal to the sessions userid by accessing it with the get function in the session class
        $userId = Session::get("userid"); 
        //set the movie id equal to the get movie id value
        $movieid = $_GET["movieid"];
        //call the watchlist class instance function insert to watchlist and pass the 
        //user id and movie id values
        $addToWatchList = $watchlist->insertToWatchlist($userId, $movieid);
    }
    //if the server request method is a get method and the corresponding get array value is set
    //then do the content in the statement
    else if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["watchlatermovieid"])){

        //get the session user id set for the session
        $userId = Session::get("userid"); 
        //set the movie id equal to the get array movie id value
        $movieid = $_GET["watchlatermovieid"];

        //call the insert to watch later function and pass the user id and movie id 
        //parameters
        $addToWatchLater = $watchlater->insertToWatchlater($userId, $movieid);
    }
?>



<div class="main content_style">
   <div class="content">
       <div class="content_top">
           <div class="heading">
           <h1 id="center">Showplace Movie Database</h1> 
           <h3>All Movies</h3>
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
           </div>
           <div class="clear"></div>
       </div>
         <div class="row"">

         <?php
          if ($selectAllMovies) {
            while ($result = $selectAllMovies->fetch()) {
          
         ?>
               <div class="col-xs-12 col-sm-6 col-md-3 col-lg-4 border border-success">
		        <a href="details.php?movieid=<?php echo $result["id"] ?>">
		        <img src="<?php echo "system_admin/".$result['image'];?>" class="img-fluid img-thumbnail" width="200px" alt="" /></a>
		        <h4><?php echo $result["title"]; ?></h4>
                <p>Rank: <?php  echo $result["rank"]?></p>
		        <div><span><a class="btn btn-outline-success my-2 my-sm-0" onClick="details('<?php echo $result['id'];?>')" class="details">Details</a></span></div>
                <?php if(Session::get("userLogin")){?>
                <div><span><a class="btn btn-outline-success my-2 my-sm-0" href="?movieid=<?php echo $result['id']; ?>" class="details">Add to Watchlist</a></span></div>
                <div><span><a class="btn btn-outline-success my-2 my-sm-0" href="?watchlatermovieid=<?php echo $result['id']; ?>" class="details">Add to Watchlater</a></span></div>
                <?php }?>
             </div>
                <?php  } } else {?> 
                    <p>No movies in the system.</p>
                <?php } ?>
               </div>
           </div>
   </div>
</div>
</div>
    <?php include 'inc/footer.php'; ?>