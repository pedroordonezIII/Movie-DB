<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>


<?php

/**
 * This class will impelment all functionality related to sending 
 * messages in the system.  Functionality to insert messages, delete 
 * messages and get user messages to the contact table will be implemented. 
 * Additionally, a fucntion to send an email will be provided.  
 */

class Contact{

    /**
     * set the db and fm attributes for he class
     */
    private $db; 
    private $fm;


    /**
     * constructor that is set when instantiating the class
     * 
     */
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * This method will take a form input 
     * , validate that input, and then check
     * if any of the input fields are empty. 
     * If any of the field are empty, return 
     * a message to the user.  Otherwise, insert
     * the form data into the contact table in the 
     * database for the specified fields.  Once
     * the data is inserted succesfully, return a 
     * success message.  
     */
    public function insertUserMessage($data){

        $name = $this->fm->clean_text($data["name"]);
        $email = $this->fm->clean_text($data["email"]); 
        $phone = $this->fm->clean_text($data["phone"]); 
        $subject = $this->fm->clean_text($data["subject"]); 
        $message = $this->fm->clean_text($data["message"]); 
          
         //check if any of the fields are empty and return error
         if($name == "" || $email == "" || $phone == "" || $subject=="" 
         || $message == ""){
            $msg = "<span class='error'>Fields must not be empty.</span>";
            return $msg; 
         }else{

             //insert the data into the database tbl_contact
             //insert all the field names and then all the values
             //that were input through the post request.  
             $query = "INSERT INTO tbl_contact(name, email, phone, subject, message) 
          VALUES ('$name','$email', '$phone', '$subject', '$message')";  
 
        //call insert method in db object class and pass the query to it
          $inserted_row = $this->db->insert($query);

          //check if inserted_row is inserted successufully
          if ($inserted_row) {
    			$msg = "<span class='success'>Message sent successfully.</span>";
    			return $msg;// Return success  message 
    		}else {
    			$msg = "<span class='error'>Message was not sent..</span> ";
    			return $msg; // Return errors message 
            }
        }
    }

    /**
     * This method will select all the user messages 
     * from the contact table in the databse using the 
     * select query.  To select that data, the select 
     * function in the databse class will be called 
     * by passing the query.  
     */
    public function getUserMessages(){

        //select all the rows from the contact table
        $query = "SELECT * FROM tbl_contact"; 

        //call the select function from the databse class and pass the query
        $table_rows = $this->db->select($query); 

        //return the result which is an object holding the data
        return $table_rows; 
    }


    /**
     * This function will delete a user message based on the 
     * messages unique identification, which will be the parameter 
     * of the function.  A delete query will be done on the contact table
     * and if the deletion is successful, the window.location will be used 
     * to reload the page.  Otherwise, an error message will be displayed.  
     */
    public function deleteUserMessage($id){

        //
        $messageId = mysqli_real_escape_string($this->db->link, $id);

        //delete query that deletes the message from the contact table based
        //on the message id that matches the input id.  
        $query = "DELETE FROM tbl_contact
                WHERE id='$messageId'";
        
        $delete_query = $this->db->delete($query);

        //if successful, reload the page.  otherwise, show an error.
        if($delete_query){
            $msg = "<span class='success'>Message deleted successfully.</span>";
            echo "<script>window.location = 'inbox.php';</script>";
    			return $msg;// Return message 
    		}else {
    			$msg = "<span class='error'>Message was not deleted.</span> ";
    			return $msg; // Return message 
            }
        }


        /**
         * This method will take a message id as input 
         * and return the specified message based on that 
         * message id.  This message will be returned using a 
         * select query on the databse based on the message id.  
         */
        public function getMessageById($id){
            //
            $messageId = mysqli_real_escape_string($this->db->link, $id);

            //Select the row from the contact table 
            //with the specified message id.  
            $query = "SELECT * FROM tbl_contact
                WHERE id='$messageId'";

            $select_query = $this->db->delete($query);

            //return the value
            return $select_query;
        }

        /**
         * This function will take a post request as input
         * , validate that data, and use that data to send an
         * email to the user based on the input email they gave.  
         * the php mail function will be used to send the email.  
         * If the email is sent successfully, a success message 
         * will be returned, otherwise an error message will be returned.  
         */
        public function sendEmail($data){

    //validate form input
        $name = $this->fm->validation($data["name"]);
        $email = $this->fm->validation($data["email"]); 
        $subject = $this->fm->validation($data["subject"]); 
        $message = $this->fm->validation($data["message"]); 

        //perform built in function to escape characters, use this to get all post field names
         //before inserting in the database
         $name = mysqli_real_escape_string($this->db->link, $name); 
         $email = mysqli_real_escape_string($this->db->link, $email); 
         $subject = mysqli_real_escape_string($this->db->link, $subject);
         $message = mysqli_real_escape_string($this->db->link, $message);

         //set the send to email, the message subject, message content and 
         //headers to pass to the mail function
        $to     = $email;
        $subject = $subject;
        $message = wordwrap($message, 70, "\r\n");
        $headers = 'From: '.$name . "\r\n" .
                'Reply-To: ecommercecsci675@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        //pass information to the mail function to send the email
        $mail = mail($to, $subject, $message, $headers);


        //if successfully sent, show success message
            if($mail){
            $msg = "<span class='success'>Message sent successfully.</span>";
            return $msg;// Return success message 
            }else {
            //otherwise, show error message.
            $msg = "<span class='error'>Message was not set.</span> ";
            return $msg; // Return message 
            }

        }


        /**
         * This method will select all the rows from the contact 
         * table and count the rows the show the message count.  
         * The count will then be returned.  
         */
        public function countMessages(){

            //query to select all rows from the contact table  
            $query = "SELECT * FROM tbl_contact"; 


            $table_rows = $this->db->select($query); 

            //initialize count to be zero.  
            $count = 0; 
            //if return is true and a row is present do this
            if($table_rows){
                //return associative array of all rows. 
                while($results = $table_rows->fetch_assoc()){
                    //udpate count
                    $count++; 
                }
            }
            //return the count.
            return $count;
        }
    }
?>