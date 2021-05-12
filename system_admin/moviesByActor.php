<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php  

    if(!isset($_GET["actorid"]) || $_GET["actorid"] == "NULL"){
        echo "<script>window.location = viewactors.php</script>";
    }
    else{
        $actorId = $_GET["actorid"]; 
    }

    if(isset($_GET["movieid"])){

        $actorId = $_GET["actorid"];

        $movieId = $_GET["movieid"]; 

        $deleteRole = $actor->deleteActorRole($movieId, $actorId); 
    }

?>

<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Actors</h1>
          </div>
          <div class="container">
              <div class="row">
                  <?php 
                  if(isset($deleteActorRole)){
                      echo $deleteActorRole;
                  }
                  ?>
                <div class="col-12">
                <?php 
                $selectActor = $actor->selectActorById($actorId);

                if($selectActor){
                $result = $selectActor->fetch();
                ?>
				<h2><?php echo $result["first_name"]?> <?php echo $result["last_name"]?> Movies</h2>
                <?php }?>
                <div class="table-responsive">     
                <?php
                    $actorMovies = $actor->selectActorMovies($actorId);
                    if($actorMovies){
                ?> 
                    <table class="table table-striped" id="example">
					<thead>
						<tr>
                        <th>#</th>
					        <th>Role</th>
			                <th>Movie Title</th>
                            <th>Image</th>
                            <th>Action</th>
						</tr>
					</thead>
					<tbody>
                    <?php 
			            //post number
           	            $i = 0;
			            //fetch assoc array for all table items
          	            while ($result = $actorMovies->fetch() ) {
          	            $i++;//increment
                        ?>
				            <tr class="">
					            <td><?php echo $i; ?></td>
					            <td><?php echo $result['role'];?></td>
                                <td><?php echo $result['title'];?></td>
					            <td><img src="<?php echo $result['image'];?>" class="dimmensions"></td>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" onclick="return confirm('Are you sure you want to delete movie from category?')" 
								href="?actorid=<?php echo $actorId;?>&movieid=<?php echo $result["movie_id"];?>">Delete</a> ||
                                <a class="btn btn-outline-success my-2 my-sm-0" href="editrole.php?actorid=<?php echo $actorId;?>&movieid=<?php echo $result["movie_id"];?>">
                                Edit Role</a></td>
				            </tr>
				     <?php  } ?>	
						 
					</tbody>
				</table>
                <?php } else{?>
                    <?php if($selectActor){?>
                    <p><?php echo $result["first_name"]?> <?php echo $result["last_name"]?> currently has no movies in the system.</p>
                <?php } else{?>
                    <p>Actor is not present in the system.</p>
                <?php }}?>
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