<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php
//check for message get request
if(isset($_GET["messageid"])){
    //set message id variable
    $messageId = $_GET["messageid"]; 

    //retrieve the message by the id from the contact table.
    $selectMessage = $message->selectMessageById($messageId); 
}


?>




<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Message Options</h1>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-12">
                <div class="table-responsive card border-dark mb-3">
                <?php 
                 if(isset($selectMessage)){
                    while($result = $selectMessage->fetch()){
                ?>
                <table class="table container center table-bordered  align-middle">
                <tr>
                    <td colspan="3"> <h2> Message Details </h2> </td>
                </tr>
                <tr>
                    <td width="20%"> First Name  </td>
                    <td width="5%"> : </td>
                    <td><?php echo $result["f_name"];?></td>
                </tr>
                <tr>
                    <td> Last Name  </td>
                    <td> : </td>
                    <td><?php echo $result["l_name"];?></td>
                </tr>
                <tr>
                    <td> Subject  </td>
                    <td> : </td>
                    <td><?php echo $result["subject"]; ?></td>
                </tr>
                <tr>
                    <td> Message  </td>
                    <td> : </td>
                    <td><?php echo $result["message"];?> </td>
                </tr>
                <tr>
                    <td> Email  </td>
                    <td> : </td>
                    <td> <?php echo $result["email"];?> </td>
                </tr>
                <tr>
                    <td> Username  </td>
                    <td> : </td>
                    <td><?php echo $result["username"];?></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>  </td>
                    <td>
                    <a class="btn btn-outline-success my-2 my-sm-0"
                    href="sendemail.php?messageid=<?php echo $result["id"];?>" role="button">Reply</a>
                    </td>
                </tr>
                </table>
                <?php } } else{?>
                <p>No message to display.</p>
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
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>