<?php
    include("../classes/Admin.php");
    $admin = new Admin();
?>

<?php
  //check if there is a post method request
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["register"])) {
	//now check the login credentials by calling the adminLogin method
	//from the object

	$registration = $admin->registerAdmin($_POST);

    }
    //will only return the loginmsg if an error occurs
    if(isset($registration)){
        //echo the login checl
        echo $registration; 
    }
  ?>