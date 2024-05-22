<?php
$titel = "My Bill";
$ClientsBill = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST); 
$id = $_SESSION['SESS_EMP_ID'];
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ClientsBill' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$resultgg = mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, breseller, mac_user FROM clients WHERE c_id = '$id'");
$rowgg = mysql_fetch_array($resultgg);	

if($rowgg['breseller'] == '2'){
$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.invoice_id, a.paydate, a.bill_date AS date, a.bill_amount, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
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
		if($rowgg['mac_user'] == '0'){
		$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.p_name, a.p_price, a.raw_download, a.raw_upload, a.total_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, p.p_name, p.p_price, c.raw_download, c.raw_upload, c.total_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$id'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, '', '', '', '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$id' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");
					
		$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$id'");
		}
		else{
$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.paydate, a.c_id, a.bill_date AS date, a.p_name, a.p_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
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
	
$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing_mac_client GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment_mac_client GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$id'");
		}
	}
	
$rows = mysql_fetch_array($sql2);
$Dew = $rows['due'];				
if($Dew > 0){
	$color = 'style="color:#ff3f3f;font-weight: bold;font-size: 20px;padding-bottom: 10px;"';					
} else{
	$color = 'style="color:#000;font-weight: bold;font-size: 20px;padding-bottom: 10px;font-family: Georgia;"';
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
		   docprint.document.write('<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/prettify.css" type="text/css" />');
		   docprint.document.write('<head><title>Billpayment</title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
		   docprint.document.write('.hidedisplay{display: none;}');
		   docprint.document.write('a{color:#000;text-decoration:none;}');
		   docprint.document.write('td{border: 1px solid black;}');
		   docprint.document.write('.gradeX{border: 1px solid black;}</style>');
		   docprint.document.write('</head><body onLoad="self.print()"><center>');
		   docprint.document.write(content_vlue);
		   docprint.document.write('</center></body></html>');
		   docprint.document.close();
		   docprint.focus();
		}
	</script>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 style="font-weight: bold;text-align: center;">Choose Payment Mathod</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv" style="text-align: center;">
					<div class="col-2" style="width: 100%;">
								<?php if($Dew > '2'){ if(in_array(1, $online_getway)){?>
									<a href="PaymentOnline?gateway=bKash"><img src="imgs/bk_rbttn.png" style="width: 40px;padding: 0px 15px 0 0;margin-top: -3px;"></a>
								<?php } if(in_array(6, $online_getway)){?>
									<a href="PaymentOnline?gateway=bKashT"><img src="imgs/bk_rbttn.png" style="width: 40px;padding: 0px 15px 0 0;margin-top: -3px;"></a>
								<?php } if(in_array(4, $online_getway)){?>
									<a href="PaymentOnline?gateway=Rocket"><img src="imgs/rocket_s.png" style="width: 40px;padding: 0px 15px 0 0;margin-top: -3px;border-radius: 10px;"></a>
								<?php } if(in_array(5, $online_getway)){?>
									<a href="PaymentOnline?gateway=Nagad"><img src="imgs/nagad_s.png" style="width: 40px;padding: 0px 15px 0 0;margin-top: -3px;border-radius: 10px;"></a>
								<?php } if(in_array(2, $online_getway)){?>
									<a href="PaymentOnline?gateway=iPay"><img src="imgs/ip_rbttn.png" style="width: 40px;padding: 0px 15px 0 0;margin-top: -3px;"></a>
								<?php } if(in_array(3, $online_getway)){?>
									<a href="PaymentOnline?gateway=SSLCommerz"><img src="imgs/ssl.png" style="width: 40px;margin-top: -3px;border-radius: 10px;"></a>
								<?php }} ?>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div><!--#myModal-->
	<div class="pageheader">
		<div class="searchbar">
		<div class="actionBar" style="border: 0px;">
		<?php if($Dew > '2'){ if(in_array(1, $online_getway) || in_array(2, $online_getway) || in_array(3, $online_getway) || in_array(4, $online_getway) || in_array(5, $online_getway) || in_array(6, $online_getway)){?>
			<a class="buttonNext" style="font-weight: bold;font-size: 13px;border: 3px solid #0866c6;" href="#myModal" data-toggle="modal">Online Payment</a>
		<?php }} ?>
        </div>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Bill & Payment Informations</h1>
        </div>
    </div><!--pageheader-->
	<?php if($sts == 'done') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $payment; ?> TK Successfully paid by <?php echo $mode; ?>.
			</div><!--alert-->
	<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
		<div id="divid">
			<div <?php echo $color; ?>>Due:&nbsp; <?php echo number_format($Dew,2).'tk';?></div>
					<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;">
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
                    </colgroup>
                    <thead>
                        <tr class="newThead">
							<th class="head1">Date</th>
							<?php if($rowgg['breseller'] == '2'){?>
							<th class="head0 center">Invoice No</th>
							<?php } else{ ?>
							<th class="head0">Package</th>
							<th class="head1 right">Package Rate</th>
							<th class="head0 right">P.Discount</th>
							<?php } ?>
							<th class="head1 right">Total Bill</th>
							<th class="head0 right">Discount</th>
							<th class="head1 right">Payment</th>
							<th class="head0 center">Mathod</th>
							<th class="head1 center">MR/TrxID</th>
							<th class="head0 center">Entry By</th>
							<th class="head1 center hidedisplay">Print</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rown = mysql_fetch_assoc($sql) )
								{
									
									$yrdata= strtotime($rown['date']);
									$month = date('d F, Y', $yrdata);
									
									if($rown['pay_idd'] != '#'){
										$ee = "<li><form action='fpdf/MRPrint' method='post' target='_blank' enctype='multipart/form-data'><input type='hidden' name='mrno' value='{$rown['pay_idd']}'/><input type='hidden' name='c_id' value='{$rown['c_id']}'/><button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>";
									}
									else{
										$ee = '';
									}
									
									if($rowgg['breseller'] == '2'){	if($rown['pay_idd'] == '#'){
											$invoprint = "<li><form action='fpdf/BillPrintInvoiceClient' title='Print Invoice' method='post' target='_blank'><input type='hidden' name='invoice_id' value='{$rown['invoice_id']}'/><button class='btn ownbtn6' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>";
										}
										else{
											$invoprint = "";
										} 
										echo
										"<tr class='gradeX'>
											<td style='vertical-align: middle;'>{$rown['dateee']}</td>
											<td class='center' style='vertical-align: middle;'><a href='#' style='font-size: 14px;font-weight: bold;'>{$rown['invoice_id']}</a></td>
											<td class='right' style='font-weight: bold;vertical-align: middle;'>{$rown['bill_amount']}</td>
											<td class='right' style='vertical-align: middle;'>{$rown['discount']}</td>
											<td class='right' style='font-weight: bold;vertical-align: middle;font-size: 16px;color: brown;'>{$rown['payment']}</td>
											<td class='center' style='vertical-align: middle;'>{$rown['pay_mode']}</td>
											<td class='center'>{$rown['moneyreceiptno']}{$rown['sender_no']}<br>{$rown['trxid']}</td>
											<td class='center' style='vertical-align: middle;'>{$rown['entrybyname']}</td>
											<td class='center hidedisplay' style='width: 100px !important;padding: 2px;vertical-align: middle;'>
												<ul class='tooltipsample'>
													{$invoprint}{$ee}
												</ul>
											</td>
										</tr>\n ";
									}
									else{
									echo
										"<tr class='gradeX'>
											<td style='vertical-align: middle;'>{$month}</td>
											<td style='vertical-align: middle;'>{$rown['p_name']}</td>
											<td class='right' style='vertical-align: middle;'>{$rown['p_price']}</td>
											<td class='right' style='vertical-align: middle;'>{$rown['p_discount']}</td>
											<td class='right' style='font-weight: bold;vertical-align: middle;'>{$rown['bill_amount']}</td>
											<td class='right' style='vertical-align: middle;'>{$rown['discount']}</td>
											<td class='right' style='font-weight: bold;vertical-align: middle;font-size: 16px;color: brown;'>{$rown['payment']}</td>
											<td class='center' style='vertical-align: middle;'>{$rown['pay_mode']}</td>
											<td class='center'>{$rown['moneyreceiptno']}{$rown['sender_no']}<br>{$rown['trxid']}</td>
											<td class='center' style='vertical-align: middle;'>{$rown['entrybyname']}</td>
											<td class='center hidedisplay' style='width: 100px !important;padding: 2px;vertical-align: middle;'>
												<ul class='tooltipsample'>
													{$ee}
												</ul>
											</td>
										</tr>\n ";
								}  }
							?>
					</tbody>
				</table>
			</div>
		</div>
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
