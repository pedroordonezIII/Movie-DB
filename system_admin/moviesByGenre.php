<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php  

    if(!isset($_GET["genreid"]) || $_GET["genreid"] == "NULL"){
        header("viewgenres.php");
    }
    else{
        $genreId = $_GET["genreid"]; 
    }

    if(isset($_GET["movieid"])){

        $genreId = $_GET["genreid"];

        $movieId = $_GET["movieid"]; 

        $deleteMovieGenre = $genre->deleteMovieGenre($movieId, $genreId); 
    }

?>

<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Movies</h1>
          </div>
          <div class="container">
              <div class="row">
              <?php 
                  if(isset($deleteMovieGenre)){
                      echo $deleteMovieGenre;
                  }
            ?>
                <div class="col-12">
                <?php 
                $genreName = $genre->selectGenreById($genreId);

                if($genreName){
                $result = $genreName->fetch();
                ?>
				<h2><?php echo $result["name"]?> Movies</h2>
                <?php }?>
                <div class="table-responsive">     
                <?php
                    $selectMovies = $movie->selectMovieByGenreId($genreId);     
                    if ($selectMovies) {
                ?> 
                    <table class="table table-striped" id="example">
					<thead>
						<tr>
                        <th>#</th>
					        <th>Title</th>
			                <th>Image</th>
                            <th>Action</th>
						</tr>
					</thead>
					<tbody>
                    <?php 
			            //post number
           	            $i = 0;
			            //fetch assoc array for all table items
          	            while ($result = $selectMovies->fetch() ) {
          	            $i++;//increment
                        ?>
				            <tr class="">
					            <td><?php echo $i; ?></td>
					            <td><?php echo $result['title'];?></td>
					            <td><img src="<?php echo $result['image'];?>" class="dimmensions"></td>
                                <td><a class="btn btn-outline-success my-2 my-sm-0" onclick="return confirm('Are you sure you want to delete movie from category?')" 
								href="?genreid=<?php echo $genreId;?>&movieid=<?php echo $result["movie_id"];?>">Delete</a></td>
				            </tr>
				     <?php  } ?>	
						 
					</tbody>
				</table>
                <?php } else{?>
                    <?php if($genreName){?>
                    <p>No <?php echo $result["name"] ?> movies currently in the system.</p>
                    <?php }else{?>
                    <p>Genre does not exist.</p>
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