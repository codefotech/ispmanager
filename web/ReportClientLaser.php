<?php
$titel = "Reports";
$Reports = 'active';
$ReportClientLaser = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(166, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($user_type == 'billing'){
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name");
}else{
$result=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
}

$resultsgsg=mysql_query("SELECT box_id, b_name FROM `box` WHERE `z_id` = $macz_id");
?>
	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Client Ledger</h1>
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
					<div class="box-body" style="min-height: 440px;"><br/>
						<center>
						<h4>Client Ledger</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="fpdf/ReportClientLaser" target="_blank">
								<input type="hidden" name="user_type" id="" readonly value="<?php echo $user_type; ?>" />
								<input type="hidden" name="e_id" id="" readonly value="<?php echo $e_id; ?>" />
									<?php if($user_type == 'mreseller'){ ?>
									<input type="hidden" name="way" id="" value="macreseller" />
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="box_id" class="chzn-select"  style="width:345px;" />
											<option value="all"> All Zone </option>
												<?php while ($rowaf=mysql_fetch_array($resultsgsg)) { ?>
											<option value="<?php echo $rowaf['box_id']?>"><?php echo $rowaf['b_name']; ?></option>
												<?php } ?>
										</select>
										<input type="hidden" name="z_id" id="" readonly value="<?php echo $macz_id;?>" />
									</div>
									<?php } else{ ?>
									<input type="hidden" name="way" id="" value="none" />
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;" />
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
												<?php } ?>
										</select>
									</div>
										<?php } ?>
									<div class="inputwrapper1 animate_cus4">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date"/>
										</div>
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