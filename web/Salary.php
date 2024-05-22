<?php
$titel = "Employee Salary";
$Salary = 'active';
include('include/hader.php');
$VendorsID = $_GET['VendorsInfo'];
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');
$todayyy = date('Y-m-d', time());	
if($f_date == '' || $t_date == ''){
$f_date = date('Y-m-01', strtotime('-1 month'));
$t_date = date('Y-m-d');}
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Salary' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typee" value="vendor" />
	<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
	<input type="hidden" name="enty_time" value="<?php echo date("Y-m-d h:i:s");?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Vendor Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Name:</div>
						<div class="col-2"><input type="text" name="v_name" id="" placeholder="Ex: Full Name" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Location:</div>
						<div class="col-2"><input type="text" name="location" id="" placeholder="Ex: Vendor Address" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Cell:</div>
						<div class="col-2"><input type="text" name="cell" id="" placeholder="Ex: 01712345678" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Email:</div>
						<div class="col-2"><input type="text" name="email" id="" placeholder="Ex: Email Address" class="input-large"/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Join Date:</div>
						<div class="col-2"><input type="text" name="join_date" id="" placeholder="" class="input-large datepicker" value="<?php echo date("Y-m-d");?>"/></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn">Reset</button>
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<?php if($userr_typ == 'mreseller'){} 
		else{ ?>
			<a class="btn ownbtn2" href="SalaryPayroll">Payroll</a>
			<!--<a class="btn" href="SalaryBonusPayroll">Bonus Payroll</a>
			<a class="btn" href="SalaryPayment">Salary Payment</a>-->	
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i> </div>
        <div class="pagetitle">
			<h1> Salary</h1>
        </div>
    </div><!--pageheader-->	
	<?php if($sts == 'delete') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
		</div>
	<!--alert-->
	<?php } if($sts == 'editinfo') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> Vendor Information Successfully Edited in Your System.
	</div>
	<!--alert-->
	<?php } if($sts == 'add') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
	</div>
	<!--alert-->
	<?php } if($sts == 'edit') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.
	</div>
	<!--alert-->
	<?php } if($emp_id == ''){ ?>	
		<div class="box box-primary">
			<div class="box-header">
				Employee Salary List
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
							</colgroup>
							<thead>
								<tr  class="newThead">
									<th class="head0 center">SL</th>
									<th class="head1">Employee</th>
									<th class="head1 right">Gross Salary</th>
									<th class="head0 right">Generated Salary</th>
									<th class="head1 right">Paid Amount</th>
									<th class="head0 right">Payable</th>
									<th class="head1 center">Action</th>
								</tr>
							</thead>
							<tbody>
				<?php $sqlBank = mysql_query("SELECT e.id, e.e_id, e.e_name, e.e_des, e.e_cont_per, d.dept_name, e.e_j_date, e.e_cont_office, e.gross_total, e.status, e.z_id FROM emp_info AS e
											LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE e.status = '0' AND e.z_id = '' ORDER BY e.e_name ASC");
				$x = 1;
				$TotBalance = 0;
				$PayrollAmount = 0;
				$PaymentAmountt = 0;
				$grosstotalAmountt = 0;
				while ($rowBank = mysql_fetch_array($sqlBank)) {
					$empId = $rowBank['e_id'];
					$empName = $rowBank['e_name'];
					$deptname = $rowBank['dept_name'];
					$gross_total = $rowBank['gross_total'];
					
					$sql = mysql_query("SELECT * FROM 
										(
										SELECT e_id, e_name FROM emp_info WHERE e_id = '$empId'
										)a
										LEFT JOIN
										(
										SELECT e_id, SUM((basic_salary+mobile_bill+house_rent+medical+food+others+other_bonus)-(provident_fund+professional_tax+income_tax+cut_amount)) AS salary_amount FROM emp_payroll WHERE sts = '0' AND e_id = '$empId'
										)b ON a.e_id = b.e_id");
					$row = mysql_fetch_array($sql);		
					$PayrollAmount = $row['salary_amount'];
					
					$sql1 = mysql_query("SELECT * FROM 
										(
										SELECT e_id, e_name FROM emp_info WHERE e_id = '$empId'
										)a
										LEFT JOIN
										(
										SELECT ex_by, SUM(amount) AS salary_pay FROM expanse WHERE type = '1' AND status = '2' AND ex_by = '$empId'
										)b ON a.e_id = b.ex_by
										LEFT JOIN
										(
										SELECT ex_by, SUM(amount) AS advance_pay FROM expanse WHERE type = '2' AND status = '2' AND ex_by = '$empId'
										)c ON a.e_id = c.ex_by");
					$row1 = mysql_fetch_array($sql1);
					$PaymentAmount = $row1['salary_pay'] + $row1['advance_pay'];
					$Balance = ($PayrollAmount - $PaymentAmount);

					echo
												"<tr class='gradeX'>
													<td class='center' style='font-size: 20px;font-weight: bold;color: darkolivegreen;'>{$x}</td>
													<td><b>{$empName}</b> ({$empId})<br>{$deptname}</td>
													<td style='text-align: right;font-size: 16px;padding: 14px 5px;'>{$gross_total}</td>
													<td style='text-align: right;font-size: 16px;padding: 14px 5px;'>{$PayrollAmount}</td>
													<td style='text-align: right;font-size: 16px;padding: 14px 5px;'>{$PaymentAmount}</td>
													<td style='text-align: right;font-size: 16px;padding: 14px 5px;font-weight: bold;'>{$Balance}</td>
													<td class='center'>
														<ul class='tooltipsample'>
															<li><form action='Salary' method='post'><input type='hidden' name='emp_id' value='{$empId}' /><button class='btn' style='border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 9px;' onClick='submit();'><i class='fa iconfa-eye-open'></i></button></form></li>
														</ul>
													</td>
												</tr>\n";
				
					$x++;
					$grosstotalAmountt += $gross_total;
					$PayrollAmountt += $PayrollAmount;
					$PaymentAmountt += $PaymentAmount;
					$TotBalance += $Balance;
					
				}?>
												<td></td>
												<td style='text-align: right;font-size: 16px;padding: 14px 5px;'><b>TOTAL:</b></td>
												<td style='text-align: right;font-size: 16px;padding: 14px 5px;'><b><?php echo number_format($grosstotalAmountt,2);?></b></td>
												<td style='text-align: right;font-size: 16px;padding: 14px 5px;'><b><?php echo number_format($PayrollAmountt,2);?></b></td>
												<td style='text-align: right;font-size: 16px;padding: 14px 5px;'><b><?php echo number_format($PaymentAmountt,2);?></b></td>
												<td style='text-align: right;font-size: 16px;padding: 14px 5px;'><b><?php echo number_format($TotBalance,2);?></b></td>
												<td></td>
							</tbody>
						</table>
			</div>			
		</div>
	<?php } else{ 
					$sqlop1 = mysql_query("SELECT ((SUM(gross_total)+SUM(other_bonus))-SUM(cut_amount)) AS salary_amount FROM emp_payroll WHERE sts = '0' AND e_id = '$emp_id' AND salary_date < '$f_date'");
					$rowop1 = mysql_fetch_array($sqlop1);
					$fundReceivedOp = $rowop1['salary_amount'];
					
					$sqlopCr2 = mysql_query("SELECT SUM(amount) AS salary_pay, note FROM expanse WHERE type = '1' AND status = '2' AND ex_by = '$emp_id' AND DATE_FORMAT(check_date, '%Y-%m-%d') < '$f_date'");
					$sqlopCr4 = mysql_query("SELECT SUM(amount) AS salary_pay, note FROM expanse WHERE type = '2' AND status = '2' AND ex_by = '$emp_id' AND DATE_FORMAT(check_date, '%Y-%m-%d') < '$f_date'");
					
					$rowop8 = mysql_fetch_array($sqlopCr2);
					$loanPaidOp = $rowop8['salary_pay'];
					
					$rowop10 = mysql_fetch_array($sqlopCr4);
					$allPaymentOp = $rowop10['salary_pay'];

					
					$openingRecived = $fundReceivedOp;
					$openingPayment = $loanPaidOp + $allPaymentOp;
					
					$openingBalance = $openingRecived - $openingPayment;
					
	$Bankkk = mysql_query("SELECT e.id, e.e_id, e.e_name, e.e_des, e.e_cont_per, d.dept_name, e.e_j_date, e.e_cont_per, e.gross_total, e.status, e.z_id FROM emp_info AS e
						LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE e.status = '0' AND e.z_id = '' AND e.e_id = '$emp_id'");
					$Bnkkk=mysql_fetch_array($Bankkk);
					$emp_iddd = $Bnkkk['e_id'];
					$emp_name = $Bnkkk['e_name'];
					$emp_cell = $Bnkkk['e_cont_per'];
					$Dept_Name = $Bnkkk['dept_name'];
	?>
		<div class="box box-primary">
			<div class="box-body">
			<div id="hd">
				<table style="width:100%;margin-bottom: 5px;">
							<tr>
								<td style="text-align: center;"><b>Employee:</b> <?php echo $emp_name.' ('.$emp_iddd.')';?></td>
								<td style="text-align: center;"><b>Department:</b> <?php echo $Dept_Name;?></td>
								<td style="text-align: center;"><b>Cell:</b> <?php echo $emp_cell;?></td>
								<td style="text-align: right;">
									<form id="" name="form" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
										<input type="text" name="f_date" id="" style="width:30%;text-align: center;" placeholder="From Date" class="surch_emp datepicker" value="<?php echo $f_date; ?>"/>
										<input type="text" name="t_date" id="" style="width:30%;text-align: center;" placeholder="To Date" class="surch_emp datepicker" value="<?php echo $t_date; ?>"/>
										<input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>"/>
										<button class="btn col5" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
									</form>
								</td>
							</tr>
				</table>
			</div>
					<table id="dyntable" class="table table-bordered responsive">
						<colgroup>
								<col class="con0" />
								<col class="con1" />
								<col class="con0" />
								<col class="con1" />
								<col class="con0" />
								<col class="con1" />
								<col class="con0" />
						</colgroup>
						<thead>
								<tr  class="newThead">
									<th class="head0 center">Date</th>
									<th class="head1 center">Particulars</th>
									<th class="head0 center">Net Gross Salary</th>
									<th class="head1 center">Paid Amount</th>
									<th class="head0 center">Payable</th>
									<th class="head1 center">Bank</th>
									<th class="head0 center">Note</th>
								</tr>
						</thead>
					<tbody>
					<tr class='gradeX'>
						<td></td>
						<td></td>
						<td></td>
						<td style="text-align: right;"><b>Opeaning Balance:</b></td>
						<td><b><?php echo $openingBalance; ?></b></td>
						<td></td>
						<td></td>
					</tr>
					<?php			
					$x = 1;
					$TotaltransferAmountCr = 0;
					$TotalAmountCr = 0;

		while (strtotime($f_date) <= strtotime($t_date)) {
		//------------------------------------------------------------Received Amount---------------------------------------------------------------------------------	
			
			$sqldfgd = mysql_query("SELECT p.e_id, e.e_name AS payroll_by, p.professional_tax, p.income_tax, p.working_day, p.provident_fund, p.others, p.medical, p.food, p.salary_date, p.basic_salary, p.mobile_bill, p.house_rent, ((p.gross_total+p.other_bonus)-p.cut_amount) AS salary_amount, p.note, p.gross_total, p.other_bonus, p.cut_amount, DATE_FORMAT(p.ent_date, '%d-%M, %Y') AS ent_date, p.ent_time FROM emp_payroll AS p
								LEFT JOIN emp_info AS e ON e.e_id = p.ent_by
								WHERE p.sts = '0' AND p.e_id = '$emp_id' AND p.salary_date = '$f_date'");
			$BalanceTransferRcv = 0;
			while ($rowsdf = mysql_fetch_array($sqldfgd)) {?>
				<tr class='gradeX'>
					<td style="font-weight: bold;padding-top: 4%;" class="center"><?php echo $rowsdf['salary_date']; ?></td>
					<td><?php echo '<b>Salary Generated</b> by '.$rowsdf['payroll_by'].' at '.$rowsdf['ent_date'].' '.$rowsdf['ent_time'];?> <br>
						<table style="width:100%;background: #def9ff;float: left;">
							<tr>
								<td style="padding-top: 5px;text-align: right;background: #d7edf0;">Basic: <?php echo $rowsdf['basic_salary'];?></td>
								<td style="padding-top: 5px;text-align: right;background: #d7edf0;">Food: <?php echo $rowsdf['food'];?></td>
								<td style="padding-top: 5px;text-align: right;background: #ffe5e5;">P.Fund: <?php echo $rowsdf['provident_fund'];?></td>
							</tr>
							<tr>
								<td style="padding-top: 5px;text-align: right;background: #d7edf0;">Mobile: <?php echo $rowsdf['mobile_bill'];?></td>
								<td style="padding-top: 5px;text-align: right;background: #d7edf0;">House: <?php echo $rowsdf['house_rent'];?></td>
								<td style="padding-top: 5px;text-align: right;background: #ffe5e5;">P.Tax: <?php echo $rowsdf['professional_tax'];?></td>
							</tr>
							<tr>
								<td style="padding-top: 5px;text-align: right;background: #d7edf0;">Medical: <?php echo $rowsdf['medical'];?></td>
								<td style="padding-top: 5px;text-align: right;background: #d7edf0;">Others: <?php echo $rowsdf['others'];?></td>
								<td style="padding-top: 5px;text-align: right;background: #ffe5e5;">I.Tax: <?php echo $rowsdf['income_tax'];?></td>
							</tr>
							<tr>
								<td colspan="3" style="background: #fff;"></td>
							</tr>
							<tr>
								<td colspan="2" style="padding-top: 5px;text-align: right;font-weight: bold;background: #d7edf0;">Gross Total</td>
								<td style="padding-top: 5px;text-align: right;font-weight: bold;background: #d7edf0;"><?php echo $rowsdf['gross_total'];?></td>
							</tr>
							<tr>
								<td style="padding-top: 5px;text-align: center;background: #ffe5e5;"><b><?php echo $rowsdf['working_day'];?></b> Working Days</td>
								<td style="padding-top: 5px;text-align: right;font-weight: bold;background: #d7edf0;">Bonus</td>
								<td style="padding-top: 5px;text-align: right;font-weight: bold;background: #d7edf0;"><?php echo $rowsdf['other_bonus'];?></td>
							</tr>
							<tr>
								<td colspan="2" style="padding-top: 5px;text-align: right;font-weight: bold;background: #d7edf0;color: #ff4c4c;">Cut Amount</td>
								<td style="padding-top: 5px;text-align: right;font-weight: bold;background: #d7edf0;color: #ff4c4c;"><?php echo $rowsdf['cut_amount'];?></td>
							</tr>
						</table>
					</td>
					<td style="font-size: 15px;font-weight: bold;text-align: center;padding-top: 4%;text-anchor: middle;color: #0866c6;"><?php echo $rowsdf['salary_amount']; ?></td>
					<td class="center" style="padding-top: 4%;">-</td>
					<td class="center" style="padding-top: 4%;">-</td>
					<td class="center" style="padding-top: 4%;">-</td>
					<td><?php echo $rowsdf['note']; ?></td>
				</tr>
			<?php	$BalanceTransferRcv += $rowsdf['salary_amount'];
			}

	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
			$sqlCr = mysql_query("SELECT e.ex_by, b.bank_name, e.bank, DATE_FORMAT(e.check_date, '%Y-%m-%d') AS apprv_date, e.mathod, e.amount AS salary_pay, q.e_name AS check_by, e.note FROM expanse AS e 
			LEFT JOIN bank AS b ON b.id = e.bank
			LEFT JOIN emp_info AS q ON q.e_id = e.check_by
			
			WHERE e.type = '1' AND e.status = '2' AND e.ex_by = '$emp_id' AND DATE_FORMAT(e.check_date, '%Y-%m-%d') = '$f_date'");
									
			$TottransferAmountCr = 0;
			while ($rowCr = mysql_fetch_array($sqlCr)) {?>
				<tr class='gradeX'>
					<td style="font-weight: bold;" class="center"><?php echo $rowCr['apprv_date'];?></td>
					<td><?php echo '<b>Salary Approved</b> by '.$rowCr['check_by'].' & Paid by '.$rowCr['mathod'];?></td>
					<td class="center">-</td>
					<td style="font-weight: bold;"><?php echo $rowCr['salary_pay'];?></td>
					<td class="center">-</td>
					<td><?php echo $rowCr['bank_name'].' ('.$rowCr['bank'].')';?></td>
					<td><?php echo $rowCr['note']; ?></td>
				</tr>
			<?php	$TottransferAmountCr += $rowCr['salary_pay'];
			}
			
			$sql1Cr = mysql_query("SELECT e.ex_by, b.bank_name, e.bank, DATE_FORMAT(e.check_date, '%Y-%m-%d') AS apprv_date, e.mathod, e.amount AS salary_pay, q.e_name AS check_by, e.note FROM expanse AS e 
			LEFT JOIN bank AS b ON b.id = e.bank
			LEFT JOIN emp_info AS q ON q.e_id = e.check_by
			
			WHERE e.type = '2' AND e.status = '2' AND e.ex_by = '$emp_id' AND DATE_FORMAT(e.check_date, '%Y-%m-%d') = '$f_date'");
			$TotAmountCr = 0;
			while ($row1Cr = mysql_fetch_array($sql1Cr)) {?>
				<tr class='gradeX'>
					<td style="font-weight: bold;" class="center"><?php echo $row1Cr['apprv_date'];?></td>
					<td><?php echo '<b>Salary Advance Approved</b> by '.$row1Cr['check_by'].' & Paid by '.$row1Cr['mathod'];?></td>
					<td class="center">-</td>
					<td style="font-weight: bold;"><?php echo $row1Cr['salary_pay'];?></td>
					<td class="center">-</td>
					<td><?php echo $row1Cr['bank_name'].' ('.$row1Cr['bank'].')';?></td>
					<td><?php echo $row1Cr['note'];?></td>
				</tr>
			<?php	$TotAmountCr += $row1Cr['salary_pay'];
			}
			
			$f_date = date ("Y-m-d", strtotime("+1 days", strtotime($f_date)));
			$x++;
			$TotBalanceTransferRcv += $BalanceTransferRcv;

			$TotaltransferAmountCr += $TottransferAmountCr;
			$TotalAmountCr += $TotAmountCr;
		}	

			$ReciveTotal = $TotBalanceTransferRcv;
			$PaidTotal = $TotaltransferAmountCr + $TotalAmountCr;?>
				<tr class='gradeX'>
					<td></td>
					<td style="text-align: right;"><b>TOTAL:</b></td>
					<td><b><?php echo number_format($ReciveTotal,2); ?></b></td>
					<td><b><?php echo number_format($PaidTotal,2); ?></b></td>
					<td><b><?php echo number_format((($ReciveTotal + $openingBalance) - $PaidTotal),2); ?></b></td>
					<td></td>
					<td></td>
				</tr>
					</tbody>
						</table>
				
			</div>			
		</div>
	<?php } 
}
else{
	include('include/index');
}
include('include/footer.php');
?>
