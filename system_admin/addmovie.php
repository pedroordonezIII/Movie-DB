<?php include("inc/header.php")?>
<?php include("inc/sidebar.php")?>

<?php
//check if the post request is set
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){

    //call the insert movie function in the movie object instant 
    //and pass the post array and file array.
    $insertMovie = $movie->insertMovie($_POST, $_FILES);
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
				
                <div class="table-responsive">     
				<?php
                //check if the variable is set and echo it
                    if(isset($insertMovie)){
                        echo $insertMovie;
                    }
                ?>          
              <form action=" "  method="post" enctype="multipart/form-data">   
                    <table class = "table container center table-bordered  bg-light align-middle">
                        <tr>
                            <td colspan="2"> <h2 id="center">Add Movies</h2> </td>   
                        </tr>
                        <tr>
                            <?php 
                                if(isset($addMovie)){
                                echo $addMovie; 
                                }
                            ?>
                            <td width="20%"> Title  </td>  
                            <td> <input class="form-control" type="text" name="title" value="<?php $title;?>"> </td>
                        </tr>
                        <tr>
                            <td> Rank </td>
                            <td> <input class="form-control" type="text" name="rank" value="<?php $rank;?>">  </td>
                        </tr>
                        <tr>
                            <td> Rating  </td>
                            <td><input class="form-control" type="text" name="rating" value="<?php $rating;?>">  </td>
                        </tr>
                        <tr>
                            <td>Release Date</td> 
                            <td> <input class="form-control" type="date" name="release" value="<?php $release;?>">  </td>
                        </tr>
                        <tr>
                            <td> Runtime  </td> 
                            <td> <input class="form-control" type="text" name="runtime" value="<?php $runtime;?>" > </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Category</label>
                            </td>
                            <td>
                                <select class="form-control" id="select" name="categoryId">
                                    <?php
                                    //create a new category obe=ject
                                    $category = new Category(); 
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
                            <td>
                                <label>Genre</label>
                            </td>
                            <td>
                                <select class="form-control" id="select" name="genreId">
                                    <?php
                                    //create a new category obe=ject
                                    $category = new Genre(); 
                                    //access the getALlCat method to get all categories
                                    $selectGenres = $category->selectGenres(); 
                                    //if return
                                    if($selectGenres){
                                        //get all rows and convert to associateve array
                                        while($result = $selectGenres->fetch()){
                                    ?>
                                    <option value="<?php echo $result['id'];  ?>"><?php echo $result['name']; ?></option>

                                    <?php   }  } ?>
                            
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Upload Image</label>
                            </td>
                            <td>
                                <input type="file" name="image" />
                            </td>
                        </tr>
                        <tr>
                        <td> Summary </td> 
                        <td> <textarea class="form-control" rows="8" type="text" name="summary" value="<?php $summary;?>">
                        </textarea></td>
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