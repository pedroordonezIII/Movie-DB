<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php 

    if(isset($_GET["delcat"])){

        $catId = $_GET["delcat"]; 

        $deleteCategory = $category->deleteCategory($catId); 
    }

?>

<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Categories</h1>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-12">
				<h2>Category List</h2>
                <div class="table-responsive">     
					<?php

					if(isset($deleteCategory)){
						echo $deleteCategory;
					}
					?>   
                    <table id="example" class="table container center table-bordered  bg-light align-middle">
					<thead>
						<tr>
							<th>#</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
                    <?php
                    $categoryList = $category->selectCategories();

                    $i = 0; 
                    if($categoryList){

                        while($result = $categoryList->fetch()){
                        $i++; 
                    ?>

						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $result["name"];?></td>
							<td><a class="btn btn-outline-success my-2 my-sm-0" href="editcategory.php?catid=<?php echo $result["id"]?>">Edit</a> 
								|| <a class="btn btn-outline-success my-2 my-sm-0" onclick="return confirm('Are you sure you want to delete')" 
								href="?delcat=<?php echo $result["id"];?>">Delete</a> || 
                                <a class="btn btn-outline-success my-2 my-sm-0" href="moviesByCategory.php?categoryid=<?php echo $result["id"]?>">View Movies</a></td>
						</tr>

						<?php } }?>
						 
					</tbody>
				</table>
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