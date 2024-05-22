<?php
	ini_alter('date.timezone','Asia/Almaty');
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

require('mysql_table.php');
require('connection.php');
require('Function.php');
extract($_POST);

$todayy = date("Y-m-d h:i:s");
$f_date = date('Y-m-01', strtotime($todayy));
$t_date = date('Y-m-d', strtotime($todayy));
$yrda= strtotime($todayy); 
$dates = date('jS M,y g:i A', $yrda);
$ip = getenv(REMOTE_ADDR);
class PDF extends PDF_MySQL_Table
{

}
$pdf=new FPDF('L','mm',[148,210]);
$pdf->AddPage();

$result = mysql_query("SELECT t1.c_id, t1.con_sts, t1.c_name, t1.thana, t1.address, t1.note, t1.cell, t1.p_name, t1.breseller, t1.con_type, t1.raw_download, t1.raw_upload, t1.total_bandwidth, t1.total_price, t1.bandwith, t1.p_price, t1.z_name, IFNULL(t2.dis,0.00) AS dis, IFNULL(t2.billl,0.00) AS bill, IFNULL(t3.bill_disc,0.00) AS bill_disc, t1.p_m, IFNULL(t3.pay, 0.00) AS pay FROM
									(
									SELECT c.c_id, c.c_name, c.thana, c.address, c.cell, c.con_type, c.breseller, c.p_id, p.p_price, p.p_name, c.raw_download, c.raw_upload, c.total_bandwidth, c.total_price, p.bandwith, z.z_name, c.note, c.p_m, c.con_sts FROM clients AS c 
									LEFT JOIN package AS p ON c.p_id = p.p_id
									LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.mac_user = '0' AND c.sts != '1' AND c.c_id = '$c_id'
									)t1
									LEFT JOIN
									(
									SELECT b.c_id, SUM(b.bill_amount) AS billl, SUM(b.discount) AS dis FROM billing AS b
									WHERE MONTH(b.bill_date) = MONTH('$f_date') AND YEAR(b.bill_date) = YEAR('$f_date')
									GROUP BY b.c_id
									)t2
									ON t1.c_id = t2.c_id
									LEFT JOIN
									(
									SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 
									WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'
									GROUP BY p.c_id
									)t3
									ON t1.c_id = t3.c_id"); 
									
									

$row = mysql_fetch_assoc($result);

				$date = $row['pay_date'];
				$ccc_id = $row['c_id'];
				$c_name = $row['c_name'];
				$address = $row['address'];
				$flt_no = $row['flt_no'];
				$house = $row['house'];
				$road = $row['road'];
				$block = $row['block'];
				$area = $row['area'];
				$thana = $row['thana'];
				$cell = $row['cell'];
				$p_price = $row['p_price'];
				$discount = $row['dis'];
				$bill = $row['bill'];
				$bill_disc = $row['bill_disc'];
				$pay = $row['pay'];
				$note = $row['note'];
				$pa_m = $row['p_m'];
				$z_name = $row['z_name'];
				$con_sts = $row['con_sts'];
				$raw_download = $row['raw_download'];
				$raw_upload = $row['raw_upload'];
				$total_bandwidth = $row['total_bandwidth'];
				$total_price = $row['total_price'];
				$bandwidth = $row['bandwidth'];
				$con_type = $row['con_type'];
				$p_name = $row['p_name'];
				$bandwith = $row['bandwith'];
				$breseller = $row['breseller'];
				
	$balance = $bill - ($bill_disc + $pay);
	
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
				$rowss = mysql_fetch_array($results);					
				$dew = $rowss['bill'] - ($rowss['bill_disc'] + $rowss['pay']);
				
				if($dew < 0){
					$dews = 0.00;
					$advs = abs($dew);
				}else{
					$dews = $dew;
					$advs = 0.00;
				}
				
				$total_payable = number_format((($balance + $dews) - $advs),2);
				$total_payable1 = $balance + $dews;
				
		if($total_payable == '0.00'){
			
			$bill = '0.00';
		}		
		$aaa = ($bill - $bill_disc) - $advs;

$yrda= strtotime($todayy); 
$dates = date('d M, y', $yrda);
$month = date('M, Y', $yrda);
$monthonly = date('M', $yrda);

$ress = mysql_query("SELECT b.id AS billno FROM billing AS b WHERE b.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
$rowsss = mysql_fetch_array($ress);
$billno = $rowsss['billno'];

$yrdaa= strtotime($ex_date);
$exdate = date('M-d, y', $yrdaa);

//		$pdf->SetX(1);
//		$pdf->SetY(1);
//		$pdf->SetDrawColor(3, 3, 3);
//		$pdf->SetFillColor(255, 255, 255);
//		$pdf->SetTextColor(3,3,3);
//		$pdf->Image('../imgs/logo.png',8,8,23);
//		$pdf->Ln(35);
		$pdf->SetY(25);
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(21,5,'User ID','0',0,'L',false);
		$pdf->Cell(3,5,':','0',0,'L',false);
		$pdf->Cell(5,5,$ccc_id,'0',0,'L',false);
		$pdf->Cell(141,5,'INVOICE No # '.$billno,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(21,5,'Name','0',0,'L',false);
		$pdf->Cell(3,5,':','0',0,'L',false);
		$pdf->Cell(5,5,$c_name,'0',0,'L',false);
		$pdf->Cell(141,5,'Issue Date: '.$dates,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(21,5,'Payment Type','0',0,'L',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(3,5,':','0',0,'L',false);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(5,5,'Prepaid','0',0,'L',false);
		$pdf->Cell(141,5,'Billing Month: '.$month,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(21,5,'Cell No','0',0,'L',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(3,5,':','0',0,'L',false);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(5,5,$cell,'0',0,'L',false);
		$pdf->Cell(141,5,'','0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(21,5,'Address','0',0,'L',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(3,5,':','0',0,'L',false);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(5,5,$address,'0',0,'L',false);
		$pdf->Cell(141,5,'','0',0,'R',false);
		$pdf->Ln(4);
		
		$pdf->SetX(28);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(16,5,'','0',0,'L',false);
		$pdf->Cell(70,5,$z_name.', Thana-'.$thana,'0',0,'L',false);
		$pdf->Cell(117,5,'','0',0,'R',false);
		$pdf->Ln(7);
		
		$pdf->SetX(21);
		$pdf->SetTextColor(89,89,89);
		$pdf->SetFont('Helvetica','B',13);
		$pdf->Cell(167,4,'','',0,'C',false);
		$pdf->Ln(4.5);
		
		$pdf->SetX(21);
		$pdf->SetFillColor(210, 210, 210);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(3, 3, 3);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(136,6,'Particulars','LTB',0,'C',true);
		$pdf->Cell(1,6,'','TB',0,'C',true);
		$pdf->Cell(30,6,'Amount (TK)','LTRB',0,'C',true);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(130,6,'Monthly Recurring Charges for Broadband Internet Service:','L',0,'C',false);
		$pdf->Cell(7,6,'','R',0,'C',false);
		$pdf->Cell(30,6,'','R',0,'C',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',9);
	if($breseller == '0'){
		$pdf->Cell(130,5,$con_type.' Bandwidth: '.$p_name.' - '.$bandwith,'L',0,'C',false);
	} else{
		$pdf->Cell(130,5,$con_type.' Bandwidth: '.$p_name.' '.$bandwith.$total_bandwidth.' mbps','L',0,'C',false);
	}
		$pdf->Cell(7,5,'','R',0,'C',false);
		$pdf->Cell(30,5,$bill,'R',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(130,3,'','LB',0,'R',false);
		$pdf->Cell(7,3,'','BR',0,'C',false);
		$pdf->Cell(30,3,'','BR',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFillColor(210, 210, 210);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(3, 3, 3);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(110,5,'','',0,'C',false);
		$pdf->Cell(27,5,'Discount','TLB',0,'R',true);
		$pdf->Cell(30,5,$bill_disc,'TLBR',0,'R',true);
		$pdf->Ln();
		
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(111,5,'Amount in Word: '.convertNum($total_payable1).' Taka Only.','',0,'L',false);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(27,5,'Advance','LB',0,'R',true);
		$pdf->Cell(30,5,number_format($advs,2),'LBR',0,'R',true);
		$pdf->Ln();
		
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(111,5,'NOTE: Monthly Recurring Charges are Excluding VAT.','',0,'L',false);
		$pdf->Cell(27,5,'Previous Due','LB',0,'R',true);
		$pdf->Cell(30,5,number_format($dews,2),'LBR',0,'R',true);
		$pdf->Ln();
		
		$pdf->SetX(20);
		$pdf->Cell(111,5,'','',0,'L',false);
		$pdf->Cell(27,5,'Partially Paid','LB',0,'R',true);
		$pdf->Cell(30,5,number_format($bill_disc + $pay,2),'LBR',0,'R',true);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(100,5,'For Cheque payment make crossed cheque in the ','LTR',0,'C',false);
		$pdf->Cell(10,5,'','R',0,'C',false);
		$pdf->Cell(27,5,'Total Receivable','LB',0,'R',true);
		$pdf->Cell(30,5,$total_payable,'LBR',0,'R',true);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->Cell(40,5,'favor of ','LB',0,'R',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(60,5,'"'.$comp_name.'"','RB',0,'L',false);
		$pdf->Cell(10,5,'','',0,'C',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->Cell(100,5,'bKash Payment','LBR',0,'C',false);
		$pdf->Cell(10,5,'','',0,'C',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(50,5,'Personal Account Number ','LB',0,'R',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(50,5,$company_cell,'LRB',0,'L',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->Cell(115,5,'','',0,'C',false);
		$pdf->Cell(50,5,'Authorized Signature','T',0,'C',false);
		$pdf->Cell(10,5,'','',0,'C',false);
		$pdf->Ln();

		$pdf->Output();

?>