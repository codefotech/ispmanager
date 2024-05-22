<?php
$titel = "Reports";
$Reports = 'active';
$ReportBtrc = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(177, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$result=mysql_query("SELECT * FROM zone WHERE status = '0' order by z_name");
$result1=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");

?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>BTRC Report</h1>
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
					<div class="box-body" style="min-height: 440px;"><br/><br/>
						<center>
							<h4>BTRC Clients List</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
											<option value="allzone"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus2">
										<div id="custdiv">
											<select data-placeholder="Choose a Area" name="sts" class="chzn-select"  style="width:345px;">
												<option value="all"> All Clients </option>
												<option value="active">Active Clients</option>
												<option value="inactive">Inactive Clients</option>
											</select>
										</div>
									</div>
									<div class="animate_cus3">
								<!---		<input class="btn" style='width: 45%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/BtrcClientsList';"/>--->
										<input class="btn ownbtn2" style='width: 345px;' type="submit" value="Download XLS" onclick="javascript: form.action='exl/BtrcClientsList';"/>
									</div>
								</form>
							</div>
						</center>
						<br>
						<br>
						<br>
						<br>
						<br>
						<center>
							<h4>Reseller Clients List</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
											<option value="allzone"> All Reseller </option>
												<?php while ($row1=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row1['z_id']?>"><?php echo $row1['z_name']; ?> (<?php echo $row1['resellername']; ?>)</option>
												<?php } ?>
										</select>
									</div>
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width: 345px;' type="submit" value="Submit" onclick="javascript: form.action='exl/ResellerClientsList';"/>
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