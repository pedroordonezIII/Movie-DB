<?php include 'inc/pageHeader.php'; ?>

<?php 

?>


<?php 
 

?>

<div class="row table-responsive">
        <div class="col-sm">
            <table class="table table-bordered border-success style_margin table_style2">
                <tr>
                    <td colspan="3"> <h3>Directors</h3></td>
                </tr>
                <?php 
                    $selectDirectors = $director->selectDirectors();
                    if($selectDirectors){
                        while($result = $selectDirectors->fetch()){
                ?>
                <tr>
                <td>
                    <div>
				        <input type="button"  onClick="directors('<?php echo $result['id'];?>')" id="details" 
                        class="btn btn-outline-success my-2 my-sm-0" value="<?php echo $result['first_name'];?> <?php echo $result['last_name'];?>" class="btnSubmit" />
			        </div>
                </td>
                </tr>
                <?php } } else{?>
                    <tr>
                    <td>No directors in the system.</td>
                    </tr>
                <?php }?>
            </table>
         </div>
    </div>
</div>
</div>
<?php include 'inc/footer.php'; ?>