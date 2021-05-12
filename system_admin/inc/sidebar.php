<style>
    .margin {
    margin-top: 10;
    }
   
    .containerHeight{
        height: 100vh;
    }

</style>
<div class="container-fluid">
      <div class="row containerHeight">
        <nav class="col-5 col-sm-4 col-lg-3 d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                  
                <a class="nav-link active text-dark" href="dashboard.php">
                  <span data-feather="home"></span>Dashboard <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item margin">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Category Option
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="addcategory.php">Add Category</a>
                        <a class="dropdown-item" href="viewcategories.php">Category List</a>
                        <a class="dropdown-item" href="addMovieToCategory.php">Add Movie to Category</a>
                    </div>
                </div>
              </li>
              <li class="nav-item margin">
              <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Genre Option
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="addgenre.php">Add Genre</a>
                        <a class="dropdown-item" href="viewgenres.php">Genre List</a>
                        <a class="dropdown-item" href="addMovieToGenre.php">Add Movie to Genre</a>
                    </div>
                </div>
              </li>
              <li class="nav-item margin">
              <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" 
                    aria-haspopup="true" aria-expanded="false">
                    Actor Option
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="addactor.php">Add Actor</a>
                        <a class="dropdown-item" href="viewactors.php">Actor List</a>
                        <a class="dropdown-item" href="addrole.php">Add Actor Role</a>
                    </div>
                </div>
              </li>
              <li class="nav-item margin">
              <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Director Option
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="adddirector.php">Add Director</a>
                        <a class="dropdown-item" href="viewdirectors.php">Director List</a>
                        <a class="dropdown-item" href="addMovieToDirector.php">Add Movie to Director</a>
                    </div>
                </div>
              </li>
              <li class="nav-item margin">
              <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Movie Option
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="addmovie.php">Add Movie</a>
                        <a class="dropdown-item" href="viewmovies.php">Movie List</a>
                    </div>
                </div>
              </li>
            </ul>
            </div> 
        </nav> 
