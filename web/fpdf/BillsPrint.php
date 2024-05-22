<?php
	
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

ini_alter('date.timezone','Asia/Almaty');

$todayy = date("Y-m-d");

$f_date = date('Y-m-01', strtotime($todayy));
$t_date = date('Y-m-t', strtotime($todayy));


$yrda= strtotime($todayy); 
$dates = date('M-d, y', $yrda);
$datesss = date('M, y', $yrda);
$month = date('M, Y', $yrda);
$monthonly = date('M', $yrda);
		
class PDF extends PDF_MySQL_Table
{

}

$pdf=new PDF();
$pdf->AddPage();

	$sqlww = "SELECT t1.c_id, t1.con_sts, t1.c_name, t1.com_id, t1.address, t1.note, t1.join_date, t1.cell, t1.p_price, t1.z_name, IFNULL(t2.dis,0.00) AS dis, IFNULL(t2.billl,0.00) AS bill, IFNULL(t3.bill_disc,0.00) AS bill_disc, t1.p_m, IFNULL(t3.pay, 0.00) AS pay FROM
				(
				SELECT c.c_id, c.c_name, c.com_id, c.address, c.cell, c.join_date, c.p_id, p.p_price, z.z_name, c.note, c.p_m, c.con_sts FROM clients AS c 
				LEFT JOIN package AS p ON c.p_id = p.p_id
				LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.mac_user = '0' AND c.sts != '1'";
	if ($z_id != 'all'){
		$sqlww .= " AND c.z_id = '{$z_id}'";
	}
	if ($p_m != 'all'){
		$sqlww .= " AND c.p_m = '{$p_m}'";
	}
	if ($con_sts != 'all'){
		$sqlww .= " AND c.con_sts = '{$con_sts}'";
	}
	if ($user_type == 'billing'){
		$sqlww .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
	}
	$sqlww .= " ORDER BY c.z_id ASC
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
					ON t1.c_id = t3.c_id";
	$result = mysql_query($sqlww);
	
	$x = 0;							

while ($row=mysql_fetch_array($result)) {
				$date = $row['pay_date'];
				$c_id = $row['c_id'];
				$c_name = $row['c_name'];
				$address = $row['address'];
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
				$com_id = $row['com_id'];
				$join_date = $row['join_date'];
				
				$yrdata= strtotime($row['join_date']);
				$joining_date = date('F d, Y', $yrdata);
				
				$x++;
				
				$balance = $bill - ($bill_disc + $pay);
				
				$ress = mysql_query("SELECT b.id AS billno FROM billing AS b WHERE b.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
				$rowsss = mysql_fetch_array($ress);
				$billno = $rowsss['billno'];
				
				$results = mysql_query("SELECT t2.c_id, IFNULL(t2.dis, 0.00) AS dis, IFNULL(t2.bill, 0.00) AS bill, IFNULL(t3.bill_disc, 0.00) AS bill_disc, IFNULL(t3.pay, 0.00) AS pay FROM
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
if($total_payable >= '1'){
			global $comp_name;
			global $comp_name2;
			global $copmaly_address;
			global $company_main_logo;

if($withlogo == 'Yes'){
		$pdf->Image('../'.$company_main_logo,7,5,25);
		$pdf->Image('../'.$company_main_logo,92,5,25);
		$pdf->Image('../'.$company_main_logo,7,73,25);
		$pdf->Image('../'.$company_main_logo,92,73,25);
		$pdf->Image('../'.$company_main_logo,7,140,25);
		$pdf->Image('../'.$company_main_logo,92,140,25);
		$pdf->Image('../'.$company_main_logo,7,207,25);
		$pdf->Image('../'.$company_main_logo,92,207,25);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetTextColor(3,3,3);
		$pdf->Cell(78,0,'INV-'.$billno,'0',0,'R',false);
		$pdf->Cell(118,0,'INV-'.$billno,'0',0,'R',false);
		$pdf->Ln(-2);
		
		$pdf->Cell(78,10,$dates,'0',0,'R',false);
		$pdf->Cell(118,10,$dates,'0',0,'R',false);
		$pdf->Ln(5);
}
else{
		$pdf->SetX(7);
		$pdf->SetDrawColor(3, 3, 3);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(3,3,3);
		$pdf->SetFont('Helvetica','B',12);
		$pdf->Cell(15,0,$comp_name,'0',0,'L',false);
		
		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetTextColor(3,3,3);
		$pdf->Cell(65,3,'INV-'.$billno,'0',0,'R',false);
		$pdf->Cell(5,5,'','0',0,'L',false);
		
		$pdf->SetFont('Helvetica','B',12);
		$pdf->SetTextColor(3,3,3);
		$pdf->Cell(30,0,$comp_name,'0',0,'L',false);
		
		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetTextColor(3,3,3);
		$pdf->Cell(83,3,'INV-'.$billno,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetTextColor(3,3,3);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,3,'','0',0,'L',false);
		$pdf->Cell(15,2,$copmaly_address,'0',0,'L',false);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(65,3,$dates,'0',0,'R',false);
		$pdf->Cell(5,3,'','0',0,'L',false);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(43,2,$copmaly_address,'0',0,'L',false);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(70,3,$dates,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetTextColor(3,3,3);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(15,2,$copmaly_address2,'0',0,'L',false);
		$pdf->Cell(65,2,'','0',0,'R',false);
		$pdf->Cell(5,5,'','0',0,'L',false);
		$pdf->Cell(43,2,$copmaly_address2,'0',0,'L',false);
		$pdf->Cell(70,2,'','0',0,'R',false);
		$pdf->Ln(-2);
}
		$pdf->Ln(5);
		$pdf->SetX(8);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell(79,0,'','B',0,'C',true);
		
		$pdf->SetDrawColor(255, 255, 255);
		$pdf->Cell(6,0,'','B',0,'C',true);
		
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell(112,0,'','B',0,'C',true);
		$pdf->Ln(5);
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','B',8);
		
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(65,3,$c_name,'0',0,'L',false);
		$pdf->Cell(3,3,'Bill ('.$monthonly.') : ','0',0,'R',false);
		$pdf->Cell(12,3,$bill,'0',0,'R',false);
		$pdf->Cell(5,5,'','0',0,'L',false);
		$pdf->Cell(10,3,$c_name,'0',0,'L',false);
		$pdf->Cell(91,3,'Bill ('.$monthonly.') : ','0',0,'R',false);
		$pdf->Cell(12,3,$bill,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,3,'User ID : '.$c_id,'0',0,'L',false);
		$pdf->Cell(1,3,'Discount : ','0',0,'R',false);
		$pdf->Cell(12,3,$discount,'0',0,'R',false);
		$pdf->Cell(5,5,'','0',0,'L',false);
		$pdf->Cell(23,3,'User ID : '.$c_id,'0',0,'L',false);
		$pdf->Cell(78,3,'Discount : ','0',0,'R',false);
		$pdf->Cell(12,3,$discount,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,3,'Zone : '.$z_name,'0',0,'L',false);
		$pdf->Cell(1,3,'Advance : ','0',0,'R',false);
		$pdf->Cell(12,3,number_format($advs,2),'B',0,'R',false);
		$pdf->Cell(5,5,'','0',0,'L',false);
		$pdf->Cell(73,3,$address,'0',0,'L',false);
		$pdf->Cell(28,3,'Advance : ','0',0,'R',false);
		$pdf->Cell(12,3,number_format($advs,2),'B',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,4,$cell,'0',0,'L',false);
		$pdf->Cell(1,4,'Sum : ','0',0,'R',false);
		$pdf->Cell(12,4,number_format($aaa,2),'0',0,'R',false);
		$pdf->Cell(5,4,'','0',0,'L',false);
		$pdf->Cell(73,4,$cell,'0',0,'L',false);
		$pdf->Cell(28,4,'Sum : ','0',0,'R',false);
		$pdf->Cell(12,4,number_format($aaa,2),'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,3,'ComID: '.$com_id,'0',0,'L',false);
		$pdf->Cell(1,3,'Vat : ','0',0,'R',false);
		$pdf->Cell(12,3,'0.00','B',0,'R',false);
		$pdf->Cell(5,3,'','0',0,'L',false);
		$pdf->Cell(73,3,'ComID: '.$com_id,'0',0,'L',false);
		$pdf->Cell(28,3,'Vat : ','0',0,'R',false);
		$pdf->Cell(12,3,'0.00','B',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,4,$joining_date,'0',0,'L',false);
		$pdf->Cell(1,4,'Sum With Vat : ','0',0,'R',false);
		$pdf->Cell(12,4,number_format($aaa,2),'0',0,'R',false);
		$pdf->Cell(5,4,'','0',0,'L',false);
		$pdf->Cell(73,4,$joining_date,'0',0,'L',false);
		$pdf->Cell(28,4,'Sum With Vat : ','0',0,'R',false);
		$pdf->Cell(12,4,number_format($aaa,2),'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,3,'Status: '.$con_sts,'0',0,'L',false);
		$pdf->Cell(1,3,'Previous Due : ','0',0,'R',false);
		$pdf->Cell(12,3,number_format($dews,2),'B',0,'R',false);
		$pdf->Cell(5,3,'','0',0,'L',false);
		$pdf->Cell(73,3,'Status: '.$con_sts,'0',0,'L',false);
		$pdf->Cell(28,3,'Previous Due : ','0',0,'R',false);
		$pdf->Cell(12,3,number_format($dews,2),'B',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(2,1,'','0',0,'L',false);
		$pdf->Cell(67,4,'Month : '.$month,'0',0,'L',false);
		$pdf->Cell(1,4,'Total : ','0',0,'R',false);
		$pdf->Cell(12,4,$total_payable,'0',0,'R',false);
		$pdf->Cell(5,4,'','0',0,'L',false);
		$pdf->Cell(73,4,'Month : '.$month,'0',0,'L',false);
		$pdf->Cell(28,4,'Total : ','0',0,'R',false);
		$pdf->Cell(12,4,$total_payable,'0',0,'R',false);
		$pdf->Ln(7);
		
		
		$pdf->SetX(8);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell(79,0,'','B',0,'C',true);
		
		$pdf->SetDrawColor(255, 255, 255);
		$pdf->Cell(6,0,'','B',0,'C',true);
		
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->Cell(112,0,'','B',0,'C',true);
		$pdf->Ln();
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,10,'InWord: '.convertNum($total_payable1).' Taka Only.','0',0,'L',false);
		$pdf->Cell(3,3,'','0',0,'R',false);
		$pdf->Cell(10,3,'','',0,'R',false);
		$pdf->Cell(5,3,'','0',0,'L',false);
		$pdf->Cell(73,10,'InWord: '.convertNum($total_payable1).' Taka Only.','0',0,'L',false);
		$pdf->Cell(30,3,'','0',0,'R',false);
		$pdf->Cell(10,3,'','0',0,'R',false);
		$pdf->Ln(5);
		
		$pdf->SetX(5);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(2,5,'','0',0,'L',false);
		$pdf->Cell(67,3,'','0',0,'L',false);
		$pdf->Cell(3,3,'','0',0,'R',false);
		$pdf->Cell(10,3,'','',0,'R',false);
		$pdf->Cell(5,3,'','0',0,'L',false);
		$pdf->Cell(73,8,'Note: Please take money receipt while paying money.','0',0,'L',false);
		$pdf->Cell(30,3,'','0',0,'R',false);
		$pdf->Cell(10,8,'Signature','0',0,'R',false);
		$pdf->Ln(6);
		
		$pdf->SetX(0);
		$pdf->SetDrawColor(255,0,0);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(210,5,$x,'B',0,'L',true);
		$pdf->Ln(13);
		}
		else {
			
		}

}
$pdf->Output();

?>
