<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php

//check if the delmessid get request is set
if(isset($_GET["delmessid"])){
	$messageId = $_GET["delmessid"]; 

	//delete the message by passing the message id to the 
	//deleteusermessage function
	$deleteMessage = $message->deleteUserMessage($messageId);
}
?>

<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Message Inbox</h1>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-12">
				<h2>Inbox</h2>
                <div class="table-responsive">  
				<?php

					if(isset($deleteMessage)){
						echo $deleteMessage;
					}
					?>      
					<?php
					$selectMessages = $message->selectMessages();
					if($selectMessages){
						$i = 0; 
						while($result = $selectMessages->fetch()){
						$i++;
					?>
                    <table id="example" class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Subject</th>
							<th>Message</th>
							<th>email</th>
							<th>username</th>
							<th>Action</th>
						</tr>
					</thead> 
					<tbody>
						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $result["f_name"];?></td>
							<td><?php echo $result["l_name"];?></td>
							<td><?php echo $format->textShorten($result["subject"], 20);?></td>
							<td><?php echo $format->textShorten($result["message"], 20);?></td>
							<td><?php echo $result["email"];?></td>
							<td><?php echo $result["username"];?></td>
							<td><a class="btn btn-outline-success my-2 my-sm-0" href="viewmessage.php?messageid=<?php echo $result["id"]?>">View</a> || <a class="btn btn-outline-success my-2 my-sm-0" href="?delmessid=<?php echo $result["id"]?>">Delete</a></td>
						</tr>
					</tbody>
				</table>
					<?php } } else {?>
						<p>No messages to show.</p>
					<?php }?>
               </div>
              </div>
            </div>
          </div>  
        </main>
	<script type="text/javascript">
        $(document).ready(function() {
    		$('#example').DataTable();
			} );
    </script>
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