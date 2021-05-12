<?php 
//include the real file path and pass that to the 
//include once built in function to include the config file.  
$filepath = realpath(dirname(__FILE__));
include_once($filepath.'/../config/config.php');
 
?>

<?php 
/*
This class will be needed to create the database. 
The class will connect to the databse using information
from the config file.
*/
 class Database {

//initialize all attributes from the config file 
//that will allow the user to connect to the database
public $host = DB_HOST;
public $user = DB_USER;
public $pass = DB_PASS;
public $dbname = DB_NAME;
public $charset = DB_CHARSET;

//intialize attribute that links the user to the database
 public $link;
 //initialize attribute for errors when connecting to the database
 public $error;

   //automatically create constructor when calling
   //class on object instance
   public function __construct(){
      //call the connectDb method upon instantiating
      //the class
   	$this->connectDB();
   }

   /**
    * this function will connect to the database and set the link attribute
    to the database connection in the class
    */
   public function connectDB(){
      //specify the information from the config file
       $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        /*
        set the link attribute to the database connection
        */
        $this->link = new PDO($dsn, $this->user, $this->pass, $opt);  
   }
 }