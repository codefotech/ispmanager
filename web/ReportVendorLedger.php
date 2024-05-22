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
			<button class="btn ownbtn2" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
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
									<th class="head0">SL</th>
									<th class="head1">Vendor</th>
									<th class="head1">Opeaning Balance</th>
									<th class="head0">Bill Amount</th>
									<th class="head1">Paid Amount</th>
									<th class="head0">Balance</th>
									<th class="head1 center">Action</th>
								</tr>
							</thead>
							<tbody>
				<?php $sqlBank = mysql_query("SELECT id, v_name, cell, email, location, join_date FROM vendor ORDER BY id ASC");
				$x = 1;
				$TotBalance = 0;
				$ReceivedAmountt = 0;
				$PaymentAmountt = 0;
				while ($rowBank = mysql_fetch_array($sqlBank)) {
					$VenId = $rowBank['id'];
					$VenName = $rowBank['v_name'];
					$VenCell = $rowBank['cell'];
					$VenEmail = $rowBank['email'];
					$VenLocation = $rowBank['location'];
					
					$sqlOp = mysql_query("SELECT * FROM 
										(
										SELECT id, v_name, cell FROM vendor WHERE id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT v_id, SUM(amount) AS insprice FROM vendor_bill WHERE sts = '0' AND v_id = '$VenId' AND bill_date < '$f_date'
										)b ON a.id = b.v_id");
					$rowOp = mysql_fetch_array($sqlOp);		
					$ReceivedAmountOp = $rowOp['insprice'];
					
					$sqlOp1 = mysql_query("SELECT * FROM 
										(
										SELECT id, v_name, cell FROM vendor WHERE id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT v_id, IFNULL(SUM(amount), 0) AS vanpayamount FROM expanse WHERE v_id = '$VenId' AND status = '2' AND ex_date < '$f_date'
										)b ON a.id = b.v_id");
					$rowOp1 = mysql_fetch_array($sqlOp1);		
					$PaymentAmountOp = $rowOp1['vanpayamount'];
					$OpeningAmount = $ReceivedAmountOp - $PaymentAmountOp;
					
					$sql = mysql_query("SELECT * FROM 
										(
										SELECT id, v_name, cell FROM vendor WHERE id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT v_id, IFNULL(SUM(amount), 0) AS insprice FROM vendor_bill WHERE sts = '0' AND v_id = '$VenId' AND bill_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.id = b.v_id");
					$row = mysql_fetch_array($sql);		
					$ReceivedAmount = $row['insprice'] + $row['fibprice'];
					
					$sql1 = mysql_query("SELECT a.id, b.v_id, IFNULL(b.vanpaya, 0) AS vanpayamount FROM 
										(
										SELECT id, v_name, cell FROM vendor WHERE id = '$VenId'
										)a
										LEFT JOIN
										(
										SELECT v_id, SUM(amount) AS vanpaya FROM expanse WHERE v_id = '$VenId' AND status = '2' AND ex_date BETWEEN '$f_date' AND '$t_date'
										)b ON a.id = b.v_id");
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
															<li><form action='ReportVendorLedger' method='post'><input type='hidden' name='vendor_id' value='{$VenId}' /><button class='btn ownbtn2' onClick='submit();'><i class='fa iconfa-eye-open'></i></button></form></li>
															<li><a data-placement='top' data-rel='tooltip' href='#?id={$VenId}' data-original-title='Print' class='btn ownbtn7'  style='padding: 6px 9px;'><i class='iconfa-print'></i></a></li>
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