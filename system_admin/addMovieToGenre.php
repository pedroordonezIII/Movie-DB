<?php include("inc/header.php")?>
<?php include("inc/sidebar.php")?>

<?php
//check for the post rquest 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
    //set the data equal to the data in the post array
    $movieId = $_POST["movieId"]; 
    $genreId = $_POST["genreId"]; 

    //pass the values to the insert movie genre method 
    //in the genre object instantiation. 
    $insertMovieGenre = $genre->insertMovieGenre($movieId, $genreId);
}
?>

<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Genres</h1>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-12">
				
                <div class="table-responsive">     
				<?php
                    if(isset($insertMovieGenre)){
                        echo $insertMovieGenre;
                    }
                ?>          
              <form action=" "  method="post" enctype="multipart/form-data">   
                    <table class = "table container center table-bordered  bg-light align-middle">
                        <tr>
                            <td colspan="2"> <h2 id="center">Insert Movie Genre</h2> </td>   
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
                                <label>Genres</label>
                            </td>
                            <td>
                                <select class="form-control" id="select" name="genreId">
                                    <?php
                                    //create a new category obe=ject
                                    //$genre = new Genre(); 
                                    //access the getALlCat method to get all categories
                                    $selectGenres = $genre->selectGenres(); 
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