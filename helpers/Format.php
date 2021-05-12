


<?php


class Format{

     /**
     * This method takes a date and 
     * formats the date using the date
     * built in function in php, month, day, year,
     * current time
     */
    public function formatDate($date){

        return date('Y-m-d', strtotime($date));
    }

    /**
     * Method to shorten text
     * Text passed and characters
     * to be display in this aray
     */
    public function textShorten($text, $limit = 400){
	//blank text
    $text = $text. "";
    //substring from 0-400 characters visible
	$text = substr($text, 0, $limit);
    //concatenate to show additional text
	$text = $text."..";
    //return the text
	return $text;
    }

    /*
    function to clean up the form data
    */
    public function clean_text($string){
        $string = trim($string); 
        $string = stripslashes($string); 
        $string = htmlspecialchars($string); 
        return $string; 
    }
    



}


?>