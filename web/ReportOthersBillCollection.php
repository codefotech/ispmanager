<?php
$titel = "Reports";
$Reports = 'active';
$ReportOthersBillCollection = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(173, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$result=mysql_query("SELECT * FROM bills_type order by type");
?>
	<div class="pageheader">
        <div class="searchbar"></div>
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
						<br>
						<br>
						<br>
						<center>
						<h4> Others Bill Collections (Clients)</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="fpdf/ReportOthersBillCollection" target="_blank">
								<input type="hidden" name="way" value="client"/>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a one" name="bill_type" class="chzn-select"  style="width:345px;">
											<option value="all"> All Others Collection </option>
												<?php while ($row221=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row221['bill_type'];?>"><?php echo $row221['type'];?></option>
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
										<button class="btn ownbtn2" style='width: 70%;' type="submit">SUBMIT</i></button>
									</div>
								</form>
							</div>
						</center>
						<br>
						<br>
						<br>
						<br>
						<center>
						<h4> Others Bill Collections (Outside)</h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="fpdf/ReportOthersBillCollection" target="_blank">
								<input type="hidden" name="way" value="outside"/>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Choose a one" name="bill_type" class="chzn-select"  style="width:345px;">
											<option value="all"> All Others Collection </option>
												<?php while ($row221=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row221['id']?>"><?php echo $row221['type']; ?></option>
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
										<button class="btn ownbtn2" style='width: 70%;' type="submit">SUBMIT</i></button>
									</div>
								</form>
							</div>
						</center>
						<br>
						<br>
						<br>
						<br>
						<br>
						<br>
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