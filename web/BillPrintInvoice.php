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

$resultgg = mysql_query("SELECT c_id, mac_user FROM clients WHERE c_id = '$c_id'");
$rowgg = mysql_fetch_array($resultgg);	

if($rowgg['mac_user'] == '1'){
$res = mysql_query("SELECT t1.c_id, t1.c_name, t1.address, t1.note, t1.cell, t1.p_price, t1.z_name, t2.dis, t2.bill, IFNULL(t3.bill_disc,0.00) AS bill_disc, t1.p_m, IFNULL(t3.pay,0.00) AS pay, t3.pay_date FROM
								(
								SELECT c.c_id, c.c_name, c.address, c.cell, c.p_id, p.p_price_reseller AS p_price, z.z_name, c.note, c.p_m FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE c.c_id = '$c_id'
								)t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing_mac_client AS b
								WHERE MONTH(b.bill_date) = MONTH('$f_date') AND YEAR(b.bill_date) = YEAR('$f_date')
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id
								LEFT JOIN
								(
								SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc, p.pay_date FROM payment_mac_client AS p 
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'
								GROUP BY p.c_id
								)t3
								ON t1.c_id = t3.c_id");
}
else{
$res = mysql_query("SELECT t1.c_id, t1.c_name, t1.address, t1.note, t1.cell, t1.p_price, t1.z_name, t2.dis, t2.bill, IFNULL(t3.bill_disc,0.00) AS bill_disc, t1.p_m, IFNULL(t3.pay,0.00) AS pay, t3.pay_date FROM
								(
								SELECT c.c_id, c.c_name, c.address, c.cell, c.p_id, p.p_price, z.z_name, c.note, c.p_m FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE c.c_id = '$c_id'
								)t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
								WHERE MONTH(b.bill_date) = MONTH('$f_date') AND YEAR(b.bill_date) = YEAR('$f_date')
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id
								LEFT JOIN
								(
								SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc, p.pay_date FROM payment AS p 
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'
								GROUP BY p.c_id
								)t3
								ON t1.c_id = t3.c_id");
}
			$rows = mysql_fetch_array($res);
			
				$datee = $rows['pay_date'];
				$c_name = $rows['c_name'];
				$address = $rows['address'];
				$cell = $rows['cell'];
				$z_name = $rows['z_name'];
				$p_price = $rows['p_price'];
				$discount = $rows['dis'];
				$bill = $rows['bill'];
				$bill_disc = $rows['bill_disc'];
				$pay = $rows['pay'];
				$note = $rows['note'];
				$pa_m = $rows['p_m'];
			
				$balance = $bill - ($bill_disc + $pay);

				
if($rowgg['mac_user'] == '1'){
$results = mysql_query("SELECT t2.c_id, IFNULL(t2.dis,0.00) AS dis, IFNULL(t2.bill,0.00) AS bill, IFNULL(t3.bill_disc,0.00) AS bill_disc, IFNULL(t3.pay,0.00) AS pay FROM
										(
										SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing_mac_client AS b
										WHERE b.bill_date < '$f_date' AND b.c_id = '$c_id'
										GROUP BY b.c_id
										)t2
										LEFT JOIN
										(
										SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment_mac_client AS p 
										WHERE p.pay_date < '$f_date' AND p.c_id = '$c_id'
										GROUP BY p.c_id
										)t3
										ON t2.c_id = t3.c_id");
}
else{
$results = mysql_query("SELECT t2.c_id, IFNULL(t2.dis,0.00) AS dis, IFNULL(t2.bill,0.00) AS bill, IFNULL(t3.bill_disc,0.00) AS bill_disc, IFNULL(t3.pay,0.00) AS pay FROM
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
}
				$rowss = mysql_fetch_array($results);					
				$dew = $rowss['bill'] - ($rowss['bill_disc'] + $rowss['pay']);
				
				if($dew < 0){
					$dews = 0.00;
					$advs = abs($dew);
				}else{
					$dews = $dew;
					$advs = 0.00;
				}
				
				$total_payable = number_format(($balance + $dew),2);

$yrda= strtotime($todayy); 
$dates = date('M-d, y', $yrda);
$month = date('M, Y', $yrda);
$monthonly = date('M', $yrda);

if($rowgg['mac_user'] == '1'){
$ress = mysql_query("SELECT b.id AS billno FROM billing_mac_client AS b WHERE b.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
}
else{
$ress = mysql_query("SELECT b.id AS billno FROM billing AS b WHERE b.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
}
$rowsss = mysql_fetch_array($ress);
$billno = $rowsss['billno'];


$ones = array(
 "",
 " One",
 " Two",
 " Three",
 " Four",
 " Five",
 " Six",
 " Seven",
 " Eight",
 " Nine",
 " Ten",
 " Eleven",
 " Twelve",
 " Thirteen",
 " Fourteen",
 " Fifteen",
 " Sixteen",
 " Seventeen",
 " Eighteen",
 " Nineteen"
);
 
$tens = array(
 "",
 "",
 " Twenty",
 " Thirty",
 " Forty",
 " Fifty",
 " Sixty",
 " Seventy",
 " Eighty",
 " Ninety"
);
 
$triplets = array(
 "",
 " Thousand",
 " Million",
 " Billion",
 " Trillion",
 " Quadrillion",
 " Quintillion",
 " Sextillion",
 " Septillion",
 " Octillion",
 " nonillion"
);
 // recursive fn, converts three digits per pass
function convertTri($num, $tri) {
  global $ones, $tens, $triplets;
 
  // chunk the number, ...rxyy
  $r = (int) ($num / 1000);
  $x = ($num / 100) % 10;
  $y = $num % 100;
 
  // init the output string
  $str = "";
 
  // do hundreds
  if ($x > 0)
   $str = $ones[$x] . " Hundred";
 
  // do ones and tens
  if ($y < 20)
   $str .= $ones[$y];
  else
   $str .= $tens[(int) ($y / 10)] . $ones[$y % 10];
 
  // add triplet modifier only if there
  // is some output to be modified...
  if ($str != "")
   $str .= $triplets[$tri];
 
  // continue recursing?
  if ($r > 0)
   return convertTri($r, $tri+1).$str;
  else
   return $str;
 }
 
// returns the number as an anglicized string
function convertNum($num) {
 $num = (int) $num;    // make sure it's an integer
 
 if ($num < 0)
  return "negative".convertTri(-$num, 0);
 
 if ($num == 0)
  return "Zero";
 
 return convertTri($num, 0);
}
 
 // Returns an integer in -10^9 .. 10^9
 // with log distribution
 function makeLogRand() {
  $sign = mt_rand(0,1)*2 - 1;
  $val = randThousand() * 1000000
   + randThousand() * 1000
   + randThousand();
  $scale = mt_rand(-9,0);
 
  return $sign * (int) ($val * pow(10.0, $scale));
 }

$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

$total_payable1 = $balance + $dew;


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
									<td colspan="4" style="padding: 8px 0 0 5px;font-weight: normal;text-transform: capitalize;font-size: 9.5px;/*! padding-top: 22px; */">In Word : <?php echo convertNum($total_payable1); ?> Taka Only.</td>
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
									<td colspan="4" style="padding: 0 0 0 5px;font-weight: normal;text-transform: capitalize;font-size: 9.5px;">In Word : <?php echo convertNum($total_payable1); ?> Taka Only.</td>
								  </tr>
								  <tr>
									<td colspan="3" style="padding: 0 0 0 5px;">Note: Please take money receipt while paying money.</td>
									<td style="height: 55px;text-align: right;">Signature</td>
								  </tr>
								</table>
							</div>
							
						</div>	
					</div>
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