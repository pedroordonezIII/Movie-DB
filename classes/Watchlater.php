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

class Watchlater{

    //intialize the private class attributes
    private $db;
    private $fm; 

    //intialize the constructor which will be called when creating
    //an object instance of the class
    public function __construct(){
        //new database object
        $this->db = new Database();
        //new format object 
        $this->fm = new Format();
    }

    /**
     * Input: users unique identification and movies 
     * unique identification. 
     * Output: Error message if an error occurs 
     * Redirect the user to the corresponding page
     * This function will add a specific movie to 
     * a specific users watch later list in the 
     * database.  To do this , the movie must first 
     * be checked to see if the movie with the specific 
     * movie id is not in the users watch later list already
     * If it is, an error will be returned. Otherwise, the 
     * data will e inserted into the user watch later table in 
     * the database.  If is successfully inserted, the user 
     * will be redirected to the watch later list page. Otherwise, 
     * an error will occur.  
     */
    public function insertToWatchlater($userid, $movieid){

        //validate the users input usoing clean text function
        $userid = $this->fm->clean_text($userid);
        $movieid = $this->fm->clean_text($movieid);

        //performa select query of the watchlater table with the condition that 
        //the user id and movie id in the watch later table is equal to the user input 
        $checkMovie = $this->db->link->prepare("SELECT * FROM user_watchlater
                                            WHERE userId = (?)
                                            AND movieId = (?)"); 
        //pass the user input to the execute function
        $checkMovie->execute([$userid, $movieid]); 

        //if the row count is more than zero meaning the movie is alreaduy in the
        //users watch later list , return an error
        if($checkMovie->rowCount() > 0 ){
            $msg = '<p><label class="text-danger">Movie is already in your watchlater list.</label></p>';
            return $msg;  
        }
        else{   

            //perform an insert query on the watch later table and insert the corresonding values into 
            //the table and pass the the prepare function
            $insertMovie = $this->db->link->prepare("INSERT INTO user_watchlater(userId, movieId)
                                                    VALUES(?,?)");
            
            //pass the user id and movie id to the execute function
            $insertMovie->execute([$userid, $movieid]);

            //if the query is successful, redirect to the wishlist page. 
            if($insertMovie){
                header("Location:wishlist.php");
            } 
            //ptherwise return an error
            else{
                $msg = '<p><label class="text-danger">Movie could not be added to the watchlater list.</label></p>';
                return $msg;  
            }


        }

    }

    /**
     * INput: users unique identifcation 
     * Output: reference to the query or false 
     * This functio will take an user id as input 
     * and return the users watch list from the watch
     * list table based on the user id inthe watch later 
     * table that matches the input user id.  If more than
     * one row is returned, a reference to the query is returned
     * Otherwsie, false is returned
     */
    public function selectUserWatchlater($id){

        //validate the form inpjut
        $userId = $this->fm->clean_text($id); 

        //perform a select query on the user watch later table where the 
        //user watch later user id is equal to the input user id.  Also perform
        //an inner join of the movies table based on the matching movie id in both 
        //tables 
        $query = $this->db->link->prepare("SELECT user_watchlater.*, movies.title,
                                        movies.rank, movies.image, movies.id AS movieId
                                        FROM user_watchlater
                                        INNER JOIN movies
                                        ON user_watchlater.movieId = movies.id
                                        WHERE user_watchlater.userId = (?)
                                        ORDER BY movies.rank DESC"); 

        //pass the user id to gthe execute function
        $query->execute([$userId]); 

        //if more than 0 rows are returned, return the query which means that 
        //the user has movies in their watch later list
        if($query->rowCount() > 0){
            return $query;
        } 
        //otherwise, return false
        else{
            return false;
        }
    }

    /**
     * Input: watchlist unique identifcation
     * Output: erro message
     * This function will delete a movie from the 
     * watch later list by performing a query 
     * that deletes the corresponding watch later list
     * with the input id.  If query is successful, the user 
     * will be redirected to the same page.  If it fails, an 
     * error message will be displayed.
     */
    public function deleteWatchlater($id){

        //pass the id to the clean text function to 
        //validate it
        $wishlistid = $this->fm->clean_text($id); 

        //perform a delete query based on the id in the table 
        //matching the input id
        $delete_query = $this->db->link->prepare("DELETE FROM user_watchlater
                                                WHERE id = (?)"); 
        //pass the input to the execute function
        $delete_query->execute([$wishlistid]); 

        //if the deletion is successful, redirect to the wishlist page
        if($delete_query){
            echo "<script>window.location = 'wishlist.php';</script>";
        } 
        //otherwise, return an error.
        else{
            $msg = '<p><label class="text-danger">Movie could not be deleted from the watchlater list.</label></p>';
            return $msg; 
        }
    }
}