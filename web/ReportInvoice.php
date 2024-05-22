<?php
$titel = "Reports";
$Reports = 'active';
$ReportInvoice = 'activeted';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(162, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($user_type == 'billing'){
$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name");
}else{
$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
}
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Invoice (Due Bills)</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/Reports_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 15px !important;">
				<div class="box box-primary" style=" margin: 0px;">
					<div class="box-body" style="min-height: 440px;">
											<br /><br /><br />

						<center>
						<h4>Billing Invoice Print</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="fpdf/BillsPrint" target="_blank">
									<div class="inputwrapper animate_cus1">
									<?php if($userr_typ == 'billing'){ ?>
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
												<?php while ($row=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?></option>
												<?php } ?>
										</select>
									<?php } else{?>
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?></option>
												<?php } ?>
										</select>
										<?php } ?>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:345px;">
											<option value="">All Payment Method</option>
											<option value="Cash">Cash</option>
											<option value="Home Cash">Cash from Home</option>
											<option value="Office">Office</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
										</select>
									</div>
									<div class="inputwrapper animate_cus3">
										<button class="btn btn-primary" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
									</div>
								</form>
							</div>
						</center>
					</div>
				</div>
			</div>
		</div>
<?php
}
else{
	session_unset();
	session_destroy();
}
include('include/footer.php');
?>