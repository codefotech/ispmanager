<?php
$titel = "Payroll Edit";
$Salary = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Salary' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

$result = mysql_query("SELECT e.id, e.e_id, e.e_name, e.e_des, d.dept_name, e.e_cont_per, e.e_j_date, e.e_cont_office, e.gross_total FROM emp_info AS e
						LEFT JOIN department_info AS d ON e.dept_id = d.dept_id	
						WHERE e.status = '0' AND e.z_id = '' ORDER BY e.e_id DESC");

?>

	<div class="pageheader">
        <div class="searchbar">
			
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Employee Payroll Update</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Salary Payroll</h5>
				</div>
				
					<div class="modal-body">
						<?php if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'hr') {?>
							<div class="box-header">
								<form id="" name="form" class="stdform" method="POST" action="<?php echo $PHP_SELF;?>">	
									<select data-placeholder="Choose Employee" style="width:350px;" name="emp" class="chzn-select" >
										<option value=""><option>
										<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row['e_id'] ?>" <?php if($row['e_id'] == $emp){echo 'selected';}?> ><?php echo $row['e_name'].' ('.$row['e_id'].')'; ?></option>
										<?php } ?>
									</select>											
									<input type="text" name="salary_date" value= "<?php echo $salary_date; ?>" style="width:150px;margin-top: -27px;" class="span2 datepicker" placeholder="Date" value="" />
									<button class="btn" style="width:150px;margin-top: -27px;" type="submitt">Find</button>
								</form>
							</div>
							<table id="dyntable" class="table table-bordered responsive">
								<colgroup>
									<col class="con1" />
									<col class="con0" />
									<col class="con1" />
								</colgroup>
								<thead>
									<tr style="font-size: 11px;">
										<th class="head1">Employee Name</th>
										<th class="head0">Salary Month</th>
										<th class="head1">Status</th>
									</tr>
								</thead>
								<tbody class="abcd123">
									<?php
										$fromdate = date('Y-m-01', strtotime($salary_date));
										$todate = date('Y-m-t', strtotime($salary_date));
										$sql = "SELECT p.id, e.e_name, p.salary_date FROM employee_payroll AS p LEFT JOIN emp_info AS e ON e.e_id = p.e_id WHERE p.sts = 0";
										if ($fromdate != '' && $todate != '') {
												$sql .= " AND p.salary_date BETWEEN '{$fromdate}' AND '{$todate}'";
											}
										if ($emp != '') {
												$sql .= " AND p.e_id = '{$emp}'";
											}
											
										$sql .= " ORDER BY p.salary_date";
										if($fromdate != '' || $todate != '' || $emp != ''){		
											$result = mysql_query($sql);
											while( $row = mysql_fetch_assoc($result) )
											{
												
												echo
													"<tr class='gradeX'>
														<td>{$row['e_name']}</td>
														<td>{$row['salary_date']}</td>
														<td><a href='EmployeePayrollUpdate?id=",$id,"{$row['id']}' target='_blank'><span class='btn-primary3 animate1 bounceIn'><i class='iconfa-eye-open'></i> Edit</span></a></td>
													</tr>\n ";
											}  
										}	
									?>
								</tbody>    
							</table>
						<?php } ?>
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