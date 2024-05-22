<?php
$titel = "Reports";
$Reports = 'active';
$ReportExpenceHead = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(157, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];
if($user_type == 'admin' || $user_type == 'superadmin' ){
$query1="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' ORDER BY e_id ASC";
}
else{
$query1="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' AND e_id = '$e_id'";
}
$result1=mysql_query($query1);

$query="SELECT id, ex_type FROM expanse_type WHERE status = '0' ORDER BY ex_type ASC";
$result=mysql_query($query);
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Expense</h1>
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
						<h4> Expense Report </h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a Expense Head" name="type" class="chzn-select"  style="width:345px;">
												<option value="all"> All Expense Head </option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
												<option value="<?php echo $row['id'] ?>"><?php echo $row['ex_type']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="inputwrapper animate_cus2">
										<select data-placeholder="Choose a Employee" name="e_id" class="chzn-select"  style="width:345px;">
												<?php if($user_type == 'admin' || $user_type == 'superadmin' ){ ?><option value="all"> All Employee </option><?php } ?>
											<?php while ($row=mysql_fetch_array($result1)) { ?>
												<option value="<?php echo $row['e_id'] ?>"><?php echo $row['e_name']?> - <?php echo $row['e_des']?> - <?php echo $row['e_id']?></option>
											<?php } ?>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus3">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date"/>
										</div>
									</div>
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width: 45%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportExpenceHead';"/>
										<input class="btn ownbtn3" style='width: 45%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportExpenceHead';"/>
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