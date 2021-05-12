<?php 
 $filepath = realpath(dirname(__FILE__));
 //connect to the database
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
 
?>

<?php

class Movie{

    private $db;
    private $fm;

    public function __construct(){

        $this->fm = new Format();
        $this->db = new Database();
    }

    /**
     * 
     */
    public function insertMovie($data, $file){

        //validate data
            $title = $this->fm->clean_text($data["title"]);  
            $rank= $this->fm->clean_text($data["rank"]);  
            $poster = $this->fm->clean_text($data["poster"]);  
            $star_rating = $this->fm->clean_text($data["starrating"]);
            $rating = $this->fm->clean_text($data["rating"]); 
            $release = $this->fm->clean_text($data["release"]);  
            $category = $this->fm->clean_text($data["category"]);  
            $runtime = $this->fm->clean_text($data["runtime"]); 
            $genre = $this->fm->clean_text($data["genre"]); 
            $summary = $this->fm->clean_text($data["summary"]); 

        if(empty($data["title"]) || empty($data["rank"]) || 
            empty($data["starrating"]) || empty($data["poster"])
            || empty($data["rating"]) || empty($data["release"])
            || empty($data["category"]) || empty($data["runtime"])
            || empty($data["genre"]) || empty($data["summary"])){
            $msg = '<p><label class="text-danger">Please fill
            all fields.</label></p>'; 
            return $msg; 
        }
        else{  
            //create a matrix to hold data 
            $matrix = array();

            //call the function with the file and array that will 
            //hold the data
            $array = $this->data->getData("data/dataset.csv", $matrix);

            //open file and go to end of file
            $file_open = fopen("data/dataset.csv", "a");
        
             //set number of rows equal to matrix
            $no_rows = (count($array));
                
                if($no_rows > 1){
                    
                //serial number
                $no_rows = ($no_rows - 1) + 1; 
                }

            //store form data in array
            //store all data in array format
            $form_data = array(
                            
                "Title"     => $title,
                "Rank"      => $rank, 
                "Star Rating" => $star_rating,
                "Poster"      => $poster,
                "Rating"       => $rating,
                "Release Date"  => $release,
                "Runtime"       => $runtime,
                "Category"      => $category, 
                "Genre"         => $genre,
                "Summmary"      => $summary,
                "ID"        => $no_rows, 
            );
            //write array data in csv file
            //file open is file, form data is data 
            //to write in csv file
            fputcsv($file_open, $form_data);
        
            // $error .= '<p><h2 class="text-danger">Movie Stored.</h2></p>'; 
                
            $msg = '<p><label class="text-success">Movie Stored.</label></p>';
            return $msg;          
        }
    }


    /*
This function updates a movie based on the
ID. It also performs certain validation on the
form, sets the forms input equal to variables, 
and updates all items by updating an array of the 
items and then overwriting the csv file.
*/
public function updateAll($data){
    
     //validate data
     $title = $this->fm->clean_text($data["title"]);  
     //$rank= $this->fm->clean_text($data["rank"]);  
     $poster = $this->fm->clean_text($data["poster"]);  
     $star_rating = $this->fm->clean_text($data["starrating"]);
     $rating = $this->fm->clean_text($data["rating"]); 
     $release = $this->fm->clean_text($data["release"]);  
     $category = $this->fm->clean_text($data["category"]);  
     $runtime = $this->fm->clean_text($data["runtime"]); 
     $genre = $this->fm->clean_text($data["genre"]); 
     $summary = $this->fm->clean_text($data["summary"]); 
     $postid = $this->fm->clean_text($data["id"]); 

    if(empty($data["title"]) || empty($data["starrating"]) || empty($data["poster"])
     || empty($data["rating"]) || empty($data["release"])
     || empty($data["category"]) || empty($data["runtime"])
     || empty($data["genre"]) || empty($data["summary"])
     || $data["id"] == ""){

        $msg = '<p><label class="text-danger">Please fill
        all fields.</label></p>'; 
        return $msg; 
    } else{

        $file = "data/dataset.csv"; 
        
        //create a matrix to hold data 
        $matrix = array();
    
        //call the function with the file and array that will 
        //hold the data
        $dataContent = $this->data->getData($file, $matrix); 
    
        // if($id < count($matrix) && $current <= count($matrix) 
        // && $rank <=count($matrix) && $id >= 0){
        if($postid < count($dataContent) && $postid >= 0){

        // //make ranking for the Specified movie ID equal to the desired ranking
        // $matrix[$id]["Rank"] = $rank;
        // //update the specified movie to update ID
        // $matrix[$id]["ID"] = $rank-1;

        // //have the movie that holds the desired ranking hold 
        // //the current movies ranking
        // $matrix[$rank-1]["Rank"] = $current; 
        // //have the movie with the desired ranking hold the current
        // //movies id
        // $matrix[$rank-1]["ID"] = $id;
        // //swap the two 
        // $temp = $matrix[$rank-1]; 
        // $matrix[$rank-1] = $matrix[$id]; 
        // $matrix[$id] = $temp; 

        $datafile = "data/dataset.csv"; 
        //input the file, entire post, and post id
        $this->data->updateAllData($datafile, $data, $postid);
        //show success message
        $msg = '<p><label class="text-success">Update successful.</label></p>';
        return $msg; 
        } else{
                $msg = '<p><label class="text-danger">Please enter
                a valid ID.</label></p>'; 
                return $msg; 
            }
        } 
    }


    /**
     * 
     */

