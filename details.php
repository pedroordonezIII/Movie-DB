
<?php include 'inc/pageheader.php'; ?>

<?php

/**
 * check if the movieid get request is set and if not
 * redirect to the 404 page. 
 */
if (!isset($_GET['movieid'])  || $_GET['movieid'] == NULL ) {
    echo "<script>window.location = '404.php';  </script>";
 }
 //otherwise, access the get array with the movieid value
 else {
   $movieid = $_GET['movieid'];
 }


?>

<?php 
//check for the post request and if the post array watchlist value is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["watchlist"])){

        //get the user id for the current session by calling the static get variable
        //and accessing the userid that is set for the user in the sesion
        $userId = Session::get("userid"); 

        //call the watchlist instance function insert to watch list and pass the 
        //user id and movie id as parameters
        $addToWatchList = $watchlist->insertToWatchlist($userId, $movieid);
    }
    //if the request is a post request and the watchlater post arry value is set, do this
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["watchlater"])){

        //set the user id equal to the user id set for the session 
        $userId = Session::get("userid"); 
        //access the watchlater class instance function insert to watchlater 
        //and pass the user id and movie id to insert to the watch list
        $addToWatchLater = $watchlater->insertToWatchlater($userId, $movieid);
    }
?>

<style>
.mybutton{width: 100px;float: left;margin-right: 45px;}	

</style>


<div class="container content_style"> 
               <div class="">	

                <?php 
                //access the product class object method
                $selectMovie = $movie->selectMovieById($movieid); 
                 if ($selectMovie) {
                     //retrieve associative array of query
                     while ($result = $selectMovie->fetch()) { 
                   ?>
                   <div class="d-flex justify-content-center">
                        <div class="row">
                            <div class="col-12">
                                <h1><?php echo $result['title'];?></h1>
                            </div>
                        </div>
                    </div>
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
                   <div class="row">
                        <div class="col-4">
                            <img src="<?php echo "system_admin/".$result['image']; ?>" class="img-fluid img-thumbnail" alt="" />
                        </div>
                        <div class="col-8">
                        <h2>Movie Details</h2>
                        <p><?php echo $result['summary'];?></p>
                        </div>
                   </div>
               <div class="style_margin">					
                   <div class="row">
                        <div class="col-12">
                       <p>Rank: <span><?php echo $result['rank'];?></span></p>
                       <p>Rating: <span><?php echo $result['rating'];?></span></p>
                       <p>Release Date: <span><?php echo $result['release_date'];?></span></p>
                       <p>Runtime:<span><?php echo $result['runtime'];?></span></p>
                       </div>
                   </div>
                   
                   <div class="row">
                        <div class="col-12">
                        <?php 
                        $selectMovieCategories = $category->selectCategoriesByMovieId($movieid); 

                        if($selectMovieCategories){
                        ?>
                            <?php 
                            while($result = $selectMovieCategories->fetch()){
                            ?>
                            <p>Category: <span><?php echo $result['name'];?></span></p>
                        </p>
                        <?php }} else{?>
                            <p>Category: <span>No category present.</span></p>
                        <?php }?>
                       </div>
                       <div class="col-12">
                        <?php 
                        $selectMovieGenres = $genre->selectGenresByMovieId($movieid); 

                        if($selectMovieGenres){
                        ?>
                            <?php 
                            while($result = $selectMovieGenres->fetch()){
                            ?>
                            <p>Genre: <span><?php echo $result['name'];?></span></p>
                        </p>
                        <?php }} else{?>
                            <p>Genre: <span>No genres present.</span></p>
                        <?php }?>
                       </div>
                   </div>
                <?php if(Session::get("userLogin")){?>
               <div class="row">
                    <div class="col-12">
                   <form action="details.php?movieid=<?php echo $movieid?>" method="post">
                       <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="watchlist" value="Add to Watchlist"/>
                   </form>	
                   </div>			
               </div>
               <?php }?>     
                <?php 
                ?>
            <?php if(Session::get("userLogin")){?>
               <div class="row justify-content-center style_margin">
                   <div class="col-4">  
                   <form action="details.php?movieid=<?php echo $movieid?>" method="post">
                       <input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="watchlater" value="Add to Watchlater"/>
                   </form>	
                   </div>
               </div>    
           <?php }?>

           </div>	
           <?php }} else{?>
            
           <?php header("Location: 404.php"); }?>
   </div>
 </div>
 </div>
<?php include 'inc/footer.php'; ?>  