<?php
$titel = "Reports";
$Reports = 'active';
$ReportMacResellerMonthBill = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$result1=mysql_query("SELECT e.id, e.e_id, e.e_name, e.z_id, z.z_name FROM emp_info AS e LEFT JOIN zone AS z ON z.e_id = e.e_id WHERE e.dept_id = '0' AND e.status = '0' order by e.e_name");
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Reports</h1>
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
						<center><br/>
						<h4> Mac Reseller Payment Collection </h4><br/>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<div class="inputwrapper animate_cus2">
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:345px;">
											<option value="all"> All Reseller Zone </option>
												<?php while ($row1=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row1['z_id']?>"><?php echo $row1['e_name']; ?> (<?php echo $row1['z_name']?>)</option>
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
										<input class="btn ownbtn2" style='width: 40%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportResellerCollection';"/>
										<input class="btn ownbtn3" style='width: 40%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportResellerCollection';"/>
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
	include('include/index');
}
include('include/footer.php');
?>