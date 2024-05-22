<?php
$titel = "Reports";
$Reports = 'active';
$ReportVendorLedger = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(175, $access_arry)){
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
			<input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>"/>
			<button class="btn col5" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Vendor Ledger</h1>
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
					<?php if($vendor_id !=''){
					$sqlop1 = mysql_query("SELECT SUM(amount) AS ISP FROM vendor_bill WHERE sts = '0' AND v_id = '$vendor_id' AND bill_date < '$f_date'");

					$rowop1 = mysql_fetch_array($sqlop1);
					$fundReceivedOp = $rowop1['ISP'];
					
					$sqlopCr1 = mysql_query("SELECT SUM(amount) AS VPT FROM expanse WHERE v_id = '$vendor_id' AND status = '2' AND ex_date < '$f_date'");
					
					$rowop7 = mysql_fetch_array($sqlopCr1);
					$fundSendOp = $rowop7['VPT'];
					
					
					$openingRecived = $fundReceivedOp;
					$openingPayment = $fundSendOp;
					
					$openingBalance = $openingRecived - $openingPayment;
					
					$Bankkk = mysql_query("SELECT id, v_name, cell, email, location, join_date FROM vendor WHERE id = '$vendor_id'");
					$Bnkkk=mysql_fetch_array($Bankkk);
					$vendorname = $Bnkkk['v_name'];
					$vendorcell = $Bnkkk['cell'];
					$vendorlocation = $Bnkkk['location'];
					$vendoremail = $Bnkkk['email'];
					$vendorjoin_date = $Bnkkk['join_date'];
					?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="padding-top: 5px;">Name:</th>
						<td><?php echo $vendorname.' ('.$vendorcell.')'; ?></td>
								
						<th style="padding-top: 5px;">Address:</th>
						<td><?php echo $location; ?></td>
						
						<th style="padding-top: 5px;">Email:</th>
						<td><?php echo $vendoremail; ?></td>
						
						<th style="padding-top: 5px;">joining Date:</th>
						<td><?php echo $vendorjoin_date; ?></td>
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
									<th class="head0">Bill</th>
									<th class="head1">Paid</th>
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
			
			$sql = mysql_query("SELECT p.id AS vp_id, p.auto_generate, DATE_FORMAT(p.bill_date, '%D %b-%y') AS bill_date,  DATE_FORMAT(p.bill_time, '%h:%i%p') AS bill_time, p.v_id, v.v_name, p.bill_type, t.ex_type, p.purpose, v.cell, v.location, p.note, p.amount, p.ent_by, e.e_name, p.sts FROM `vendor_bill` AS p
											LEFT JOIN vendor AS v ON v.id = p.v_id
											LEFT JOIN emp_info AS e ON e.e_id = p.ent_by
											LEFT JOIN expanse_type AS t ON t.id = p.purpose
											
											WHERE p.sts = '0' AND p.v_id = '$vendor_id' AND p.bill_date = '$f_date' ORDER BY p.bill_date_time DESC");
			$InstumentPurchase = 0;
			while ($row = mysql_fetch_array($sql)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $row['bill_date']; ?></b><br><?php echo $row['bill_time']; ?></td>
					<td><?php echo $row['ex_type']; ?> [Add by <?php echo $row['e_name'];?> as <?php echo $row['bill_type'];?>]</td>
					<td><?php echo $row['amount'].'/='; ?></td>
					<td class="center">-</td>
					<td></td>
					<td><?php echo $row['note']; ?></td>
				</tr>
			<?php	$InstumentPurchase += $row['amount'];
			}
		

	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
	
			$sqlCr = mysql_query("SELECT e.voucher, x.ex_type, DATE_FORMAT(e.ex_date, '%D %b-%y') AS ex_date, e.`ex_by`, i.e_name AS ex_by, e.`type`, e.`amount`, e.`mathod`, e.`entry_by`, q.e_name AS entry_by, DATE_FORMAT(e.enty_date, '%h:%i%p') AS enty_date , e.`note`, e.`v_id`, b.bank_name FROM `expanse` AS e 
									LEFT JOIN expanse_type AS x ON x.id = e.type
									LEFT JOIN emp_info AS i ON i.e_id = e.ex_by
									LEFT JOIN emp_info AS q ON q.e_id = e.entry_by
									LEFT JOIN bank AS b ON b.id = e.bank
									WHERE e.v_id = '$vendor_id' AND e.`status` = '2' AND e.`ex_date` = '$f_date' ORDER BY e.ex_date DESC");
			$VendorPaymentAmountCr = 0;
			while ($rowCr = mysql_fetch_array($sqlCr)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $rowCr['ex_date']; ?></b><br><?php echo $rowCr['enty_date']; ?></td>
					<td><?php echo $rowCr['ex_type']; ?> [Paid by <?php echo $rowCr['ex_by'];?> by <?php echo $rowCr['mathod'];?>] [Bank: <?php echo $rowCr['bank_name'];?>]</td>
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
					<?php } if($vendor_id ==''){ ?>
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
									<th class="head1">Reseler</th>
									<th class="head1" style='text-align: right;'>Opeaning Balance</th>
									<th class="head0" style='text-align: right;'>Recharge on Client</th>
									<th class="head1" style='text-align: right;'>Payment </th>
									<th class="head0" style='text-align: right;'>Balance</th>
									<th class="head1 center">Action</th>
								</tr>
							</thead>
							<tbody>
				<?php 
				
				
				$sqlBank = mysql_query("SELECT e.id, e.e_id, e.e_name, e.billing_type, e.minimum_day, m.Name AS mkname, e.pre_address, e.e_cont_per, e.e_j_date, z.z_id, z.z_name, COUNT(c.c_id) AS totalclient FROM emp_info AS e
													LEFT JOIN clients AS c ON e.z_id = c.z_id
													LEFT JOIN zone AS z	ON z.z_id = e.z_id
													LEFT JOIN mk_con AS m ON m.id = e.mk_id
													WHERE e.dept_id = '0' AND e.`status` = '0' AND e.z_id != '' GROUP BY e.z_id ORDER BY totalclient DESC");
				
				
				$x = 1;
				$TotBalance = 0;
				$ReceivedAmountt = 0;
				$PaymentAmountt = 0;
				while ($rowBank = mysql_fetch_array($sqlBank)) {
					$ResellerId = $rowBank['id'];
					$ResellerZId = $rowBank['z_id'];
					$ResellerName = $rowBank['e_name'];
					$ResellerCell = $rowBank['e_cont_per'];
					$ResellerTotalClient = $rowBank['totalclient'];
					$ResellerZoneName = $rowBank['z_name'];
					
					$sqlOp = mysql_query("SELECT SUM(bill_amount) AS bill_amount FROM billing_mac WHERE sts = '0' AND z_id = '$ResellerZId' AND entry_date < '$f_date'");
					$rowOp = mysql_fetch_array($sqlOp);		
					$bill_amountOp = $rowOp['bill_amount'];

					$sqlOp1 = mysql_query("SELECT (SUM(discount)+SUM(pay_amount)) AS totalpayment FROM payment_macreseller WHERE sts = '0' AND z_id = '$ResellerZId' AND pay_date < '$f_date'");
					$rowOp1 = mysql_fetch_array($sqlOp1);		
					$totalpaymentOp = $rowOp1['totalpayment'];
					
					$OpeningAmount =  $totalpaymentOp - $bill_amountOp;
					
					$sql = mysql_query("SELECT SUM(bill_amount) AS bill_amount FROM billing_mac WHERE sts = '0' AND z_id = '$ResellerZId' AND entry_date BETWEEN '$f_date' AND '$t_date'");
					$row = mysql_fetch_array($sql);		
					$billAmount = $row['bill_amount'];
					$billAmounte = $row['bill_amount'];
					
					$sql1 = mysql_query("SELECT (SUM(discount)+SUM(pay_amount)) AS totalpayment FROM payment_macreseller WHERE sts = '0' AND z_id = '$ResellerZId' AND pay_date BETWEEN '$f_date' AND '$t_date'");
					$row1 = mysql_fetch_array($sql1);
					$totalpaymentAmount = $row1['totalpayment'];
					$Balance = ($totalpaymentAmount - ($billAmounte + $OpeningAmount));

					echo
												"<tr class='gradeX'>
													<td class='center' style='font-size: 15px;'><b>{$x}</b></td>
													<td><b>{$ResellerName}</b><br>{$ResellerCell}<br>{$ResellerZoneName}<br>{$ResellerTotalClient}</td>
													<td style='text-align: right;'>{$OpeningAmount}</td>
													<td style='text-align: right;'>{$billAmounte}</td>
													<td style='text-align: right;'>{$totalpaymentAmount}</td>
													<td style='text-align: right;font-size: 15px;'><b>{$Balance}</b></td>
													<td class='center'>
														<ul class='tooltipsample'>
															<li><form action='ReportMacResellerLedger' method='post'><input type='hidden' name='z_id' value='{$ResellerZId}' /><button class='btn col1' onClick='submit();'><i class='fa iconfa-eye-open'></i></button></form></li>
														</ul>
													</td>
												</tr>\n";
					$x++;
					$ReceivedAmountt += $billAmounte;
					$PaymentAmountt += $totalpaymentAmount;
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