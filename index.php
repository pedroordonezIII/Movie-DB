<?php include "inc/pageheader.php"?>

<?php
	// if(isset($_POST["movieid"])){
	// 	$movieid = $_POST["movieid"]
	// }

	if(isset($_GET["movieid"])){
		$movieid = $_GET["movieid"];
	 }
?>

<?php 
//check for the post request and if the watchlist post array value is set and if they are do this
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["watchlist"])){
		//set the user id equal to the user id set for the session by
		//accessing the get request with the user id
        $userId = Session::get("userid");
		//access the watchlist object instance function insert to watchlist 
		//and pass the user id and movie id as parameters to the function
        $addToWatchList = $watchlist->insertToWatchlist($userId, $movieid);
    } 
	//check if the request is a post and if the watchlater post array value is set and if they are, do the
	//actions inside the statement
	else if(($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["watchlater"]))){
		//get the users session id for the current session
		$userId = Session::get("userid");
		//access the watchlater class instance function insert to watch later
		//and pass the user id and movie id as parameters
        $addToWatchLater = $watchlater->insertToWatchlater($userId, $movieid);

	}
?>

<div class=" container content_style">
    <h1 id="center">Showplace Movie Database</h1>  
    <span style="color: red; font-size: 18px;">
    <?php
    	if(isset($addToWatchList)){
            echo $addToWatchList;
        } 
		if(isset($addToWatchLater)){
            echo $addToWatchLater;
        } 

    ?>
    </span> 
    <?php
	$topRatedMovies = $category->selectTopRatedMovies(); 

	if($topRatedMovies){
	?> 
    <div class="content_top style_margin">
    	<div class="heading">
    		<h3>Top Rated Movies</h3>
    	</div>
    </div>
	<div class="row">
        <?php 
        while($result = $topRatedMovies->fetch()){
        ?>
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 border border-success">
			<a onClick="details('<?php echo $result['movie_id'];?>')">
		    <img src="<?php echo "system_admin/".$result['image'];?>" class="img-fluid img-thumbnail" width="200px" alt="" /></a>
		    <h4><?php echo $result["title"]; ?></h4>
		    <p><?php  echo $format->textShorten($result['summary'], 60);?></p>
		    <div>
				<input type="hidden" name="movieid" id="movieid" value="<?php echo $result['movie_id']; ?>" class="details"></input>
			</div>
			<?php if(Session::get("userLogin")){?>
			<form action="index.php?movieid=<?php echo $result['movie_id']; ?>" method="post">
                <span>
					<input class="btn btn-outline-success my-2 my-sm-0"
					type="submit" name="watchlist" value="Add to Watchlist"/>
                </span>
            </form>
			<form action="index.php?movieid=<?php echo $result['movie_id']; ?>" method="post">
                <span>
					<input class="btn btn-outline-success my-2 my-sm-0"
					type="submit" name="watchlater" value="Add to Watchlater"/>
                </span>
            </form>
			<?php }else{ ?>
				<div>
					<input type="button"  onClick="details('<?php echo $result['movie_id'];?>')" id="details" class="btn btn-outline-success my-2 my-sm-0" value="Details" class="btnSubmit" />
				</div>
			<?php }?>
	    </div>
        <?php  }}?>
	</div>
	<?php
	$mostPopularMovies = $category->selectMostPopularMovies(); 

	if($mostPopularMovies){
	?>
	<div class="content_bottom style_margin">
    	<div class="heading">
    	    <h3>Most Popular Movies</h3>
    	</div>
    </div>
	<div class="row">
        <?php 
        while($result = $mostPopularMovies->fetch()){
        ?>
	     <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 border border-success">
		    <a onClick="details('<?php echo $result['movie_id'];?>')">
		    <img src="<?php echo "system_admin/".$result['image'];?>" class="img-fluid img-thumbnail" width="200px" alt="" /></a>
		    <h4><?php echo $result["title"]; ?></h4>
		    <p><?php  echo $format->textShorten($result['summary'], 60);?></p>
		    <div>
				<input type="button"  onClick="details('<?php echo $result['movie_id'];?>')" id="details" class="btn btn-outline-success my-2 my-sm-0" value="Details" class="btnSubmit" />
			</div>
	    </div>
	    <?php }}?>
	</div>
	<?php
	$dramaMovies = $genre->selectDramaMovies(); 

	if($dramaMovies){
	?>
    <div class="content_bottom style_margin">
    	<div class="heading">
    	    <h3>Drama Movies</h3>
    	</div>
    </div>
	<div class="row">
        <?php 
			while($result = $dramaMovies->fetch()){
        ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 border border-success">
			<a onClick="details('<?php echo $result['movie_id'];?>')">
		    <img src="<?php echo "system_admin/".$result['image'];?>" class="img-fluid img-thumbnail" width="200px" alt="" /></a>
		    <h4><?php echo $result["title"]; ?></h4>
		    <p><?php  echo $format->textShorten($result['summary'], 60);?></p>
			<p>Rank: <?php  echo $result["rank"];?></p>
		    <div>
				<input type="button"  onClick="details('<?php echo $result['movie_id'];?>')" id="details" class="btn btn-outline-success my-2 my-sm-0" value="Details" class="btnSubmit" />
			</div>
	    </div>
	    <?php }}?>
	</div>
	<?php
	$actionMovies = $genre->selectActionMovies(); 

	if($actionMovies){
	?>
    <div class="style_margin">
    	<div class="">
    	    <h3>Action Movies</h3>
    	</div>
    </div>
	<div class="row">
		<?php 
			while($result = $actionMovies->fetch()){
        ?>
	    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 border border-success">
			<a onClick="details('<?php echo $result['movie_id'];?>')">
		    <img src="<?php echo "system_admin/".$result['image'];?>" class="img-fluid img-thumbnail" width="200px" alt="" /></a>
		    <h4><?php echo $result["title"]; ?></h4>
		    <p><?php  echo $format->textShorten($result['summary'], 60);?></p>
			<p>Rank: <?php  echo $result["rank"];?></p>
		    <div>
				<input type="button"  onClick="details('<?php echo $result['movie_id'];?>')" id="details" class="btn btn-outline-success my-2 my-sm-0" value="Details" class="btnSubmit" />
			</div>
	    </div>
	    <?php }}?>
	</div>
    </div>
	</div>   
</div>
</div>
<?php include "inc/footer.php"?>
