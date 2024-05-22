<?php
$titel = "Reports";
$Reports = 'active';
$ReportLoanLedger = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(176, $access_arry)){
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
			<input type="hidden" name="loan_id" value="<?php echo $loan_id; ?>"/>
			<button class="btn col5" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Loan Ledger</h1>
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
					<?php if($loan_id !=''){
					$sqlop1 = mysql_query("SELECT SUM(amount) AS ISP FROM loan_receive WHERE sts = '0' AND loan_from = '$loan_id' AND loan_date < '$f_date'");

					$rowop1 = mysql_fetch_array($sqlop1);
					$fundReceivedOp = $rowop1['ISP'];
					
					$sqlopCr1 = mysql_query("SELECT SUM(amount) AS VPT FROM loan_payment WHERE loan_payment_to = '$loan_id' AND sts = '0' AND payment_date < '$f_date'");
					
					$rowop7 = mysql_fetch_array($sqlopCr1);
					$fundSendOp = $rowop7['VPT'];
					
					
					$openingRecived = $fundReceivedOp;
					$openingPayment = $fundSendOp;
					
					$openingBalance = $openingRecived - $openingPayment;
					
					$Bankkk = mysql_query("SELECT id, name, cell, address FROM loan_from WHERE id = '$loan_id'");
					$Bnkkk=mysql_fetch_array($Bankkk);
					$agentname = $Bnkkk['name'];
					$agentcell = $Bnkkk['cell'];
					$address = $Bnkkk['address'];
					?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="padding-top: 5px;">Name:</th>
						<td><?php echo $agentname;?></td>
								
						<th style="padding-top: 5px;">Cell:</th>
						<td><?php echo $agentcell; ?></td>
						
						<th style="padding-top: 5px;">Email:</th>
						<td><?php echo $address; ?></td>
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
									<th class="head0">Date</th>
									<th class="head1">Particulars</th>
									<th class="head0">Received Amount</th>
									<th class="head1">Paid Amount</th>
									<th class="head0">Balance</th>
									<th class="head1">Note</th>
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
					</tr>
					<?php			
					$x = 1;
					$TotBalanceTransferRcv = 0;	
					$TotalVendCr = 0;
					
		while (strtotime($f_date) <= strtotime($t_date)) {	
		//------------------------------------------------------------Received Amount---------------------------------------------------------------------------------	
			
			$sql = mysql_query("SELECT p.id AS vp_id, p.amount, p.loan_from, b.bank_name, DATE_FORMAT(p.loan_date, '%D %b-%y') AS bill_date, a.name AS loan_from_name, a.cell, e.e_name, p.sts, p.note FROM `loan_receive` AS p
											LEFT JOIN loan_from AS a ON a.id = p.loan_from
											LEFT JOIN emp_info AS e ON e.e_id = p.ent_by
											LEFT JOIN bank AS b ON b.id = p.bank
											WHERE p.sts = '0' AND p.loan_from = '$loan_id' AND p.loan_date = '$f_date' ORDER BY p.last_update DESC");
			$InstumentPurchase = 0;
			while ($row = mysql_fetch_array($sql)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $row['bill_date']; ?></b></td>
					<td>Loan Receive to [<?php echo $row['bank_name'];?>]</td>
					<td><?php echo $row['amount'].'/='; ?></td>
					<td class="center">-</td>
					<td></td>
					<td><?php echo $row['note']; ?></td>
				</tr>
			<?php	$InstumentPurchase += $row['amount'];
			}
		

	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
	
			$sqlCr = mysql_query("SELECT e.id, DATE_FORMAT(e.payment_date, '%D %b-%y') AS payment_date, i.e_name AS entby, e.amount, e.note, e.loan_payment_to, b.bank_name FROM `loan_payment` AS e 
									LEFT JOIN emp_info AS i ON i.e_id = e.ent_by
									LEFT JOIN bank AS b ON b.id = e.bank
									WHERE e.loan_payment_to = '$loan_id' AND e.sts = '0' AND e.payment_date = '$f_date' ORDER BY e.payment_date DESC");
			$VendorPaymentAmountCr = 0;
			while ($rowCr = mysql_fetch_array($sqlCr)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $rowCr['payment_date']; ?></b></td>
					<td>Loan Paid by <?php echo $rowCr['entby'];?> [Bank: <?php echo $rowCr['bank_name'];?>]</td>
					<td class="center">-</td>
					<td><?php echo $rowCr['amount'].'/='; ?></td>
					<td></td>
					<td><?php echo $rowCr['note']; ?></td>
				</tr>
			<?php	$VendorPaymentAmountCr += $rowCr['amount'];
			}
			

			$f_date = date ("Y-m-d", strtotime("+1 days", strtotime($f_date)));
			$x++;
			$TotBalanceTransferRcv += $InstumentPurchase;
			$TotalVendCr += $VendorPaymentAmountCr;
		}	

			$ReciveTotal = $TotBalanceTransferRcv;
			$PaidTotal = $TotalVendCr;?>
				<tr class='gradeX'>
					<td></td>
					<td style="text-align: right;"><b>TOTAL:</b></td>
					<td><b><?php echo number_format($ReciveTotal,2); ?></b></td>
					<td><b><?php echo number_format($PaidTotal,2); ?></b></td>
					<td><b><?php echo number_format((($ReciveTotal + $openingBalance) - $PaidTotal),2); ?></b></td>
					<td></td>
				</tr>
					</tbody>
						</table>
					<?php } if($loan_id == ''){ ?>
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
									<th class="head0">SL</th>
									<th class="head1">Loan From</th>
									<th class="head1">Opeaning Balance</th>
									<th class="head0">Loan Amount</th>
									<th class="head1">Paid Amount</th>
									<th class="head0">Balance</th>
									<th class="head1 center">Action</th>
								</tr>
							</thead>
							<tbody>
				<?php $sqlBank = mysql_query("SELECT id, name, cell, address FROM loan_from ORDER BY id ASC");
				$x = 1;
				$TotBalance = 0;
				$ReceivedAmountt = 0;
				$PaymentAmountt = 0;
				while ($rowBank = mysql_fetch_array($sqlBank)) {
					$loanid = $rowBank['id'];
					$VenName = $rowBank['name'];
					$VenCell = $rowBank['cell'];
					$VenEmail = $rowBank['cell'];
					$VenLocation = $rowBank['address'];
					
					$sqlOp = mysql_query("SELECT * FROM 
										(
										SELECT id, name, cell AS cell FROM loan_from WHERE id = '$loanid'
										)a
										LEFT JOIN
										(
										SELECT loan_from, SUM(amount) AS insprice FROM loan_receive WHERE sts = '0' AND loan_from = '$loanid' AND loan_date < '$f_date'
										)b ON a.id = b.loan_from");
					$rowOp = mysql_fetch_array($sqlOp);		
					$ReceivedAmountOp = $rowOp['insprice'];
					
					$sqlOp1 = mysql_query("SELECT * FROM 
										(
										SELECT id, name, cell AS cell FROM loan_from WHERE id = '$loanid'
										)a
										LEFT JOIN
										(
										SELECT loan_payment_to, IFNULL(SUM(amount), 0) AS vanpayamount FROM loan_payment WHERE loan_payment_to = '$loanid' AND sts = '0' AND payment_date < '$f_date'
										)b ON a.id = b.loan_payment_to");
					$rowOp1 = mysql_fetch_array($sqlOp1);		
					$PaymentAmountOp = $rowOp1['vanpayamount'];
					$OpeningAmount = $ReceivedAmountOp - $PaymentAmountOp;
					
					$sql = mysql_query("SELECT * FROM 
										(
										SELECT id, name, cell AS cell FROM loan_from WHERE id = '$loanid'
										)a
										LEFT JOIN
										(
										SELECT loan_from, IFNULL(SUM(amount), 0) AS insprice FROM loan_receive WHERE sts = '0' AND loan_from = '$loanid' AND loan_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.id = b.loan_from");
					$row = mysql_fetch_array($sql);		
					$ReceivedAmount = $row['insprice'] + $row['fibprice'];
					
					$sql1 = mysql_query("SELECT a.id, b.loan_payment_to, IFNULL(b.vanpaya, 0) AS vanpayamount FROM 
										(
										SELECT id, name, cell AS cell FROM loan_from WHERE id = '$loanid'
										)a
										LEFT JOIN
										(
										SELECT loan_payment_to, SUM(amount) AS vanpaya FROM loan_payment WHERE loan_payment_to = '$loanid' AND sts = '0' AND payment_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.id = b.loan_payment_to");
					$row1 = mysql_fetch_array($sql1);
					$PaymentAmount = $row1['vanpayamount'];
					$Balance = (($ReceivedAmount + $OpeningAmount) - $PaymentAmount);

					echo
												"<tr class='gradeX'>
													<td>{$x}</td>
													<td><b>{$VenName}</b><br>{$VenCell}<br>{$VenLocation}<br>{$VenEmail}</td>
													<td>{$OpeningAmount}</td>
													<td>{$ReceivedAmount}</td>
													<td>{$PaymentAmount}</td>
													<td><b>{$Balance}</b></td>
													<td class='center'>
														<ul class='tooltipsample'>
															<li><form action='ReportLoanLedger' method='post'><input type='hidden' name='loan_id' value='{$loanid}' /><button class='btn ownbtn2' style='padding: 6px 9px;' onClick='submit();'><i class='fa iconfa-eye-open'></i></button></form></li>
															<li><a data-placement='top' data-rel='tooltip' href='#?id={$loanid}' data-original-title='Print' class='btn ownbtn7' style='padding: 6px 9px;'><i class='iconfa-print'></i></a></li>
														</ul>
													</td>
												</tr>\n";
				
					$x++;
					$ReceivedAmountt += $ReceivedAmount;
					$PaymentAmountt += $PaymentAmount;
					$TotBalance += $Balance;
					
				}?>
												<td></td>
												<td></td>
												<td style="text-align: right;"><b>TOTAL:</b></td>
												<td><b><?php echo $ReceivedAmountt; ?></b></td>
												<td><b><?php echo $PaymentAmountt; ?></b></td>
												<td><b><?php echo $TotBalance; ?></b></td>
												<td></td>
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