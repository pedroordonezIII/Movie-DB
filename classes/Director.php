<?php 
 $filepath = realpath(dirname(__FILE__));
 //connect to the database
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 
?>


<?php 

class Director{

    //private class attributes
    private $db;
    private $fm;

    //instantiate the clss constructor which is called 
    //when an instance of a class is made
    public function __construct(){

        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * This function will take a firstname and a lastname 
     * as inputs and check if the inputs are already in the 
     * directors table in the database.  If already in the database,
     * the query object will be returned.  Otherwise, false will 
     * be returned.  
     */
    public function checkForDuplicates($firstName, $lastName){

        //clean the form inputs using the clean text function
        $firstName = $this->fm->clean_text($firstName);
        $lastName = $this->fm->clean_text($lastName);

        //perform a select query where the first name and last 
        //name columns in the table are equal to the input values
        //and pass this to the prepare function
        $query = $this->db->link->prepare("SELECT * FROM directors
                                        WHERE first_name = (?)
                                        AND last_name = (?)"); 
        
        //pass the firstname and last name values to the execute fucntion
        //to set the query values
        $query->execute([$firstName, $lastName]); 

        //if more than 0 rows are returned return the query
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise return false.
        else{
            return false;
        }
    }

    /**
     * This function will take post data as input
     * related to the director such as the first name 
     * and lasst name and insert that data into the 
     * directors table in the database. Prior to inserting, 
     * the input will be validated and if an error occurs, 
     * the error will be returned. Otherwise, the insert query 
     * will be performed and a success message will be returned. 
     */
    public function insertDirector($data){

        //validate the form input using the clean_text function
        //in the format class
        $firstname = $this->fm->clean_text($data["firstname"]); 
        $lastname = $this->fm->clean_text($data["lastname"]); 

        //if either input field is empty, return an error
        if($firstname == "" || $lastname == ""){
            $msg = '<p><label class="text-danger">Please fill
            all fields.</label></p>'; 
            return $msg; 
        }
        else{

            //check if the name is already in the system by using the 
            //checkforduplicates function in the class and pass the input values
            //if there are duplicates, return an error messsage
            if($this->checkForDuplicates($firstname, $lastname)){
                $msg = '<p><label class="text-danger">Director
                was already added to the system.</label></p>'; 
                return $msg; 
            } else{
                //otherwise perform an insert query to the directors table 
                //with the corresponding user input as values and pass to the prepare function
                $query = $this->db->link->prepare("INSERT INTO directors(first_name, last_name)
                VALUES(?,?)");

                //pass the firstname and lastname input values to the execute 
                //function to set them as the query values
                $query->execute([$firstname, $lastname]); 

                //if the query is successful, return a success message
                if($query){
                    $msg = '<p><label class="text-success">Director inserted
                    successfully.</label></p>'; 
                    return $msg; 
                }
                //otherwise, return an error message
                else{
                    $msg = '<p><label class="text-danger">Director Failed
                    to be inserted.</label></p>'; 
                    return $msg; 
                }
            }
        }
    }

     /**
     * This function will select all the directors from the 
     * system and return the query if more than 0 rows are 
     * returned with the query. Otherwise, false is returned.  
     */
    public function selectDirectors(){

        //perform a select query on the directors table
        //and pass the query to the query function
        $query = $this->db->link->query("SELECT * FROM directors"); 

        //if the row count is more than 0, return the query
        if($query->rowCount() > 0){
            return $query;
        } 
        //otherwise, return false.
        else{
            return false;
        }
    }

    /**
     * This function will take a director id as input 
     * and make sure the director does not have movies 
     * associated with them prior to deletion. If the director 
     * does have movies associate with them, an error message will
     * be displayed.  Otherwise, the director with the specific id 
     * will be deleted from the directos table and a success message 
     * will be returned. If the query was not successful an error 
     * message will be returned
     */
    public function deleteDirectorById($id){

        //clean the input value using the clean_text function
        $directorId = $this->fm->clean_text($id); 

        //perform a select query on the movies_directors table where the 
        //director id in the table is equal to the input director id to the 
        //function. Pass the to prepare function
        $query = $this->db->link->prepare("SELECT * FROM movies_directors
                                        WHERE director_id = (?)"); 
        
        //pass the director id input to the execute function to set the 
        //values in the query
        $query->execute([$directorId]); 

        //if more than one row is returned, the director has movies associated 
        //with them and a message will be displayed 
        if($query->rowCount() > 0){
            $msg = '<p><label class="text-danger">Director cannot be deleted 
                since the director has movies associated with them.</label></p>';
            return $msg;  
        } 
        else{
            //otherwise, a delete query will be done on the directors table
            //where the id is equal to the input of the function. passs to the 
            //prepare function
            $query = $this->db->link->prepare("DELETE FROM directors 
                                            WHERE id = (?)"); 
            //passs the director id to the execute function 
            //to set the values in the query
            $query->execute([$directorId]); 

            //if the query is successful, return a success message 
            if($query){
                $msg = '<p><label class="text-success">Director deleted
                successfully.</label></p>'; 
                return $msg; 
            } 
            //otherwise return an error
            else {
                $msg = '<p><label class="text-danger">Director deletion
                failed.</label></p>'; 
                return $msg; 
            }
        }
    }

    /**
     * This function will take a director id as input
     * and use the director id to select the specific 
     * director with the specific id from the directors 
     * table in the databse.  If more than 0 rows are returned,
     * the query reference will be returned. Otherwise, false 
     * will be returned. 
     */
    public function selectDirectorById($id){

        //pass the input to the clean_text function to clean it
        $directorId = $this->fm->clean_text($id); 

        //perform a select query from the directors table where the
        //id is equal to the input id. Pass to the prepare function
        $selectQuery = $this->db->link->prepare("SELECT * FROM directors
                                                WHERE id = (?)"); 

        //pass the director id input to the execute function
        $selectQuery->execute([$directorId]); 

        //if more than 0 rows are returned from the query, return the query
        if($selectQuery->rowCount() > 0){
            return $selectQuery;
        } 
        //otherwise, return false
        else{
            return false;
        }
    }

    /**
     * This function will take three input paramters. It will 
     * take one corresponding to the firstname, one to the lastname, 
     * and one to the directors unique id, and will use that data to 
     * update the corresponding directors information.  Prior to updating,
     * the input data will be validated and if any error occurs, an error 
     * message will be displayed. Otherwise, the update query will be performed
     * and a success message wil be returned if it is successful
     */
    public function updateDirectorById($first_name, $last_name, $id){

        //clean form input using the clean _ text function and 
        //passing it some input values
        $first_name = $this->fm->clean_text($first_name);
        $last_name = $this->fm->clean_text($last_name);
        $directorId = $this->fm->clean_text($id);

        //if any of the input fields are empty , return an error
        if($first_name =="" || $last_name == "" ||
         $directorId == ""){
                $msg = '<p><label class="text-danger">All fields must be filled.</label></p>'; 
                return $msg; 
        }
        else{

            //perform a select query from directors where the 
            //firstname and lastname columns in the table equal 
            //the input data and pass to the prepare function
            $selectQuery = $this->db->link->prepare("SELECT * FROM directors
                                                    WHERE first_name = (?)
                                                    AND last_name = (?)"); 
            
            //pass the data from the input to the execute function
            $selectQuery->execute([$first_name, $last_name]); 

            //if more than zero rows are returned, that means there is already
            //a director with this name and an error will be returned
            if($selectQuery->rowCount() > 0){
                $msg = '<p><label class="text-danger">Director is already in the system.</label></p>'; 
                return $msg;
            } else{
                //Perform an update query on directors and set the name values
                //equal to the input values where the id is also equal to the 
                //director input id provided.
                $updateQuery = $this->db->link->prepare("UPDATE directors
                                                        set first_name =(?), last_name = (?)
                                                        WHERE id = (?)"); 

                //pass the input values to the execute function to set the values
                $updateQuery->execute([$first_name, $last_name, $directorId]); 

                //if it is successful, return a success message
                if($updateQuery){
                    $msg = '<p><label class="text-success">Director updated successfully.</label></p>'; 
                    return $msg;
                } 
                //otherwise, return an error
                else{
                    $msg = '<p><label class="text-danger">Director failed to update.</label></p>'; 
                    return $msg;
                }
            }
        }
    }

     /**
     * This function will take a director id 
     * as input and select the movies associated 
     * with a director from the database. If more than
     * 0 rows are returned from the query, the query 
     * will be returned.  Otherwise, flase will be 
     * returned
     */
    public function selectDirectorMovies($id){

        //clean the input text using the clean_text functoin
        $directorId = $this->fm->clean_text($id);

        /*
        Perform a select query on the movies_directors table with the condition
        that the director id field in the movies_directors table is equal to the 
        input id of the function.  Also perform an inner join of the movies table 
        based on the movie id in the movies_directors table equalling that of the 
        the movies table. Also order in descending order by the movie rank.
         Pass to the prepare function
        */
        $query = $this->db->link->prepare("SELECT movies_directors.*, movies.title, movies.image,
                                        movies.rating, movies.rank
                                        FROM movies_directors
                                        INNER JOIN movies
                                        ON movies_directors.movie_id = movies.id
                                        WHERE movies_directors.director_id = (?)
                                        ORDER BY movies.rank DESC");
        
        //pass the director id to the execute function to pass the value to the
        //query
        $query->execute([$directorId]); 

        //if more than 0 rows are returned, return the query, which means 
        //the director has one or movies associated with them
        if($query->rowCount() > 0){
            return $query; 
        }
        //otherwise, return false. 
        else{
            return false;
        }
    }

    /**
     * This function will take a movie id and director id 
     * as input and delete the dirctor and movie id association
     * from the database.  if the query is successful, a success 
     * message will be returned. Otherwise, an error message will be returned
     */
    public function deleteDirectorMovie($movieId, $directorId){

        //clean the input data using the clean_text function and pass 
        //the input data to it
        $movieId = $this->fm->clean_text($movieId); 
        $directorId = $this->fm->clean_text($directorId); 

        //perform a delete query on the movies_directors table 
        //where the movie_id and director id columns in the table
        //are equal to the input data.  Pass to the prepare function
        $query = $this->db->link->prepare("DELETE FROM movies_directors
                                        WHERE movie_id = (?)
                                        AND director_id = (?)"); 

        //pass the movieid and director id values to the execute function
        //to set the values in the query
        $query->execute([$movieId, $directorId]); 

        //if the query is successful, return a success message 
        if($query){
            $msg = '<p><label class="text-success">Movie is no longer associated with this 
            director.</label></p>';
            return $msg; 
            //echo "<script>window.location = 'viewcategories.php';</script>";
        }
        //otherwise , return an error message
        else{
            $msg = '<p><label class="text-danger">Movie deletion from the director failed.</label></p>';
            return $msg; 
        }
    }

    /**
     * This function will take a movie id as input and 
     * a director id as input and make a movie have a speicifc 
     * director. For that reason, an insert query will be done
     * that inserts the input data to the movies_directors table 
     * and associates the movies with a director.  If successfully 
     * inserted, a success message will be returned.  Otherwise, if the 
     * data does not pass validation or the query fails, an error message 
     * will be returned. 
     */
    public function insertMovieDirector($movieId, $directorId){

        //clean the input data by passing data to the clean_text function
        $movieId = $this->fm->clean_text($movieId);
        $directorId = $this->fm->clean_text($directorId);

        //if any of the input fields are empty, an error message will be displayed
        if($movieId == "" || $directorId ==""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>'; 
            return $msg;
        }
        else{
            //perform a select query on the movies_directors table on the condition
            //that the movie id is equal to the input movie id.  Pass to prepare function
            $checkDirector = $this->db->link->prepare("SELECT * FROM movies_directors
                                                WHERE movie_id = (?)"); 
            
            //pass the movieid to the execute function to set the value in the query
            $checkDirector->execute([$movieId]); 

            //if more than 0 rows are returned by the query, which mean that the movie already
            //has a director, return an error
            if($checkDirector->rowCount() > 0){
                $msg = '<p><label class="text-danger">The movie already has
                a director.</label></p>'; 
                return $msg;
            }
            else{
                //otherwise perform an insert query to the movies_directors table in the database
                //and set the values to the input values of the function
                $insertQuery = $this->db->link->prepare("INSERT INTO movies_directors(movie_id, director_id)
                                                        VALUES(?,?)"); 
                //pass the values to the execute to set the values in the query
                $insertQuery->execute([$movieId, $directorId]);

                //if the query was successful, return a success message 
                if($insertQuery){
                    $msg = '<p><label class="text-success">Movie director has successfully been inserted.</label></p>'; 
                    return $msg;
                }
                //otherwise, return an error. 
                else{
                    $msg = '<p><label class="text-danger">Movie director insertion failed.</label></p>'; 
                    return $msg; 
                }
            }
        }
    }
}

?>