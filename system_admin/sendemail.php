<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>


<?php
if(isset($_GET["messageid"])){

    $messageid = $_GET["messageid"];

    $selectMessage = $message->selectMessageById($messageid); 
}
?>

<?php

if(isset($_POST['submit'])){

    $sendEmail = $message->sendEmail($_POST);

}
?>
<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Email Option</h1>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-12">
                <div class="table-responsive card border-dark mb-3">
                <?php 
                    if(isset($sendEmail)){
                        echo $sendEmail;
                        //print_r($sendEmail);
                    }
                ?>
                    <?php 
                    $adminName= Session::get("adminName");

                    if(isset($selectMessage)){
                        while($result = $selectMessage->fetch()){
                    ?>
                    <form action=" "  method="post" enctype="multipart/form-data">   
                    <table class = "table container center table-bordered  align-middle">
                        <tr>
                            <td colspan="2"> <h2>Send Email</h2> </td>   
                        </tr>
                        <tr>
                            <td width="20%"> Name  </td>  
                            <td> <input class="form-control" type="text" name="name" value="<?php echo $adminName;?>"> </td>
                        </tr>
                        <tr>
                            <td> Recipient Email  </td>
                            <td> <input class="form-control" type="text" name="email" value="<?php echo $result["email"];?>">  </td>
                        </tr>
                        <tr>
                            <td> Subject  </td>
                            <td> <input class="form-control" type="text" name="subject" value="<?php echo $result["subject"];?>">   </td>
                        </tr>
                        <tr>
                            <td> Message </td>
                            <td> <textarea class="form-control" rows="8" type="text" name="message">
                            <?php echo $result["message"];?>
                            </textarea></td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td><input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Send Email"> </td>
                        </tr>
                        </table>
                    </form>
                    <?php }} else{?>
                    <p>No message.</p>
                    <?php }?>
                </div>
              </div>
            </div>
          </div>  
        </main>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../../../assets/js/vendor/popper.min.js"></script>
    <script src="../../../../dist/js/bootstrap.min.js"></script>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
<?php include 'inc/footer.php';?>