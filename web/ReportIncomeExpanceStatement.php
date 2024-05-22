<?php
$titel = "Reports";
$Reports = 'active';
$ReportIncomeExpanceStatement = 'activeted';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(156, $access_arry)){
//---------- Permission -----------
$userName = $_SESSION['SESS_FIRST_NAME'];
$Date = date('d/m/Y');

if($f_date == '' || $t_date == ''){
$f_date = date("Y-m-01");
$t_date = date("Y-m-d");}

?>
	<script language="javascript">
		function PrintMe(DivID) {
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=1050px, height=800px, left=50, top=25";
		   var content_vlue = document.getElementById(DivID).innerHTML;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		   docprint.document.write('<link rel="stylesheet" href="css/style.default.print.css" type="text/css"/>');
		   docprint.document.write('<link rel="stylesheet" href="css/style.default.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css"/>');
		   docprint.document.write('<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css"/>');
		   docprint.document.write('<link rel="stylesheet" href="css/prettify.css" type="text/css"/>');
		   docprint.document.write('<head><title>Income_Statement_<?php echo $f_date;?>_to_<?php echo $t_date;?></title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
		   docprint.document.write('.hidedisplay{display: none;}');
		   docprint.document.write('.table{border: 1px solid black;}');
		   docprint.document.write('.table.table-bordered{border: 1px solid black;}');
		   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
		   docprint.document.write('</head><body onLoad="self.print()"><center>');
		   docprint.document.write(content_vlue);
		   docprint.document.write('</center></body></html>');
		   docprint.document.close();
		   docprint.focus();
		}
	</script>
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
            <h1>Income Statement</h1>
        </div>
    </div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="span3 profile-left" style="">
				<div class="list-group">
					<?php require('include/Reports_menu.php'); ?>
				</div>
			</div>
			<div class="span9 rightside" style="width: 74% !important; margin-left: 15px !important;">
				<div class="box box-primary" style="margin: 0px;">
					<div class="box-body" style="min-height: 440px;">
					<div id="divid">
						<center>
					<?php 
					$sqlop2 = mysql_query("SELECT SUM(amount) AS TLR FROM loan_receive WHERE bank != '' AND loan_date < '$f_date'");
					$sqlop3 = mysql_query("SELECT SUM(pay_amount) AS TBC FROM payment WHERE bank != '' AND pay_date  < '$f_date'");
					$sqlop400 = mysql_query("SELECT SUM(amount) AS OBS FROM bill_signup WHERE bank != '' AND pay_date < '$f_date'");
					$sqlop600 = mysql_query("SELECT SUM(amount) AS EBS FROM bill_extra WHERE bank != '' AND pay_date < '$f_date'");
					$sqlop500 = mysql_query("SELECT SUM(pay_amount) AS MRP FROM payment_macreseller WHERE sts = '0' AND bank != '' AND pay_date < '$f_date'");
					
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
					
					$sqlopCr2 = mysql_query("SELECT SUM(amount) AS TLP FROM loan_payment WHERE bank != '' AND payment_date < '$f_date'");
					$sqlopCr4 = mysql_query("SELECT SUM(amount) AS TP FROM expanse WHERE bank != '' AND status = '2' AND ex_date < '$f_date'");
					$sqlopCr6 = mysql_query("SELECT SUM(amount) AS VPP FROM vendor_payment WHERE bank != '' AND sts = '0' AND payment_date < '$f_date'");
										
					$rowop8 = mysql_fetch_array($sqlopCr2);
					$loanPaidOp = $rowop8['TLP'];
					
					$rowop10 = mysql_fetch_array($sqlopCr4);
					$allPaymentOp = $rowop10['TP'];
					
					$rowop12 = mysql_fetch_array($sqlopCr6);
					$allVpOp = $rowop12['VPP'];
					
					$openingRecived = $loanReceiveOp + $billSignupOp + $ExtraBillOp + $billCollectionOp + $MacresellerPaymentOp;
					$openingPayment = $loanPaidOp + $allPaymentOp + $allVpOp;
					
					$openingBalance = $openingRecived - $openingPayment;

					?>

					<table id="dyntable" class="table table-bordered responsive">
						<colgroup>
								<col class="con0" />
								<col class="con1" />
								<col class="con0" />
						</colgroup>
						<thead>
								<tr  class="newThead">
									<th class="head0">Income Type</th>
									<th class="head1">Object</th>
									<th class="head0">Amount</th>
								</tr>
						</thead>
					<tbody>
					<tr class='gradeX'>
						<td colspan="2" style="text-align: right;"><b>Opeaning Balance:</b></td>
						<td><b><?php echo $openingBalance; ?></b></td>
					</tr>
					<?php			
					$x = 1;
					$TotBillCollectionAmountttt = 0;
					$TotbillsignupAmounttt = 0;
					$TotOthersFeeAmounttt = 0;
					$TotbillextraAmounttt = 0;
					$TotResellerBillCollectionnn = 0;
					$TotLoanAmounttt = 0;
		//------------------------------------------------------------Received Amount---------------------------------------------------------------------------------	
		
			$sql1qqqmm = mysql_query("SELECT COUNT(id) AS object, IFNULL(SUM(pay_amount), 0.00) AS amount FROM payment 
									WHERE bank != '' AND pay_date BETWEEN '$f_date' AND '$t_date'");
			$TotBillCollectionAmount = 0;
			while ($row1qqqmm = mysql_fetch_array($sql1qqqmm)) {?>
				<tr class='gradeX'>
					<td style="font-weight: bold;"><?php echo 'Bill Collection'; ?></td>
					<td><?php echo $row1qqqmm['object']; ?></td>
					<td><?php echo $row1qqqmm['amount']; ?></td>
				</tr>
			<?php	$TotBillCollectionAmount += $row1qqqmm['amount'];
			}
			
			$sql1qqq = mysql_query("SELECT COUNT(id) AS object, IFNULL(SUM(amount), 0.00) AS amount FROM bill_signup 
									WHERE bill_type = '5' and bank != '' AND pay_date BETWEEN '$f_date' AND '$t_date'");
			$TotbillsignupAmount = 0;
			while ($row1qqq = mysql_fetch_array($sql1qqq)) {?>
				<tr class='gradeX'>
					<td style="font-weight: bold;"><?php echo 'Signup Fee Collection'; ?></td>
					<td><?php echo $row1qqq['object']; ?></td>
					<td><?php echo $row1qqq['amount']; ?></td>
				</tr>
			<?php	$TotbillsignupAmount = $row1qqq['amount'];
			}
			
			$sql1qqqeee = mysql_query("SELECT COUNT(id) AS object, IFNULL(SUM(amount), 0.00) AS amount FROM bill_signup 
										WHERE bill_type != '5' and bank != '' AND pay_date BETWEEN '$f_date' AND '$t_date'");
			$TotOthersFeeAmount = 0;
			while ($row1qqqeee = mysql_fetch_array($sql1qqqeee)) {?>
				<tr class='gradeX'>
					<td style="font-weight: bold;"><?php echo 'Others Collection'; ?></td>
					<td><?php echo $row1qqqeee['object']; ?></td>
					<td><?php echo $row1qqqeee['amount']; ?></td>
				</tr>
			<?php	$TotOthersFeeAmount = $row1qqqeee['amount'];
			}
			
			$sql1ex = mysql_query("SELECT COUNT(id) AS object, IFNULL(SUM(amount), 0.00) AS amount FROM bill_extra 
								WHERE bank != '' AND pay_date BETWEEN '$f_date' AND '$t_date'");
			$TotbillextraAmount = 0;
			while ($row1ex = mysql_fetch_array($sql1ex)) {;?>
				<tr class='gradeX'>
					<td style="font-weight: bold;"><?php echo 'Extra Income (Out Side)'; ?></td>
					<td><?php echo $row1ex['object']; ?></td>
					<td><?php echo $row1ex['amount']; ?></td>
				</tr>
			<?php	$TotbillextraAmount = $row1ex['amount'];
			}
			
			$sql2 = mysql_query("SELECT COUNT(id) AS object, IFNULL(SUM(pay_amount), 0.00) AS amount FROM payment_macreseller
								WHERE bank != '' AND sts = '0' AND pay_date BETWEEN '$f_date' AND '$t_date'");
			$TotResellerBillCollection = 0;
			while ($row2 = mysql_fetch_array($sql2)) {?>
				<tr class='gradeX'>
					<td style="font-weight: bold;"><?php echo 'Reseller Bill Collection'; ?></td>
					<td><?php echo $row2['object']; ?></td>
					<td><?php echo $row2['amount']; ?></td>
				</tr>
			<?php	$TotResellerBillCollection = $row2['amount'];
			}

			$sql1 = mysql_query("SELECT IFNULL(SUM(amount), 0.00) as amount, COUNT(id) as object FROM loan_receive
								WHERE bank != '' AND loan_date BETWEEN '$f_date' AND '$t_date'");
			$TotLoanAmount = 0;
			while ($row1 = mysql_fetch_array($sql1)) {;?>
				<tr class='gradeX'>
					<td style="font-weight: bold;"><?php echo 'Loan Received'; ?></td>
					<td><?php echo $row1['object']; ?></td>
					<td><?php echo $row1['amount']; ?></td>
				</tr>
			<?php	$TotLoanAmount = $row1['amount'];
			}

			$x++;
			$TotBillCollectionAmountttt += $TotBillCollectionAmount;
			$TotbillsignupAmounttt += $TotbillsignupAmount;
			$TotOthersFeeAmounttt += $TotOthersFeeAmount;
			$TotbillextraAmounttt += $TotbillextraAmount;
			$TotResellerBillCollectionnn += $TotResellerBillCollection;
			$TotLoanAmounttt += $TotLoanAmount;

			$ReciveTotal = $TotBillCollectionAmountttt + $TotbillsignupAmounttt + $TotOthersFeeAmounttt + $TotbillextraAmounttt + $TotResellerBillCollectionnn + $TotLoanAmounttt;
			
			$yrdatas= strtotime($f_date);
			$fdate = date('d-M, Y', $yrdatas);
			
			$yrdatasd= strtotime($t_date);
			$tdate = date('d-M, Y', $yrdatasd);
			?>
				<tr class='gradeX'>
					<td colspan="2" style="text-align: right;"><b>[<?php echo $fdate;?>] To [<?php echo $tdate;?>]</b></td>
					<td><b><?php echo number_format($ReciveTotal,2); ?></b></td>
				</tr>
				<tr class='gradeX'>
					<td colspan="2" style="text-align: right;"><b>TOTAL INCOME</b></td>
					<td><b><?php echo number_format(($ReciveTotal + $openingBalance),2); ?></b></td>
				</tr>
					</tbody>
					</table><br>
					
					<table id="dyntable" class="table table-bordered responsive">
						<colgroup>
								<col class="con1" />
								<col class="con0" />
								<col class="con0" />
								<col class="con1" />
								<col class="con0" />
						</colgroup>
						<thead>
								<tr  class="newThead">
									<th class="head1" style="width: 50%;">Expense Type</th>
									<th class="head0 center" style="width: 10%;">Category</th>
									<th class="head1 center" style="width: 5%;">Object</th>
									<th class="head0" style="width: 20%;">Amount</th>
									<th class="head1 center hidedisplay" style="width: 5%;">VIEW</th>
								</tr>
						</thead>
					<tbody>
					<?php			
					$x = 1;
					$TotalAmountCr = 0;
					$TotalExAmountCr = 0;
					$TotMacPayAmounttt = 0;
					
	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
			
			$sql1Crrr = mysql_query("SELECT COUNT(id) AS object, IFNULL(SUM(amount), 0.00) AS amount FROM loan_payment
									WHERE bank != '' AND payment_date BETWEEN '$f_date' AND '$t_date'");
			$TotAmountCr = 0;
			while ($row1Crrr = mysql_fetch_array($sql1Crrr)) {;?>
				<tr class='gradeX'>
					<td><b><?php echo 'Loan Payment';?></b></td>
					<td style='text-align: center;'></td>
					<td style='text-align: center;'><?php echo $row1Crrr['object']; ?></td>
					<td><?php echo $row1Crrr['amount']; ?></td>
					<td class="hidedisplay"></td>
				</tr>
			<?php	$TotAmountCr = $row1Crrr['amount'];
			}
			
			$sql2Cr = mysql_query("SELECT t.ex_type, e.type, e.category, COUNT(e.type) AS object, SUM(e.amount) AS amount FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank != '' AND e.status = '2' AND e.ex_date BETWEEN '$f_date' AND '$t_date' GROUP BY e.type ORDER BY t.ex_type ASC");
			$TotExAmountCr = 0;
			while ($row2Cr = mysql_fetch_array($sql2Cr)) {
				if($row2Cr['category'] == '0'){
						$categoryyy = "<span class='label label-success' style='font-weight: bold;border-radius: 7px;'>Office Expense<span>";
					}
				if($row2Cr['category'] == '1'){
						$categoryyy = "<span class='label label-important' style='font-weight: bold;border-radius: 7px;'>Vendor Bill Pay<span>";
					}
				if($row2Cr['category'] == '2'){
						$categoryyy = "<span class='label label-warning' style='font-weight: bold;border-radius: 7px;'>Agent Commission Pay<span>";
					}
				if($row2Cr['category'] == '3'){
						$categoryyy = "<span class='label label-warning' style='font-weight: bold;border-radius: 7px;background: #9100a6bd !important;'>Invest Expense<span>";
					}
				?>
			
				<tr class='gradeX'>
					<td><b><?php echo $row2Cr['ex_type'];?></b></td>
					<td style='text-align: center;'><?php echo $categoryyy;?></td>
					<td style='text-align: center;'><?php echo $row2Cr['object']; ?></td>
					<td><?php echo $row2Cr['amount']; ?></td>
					<td style="width: 10px;text-align: center;" class="hidedisplay">
						<form id="" name="form" class="stdform" method="post" action="fpdf/ReportExpenceHead" target="_blank">
							<input type="hidden" name="type" value="<?php echo $row2Cr['type']; ?>"/>
							<input type="hidden" name="e_id" value="all"/>
							<input type="hidden" name="f_date" value="<?php echo $f_date; ?>"/>
							<input type="hidden" name="t_date" value="<?php echo $t_date; ?>"/>
						<button class="btn ownbtn2" style='padding: 6px 9px;' type="submit"><i class="fa iconfa-eye-open"></i></button>
						</form>
					</td>
				</tr>
			<?php	$TotExAmountCr += $row2Cr['amount'];
			}
			
			$sql2CrOff = mysql_query("SELECT t.ex_type, e.type, e.category, COUNT(e.type) AS object, SUM(e.amount) AS amount FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank != '' AND e.category = '0' AND e.status = '2' AND e.ex_date BETWEEN '$f_date' AND '$t_date' GROUP BY e.category");
			$rowwwwsgsg = mysql_fetch_array($sql2CrOff);
			$office_exp = $rowwwwsgsg['amount'];
			
			$sql2CrVen = mysql_query("SELECT t.ex_type, e.type, e.category, COUNT(e.type) AS object, SUM(e.amount) AS amount FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank != '' AND e.category = '1' AND e.status = '2' AND e.ex_date BETWEEN '$f_date' AND '$t_date' GROUP BY e.category");
			$rowwwwsgsgw = mysql_fetch_array($sql2CrVen);
			$vend_exp = $rowwwwsgsgw['amount'];
			
			$sql2CrAge = mysql_query("SELECT t.ex_type, e.type, e.category, COUNT(e.type) AS object, SUM(e.amount) AS amount FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank != '' AND e.category = '2' AND e.status = '2' AND e.ex_date BETWEEN '$f_date' AND '$t_date' GROUP BY e.category");
			$rowwsgsgw = mysql_fetch_array($sql2CrAge);
			$agent_exp = $rowwsgsgw['amount'];
			
			$sql8CrOff = mysql_query("SELECT t.ex_type, e.type, e.category, COUNT(e.type) AS object, SUM(e.amount) AS amount FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank != '' AND e.category = '3' AND e.status = '2' AND e.ex_date BETWEEN '$f_date' AND '$t_date' GROUP BY e.category");
			$rowwwwsgsggg = mysql_fetch_array($sql8CrOff);
			$investment_exp = $rowwwwsgsggg['amount'];
			$x++;

			$TotalAmountCr += $TotAmountCr;
			$TotalExAmountCr += $TotExAmountCr;

			$PaidTotal = $TotalAmountCr + $TotalExAmountCr;?>
				<tr class='gradeX'>
					<td colspan="3" style="text-align: right;"><b>TOTAL EXPENSE</b></td>
					<td colspan="2"><b><?php echo number_format(($PaidTotal),2); ?></b></td>
				</tr>
					</tbody>
					</table>
					<br>
					<div class="row">
						<div style="padding-left: 15px; width: 99%;">
							<table class="table table-bordered table-invoice" style="width: 47.5%; float: left;">
								<tr>
									<td class=""><strong>Opeaning Balance</strong></td>
									<td class=""><?php echo number_format($openingBalance,2); ?></td>
								</tr>
								<tr>
									<td class=""><strong>Bill Collection</strong></td>
									<td class=""><?php echo number_format($TotBillCollectionAmountttt,2); ?></td>
								</tr>
								<tr>
									<td><strong>Others Income</strong></td>
									<td><?php echo number_format($TotbillsignupAmounttt+$TotOthersFeeAmounttt+$TotbillextraAmounttt,2); ?></td>
								</tr>
								<tr>
									<td><strong>Reseller Payment</strong></td>
									<td><?php echo number_format($TotResellerBillCollectionnn,2); ?></td>
								</tr>
								<tr>
									<td><strong>Loan Received</strong></td>
									<td><?php echo number_format($TotLoanAmounttt,2); ?></td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;"><strong>TOTAL INCOME</strong></td>
									<td style="font-size: 13px;"><strong><?php echo number_format($ReciveTotal + $openingBalance,2); ?> ৳</strong></td>
								</tr>
							</table>
							<table class="table table-bordered table-invoice" style="width: 47.5%; float: left; margin-left: 15px;">
								<tr>
									<td><strong>Loan Payment</strong></td>
									<td><?php echo number_format($TotalAmountCr,2); ?></td>
								</tr>
								<tr>
									<td><strong>Office Expense</strong></td>
									<td><?php echo number_format($office_exp,2); ?></td>
								</tr>
								<tr>
									<td><strong>Vendor Bill Pay</strong></td>
									<td><?php echo number_format($vend_exp,2); ?></td>
								</tr>
								<tr>
									<td><strong>Agent Commission Pay</strong></td>
									<td><?php echo number_format($agent_exp,2); ?></td>
								</tr>
								<tr>
									<td><strong>Investment</strong></td>
									<td><?php echo number_format($investment_exp,2); ?></td>
								</tr>
								<tr>
									<td style="text-align: right;font-size: 13px;"><strong>Total Paid</strong></td>
									<td style="font-size: 13px;"><strong><?php echo number_format($PaidTotal,2); ?> ৳</strong></td>
								</tr>
							</table>
						</div><!--col-md-6-->
						</div>
						<div class="row">
							<table class="table table-bordered table-invoice" style="width: 52.5%;margin-top: 40px;">
								<tr>
									<td style="text-align: right;font-size: 20px;background: grey;color: white;;"><strong>Closing Balance</strong></td>
									<td style="text-align: left;font-size: 30px;background: teal;color: white;"><strong><?php echo number_format((($ReciveTotal + $openingBalance) - $PaidTotal),2); ?>৳</strong></td>
								</tr>
							</table>
					</div>
						</center>
					</div>
					<button class="btn btn-danger" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
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