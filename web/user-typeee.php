<?php
include("conn/connection.php") ;
$typeid = $_GET['typeid'];

$sqlc1 = mysql_query("SELECT * FROM user_typ WHERE id = '$typeid'");
$rowc1 = mysql_fetch_assoc($sqlc1);

if($rowc1['id'] != ''){
?>
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="idaa" value="<?php echo $rowc1['id'];?>" />
	<input type="hidden" name="old_u_type" value="<?php echo $rowc1['u_type'];?>" />
	<input type="hidden" name="typ" value="UserTypeEdit" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Edit User Type Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Type Name:</div>
						<div class="col-2"><input type="text" name="u_type" id="" value="<?php echo $rowc1['u_type'];?>" placeholder="Ex: Suppoer, Manager etc" class="input-large" required=""/></div>
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

