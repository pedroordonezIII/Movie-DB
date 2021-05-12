<?php include 'inc/pageHeader.php'; ?>

<script type="text/javascript">
//categories function will be called
//to asynchronously load pages
function categories(id) {
	//console.log($("#movieid").val());
    jQuery.ajax({
      url: "moviesByCategory.php",
	  data:'categoryId='+ id,
      type: "GET",
	  cache: false,
      success: function(data)
        {
      $("body").html(data);
        },
        error: function() 
        {}           
     });
	}
</script>

<div class="row table-responsive">
        <div class="col-sm">
            <table class="table table-bordered border-success style_margin table_style2">
                <tr>
                    <td colspan="3"> <h3>Categories</h3></td>
                </tr>
                <?php 
                    $selectCategories = $category->selectCategories();
                    if($selectCategories){
                        while($result = $selectCategories->fetch()){
                ?>
                <tr>
                <td>
                    <div>
				        <input type="button"  onClick="categories('<?php echo $result['id'];?>')" id="details" 
                        class="btn btn-outline-success my-2 my-sm-0" value="<?php echo $result['name'];?>" class="btnSubmit" />
			        </div>
                </td>
                </tr>
                <?php } } else{?>
                    <tr>
                    <td>No categories in the system.</td>
                    </tr>
                <?php }?>
            </table>
         </div>
    </div>
</div>
</div>
<?php include 'inc/footer.php'; ?>