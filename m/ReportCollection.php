<?php
$titel = "Reports";
$Reports = 'active';
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
?>
	<div class="box box-primary">
			<div class="box-body aasas"> 
				<h4> Collection Report </h4><br><br>
							<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
								<input type="hidden" name="user_type" id="" readonly value="<?php echo $user_type; ?>" />
								<input type="hidden" name="e_id" id="" readonly value="<?php echo $e_id; ?>" />
									<div class="inputwrapper animate_cus1">
									<?php if($userr_typ == 'mreseller'){ ?>
										<input type="hidden" name="z_id" id="" readonly value="<?php echo $macz_id; ?>" />
										<input type="hidden" name="way" id="" value="macreseller" />
										<select data-placeholder="Choose a Zone" name="box_id" class="chzn-select" style="width:100%;" />
											<option value="all"> All Zone </option>
												<?php while ($rowaf=mysql_fetch_array($resultsgsg)) { ?>
											<option value="<?php echo $rowaf['box_id']?>"><?php echo $rowaf['b_name']; ?></option>
												<?php } ?>
										</select>
									<?php } else{?>
										<input type="hidden" name="way" id="" value="none" />
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select" style="width:100%;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
												<?php } ?>
										</select>
										<?php } ?>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Payment Type" name="payment_type" class="chzn-select" style="width:100%;" />
											<option value="all"> All Payment Type</option>
											<option value="CASH"> Cash </option>
											<option value="Online"> Online </option>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus4">
										<div id="custdiv">
											<input type="text" name="f_date" id="" style="width:49%;" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date"/>
											<input type="text" name="t_date" id="" style="width:49%;" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date"/>
										</div>
									</div>
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width:49%;text-align: center;font-weight: bold;font-size: 15px;' type="submit" value="PDF" onclick="javascript: form.action='<?php echo $weblink;?>fpdf/ReportCollection';"/>
										<input class="btn ownbtn3" style='width:49%;text-align: center;font-weight: bold;font-size: 15px;' type="submit" value="CSV" onclick="javascript: form.action='<?php echo $weblink;?>exl/ReportCollection';"/>
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
<style>
.aasas{text-align: center;min-height: 85vh}
</style>