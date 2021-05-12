

<?php

class Request{


    /**
     * 
     */
    public function checkId(){
        if (!isset($_GET['proid'])  || $_GET['proid'] == NULL ) {
            echo "<script>window.location = '404.php';  </script>";
        }
        else {
            return $id = $_GET['proid'];
        }
    }


}


?>