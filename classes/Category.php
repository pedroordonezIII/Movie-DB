<?php 
 $filepath = realpath(dirname(__FILE__));
 //connect to the database
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 
?>

<?php

class Category{

    //instantiate the private class attributes
    public $db;
    public $fm;

    //create the constructor which is called everytime the 
    //the class is instantiated.
    public function __construct(){
        $this->db = new Database(); 
        $this->fm = new Format();
    }

    /**
     * This function take a category name as input
     * and use that category name to check if the 
     * category name is already in the system.  
     * Performing a select query and comparing the 
     * name to all of the name fields in the 
     * categories table, and checking to see 
     * if any rows are returned will allow 
     * the function to check for duplicates.
     * If there are duplicated, the query will be returned,
     * otherwise false will be returned.
     */
    public function checkForDuplicates($catName){

        //clean the input text using the clean_text function in fm
        //object class
        $categoryName = $this->fm->clean_text($catName);

        //perform a select query to return all the rows and columns
        //where the name is the input text. Use db object class and link
        //the databse and pass the query to prepare
        $query = $this->db->link->prepare("SELECT * FROM categories
                                        WHERE name = (?)"); 
        
        //pass the use input to the execute function
        $query->execute([$categoryName]); 

        //check if the row count is greater than 0 
        //if it is, return the query
        if($query->rowCount() > 0){
            return $query;
        }
        else{
            //return false if no rows are returned
            return false;
        }
    }

    /**
     * This function will take a category name as input and 
     * and insert the category into the categories table in the
     * databse.  Before inserting, the user input must be validated.
     * If the input is empty, and error message will be returned. 
     * If not empty, the category will be passed to the check duplicated
     * function to check if the name is already in the system.  If it 
     * is a duplicate, an error message will be returned. Otherwise, 
     * the category name will be inserted into the categories table and a message 
     * will be returned.  
     */
    public function insertCategory($catName){

        //clean the text input using the clean text function.
        $category = $this->fm->clean_text($catName); 

        //check if the user input is empty and return error 
        //message if it 
        if($category == ""){
            $msg = '<p><label class="text-danger">Please fill
            all fields.</label></p>'; 
            return $msg; 
        }
        else{

            //the category name will be passed to the checkforduplicateds function 
            //and if rows are returned, an error message will be returned
            if($this->checkForDuplicates($category)){
                $msg = '<p><label class="text-danger">Category
                was already added to the system.</label></p>'; 
                return $msg; 
            }
            //use the db databse class and the link variable and pass the query to 
            //the prepare function since user oinput will be passed to it.
            else{
                $stmt = $this->db->link->prepare("INSERT INTO categories(name)
                                                VALUES(?)"); 
            //run the execute function on the returned query and pass the user input
            $stmt->execute([$catName]); 

            //if the statmenet is successful, return a success message
            if($stmt){
                $msg = '<p><label class="text-success">Category inserted successfully.</label></p>';
                return $msg;  
            }
            //otherwise, return an error message. 
            else{
                $msg = '<p><label class="text-danger">Category insertion failed.</label></p>';
                return $msg;  
            }
            }
        }
    }

    /**
     * This function will select all of the rows and columns from the 
     * categories table in the database.  
     */
    public function selectCategories(){

        //pass the query to the query function which is called
        //by the link variable wich holds the databse connection
        $stmt = $this->db->link->query("SELECT * FROM categories"); 

        //if more than zero rows are return, return the query
        if($stmt->rowCount() > 0){
            return $stmt;
        }   
        //otherwise return false. 
        else{
            return false; 
        }
    }

    /**
     * This function will take a category identfication as input 
     * .Before deleting the category from the database, a select 
     * query is done to the movies_categories table to make sure 
     * that no movies have the current category to delete in the databse.  
     * If a movie in the system has the category, which will be proved by comparing the
     * category id to the rows in the movies_categories table in the databse, 
     * an error message will be returned. Otherwise , the category with the specific
     * identification will be deleted from the database.  Once category has been 
     * delted, a success message will be returned. If an error occurs, an error 
     * message will be return.  
     */
    public function deleteCategory($catId){

        //set the categoryId variable equal to the 
        //category id passed to the clean text function
        //in the fm class object.  
        $categoryId = $this->fm->clean_text($catId); 

        //pass a select query to the prepare function to return all the 
        //rows and columns from the movies categories table in the database where
        // the category id in the movie categories table is equal to the input
        //category id. Set the return value equal to query variable.  
        $query = $this->db->link->prepare("SELECT * FROM movies_categories
                                        WHERE category_id = (?)"); 
        
        //pass the category id to the execute function to safely handle user 
        //input
        $query->execute([$categoryId]); 

        //if the returned select query has more than 0 row, and error message
        //will be displayed telling the user that the category cannot be deleted
        //beause movies have that category.
        if($query->rowCount() > 0){
            $msg = '<p><label class="text-danger">Category cannot be deleted 
                since movies are in the category.</label></p>';
            return $msg;  
        } 
        //otherwise, perform the deletion
        else{
            //using the link variable in the database class object to 
            //connect to the database, call the prepare function in it 
            //and pass a delete query that deleted the category from the
            //categories table based on the unique identifcation
            $stmt = $this->db->link->prepare("DELETE FROM categories
                                            WHERE id = (?)"); 

            //call the execute function and pass the input category id
            //to delete the category with specified category id
            $stmt->execute([$categoryId]);

            
            //if the query is successful, return a success message
            if($stmt){
                $msg = '<p><label class="text-success">Category deleted successfully.</label></p>';
                return $msg;  
            }
            //if the query is not successful, return an error message 
            else{
                $msg = '<p><label class="text-danger">Category was not inserted successfully.</label></p>';
                return $msg;  
            }
        }
    }

    /**
     * This method will take a categories unique identification
     * and select the category with the with the category id that 
     * was passed to the function from the categories table.  Since
     * each category only has one unique id, only one category will be 
     * returned from the query.  Once the query is executed, the row
     * count is checked and if there is more than zero rows returned, 
     * the query object reference will be returned.  Otherwise, false 
     * will be returned.  
     */
    public function selectCategoryById($catId){
        
        //pass the category id to the clean text function
        $categoryId = $this->fm->clean_text($catId); 

        //by calling the link variable in the db class 
        //and calling the prepare function from the 
        //databse connection, pass the query to the that 
        //prepare function. The select query will select
        //all the rows from the categories database based on the 
        //unique category id passed to the function.
        $stmt = $this->db->link->prepare("SELECT * FROM categories
                                        WHERE id = (?)"); 
        //call the execute function and pass category id
        //to successfully input the id to the query.
        $stmt->execute([$categoryId]); 

        //if more than zero rows are returned, that means the category
        //exists and has been returned
        if($stmt->rowCount() > 0){
            return $stmt; 
        }
        //otherwise, false will be returned to show that no category was 
        //returned.
        else{
            return false; 
        }

    }
    
    /**
     * This function will take a category id and a category 
     * name as input and will update the category name of 
     * the category based on that specific categories id
     * in the categories table in the movie databse.  Before
     * updating the category name, the function will check 
     * if the caregory name the user submitted is null and if
     * it is, an error message will be returned to the user.
     * Otherwise, the check for duplicated function will be 
     * called in this class and if the query is returned, 
     * an error message will be displayed to the user 
     * telling them that the category is already in the system.
     * If the category is not a duplicate, the category name 
     * will be updated based on the category id passed to the 
     * function. 
     */
    public function upateCategoryById($catId, $catName){

        //clean the user input using the clean text function
        //in the fm class object
        $categoryId = $this->fm->clean_text($catId); 
        $category= $this->fm->clean_text($catName); 

        //check if the input is empty and return an error 
        //message if it is. 
        if($category == ""){
            $msg = '<p><label class="text-danger">Please fill
            all fields.</label></p>'; 
            return $msg; 
        }
        else{

            //call the check for duplicated function in this class
            //to check for duplicate names, and if there is a duplicate,
            //return an error message
            if($this->checkForDuplicates($category)){
                $msg = '<p><label class="text-danger">Category
                was already added to the system.</label></p>'; 
                return $msg; 
            }
            else{  
                //if this pooint is reached, the name is not a duplicate 
                //and the input is not empty.
                //perform an update query by passing the query to the 
                //prepare function in the databse object link variable. 
                //specifying the name and where condition related to the id 
                $stmt = $this->db->link->prepare("UPDATE categories
                SET name=(?)
                WHERE id=(?)");

                //pass the user inputs to the execute function corresponding
                //to the correct position. 
                $stmt->execute([$category, $categoryId]); 

                //if the statement is successful and returned, return a success message
                if($stmt){
                    $msg = '<p><label class="text-success">Category updated successfully.</label></p>';
                    return $msg;  
                }
                //otherwise return an error message that the category was not updateds
                else{
                    $msg = '<p><label class="text-danger">Category was not updated successfully.</label></p>';
                    return $msg;  
                }
            }
        }
    }

    /**
     * This function will take a movie id as input and also a category 
     * id as input and insert the specified movie to the specific category 
     * with the corresponding category id in the database.  Before inserting
     * into the movies_categories table in the database, the category and id
     * inputs will be checked to make sure they are selected and return an 
     * error message if they empty.  Otherwise, the function will perform 
     * a select query from the movies_categories table with the condition 
     * that the movie id and category id are equal to the input movie id 
     * and category id.  If more than 0 rows are returned, an error message
     * will be displayed telling the user that the movie already has the 
     * category.  If 0 rows are returned, the movie id and category id will
     * be inserted into the movies_categories table in the database, giving
     * the movie the category.  If insert is successful, a success message will 
     * be returned, otherwise an error message will be returned.  
     */
    public function insertMovieCategory($movieId, $categoryId){

        //clean the user input using the clean text function in the 
        //fm class
        $movieId = $this->fm->clean_text($movieId); 
        $categoryId = $this->fm->clean_text($categoryId); 

        //if the movie id or category id are empty, an error message will be
        //displayed to the user.  
        if($movieId == "" || $categoryId == ""){
            $msg = '<p><label class="text-danger">A category and movie must be selected.</label></p>';
            return $msg; 
        }
        else{
            //a select query will be passed to the prepare function from the 
            //movies categories table based on the movie id and category id
            //from the movies_categories table.  Use the db object instantiation
            $query = $this->db->link->prepare("SELECT * FROM movies_categories
                                            WHERE movie_id = (?)
                                            AND category_id = (?)"); 
            
            //pass the movie and category id to the execute function
            $query->execute([$movieId, $categoryId]);
            

            //if more than zero rows are returned, return an error messages
            if($query->rowCount() > 0){
                $msg = '<p><label class="text-danger">Movie already has this category.</label></p>';
                return $msg; 
            } else{
                //Otherwise, pass an insert query that inserts a movie id and category id to the 
                //movies_categories table with the corresponding values
                $query = $this->db->link->prepare("INSERT INTO movies_categories(movie_id, category_id)
                                                VALUES(?,?)"); 

                //pass the movie id and category id to the execute functions
                $query->execute([$movieId, $categoryId]); 

                //if the query is successful, return a success message
                if($query){
                    $msg = '<p><label class="text-success">Movie category was successfully inserted.</label></p>';
                    return $msg; 
                } 
                //otherwise, return an error message to the user.
                else{
                    $msg = '<p><label class="text-danger">Movie category failed to insert.</label></p>';
                    return $msg; 
                }
            }
        }
    }

    /**
     * This function will take a movie id and category id as input 
     * and delete the movie with the specific id from the category 
     * with the specific id.  A delete query will be performed to 
     * delete the movie id and category id from the movies_categories
     * table.  If the query is successful, a success message will be returned.
     * Otherwise, an error message will be returned.  
     */
    public function deleteMovieCategory($movieId, $categoryId){

        //using the clean_text function, clean the user inputs
        $movieId = $this->fm->clean_text($movieId); 
        $categoryId = $this->fm->clean_text($categoryId); 

        //pass a delete query to the prepare function that deletes 
        //the specific movie and category id's from the movies_categories
        //table from the movies_categories table in the database.  
        $query = $this->db->link->prepare("DELETE FROM movies_categories
                                        WHERE movie_id = (?)
                                        AND category_id = (?)"); 

        //pass the user inputs to the execute function including 
        //the movie id and category id's
        $query->execute([$movieId, $categoryId]); 

        //if the query is successful, return a success message
        if($query){
            $msg = '<p><label class="text-success">Movie deleted from category successfully.</label></p>';
            return $msg; 
            //echo "<script>window.location = 'viewcategories.php';</script>";
        }
        //otherwise, return an error message.
        else{
            $msg = '<p><label class="text-danger">Movie failed to delete from the
            category.</label></p>';
            return $msg; 
        }
    }

    /**
     * This function will select movies from the database
     * with the category of top rated which have a category
     * id of 1.  In addition , the query will join the movies 
     * table based on the matching movie id's in both the movies_categories
     * table and the movies table.  If more than zero rows are returned, 
     * which means that there are movies of this category, the query is 
     * returned.  Otherwise, false is returned.  
     */
    public function selectTopRatedMovies(){

        //perform a select query on the movies_Categories table with the condition
        //the the category id in the movies_categories table is equal to one for 
        //top rated movies.  Additionally, perform an inner join of the movies 
        //table where both tables have matching unique movie id's. Pass this 
        //query to the query function
        $query = $this->db->link->query("SELECT movies_categories.*, movies.image,
                                        movies.title, movies.summary
                                        FROM movies_categories
                                        INNER JOIN movies
                                        ON movies_categories.movie_id = movies.id
                                        WHERE movies_categories.category_id = 1
                                      LIMIT 4");
        //if more than zero rows are returned, which means there are movies
        //of this category in the databse, the query is returned
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise, false is returned
        else{
            return false;
        }
        
    }

    /**
     * This function will select movies by the category
     * related to the most popular movies.  To do this, 
     * items will be selected from the movies_categories 
     * table from the databse with the corresponding category 
     * id in the movies_categories table equaling two. The query will
     * then be checked to see if it returned more than 0 rows and it id did,
     * the query is returned.  Otherwise, return false. 
     */
    public function selectMostPopularMovies(){

        //perform a select query on the movies_categories table
        //based on the category id in the movies_categories table 
        //equaling 2.  In addition an inner join of the movies 
        //table will be performed based on matching move identfications
        $query = $this->db->link->query("SELECT movies_categories.*, movies.image,
                                        movies.title, movies.summary
                                        FROM movies_categories
                                        INNER JOIN movies
                                        ON movies_categories.movie_id = movies.id
                                        WHERE movies_categories.category_id = 2
                                        LIMIT 4");
        //if the rouw count is greated than 0, the query will be returned
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise return false.  
        else{
            return false;
        }
        
    }

    /**
     * This function will take a unique movie identification 
     * as input and perform a select query on the movies_Categories
     * table in the database based on the moves_categories input that have 
     * the input movie id as a field.  This will allow the function to return 
     * all the categories of the specific movie to show.  Once the query finishes, 
     * if more than 0 rows are returned by the query, the query will be returned. 
     * Otherwise, false will be returned.  
     */
    public function selectCategoriesByMovieId($id){
        //clean the input text using the clean text function and pass the input
        $movieId = $this->fm->clean_text($id); 

        //perform a select query on the movies_categoires table where the movie id
        //column matches the the input movie id.  Also perform an inner join of the 
        //categories table where the category id's match.  Pass this to the perpare function
        $query = $this->db->link->prepare("SELECT movies_categories.*, categories.name
                                        FROM movies_categories
                                        INNER JOIN categories
                                        ON movies_categories.category_id = categories.id
                                        WHERE movies_categories.movie_id = (?)"); 

        //pass the movie id input to the execute function
        $query->execute([$movieId]); 

        //if more than zero rows are returned , return the query
        if($query->rowCount() > 0){
            return $query; 
        } 
        //otherwise, return false.
        else{
            return false;
        }    
    }
}
?>