<?php
$titel = "Payroll Update";
$EmployeePayroll = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'EmployeePayroll' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$Id = $_GET['id'];
$sqlP = mysql_query("SELECT * FROM employee_payroll WHERE id = '$Id'");
$Rs = mysql_fetch_array($sqlP);
$eId = $Rs['e_id'];

$result = mysql_query("SELECT e_id, e_name FROM emp_info WHERE e_id = '$eId'");

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="EmployeePayrollEdit"><i class="iconfa-edit"></i> Update </a>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Salary Payroll</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Salary Payroll</h5>
				</div>
				
			<div class="modal-body">
				<form id="" name="form1" class="stdform" method="post" action="EmployeePayrollUpdateSave">
					<input type="hidden" value="<?php echo $Rs['id']; ?>" name="ids" />
					<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="ent_by" />
					<input type="hidden" value="<?php echo date('Y-m-d'); ?>" name="ent_date" />
						
						<p>
							<label>Employee</label>
							<select data-placeholder="Choose one" name="e_id" style="width:50%;" class="chzn-select" required="">
									<?php while ($row = mysql_fetch_array($result)) { ?>
								<option value="<?php echo $row['e_id'] ?>"><?php echo $row['e_name'].' ('.$row['e_id'].')'; ?></option>
									<?php } ?>
							</select>
						</p>
						<p>
							<label>Working Day</label>
							<span class="field"><input type="text" name="working_day" value="<?php echo $Rs['working_day']; ?>" id="" style="width:55%;" required="" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Day' readonly /></span>
						</p>
						<p>
							<label>Advance Amount</label>
							<span class="field"><input type="text" name="advance" value="<?php echo $Rs['advance']; ?>" id="" style="width:55%;" placeholder="Advance Amount (if any)" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Taka' readonly /></span>
						</p>
						<!--
						<p>
							<label>Over Time</label>
							<span class="field"><input type="text" name="over_time" value="<?php echo $Rs['over_time']; ?>" id="" style="width:55%;" placeholder="Over time amount (if any)" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Taka' readonly /></span>
						</p>
						-->
						<p>
							<label>Other Tips</label>
							<span class="field"><input type="text" name="other_tips" value="<?php echo $Rs['other_tips']; ?>" id="" style="width:55%;" placeholder="Other Tips (if any)" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Taka' readonly /></span>
						</p>
						<p>
							<label>Salary Date/Month</label>
							<span class="field"><input type="text" class="datepicker" value="<?php echo $Rs['salary_date']; ?>" name="salary_date" required="" id="" style="width:30%;;" readonly value="<?php echo date('Y-m-d', strtotime('-1 month')); ?>" /></span>
						</p>
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="note" style="width:61%;" id="" placeholder="Expanse Note (If Any)" class="input-xxlarge" /><?php echo $Rs['note']; ?></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn">Reset</button>
						<button class="btn btn-primary" type="submit">Submit</button>
					</div>
				</form>			
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