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

class User{

    //private attributes of the function
    private $db; 
    private $fm; 

    //make the constructor which is called when 
    //instantiating an object of the class
    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
    }

    /**
     * This function will take post data from the user 
     * registration form submitted by users and insert that
     * data into the users table in the database. If it is inserted 
     * successfully, a success message will be returned.  Otherwise, 
     * several form validations will occur and if the any of the 
     * validations fail, an error will be returned. Additionally, if the 
     * query fails, an error will be returned.  
     */
    public function registerUser($data){

        //pass the data in the post array with the corresponding name from the form
        //to the clean text funcion to clean the text
        $firstname = $this->fm->clean_text($data["firstname"]);
        $lastname = $this->fm->clean_text($data["lastname"]);
        $city = $this->fm->clean_text($data["city"]);
        $country = $this->fm->clean_text($data["country"]);
        $zip = $this->fm->clean_text($data["zip"]);
        $username = $this->fm->clean_text($data["username"]);
        $email = $this->fm->clean_text($data["email"]);
        $password = $this->fm->clean_text($data["password"]);

        //if any of the form data is empty return an error
        if($firstname == "" || $lastname == "" || $city == "" ||
        $country == "" || $zip == "" || $username == "" || $email == "" 
        || $password ==""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg; 
        } 
        else{

            //this query will select all rows with all columns from the user table
            // where the username is equal to the input username and the query will
            // be passed to the prepare function
            $checkUsername = $this->db->link->prepare("SELECT * FROM users
                                              WHERE username = (?)"); 
            //pass the username input to the query by passing it to the execute function
            $checkUsername->execute([$username]);

            //this query will select all rows with all columns from the admins table
            //where the username is equal to the input username and the query will be 
           // pass to the prepare function
            $checkAdminUsername = $this->db->link->prepare("SELECT * FROM admins
                                                        WHERE username = (?)"); 
            //pass the username input to the query by passing it to the execute function
            $checkAdminUsername->execute([$username]);

            //th//pass the input email to the query is query will select all rows and columns from the users table where the 
            //email is equal to the input email
            $checkEmail = $this->db->link->prepare("SELECT * FROM users
                                                WHERE email = (?)"); 
            
            $checkEmail->execute([$email]);

            //this query will select all rows and columns from the admins table where the 
            //email is equal to the input email
            $checkAdminEmail = $this->db->link->prepare("SELECT * FROM admins
                                                        WHERE email = (?)"); 
            //pass the input email to the query value
            $checkAdminEmail->execute([$email]);

            //this query will check both the email and the password from the users table where 
            //the email and the password both equal to the users input
            $checkAllCredentials = $this->db->link->prepare("SELECT * FROM users
                                                        WHERE email = (?)
                                                        AND username = (?)");
            //pass the users input email and the username to the query 
            $checkAllCredentials->execute([$email, $username]);

            //this query will check both the email and the password from the admins table where 
            //the email and the password both equal to the users input
            $checkAllAdminCredentials = $this->db->link->prepare("SELECT * FROM admins
                                                            WHERE username = (?)
                                                            AND email = (?)"); 
             //pass the users input email and the username to the query 
             $checkAllAdminCredentials->execute([$username, $email]);

            //check if the returned query returned more than zero rows for the query and username
            if($checkAllCredentials->rowCount() > 0 || $checkAllAdminCredentials->rowCount() > 0){
                $msg = '<p><label class="text-danger">Username and email are already in the system.</label></p>';
                return $msg;
            //check if the query returned more than zero rows for the username and return error
            } else if($checkUsername->rowCount() > 0 || $checkAdminUsername->rowCount() > 0){
                $msg = '<p><label class="text-danger">Username is already in the system.</label></p>';
                return $msg; 
            //check if the query returned more than zero rows for the email query and return error
            } else if($checkEmail->rowCount() > 0 || $checkAdminEmail->rowCount() > 0){
                $msg = '<p><label class="text-danger">Email is already in the system.</label></p>';
                return $msg; 
            } else{
                //using the password_hash built in function, pass the password to has it
                $hash = password_hash($password, PASSWORD_DEFAULT); 

                //perform an insert query on the user table with the corresponding columns
                //and pass the input values as input
                $query = $this->db->link->prepare("INSERT INTO users(f_name, l_name, username, email, 
                                            password, city, zip, country)
                VALUES(?,?,?,?,?,?,?,?)");

                //pass the input values to the execute function to set the query values
                $query->execute([$firstname, $lastname, $username, $email, 
                $hash, $city, $zip, $country]); 
                
                //if the query is successful, return a success message
                if($query){
                $msg = '<p><label class="text-success">User registered successfully.</label></p>';
                return $msg; 
                } 
                //otherwise, return an error message.
                else{
                $msg = '<p><label class="text-danger">User failed to register.</label></p>';
                return $msg; 
                }
            }
        }    
    }

    /**
     * This method will take a post data array
     * as input and will return an error message
     * if the user leaves the input data blank
     * or if the email or password do not match one
     * in the database.  If all is correct, based 
     * on the database query that compares the input
     * password and email to those in the database, 
     * a session is created and the session values are
     * set based on the returned user data from the select 
     * method on the users table in the database.  
     * The page is then redirected to the home page upon
     * successful login.  
     */

    public function userLogin($data){

        //validate the password and email input fields 
        $password   = $this->fm->clean_text($data['password']);
        $username      = $this->fm->clean_text($data["username"]);

        //if any field is left empty, return an error message
        if ($username == ""  || $password == "" ) {
            $msg = '<p><label class="text-danger">Please fill
            all fields.</label></p>'; 
            return $msg; 
        } 
        else{

            //query the database to check if the username is present
            //in the system to login using the select query where the username 
            //must match the one in the database table.
            $selectRow = $this->db->link->prepare("SELECT * FROM users
                                                WHERE username = (?)"); 

            //pass the input username to the execute function to set the value in the query
            $selectRow->execute([$username]);

            //get associative array of the query performed
            $rows = $selectRow->fetch(); 
            
            //if the row count is greated than 0, which means the username exists, 
            // and the password matches and true is for the user with the corresponding username 
            //,execute code inside this if block
            if($selectRow->rowCount() > 0 && password_verify($password, $rows["password"])){

                //set the userlogin to true using the set method in the session class
                Session::set("userLogin", true); 

                //add all user information in the session by setting user data based on the returned
                //database information that is an associative array in the rows variable using the 
                //set method in Session class for all user information
                Session::set("userid", $rows["id"]);
                Session::set("useremail", $rows["email"]); 
                Session::set("username", $rows["username"]); 
                Session::set("firstname", $rows["f_name"]); 
                Session::set("lastname", $rows["l_name"]);  
                Session::set("city", $rows["city"]); 
                Session::set("country", $rows["country"]);
                Session::set("zip", $rows["zip"]);

                //redirect to a specfic page using the header function upon logging int
                header("Location: index.php");
            }
            //otherwise, if the username or password are do not match, return an error message
            else{
                $msg = '<p><label class="text-danger">The password or username
                is incorrect.</label></p>'; 
                return $msg;  
            }
        }
    }

    /**
     * This function will take a users unique id as 
     * input and select the information from the users 
     * table in the database with where the id of the user
     * correspond to the input id.  If more than zero rows
     * are returned, return the query. 
     * Otherwise, an error message will be displayed. 
     */
    public function selectUserDetails($id){
        //set user id to input id
        $userId = $id; 

        //perform a select query from the users table where the 
        //id is equal to the input id. pass to the prepare function
        $selectQuery = $this->db->link->prepare("SELECT * FROM users
                                                WHERE id = (?) ");
        //pass the input id to the execute fucnction to set the value in the query
        $selectQuery->execute([$userId]); 

        //if more than 0 rows are returned , the user id exists and the query is returned
        if($selectQuery->rowCount() > 0){
            return $selectQuery;
        } 
        //otherwise return false
        else{
            return false; 
        }
    }

    /**
     * This function will take a post data array
     * as input and a unique user id as input. 
     * This data will be used to update the details
     * of the user with the corresponding input id in the users 
     * table in the database.  Prior to updating the information,
     * form validation will occur and if an error occurs, an 
     * error message will be returned.  Otherwise, the data will 
     * be updated in the users table in the database based on the 
     * user with the corresponding input unique id.  Once the update 
     * is successfully finished, a success message will be returned. 
     * Otherwise, an error message will be returned.   
     */
    public function updateUserDetails($data, $id){


        //validate information before inserting into the database
        $userId = $this->fm->clean_text($id);
        $firstName = $this->fm->clean_text($data["f_name"]);
        $lastName = $this->fm->clean_text($data["l_name"]);
        // $email = $this->fm->clean_text($data["email"]);
        // $userName = $this->fm->clean_text($data["username"]);
        $city = $this->fm->clean_text($data["city"]);
        $zip = $this->fm->clean_text($data["zip"]);
        $country = $this->fm->clean_text($data["country"]);

        //check for empty input fields and return error message if any field is left empty.  
        if($firstName == ""  || $lastName == "" || $city == "" || 
        $zip == "" || $country == ""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg; 
        }
        // } else{

        //     $checkCredentialsAdminsTable = $this->db->link->prepare("SELECT * FROM admins
        //                                                         WHERE email = (?)
        //                                                         OR username = (?)");
                                                                
        //     $checkCredentialsAdminsTable->execute([$email, $userName]);

        //     $checkCredentialsUsersTable = $this->db->link->prepare("SELECT * FROM users
        //                                                         WHERE email = (?)
        //                                                         OR username = (?)
        //                                                         "); 
                                                
        //     $checkCredentialsUsersTable->execute([$email, $userName]);
            
        //     $checkUsers = $this->db->link->prepare("SELECT * FROM users
        //                                             WHERE email = (?)
        //                                             OR username = (?)
        //                                             AND id = (?)");

        //     $checkUsers->execute([$email, $userName, $userId]);

        //     if($checkCredentialsAdminsTable->rowCount() > 0 || $checkCredentialsUsersTable->rowCount() > 0){
        //         $msg = '<p><label class="text-danger">Email or username is already in the system.</label></p>';
        //         return $msg; 
        //     } 
        else{
            /**
             * perform an update query of the users table and 
                * set the specified fields to the users input information
                * for the user with the unique identification equal to the input data.
                */
            $query = "UPDATE users
                    SET f_name=(?), l_name = (?),
                     city = (?), zip = (?), country = (?)
                    WHERE id=(?)";

            //pass the query to the prepare function 
            $update = $this->db->link->prepare($query);

            //pass the inputs to the execute function to set them as the values 
            //in the query
            $update->execute([$firstName, $lastName, $city, 
                            $zip, $country, $userId]);

            //if successfully updated, return a success message to the user.  
            if($update){
                echo "<script>window.location = 'updateProfile.php';</script>";
            } 
            //otherwise, return an error
            else{
                $msg = '<p><label class="text-danger">User detail failed to update succesfully.</label></p>';
                return $msg; 
            }
        }
    }

    /**
     * This function will take a post data array
     * as input and a unique user id as input. The data 
     * will be used to update the user email in the users table
     * of the database based on the user with the unique id corresponding 
     * to the input id provided.  Prior to updating, the data will be validated 
     * and if an error occurs, the error will be returned to the user.  Otherwise, 
     * the update query will be performed and if it is successful, a success message will
     * be returned and if not, an error message will be returned. 
     */
    public function updateUserEmail($data, $id){


        //validate information before inserting into the database
        $userId = $this->fm->clean_text($id);
        $email = $this->fm->clean_text($data["email"]);

        //check for empty input fields and return error message if any field is left empty.  
        if($email == ""){
            $msg = '<p><label class="text-danger">Field must not be empty.</label></p>';
            return $msg; 
        } 
        //make sure the email is in correct format by passing it to the filer_var function and
        //return an error message if it is not
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = '<p><label class="text-danger">Invalid email format.</label></p>';
            return $msg; 
        }
        else{
            //perform a select query on the admins table where the email field is 
            //equal to the input email field of the function and pass to the prepare 
            //function
            $checkCredentialsAdminsTable = $this->db->link->prepare("SELECT * FROM admins
                                                                WHERE email = (?)
                                                               ");
            //pass the email to the execute function to set the queries values                                          
            $checkCredentialsAdminsTable->execute([$email]);

            //perform a select query on the users table where the email field is 
            //equal to the input email field of the function and pass to the prepare 
            //function
            $checkCredentialsUsersTable = $this->db->link->prepare("SELECT * FROM users
                                                                WHERE email = (?)
                                                                "); 
            //pass the email to the execute function to set the queries values                               
            $checkCredentialsUsersTable->execute([$email]);
            
            // $checkUsers = $this->db->link->prepare("SELECT * FROM users
            //                                         WHERE email = (?)
            //                                         OR username = (?)
            //                                         AND id = (?)");

            // $checkUsers->execute([$email, $userName, $userId]);

            //if either of the queries return more than zero rows, that means the email 
            //is already in the system in either the admins or users table and an error should 
            //be returned 
            if($checkCredentialsAdminsTable->rowCount() > 0 || $checkCredentialsUsersTable->rowCount() > 0){
                $msg = '<p><label class="text-danger">Email is already in the system.</label></p>';
                return $msg; 
            } else{
                /**
                 * perform an update query of the users table and 
                 * set the specified fields to the users input information
                 * for the user with the unique identification, which will equal to 
                 * the input id provided.
                 */
                $query = "UPDATE users
                        SET email=(?)
                        WHERE id=(?)";

                //pass the query to the prepare function 
                $update = $this->db->link->prepare($query);
                
                //pass the email and user id to the execute function to set the values
                $update->execute([$email, $userId]);

                //if successfully updated, return a success message to the user.  
                if($update){
                    $msg = '<p><label class="text-success">Email updated succesfully.</label></p>';
                    return $msg; 
                } 
                //otherwise, return an error
                else{
                    $msg = '<p><label class="text-danger">Email failed to update succesfully.</label></p>';
                    return $msg; 
                }
            }
        }
    }

     /**
     * This function will take a post data array
     * as input and a unique user id as input. The data 
     * will be used to update the user username in the users table
     * of the database based on the user with the unique id corresponding 
     * to the input id provided.  Prior to updating, the data will be validated 
     * and if an error occurs, the error will be returned to the user.  Otherwise, 
     * the update query will be performed and if it is successful, a success message will
     * be returned and if not, an error message will be returned. 
     */
    public function updateUsername($data, $id){


        //validate information before inserting into the database by passing the 
        //input data to the clean_text function
        $userId = $this->fm->clean_text($id);
        $username = $this->fm->clean_text($data["username"]);

        //check for empty input fields and return error message if any field is left empty.  
        if($username == ""){
            $msg = '<p><label class="text-danger">Field must not be empty.</label></p>';
            return $msg; 
        } else{
             //perform a select query on the admins table where the username field is 
            //equal to the input username field of the function and pass to the prepare 
            //function
            $checkCredentialsAdminsTable = $this->db->link->prepare("SELECT * FROM admins
                                                                WHERE username = (?)
                                                               ");
              //pass the username input to the execute function to set the queries values                                                       
            $checkCredentialsAdminsTable->execute([$username]);

             //perform a select query on the users table where the username field is 
            //equal to the input username field of the function and pass to the prepare 
            //function
            $checkCredentialsUsersTable = $this->db->link->prepare("SELECT * FROM users
                                                                WHERE username = (?)
                                                                "); 
           //pass the username input to the execute function to set the queries values                               
            $checkCredentialsUsersTable->execute([$username]);
            
            // $checkUsers = $this->db->link->prepare("SELECT * FROM users
            //                                         WHERE email = (?)
            //                                         OR username = (?)
            //                                         AND id = (?)");

            // $checkUsers->execute([$email, $userName, $userId]);

            //if either of the queries return more than zero rows, that means the username
            //is already in the system in either the admins or users table and an error should 
            //be returned 
            if($checkCredentialsAdminsTable->rowCount() > 0 || $checkCredentialsUsersTable->rowCount() > 0){
                $msg = '<p><label class="text-danger">Username is already in the system.</label></p>';
                return $msg; 
            } else{
                /**
                 * perform an update query of the users table and 
                 * set the specified fields to the users input information
                 * for the user with the unique identification input field.
                 */
                $query = "UPDATE users
                        SET username=(?)
                        WHERE id=(?)";

                //pass the query to the prepare function
                $update = $this->db->link->prepare($query);
                
                //pass the input values to the execute function to 
                //set the values in the query
                $update->execute([$username, $userId]);

                //if successfully updated, return a success message to the user.  
                if($update){
                    $msg = '<p><label class="text-success">Username updated succesfully.</label></p>';
                    return $msg; 
                } 
                //otherwise, return an error message
                else{
                    $msg = '<p><label class="text-danger">Username failed to update succesfully.</label></p>';
                    return $msg; 
                }
            }
        }
    }
}

?>