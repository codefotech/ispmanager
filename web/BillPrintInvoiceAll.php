<?php
$titel = "Bill Print";
$Billing = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$c_id = $_GET['id'];

$todayy = date("Y-m-d");

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$f_date = date('Y-m-01', strtotime($todayy));
$t_date = date('Y-m-t', strtotime($todayy));

$result = mysql_query("SELECT t1.c_id, t1.address, t1.note, t1.cell, t1.p_price, t2.dis, t2.bill, t3.bill_disc, t1.p_m, t3.pay FROM
								(
								SELECT c.c_id, c.address, c.cell, c.p_id, p.p_price, c.note, c.p_m FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								WHERE c.sts = 0 AND c.mac_user = '0'
								)t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
								WHERE MONTH(b.bill_date) = MONTH('$f_date')
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id
								LEFT JOIN
								(
								SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'
								GROUP BY p.c_id
								)t3
								ON t1.c_id = t3.c_id ORDER BY t1.address");  

$yrda= strtotime($todayy); 
$dates = date('M-d, y', $yrda);
$month = date('M, Y', $yrda);
$monthonly = date('M', $yrda);

$ress = mysql_query("SELECT b.id AS billno FROM billing AS b	WHERE b.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
$rowsss = mysql_fetch_array($ress);
$billno = $rowsss['billno'];

$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);


?>

	<script language="javascript">
		function PrintMe(DivID) {
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=595, height=842, left=2, top=1";
		   var content_vlue = document.getElementById(DivID).innerHTML;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		   docprint.document.write('<link rel="stylesheet" href="css/resume_print.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/reset-fonts-grids_print.css" type="text/css" />');
		   docprint.document.write('<head><title><?php echo $comp_name; ?></title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:11px;}');
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
			<a class="btn" href="Billing"> Go Back </a>
        </div>
        <div class="pageicon"><i class="iconfa-print"></i></div>
        <div class="pagetitle">
            <h1>Print Billing Invoice</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Invoice</h5>
				</div>
				<div class="modal-body">
					<div id="divid">
					
					
					<?php 
					
					while ($row=mysql_fetch_array($result)) {
				$date = $row['pay_date'];
				$c_id = $row['c_id'];
				$address = $row['address'];
				$cell = $row['cell'];
				$p_price = $row['p_price'];
				$discount = $row['dis'];
				$bill = $row['bill'];
				$bill_disc = $row['bill_disc'];
				$pay = $row['pay'];
				$note = $row['note'];
				$pa_m = $row['p_m'];
				
				$balance = $bill - ($bill_disc + $pay);
				
				$results = mysql_query("SELECT t2.c_id, t2.dis, t2.bill, t3.bill_disc, t3.pay FROM
										(
										SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
										WHERE b.bill_date < '$f_date' AND b.c_id = '$c_id'
										GROUP BY b.c_id
										)t2
										LEFT JOIN
										(
										SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 
										WHERE p.pay_date < '$f_date' AND p.c_id = '$c_id'
										GROUP BY p.c_id
										)t3
										ON t2.c_id = t3.c_id");
				$rows = mysql_fetch_array($results);					
				$dew = $rows['bill'] - ($rows['bill_disc'] + $rows['pay']);
				
				if($dew < 0){
					$dews = 0;
					$advs = abs($dew);
				}else{
					$dews = $dew;
					$advs = 0;
				}
				
				$total_payable = $balance + $dew;
				
			if($total_payable <= 0){
					
			}else{?>
				
				<div style="overflow: hidden;">
							<div style="float: left;width: 40%;">
								<table style="width: 100%;margin: 9.5px;font-size: 10px;">
								  <tr style="height: 55px;">
									<th style="padding: 0 0 0 5px; color: #333;font-size: 13px;text-align: left;font-weight: bold;"><?php echo $comp_name; ?>
									<p style="color: #333;text-align: left;line-height: 10px;font-weight: normal;font-size: 10px;"><?php echo $CompanyAddress; ?></p></th>
									<th colspan="3" style="text-align: right;line-height: 10px;font-weight: normal;font-size: 10px;padding: 0;">INV-BN<?php echo $billno; ?>
									<p style="color: #333;text-align: right;line-height: 15px;font-weight: normal;font-size: 10px;"><?php echo $dates; ?></p></th>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td rowspan="6" style="padding: 0 0 0 5px;"><p><b><?php echo $c_name; ?></b></p><p><b>User ID:</b> <?php echo $c_id; ?></p>
														<p><?php echo $address; ?></p>
														<p><?php echo $cell; ?></p></td>
									<td style="text-align: right;width: 30%;">Bill Amount</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right;"><?php echo number_format($bill,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Discount<br></td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right;"><?php echo number_format($bill_disc,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Advance</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="border-bottom: 1px solid black; text-align: right;"><?php echo number_format($advs,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Sum</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right; text-align: right;"><?php $aaa = ($bill - $bill_disc) - $advs; echo number_format($aaa,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Vat</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="border-bottom: 1px solid black; text-align: right;">0.00</td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Sum With Vat</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right;"><?php echo number_format($aaa,2); ?></td>
								  </tr>
								  <tr>
									<td style="padding: 0 0 0 5px;font-weight: bold;">Month : <?php echo $month; ?>.</td>
									<td style="text-align: right;width: 30%;">Previous Due</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="border-bottom: 1px solid black; text-align: right;"><?php echo number_format($dews,2); ?></td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td style="text-align: right;width: 30%;">Total</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="font-weight: bold; text-align: right;"><?php echo $total_payable; ?></td>
								  </tr>
								  <tr>
									<td colspan="4" style="padding: 8px 0 0 5px;font-weight: normal;text-transform: capitalize;font-size: 9.5px;/*! padding-top: 22px; */">In Word : <?php echo $f->format($balance + $dew); ?> Taka Only.</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								</table>
							</div>

							<div style="float: right;width: 55%;margin-right: 2%;">
								<table style="width: 100%;margin: 9.5px;font-size: 10px;">
								  <tr style="height: 45px;">
									<th style="padding: 0 0 0 5px; color: #333;font-size: 13px;text-align: left;font-weight: bold;"><?php echo $comp_name; ?>
									<p style="color: #333;text-align: left;line-height: 10px;font-weight: normal;font-size: 10px;"><?php echo $CompanyAddress; ?> </p></th>
									<th colspan="3" style="text-align: right;line-height: 10px;font-weight: normal;font-size: 10px;padding: 0;">INV-BN<?php echo $billno; ?>
									<p style="color: #333;text-align: right;line-height: 15px;font-weight: normal;font-size: 10px;"><?php echo $dates; ?></p></th>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td rowspan="6" style="padding: 0 0 0 5px;"><p><b><?php echo $c_name; ?></b></p><p><b>User ID:</b> <?php echo $c_id; ?></p>
														<p><?php echo $address; ?></p>
														<p><?php echo $cell; ?></p></td>
									<td style="text-align: right;width: 30%;">Bill Amount</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right;"><?php echo number_format($bill,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Discount<br></td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right;"><?php echo number_format($bill_disc,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Advance</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="border-bottom: 1px solid black; text-align: right;"><?php echo number_format($advs,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Sum</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right;"><?php $aaa = ($bill - $bill_disc) - $advs; echo number_format($aaa,2); ?></td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Vat</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="border-bottom: 1px solid black; text-align: right;">0.00</td>
								  </tr>
								  <tr>
									<td style="text-align: right;width: 30%;">Sum With Vat</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="text-align: right;"><?php echo number_format($aaa,2); ?></td>
								  </tr>
								  <tr>
									<td></td>
									<td style="text-align: right;width: 30%;">Previous Due</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="border-bottom: 1px solid black; text-align: right;"><?php echo number_format($dews,2); ?></td>
								  </tr>
								  <tr>
									<td style="padding: 0 0 0 5px;font-weight: bold;">Billing Month : <?php echo $month; ?>.</td>
									<td style="text-align: right;width: 30%;">Total</td>
									<td>&nbsp;:&nbsp;</td>
									<td style="font-weight: bold; text-align: right;"><?php echo $total_payable; ?></td>
								  </tr>
								  <tr>
									<td colspan="4" style="padding: 0 0 0 5px;font-weight: normal;text-transform: capitalize;font-size: 9.5px;">In Word : <?php echo $f->format($balance + $dew); ?> Taka Only.</td>
								  </tr>
								  <tr>
									<td colspan="3" style="padding: 0 0 0 5px;">Note: Please take money receipt while paying money.</td>
									<td style="height: 55px;text-align: right;">Signature</td>
								  </tr>
								</table>
							</div>
						</div>	
				
				
			<?php }
			$TotalPayment += $total_payable;
		}
					
					?>
						
						
					</div><!--- PRINT --->
				</div>
			<div class="modal-footer">
				<button class="btn" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')">Print Invoice</button>
			</div>
			</div>			
	</div></div>

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>