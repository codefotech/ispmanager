<?php
$titel = "Reports";
$Reports = 'active';
$ReportResellerCollection = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(180, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$result=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
$result1=mysql_query("SELECT * FROM emp_info WHERE sts = '0' order by e_name");

?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Reseller Collections</h1>
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
						<center><br><br><br>
						<h4> Reseller Wise Collection Report </h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Mac Reseller </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> - <?php echo $row['resellername']; ?></option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Payment Type" name="payment_type" class="chzn-select"  style="width:345px;" />
											<option value="all"> All Payment Type</option>
											<option value="Cash"> Cash </option>
											<option value="Online"> Online </option>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus4">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date"/>
										</div>
									</div>
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width: 40%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportResellerCollection';"/>
										<input class="btn ownbtn3" style='width: 40%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportResellerCollection';"/>
									</div>
								</form>
							</div>
						</center>

<br><br>

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