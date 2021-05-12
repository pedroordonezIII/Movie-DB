<?php 
/**
 * the real path will be the directory name
 * which is a file. When using the real path,
 * will load the entire path
 */
 $filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 
?>


<?php

class Watchlist{

    //initialize class attributes
    private $db;
    private $fm; 

    //intialize class constructor for when the class is called
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * InputL unique user id and unique movie id
     * Output : error message if failure occurs
     * This function will input a user id and movie
     * id into the watchlist table to correspond to
     * a specific users movie watch list.  Before 
     * inserting the data the input must be validated
     * and if an error occurs, the error message will 
     * be returned. 
     */
    public function insertToWatchList($userid, $movieid){

        //clean the user input with the clean text function
        $userid = $this->fm->clean_text($userid);
        $movieid = $this->fm->clean_text($movieid);

        //perform a select query on the watchlsits table 
        //where the user id and movie in the table equal the 
        //input data and pass the to the prepare functino
        $checkMovie = $this->db->link->prepare("SELECT * FROM user_watchlists
                                            WHERE userId = (?)
                                            AND movieId = (?)"); 
        //pass iinput to the execute function
        $checkMovie->execute([$userid, $movieid]); 

        //if the row count is greater than 0 which means that the movie is 
        //in the corresponding users watchlist, return an error
        if($checkMovie->rowCount() > 0 ){
            $msg = '<p><label class="text-danger">Movie is already in your watchlist.</label></p>';
            return $msg;  
        }
        else{
            //otherwise, perform an insert query on the watchlists table and insert the 
            //corresponding value and pass the the prepare function
            $insertMovie = $this->db->link->prepare("INSERT INTO user_watchlists(userId, movieId)
                                                    VALUES(?,?)");
            
            //pass the values to the execute function including the userid and movieid
            $insertMovie->execute([$userid, $movieid]);

            //if the insert query is successful, redirect to the watchlist page
            if($insertMovie){
                header("Location:watchlist.php");
            } 
            //otherwise, return an error
            else{
                $msg = '<p><label class="text-danger">Movie could not be added to the watchlist.</label></p>';
                return $msg;  
            }


        }

    }

    /**
     * Input: user unique id
     * Output: reference to the query object
     * or false if query failed
     * This function will select all the entries 
     * in the user_watchlists table in the database
     * with the specific unique user identification.  
     * If more than 0 rows are returned, which means
     * the user has items in their watchlist, the 
     * query will be returned.  Otherwise, false will
     * be returned.
     */
    public function selectUserWatchlist($id){

        //clean the user input with the clean text function
        $userId = $this->fm->clean_text($id); 

        //perform a select query on the user watchlists table, 
        //where the user id in the watchlists table is equal to 
        //the input id.  Additionally , perform an inner join
        //of the movies table  where the watchlists movie id 
        //is equal to the movies id in the movies table to access 
        //movie columns
        $query = $this->db->link->prepare("SELECT user_watchlists.*, movies.title,
                                        movies.rank, movies.image, movies.id AS movieId
                                        FROM user_watchlists
                                        INNER JOIN movies
                                        ON user_watchlists.movieId = movies.id
                                        WHERE user_watchlists.userId = (?)
                                        ORDER BY movies.rank DESC"); 

        //pass the unique user id to the execute function
        $query->execute([$userId]); 

        //if more than 0 rows are returned, return the query, which means that 
        //the user has items in their watchlist
        if($query->rowCount() > 0){
            return $query;
        } 
        //otherwise, return false.  
        else{
            return false;
        }
    }

    /**
     * Input: uniqe watch list identifcation 
     * This function will take a unique watchlist 
     * id as input and delete the corresponding item
     * from the watchlists table with that id by performing
     * a delete query.  If the query is successful, the 
     * page is redirected to the watchlist page and if it fails,
     * an error message will be displayed
     */
    public function deleteWatchlist($id){
        //validate the form input
        $watchlistid = $this->fm->clean_text($id); 

        //pass a delete query to the prepare function. the delete query
        //will delete the row from the watchlists table with the id equal 
        //to the input id
        $delete_query = $this->db->link->prepare("DELETE FROM user_watchlists
                                                WHERE id = (?)"); 
        //pass the input to the execute function
        $delete_query->execute([$watchlistid]); 

        //if successful, reload the page
        if($delete_query){
            echo "<script>window.location = 'watchlist.php';</script>";
        } 
        //otherwise return an error
        else{
            $msg = '<p><label class="text-danger">Movie could not be deleted from the watchlist.</label></p>';
            return $msg; 
        }
    }
}