    public function updateSummary($data){
        $summary = $this->fm->clean_text($data["summary"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Summary"; 
    //check submisions from form
        if(empty($data["summary"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $summary, $postid); 
            return $msg;
         } 
    }

    /**
     * 
     */

    public function updateGenre($data){
        $genre = $this->fm->clean_text($data["genre"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Genre"; 
    //check submisions from form
        if(empty($data["genre"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $genre, $postid); 
            return $msg;
    } 
}


    /**
     * 
     */
    public function updateRuntime($data){
        $runtime = $this->fm->clean_text($data["runtime"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Runtime"; 
    //check submisions from form
        if(empty($data["runtime"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $runtime, $postid);
            return $msg; 
    }
} 

    /**
     * 
     */
    public function updateCategory($data){
        $category = $this->fm->clean_text($data["category"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Category"; 
    //check submisions from form
        if(empty($data["category"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $category, $postid);
            return $msg;
    }
}
    
    
    /**
     * 
     */
    public function updateRelease($data){
        $release = $this->fm->clean_text($data["release"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Release Date"; 
    //check submisions from form
        if(empty($data["release"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $release, $postid); 
            return $msg;
    } 
}

    /**
     * 
     */
    public function updateRating($data){
        $rating = $this->fm->clean_text($data["rating"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Rating"; 
    //check submisions from form
        if(empty($data["rating"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $rating, $postid);
            return $msg;
    } 
}


    /**
     * 
     */
    public function updatePoster($data){
        $poster = $this->fm->clean_text($data["poster"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Poster"; 
    //check submisions from form
        if(empty($data["poster"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $poster, $postid);
            return $msg;
    } 
}



    /**
     * 
     */
    public function updateStarRating($data){
        $star_rating = $this->fm->clean_text($data["star_rating"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Star Rating"; 
    //check submisions from form
        if(empty($data["star_rating"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $star_rating, $postid);
            return $msg; 
        } 
    }

    /**
     * 
     */
    public function updateRank($data){
        $rank = $this->fm->clean_text($data["rank"]);
        $current = $this->fm->clean_text($data["current"]);    
        $id = $this->fm->clean_text($data["id"]);
    //check submisions from form
        if(empty($data["rank"]) || $data["id"] == "" || empty($data["current"])){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
                //read the fiile
                $handle=fopen("data/dataset.csv","r");
    
                //create a matrix to hold data 
                $matrix = array();
    
                //call the function with the file and array that will 
                //hold the data
                $this->data->getDataMemory($handle, $matrix); 
    
                if($id < count($matrix) && $current <= count($matrix) 
                && $rank <=count($matrix) && $id >= 0){
                
                //make ranking for the Specified movie ID equal to the desired ranking
                $matrix[$id]["Rank"] = $rank;
                //update the specified movie to update ID
                $matrix[$id]["ID"] = $rank-1;
    
                //have the movie that holds the desired ranking hold 
                //the current movies ranking
                $matrix[$rank-1]["Rank"] = $current; 
                //have the movie with the desired ranking hold the current
                //movies id
                $matrix[$rank-1]["ID"] = $id;
                //swap the two 
                $temp = $matrix[$rank-1]; 
                $matrix[$rank-1] = $matrix[$id]; 
                $matrix[$id] = $temp; 
                // $matrix[$id]["Rank"] = $current;
                
                //get the data file to write over  
                $dataFile = fopen("data/dataset.csv", "w+"); 
                //build the headers for the table
                $headers = array("Title", "Rank", "Star Rating", "Poster", "Rating", 
                "Release Date", "Runtime", "Category", "Genre", "Summary","ID"); 
                //create the csv by calling the create csv function
                $this->data->createCSV($dataFile, $headers, $matrix);
                $msg = '<p><label class="text-success">Update successful.</label></p>'; 
                return $msg;
                }
                else{
                    $msg = '<p><label class="text-danger">Please enter
                    a valid ID.</label></p>'; 
                    return $msg;
             }
        }
    }

    /**
     * 
     */
    public function updateTitle($data){
        $title = $this->fm->clean_text($data["title"]);  
        $postid = $this->fm->clean_text($data["id"]);
        $key = "Title"; 
    //check submisions from form
        if(empty($data["title"]) || $data["id"] == ""){
            $msg= '<p><label class="text-danger">Empty field.</label></p>'; 
            return $msg;
        } else{
            $file = "data/dataset.csv"; 
            $msg = $this->data->updateData($file, $key, $title, $postid);
            return $msg; 
        } 
    }


    /**
     * 
     */
    public function deleteMovie($id){
        $file = "data/dataset.csv";

        $matrix = array();
        $dataArray = $this->data->getData($file, $matrix);

        array_splice($dataArray, $id, 1);

        foreach($dataArray as &$data){
                if($id <= $data["ID"]){
                $data["Rank"] =  $data["Rank"] - 1;
                $data["ID"] = $data["ID"] - 1;
            }
        }

        //print_r($dataArray);

        //get the data file to write over  
        $dataFile = fopen($file, "w+"); 

        //build the headers for the table
        $headers = array("Title", "Rank", "Star Rating", "Poster", "Rating", 
        "Release Date", "Runtime", "Category", "Genre", "Summary","ID"); 

        //create the csv by calling the create csv function
        $this->data->createCSV($dataFile, $headers, $dataArray);

        $msg = '<p><label class="text-success">Update successful.</label></p>';
        echo "<script>window.location = 'deleteOptions.php';</script>";
        return $msg;

    }

    /**
     * 
     */
    public function selectMovieByCategoryId($id){

    }
      
} 
?>