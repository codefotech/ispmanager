<?php
$titel = "Bills & Payment History";
$Billing = 'active';
include('include/hader.php');
$id = $_GET['id'];
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '11' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(130, $access_arry)){
//---------- Permission -----------

ini_alter('date.timezone','Asia/Almaty');
$this_month_yr = date('Y-m', time());

$resultgg = mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, breseller, mac_user FROM clients WHERE c_id = '$id'");
$rowgg = mysql_fetch_array($resultgg);	

if($rowgg['mac_user'] == '0'){
	if($rowgg['breseller'] == '2'){
$sqlasa = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.invoice_id, a.paydate, a.bill_date AS date, a.bill_amount, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
(
SELECT b.c_id, b.invoice_date AS bill_date, b.invoice_id, '' AS paydate, SUM(b.total_price) AS bill_amount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.date_time AS pay_date_time
										FROM billing_invoice AS b
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.c_id = '$id' AND b.sts = '0' GROUP BY b.invoice_id
						UNION
SELECT p.c_id, p.pay_date AS bill_date, '' AS invoice_id, pay_date AS paydate, '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$id' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");

$result = mysql_query("SELECT c_id, c_name, cell, address FROM clients WHERE c_id = '$id'");
$row = mysql_fetch_array($result);	

$sql1 = mysql_query("SELECT pay_date, pay_amount, bill_discount FROM payment WHERE c_id = '$id' ORDER BY pay_date");

$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(total_price) AS bill FROM billing_invoice WHERE sts = '0' GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment WHERE sts = '0' GROUP BY c_id)p
						ON p.c_id = c.c_id
						WHERE c.c_id = '$id'");
	}
	else{
$sqlasa = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.c_id, a.paydate, a.bill_date AS date, a.p_name, a.p_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, '' AS paydate, p.p_name, p.p_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$id'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, pay_date AS paydate, '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$id' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");

$result = mysql_query("SELECT c_id, c_name, cell, address FROM clients WHERE c_id = '$id'");
$row = mysql_fetch_array($result);	

$sql1 = mysql_query("SELECT pay_date, pay_amount, bill_discount FROM payment WHERE c_id = '$id' ORDER BY pay_date");

$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$id'");
}}
else{

$sqlasa = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.paydate, a.c_id, a.bill_date AS date, a.p_name, a.p_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, '' AS paydate, p.p_name, p.p_price_reseller AS p_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing_mac_client AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$id'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, pay_date AS paydate, '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment_mac_client AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$id' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.bill_date");

$result = mysql_query("SELECT c_id, c_name, cell, address FROM clients WHERE c_id = '$id'");
$row = mysql_fetch_array($result);	

$sql1 = mysql_query("SELECT pay_date, pay_amount, bill_discount FROM payment_mac_client WHERE c_id = '$id' ORDER BY pay_date");

$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing_mac_client GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment_mac_client GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$id'");
}
$rows = mysql_fetch_array($sql2);
$Dew = $rows['due'];
			
if($Dew > 0){
	$color = 'style="color:red;"';					
} else{
	$color = 'style="color:#000;"';
}
	?>
<link rel="stylesheet" href="css/reset-fonts-grids.css" type="text/css" />
<link rel="stylesheet" href="css/resume.css" type="text/css" />
	<script language="javascript">
		function PrintMe(DivID) {
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=1050, height=800, left=50, top=25";
		   var content_vlue = document.getElementById(DivID).innerHTML;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		   docprint.document.write('<link rel="stylesheet" href="css/style.default.print.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/style.default.css" type="text/css" />');
		   docprint.document.write('<head><title>Billpayment</title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
		   docprint.document.write('.hidedisplay{display: none;}');
		   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
		   docprint.document.write('</head><body onLoad="self.print()"><center>');
		   docprint.document.write(content_vlue);
		   docprint.document.write('</center></body></html>');
		   docprint.document.close();
		   docprint.focus();
		}
	</script>
	
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" href="Billing"><i class="iconfa-arrow-left"></i>  Back</a>
			<button class="btn ownbtn2" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Ledger</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
		<?php if($sts == 'delete') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong style="font-weight: normal !important;">Success!!</strong> <?php echo $titel;?> Successfully Deleted from The Database.
			</div><!--alert-->
		<?php } ?>
		<div id="divid">
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:right">Client ID&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['c_id']; ?></td>
								
						<th style="text-align:right">Client Name&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['c_name']; ?></td>
							
						<th style="text-align:right">Cell No&nbsp;:&nbsp; </th>
						<td>&nbsp; <?php echo $row['cell']; ?></td>
							
						<th style="text-align:right">Total Due&nbsp;:&nbsp; </th>
						<td <?php echo $color; ?>> &nbsp; <?php echo number_format($Dew,2); ?></td>
					</tr>	
				</table>
			</div>
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
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
							<th class="head1">Date</th>
							<?php if($rowgg['breseller'] == '2'){?>
							<th class="head0 center">Invoice No</th>
							<?php } else{ ?>
							<th class="head0 center">Package</th>
							<th class="head1 right">Package Rate</th>
							<th class="head0 right">P.Discount</th>
							<th class="head1 right">P.Extra Bill</th>
							<?php } ?>
							<th class="head0 right">Total Bill</th>
							<th class="head1 right">Discount</th>
							<th class="head0 right">Payment</th>
							<th class="head1 center">Mathod</th>
							<th class="head0 center">MR/TrxID</th>
							<th class="head1 center">Entry By</th>
							<th class="head0 center hidedisplay">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $row = mysql_fetch_assoc($sqlasa) )
								{
									$yrdata1= strtotime($row['paydate']);
									$month_yr = date('Y-m', $yrdata1);
									
									
									if($row['pay_idd'] != '#'){
										if($this_month_yr == $month_yr && in_array(246, $access_arry)){
											$ss = "<li><form action='PaymentDeleteClient' method='post' enctype='multipart/form-data'><input type='hidden' name='py_id' value='{$row['pay_idd']}'/><input type='hidden' name='mac_user' value='{$rowgg['mac_user']}'/> <button class='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()'><i class='iconfa-remove'></i></button></form></li>";
										}
										else{
											$ss = '';
										}
										if(in_array(245, $access_arry)){
											$ee = "<li><form action='fpdf/MRPrint' method='post' target='_blank' enctype='multipart/form-data'><input type='hidden' name='mrno' value='{$row['pay_idd']}'/><input type='hidden' name='c_id' value='{$row['c_id']}'/><button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>";
										}
										}
									else{
										$ss = '';										
										$ee = '';
									}
									if($rowgg['breseller'] == '2'){
									$yrdatad1= strtotime($row['date']);
									$month_yrd = date('Y-m', $yrdatad1);
										if($this_month_yr == $month_yrd && $row['pay_idd'] == '#'){
											$addfd = "<li><form action='ClientsBillAdjust' title='Add/Adjustment Invoice' method='post' enctype='multipart/form-data'><input type='hidden' name='c_id' value='{$id}'/><input type='hidden' name='usertype' value='{$user_type}'/> <button class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-plus'></i></button></form></li>";
										}
										else{
											$addfd = '';
										}
										if(in_array(245, $access_arry) && $row['pay_idd'] == '#'){
											$invoprint = "<li><form action='fpdf/BillPrintInvoiceClient' title='Print Invoice' method='post' target='_blank'><input type='hidden' name='invoice_id' value='{$row['invoice_id']}'/><button class='btn ownbtn6' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>";
										}
										else{
											$invoprint = "";
										} 
									echo
										"<tr class='gradeX'>
											<td>{$row['dateee']}</td>
											<td class='center'><a href='BillInvoiceView.php?id={$row['invoice_id']}' style='font-size: 15px;font-weight: bold;'>{$row['invoice_id']}</a></td>
											<td class='right'>{$row['bill_amount']}</td>
											<td class='right'>{$row['discount']}</td>
											<td class='right'>{$row['payment']}</td>
											<td class='center'>{$row['pay_mode']}</td>
											<td class='center'>{$row['moneyreceiptno']}{$row['sender_no']}<br>{$row['trxid']}</td> 
											<td class='center'>{$row['entrybyname']}</td>
											<td class='center hidedisplay' style='width: 100px !important;'>
												<ul class='tooltipsample'>
												{$ee}{$ss}{$invoprint}{$addfd}
												</ul>
											</td>
										</tr>\n";
									}
									else{
										echo
										"<tr class='gradeX'>
											<td>{$row['dateee']}</td>
											<td class='center'>{$row['p_name']}</td>
											<td class='right'>{$row['p_price']}</td>
											<td class='right'>{$row['p_discount']}</td>
											<td class='right'>{$row['extra_bill']}</td>
											<td class='right'>{$row['bill_amount']}</td>
											<td class='right'>{$row['discount']}</td>
											<td class='right'>{$row['payment']}</td>
											<td class='center'>{$row['pay_mode']}</td>
											<td class='center'>{$row['moneyreceiptno']}{$row['sender_no']}<br>{$row['trxid']}</td>
											<td class='center'>{$row['entrybyname']}</td>
											<td class='center hidedisplay' style='width: 70px !important;'>
												<ul class='tooltipsample'>
												{$ee}{$ss}
												</ul>
											</td>
										</tr>\n";
									}
								}
								
									
							?>
					</tbody>
				</table>
			</div>
		</div></div>
		<div class="modal-footer">
			<button class="btn ownbtn2" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')"><i class="iconfa-print"></i> Print</button>
		</div>
	</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete Payment!!  Are you sure?');
}
</script>