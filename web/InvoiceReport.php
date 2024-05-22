<?php
$titel = "Invoice Report";
$Dashboard = 'active';
$InvoiceReport = 'activeted';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Dashboard' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$e_id = $_SESSION['SESS_EMP_ID'];
if($user_type == 'admin'){
	$result = mysql_query("SELECT t_id, t_name FROM territory_info ORDER BY t_name");
	$result1 = mysql_query("SELECT DISTINCT t.bd_area, e.e_name FROM territory_info AS t LEFT JOIN emp_info AS e ON t.bd_area = e.e_id");
}

?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-tag"></i></div>
        <div class="pagetitle">
            <h1>Invoice Report</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/Dashboard_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 15px !important;">
				<div class="box box-primary" style=" margin: 0px;">
					<div class="box-body" style="min-height: 440px;">
				<?php if($user_type == 'admin' || $user_type == 'customer_care') {?>
						<form id="" name="form" class="stdform" method="post" action="fpdf/OrderReport" target="_blank">		
							<center>
								<div class="pad2">
									<div class="inputwrapper animate_cus2">
										<select data-placeholder="Choose Territory" name="t_id" style="width:350px;" class="chzn-select">
											<option value=""></option>
											<option value="all">All Territory</option>
											<?php while ($row2=mysql_fetch_array($result)) { ?>
											<option value=<?php echo $row2['t_id']?>><?php echo $row2['t_name']?></option>
												<?php } ?>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus3">
										<div id="custdiv">
											<input type="text" name="t_date" style="width:160px;height: 25px;" id="" class="surch_emp datepicker" placeholder="To Date"/>
											<input type="text" name="f_date" style="width:160px;height: 25px;" id="" class="surch_emp datepicker" placeholder="From Date"/>
										</div>
									</div>
									<div class="inputwrapper animate_cus4">
										<button class="btn btn-primary" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
									</div>
								</div>
							</center>
						</form>
						<?php } else{ }?>
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