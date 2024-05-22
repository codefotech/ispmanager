<?php
$titel = "Reports";
$Reports = 'active';
$ReportCashInHand = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(155, $access_arry)){
//---------- Permission -----------
$userName = $_SESSION['SESS_FIRST_NAME'];
$Date = date('d/m/Y');

if($f_date == '' || $t_date == ''){
$f_date = date("Y-m-01");
$t_date = date("Y-m-d");}

?>
	<div class="pageheader">
        <div class="searchbar" style="right: 0px;">
		<form id="" name="form" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
			<input type="text" name="f_date" id="" style="width:30%;text-align: center;" placeholder="From Date" class="surch_emp datepicker" value="<?php echo $f_date; ?>"/>
			<input type="text" name="t_date" id="" style="width:30%;text-align: center;" placeholder="To Date" class="surch_emp datepicker" value="<?php echo $t_date; ?>"/>
			<input type="hidden" name="bank" value="<?php echo $bank; ?>"/>
			<button class="btn col5" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Cash In Hand Statement</h1>
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
					<?php if($bank !=''){
					$sqlop1 = mysql_query("SELECT SUM(transfer_amount) AS TFR FROM fund_transfer WHERE fund_received = '$bank' AND transfer_date < '$f_date'");
					$sqlop2 = mysql_query("SELECT SUM(amount) AS TLR FROM loan_receive WHERE bank = '$bank' AND loan_date < '$f_date'");
					$sqlop3 = mysql_query("SELECT SUM(pay_amount) AS TBC FROM payment WHERE bank = '$bank' AND pay_date  < '$f_date'");
					$sqlop400 = mysql_query("SELECT SUM(amount) AS OBS FROM bill_signup WHERE bank = '$bank' AND pay_date < '$f_date'");
					$sqlop600 = mysql_query("SELECT SUM(amount) AS EBS FROM bill_extra WHERE bank = '$bank' AND pay_date < '$f_date'");
					$sqlop500 = mysql_query("SELECT SUM(pay_amount) AS MRP FROM payment_macreseller WHERE sts = '0' AND bank = '$bank' AND pay_date < '$f_date'");

					$rowop1 = mysql_fetch_array($sqlop1);
					$fundReceivedOp = $rowop1['TFR'];
					
					$rowop2 = mysql_fetch_array($sqlop2);
					$loanReceiveOp = $rowop2['TLR'];
					
					$rowop3 = mysql_fetch_array($sqlop3);
					$billCollectionOp = $rowop3['TBC'];
					
					$rowop400 = mysql_fetch_array($sqlop400);
					$billSignupOp = $rowop400['OBS'];
					
					$rowop500 = mysql_fetch_array($sqlop500);
					$MacresellerPaymentOp = $rowop500['MRP'];
					
					$rowop600 = mysql_fetch_array($sqlop600);
					$ExtraBillOp = $rowop600['EBS'];
					
					
					$sqlopCr1 = mysql_query("SELECT SUM(transfer_amount) AS TFS FROM fund_transfer WHERE fund_send = '$bank' AND transfer_date < '$f_date'");
					$sqlopCr2 = mysql_query("SELECT SUM(amount) AS TLP FROM loan_payment WHERE bank = '$bank' AND payment_date < '$f_date'");
					$sqlopCr4 = mysql_query("SELECT SUM(amount) AS TP FROM expanse WHERE bank = '$bank' AND status = '2' AND ex_date < '$f_date'");
					$sqlopCr5 = mysql_query("SELECT SUM(amount) AS SAP FROM emp_salary_payment WHERE bank = '$bank' AND payment_date < '$f_date'");
					$sqlopCr6 = mysql_query("SELECT SUM(amount) AS VPP FROM vendor_payment WHERE bank = '$bank' AND sts = '0' AND payment_date < '$f_date'");
					
					$rowop7 = mysql_fetch_array($sqlopCr1);
					$fundSendOp = $rowop7['TFS'];
					
					$rowop8 = mysql_fetch_array($sqlopCr2);
					$loanPaidOp = $rowop8['TLP'];
					
					$rowop10 = mysql_fetch_array($sqlopCr4);
					$allPaymentOp = $rowop10['TP'];
					
					$rowop11 = mysql_fetch_array($sqlopCr5);
					$allSalaryOp = $rowop11['SAP'];
					
					$rowop12 = mysql_fetch_array($sqlopCr6);
					$allVpOp = $rowop12['VPP'];
					
					$openingRecived = $fundReceivedOp + $loanReceiveOp + $billSignupOp + $ExtraBillOp + $billCollectionOp + $MacresellerPaymentOp;
					$openingPayment = $fundSendOp + $loanPaidOp + $allPaymentOp + $allSalaryOp + $allVpOp;
					
					$openingBalance = $openingRecived - $openingPayment;
					
					$Bankkk = mysql_query("SELECT b.bank_name, b.id, e.e_id, e.e_name, e.e_cont_per, d.dept_name FROM bank AS b LEFT JOIN emp_info AS e ON e.e_id = b.emp_id LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE b.id = '$bank'");
					$Bnkkk=mysql_fetch_array($Bankkk);
					$Bankname = $Bnkkk['bank_name'];
					$Bankid = $Bnkkk['id'];
					$BanEmpName = $Bnkkk['e_name'];
					$BanDeptName = $Bnkkk['dept_name'];
					$BanEid = $Bnkkk['e_id'];
					$BanEmpCell = $Bnkkk['e_cont_per'];
					?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="padding-top: 5px;">Bank:</th>
						<td><?php echo $Bankname.' ('.$Bankid.')'; ?></td>
								
						<th style="padding-top: 5px;">Employee:</th>
						<td><?php echo $BanEmpName.' ('.$BanEid.')'; ?></td>
						
						<th style="padding-top: 5px;">Department:</th>
						<td><?php echo $BanDeptName; ?></td>
						
						<th style="padding-top: 5px;">Cell:</th>
						<td><?php echo $BanEmpCell; ?></td>
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
									<th class="head0" style="text-align: center;">Date & Time</th>
									<th class="head1" style="text-align: center;">Particulars</th>
									<th class="head0" style="text-align: center;width: 6%;">Received</th>
									<th class="head1" style="text-align: center;width: 6%;">Paid</th>
									<th class="head0" style="text-align: center;width: 6%;">Balance</th>
									<th class="head1" style="text-align: center;width: 15%;">Note</th>
								</tr>
						</thead>
					<tbody>
					<tr class='gradeX'>
						<td colspan="4" style="text-align: right;font-size: 15px;"><b>Opeaning Balance</b></td>
						<td style="text-align: right;"><b><?php echo number_format($openingBalance,2);?></b></td>
						<td></td>
					</tr>
					<?php			
					$x = 1;
					$TotBalanceTransferRcv = 0;	
					$TotalLoanAmount = 0;
					$TotalBillCollection = 0;
					$TotaltransferAmountCr = 0;
					$TotalAmountCr = 0;
					$TotalExAmountCr = 0;
					$TotalSalaryCr = 0;
					$TotalVendCr = 0;
					$TotOtherAmounttt = 0;
					$TotMacPayAmounttt = 0;
					
		while (strtotime($f_date) <= strtotime($t_date)) {	
		//------------------------------------------------------------Received Amount---------------------------------------------------------------------------------	
			
			$sql = mysql_query("SELECT DATE_FORMAT(f.transfer_date, '%D %b,%y') AS transfer_date, b.bank_name, f.transfer_amount, DATE_FORMAT(f.last_update, '%h:%i%p') AS last_update, f.note FROM fund_transfer AS f
									LEFT JOIN bank AS b ON b.id = f.fund_send
									WHERE f.fund_received = '$bank' AND f.transfer_date = '$f_date' ORDER BY f.last_update");
			$BalanceTransferRcv = 0;
			while ($row = mysql_fetch_array($sql)) {?>
				<tr class='gradeX'>
					<td><?php echo $row['transfer_date'].' '.$row['last_update'];?></td>
					<td><?php echo 'Fund Received from <b>'.$row['bank_name'].'</b>';?></td>
					<td style="text-align: right;color: green;font-weight: bold;"><?php echo $row['transfer_amount'];?></td>
					<td></td>
					<td></td>
					<td><?php echo $row['note'];?></td>
				</tr>
			<?php	$BalanceTransferRcv += $row['transfer_amount'];
			}
						
			$sql1 = mysql_query("SELECT l.loan_from, f.name, l.amount, DATE_FORMAT(l.loan_date, '%D %b,%y') AS loan_date, l.note, DATE_FORMAT(l.last_update, '%h:%i%p') AS last_update FROM loan_receive AS l 
								LEFT JOIN loan_from AS f ON f.id = l.loan_from
								WHERE l.bank = '$bank' AND l.loan_date = '$f_date' ORDER BY l.last_update");
			$TotLoanAmount = 0;
			while ($row1 = mysql_fetch_array($sql1)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1['loan_date'].' '.$row1['last_update'];?></td>
					<td><?php echo 'Loan received from <b>'.$row1['name'].'</b>';?></td>
					<td style="text-align: right;color: gray;font-weight: bold;"><?php echo $row1['amount'];?></td>
					<td></td>
					<td></td>
					<td><?php echo $row1['note'];?></td>
				</tr>
			<?php	$TotLoanAmount += $row1['amount'];
			}
			
			$sql1qqq = mysql_query("SELECT b.id, b.c_id, c.c_name, b.bill_type, b.amount, DATE_FORMAT(b.pay_date, '%D %b,%y') AS pay_date, DATE_FORMAT(b.pay_date_time, '%h:%i%p') AS pay_date_time, b.bill_dsc, t.type, b.bank FROM bill_signup AS b
								LEFT JOIN bills_type AS t ON t.bill_type = b.bill_type
								LEFT JOIN clients AS c ON c.c_id = b.c_id
								WHERE b.bank = '$bank' AND b.pay_date = '$f_date' ORDER BY b.pay_date_time");
			$TotOtherAmount = 0;
			while ($row1qqq = mysql_fetch_array($sql1qqq)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1qqq['pay_date'].' '.$row1qqq['pay_date_time'];?></td>
					<td><?php echo 'Payment received from <b>'.$row1qqq['c_name'].' ('.$row1qqq['c_id'].')</b> for <b>'.$row1qqq['type'].'</b>';?></td>
					<td style="text-align: right;color: #0093b5;font-weight: bold;"><?php echo $row1qqq['amount'];?></td>
					<td></td>
					<td></td>
					<td><?php echo $row1qqq['bill_dsc'];?></td>
				</tr>
			<?php	$TotOtherAmount += $row1qqq['amount'];
			}
			
			$sql1qqqeee = mysql_query("SELECT b.id, b.be_name, b.bill_type, b.amount, DATE_FORMAT(b.pay_date, '%D %b,%y') AS pay_date, b.bill_dsc, DATE_FORMAT(b.pay_date_time, '%h:%i%p') AS pay_date_time, t.type, b.bank FROM bill_extra AS b
								LEFT JOIN bills_type AS t ON t.bill_type = b.bill_type
								WHERE b.bank = '$bank' AND b.pay_date = '$f_date' ORDER BY b.pay_date_time");
			$TotExtraAmount = 0;
			while ($row1qqqeee = mysql_fetch_array($sql1qqqeee)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1qqqeee['pay_date'].' '.$row1qqqeee['pay_date_time'];?></td>
					<td><?php echo 'Payment received from <b>'.$row1qqqeee['be_name'].' for '.$row1qqqeee['type'].'</b>';?></td>
					<td style="text-align: right;color: #0093b5;font-weight: bold;"><?php echo $row1qqqeee['amount'];?></td>
					<td></td>
					<td></td>
					<td><?php echo $row1qqqeee['bill_dsc'];?></td>
				</tr>
			<?php	$TotExtraAmount += $row1qqqeee['amount'];
			}
			
			$sql1qqqmm = mysql_query("SELECT m.e_id, e.e_name, z.z_name, DATE_FORMAT(m.pay_date, '%D %b,%y') AS pay_date, DATE_FORMAT(m.pay_time, '%h:%i%p') AS pay_time, m.pay_amount, m.discount, m.note FROM payment_macreseller AS m
									LEFT JOIN zone AS z ON z.z_id = m.z_id
									LEFT JOIN emp_info AS e ON e.e_id = m.e_id
									WHERE m.sts = '0' AND m.bank = '$bank' AND m.pay_date = '$f_date' ORDER BY m.date_time");
			$TotMacPayAmount = 0;
			while ($row1qqqmm = mysql_fetch_array($sql1qqqmm)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1qqqmm['pay_date'].' '.$row1qqqmm['pay_time'];?></td>
					<td><?php echo 'Reseller payment received from <b>'.$row1qqqmm['e_name'].' ('.$row1qqqmm['z_name'].')</b>';?></td>
					<td style="text-align: right;color: #8233e1;font-weight: bold;"><?php echo $row1qqqmm['pay_amount'];?></td>
					<td></td>
					<td></td>
					<td><?php echo $row1qqqmm['note'];?></td>
				</tr>
			<?php	$TotMacPayAmount += $row1qqqmm['pay_amount'];
			}
			
			$sql2 = mysql_query("SELECT p.c_id, c.c_name, p.pay_amount, DATE_FORMAT(p.pay_date, '%D %b,%y') AS pay_date, p.pay_desc, DATE_FORMAT(p.pay_date_time, '%h:%i%p') AS pay_date_time, p.pay_mode, p.moneyreceiptno, p.trxid FROM payment AS p LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE p.bank = '$bank' AND p.pay_date = '$f_date' ORDER BY p.pay_date_time");
			$TotBillCollection = 0;
			while ($row2 = mysql_fetch_array($sql2)) {?>
				<tr class='gradeX'>
					<td><?php echo $row2['pay_date'].' '.$row2['pay_date_time'];?></td>
					<td><?php echo 'Bill collection From '.$row2['c_name'].' <b>('.$row2['c_id'].')</b> by '.$row2['pay_mode'].'.'; if($row2['moneyreceiptno'] != ''){ echo '<b>MR: '.$row2['moneyreceiptno'].'</b>.';} if($row2['trxid'] != ''){ echo '<b>TrxID: '.$row2['trxid'].'</b>.';}?></td>
					<td style="text-align: right;color: blue;font-weight: bold;"><?php echo $row2['pay_amount'];?></td>
					<td></td>
					<td></td>
					<td><?php echo $row2['pay_desc'];?></td>
				</tr>
			<?php	$TotBillCollection += $row2['pay_amount'];
			}

	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
	
			$sqlCr = mysql_query("SELECT DATE_FORMAT(f.transfer_date, '%D %b,%y') AS transfer_date, DATE_FORMAT(f.last_update, '%h:%i%p') AS last_update, b.bank_name, f.transfer_amount, f.note FROM fund_transfer AS f
									LEFT JOIN bank AS b ON b.id = f.fund_received
									WHERE f.fund_send = '$bank' AND f.transfer_date = '$f_date' ORDER BY f.last_update");
			$TottransferAmountCr = 0;
			while ($rowCr = mysql_fetch_array($sqlCr)) {?>
				<tr class='gradeX'>
					<td><?php echo $rowCr['transfer_date'].' '.$rowCr['last_update'];?></td>
					<td><?php echo 'Fund send to <b>'.$rowCr['bank_name'].'</b>';?></td>
					<td></td>
					<td style="text-align: right;color: #ff00bf;font-weight: bold;"><?php echo $rowCr['transfer_amount'];?></td>
					<td></td>
					<td><?php echo $rowCr['note'];?></td>
				</tr>
			<?php	$TottransferAmountCr += $rowCr['transfer_amount'];
			}
			
			$sql1Cr = mysql_query("SELECT l.loan_payment_to, f.name, l.amount, DATE_FORMAT(l.payment_date, '%D %b,%y') AS payment_date, DATE_FORMAT(l.last_update, '%h:%i%p') AS last_update, l.note FROM loan_payment AS l 
								LEFT JOIN loan_from AS f ON f.id = l.loan_payment_to
								WHERE l.bank = '$bank' AND l.payment_date = '$f_date' ORDER BY l.last_update");
			$TotAmountCr = 0;
			while ($row1Cr = mysql_fetch_array($sql1Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1Cr['payment_date'].' '.$row1Cr['last_update'];?></td>
					<td><?php echo 'Loan paid to <b>'.$row1Cr['name'].'</b>';?></td>
					<td></td>
					<td style="text-align: right;color: #b16403;font-weight: bold;"><?php echo $row1Cr['amount'];?></td>
					<td></td>
					<td><?php echo $row1Cr['note'];?></td>
				</tr>
			<?php	$TotAmountCr += $row1Cr['amount'];
			}
			
			$sql2Cr = mysql_query("SELECT DATE_FORMAT(e.ex_date, '%D %b,%y') AS ex_date, DATE_FORMAT(e.enty_date, '%h:%i%p') AS enty_date, t.ex_type, e.amount, e.note FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank = '$bank' AND e.category = '0' AND e.status = '2' AND e.ex_date = '$f_date' ORDER BY e.enty_date");
			$TotExAmountCr = 0;
			while ($row2Cr = mysql_fetch_array($sql2Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row2Cr['ex_date'].' '.$row2Cr['enty_date'];?></td>
					<td><?php echo 'Paid for <b>'.$row2Cr['ex_type'].'</b> [Office Expance]';?></td>
					<td></td>
					<td style="text-align: right;color: #b16403;font-weight: bold;"><?php echo $row2Cr['amount']; ?></td>
					<td></td>
					<td><?php echo $row2Cr['note']; ?></td>
				</tr>
			<?php	$TotExAmountCr += $row2Cr['amount'];
			}
			
			$sql3Cr = mysql_query("SELECT DATE_FORMAT(p.payment_date, '%D %b,%y') AS payment_date, p.amount, p.note, e.e_name FROM emp_salary_payment AS p 
									LEFT JOIN emp_info AS e ON p.payment_to = e.e_id 
									WHERE p.bank = '$bank' AND p.payment_date = '$f_date'");
			$TotSalaryCr = 0;
			while ($row3Cr = mysql_fetch_array($sql3Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row3Cr['payment_date']; ?></td>
					<td><?php echo 'Paid to employee salary ('.$row3Cr['e_name'].')'; ?></td>
					<td></td>
					<td style="text-align: right;"><?php echo $row3Cr['amount']; ?></td>
					<td></td>
					<td><?php echo $row3Cr['note']; ?></td>
				</tr>
			<?php	$TotSalaryCr += $row3Cr['amount'];
				
			}
			
			$sql4Cr = mysql_query("SELECT DATE_FORMAT(e.ex_date, '%D %b,%y') AS ex_date, DATE_FORMAT(e.enty_date, '%h:%i%p') AS enty_date, t.ex_type, e.amount, e.note, v.v_name, v.cell, v.location FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									LEFT JOIN vendor AS v ON v.id = e.v_id
									WHERE e.bank = '$bank' AND e.category = '1' AND e.status = '2' AND e.ex_date = '$f_date' ORDER BY e.enty_date");
			$TotVendrCr = 0;
			while ($row4Cr = mysql_fetch_array($sql4Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row4Cr['ex_date'].' '.$row4Cr['enty_date'];?></td>
					<td><?php echo 'Paid to Vendor <b>('.$row4Cr['v_name'].'-'.$row4Cr['location'].')</b>';?></td>
					<td></td>
					<td style="text-align: right;color: #a00;font-weight: bold;"><?php echo $row4Cr['amount'];?></td>
					<td></td>
					<td><?php echo $row4Cr['note'];?></td>
				</tr>
			<?php	$TotVendrCr += $row4Cr['amount'];
				
			}
			
			$sql4CrAg = mysql_query("SELECT DATE_FORMAT(e.ex_date, '%D %b,%y') AS ex_date, DATE_FORMAT(e.enty_date, '%h:%i%p') AS enty_date, t.ex_type, e.amount, e.note, a.e_name, a.e_cont_per FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									LEFT JOIN agent AS a ON a.e_id = e.agent_id
									WHERE e.bank = '$bank' AND e.category = '2' AND e.status = '2' AND e.ex_date = '$f_date' ORDER BY e.enty_date");
			$TotAgCr = 0;
			while ($row4CrAg = mysql_fetch_array($sql4CrAg)) {?>
				<tr class='gradeX'>
					<td><?php echo $row4CrAg['ex_date'].' '.$row4CrAg['enty_date']; ?></td>
					<td><?php echo 'Commission Paid to Agent <b>('.$row4CrAg['e_name'].'-'.$row4CrAg['e_cont_per'].')</b>'; ?></td>
					<td></td>
					<td style="text-align: right;color: #a00;font-weight: bold;"><?php echo $row4CrAg['amount']; ?></td>
					<td></td>
					<td><?php echo $row4CrAg['note']; ?></td>
				</tr>
			<?php	$TotAgCr += $row4CrAg['amount'];
				
			}
			
			$sql8CrAg = mysql_query("SELECT DATE_FORMAT(e.ex_date, '%D %b,%y') AS ex_date, DATE_FORMAT(e.enty_date, '%h:%i%p') AS enty_date, t.ex_type, e.amount, e.note FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank = '$bank' AND e.category = '3' AND e.status = '2' AND e.ex_date = '$f_date' ORDER BY e.enty_date");
			$TotAginCr = 0;
			while ($row8CrAg = mysql_fetch_array($sql8CrAg)) {?>
				<tr class='gradeX'>
					<td><?php echo $row8CrAg['ex_date'].' '.$row8CrAg['enty_date']; ?></td>
					<td><?php echo 'Investment for <b>'.$row8CrAg['ex_type'].'</b>';?></td>
					<td></td>
					<td style="text-align: right;color: #a00;font-weight: bold;"><?php echo $row8CrAg['amount']; ?></td>
					<td></td>
					<td><?php echo $row8CrAg['note']; ?></td>
				</tr>
			<?php	$TotAginCr += $row8CrAg['amount'];
				
			}

			$f_date = date ("Y-m-d", strtotime("+1 days", strtotime($f_date)));
			$x++;
			$TotBalanceTransferRcv += $BalanceTransferRcv;
			$TotalLoanAmount += $TotLoanAmount;
			$TotOtherAmounttt += $TotOtherAmount;
			$TotExtraAmounttt += $TotExtraAmount;
			$TotMacPayAmounttt += $TotMacPayAmount;
			$TotalBillCollection += $TotBillCollection;

			$TotaltransferAmountCr += $TottransferAmountCr;
			$TotalAmountCr += $TotAmountCr;
			$TotalExAmountCr += $TotExAmountCr;
			$TotalSalaryCr += $TotSalaryCr;
			$TotalVendCr += $TotVendrCr;
			$TotalAgeCr += $TotAgCr;
			$TotalAgineCr += $TotAginCr;
		}	

			$ReciveTotal = $TotBalanceTransferRcv + $TotalLoanAmount + $TotOtherAmounttt + $TotExtraAmounttt + $TotMacPayAmounttt + $TotalBillCollection;
			$PaidTotal = $TotaltransferAmountCr + $TotalAmountCr + $TotalExAmountCr + $TotalSalaryCr + $TotalVendCr + $TotalAgeCr + $TotalAgineCr;?>
				<tr class='gradeX'>
					<td colspan="2" style="text-align: right;font-size: 15px;"><b>TOTAL</b></td>
					<td style="text-align: right;"><b><?php echo number_format($ReciveTotal,2); ?></b></td>
					<td style="text-align: right;"><b><?php echo number_format($PaidTotal,2); ?></b></td>
					<td colspan="2" style="font-size: 15px;color:red;"><b><?php echo number_format((($ReciveTotal + $openingBalance) - $PaidTotal),2); ?></b></td>
				</tr>
					</tbody>
						</table><br>
					<div class="row">
						<div style="padding-left: 15px; width: 100%;">
							<table class="table table-bordered table-invoice" style="width: 47.5%; float: left;">
								<tr>
									<td><strong>Balance Received</strong></td>
									<td style="color: green;font-weight: bold;"><?php echo number_format($TotBalanceTransferRcv,2); ?></td>
								</tr>
								<tr>
									<td class="width30"><strong>Bill Collection</strong></td>
									<td class="width70" style="color: blue;font-weight: bold;"><?php echo number_format($TotalBillCollection,2); ?></td>
								</tr>
								<tr>
									<td><strong>Reseller Collection</strong></td>
									<td style="color: #8233e1;font-weight: bold;"><?php echo number_format($TotMacPayAmounttt,2); ?></td>
								</tr>
								<tr>
									<td><strong>Others Income</strong></td>
									<td style="color: #0093b5;font-weight: bold;"><?php echo number_format($TotOtherAmounttt,2); ?></td>
								</tr>
								<tr>
									<td><strong>Outside Income</strong></td>
									<td style="color: #0093b5;font-weight: bold;"><?php echo number_format($TotExtraAmounttt,2); ?></td>
								</tr>
								<tr>
									<td><strong>Loan Received</strong></td>
									<td style="color: gray;font-weight: bold;"><?php echo number_format($TotalLoanAmount,2); ?></td>
								</tr>
								<tr>
									<td><strong>Others</strong></td>
									<td style="color: gray;font-weight: bold;"><?php echo number_format(0.00,2); ?></td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;"><strong>Total Received</strong></td>
									<td style="font-size: 13px;"><strong><?php echo number_format($ReciveTotal,2); ?> ৳</strong></td>
								</tr>
							</table>
							<table class="table table-bordered table-invoice" style="width: 47.5%; float: left; margin-left: 15px;">
								<tr>
									<td class="width30"><strong>Transfer Amount</strong></td>
									<td class="width70" style="color: #ff00bf;font-weight: bold;"><?php echo number_format($TotaltransferAmountCr,2); ?></td>
								</tr>
								<tr>
									<td><strong>Loan Paid</strong></td>
									<td style="color: #b16403;font-weight: bold;"><?php echo number_format($TotalAmountCr,2); ?></td>
								</tr>
								<tr>
									<td><strong>Expance</strong></td>
									<td style="color: #b16403;font-weight: bold;"><?php echo number_format($TotalExAmountCr,2); ?></td>
								</tr>
								<tr>
									<td><strong>Salary Paid</strong></td>
									<td style="font-weight: bold;"><?php echo number_format($TotalSalaryCr,2); ?></td>
								</tr>
								<tr>
									<td><strong>Vendor Bill Paid</strong></td>
									<td style="color: #a00;font-weight: bold;"><?php echo number_format($TotalVendCr,2); ?></td>
								</tr>
								<tr>
									<td><strong>Commission Paid</strong></td>
									<td style="color: #a00;font-weight: bold;"><?php echo number_format($TotalAgeCr,2); ?></td>
								</tr>
								<tr>
									<td><strong>Investment</strong></td>
									<td style="color: #a00;font-weight: bold;"><?php echo number_format($TotalAgineCr,2); ?></td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;"><strong>Total Paid</strong></td>
									<td style="font-size: 13px;"><strong><?php echo number_format($PaidTotal,2);?> ৳</strong></td>
								</tr>
							</table>
						</div><!--col-md-6-->
					</div>
					<?php } if($bank ==''){ ?>
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
									<th class="head0 center">S/L</th>
									<th class="head1">Bank Name</th>
									<th class="head1" style='text-align: right;'>Opeaning Balance</th>
									<th class="head0" style='text-align: right;'>Received Amount</th>
									<th class="head1" style='text-align: right;'>Paid Amount</th>
									<th class="head0" style='text-align: right;'>Balance</th>
									<th class="head1 center">Action</th>
								</tr>
							</thead>
							<tbody>
				<?php $sqlBank = mysql_query("SELECT b.id, b.bank_name, b.sort_name, b.show_exp, b.emp_id, e.e_name, d.dept_name FROM bank AS b
										LEFT JOIN emp_info AS e	ON e.e_id = b.emp_id
										LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE b.sts = 0 ORDER BY b.bank_name");
				$x = 1;
				$TotBalance = 0;
				$ReceivedAmountt = 0;
				$PaymentAmountt = 0;
				$OpeningAmountttt = 0;
				while ($rowBank = mysql_fetch_array($sqlBank)) {
					$bankId = $rowBank['id'];
					$bankName = $rowBank['bank_name'];
					$empid = $rowBank['emp_id'];
					$ename = $rowBank['e_name'];
					$deptname = $rowBank['dept_name'];
					
					$sqlOp = mysql_query("SELECT * FROM 
										(
										SELECT id, bank_name FROM bank WHERE id = '$bankId'
										)a
										LEFT JOIN
										(
										SELECT fund_received, SUM(transfer_amount) AS transfer_amount FROM fund_transfer WHERE fund_received = '$bankId' AND transfer_date < '$f_date'
										)b ON a.id = b.fund_received
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS amount FROM loan_receive WHERE bank = '$bankId' AND loan_date < '$f_date'
										)c ON a.id = c.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS otheramounts FROM bill_signup WHERE bank = '$bankId' AND pay_date < '$f_date'
										)e ON a.id = e.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS extraamount FROM bill_extra WHERE bank = '$bankId' AND pay_date < '$f_date'
										)h ON a.id = h.bank
										LEFT JOIN
										(
										SELECT bank, SUM(pay_amount) AS paymentmacreseller FROM payment_macreseller WHERE sts = '0' AND bank = '$bankId' AND pay_date < '$f_date'
										)f ON a.id = f.bank
										LEFT JOIN
										(
										SELECT bank, SUM(pay_amount) AS collection FROM payment WHERE bank = '$bankId' AND pay_date < '$f_date'
										)d ON a.id = d.bank");
					$rowOp = mysql_fetch_array($sqlOp);		
					$ReceivedAmountOp = $rowOp['transfer_amount'] + $rowOp['amount'] + $rowOp['otheramounts'] + $rowOp['extraamount'] + $rowOp['collection'] + $rowOp['paymentmacreseller'];
					
					$sqlOp1 = mysql_query("SELECT * FROM 
										(
										SELECT id, bank_name FROM bank WHERE id = '$bankId'
										)a
										LEFT JOIN
										(
										SELECT fund_send, SUM(transfer_amount) AS transferAmount FROM fund_transfer WHERE fund_send = '$bankId' AND transfer_date < '$f_date'
										)b ON a.id = b.fund_send
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS Amounts FROM loan_payment WHERE bank = '$bankId' AND payment_date < '$f_date'
										)c ON a.id = c.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS payAmount FROM expanse WHERE bank = '$bankId' AND status = '2' AND ex_date < '$f_date'
										)d ON a.id = d.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS paySalary FROM emp_salary_payment WHERE bank = '$bankId' AND payment_date < '$f_date'
										)f ON a.id = f.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS venPayemnt FROM vendor_payment WHERE bank = '$bankId' AND sts = '0' AND payment_date < '$f_date'
										)g ON a.id = g.bank");
					$rowOp1 = mysql_fetch_array($sqlOp1);		
					$PaymentAmountOp = $rowOp1['transferAmount'] + $rowOp1['Amounts'] + $rowOp1['payAmount'] + $rowOp1['paySalary'] + $rowOp1['venPayemnt'];
					$OpeningAmount = $ReceivedAmountOp - $PaymentAmountOp;
					
					$sql = mysql_query("SELECT * FROM 
										(
										SELECT id, bank_name FROM bank WHERE id = '$bankId'
										)a
										LEFT JOIN
										(
										SELECT fund_received, SUM(transfer_amount) AS transfer_amount FROM fund_transfer WHERE fund_received = '$bankId' AND transfer_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.id = b.fund_received
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS amount FROM loan_receive WHERE bank = '$bankId' AND loan_date BETWEEN '$f_date' AND '$t_date'
										)c ON a.id = c.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS otheramount FROM bill_signup WHERE bank = '$bankId' AND pay_date BETWEEN '$f_date' AND '$t_date'
										)e ON a.id = e.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS extraamount FROM bill_extra WHERE bank = '$bankId' AND pay_date BETWEEN '$f_date' AND '$t_date'
										)h ON a.id = h.bank
										LEFT JOIN
										(
										SELECT bank, SUM(pay_amount) AS paymentmacreseller FROM payment_macreseller WHERE sts = '0' AND bank = '$bankId' AND pay_date BETWEEN '$f_date' AND '$t_date'
										)f ON a.id = f.bank
										LEFT JOIN
										(
										SELECT bank, SUM(pay_amount) AS collection FROM payment WHERE bank = '$bankId' AND pay_date BETWEEN '$f_date' AND '$t_date'
										)d ON a.id = d.bank");
					$row = mysql_fetch_array($sql);		
					$ReceivedAmount = $row['transfer_amount'] + $row['amount'] + $row['otheramount'] + $row['extraamount'] + $row['collection'] + $row['paymentmacreseller'];
					
					$sql1 = mysql_query("SELECT * FROM 
										(
										SELECT id, bank_name FROM bank WHERE id = '$bankId'
										)a
										LEFT JOIN
										(
										SELECT fund_send, SUM(transfer_amount) AS transferAmount FROM fund_transfer WHERE fund_send = '$bankId' AND transfer_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.id = b.fund_send
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS Amounts FROM loan_payment WHERE bank = '$bankId' AND payment_date BETWEEN '$f_date' AND '$t_date'
										)c ON a.id = c.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS payAmount FROM expanse WHERE bank = '$bankId' AND status = '2' AND ex_date BETWEEN '$f_date' AND '$t_date'
										)d ON a.id = d.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS paySalary FROM emp_salary_payment WHERE bank = '$bankId' AND payment_date BETWEEN '$f_date' AND '$t_date'
										)f ON a.id = f.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS venPayemnt FROM vendor_payment WHERE bank = '$bankId' AND sts = '0' AND payment_date BETWEEN '$f_date' AND '$t_date'
										)g ON a.id = g.bank");
					$row1 = mysql_fetch_array($sql1);
					$PaymentAmount = $row1['transferAmount'] + $row1['Amounts'] + $row1['payAmount'] + $row1['paySalary'] + $row1['venPayemnt'];
					$Balance = (($ReceivedAmount + $OpeningAmount) - $PaymentAmount);
					
					$ReceivedAmounttt = number_format($ReceivedAmount,2);
					$PaymentAmounttt = number_format($PaymentAmount,2);
					$Balanceeee = number_format($Balance,2);
					$OpeningAmounttt = number_format($OpeningAmount,2);
					if($empid == ''){
						$empinfo = '';
					}else{
						$empinfo = $ename.' ('.$empid.') <br>'.$deptname;
					}
					
					echo
												"<tr class='gradeX'>
													<td class='center' style='font-size: 15px;'><b>{$x}</b></td>
													<td><b>{$bankName}</b><br>{$empinfo}</td>
													<td style='text-align: right;'>{$OpeningAmounttt}</td>
													<td style='text-align: right;'>{$ReceivedAmounttt}</td>
													<td style='text-align: right;'>{$PaymentAmounttt}</td>
													<td style='text-align: right;font-size: 15px;'><b>{$Balanceeee}</b></td>
													<td class='center'>
														<ul class='tooltipsample'>
															<li><form action='ReportCashInHand' method='post'><input type='hidden' name='bank' value='{$bankId}' /><button class='btn ownbtn2' style='padding: 6px 9px;' onClick='submit();'><i class='fa iconfa-eye-open'></i></button></form></li>
														</ul>
													</td>
												</tr>\n";
				
					$x++;
					$OpeningAmountttt += $OpeningAmount;
					$ReceivedAmountt += $ReceivedAmount;
					$PaymentAmountt += $PaymentAmount;
					$TotBalance += $Balance;
					
				}?>

												<td colspan="2" style="text-align: right;"><b>TOTAL:</b></td>
												<td style="text-align: right;"><b><?php echo number_format($OpeningAmountttt,2); ?></b></td>
												<td style="text-align: right;"><b><?php echo number_format($ReceivedAmountt,2); ?></b></td>
												<td style="text-align: right;"><b><?php echo number_format($PaymentAmountt,2);?></b></td>
												<td colspan="2" style="text-align: center;font-size: 15px;color:red;"><b><?php echo number_format($TotBalance,2);?></b></td>
							</tbody>
						</table>
					<?php } ?>
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