



<?php


class Data{



    //get the data and store it in the array called matrix 
    //function takes a file and an array passed by value as input
    public function getData($file, $array){

        //open the dataset.csv file and read it
        $handle=fopen($file,"r");

        // open for reading
        if ($handle !== false) {            
            // extract header data
            if (($data = fgetcsv($handle, 1000, ",")) !== false) {      
                // save as keys 
                $keys = $data;                       
            }
            // loop remaining rows of data
            while (($data = fgetcsv($handle, 1000, ",")) !== false) { 
                // push associative subarrays
                $array[] = array_combine($keys, $data);       
            }
            fclose($handle);      

        return $array; 
        }
    }


    /**
     * 
     */
    function openFile($file){
        //open the file using read 
        $dataFile = fopen($file, "r");
        return $dataFile; 
    }

    /*
    this function takes a file, heading array,
    and data array to make into a csv file.
    The function first creates the csv file
    headers and then pupulates the data of the
    array into a csv file.  
    */
    function createCSV($file, $heading, $array){
        //create the headers in the csv file
        fputcsv($file, $heading); 

        //populate the data in the csv file
        foreach($array as $fields){
            fputcsv($file, $fields); 
        }   
        //close the file
        fclose($file); 
    }

    /**
     * 
     */
    function updateData($file, $key, $postupdate, $postid){
        
        //create a matrix to hold data 
        $matrix = array();
        
        //call the function with the file and array that will 
        //hold the data
        $dataArray = $this->getData($file, $matrix); 
        
        //must be greated than 0 and less than the length of the array
        if($postid < count($dataArray) && $postid >= 0){
            
            //update the title for the movie with the current ID
            $dataArray[$postid][$key] = $postupdate;
                
            //get the data file to write over  
            $dataFile = fopen($file, "w+"); 

            //build the headers for the table
            $headers = array("Title", "Rank", "Star Rating", "Poster", "Rating", 
            "Release Date", "Runtime", "Category", "Genre", "Summary","ID"); 

            //create the csv by calling the create csv function
            $this->createCSV($dataFile, $headers, $dataArray);

            $msg = '<p><label class="text-success">Update successful.</label></p>';
            return $msg;
        } else{
            $msg = '<p><label class="text-danger">Please enter a valid id</label></p>';
            return $msg;
    } 
}  
    /**
     * 
     */
    function updateAllData($dataFile, $data, $postid){
        
        //create a matrix to hold data 
        $matrix = array();
        
        //call the function with the file and array that will 
        //hold the data
        $dataContent = $this->getData($dataFile, $matrix); 
        
        //must be greated than 0 and less than the length of the array
        if($postid < count($dataContent) && $postid >= 0){
            
        //update all the items for the entry
         //$title, $rank, $star_rating;, $poster,
        //$rating, $release, $category, $runtime, $genre, $summary, 
        $dataContent[$postid]["Title"] = $data["title"];
        $dataContent[$postid]["Star Rating"] = $data["starrating"];
        $dataContent[$postid]["Poster"] = $data["poster"];
        $dataContent[$postid]["Rating"] = $data["rating"];
        $dataContent[$postid]["Release Date"] = $data["release"];
        $dataContent[$postid]["Runtime"] = $data["runtime"];
        $dataContent[$postid]["Category"] = $data["category"];
        $dataContent[$postid]["Genre"] = $data["genre"];
        $dataContent[$postid]["Summary"] = $data["summary"];
            
        //get the data file to write over  
        $dataFile = fopen($dataFile, "w+"); 

        //build the headers for the table
        $headers = array("Title", "Rank", "Star Rating", "Poster", "Rating", 
        "Release Date", "Runtime", "Category", "Genre", "Summary","ID"); 

        //create the csv by calling the create csv function
        $this->createCSV($dataFile, $headers, $dataContent);

        $msg = '<p><label class="text-success">Update successful.</label></p>';
        return $msg;
        }
        else{
            $msg = '<p><label class="text-danger">Please enter a valid id.</label></p>';
            return $msg;
        } 
    }
    
    

    /**
     * 
     */
    public function getDataMemory($file, &$array){
        // while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
        //     $array[] = $row;
        // }
        // open for reading
        if ($file !== false) {            
            // extract header data
            if (($data = fgetcsv($file, 1000, ",")) !== false) {      
                  // save as keys 
                $keys = $data;                       
            }
            // loop remaining rows of data
            while (($data = fgetcsv($file, 1000, ",")) !== false) { 
                // push associative subarrays
                $array[] = array_combine($keys, $data);       
            }
            fclose($file);      
    
        //return $csv; 
        }
    }

}


?>