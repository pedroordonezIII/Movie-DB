<?php 
 $filepath = realpath(dirname(__FILE__));
 //connect to the database
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 
?>


<?php

class Actor{

    //private attributes for the class
    private $db; 
    private $fm;
    
    //contsructor for the class that is called when 
    //instantiating a class object
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * This function will check for duplicate names when 
     * inserting an actor first name and last name. 
     * The function will take an actor first name and a
     * last name and check if those inputs are already in
     * the actors table to only allow one actor with the 
     * same name in the table. If more than one row is 
     * returned from the query, the query will be returned.
     * Otherwise, false will be returned.  
     */
    public function checkForDuplicates($firstName, $lastName){

        //validate form input by calling clean_tesxt in format class
        $firstName = $this->fm->clean_text($firstName);
        $lastName = $this->fm->clean_text($lastName);

        //pass the query to the prepare function which selects 
        //all the rows and columns from the actors table where 
        //the input first name and last name are equal to 
        //the firstname and last name in the actors table. 
        $query = $this->db->link->prepare("SELECT * FROM actors
                                        WHERE first_name = (?)
                                        AND last_name = (?)"); 
        
        //pass the form inputs the execute function that will be used 
        //to compare the values.
        $query->execute([$firstName, $lastName]); 

        //if more than 0 rows are returned , that means theres duplicated 
        //and the query must be returned 
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise, return false. 
        else{
            return false;
        }
    }

    /**
     * This function will take a post request as input 
     * and use the inputs from the post request to 
     * insert data into the actors table in the database.  
     * Before the data can be submitted, the form data is 
     * validated and if an error occurs, the error will 
     * be returned.  Otherwise, if the insert query is 
     * successfully inserted, a success message will be 
     * returned.  
     */
    public function insertActor($data){
        //clean the text input using the clean text function in the 
        //format class
        $first_name = $this->fm->clean_text($data["firstname"]);
        $last_name = $this->fm->clean_text($data["lastname"]);
        $gender = $this->fm->clean_text($data["gender"]); 

        //check if any of the input fields are empty and return an error if they are
        if($first_name == "" || $last_name == "" || $gender == ""){
            $msg = '<p><label class="text-danger">Please fill
            all fields.</label></p>'; 
            return $msg; 
        }
        //otherwise continue
        else{

            //check if the names used are duplictes by passing the form input to 
            //the checkForDuplicates function in this class.  return an error if there is
            if($this->checkForDuplicates($first_name, $last_name)){
                $msg = '<p><label class="text-danger">Actor
                was already added to the system.</label></p>'; 
                return $msg; 
            }
            //otherwise continue if no duplicated
            else{

                //pass an insert query to the perpare function and specify the column of the actors
                //table and the values as ?
                $query = $this->db->link->prepare("INSERT INTO actors(first_name, last_name, gender)
                                                VALUES(?,?,?)");

                //pass the input form valyes to the execute function to be used as values in the 
                //insert query
                $query->execute([$first_name, $last_name, $gender]); 

                //if the query is successful, return a success message
                if($query){
                    $msg = '<p><label class="text-success">Actor inserted
                    successfully.</label></p>'; 
                    return $msg; 
                }
                //otherwise, return an error message
                else{
                    $msg = '<p><label class="text-danger">Actor Failed
                    to be inserted.</label></p>'; 
                    return $msg; 
                }
            }
        }
    }

    /**
     * This function will select all the actors and rows 
     * of the actors column in the system.  If more than 
     * zero rows are returned from the query, return the 
     * query. Otherwise, return false. 
     */
    public function selectActors(){

        //pass the select query of the actors table to the 
        //query function.
        $query = $this->db->link->query("SELECT * FROM actors"); 

        //if more than zero rows are returned, return the query
        if($query->rowCount() > 0){
            return $query;
        } 
        //otherwise, return false
        else{
            return false;
        }
    }

    /**
     * Input: actor unique identdication key
     * Output: Error or success message regarding
     * if the actor could be deleted.
     * This function will delete an actor 
     * by their unique identification key. 
     * Prior to deletion, it must be proved 
     * that the actor does not have a role
     * by checking the actor in the roles 
     * table. if the actor does have a role, 
     * an error message will be displayed.  
     * Otherwise, the delete query will
     * be performed to delete the actor from the 
     * system and a message will be returned. 
     */
    public function deleteActorById($id){

        //clean actor id input
        $actorId = $this->fm->clean_text($id); 

        //pass a select query that select all rows and columns,
        //where the actor id in the roles table is equal to that 
        //of the input field
        $query = $this->db->link->prepare("SELECT * FROM roles
                                        WHERE actor_id = (?)"); 
        
        //pass the actor id to the execute function to pass it as a parameter to check with
        $query->execute([$actorId]); 

        //if more than zero rows are returned, the actor has a role so return error message
        if($query->rowCount() > 0){
            $msg = '<p><label class="text-danger">Actor cannot be deleted 
                since actor has movies associated with them.</label></p>';
            return $msg;  
        } 
        else{
            //if actor does not have a role, delete the actor from the actors table 
            //where the actor id is equal to the id in the actors table.  Pass query 
            //to the prepare function
            $query = $this->db->link->prepare("DELETE FROM actors 
                                          WHERE id = (?)"); 
            //pass the actor id to the execute function to pass it as inputs
            $query->execute([$actorId]); 

            //if the query is successful, return the success message
            if($query){
                $msg = '<p><label class="text-success">Actor deleted
                successfully.</label></p>'; 
                return $msg; 
            } 
            //otherwise return an error message
            else {
                $msg = '<p><label class="text-danger">Actor deletion
                failed.</label></p>'; 
                return $msg; 
            }
        }
    }

    /**
     * Input: actor unique identification
     * Output: query object or false.
     * This function will take an actors unique 
     * id as input and perform a select query on the 
     * actors table to return the row with the corresponding
     * actor id.  if more than zero rows are returned from the 
     * query, that mean the actor exists and the query is returned.
     * Otherwise, the actor does not exist and false is returned.  
     */
    public function selectActorById($id){

        //clean input by passing id to clean text function
        $actorId = $this->fm->clean_text($id); 

        //pass the query to the perpare function, which will be a select
        //query of the actors table with the condition that the actor id
        //in the system is equal to that of the input
        $selectQuery = $this->db->link->prepare("SELECT * FROM actors
                                                WHERE id = (?)"); 

        //pass the actor id to the execute function to pass it as a parameter. 
        $selectQuery->execute([$actorId]); 

        //if more than zero rows are returned
        //return the query
        if($selectQuery->rowCount() > 0){
            return $selectQuery;
        } 
        //otherwise, return false. 
        else{
            return false;
        }
    }

    /**
     * Input: actor first name, last name, gender and actors
     * unique identifciation
     * Output : Error message regarding form validationm or success 
     * message if the query is successful, or an error message 
     * if query fails.  
     * This function will take a firstname , lastname, gender and 
     * unique actor identification to update the actor with the corresponding 
     * id based on the form input names and gender.  Before updating, the 
     * form must be validated to not be empty and make sure that the names 
     * are not yet in the systeem.  If it is not either of those, the update 
     * query will be performed on the form input based o nthe actors unique 
     * input.  Once it is performed, it will return a success message if successful
     * and an error message if it is not.  
     */
    public function updateActorById($first_name, $last_name, $gender, $id){

        //clean the input by calling the clean text function 
        $first_name = $this->fm->clean_text($first_name);
        $last_name = $this->fm->clean_text($last_name);
        $gender = $this->fm->clean_text($gender);
        $actorId = $this->fm->clean_text($id);

        //check if the input is empty and if it is, return error
        if($first_name =="" || $last_name == "" ||
        $gender == "" || $actorId == ""){
                $msg = '<p><label class="text-danger">All fields must be filled.</label></p>'; 
                return $msg; 
        }
        else{

            //perform a select query on the ators table with the 
            //condition that the firstname and last name are equal
            //to the input from form and pass the query to the perpare function 
            $selectQuery = $this->db->link->prepare("SELECT * FROM actors
                                                    WHERE first_name = (?)
                                                    AND last_name = (?)"); 
            
            //pass the input to the execute function to pass those to the prepare
            $selectQuery->execute([$first_name, $last_name]); 

            //if more than 0 rows are returned return an error that the actor is in the system
            if($selectQuery->rowCount() > 0){
                $msg = '<p><label class="text-danger">Actor is already in the system.</label></p>'; 
                return $msg;
            } else{

                //otherwise, perform an update query and set the values in the 
                //actors table equal to the input values, with the condition that 
                //the actor has the corresponding actor id input and pass it to the 
                //prepare function 
                $updateQuery = $this->db->link->prepare("UPDATE actors
                                                        set first_name =(?), last_name = (?),
                                                        gender = (?)
                                                        WHERE id = (?)"); 
                
                //pass the input values to the execute function to pass them to the 
                //query passed to the prepare function
                $updateQuery->execute([$first_name, $last_name, $gender, $actorId]); 

                //if query is successful, return a success message
                if($updateQuery){
                    $msg = '<p><label class="text-success">Actor updated successfully.</label></p>'; 
                    return $msg;
                } 
                //otherwise, retun an error
                else{
                    $msg = '<p><label class="text-danger">Actor failed to update.</label></p>'; 
                    return $msg;
                }
            }
        }
    }

    /**
     * Input: movie unique identifcation, actor unique identifcation
     * and the role 
     * Output: message indicating whether there was an error or 
     * if the role was inserted successfully
     * This function will insert a role for a specific actor 
     * to a specific movie.  Prior to inserting , the form input
     * is validated for empty inputs.  Then it is validated to see 
     * if a role is already in place for the actor in the given movie.
     * If it is, return an error, otherwise, insert the movie, actor and role
     * into the roles table and return a message indicating whether or not
     * the query was successful. 
     */
    public function insertActorRole($movieId, $actorId, $role){

        //clean the input data by passing the data to the clean text function
        $movieId = $this->fm->clean_text($movieId);
        $actorId = $this->fm->clean_text($actorId);
        $role = $this->fm->clean_text($role);

        //if the role input is empty, return an error message to the user
        if($role == ""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>'; 
            return $msg;
        }
        else{

            //perform a selected query of the roles table where the 
            //movie id and actor id are equal to the input data and pass
            //it to the prepar function. 
            $checkActor = $this->db->link->prepare("SELECT * FROM roles
                                                WHERE movie_id = (?) AND
                                                actor_id = (?)"); 
            
            //pass the form inputs to the execute function to use as the values
            //to compare the data to. 
            $checkActor->execute([$movieId, $actorId]); 

            //if the row count returned is more than zero, it means the actor already 
            //has a role in the movie and an error is returned. 
            if($checkActor->rowCount() > 0){
                $msg = '<p><label class="text-danger">Actor already has a role
                in the movie.</label></p>'; 
                return $msg;
            }
            else{

                //otherwise, insert the values into the roles table by performing a
                //insert query on the roles table with the corresponding values and 
                //pass it to the prepare function
                $insertQuery = $this->db->link->prepare("INSERT INTO roles(movie_id, actor_id, role)
                                                      VALUES(?,?,?)"); 
               //pass inputs to the execute function
               $insertQuery->execute([$movieId, $actorId, $role]);

               //if the query is successful, return success message
                if($insertQuery){
                    $msg = '<p><label class="text-success">Actor role was inserted successfully.</label></p>'; 
                    return $msg;
                }
                //otherwise return an error
                else{
                    $msg = '<p><label class="text-danger">Actor role failed to insert.</label></p>'; 
                    return $msg; 
                }
            }
        }
    }

    /**
     * INput: Actor unique identification
     * Output: reference to the query 
     * or false.
     * This function will select all the 
     * roles that the actor plays for in
     *  movies for an actor with a unqiue 
     * identifcation and return the query 
     * result or false.  
     */
    public function selectActorMovies($id){

        //clean the user input, using the clean text function
        $actorId = $this->fm->clean_text($id);

        //perform a select query of the roles table and specify the columns
        //to return for the movies table since an inner join will be performed on it
        //based on the movie id in the roles table matching the one in the movies table 
        //the rows that will be returned will be those with the corresponding actor id 
        //in the roles table that equals the input actor id.  Order in descending order
        //based on the movie rank
        $query = $this->db->link->prepare("SELECT roles.*, movies.title, movies.image,
                                        movies.rating, movies.rank
                                        FROM roles
                                        INNER JOIN movies
                                        ON roles.movie_id = movies.id
                                        WHERE roles.actor_id = (?)
                                        ORDER BY movies.rank DESC");
        
        //pass value to exxecute function 
        $query->execute([$actorId]); 

        //if more than 0 rows are returned, the actor has roles for a specific movie
        //and the query is returned
        if($query->rowCount() > 0){
            return $query; 
        }
        //otherwsie return false.  
        else{
            return false;
        }
    }

    /**
     * INput: unique movie id, unique actor id
     * Output: Message stating whether the query 
     * was successful or not
     * This function will delete the actor role 
     * from the specific movie by performing a 
     * delete query based on the input data.
     * If it is successful, the success message 
     * will be returned, otherwise false is returned
     */
    public function deleteActorRole($movieId, $actorId){

        //clean the input data using clean text fucntion
        $movieId = $this->fm->clean_text($movieId); 
        $actorId = $this->fm->clean_text($actorId); 

        //perform delete query to delete actor role from the roles
        //table where the movie id and actor id in the roles table
        //match the input data. Pass this query to the prepare function
        $query = $this->db->link->prepare("DELETE FROM roles
                                        WHERE movie_id = (?)
                                        AND actor_id = (?)"); 

        //pass the form input data ato the execute function
        $query->execute([$movieId, $actorId]); 

        //if the query is successful, return a success message
        if($query){
            $msg = '<p><label class="text-success">Actor role successfully deleted.</label></p>';
            return $msg; 
            //echo "<script>window.location = 'viewcategories.php';</script>";
        }
        //otherwise, return an error message
        else{
            $msg = '<p><label class="text-danger">Actor role failed to be deleted.</label></p>';
            return $msg; 
        }
    }

    /**
     * Input: unique actor identfication and 
     * unique movie identfication
     * Output: reference to the query or false
     * This funtion will perform a select query on the roles 
     * table where the actor id and movie id fields in the roles
     * table equal to those from the input.  This will allow 
     * all the actor roles for the specific actor to be returned
     * for the specific movie. 
     */
    public function selectActorRole($actorId, $movieId){

        //clean the user input using the clean text function in format class
        $actorId = $this->fm->clean_text($actorId);
        $movieId = $this->fm->clean_text($movieId);

        //perform a select query from the roles table where the 
        //actor id and movie id in the roles table equal the input
        //data and pass to the prepare function.
        $query = $this->db->link->prepare("SELECT * FROM roles
                                        WHERE actor_id = (?)
                                        AND movie_id = (?)");
        
        //pass the actor id and movie id to the execute function
        $query->execute([$actorId, $movieId]); 

        //if more than 0 rows are returned, return the query, which 
        //means that the actor does have a role in the movie
        if($query->rowCount() > 0){
            return $query; 
        }
        //otherwise, return false. 
        else{
            return false;
        }
    }

    /**
     * Input: unique actor identifcation
     * and unique movie identification
     * Return: reference to query or false
     * This function will perform a query that 
     * selected all the rows from the roles 
     * table where the actor id and movie id
     * equal to the input data.  Additionally, 
     * the query will allow access to the movie 
     * tite by performing an inner join of the movies table
     * based on the movie id in the roles matching the one 
     * in the movies table and allow access to the first name 
     * and last name of the actor by performing an inner join
     * of the actors table where the role actor id column is equal to 
     * the actor id in the actors table.  
     */
    public function selectActorMovieRole($actorId, $movieId){
        //clean the input fields using clean text function in format class
        $actorId = $this->fm->clean_text($actorId);
        $movieId = $this->fm->clean_text($movieId);

        //perform a select query on the roles table where the roles actor 
        //id and the roles movie id is equal to the input data.  Perform 
        //an inner join of the movies table based on the roles movie id 
        //equaling the movies id and an inner join of the actors table 
        //on the roles actor id equalling the actor id. Pass the query to 
        //the prepare function
        $query = $this->db->link->prepare("SELECT roles.*, movies.title, 
                                        actors.first_name, actors.last_name
                                        FROM roles
                                        INNER JOIN movies
                                        ON roles.movie_id = movies.id
                                        INNER JOIN actors
                                        ON roles.actor_id = actors.id
                                        WHERE roles.actor_id = (?)
                                        AND roles.movie_id = (?)"); 

        //pass the input values to the execute function to be used above.
        $query->execute([$actorId, $movieId]); 

        //if more than zero rows are returned the actor has a role for the specific movie
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise return false
        else{
            return false;
        }
    }

    /**
     * input: a role string, a unique actor id, and a unique
     * movie id.
     * Return : Error message if an error occurs , or a success
     * message if the query is successful
     * This function will take a role, actor id, and movie id as input
     * and update the role based on the input actor id and movie id.  
     * If the update query is successful, an error is returned.  Otherwise, 
     * there will be an error return if the input field is empty or if the 
     * query is not successful.  
     */
    public function updateActorRoleById($role, $actorId, $movieId){

        //clean the input text using the clean text function
        $role = $this->fm->clean_text($role);
        $actorId = $this->fm->clean_text($actorId);
        $movieId = $this->fm->clean_text($movieId);

        //if the role field is empty, return an error message
        if($role ==""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg; 
        }
        else{   
            //otherwise, perform a query to upate the roles and set the 
            //role value in the roles table equal to the input role 
            //with the condition that the actor id and movie id are 
            //equal to the input stuff
            $query = $this->db->link->prepare("UPDATE roles
                                            SET role = (?)
                                            WHERE actor_id = (?)
                                            AND movie_id = (?)"); 
            
            //pass the role, actor id , and movie id to pass as inputs
            $query->execute([$role, $actorId, $movieId]); 

            //if the query is successful, return a success message
            if($query){
                $msg = '<p><label class="text-success">Actor role updated successfully.</label></p>';
                return $msg; 
            }
            //otherwise return an error
            else{
                $msg = '<p><label class="text-danger">Actor role failed to update.</label></p>';
                return $msg; 
            }
        }

    }
}

?>