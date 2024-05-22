<?php
$titel = "Reports";
$Reports = 'active';
$ReportCollection = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(158, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($user_type == 'billing'){
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name");
$allll = '';
}
else{
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
$allll = '<option value="all"> All Zone </option>';
}
$result1=mysql_query("SELECT * FROM emp_info WHERE sts = '0' order by e_name");

if($userr_typ == 'mreseller'){
	$resultsgsg=mysql_query("SELECT box_id, b_name FROM `box` WHERE `z_id` = $macz_id");
}
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Collections</h1>
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
						<center>
						<h4> Zone Wise Collection Report </h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
								<input type="hidden" name="user_type" id="" readonly value="<?php echo $user_type; ?>" />
								<input type="hidden" name="e_id" id="" readonly value="<?php echo $e_id; ?>" />
									<div class="inputwrapper animate_cus1">
									<?php if($userr_typ == 'mreseller'){ ?>
										<input type="hidden" name="z_id" id="" readonly value="<?php echo $macz_id; ?>" />
										<input type="hidden" name="way" id="" value="macreseller" />
										<select data-placeholder="Choose a Zone" name="box_id" class="chzn-select"  style="width:345px;" />
											<option value="all"> All Zone </option>
												<?php while ($rowaf=mysql_fetch_array($resultsgsg)) { ?>
											<option value="<?php echo $rowaf['box_id']?>"><?php echo $rowaf['b_name']; ?></option>
												<?php } ?>
										</select>
									<?php } else{?>
										<input type="hidden" name="way" id="" value="none" />
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
												<?php } ?>
										</select>
										<?php } ?>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Payment Type" name="payment_type" class="chzn-select"  style="width:345px;" />
											<option value="all"> All Payment Type</option>
											<option value="CASH"> Cash </option>
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
										<input class="btn ownbtn2" style='width: 45%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportCollection';"/>
										<input class="btn ownbtn3" style='width: 45%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportCollection';"/>
									</div>
								</form>
							</div>
						</center>

<br><br>

<?php if($userr_typ != 'mreseller' && $userr_typ != 'billing'){ ?>
						<center>
						<h4>Employee wise Collection Report </h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Employee" name="e_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Employee </option>
												<?php while ($row1=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row1['e_id']?>"><?php echo $row1['e_name']; ?> (<?php echo $row1['e_cont_per']; ?>)</option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus4">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date"/>
										</div>
									</div>
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width: 45%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportEmpCollection';"/>
										<input class="btn ownbtn3" style='width: 45%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportEmpCollection';"/>
									</div>
								</form>
							</div>
						</center>
<?php } ?>
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