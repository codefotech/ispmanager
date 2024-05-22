<?php
$titel = "Reports";
$Reports = 'active';
$ReportDiactivationClients = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(164, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$result=mysql_query("SELECT * FROM zone WHERE status = '0' order by z_name");
?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Diactivation Clients</h1>
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
					<br><br><br>
						<center>
						<h3><b>Diactivation Clients</b></h3><br>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
									<div class="inputwrapper animate_cus1">
										<input type="text" name="con_sts" id="" required="" readonly value="Inactive" class="input-xxlarge" style="text-align: center;font-size: 17px;font-weight: bold;" />
									</div>
									<div class="inputwrapper animate_cus1">
										<input type="radio" name="inactive_type" value="auto"> Auto Inactive &nbsp; &nbsp;
										<input type="radio" name="inactive_type" value="notauto"> Not Auto Inactive &nbsp; &nbsp;
										<input type="radio" name="inactive_type" value="all" checked="checked"> Both &nbsp; &nbsp;
									</div>
									<div class="inputwrapper1 animate_cus4">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date"/>
										</div>
									</div>
									<div class="animate_cus3">
										<input class="btn" style='width: 45%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportDiactivationClients';"/>
										<input class="btn" style='width: 45%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportDiactivationClients';"/>
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