<?php
//include classes 
    include 'classes/User.php';
    include 'classes/Watchlist.php';
    include 'classes/Watchlater.php';
    $user= new User();
    $watchlist = new Watchlist();
    $watchlater = new Watchlater();
?>
<?php
/**
 * Will see if the request is a post and post array value register is set
 */
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])){

        //call the user class instance fucntion register user the pass the post array data as input
        $registerUser = $user->registerUser($_POST);

        //if the register user variable is set, display it 
        if(isset($registerUser)){
            echo ($registerUser);
        }
    }

    /**
     * will check if the request method is get and the watchlistid get array value is set
     */
    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["watchlistid"])){

        //select the get array value watchlistid and set it equal to the watchlistid variable
        $watchlistid = $_GET["watchlistid"]; 

        //pass the watchlist id variable to the delete watch list function
        //to delete the watchlist instance 
        $deletewatchlist = $watchlist->deleteWatchlist($watchlistid);

        //if the deletewatchlist variable is set, display it
        if(isset($deletewatchlist)){
            echo $deletewatchlist;
        }
    }
/**
 * will check if the request method is a get request and it the watchlaterid get array data value is set
 */
    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["watchlaterid"])){
        //set the watch later id equal to the get arry value watchlaterid
        $watchlaterid = $_GET["watchlaterid"]; 
        //pass the watchlater id to the delete watchlater function and 
        //delete the watchlater instance 
        $deletewatchlater = $watchlater->deleteWatchlater($watchlaterid);

        //if the variable is set, display it. 
        if(isset($deletewatchlater)){
            echo $deletewatchlater;
        }
    }


?>