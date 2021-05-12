<?php include 'inc/pageHeader.php'; ?>

<?php 

?>


<?php 
 

?>

<div class="row table-responsive">
        <div class="col-sm">
            <table class="table table-bordered border-success style_margin table_style2">
                <tr>
                    <td colspan="3"> <h3>Actors</h3></td>
                </tr>
                <?php 
                    $selectActors = $actor->selectActors();
                    if($selectActors){
                        while($result = $selectActors->fetch()){
                ?>
                <tr>
                <td>
                    <div>
				        <input type="button"  onClick="actors('<?php echo $result['id'];?>')" id="details" 
                        class="btn btn-outline-success my-2 my-sm-0" value="<?php echo $result['first_name'];?> <?php echo $result['last_name'];?>" class="btnSubmit"></input>
			        </div>
                </td>
                </tr>
                <?php } } else{?>
                    <tr>
                    <td>No actors in the system.</td>
                    </tr>
                <?php }?>
            </table>
         </div>
    </div>
</div>
</div>
<?php include 'inc/footer.php'; ?>