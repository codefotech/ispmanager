<?php
$titel = "Re-Active Reseller";
$Reseller = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reseller' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


$update_date = date("y-m-d");
$update_time = date("H:i:s");


$ques = mysql_query("SELECT * from reseller	WHERE c_id = '$c_id'");
$roww = mysql_fetch_assoc($ques);
$cl_id = $roww['c_id'];
$c_name = $roww['c_name'];
$cell = $roww['cell'];
?>

<script type="text/javascript">
function updatesum() {
document.form.total_bandwidth.value = (document.form.raw_bandwidth.value -0) + (document.form.youtube_bandwidth.value -0);
document.form.total_price.value = (document.form.bandwidth_price.value -0) + (document.form.youtube_price.value -0);
}
</script>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Billing"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-folder-open"></i></div>
        <div class="pagetitle">
            <h1>Re-Active Adjustment</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Adjastment</h5>
				</div>
				<form id="form" name="form" class="stdform" method="post" action="ResellerInactiveQuery">
				<input type ="hidden" name="c_id" value="<?php echo $cl_id; ?>">
				<input type ="hidden" name="e_id" value="<?php echo $e_id; ?>">
				<input type ="hidden" name="a" value="Inactive">
					<div class="modal-body">
						<p>	
							<label>Client Info</label>
							<span class="field">
								<input type="text" name="" id="" class="input-xxlarge" value="<?php echo $cl_id;?> | <?php echo $c_name;?> | <?php echo $cell;?>" readonly />
							</span>
						</p>
<p>
									<label>Bandwidth</label>
									<span class="field"><input type="text" name="raw_bandwidth" placeholder="Raw Bandwidth" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="youtube_bandwidth" placeholder="YouTube Bandwidth" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="total_bandwidth" readonly placeholder="Total" style="width: 60px;" onChange="updatesum()" /> <b>MB</b></span>
								</p>
								<p>
									<label>Price</label>
									<span class="field"><input type="text" name="bandwidth_price" placeholder="Raw Price" id="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="youtube_price" placeholder="YouTube Price" id="" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="total_price" readonly placeholder="Total" id="" style="width: 60px;" onChange="updatesum()" /> <b>TK</b></span>
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
