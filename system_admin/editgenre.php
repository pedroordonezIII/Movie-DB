<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 

    if(!isset($_GET["genreid"]) || $_GET["genreid"] == "NULL"){
        echo "<script>window.location = 'viewgenres.php'; </script>";
    } else{
        $genreId = $_GET["genreid"];
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
        $genreName = $_POST["genreName"]; 
        $updateGenre = $genre->updateGenreById($genreId, $genreName); 

    }

?>

<main role="main" class="col-7 col-sm-8 col-lg-9 ml-sm-auto pt-3 px-4"> 
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap 
          align-items-center pb-2 mb-3 border-bottom">
          <h1 class="h2">Genres</h1>
          </div>
          <div class="container">
              <div class="row table-responsive">
                <div class="col-12">
                <h2></h2>
                <?php 
                        if(isset($updateGenre))
                            echo $updateGenre; 
                        ?>
              <?php
                $selectGenre = $genre->selectGenreById($genreId); 

                if($selectGenre){
                    while($result = $selectGenre->fetch()){
                 
                ?>
                <form action=" "  method="post">   
                    <table class = "table container center table-bordered  bg-light align-middle">
                    <tr>
                        <td colspan="2"> <h2 id="center">Edit Genre</h2> </td>   
                    </tr>
                    <tr>
                        <td width="20%">Genre</td>  
                        <td> <input class="form-control" type="text" name="genreName" placeholder="<?php echo $result["name"];?>" class="medium" > </td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td><input class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit" value="Save"> </td>
                    </tr>
                    </table>
                </form>
                <?php }} ?>
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