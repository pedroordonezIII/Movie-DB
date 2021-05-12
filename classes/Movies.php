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

class Movies{

    //instantiate the private attributes of the class
    private $db;
    private $fm; 

    //create the database constructor which will be called 
    //when the the class is object is instantiated
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * This function will take a post data array
     * as input and file array as input and use the 
     * corresponding information from the request and insert
     * the data into the movies table in the database. Prior 
     * to inserting the data into the movies table, several 
     * validations will be performed on the data submitted 
     * and if an error occurs, an error will be returned.  
     * Otherwise, an insert query will be performed and 
     * the corresponding data will be inserted into the 
     * movies table in the data. If the query is successful,
     * a success message will be returned, otherwise an 
     * error message will occur
     */
    public function insertMovie($data, $file){

        //access the post array data and pass the data to the
        //clean_text function to clean the input
        $title = $this->fm->clean_text($data["title"]);
        $rank = $this->fm->clean_text($data["rank"]);
        $rating = $this->fm->clean_text($data["rating"]);
        //$release_date = $this->fm->clean_text($data["release"]);
        $release_date = $this->fm->formatDate($data["release"]); 
        $runtime = $this->fm->clean_text($data["runtime"]);
        $categoryId = $this->fm->clean_text($data["categoryId"]);
        $genreId = $this->fm->clean_text($data["genreId"]);
        $summary = $this->fm->clean_text($data["summary"]);
        //$image = $this->fm->clean_text($file["image"]["name"]); 
        

        //check if any of the fields are empty and return an error if they are
        if( $title == "" || $rank == "" || $rating == "" ||
        $release_date == "" || $runtime == "" || $categoryId == "" || 
        $genreId == "" || $summary == ""){
            $msg = '<p><label class="text-danger">No fields may be empty.</label></p>';
            return $msg;  
        } 
        //if the image is set in the file data array, continue
        else if(isset($file["image"])) {
             //supported file types
            $permitted = array("jpg", "jpeg", "png", "gif"); 
         
            //handle the images
            //original image file name
            $file_name = $file["image"]["name"]; 

            //the image file size
            $file_size = $file["image"]["size"]; 
       
            //the uploaded file in the temporary directory on the 
            //web server
            $file_temp = $file["image"]["tmp_name"]; 
       
            //expode the original file name, which is a string,
            // into an array seperated by periods
            $div = explode('.', $file_name); 

            //get the last portion of the array which is the 
            //picture extension and make it lower case and set equal to file 
            //extension
            $file_ext = strtolower(end($div)); 
        
            //make the image unique using md5 hash and using the time function
            //to get a unique string.  use substr to return a substring 
            //with time from character 0-10 and concatenate the file extension
            //to make it the specific file
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext; 

            //choose place for image to be uploaded. upload folder and the name of the file
            $uploaded_image = "upload/".$unique_image; 

            //if the file name is not empty continue
            if(!empty($file_name)){
                //validation for file size and if it is too nig, return an error
                if($file_size > 2097152){
                    $msg = '<p><label class="text-danger">Image must be smaller than 2MB.</label></p>';
                    return $msg; 
                } 
                //validation for image type by checking if file extension is not in the array, and if it not
                //return an error message
                else if(in_array($file_ext, $permitted) === false){
                    //implode array to a string seperated by commas to display all permitted datatypes
                    $msg = "<p><label class='text-danger'>You can only add ".implode(',',$permitted)." images."."</label></p>";
                    return $msg; 
                }
                else{
                    //perform a select query on the movies table 
                    //where the movie title column is equal to the input title
                    $checkTitle = $this->db->link->prepare("SELECT * FROM movies
                                                        WHERE title = (?)"); 
                    //pass the input title to the execute function to set the value in the query
                    $checkTitle->execute([$title]); 
                    
                    //if more than zero rows are select, the movie title is in the 
                    //system and an error message should be returned. 
                    if($checkTitle->rowCount() > 0){
                        $msg = '<p><label class="text-danger">Movie was already added.</label></p>';
                        return $msg; 
                    }
                    //otherwise insert the movie
                    else{
                        //upload the images, which takes the file and location to upload
                        move_uploaded_file($file_temp, $uploaded_image);

                        //perform an insert query into the movies table with the corresponding 
                        //columns and input data as the values.  Pass to the prepare function
                        $stmt = $this->db->link->prepare("INSERT INTO movies(title, rating, rank,
                                                        runtime, release_date, summary, image)
                                                        VALUES(?,?,?,?,?,?,?)"); 

                        //pass the input data from the post array into the 
                        //execute function to set the values to insert into 
                        $stmt->execute([$title, $rating, $rank, $runtime, 
                            $release_date, $summary, $uploaded_image]);
                        
                        //if information was successfully inserted continue
                        if($stmt){
                            //perform a select query on the movies table
                            //where the title in the movies table is equal 
                            //to the title inserted into the movies database
                            $queryId = $this->db->link->prepare("SELECT id FROM movies
                                                                WHERE title = (?)"); 
                            
                            //pass the input title to the execute function to set the values
                            $queryId->execute([$title]); 

                            //if it is successful continue
                            if($queryId){

                                //fetch the result from the query and make it into a 
                                //associative array
                                $result = $queryId->fetch(); 

                                //get the data from the associative array result of the query
                                $movieId = $result["id"]; 

                                //perform an insert query on the movies_genres table specifying the movie id and genre id
                                //columns and set the values to the input values.  pass the query to the prepare
                                $stmt2 = $this->db->link->prepare("INSERT INTO movies_genres(movie_id, genre_id)
                                                                VALUES(?,?)"); 
                                //pass the values to insert as the values in the query 
                                $stmt2->execute([$movieId, $genreId]); 
                                
                                //perform an insert query on the movies_categories table specifying the movie id and genre id
                                //columns and set the values to the input values.  pass the query to the prepare
                                $stmt3 = $this->db->link->prepare("INSERT INTO movies_categories(movie_id, category_id)
                                                                VALUES(?,?)"); 
                                //pass the values to insert as the values in the query 
                                $stmt3->execute([$movieId, $categoryId]); 

                                //if both statements are successful, return success message
                                if($stmt2 && $stmt3){
                                    $msg = '<p><label class="text-success">Movie inserted successfully.</label></p>';
                                    return $msg; 
                                }
                                //otherwise, return an error message 
                                else{
                                    $msg = '<p><label class="text-danger">Movie insertion failed.</label></p>';
                                    return $msg; 
                                }
                            }
                        }
                    }
                }
            }
        //if the movie image field is empty, return an error message
        else{
            $msg = '<p><label class="text-danger">Movie image field must not be empty.</label></p>';
            return $msg; 
        } 
    }
    }

     /**
     * This function will select all the 
     * movies from the system in descending 
     * order the return the query if it is successful.
     * Otherwise, an error will be returned.  
     */
    public function selectAllMovies(){

        //perform a select query to return all columns of the movies
        //table and order input by the rank column in descending order
        //pass query to the query function
        $query = $this->db->link->query("SELECT * FROM movies
                                        ORDER BY rank DESC"); 

        //if the query is successful, return the query
        if($query){
            return $query; 
        } 
        //otherwise, return false
        else{
            return false;
        }
    }

    /**
     * This function will take a movie id 
     * as input and use that id to delete 
     * the movie from the movies table in the 
     * database. Before deleting the movie, 
     * the specific movie genre and movie category 
     * must be deleted. In addition, if the movie
     * has a director or actor associated with it
     * , they must also be deleted.
     */
    public function deleteMovieById($id){

        $movieId = $this->fm->clean_text($id); 

        $deleteGenre = $this->db->link->prepare("DELETE FROM movies_genres
                                            WHERE movie_id = (?)"); 
        $deleteGenre->execute([$movieId]); 

        $deleteCategory = $this->db->link->prepare("DELETE FROM movies_categories
                                            WHERE movie_id = (?)"); 
        $deleteCategory->execute([$movieId]); 

        $checkDirectors = $this->db->link->prepare("SELECT * FROM movies_directors
                                            WHERE movie_id = (?)"); 

        $checkDirectors->execute([$movieId]);
        
        $checkRoles = $this->db->link->prepare("SELECT * FROM roles
                                            WHERE movie_id = (?)"); 
                                            
        $checkRoles->execute([$movieId]);    

        if($checkDirectors->rowCount() > 0 && $checkRoles->rowCount() > 0){
            $deleteDirector = $this->db->link->prepare("DELETE FROM movies_directors
                                                     WHERE movie_id = (?)"); 
            $deleteDirector->execute([$movieId]); 

            $deleteRole = $this->db->link->prepare("DELETE FROM roles
                                                    WHERE movie_id = (?)"); 
            $deleteRole->execute([$movieId]); 
            
            $query = $this->db->link->prepare("DELETE FROM movies
                                            WHERE id = (?)"); 
            $query->execute([$movieId]); 

            if($query){
                $msg = '<p><label class="text-success">Movie deleted successfully.</label></p>';
                return $msg; 
            }
            else{
                $msg = '<p><label class="text-danger">Movie deletion was unsuccessful.</label></p>';
                return $msg; 
            }
        } else if($checkDirectors->rowCount() > 0){
            $deleteDirector = $this->db->link->prepare("DELETE FROM movies_directors
                                                    WHERE movie_id = (?)"); 
            $deleteDirector->execute([$movieId]); 

            $query = $this->db->link->prepare("DELETE FROM movies
                                            WHERE id = (?)"); 
            $query->execute([$movieId]); 

            if($query){
                $msg = '<p><label class="text-success">Movie deleted successfully.</label></p>';
                return $msg; 
            }
            else{
                $msg = '<p><label class="text-danger">Movie deletion was unsuccessful.</label></p>';
                return $msg; 
            }
        } else if($checkRoles->rowCount() > 0){
            $deleteRole = $this->db->link->prepare("DELETE FROM roles
                                                WHERE movie_id = (?)"); 
            $deleteRole->execute([$movieId]); 

            $query = $this->db->link->prepare("DELETE FROM movies
                                             WHERE id = (?)"); 
            $query->execute([$movieId]); 

            if($query){
                $msg = '<p><label class="text-success">Movie deleted successfully.</label></p>';
                return $msg; 
            }
            else{
                $msg = '<p><label class="text-danger">Movie deletion was unsuccessful.</label></p>';
                return $msg; 
            }
        } else{
            $query = $this->db->link->prepare("DELETE FROM movies
                                            WHERE id = (?)"); 
            
            $query->execute([$movieId]); 

            if($query){
                $msg = '<p><label class="text-success">Movie deleted successfully.</label></p>';
                return $msg; 
            }
            else{
                $msg = '<p><label class="text-danger">Movie deletion was unsuccessful.</label></p>';
                return $msg; 
            }
        }
    }

    /**
     * This function will take a movie id as input
     * and select the movie with the corresponding 
     * id from the movies table in the databse.  If 
     * more than 0 rows are returned, the query will
     * be returned. Otherwise, false will be returned
     */
    public function selectMovieById($id){

        //clean the input with the clean text function
        $movieId = $this->fm->clean_text($id); 

        //perform a select query on the movies table 
        //where the id in the movies table column is 
        //equal to the input id. pass the query to the 
        //prepare function
        $query = $this->db->link->prepare("SELECT * FROM movies
                                        WHERE id = (?)"); 
        //pass the movieid value to the execute function to set the query value
        $query->execute([$movieId]); 

        //if more than 0 rows are returned, the query will be returned
        if($query->rowCount() > 0){
            return $query;
        } 
        //otherwise, false will be returned. 
        else{
            return false;
        }
    }

    /**
     * This function will take a movie id as input
     * and use that movie id input to return all of 
     * the movie information corresponding to the 
     * movie with the specific id including all the 
     * information in the movies table, categories table,
     * and genres table.  If more than 0 rows are returned, 
     * the query will be returned.  Otherwise, false will 
     * be returned.  
     */
    public function selectMovieInfoById($id){

        //clean the input using the clean text function 
        //and pass the id
        $movieId = $this->fm->clean_text($id); 

        //perform a select query on the movies table where the 
        //movie id is equal to the input movie id.  
        //Also perform inner joins of the movies_genres table
        //genres table, movies_categories table, and categories table,
        //to return all movie information
        $query = $this->db->link->prepare("SELECT movies.*, movies_genres.movie_id, 
                                        movies_genres.genre_id, genres.name AS genreName
                                        movies_categories.movie_id, movies_categories.category_id,
                                        categories.name AS categoryName
                                        FROM movies
                                        INNER JOIN  movies_genres
                                        ON movies.id = movies_genres.movie_id
                                        INNER JOIN genres
                                        ON movies_genres.genre_id = genres.id
                                        INNER JOIN movies_categories
                                        ON movies.id = movies_categories.movie_id
                                        INNER JOIN categories
                                        ON movies_categories.category_id = categories.id
                                        WHERE id = (?)"); 
        
        //pass the movie id input to the execute function to set the values
        $query->execute([$movieId]); 

        //if more than 0 values are returned, return the query
        if($query->rowCount() > 0){
            return $query;
        } 
        //otherwise, return false.
        else{
            return false;
        }
    }

    /**
     * This function will take a post array as input, a file
     * and an id referring the the movie to update. The function
     * will first validate input and if an error occurs, an error 
     * message will be returned. The user will have the option
     * to update with an image or not. Depending on whether the 
     * user inputs an image, the update query will be performed 
     * with the corresponding input data. Once the update is successful
     * a success message will be returned to the user.  
     */
    public function updateMovieById($data, $file, $id){
        //validate the form input using the clean text function
        //from the input in the post array
        $title = $this->fm->clean_text($data["title"]);
        $rank = $this->fm->clean_text($data["rank"]);
        $rating = $this->fm->clean_text($data["rating"]);
        //$release_date = $this->fm->clean_text($data["release"]);
        $release_date = $this->fm->formatDate($data["release"]); 
        $runtime = $this->fm->clean_text($data["runtime"]);
        $summary = $this->fm->clean_text($data["summary"]);
        $movieId = $this->fm->clean_text($id);
        // $categoryId = $this->fm->clean_text($data["categoryId"]);
        // $genreId = $this->fm->clean_text($data["genreId"]);
        //$image = $this->fm->clean_text($file["image"]["name"]); 
        

        //check if any of the fields are empty and return error if they are 
        if( $title == "" || $rank == "" || $rating == "" ||
        $release_date == "" || $runtime == "" || $summary == ""){
            $msg = '<p><label class="text-danger">No fields may be empty.</label></p>';
            return $msg;  
        } else if(isset($file["image"])) {
             //supported file types
            $permitted = array("jpg", "jpeg", "png", "gif"); 
         
            //handle the images
            //original image file name
            $file_name = $file["image"]["name"]; 

            //the image file size
            $file_size = $file["image"]["size"]; 
       
            //the uploaded file in the temporary directory on the 
            //web server
            $file_temp = $file["image"]["tmp_name"]; 
       
            //expode the original file name, which is a string,
            // into an array seperated by periods
            $div = explode('.', $file_name); 

            //get the last portion of the array which is the 
            //picture extension and make it lower case and set equal to file 
            //extension
            $file_ext = strtolower(end($div)); 
        
            //make the image unique using md5 hash and using the time function
            //to get a unique string.  use substr to return a substring 
            //with time from character 0-10 and concatenate the file extension
            //to make it the specific file
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext; 

            //choose place for image to be uploaded. upload folder and the name of the file
            $uploaded_image = "upload/".$unique_image; 

            //if the user did input a file and it is not empty, continue here
            if(!empty($file_name)){
                //validation for file size and if too large , return error
                if($file_size > 2097152){
                    $msg = '<p><label class="text-danger">Image must be smaller than 2MB.</label></p>';
                    return $msg; 
                } 
                //validation for image type by checking if file extension is not in the array and if not, return error
                else if(in_array($file_ext, $permitted) === false){
                    //implode array to a string seperated by commas to display all permitted datatypes
                    $msg = "<p><label class='text-danger'>You can only add ".implode(',',$permitted)." images."."</label></p>";
                    return $msg; 
                }
                else{
                    //perform a select query from the movies table 
                    //with the condition that the title is equal to 
                    //the input title and the id is not equal to the 
                    //input id
                    $checkTitle = $this->db->link->prepare("SELECT * FROM movies
                                                        WHERE title = (?)
                                                        AND id != (?)"); 
                    //pass the input variables to set the values in the query
                    $checkTitle->execute([$title, $movieId]); 

                    //if more than 0 rows are returned, which means that one movie other than
                    //the current movie already had the movie title.
                    if($checkTitle->rowCount() > 0){
                        $msg = '<p><label class="text-danger">Movie was already added.</label></p>';
                        return $msg; 
                    }
                    else{
                    //upload the images, takes file and location to upload
                        move_uploaded_file($file_temp, $uploaded_image);

                        //perform an update query on the movies table 
                        //by setting all of the columns in the movies
                        //table equal to the input data where the id
                        //is equal to the input id. Pass to the prepare 
                        //function
                        $stmt = $this->db->link->prepare("UPDATE movies
                                                        SET title = (?), rating = (?), rank=(?),
                                                        runtime=(?), release_date=(?), summary=(?),
                                                        image = (?)
                                                        WHERE id = (?)"); 

                        //pass the input variable values to the execute function to 
                        //set the values in the query
                        $stmt->execute([$title, $rating, $rank, $runtime, 
                            $release_date, $summary, $uploaded_image, $movieId]);

                        //if the query is returned successfully, return a success message 
                        if($stmt){
                            $msg = '<p><label class="text-success">Movie was updated successfully.</label></p>';
                            return $msg; 
                        }
                        //otherwise, return an error
                        else{
                            $msg = '<p><label class="text-danger">Movie failed to update.</label></p>';
                            return $msg; 
                        }
                    }
                }
            }
            //at this point, the image was not submitted and the image will not be updated.
            //perform an update query on the movies table and set the corresponding 
            //values to the input values where the movie id is equal to the input movie
            //id. Pass the query to the execute function
            else{
                $stmt = $this->db->link->prepare("UPDATE movies
                                                SET title = (?), rating = (?), rank=(?),
                                                runtime=(?), release_date=(?), summary=(?)
                                                WHERE id = (?)"); 

                //pass the input variables to the execute function to set the values in the query
                $stmt->execute([$title, $rating, $rank, $runtime, 
                $release_date, $summary, $movieId]);

                //if the query is successful, return a success message to the user
                if($stmt){
                $msg = '<p><label class="text-success">Movie was updated successfully.</label></p>';
                return $msg; 
                }
                //otherwise, return a error
                else{
                $msg = '<p><label class="text-danger">Movie failed to update.</label></p>';
                return $msg; 
                }
            } 
        }
    }

    /**
     * This function will take a genre id as input
     * and will use that genre to select movies 
     * by a specific genre using the genre id. 
     * If more than 0 rows are returned, return
     * the query.  Otherwise, return false. 
     */
    public function selectMovieByGenreId($id){

        //clean the input using the clean text function
        $genreId = $this->fm->clean_text($id); 

        //perform a select query on the movies_genres table 
        //where the genre id in that table is equal to the 
        //genre id input for the function. IN addition, perform
        //an inner join of the movies table where the movie id 
        //in the movies_genres table is equal to the movie id in the 
        //movies table to return the movie information for all movies 
        //with the genre. Also order the movies by rank . Pass the query to
        //the prepare function
        $query = $this->db->link->prepare("SELECT movies_genres.*, movies.title, movies.rating,
                                        movies.release_date, movies.summary, movies.image, movies.rank
                                        FROM movies_genres
                                        INNER JOIN movies
                                        ON movies_genres.movie_id = movies.id
                                        AND movies_genres.genre_id = (?)
                                        ORDER BY movies.rank DESC"); 
        //pass the genre id to the execute function to set the query values
        $query->execute([$genreId]); 

        //if more than 0 rows are selected return the query
        if($query->rowCount() > 0){
            return $query; 
        } 
        //otherwise, return false
        else{
            return false;
        }

    }

    /**
     * This function will take an id as input, 
     * which refers to the category id, and 
     * select the rows from the movies_Categories
     * table with the corresponding category id. This
     * will allow the movies with the category id to 
     * be accessed.  Once the query is complete, if 
     * more than 0 rows are selected from the query
     * the query will be returned. Otherwise, false will be returned. 
     */
    public function selectMovieByCategoryId($id){

        //clean the input data with the clean_text function
        $categoryId = $this->fm->clean_text($id); 

        /*
        perform a select query on the movies_categories table in the database 
        where the category id in the table is equal to the input category id.
        Also, perform an inner join of the movies table where the movie id 
        in the movies table is equal to the movies_categories movie id. The
        movies will also be ordered by rank in descending order
        */
        $query = $this->db->link->prepare("SELECT movies_categories.*, movies.title, movies.rating,
                                        movies.release_date, movies.summary, movies.image, movies.rank
                                        FROM movies_categories
                                        INNER JOIN movies
                                        ON movies_categories.movie_id = movies.id
                                        AND movies_categories.category_id = (?)
                                        ORDER BY movies.rank DESC"); 

        //pass the category id to the execute function to set the value as 
        //the category id.
        $query->execute([$categoryId]); 

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
     * This method will search the body and productName
     * fields on the product table to return any products
     * that match with the search keywords.  The input
     * will be the search keywords
     */
    public function searchContent($search){

        $search = $this->fm->clean_text($search);

        //select query that select all rows from the
        //products table and selects two fields, including
        //the productName and body to compare those inputs
        //with the search input. It will be one or the other
        // $query = "SELECT movies.id AS movieID, movies.*, roles.*, 
        //         actors.*, movies_genres.*, genres.*, movies_directors.*,
        //         directors.*, movies_categories.*, categories.*
        //         FROM movies
        //         INNER JOIN roles
        //         ON movies.id = roles.movie_id
        //         INNER JOIN actors
        //         ON roles.actor_id = actors.id
        //         INNER JOIN movies_genres
        //         ON movies.id = movies_genres.movie_id
        //         INNER JOIN genres
        //         ON movies_genres.genre_id = genres.id
        //         INNER JOIN movies_directors
        //         ON movies.id = movies_directors.movie_id
        //         INNER JOIN directors
        //         ON movies_directors.director_id = directors.id
        //         INNER JOIN movies_categories
        //         ON movies.id = movies_categories.movie_id
        //         INNER JOIN categories
        //         ON movies_categories.category_id = categories.id
        //         WHERE movies.title LIKE '%$search%' 
        //         OR movies.summary LIKE '%$search%'
        //         OR actors.first_name LIKE '%$search%'
        //         OR actors.last_name LIKE '%$search%'
        //         OR CONCAT(actors.first_name, ' ', actors.last_name)
        //         LIKE '%$search%' OR genres.name LIKE '%$search%'
        //         OR directors.first_name LIKE '%$search%'
        //         OR directors.last_name LIKE '%$search%'
        //         OR CONCAT(directors.first_name, ' ', directors.last_name)
        //         LIKE '%$search%' OR categories.name LIKE '%$search%'
        //         ORDER BY movies.rank DESC";
               
            //this query will search values from the movies 
            //table in the database based on the movie title
            //or the movie summary values. Search will only correspond
            //to the title and summary column
            $query2 = "SELECT movies.id AS movieID, movies.*
                    FROM movies
                    WHERE movies.title LIKE '%$search%' 
                    OR movies.summary LIKE '%$search%'
                    ORDER BY movies.rank DESC";

        
        //pass the query to the select method 
        $result = $this->db->link->query($query2);

        //if more than zero rows are returned, return the query
        if($result->rowCount() > 0){
            return $result; 
        } 
        //otherwise, return false.
        else{
            return false;
        }

    }
}
?>