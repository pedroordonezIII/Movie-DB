<style>
    .dimmensions{
        max-width: 50%;
        max-height: 50%;

    }
</style>
<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>



<?php
//check if the delmovie get rquest is set
 if (isset($_GET['delmovie'])) {
	 $id = $_GET['delmovie'];
	 //delete the movie by the current id by passsing the movie id
	 //to this function.
	 $deleteMovie = $movie->deleteMovieById($id);

}  

?>

<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Movies</h1>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-12">
				<h2>Movie List</h2>
                <div class="table-responsive">     
				<?php	
		//display the message 
         if (isset($deleteMovie)) {
         	echo  $deleteMovie;
         }
          ?>

            <?php
            $selectMovies = $movie->selectAllMovies();     
            if ($selectMovies) {
            ?>
            <table class="table table-striped" id="example">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Rating</th>
					<th>Rank</th>
					<th>Runtime</th>
					<th>Release Date</th>
					<th>Summary</th>
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
				<tr class="odd gradeX">
					<td><?php echo $i; ?></td>
					<td><?php echo $format->textShorten($result['title'], 30);?></td>
					<td><?php echo $result['rating'];?></td>
					<td><?php echo $result['rank'];?></td>
                    <td><?php echo $result['runtime'];?></td>
                    <td><?php echo $result['release_date'];?></td>
				    <td><?php echo $format->textShorten($result['summary'], 30);?></td>
					<td><img src="<?php echo $result['image'];?>" class="dimmensions"></td>
					<td>
            <a class="btn btn-outline-success my-2 my-sm-0" href="editmovie.php?movieid=<?php echo $result['id']; ?>">Edit</a> 
								|| <a class="btn btn-outline-success my-2 my-sm-0" onclick="return confirm('Are you sure to delete')"
								 href="?delmovie=<?php echo $result['id']; ?>">Delete</a></td>
				</tr>
				 <?php  } ?>
				
				 
			</tbody>
		</table>
        <?php } else{?>
        <p>No movies currently in the system.</p>
        <?php }?>
               </div>
              </div>
            </div>
          </div>  
        </main>

    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

<?php include 'inc/footer.php';?>