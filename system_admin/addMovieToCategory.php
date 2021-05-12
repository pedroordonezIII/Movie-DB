<?php include("inc/header.php")?>
<?php include("inc/sidebar.php")?>

<?php
//check if the post request occurred
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
    //access the movie id and category id from the 
    //post data array and set the values equal to the variables
    $movieId = $_POST["movieId"]; 
    $categoryId = $_POST["categoryId"]; 

    //pass the movie id and category id to the insertmoviecategory
    //function in the category table to insert the category to the movie
    $insertMovieCategory = $category->insertMovieCategory($movieId, $categoryId);
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
				
                <div class="table-responsive">     
				<?php
                //print variable value if set
                    if(isset($insertMovieCategory)){
                        echo $insertMovieCategory;
                    }
                ?>          
              <form action=" "  method="post" enctype="multipart/form-data">   
                    <table class = "table container center table-bordered  bg-light align-middle">
                        <tr>
                            <td colspan="2"> <h2 id="center">Insert Movie Category</h2> </td>   
                        </tr>
                        <tr>
                            <td>
                                <label>Movies</label>
                            </td>
                            <td>
                                <select class="form-control" id="select" name="movieId">
                                    <?php
                                    //access the getALlCat method to get all categories
                                    $selectMovies = $movie->selectAllMovies(); 
                                    //if return
                                    if($selectMovies){
                                        //get all rows and convert to associateve array
                                        while($result = $selectMovies->fetch()){
                                    ?>
                                    <option value="<?php echo $result['id'];  ?>"><?php echo $result['title']; ?></option>

                                    <?php   }  } ?>
                            
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Categories</label>
                            </td>
                            <td>
                                <select class="form-control" id="select" name="categoryId">
                                    <?php
                                    //create a new category obe=ject
                                    //$category = new Category(); 
                                    //access the getALlCat method to get all categories
                                    $selectCategories = $category->selectCategories(); 
                                    //if return
                                    if($selectCategories){
                                        //get all rows and convert to associateve array
                                        while($result = $selectCategories->fetch()){
                                    ?>
                                    <option value="<?php echo $result['id'];  ?>"><?php echo $result['name']; ?></option>

                                    <?php   }  } ?>
                            
                                </select>
                            </td>
                        </tr>
                        <tr>
                          <td> </td>
                            <td><input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Save"> </td>
                        </tr>
                    </table>
                </form>
               </div>
              </div>
            </div>
          </div>  
        </main>
    <!-- Bootstrap core JavaScript
    ================================================== --
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>
<?php include 'inc/footer.php';?>