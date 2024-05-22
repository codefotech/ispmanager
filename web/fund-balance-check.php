<?php
include("conn/connection.php") ;
extract($_POST);

$sqlBank = mysql_query("SELECT b.id, b.bank_name, b.sort_name, b.show_exp, b.emp_id, e.e_name, e.e_id, e.e_cont_per, d.dept_name FROM bank AS b
										LEFT JOIN emp_info AS e	ON e.e_id = b.emp_id
										LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE b.sts = 0 AND b.id = '$fund_send' ORDER BY b.bank_name");
										
$rowgdfg = mysql_fetch_assoc($sqlBank);
$ename = $rowgdfg['e_name'];
$eid = $rowgdfg['e_id'];
$deptname = $rowgdfg['dept_name'];
$bankname = $rowgdfg['bank_name'];
$bb_id = $rowgdfg['id'];
$econt_per = $rowgdfg['e_cont_per'];
		
		
					$sqlOp = mysql_query("SELECT * FROM 
										(
										SELECT id, bank_name FROM bank WHERE id = '$fund_send'
										)a
										LEFT JOIN
										(
										SELECT fund_received, SUM(transfer_amount) AS transfer_amount FROM fund_transfer WHERE fund_received = '$fund_send'
										)b ON a.id = b.fund_received
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS amount FROM loan_receive WHERE bank = '$fund_send'
										)c ON a.id = c.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS otheramounts FROM bill_signup WHERE bank = '$fund_send'
										)e ON a.id = e.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS extraamount FROM bill_extra WHERE bank = '$fund_send'
										)h ON a.id = h.bank
										LEFT JOIN
										(
										SELECT bank, SUM(pay_amount) AS paymentmacreseller FROM payment_macreseller WHERE sts = '0' AND bank = '$fund_send'
										)f ON a.id = f.bank
										LEFT JOIN
										(
										SELECT bank, SUM(pay_amount) AS collection FROM payment WHERE bank = '$fund_send'
										)d ON a.id = d.bank");
					$rowOp = mysql_fetch_array($sqlOp);		
					$ReceivedAmountOp = $rowOp['transfer_amount'] + $rowOp['amount'] + $rowOp['otheramounts'] + $rowOp['extraamount'] + $rowOp['collection'] + $rowOp['paymentmacreseller'];
					
					$sqlOp1 = mysql_query("SELECT * FROM 
										(
										SELECT id, bank_name FROM bank WHERE id = '$fund_send'
										)a
										LEFT JOIN
										(
										SELECT fund_send, SUM(transfer_amount) AS transferAmount FROM fund_transfer WHERE fund_send = '$fund_send'
										)b ON a.id = b.fund_send
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS Amounts FROM loan_payment WHERE bank = '$fund_send'
										)c ON a.id = c.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS payAmount FROM expanse WHERE bank = '$fund_send' AND status = '2'
										)d ON a.id = d.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS paySalary FROM emp_salary_payment WHERE bank = '$fund_send'
										)f ON a.id = f.bank
										LEFT JOIN
										(
										SELECT bank, SUM(amount) AS venPayemnt FROM vendor_payment WHERE bank = '$fund_send' AND sts = '0'
										)g ON a.id = g.bank");
					$rowOp1 = mysql_fetch_array($sqlOp1);		
					$PaymentAmountOp = $rowOp1['transferAmount'] + $rowOp1['Amounts'] + $rowOp1['payAmount'] + $rowOp1['paySalary'] + $rowOp1['venPayemnt'];
					$OpeningAmount = $ReceivedAmountOp - $PaymentAmountOp;
					
					$Balanceeee = number_format($OpeningAmount,2);
					
//					echo 'Current Balance: '.$Balanceeee.'TK';
					
?>

									<table class="table table-bordered table-invoice" style="width: 100%;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">Employee</td>
											<td class="width70" style="color: teal;font-weight: bolder;"><?php echo $ename;?> (<?php echo $econt_per;?>)</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Bank</td>
											<td><?php echo $bankname;?> (<?php echo $bb_id;?>)</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Balance</td>
											<td style="font-size: 20px;color: red;"><?php echo $Balanceeee;?> ৳</td>
										</tr>
									</table>