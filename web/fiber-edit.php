<?php
include("conn/connection.php") ;
$p_id = $_GET['p_id'];

$sqlc1 = mysql_query("SELECT id, pro_name, pro_details FROM fiber WHERE id = '$p_id'");
$rowc1 = mysql_fetch_assoc($sqlc1);
$pp_id = $rowc1['id'];
$pro_name = $rowc1['pro_name'];
$pro_details = $rowc1['pro_details'];

if($pp_id != ''){
?>
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="p_id" value="<?php echo $pp_id;?>" />
	<input type="hidden" name="typ" value="fiberedit" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Edit Fiber Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Fiber Name:</div>
						<div class="col-2"><input type="text" name="pro_name" id="" value="<?php echo $pro_name;?>" placeholder="Ex: CAT-5, 4-CORE etc" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Fiber Details:</div>
						<div class="col-2"><input type="text" name="pro_details" id="" value="<?php echo $pro_details;?>" placeholder="" class="input-large" required=""/></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
<?php } else{echo 'Something wrong!!!';}?>