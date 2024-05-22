<?php
$titel = "Upcoming";
$Upcoming = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Upcoming' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$query="SELECT * FROM zone order by z_name";
$result=mysql_query($query);

$query1="SELECT p_id, p_name, p_price, bandwith FROM package order by id ASC";
$result1=mysql_query($query1);
?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Upcoming"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Upcoming Client</h1>
        </div>
    </div><!--pageheader-->
	<?php if ($stat == 'done'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your data successfully Inserted In Your Database.
		</div>
	<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Upcoming Client</h5>
				</div>
					<form id="form" class="stdform" method="post" action="UpcomingAddQuery">
						<input type="hidden" name="rcv_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
							<div class="modal-body">
								<p>	
									<label>Zone*</label>
									<select data-placeholder="Choose a Zone..." name="z_id" class="chzn-select"  style="width:50% !important;" required="">
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>
									<label>Client Name*</label>
									<span class="field"><input type="text" name="c_name" id="" required="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Address*</label>
									<span class="field"><input type="text" name="address" placeholder="" required="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Contact No*</label>
									<span class="field"><input type="text" name="cell" placeholder="Cell No" required="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Package</label>
									<span class="field">
										<select data-placeholder="Choose a Package" name="p_id" class="chzn-select"  style="width:50% !important;" />
											<option value=""></option>
												<?php while ($row1=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
												<?php } ?>
										</select>
									</span>
								</p>
								<p>
									<label>OTC</label>
									<span class="field"><input type="text" name="otc" id="" placeholder="Amount of Taka" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Set-up Date</label>
									<span class="field"><input type="text" name="setup_date" placeholder="Set-up Date Will be" id="" class="input-xxlarge datepicker"></span>
								</p>
								<p>
									<label>Previous ISP</label>
									<span class="field"><input type="text" name="previous_isp" id="" placeholder="Ex: ISP Name" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Note</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xxlarge" /></textarea></span>
								</p>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
					</form>			
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