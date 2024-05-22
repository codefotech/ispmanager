<?php
$titel = "Payroll";
$Salary = 'active';
include('include/hader.php');
include("conn/connection.php") ;
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');
//$month = date("M", time()); 
$month = date('F, Y', strtotime('-1 month')); 
$todayyyy = date('Y-m-d', strtotime('-1 month'));
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Salary' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$result = mysql_query("SELECT t1.e_id, t1.id, t1.e_id, t1.e_name, t1.e_des, t1.e_cont_per, t1.dept_name, t1.e_j_date, t1.e_cont_office, t1.gross_total, t1.status, t1.z_id  FROM
(SELECT e.id, e.e_id, e.e_name, e.e_des, e.e_cont_per, d.dept_name, e.e_j_date, e.e_cont_office, e.gross_total, e.status, e.z_id FROM emp_info AS e
LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE e.status = '0' AND e.z_id = '')t1
LEFT JOIN
(SELECT e_id, salary_date FROM emp_payroll WHERE sts = '0' AND MONTH(salary_date) = MONTH('$todayyyy') AND YEAR(salary_date) = YEAR('$todayyyy'))t2
ON t2.e_id = t1.e_id
WHERE isnull(t2.e_id) ORDER BY t1.e_id DESC");
?>
	<div class="pageheader">
		<div class="searchbar" style="width: 60%;">
			<form id="" name="form" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
				<select name="salary_date" class="" style="height: 30px;width:25%;float: right;margin-left: 5px;" onchange="submit();">
						<option>Check PayRoll</option>
						<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
						<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($salary_date == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F, Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
				</select>
			<?php if(!empty($_POST['salary_date'])){?>
				<a class="btn ownbtn3" href="SalaryPayroll" style="float: right;margin-left: 5px;">Salary Payroll</a>
				<a class="btn ownbtn2" href="Salary" style="float: right;margin-left: 5px;">Back To Salary</a>
			<?php } else{?>
				<a class="btn ownbtn2" href="Salary" style="float: right;">Back</a>
			<?php }?>
			</form>
	
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Salary Payroll</h1>
        </div>
    </div><!--pageheader-->
<?php if($sts == 'add') {?>			
<div class="alert alert-success">
	<button data-dismiss="alert" class="close" type="button">&times;</button>
	<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
</div><!--alert-->
<?php } if($sts == 'delete') {?>			
<div class="alert alert-error">
	<button data-dismiss="alert" class="close" type="button">&times;</button>
	<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
</div><!--alert-->
<?php } ?>
	<?php if(empty($_POST['salary_date'])){?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Salary Payroll</h5>
				</div>
					<form id="" name="form1" class="stdform" method="post" action="SalaryPayrollSave">
					<div class="modal-body">
						<input type="hidden" value="1" name="action" />
						<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID']; ?>" name="ent_by" />
							<p>
								<label>Employee</label>
								<select data-placeholder="Choose one" name="e_id" style="width:30%;" class="chzn-select" required="" onChange="getRoutePoint1(this.value)">
									<option value=""></option>
										<?php while ($row = mysql_fetch_array($result)) { ?>
									<option value="<?php echo $row['e_id'] ?>"><?php echo $row['e_id'].' - '.$row['e_name'];?> (<?php echo $row['gross_total'].' TK';?>)</option>
										<?php } ?>
								</select>
							</p>
							<div id="Pointdiv1"></div>
							<p>
								<label>Working Day</label>
								<span class="field"><input type="text" name="working_day" id="" style="width:10%;" required="" Value="30" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Day' readonly /></span>
							</p>
							
							<p>
								<label>Other Bonus</label>
								<span class="field"><input type="text" name="other_bonus" id="" style="width:10%;" placeholder="(if any)" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Taka' readonly /></span>
							</p>
							<p>
								<label>Cut Amount</label>
								<span class="field"><input type="text" name="cut_amount" id="" style="width:10%;" placeholder="(if any)" onkeypress="return isNumberKey6(event)" /><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;" value='Taka' readonly /></span>
							</p>
							<p>
								<label>Salary Month</label>
								<span class="field"><input type="hidden" class="" name="salary_date" required="" value="<?php echo date('Y-m-d', strtotime('-1 month')); ?>" /></span>
								<span class="field"><input type="text" class="" name="" required="" id="" style="width:16%;;" readonly value="<?php echo $month;?>" /></span>
							</p>
							<p>
								<label>Notes</label>
								<span class="field"><textarea type="text" name="note" style="width:30%;" id="" placeholder="Expanse Note (If Any)" class="input-xxlarge" /></textarea></span>
							</p>
					</div>	
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
					</form>	
			</div>
		</div>
		<div class="box-body">
			<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head0">S/L</th>
							<th class="head1">Date</th>
							<th class="head0">Employee</th>
                            <th class="head1">Working Day</th>
                            <th class="head1">Salary Advance</th>
							<th class="head0">Salary & Allowances</th>
							<th class="head1">Deductions</th>
							<th class="head0">Payable Salary</th>
							<th class="head1">Entry By</th>
							<th class="head0">Note</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sqls = mysql_query("SELECT e.e_name, e.e_id, DATE_FORMAT(p.salary_date, '%M, %Y') AS salary_date, p.working_day, p.advance, p.cut_amount, p.other_bonus, p.note, q.e_name AS entryby, p.basic_salary, p.mobile_bill, p.house_rent, p.medical, p.food, p.others, p.other_bonus, p.provident_fund, p.professional_tax, p.income_tax, (p.basic_salary+p.mobile_bill+p.house_rent+p.medical+p.food+p.others+p.other_bonus) AS earn, (p.provident_fund+p.professional_tax+p.income_tax+p.cut_amount) AS cut, (((p.basic_salary+p.mobile_bill+p.house_rent+p.medical+p.food+p.others+p.other_bonus)-(p.provident_fund+p.professional_tax+p.income_tax+p.cut_amount))) AS salary_amount FROM emp_payroll AS p LEFT JOIN emp_info AS e ON e.e_id = p.e_id LEFT JOIN emp_info AS q ON q.e_id = p.ent_by WHERE p.sts = '0' ORDER BY p.id DESC LIMIT 30");
									$x = 1;
									while( $rows = mysql_fetch_assoc($sqls) )
									{
										echo
											"<tr class='gradeX'>
												<td>{$x}</td>
												<td>{$rows['salary_date']}</td>
												<td>{$rows['e_name']} ({$rows['e_id']})</td>
												<td>{$rows['working_day']}</td>
												<td>{$rows['advance']}</td>
												<td>Basic: {$rows['basic_salary']}<br>Mobile: {$rows['mobile_bill']}<br>House: {$rows['house_rent']}<br>Medical: {$rows['medical']}<br>Food: {$rows['food']}<br>Others:{$rows['others']}<br>Bonus: {$rows['other_bonus']}<br>---------------------<br><b>Total: {$rows['earn']}</b></td>
												<td>P.Fund: {$rows['provident_fund']}<br>P.Tax: {$rows['professional_tax']}<br>I.Tax: {$rows['income_tax']}<br>Cut: {$rows['cut_amount']}<br>---------------------<br><b>Total: {$rows['cut']}</b></td>
												<td><b>{$rows['salary_amount']}</b></td>
												<td>{$rows['entryby']}</td>
												<td>{$rows['note']}</td>
											</tr>\n ";
										$x++;
									}  
							?>
                    </tbody>
            </table>
		</div>
	</div>
<style>
#dyntable_length{display: none;}
#dyntable_filter{display: none;}
</style>
	<?php } else{?>
		<div class="box box-primary">
		<div class="box-header">
			<h5>Payroll List</h5>
		</div>
		<div class="box-body">
			<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head0">S/L</th>
							<th class="head1">Date</th>
							<th class="head0">Employee</th>
                            <th class="head1">Working Day</th>
                            <th class="head1">Salary Advance</th>
							<th class="head0">Salary & Allowances</th>
							<th class="head1">Deductions</th>
							<th class="head0">Payable Salary</th>
							<th class="head1">Entry By</th>
							<th class="head0">Note</th>
							<th class="head1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						$sqls = mysql_query("SELECT p.id, e.e_name, e.e_id, DATE_FORMAT(p.salary_date, '%M, %Y') AS salary_date, p.working_day, p.advance, p.cut_amount, p.other_bonus, p.note, q.e_name AS entryby, p.basic_salary, p.mobile_bill, p.house_rent, p.medical, p.food, p.others, p.other_bonus, p.provident_fund, p.professional_tax, p.income_tax, (p.basic_salary+p.mobile_bill+p.house_rent+p.medical+p.food+p.others+p.other_bonus) AS earn, (p.provident_fund+p.professional_tax+p.income_tax+p.cut_amount) AS cut, (((p.basic_salary+p.mobile_bill+p.house_rent+p.medical+p.food+p.others+p.other_bonus)-(p.provident_fund+p.professional_tax+p.income_tax+cut_amount))) AS salary_amount FROM emp_payroll AS p LEFT JOIN emp_info AS e ON e.e_id = p.e_id LEFT JOIN emp_info AS q ON q.e_id = p.ent_by WHERE MONTH(p.salary_date) = MONTH('$salary_date') AND YEAR(p.salary_date) = YEAR('$salary_date') AND p.sts = '0' ORDER BY p.id DESC");

									$x = 1;
									while( $rows = mysql_fetch_assoc($sqls) )
									{
										echo
											"<tr class='gradeX'>
												<td>{$x}</td>
												<td>{$rows['salary_date']}</td>
												<td>{$rows['e_name']} ({$rows['e_id']})</td>
												<td>{$rows['working_day']}</td>
												<td>{$rows['advance']}</td>
												<td>Basic: {$rows['basic_salary']}<br>Mobile: {$rows['mobile_bill']}<br>House: {$rows['house_rent']}<br>Medical: {$rows['medical']}<br>Food: {$rows['food']}<br>Others:{$rows['others']}<br>Bonus: {$rows['other_bonus']}<br>---------------------<br><b>Total: {$rows['earn']}</b></td>
												<td>P.Fund: {$rows['provident_fund']}<br>P.Tax: {$rows['professional_tax']}<br>I.Tax: {$rows['income_tax']}<br>Cut: {$rows['cut_amount']}<br>---------------------<br><b>Total: {$rows['cut']}</b></td>
												<td><b>{$rows['salary_amount']}</b></td>
												<td>{$rows['entryby']}</td>
												<td>{$rows['note']}</td>
												<td class='center'>
												<ul class='tooltipsample' style='padding: 50px 0px;'>
													<li><form action='SalaryPayrollDelete' method='post'><input type='hidden' name='payrollid' value='{$rows['id']}' /><input type='hidden' name='salary_date' value='{$salary_date}' /><input type='hidden' name='delete_by' value='{$e_id}' /><button class='btn' style='border-radius: 3px;border: 1px solid red;color: red;padding: 6px 9px;' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form></li>
												</ul>
											</td>
											</tr>\n ";
										$x++;
									}  
							?>
                    </tbody>
            </table>
		</div>
		</div>
<style>
#dyntable_length{display: none;}
</style>
		<?php } ?>
	<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>
<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	

	function getRoutePoint1(afdId1) {		
		
		var strURL="emp_salary_advence_find.php?e_id="+afdId1;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}

function checksts(){
    return confirm('Change connection status!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}
</script>