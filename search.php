<?php include 'inc/pageheader.php'; ?>

<?php
//check if the search get request is set and if it not, send to the 404 page
 if (!isset($_POST['search'])  || $_POST['search'] == NULL ) {
    echo "<script>window.location = '404.php';  </script>";
 }else {
   //set the search variable to the search value
   $search = $_POST['search'];

 }

?>




<div id="message" class="main content_style">
   <div class="content">
       <div class="content_top">
           <div class="heading">
           <h1 id="center">Showplace Movie Database</h1> 
           <h3>Movie Search</h3>
            </div>
           <div class="clear"></div>
       </div>
         <div class="row"">

         <?php
         //retrieve the products matching the corresponding search 
         //by accessing the productBySearch function
         $movieSearch = $movie->searchContent($search); 
          if ($movieSearch) {
            //iterate through all the result rows 
           while ($result = $movieSearch->fetch()) {
          
         ?>
               <div class="col-sm border border-success">
                        <a  onClick="details('<?php echo $result['movieID'];?>')" >
                        <img src="<?php echo "system_admin/".$result['image']; ?>" class="img-fluid img-thumbnail" width="200px"alt="" /></a>
                        <p><span class=""><?php echo $result['title']; ?></span></p>
                        <p><span class=""><?php echo $result['rank']; ?></span></p>
                    <div class="button"><span><a class="btn btn-outline-success my-2 my-sm-0"  onClick="details('<?php echo $result['movieID'];?>')" class="details">Details</a></span></div>
               </div>
                <?php  } } else { ?>
                       <p>Products for this search are not available.</p>
               <?php } ?>
                
               </div>
           </div>

   
   
   </div>
</div>
</div>
  <?php include 'inc/footer.php'; ?>