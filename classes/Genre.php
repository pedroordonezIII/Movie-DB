<?php
$filepath = realpath(dirname(__FILE__)); 

include_once($filepath."/../lib/Database.php");
include_once($filepath."/../helpers/Format.php");

?>



<?php

class Genre{

    //instantiate the class attributes
    public $db; 
    public $fm; 

    //instantiate the class constructor which is called when
    //instantiating the genre class
    public function __construct(){
        $this->db = new Database(); 
        $this->fm = new Format(); 
    }

    /**
     * This function will take a genre name as input 
     * and check if the genre name is already in the genres
     * table in the database. If the row count is greater than
     * 0, the query will be returned, otherwise false will be returned
     */
    public function checkForDuplicates($genreName){

        //pass the genre name to the clean text function to clean the text
        $genreName = $this->fm->clean_text($genreName);

        //perform a select query of the genres table where the name is 
        //equal to the input name. Pass to the prepare function
        $query = $this->db->link->prepare("SELECT * FROM genres
                                        WHERE name = (?)"); 
        
        //pass the input to the execute function
        $query->execute([$genreName]); 

        //if more than 0 rows are returned, return the query, which means
        //the name is a duplicate
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise return false
        else{
            return false;
        }
    }

    /**
     * The function will take a genre name as input
     * and use that name to insert the genre name into 
     * the genres table in the database. Before inserting 
     * the data, the input data will be validated and the 
     * messages will be returned depending on if there was 
     * an error or if the name was inserted successfully. 
     */
    public function insertGenre($genreName){

        //validate the genre name using clean text function
        $genreName = $this->fm->clean_text($genreName); 

        //if the genre name is empty return an error
        if($genreName == ""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg;     
        }else{
            //call the check for duplicated function and pass the genre name 
            //to it to check if it is already used. it it is, return an eror
            if($this->checkForDuplicates($genreName)){
                $msg = '<p><label class="text-danger">Genre
                was already added to the system.</label></p>'; 
                return $msg; 
            }
            else{
                //perform an insert query on the genres table and insert the 
                //corresponding input to the table. pass the query to the prepare
                //function
                $stmt = $this->db->link->prepare("INSERT INTO genres(name)
                VALUES(?)"); 

                //pass the genre name to the execute function to pass to the values
                //in the query
                $stmt->execute([$genreName]); 

                //if the statement is successful, return a success message 
                if($stmt){
                    $msg = '<p><label class="text-success">Genre inserted successfully.</label></p>';
                    return $msg;   
                } 
                //otherwise, return an error
                else{
                    $msg = '<p><label class="text-danger">Genre was not inserted successfully.</label></p>';
                    return $msg;   
                }
            }
        }
    }

    /**
     * This function will perform a select query to return 
     * all of the rows in the genres table. If more than 0 rows
     * are returned, the query will be returned. Otherwise, false will
     * be returned
     */
    public function selectGenres(){

        //perform a select query on the genres table 
        //and pass the query to the query function
        $stmt = $this->db->link->query("SELECT * FROM genres"); 

        //if more than 0 rows are returned, that mean there are genres in the 
        //system and the statement will be returned
        if($stmt->rowCount() > 0){
            return $stmt;
        }
        //otherwise return false
        else{
            return false; 
        }
    }

    /**
     * This function will take a genre id as input
     * and and perform a deletino of the specific 
     * genre id from the genres table.  Before deleting,
     * some validations will occur.  If any error occurs,
     * an error will be returned.  Otherwise, a success 
     * message will be returned.
     */
    public function deleteGenreById($genreId){

        //vlean the text with the clean_text function
        $genreId = $this->fm->clean_text($genreId); 

        //perform a select query on the movies_genres table
        //where the genre id in the table is equal to the input genre id
        $query = $this->db->link->prepare("SELECT * FROM movies_genres
                                        WHERE genre_id = (?)"); 
        //pass the genre id to the execute function
        $query->execute([$genreId]); 

        //if more than 0 rows are returned, that mean the genre has movies
        //associated with it and an error will be returned
        if($query->rowCount() > 0){
            $msg = '<p><label class="text-danger">Genre cannot be deleted 
                since movies are in the Genre.</label></p>';
            return $msg;  
        } 
        else{
            //perform a delete query from the genres table where the id
            //is equal to the input genre id.  Pass to the prepare function
            $stmt = $this->db->link->prepare("DELETE FROM genres
                                            WHERE id=(?)");
            //pass the genre id to the execute function 
            $stmt->execute([$genreId]); 

            //if the statement is successful, return a success message
            if($stmt){
                $msg = '<p><label class="text-success">Genre deleted successfully.</label></p>';
                return $msg;  
            } 
            //otherwise, return an error message
            else{
                $msg = '<p><label class="text-danger">Genre deletion was unsuccessfully.</label></p>';
                return $msg;  
            }
        }
    }

    /**
     * This function will take a genre id as input
     * and select the the genre with the specific id 
     * from the genres table.  If more than row from the
     * query is returned, return the query to the user. 
     * Otherwoise, return faalse.  
     */
    public function selectGenreById($genreId){

        //pass the input to the clean text function to clean it
        $genreId = $this->fm->clean_text($genreId); 
        
        //perform a select query to return all columns where 
        //the id of the genre is equal to the input id.  Pass this 
        //to the prepare function
        $stmt = $this->db->link->prepare("SELECT * FROM genres
                                            WHERE id = (?)"); 
        //pass the input to the execute function to set the value to the input
        $stmt->execute([$genreId]); 

        //if more than 0 rows are returned, return the statement 
        if($stmt->rowCount() > 0){
            return $stmt;
        }
        //otherwise, return false. 
        else{
            return false; 
        }
    }

    /**
     * This function will take a genre id and genre name 
     * as input and will perform an update query on the 
     * genre with the specific id and set the name equal to
     * the input name.  Before updateing, input validation 
     * must be made and if an error occurs, the error will 
     * be displayed to the user.  Otherwise, the update query 
     * will be performed and if it is successful , a success 
     * message will be returned and if it fails, an error message
     * will be returned. 
     */
    public function updateGenreById($genreId, $genreName){

        //validate input using the clean text function in the fm class
        $genreId = $this->fm->clean_text($genreId); 
        $genre = $this->fm->clean_text($genreName); 

        //if the input is empty, return an errro
        if($genre == ""){
            $msg = '<p><label class="text-danger">Genre
            name field must not be empty.</label></p>'; 
            return $msg; 
        }else{
            //check for duplciated using the fucntion in the 
            //class and pass the genre to it. If there is one,
            //return the error
            if($this->checkForDuplicates($genre)){
                $msg = '<p><label class="text-danger">Genre
                was already added to the system.</label></p>'; 
                return $msg; 
            }
            else{
                //if input validated, perform an update query and 
                //set the genre name equal to the input genre name
                //where the id is equal to the input id.  Pass 
                //to the prepare statement
                $stmt = $this->db->link->prepare("UPDATE genres
                SET name = (?)
                WHERE id = (?)"); 
                //pass the input values to the execute function 
                $stmt->execute([$genre, $genreId]); 

                //if query is successful, return a success message
                if($stmt){
                    $msg = '<p><label class="text-success">Genre updated successfully.</label></p>';
                    return $msg;
                }
                //otherwise, return an error message
                else{
                    $msg = '<p><label class="text-danger">Genre failed to update.</label></p>';
                    return $msg;
                }
            }
        }
    }

    // public function selectGenreNameById($id){
    //     $genreId = $this->fm->clean_text($genreId); 

    //     $query = $this->db->link->prepare("SELECT name FROM genres
    //                                     WHERE id=(?)"); 

    //     $query->execute([$genreId]);

    //     if($query){
    //         return $query; 
    //     } else{
    //         return false;
    //     }
    // }
    
    /**
     * This function will take a unique movie id and 
     * a unique genre id and delete the specific movie 
     * with the specific genre from the movies_genres 
     * table so the movie no longer has the genre.  
     * If the query is successful, a success message will
     * be returned. Otherwise an error message will be returned.
     */
    public function deleteMovieGenre($movieId, $genreId){

        //validate the form input using the clean text function
        $movieId = $this->fm->clean_text($movieId); 
        $genreId = $this->fm->clean_text($genreId); 

        //perform a delete query on the movies_genres table 
        //where the movie_id and genre_id are equal to the input'
        //data and pass to the prepare function
        $query = $this->db->link->prepare("DELETE FROM movies_genres
                                        WHERE movie_id = (?)
                                        AND genre_id = (?)"); 

        //pass the movie id and genre id to the execute function to set the values
        $query->execute([$movieId, $genreId]); 

        //if the query is successful, return a success message
        if($query){
            $msg = '<p><label class="text-success">Movie deleted from genre successfully.</label></p>';
            return $msg; 
            //echo "<script>window.location = 'viewcategories.php';</script>";
        }
        //otherwise return an error message
        else{
            $msg = '<p><label class="text-danger">Movie failed to delete from the
            category.</label></p>';
            return $msg; 
        }
    }

    /**
     * This function will take a movie id and genre id as input
     * and insert this data to the movies_genres to give the movie 
     * this specific genre. Prior to performing the insertion, the 
     * movie id and genre id must not be already in the system.  If they
     * are, an error message will be returned and if any error occurs, an 
     * error message will be returned.  Otherwise, the genre will be inserted 
     * for the movie and a success message will be returned. 
     */
    public function insertMovieGenre($movieId, $genreId){

        //validate the form input using the clean_text function
        $movieId = $this->fm->clean_text($movieId); 
        $genreId = $this->fm->clean_text($genreId); 

        //if any of the input is empty, display an error message
        if($movieId == "" || $genreId == ""){
            $msg = '<p><label class="text-danger">A genre and movie must be selected.</label></p>';
            return $msg; 
        }

        //perform a select query on the movies_genres table where the 
        //movie id and genre id in the table is equal to the input 
        //fields. Pass this to the prepare function
        $query = $this->db->link->prepare("SELECT * FROM movies_genres
                                        WHERE movie_id = (?)
                                        AND genre_id = (?)"); 
        //pass the movie id and genre id to the execute function to set the values
        $query->execute([$movieId, $genreId]);
        
        //if more than 0 rows are returned from the query, the movie already has the 
        //genre so an error is returned
        if($query->rowCount() > 0){
            $msg = '<p><label class="text-danger">Movie already has this genre.</label></p>';
            return $msg; 
        } else{
            //perform an insert query to the movies_genres table with the 
            //input values of the function. pass the query to the prepare function
            $query = $this->db->link->prepare("INSERT INTO movies_genres(movie_id, genre_id)
                                            VALUES(?,?)"); 

            //pass the movie id and genre id to set the values in the query
            $query->execute([$movieId, $genreId]); 

            //if the query is successful return a success message
            if($query){
                $msg = '<p><label class="text-success">Movie genre was successfully inserted.</label></p>';
                return $msg; 
            } 
            //otherwise return an error message
            else{
                $msg = '<p><label class="text-danger">Movie genre failed to insert.</label></p>';
                return $msg; 
            }
        
        }
    }

    /**
     * This function will performs a select query on 
     * the movies_genres table to return movies with the
     * genre id equal to one.  This will allow the drama 
     * movies to be returned.  If the query is successful, 
     * and more than 0 rows are returned, the query will be returned/
     * Otherwise, false will be returned
     */
    public function selectDramaMovies(){
        //perform a select query on the movies_genres table
        //where the gene id in the table is equal to one. Also 
        //perform an inner join of the movies table based on matching
        //movie id's in the movies_genres table and the movies table.
        $query = $this->db->link->query("SELECT movies_genres.*, movies.image,
                                        movies.title, movies.summary, movies.rank
                                        FROM movies_genres
                                        INNER JOIN movies
                                        ON movies_genres.movie_id = movies.id
                                        WHERE movies_genres.genre_id = 1
                                        LIMIT 4");
        //if more than 0 rows are returned , return the query
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise return fasle
        else{
            return false;
        }
        
    }

    /**
     * This functino will select all movies 
     * that are of the genre action movies to
     * display on the screen.  To do this a selecction
     * query will be performed on the movies_genres table on
     * the condidtion that the genre id in the table is equal to
     * 3.  A limit of four rows will be returned. 
     */
    public function selectActionMovies(){
        //perform a select query on the movies_genres table with the condition
        //that the genre id in the movies_genres table is equal to 3.  Also 
        //perform an inner join of the movies table based on the unique movie
        //id matching in both tables.
        $query = $this->db->link->query("SELECT movies_genres.*, movies.image,
                                        movies.title, movies.summary, movies.rank
                                        FROM movies_genres
                                        INNER JOIN movies
                                        ON movies_genres.movie_id = movies.id
                                        WHERE movies_genres.genre_id = 3
                                        LIMIT 4");
        //if more than 0 rows are returned, return the query
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise, return false
        else{
            return false;
        }
        
    }

     /**
     * This function will take a movie id as input 
     * and perform a select query on the movies_genres 
     * table in the database based on the movie id in the 
     * movies_genres table that matches the input movie id.  
     * This query will return all the genres for a specific 
     * movie. If the query is returned with more than zero rows,
     * which mean that the movie has one or more genres, the query
     * will be returned. Otherwise false will be returned. 
     */
    public function selectGenresByMovieId($id){

        //clean the input data using the clean text function 
        $movieId = $this->fm->clean_text($id); 

        //pass a select query of the movies_genres table in the database
        //with the condition that the movie id in the table is equal to the 
        //input movie id.  Also perform an inner jon of the genres table 
        //based on the matching genre id's in both tables. pass this to the 
        //prepare function
        $query = $this->db->link->prepare("SELECT movies_genres.*, genres.name
                                        FROM movies_genres
                                        INNER JOIN genres
                                        ON movies_genres.genre_id = genres.id
                                        WHERE movies_genres.movie_id = (?)"); 

        //pass the input to the execute function to set the values
        $query->execute([$movieId]); 

        //if more than 0 rows are returned, return the query
        if($query->rowCount() > 0){
            return $query; 
        } 
        //otherwise return false.  
        else{
            return false;
        }    
    }
}

?>