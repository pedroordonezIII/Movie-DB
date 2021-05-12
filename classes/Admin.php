<?php
//include all files 
//include '../lib/Session.php';
//Session::checkLogin();//check login
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
?>

<?php


class Admin{

    //initialize the class attributes
    private $db; 
    private $fm; 


    /**
     * Initialize the constructor, which will 
     * be called upon instantiating objects of the
     * class.  
     */
    public function __construct(){
        //create objects of the class for the attributes.  
        //these objects correspond to properties
        $this->db = new Database(); 
        //new format object
        $this->fm = new Format();

    }

    /**
     * admin login function that takes the admin username as 
     * input and admin password as input
     * Will first validate the inputs using 
     * clean text function in format class
     * It will then check for empty values
     * and if empty, will return error result 
     * if not empty, function will perform a query on the database
     * and compare the user input with the database values
     * Will then use the select query from the database class
     * which will either return a reference to the object 
     * or false. If everything is correct, it will not be false
     * and all session items will be added and the user will be redirected
     * to correct location
     */
    public function adminLogin($data){
        //validate the admin username using validation method
        $username = $this->fm->clean_text($data["username"]); 
        //validate the admin password class using validation method
        $password = $this->fm->clean_text($data['password']); 

        if ($username == ""  || $password == "" ) {
            $msg = "<span class='error'>Fields must not be empty .</span>";
            return $msg; // return message )
        }else{
            //return orginal password by passing the md5 to the password
            $password = md5($password);
            //perform query
            //query will compare user input to 
            //data inside the admins table and 
            $selectRows = $this->db->link->prepare("SELECT * FROM admins
                                                    WHERE username=(?)
                                                    AND password=(?)"); 
            
            //pass the input to the execute function
            $selectRows->execute([$username, $password]);

            //if the query returns more than 0 rows, it means the input matches
            if($selectRows->rowCount() > 0){

                //get the row as an associative array
                $result = $selectRows->fetch();

                //set al values to corresponding results
                /*
                if correct login information, then redirect
                to the admin home page and set all the session
                value corresponding to the admin user
                */
                Session::set("adminlogin", true); 
                //set admin id to corresponding value
                Session::set("adminId", $result['id']);
                Session::set("adminUser", $value['username']);
                Session::set("adminName", $value['name']);
                Session::set("adminEmail", $value['email']);  
                //redirect to the admin homepage
                //check the session and redirect user
                header("Location:system_admin/dashboard.php"); 
            }  
            //otherwise, return an error message telling the user that the password is incorrects
            else{
                $msg = "<span class='error'>The password is incorrect.</span>";
                return $msg; // return message )
            }   
        } 
    }


    /**
     * Input: post data that contains the admin name, username, 
     * email, and admin password.
     * Output: Message corresponding to validation errors or 
     * success message.  
     * This function will take a post request as input , which 
     * holds all the form input data and set those values equal to
     * variables.  If any of the input values are empty, an error 
     * message will be returned. Otherwise, the username and email
     * will be validated to make sure they have not been used in the 
     * system already. Finally, if input values have not been used 
     * the data is inserted into the admins table and a success message 
     * is returned if the data is inserted successfully, while an error
     * is returned if not.  
     */
    public function registerAdmin($data){

        //validate the form input data using clean text function. 
        $name = $this->fm->clean_text($data["name"]);
        $username = $this->fm->clean_text($data["username"]);
        $email = $this->fm->clean_text($data["email"]);
        $password = $this->fm->clean_text(md5($data["password"]));


        //check for empty values and return error if there is some
        if($name == "" || $username == "" || $email == "" ||
        $password == ""){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg; 
        } else{
            //select query of the admins table where the email and username fields in the 
            //admins table equal the form input. Pass this value to the prepare function
            $checkCredentialsAdminsTable = $this->db->link->prepare("SELECT * FROM admins
                                                                WHERE email = (?)
                                                                OR username = (?)");
            //pass the input values to the execute function                                                
            $checkCredentialsAdminsTable->execute([$email, $username]);

            //select query of the users table where the email and username fields in the 
            //admins table equal the form input. Pass this value to the prepare function
            $checkCredentialsUsersTable = $this->db->link->prepare("SELECT * FROM users
                                                                WHERE email = (?)
                                                                OR username = (?)"); 
              //pass the input values to the execute function   
            $checkCredentialsUsersTable->execute([$email, $username]);

            //if either query returns more than zero rows, ir means that the username or email is in the 
            //system and an error will be returned
            if( $checkCredentialsAdminsTable->rowCount() > 0 || $checkCredentialsUsersTable->rowCount() > 0){
                $msg = '<p><label class="text-danger">Email or username are already in the system.</label></p>';
                return $msg; 
            } else{
                //$hash = password_hash($password, PASSWORD_DEFAULT); 

                //otherwise, insert the data into the admins table using the insert query 
                //and pass the correct input values.  Pass this query to the prepare function
                $query = $this->db->link->prepare("INSERT INTO admins(name, username, email, password)
                VALUES(?,?,?,?)");

                //pass the input values to the execute function
                $query->execute([$name, $username, $email, $password]); 

                //if the query is successful, return a success message
                if($query){
                $msg = '<p><label class="text-success">Admin registered successfully.</label></p>';
                return $msg; 
                } 
                //otherwise, return an error message 
                else{
                $msg = '<p><label class="text-danger">Admin failed to register.</label></p>';
                return $msg; 
                }
            }
        }    
    }

     /**
     * This function will take the admins unique identifcation
     * as input, which will be set for each users session upon
     * loggin in.  Once input is validated, a select query of 
     * the admin table to return all rows will be done based
     * on the admins unique identification for the current session.  
     */
    public function selectAdminData($id){

        //clean the data using the clean text function
        $adminId = $this->fm->clean_text($id);

        /**
         * perform a select query on the admin table based 
         * on the admins unique identification that matches 
         * one from the table rows.  
         */
        $query = $this->db->link->prepare("SELECT * FROM admins 
                                        WHERE id = (?)"); 
        //pass the admin id input to the execute function                                   
        $query->execute([$adminId]);
        
        //if more than 0 rows are returned, the admin has data
        //and the query is returned
        if($query->rowCount() > 0){
            return $query;
        }
        //otherwise return false
        else{
            return false;
        }
    }

    /**
     * This function will take the specific admins unique identification
     * and form data submitted through a post request as parameters.  
     * Initially, all data will be validated. If a field is left empty, an 
     * error message will be displayed to the user telling them 
     * that all fields must be filled.  Otherwise, 
     * an update query of the admin table that 
     * updates all the fields in the admin table 
     * will be done using the specific input information
     * for the admin with the specific unique identification. 
     * If the table row is successfully updated, a success 
     * message will be displayed to the user.  
     */
    public function updateAdminDetails($id, $data){


        //validate information before inserting into the database
        $adminId = $this->fm->clean_text($id);

        $adminName = $this->fm->clean_text($data["name"]);

        // $adminEmail = $this->fm->clean_text($data["email"]);

        // $adminUsername = $this->fm->clean_text($data["username"]);

        //check for empty input fields and return error message if any field is left empty.  
        if($adminName == ""){
            $msg = '<p><label class="text-danger">The field must not be empty.</label></p>';
            return $msg;
        }
        // } else{

        //     $checkCredentialsAdminsTable = $this->db->link->prepare("SELECT * FROM admins
        //                                                         WHERE email = (?)
        //                                                         OR username = (?)");
                                                                
        //     $checkCredentialsAdminsTable->execute([$adminEmail, $adminUsername]);

        //     $checkCredentialsUsersTable = $this->db->link->prepare("SELECT * FROM users
        //                                                         WHERE email = (?)
        //                                                         OR username = (?)"); 
        //     $checkCredentialsUsersTable->execute([$adminEmail, $adminUsername]);

        //     if( $checkCredentialsAdminsTable->rowCount() > 0 || $checkCredentialsUsersTable->rowCount() > 0){
        //         $msg = '<p><label class="text-danger">Email or username is already in the system..</label></p>';
        //         return $msg; 
        //     } 
        else{
            /**
                * perform an update query of the admins table and 
                * set the specified fields to the users input information
                * for the admin with the unique identification.
                */
            $query = "UPDATE admins
                    SET name=(?)
                    WHERE id=(?)";

            //pass the query to the prepare function
            $update = $this->db->link->prepare($query);

            //pass the input to the execute function
            $update->execute([$adminName, $adminId ]);

            //if successfully updated, relocate to the updateDetails page
            if($update){
                // $msg = '<p><label class="text-success">Admin name updated succesfully.</label></p>';
                // return $msg; 
                echo "<script>window.location = 'updatedetails.php';</script>";
            } 
            //otherwise, return an errro
            else{
                $msg = '<p><label class="text-danger">Admin name failed to update.</label></p>';
                return $msg; 
            }
        }
    }

    /**
     * Input: admins unique id, $data is the 
     * post request data which will only be an 
     * email.
     * Output: Message corresponding to whether 
     * there was an error or the query was successful
     * This function will update an admins email in the 
     * admin table in the database. Prior to updating ,
     * form validation must be performed on the form. 
     * If the input is empty, an error message will be 
     * returned. Otherwise, if the email is not in 
     * valid format an error will be returned. finally, 
     * if the email is already in the system, an error 
     * will be returned. If all form validations pass, 
     * an update will be performed on the user in the 
     * admins table with the input id and the email field
     * will be set to the input data. Finally, a success
     * message will be returned to the user if the 
     * query was successful or an error message will be 
     * returned if it failed.   
     */
    public function updateAdminEmail($id, $data){


        //validate information before inserting into the database
        $adminId = $this->fm->clean_text($id);

        $adminEmail = $this->fm->clean_text($data["email"]);


        //check for empty input fields and return error message if any field is left empty.  
        if($adminEmail == "" ){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg; 
        } 
        //check if the email input is valid email input and if not, return an error.  
        else if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            $msg = '<p><label class="text-danger">Invalid email format.</label></p>';
            return $msg; 
        }
        //otherwise do this
        else{

            //perform a select query on the admins table with the email corresponding 
            //to the input email field and pass this to the prepare function
            $checkCredentialsAdminsTable = $this->db->link->prepare("SELECT * FROM admins
                                                                WHERE email = (?)
                                                                ");
            //pass the input to the execute function                                                   
            $checkCredentialsAdminsTable->execute([$adminEmail]);
            
            //perform a select query on the users table in the database with 
            //the email field in the user table equalling the input field email
            $checkCredentialsUsersTable = $this->db->link->prepare("SELECT * FROM users
                                                                WHERE email = (?)
                                                                "); 
            //pass the admin email field to the execute function
            $checkCredentialsUsersTable->execute([$adminEmail]);

            //if any of the queries returns more than 0 rows, return an error since the email is already in the system
            if( $checkCredentialsAdminsTable->rowCount() > 0 || $checkCredentialsUsersTable->rowCount() > 0){
                $msg = '<p><label class="text-danger">Email is already in the system.</label></p>';
                return $msg; 
            } else{
                /**
                 * perform an update query of the admin table and 
                 * set the specified fields to the users input information
                 * for the admin with the unique identification.
                 */
                $query = "UPDATE admins
                        SET email=(?)
                        WHERE id=(?)";

                //pass the query to the prepare function
                $update = $this->db->link->prepare($query);
                
                //pass the input email and admin id's to the execute function
                $update->execute([$adminEmail, $adminId]);

                //if successfully updated, return a success message to the user.  
                if($update){
                    $msg = '<p><label class="text-success">Admin email updated succesfully.</label></p>';
                    return $msg; 
                } 
                //otherwise return an error message
                else{
                    $msg = '<p><label class="text-danger">Admin email failed to update.</label></p>';
                    return $msg; 
                }
            }
        }
    }

    /**
     * Input: admins unique identifcation
     * , $data related to the post data 
     * that has the username. 
     * This function will update an admins username 
     * in the system based on the admins unique 
     * user identifcation.  Prior to updating, the 
     * form input must pass validations.  For example,
     * the form must not be empty or else an error will 
     * be displayed.  In addition, the username must have never 
     * be used in the system or else an error will be returned. 
     * Otherwise, update the username based on the admins unique 
     * id and return a success message if successful or an error
     * message if an error occurred.  
     */
    public function updateAdminUsername($id, $data){


        //validate information before inserting into the database using clean text function
        $adminId = $this->fm->clean_text($id);

        $adminUsername = $this->fm->clean_text($data["username"]);


        //check for empty input fields and return error message if any field is left empty.
        //and return error message if it is  
        if($adminUsername == "" ){
            $msg = '<p><label class="text-danger">All fields must be filled.</label></p>';
            return $msg; 
        }
        else{
            //select all the rows from the admins table where the admins username
            //field is equal to the input field and pass to the prepare function
            $checkCredentialsAdminsTable = $this->db->link->prepare("SELECT * FROM admins
                                                                WHERE username = (?)
                                                                ");
            //pass the admin username input to the execute function                                                 
            $checkCredentialsAdminsTable->execute([$adminUsername]);

            //select all the rows from the users table where the users username
            //field is equal to the input field and pass to the prepare function
            $checkCredentialsUsersTable = $this->db->link->prepare("SELECT * FROM users
                                                                WHERE username = (?)
                                                                "); 
           //pass the username to input to the execute function
           $checkCredentialsUsersTable->execute([$adminUsername]);

           //if more than one row is returned from either of the tables, return an error message 
            if( $checkCredentialsAdminsTable->rowCount() > 0 || $checkCredentialsUsersTable->rowCount() > 0){
                $msg = '<p><label class="text-danger">Username is already in the system.</label></p>';
                return $msg; 
            } else{
                /**
                 * perform an update query of the admin table and 
                 * set the specified fields to the users input information
                 * for the admin with the unique identification.
                 */
                $query = "UPDATE admins
                        SET username=(?)
                        WHERE id=(?)";

                //pass the query to the prepare function
                $update = $this->db->link->prepare($query);

                //pass the input fields to the execute function
                $update->execute([$adminUsername, $adminId]);

                //if successfully updated, return a success message to the user.  
                if($update){
                    $msg = '<p><label class="text-success">Admin username updated succesfully.</label></p>';
                    return $msg; 
                } 
                //otherwise return an error message to the user.
                else{
                    $msg = '<p><label class="text-danger">Admin username failed to update.</label></p>';
                    return $msg; 
                }
            }
        }
    }

}

?>