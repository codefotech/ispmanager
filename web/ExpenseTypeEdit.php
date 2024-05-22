<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$e_id = $_GET['e_id'];
$ex_id = $_GET['ex_id'];

$sql1z1 = mysql_query("SELECT id, ex_type, ex_des FROM `expanse_type` WHERE status = '0' AND id = '$ex_id'");
$rowwz = mysql_fetch_array($sql1z1);

if($e_id != '' || $ex_id != ''){
?>
	<form id="form2" class="stdform" method="post" action="ExpanseHeadSave">
	<input type="hidden" name="ex_id" value="<?php echo $ex_id;?>" />
	<input type="hidden" name="edit_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="old_expence_type" value="<?php echo $rowwz['ex_type'];?>" />
	<input type="hidden" name="wayyy" value="edit_type" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5" style="font-weight: bold;color: #f55;font-size: 17px;">Edit Expence Type</h5>
			</div>
			<div class="modal-body">
				<div class="row">
						<div class="popdiv">
							<div class="col-1">Expense Type</div>
							<div class="col-2"><input type="text" name="ex_type" required="" value="<?php echo $rowwz['ex_type'];?>" class="input-xlarge" placeholder="Ex: Mobile Bill" /></div>
						</div>
						<div class="popdiv">
							<div class="col-1">Type Discription</div>
							<div class="col-2"><input type="text" name="ex_des" value="<?php echo $rowwz['ex_des'];?>" class="input-xlarge" placeholder="Discription" /></div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="submit">Proceed</button>
			</div>
		</div>
	</div>	
	</form>	
<?php } else{echo 'Something wrong!!!';}?>