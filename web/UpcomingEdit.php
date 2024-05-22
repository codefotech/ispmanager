<?php
$titel = "Upcoming Edit";
$Upcoming = 'active';
include('include/hader.php');
$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Upcoming' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql = ("SELECT u.id, u.schedule_id, u.rcv_by, e.e_name, u.rcv_date_time, u.z_id, z.z_name, u.c_name, u.address, u.cell, u.p_id, p.p_name, u.otc, u.setup_date, u.previous_isp, u.note, u.current_status, u.line_up_date FROM upcoming AS u
			LEFT JOIN emp_info AS e
			ON e.e_id = u.rcv_by
			LEFT JOIN zone AS z
			ON z.z_id = u.z_id
			LEFT JOIN package AS p
			ON p.p_id = u.p_id
			WHERE u.id = '$id' AND u.sts = '0'");
		
$query = mysql_query($sql);
$row = mysql_fetch_assoc($query);
		$id= $row['id'];
		$schedule_id= $row['schedule_id'];
		$rcv_by= $row['e_name'];
		$rcv_date_time = $row['rcv_date_time'];
		$cont_per_name = $row['cont_per_name'];
		$z_id= $row['z_id'];
		$z_name= $row['z_name'];
		$c_name= $row['c_name'];
		$address= $row['address'];
		$cell= $row['cell'];
		$p_id= $row['p_id'];
		$otc= $row['otc'];
		$setup_date= $row['setup_date'];
		$previous_isp= $row['previous_isp'];
		$note= $row['note'];
		$line_up_date = $row['line_up_date'];
		$current_status= $row['current_status'];
?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Upcoming"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Edit Upcoming Client</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Upcoming Client Informations</h5>
				</div>
				<form class="stdform" method="post" action="UpcomingEditQuery" name="form">
					<input type="hidden" name="schedule_id" value="<?php echo $schedule_id;?>" />
					<input type="hidden" name="id" value="<?php echo $id;?>" />
					<input type="hidden" name="update_by" value="<?php echo $e_id;?>" />
					<div class="modal-body">
								<p>	
									<label>Zone*</label>
									<select name="z_id" class="chzn-select"  style="width:540px;">	
										<option>Choose Zone</option>									
										<?php 
											$queryd="SELECT z_id, z_name, z_bn_name FROM zone";
											$resultd=mysql_query($queryd);
										while ($rowd=mysql_fetch_array($resultd)) { ?>			
											<option value=<?php echo $rowd['z_id'];?> <?php if ($rowd['z_id'] == $z_id) echo 'selected="selected"';?> ><?php echo $rowd['z_name'];?> (<?php echo $rowd['z_bn_name'];?>)</option>		
										<?php } ?>
									</select>
								</p>
								<p>
									<label>Client Name*</label>
									<span class="field"><input type="text" name="" id="" readonly class="input-xxlarge" value="<?php echo $c_name;?>" /></span>
								</p>
								<p>
									<label>Address*</label>
									<span class="field"><input type="text" name="address" required="" id="" class="input-xxlarge" value="<?php echo $address;?>" /></span>
								</p>
								<p>
									<label>Contact No*</label>
									<span class="field"><input type="text" name="cell" required="" id="" class="input-xxlarge" value="<?php echo $cell;?>" /></span>
								</p>
								<p>
									<label>Package</label>
									<span class="field">
										<select name="p_id" class="chzn-select"  style="width:540px;">
											<option>Choose Package</option>
											<?php 
												$queryd="SELECT p_id, p_name, p_price, bandwith FROM package ORDER BY p_id ASC";
												$resultd=mysql_query($queryd);
											while ($rowd=mysql_fetch_array($resultd)) { ?>			
												<option value=<?php echo $rowd['p_id']?> <?php if ($rowd['p_id'] == $p_id) echo 'selected="selected"';?> ><?php echo $rowd['p_name'];?> (<?php echo $rowd['p_price'];?> TK - <?php echo $rowd['bandwith'];?>)</option>		
											<?php } ?>
										</select>
									</span>
								</p>
								<p>
									<label>OTC</label>
									<span class="field"><input type="text" name="otc" id="" placeholder="Amount of Taka" class="input-xxlarge" value="<?php echo $otc;?>" /></span>
								</p>
								<p>
									<label>Set-up Date</label>
									<span class="field"><input type="text" name="setup_date" placeholder="Set-up Date Will be" id="" class="input-xxlarge datepicker" value="<?php echo $setup_date;?>" /></span>
								</p>
								<p>
									<label>Previous ISP</label>
									<span class="field"><input type="text" name="previous_isp" id="" placeholder="Ex: ISP Name" class="input-xxlarge" value="<?php echo $previous_isp;?>" /></span>
								</p>
								<p>
									<label>Status</label>
									<span class="field">
										<select name="current_status" class="chzn-select"  style="width:540px;">
											<option value="">Choose Status</option>
											<option value="Done" <?php if ('Done' == $current_status) echo 'selected="selected"';?>>Done</option>
											<option value="Confirm" <?php if ('Confirm' == $current_status) echo 'selected="selected"';?>>Confirm</option>	
											<option value="Not Confirm" <?php if ('Not Confirm' == $current_status) echo 'selected="selected"';?>>Not Confirm</option>
											<option value="Contact Later(EOL)" <?php if ('Contact Later(EOL)' == $current_status) echo 'selected="selected"';?>>Contact Later(EOL)</option>
											<option value="Contact Later(Client)" <?php if ('Contact Later(Client)' == $current_status) echo 'selected="selected"';?>>Contact Later(Client)</option>	
											<option value="Interested But Not Confirm" <?php if ('Interested But Not Confirm' == $current_status) echo 'selected="selected"';?>>Interested But Not Confirm</option>	
												
										</select>
									</span>
								</p>
								<p>
									<label>Line-Up Date</label>
									<span class="field"><input type="text" name="line_up_date" placeholder="Line-Up Date Will be" id="" class="input-xxlarge datepicker" value="<?php echo $line_up_date;?>" /></span>
								</p>
								<p>
									<label>Note/Update</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xxlarge" value="<?php echo $note;?>"/><?php echo $note;?></textarea></span>
								</p>
								
					</div>             
						<div class="modal-footer">
							<button type="reset" class="btn">Reset</button>
							<button class="btn btn-primary" type="submit">Submit</button>
						</div>

				</form> <!-- END OF DEFAULT WIZARD -->
			</div> 
		</div>
	</div>

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
