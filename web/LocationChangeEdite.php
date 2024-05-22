<?php
$titel = "Change Location";
$LocationChange = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'LocationChange' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$que = mysql_query("SELECT l.id, l.rec_by, l.e_date, l.c_id, c.cell, c.c_name, c.z_id, l.old_addr, l.new_addr, l.cont, l.shift_date, shift_sts FROM line_shift AS l
						LEFT JOIN clients AS c
						ON c.c_id = l.c_id
						WHERE l.id = '$id' AND l.shift_sts != 'Done'");
$rows = mysql_fetch_assoc($que);
?>
<div class="box-header">
	<div class="modal-content">
		<div class="modal-header">
			<h5>Client Line Shift Edite</h5>
		</div>
		<form id="form" class="stdform" method="POST" action="LocationChangeEditeQuery" enctype="multipart/form-data">
		<input type="hidden" name="c_id" value="<?php echo $rows['c_id'] ?>" />
		<input type="hidden" name="id" value="<?php echo $rows['id'] ?>" />
			<div class="modal-body">
				<p>	
					<label>Client Name</label>
					<span class="field"><input type="text" name="c_name" id="" required="" class="input-xxlarge" readonly value="<?php echo $rows['c_name'].' | '.$rows['cell'];?>" /></span>
				</p>
				<p>	
					<label>Zone</label>
					<select name="z_id" class="chzn-select"  style="width:540px;">		
						<?php 
					$queryd="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
					$resultd=mysql_query($queryd);
						while ($rowd=mysql_fetch_array($resultd)) { ?>			
					<option value=<?php echo $rowd['z_id'];?> <?php if ($rowd['z_id'] == $rows['z_id']) echo 'selected="selected"';?> ><?php echo $rowd['z_name'];?> (<?php echo $rowd['z_bn_name'];?>)</option>		
						<?php } ?>
					</select>
				</p>
				<p>
					<label>Old Address</label>
					<span class="field"><textarea type="text" name="old_addr" placeholder="Old Address" id="" class="input-xxlarge" readonly /><?php echo $rows['old_addr'];?></textarea></span>
				</p>
				<p>
					<label>New Address</label>
					<span class="field"><textarea type="text" name="new_addr" placeholder="New Address........" id="" class="input-xxlarge"/><?php echo $rows['new_addr'];?></textarea></span>
				</p>
				<p>
					<label>Shifting Date</label>
					<span class="field"><input type="text" name="shift_date" id="" required="" class="input-xxlarge datepicker" value="<?php echo date('Y-m-d');?>" /></span>
				</p>
				<p>
					<label>Contact</label>
					<span class="field"><input type="text" name="cont" id="" required="" class="input-xxlarge" value="<?php echo $rows['cell'];?>" /></span>
				</p>
				<p>
					<label>Status</label>
					<span class="field">
						<select data-placeholder="Choose a Status" class="chzn-select" name="shift_sts" style="width:540px;" required="" >
							<option value=""></option>
							<option value="Done" <?php if( $rows['shift_sts'] == 'Done') {echo 'selected';} ?>>Done</option>
							<option value="Done And Cable Remove" <?php if( $rows['shift_sts'] == 'Done And Cable Remove') {echo 'selected';} ?>>Done And Cable Remove</option>																												
							<option value="Pending" <?php if( $rows['shift_sts'] == 'Pending') {echo 'selected';} ?>>Pending</option>
							<option value="Not Possible" <?php if( $rows['shift_sts'] == 'Not Possible') {echo 'selected';} ?>>Not Possible</option>
						</select>
					</span>	
				</p>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn">Reset</button>
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</form>			
	</div>
</div>

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>