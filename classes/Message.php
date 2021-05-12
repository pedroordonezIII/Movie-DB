<?php 
/**
 * the real path will be the directory name
 * which is a file. When using the real path,
 * will load the entire path
 */
 $filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
//include_once ($filepath.'Admin.php');
 
?>


<?php
/**
 * This class will impelment all functionality related to sending 
 * messages in the system.  Functionality to insert messages, delete 
 * messages and select user messages from the messages table will be implemented. 
 * Additionally, a fucntion to send an email will be provided.  
 */
class Message{

    //initialize class attributes
    private $db; 
    private $fm; 

    //initialize the constructor which is called when 
    //instantiating an object of the class
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * This function will take a post data and a unique 
     * user id as parameters and use those parameters to 
     * insert data into the messages table in the database.  
     * If the insert query is successful, return a success message,
     * otherwise, return an error
     */
    public function insertUserMessage($data, $id){

        //call the cleantext function from the format class 
        //and pass the post data to it and the id
        $userId = $this->fm->clean_text($id);
        $message = $this->fm->clean_text($data["message"]);
        $subject = $this->fm->clean_text($data["subject"]);

        //if the input fields are empty, return an error message
        if($message == "" || $subject == ""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg; 
        } 
        //otherwise
        else{
            //perform an insert query on the messages table and insert 
            //the corresponding form input data
            $insertQuery = $this->db->link->prepare("INSERT INTO messages(userId, subject, message)
                                                    VALUES(?,?,?)");
            
            //pass the input data to the execute function to be passed to the 
            //values in the query
            $insertQuery->execute([$userId, $subject, $message]); 

            //if the query is successful, return a success message
            if($insertQuery){
                $msg = '<p><label class="text-success">Message Sent successfully.</label></p>';
                return $msg; 
            } 
            //otherwise, return an error message
            else{
                $msg = '<p><label class="text-success">Message failed to send.</label></p>';
                return $msg;
            }
        }
    }

    /**
     * This function will select all of the messages in the 
     * messages table in the database and inner join the users 
     * table based on the users unique id.  If more than 0 rows
     * are returned, a reference to the query will be retured.
     * Otherwise, false will be returned
     */
    public function selectMessages(){

        //this query will select all message from the messages table
        //by selecting all the rows from the messages table and columns as well
        //Additionally, an inner join based on the matching user id's in the messages and users table 
        //will be performed. This will then be passed to the query functino 
        $query = $this->db->link->query("SELECT messages.*, users.f_name, 
                                        users.l_name, users.email, users.username
                                        FROM messages
                                        INNER JOIN users
                                        ON messages.userId = users.id");
        //if more than 0 rows are returned, meaning there are messages, 
        //return the query
        if($query->rowCount() > 0){
            return $query;
        } 
        //otherwise return false
        else{
            return false;
        }
    }

   /**
         * This method will select all the rows from the contact 
         * table and count the rows and show the message count.  
         * The count will then be returned.  
         */
        public function countMessages(){

            //query to select all rows from the contact table  
            $query = "SELECT * FROM messages"; 

            //pass the query to the query function 
            $selectRows = $this->db->link->query($query); 

            //initialize count to be zero.  
            $count = 0; 
            //if return is true and a row is present do this
            if($selectRows){
                //return associative array of all rows. 
                while($selectRows->fetch()){
                    //udpate count
                    $count++; 
                }
            }
            //return the count.
            return $count;
        } 

          /**
     * This function will delete a user message based on the 
     * messages unique identification, which will be the parameter 
     * of the function.  A delete query will be done on the messages table
     * and if the deletion is successful, the window.location will be used 
     * to reload the page.  Otherwise, an error message will be displayed.  
     */
    public function deleteUserMessage($id){

        //clean the user input using the clean text function in the format class
        $messageId = $this->fm->clean_text($id);

        //delete query that deletes the message from the contact table based
        //on the message id that matches the input id.  
        $query = "DELETE FROM messages
                WHERE id=(?)";
        
        //pass the query to the perpare function
        $delete_query = $this->db->link->prepare($query);

        //pass the message id to the execute function 
        $delete_query->execute([$messageId]);

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
        public function selectMessageById($messageId){
            //clean the data using the clean_text function
            $messageId = $this->fm->clean_text($messageId);

             //join the messages and users table based on the user id and unique message id
             $selection = $this->db->link->prepare("SELECT messages.*, users.f_name, 
                                                users.l_name, users.email, users.username
                                                FROM messages
                                                INNER JOIN users
                                                ON messages.userId = users.id
                                                WHERE messages.id = (?)");
          
            //pass the unput paramters
            $selection->execute([$messageId]); 

            //check if the row count returned is greater than 0 and return the query object
            if($selection->rowCount() > 0){
                return $selection;
            } else{
                return false;
            }
        }


        /**
         * This function will take a post request as input
         * ,validate that data, and use that data to send an
         * email to the user based on the input email they gave.  
         * the php mail function will be used to send the email.  
         * If the email is sent successfully, a success message 
         * will be returned, otherwise an error message will be returned.  
         */
        public function sendEmail($data){

            //clean the form input
            $name = $this->fm->clean_text($data["name"]);
            $email = $this->fm->clean_text($data["email"]); 
            $subject = $this->fm->clean_text($data["subject"]); 
            $message = $this->fm->clean_text($data["message"]); 
            
            //if any of the form input are empty, return an error
            if($name == "" || $email == "" || $subject == "" || $message == ""){
                $msg = "<span class='text-danger'>All fields must be filled.</span> ";
                return $msg; // Return message 
            }
            //set the send to email, the message subject, message content and 
            //headers to pass to the mail function
            $to     = $email;
            $subject = $subject;
            $message = wordwrap($message, 70, "\r\n");
            // $headers = "From: ".$name . "\r\n" .
            // 'Reply-To: ecommercecsci675@gmail.com';
            $headers = 'From: '.$name . "\r\n" .
                    'Reply-To: ecommercecsci675@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
        
            //pass information to the mail function to send the email
            $mail = mail($to, $subject, $message, $headers);
            //$e = error_get_last();
        
            //if successfully sent, show success message
            if($mail){
                $msg = "<span class='text-success'>Email sent successfully.</span>";
                return $msg;// Return success message 
            }else {
                //otherwise, show error message.
                //  $errorMessage = $e['message'];
                $msg = "<span class='text-danger'>Email was not set.</span> ";
                return $msg; // Return message 
            }
        
        }

}