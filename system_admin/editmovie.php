
<?php include("inc/header.php")?>
<?php include("inc/sidebar.php")?>

<?php

if(!isset($_GET["movieid"]) || $_GET["movieid"] == "NULL"){
    echo "<script>window.location = 'viewmovies.php'; </script>";
} else{
    $movieId = $_GET["movieid"];
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
    $updateMovie = $movie->updateMovieById($_POST, $_FILES, $movieId);
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
                    if(isset($updateMovie)){
                        echo $updateMovie;
                    }
                ?>  
                <?php
                $selectMovie = $movie->selectMovieById($movieId); 

                if($selectMovie){
                    while($result = $selectMovie->fetch()){
                ?>        
              <form action=" "  method="post" enctype="multipart/form-data">   
                    <table class = "table container center table-bordered  bg-light align-middle">
                        <tr>
                            <td colspan="2"> <h2 id="center">Edit Movie</h2> </td>   
                        </tr>
                        <tr>
                            <td width="20%"> Title  </td>  
                            <td> <input class="form-control" type="text" name="title" value="<?php echo $result["title"];?>"> </td>
                        </tr>
                        <tr>
                            <td> Rank </td>
                            <td> <input class="form-control" type="text" name="rank" value="<?php echo $result["rank"];?>">  </td>
                        </tr>
                        <tr>
                            <td> Rating  </td>
                            <td><input class="form-control" type="text" name="rating" value="<?php echo $result["rating"];?>">  </td>
                        </tr>
                        <tr>
                            <td>Release Date</td> 
                            <td> <input class="form-control" type="date" name="release" value="<?php echo $result["release_date"];?>">  </td>
                        </tr>
                        <tr>
                            <td> Runtime  </td> 
                            <td> <input class="form-control" type="text" name="runtime" value="<?php echo $result["runtime"];?>" > </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Upload Image</label>
                            </td>
                            <td>
                                <input type="file" name="image" /></br>
                                <img src="<?php echo $result['image']?>" height="75px; width="100px;">
                            </td>
                        </tr>
                        <tr>
                        <td> Summary </td> 
                        <td> <textarea class="form-control" rows="8" type="text" name="summary">
                        <?php echo $result["summary"];?>
                        </textarea></td>
                        </tr>
                        <tr>
                          <td> </td>
                            <td><input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Save"> </td>
                        </tr>
                    </table>
                </form>
                <?php }}?>
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