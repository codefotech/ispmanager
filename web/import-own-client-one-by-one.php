<?php 
include("conn/connection.php");
$z_id = isset($_GET['z_id']) ? $_GET['z_id'] : ''; 
$mk_id = isset($_GET['mk_id']) ? $_GET['mk_id'] : ''; 

if($z_id != ''){
?>
<input type="hidden" name="mk_id" id="mk_id" value="<?php echo $mk_id;?>"/>
<input type="hidden" name="z_id" id="z_id" value="<?php echo $z_id;?>"/>
<button class="btn ownbtn4" type="submit" style="float: right;margin-right: 15px;">Submit</button>
<?php } else{} ?>