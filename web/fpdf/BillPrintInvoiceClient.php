<?php
if($_POST['invoice_id'] != ''){
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
function Header()
{
	//Title
	$pdf->Image('logo.png',15,8,35);
	$pdf->Image('corporation.png',160,5,35);
	$pdf->SetFont('Helvetica','',15);
	$pdf->SetDrawColor(8, 102, 198);
	$pdf->SetLineWidth(.1);
	$pdf->Cell(0,15,'Data Entry List','B',1,'C');
	
	$pdf->Ln(5);
	//Ensure table header is output
	parent::Header();
	
}
function Footer()
		{

		}
}
$pdf=new FPDF();
$pdf->AddPage();

$quesdd = mysql_query("SELECT id, c_id, invoice_id, DATE_FORMAT(invoice_date, '%M-%Y') AS invoicedate, DATE_FORMAT(invoice_date, '%D %M, %Y') AS invoicedateee, invoice_date, DATE_FORMAT(due_deadline, '%D %M, %Y') AS due_deadline FROM billing_invoice WHERE invoice_id = '$invoice_id' AND sts = '0' ORDER BY id ASC LIMIT 1");
$rowwdd = mysql_fetch_assoc($quesdd);
$invoicedateee = $rowwdd['invoicedateee'];
$invoicedate = $rowwdd['invoicedate'];
$due_deadline = $rowwdd['due_deadline'];
$invoice_date = $rowwdd['invoice_date'];
$c_id = $rowwdd['c_id'];

$quesddff = mysql_query("SELECT IFNULL((b.bill - p.paid), '0.00') AS opening_balance FROM clients AS c 
							LEFT JOIN
							(SELECT IFNULL(c_id, '$c_id') AS c_id, IFNULL(SUM(total_price), '0.00') AS bill FROM billing_invoice WHERE sts = '0' AND c_id = '$c_id' AND invoice_date < '$invoice_date')b
							ON b.c_id = c.c_id
							LEFT JOIN
							(SELECT IFNULL(c_id, '$c_id') AS c_id, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS paid FROM payment WHERE sts = '0' AND c_id = '$c_id' AND pay_date < '$invoice_date')p
							ON p.c_id = c.c_id
							WHERE c.breseller = '2' AND c.c_id = '$c_id'");
$rwwdd = mysql_fetch_assoc($quesddff);
$opening_balance = $rwwdd['opening_balance'];

$quesddffpp = mysql_query("SELECT IFNULL(c_id, '$c_id') AS c_id, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS paid FROM payment WHERE sts = '0' AND c_id = '$c_id' AND MONTH(pay_date) = MONTH('$invoice_date') AND YEAR(pay_date) = YEAR('$invoice_date')");
$rwwddpp = mysql_fetch_assoc($quesddffpp);
$thismonthpay = $rwwddpp['paid'];

$result = mysql_query("SELECT `invoice_id`, `invoice_date`, `c_id`, `item_id`, `item_name`, `description`, `quantity`, `unit`, `uniteprice`, `vat`, DATE_FORMAT(start_date, '%d/%m/%y') AS start_date, DATE_FORMAT(end_date, '%d/%m/%y') AS end_date, `days`, `total_price`, `due_deadline`, `date_time` FROM billing_invoice WHERE invoice_id = '$invoice_id' AND sts = '0'"); 
$result11 = mysql_query("SELECT DATE_FORMAT(pay_date_time, '%d/%m/%Y %H:%i:%s') AS pay_date_time, pay_amount, bill_discount, pay_mode, pay_desc FROM payment WHERE sts = '0' AND c_id = '$c_id' AND MONTH(pay_date) = MONTH('$invoice_date') AND YEAR(pay_date) = YEAR('$invoice_date') ORDER BY id ASC"); 

$quec = mysql_query("SELECT c.c_id, c.com_id, c.c_name, b.b_name, z.z_name, c.cell, c.address, c.email FROM clients AS c
LEFT JOIN zone AS z ON z.z_id = c.z_id
LEFT JOIN box AS b ON b.box_id = c.box_id
WHERE c_id = '$c_id'");

$rdppc = mysql_fetch_assoc($quec);
$cid = $rdppc['c_id'];
$comid = $rdppc['com_id'];
$cname = $rdppc['c_name'];
$zname = $rdppc['z_name'];
$cell = $rdppc['cell'];
$email = $rdppc['email'];

if($rdppc['b_name'] == ''){
	$bname = '';
}
else{
	$bname = $rdppc['b_name'].', ';
}

if($rdppc['address'] == ''){
	$address = $bname.$zname;
}
else{
	$address = $rdppc['address'];
}

		$pdf->SetDrawColor(3, 3, 3);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(3,3,3);
		$pdf->Image('../imgs/logo.png',22,16,$invoice_logo_size);
		$pdf->Ln(5);
		
		$pdf->SetFont('Helvetica','B',12);
		$pdf->SetX(21);
		$pdf->Cell(168,5,$comp_name,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetX(21);
		$pdf->Cell(168,3,$copmaly_address,'0',0,'R',false);
		$pdf->Ln();
		$pdf->SetX(21);
		$pdf->Cell(168,3,$copmaly_address2,'0',0,'R',false);
		$pdf->Ln();
		$pdf->SetX(21);
		$pdf->Cell(168,3,$company_cell,'0',0,'R',false);
		$pdf->Ln(5);
		$pdf->SetX(21);
		$pdf->Cell(168,3,$copmaly_com_email,'0',0,'R',false);
		$pdf->Ln();
		$pdf->SetX(21);
		$pdf->Cell(168,3,$copmaly_website,'0',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetX(21);
		$pdf->Cell(168,5,'','B',0,'R',false);
		$pdf->Ln(10);
		
		$pdf->SetX(21);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->Cell(84,5,'BILL TO','',0,'L',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(50,5,'Invoice No','',0,'R',false);
		$pdf->Cell(4,5,'#','',0,'C',false);
		$pdf->Cell(30,5,$invoice_id,'',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(84,5,$cname.' ('.$comid.')','',0,'L',false);
		$pdf->Cell(50,5,'Invoice Month','',0,'R',false);
		$pdf->Cell(4,5,':','',0,'C',false);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(30,5,$invoicedate,'',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(84,5,$address,'',0,'L',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(50,5,'Invoice Date','',0,'R',false);
		$pdf->Cell(4,5,':','',0,'C',false);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(30,5,$invoicedateee,'',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(84,5,$cell,'',0,'L',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(50,5,'Invoice Deadline','',0,'R',false);
		$pdf->Cell(4,5,':','',0,'C',false);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(30,5,$due_deadline,'',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFont('Helvetica','',9);
		$pdf->Cell(84,5,$email,'',0,'L',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(50,5,'Opening Balance','',0,'R',false);
		$pdf->Cell(4,5,':','',0,'C',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(30,5,number_format($opening_balance,2),'',0,'R',false);
		$pdf->Ln(10);
		
		
		$pdf->SetX(21);
		$pdf->SetFillColor(14, 36, 52);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetDrawColor(14, 36, 52);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(50,5,'Particulars','TL',0,'L',true);
		$pdf->Cell(22,5,'Quantity','T',0,'C',true);
		$pdf->Cell(15,5,'Price','T',0,'R',true);
		$pdf->Cell(15,5,'VAT(%)','T',0,'R',true);
		$pdf->Cell(19,5,'From','T',0,'C',true);
		$pdf->Cell(19,5,'To','T',0,'C',true);
		$pdf->Cell(8,5,'Day','T',0,'C',true);
		$pdf->Cell(20,5,'Amount','TR',0,'R',true);
		$pdf->Ln();

		
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		
$intotal_price = 0;
while( $row = mysql_fetch_assoc($result) )
								{			
$item_name = $row['item_name'];
$description = $row['description'];
$quantity = $row['quantity'].' '.$row['unit'];
$unit = $row['unit'];
$uniteprice = $row['uniteprice'];
$vat = $row['vat'];
$start_date = $row['start_date'];
$end_date = $row['end_date'];
$days = $row['days'];
$total_price = $row['total_price'];
$intotal_price += $row['total_price'];

		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(50,6,$item_name,'LB',0,'L',false);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(22,6,$quantity,'B',0,'L',false);
		$pdf->Cell(15,6,$uniteprice,'B',0,'R',false);
		$pdf->Cell(15,6,$vat,'B',0,'R',false);
		$pdf->Cell(19,6,$start_date,'B',0,'C',false);
		$pdf->Cell(19,6,$end_date,'B',0,'C',false);
		$pdf->Cell(8,6,$days,'B',0,'C',false);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(20,6,$total_price,'RB',0,'R',false);
		$pdf->Ln();
}

		$pdf->Ln();
		$pdf->SetX(21);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(107,5,'InWord: '.convertNum(($opening_balance+$intotal_price)-($thismonthpay)).' Taka Only.','',0,'L',false);
		$pdf->SetFont('Helvetica','',10);
		$pdf->Cell(27,5,'Total Bill','',0,'R',false);
		$pdf->Cell(4,5,':','',0,'C',false);
		$pdf->SetFont('Helvetica','',10);
		$pdf->Cell(30,5,number_format($intotal_price,2),'',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->Cell(107,5,'','',0,'C',false);
		$pdf->SetFont('Helvetica','',10);
		$pdf->Cell(27,5,'Paid + Discount','B',0,'R',true);
		$pdf->Cell(4,5,':','B',0,'C',true);
		$pdf->SetFont('Helvetica','',10);
		$pdf->Cell(30,5,number_format($thismonthpay,2),'B',0,'R',true);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->Cell(107,5,'','',0,'L',false);
		$pdf->SetFont('Helvetica','',10);
		$pdf->Cell(27,5,'Sum','',0,'R',false);
		$pdf->Cell(4,5,':','',0,'C',false);
		$pdf->SetFont('Helvetica','',10);
		$pdf->Cell(30,5,number_format(($intotal_price-$thismonthpay),2),'',0,'R',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->Cell(107,5,'','',0,'C',false);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(27,5,'Opening Balance','B',0,'R',true);
		$pdf->Cell(4,5,':','B',0,'C',true);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(30,5,number_format($opening_balance,2),'B',0,'R',true);
		$pdf->Ln();
		
		
		$pdf->SetX(21);
		$pdf->Cell(107,6,'','',0,'C',false);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(27,6,'Closing Balance','',0,'R',false);
		$pdf->Cell(4,5,':','',0,'C',false);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(30,6,number_format((($opening_balance+$intotal_price)-($thismonthpay)),2),'',0,'R',false);
		$pdf->Ln(10);

if($thismonthpay > '0'){
		$pdf->SetX(21);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(14, 36, 52);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(168,5,'Payments on '.$invoicedate,'B',0,'L',true);
		$pdf->Ln(6);
		
		$pdf->SetX(21);
		$pdf->SetFillColor(14, 36, 52);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetDrawColor(14, 36, 52);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(32,5,'Date','TL',0,'L',true);
		$pdf->Cell(38,5,'Payment Method','T',0,'C',true);
		$pdf->Cell(58,5,'Description','T',0,'C',true);
		$pdf->Cell(20,5,'Discount','T',0,'R',true);
		$pdf->Cell(20,5,'Amount','T',0,'R',true);
		$pdf->Ln();

		$pdf->SetX(21);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetDrawColor(192, 192, 192);
while( $rowp = mysql_fetch_assoc($result11) )
{			
$pay_date_time = $rowp['pay_date_time'];
$payamount = $rowp['pay_amount'];
$billdiscount = $rowp['bill_discount'];
$pay_mode = $rowp['pay_mode'];
$pay_desc = $rowp['pay_desc'];

$totaldiscount += $rowp['bill_discount'];
$totalpaid += $rowp['pay_amount'];

		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(32,6,$pay_date_time,'LB',0,'L',false);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(38,6,$pay_mode,'B',0,'C',false);
		$pdf->Cell(58,6,$pay_desc,'B',0,'C',false);
		$pdf->Cell(20,6,$billdiscount,'B',0,'R',false);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(20,6,$payamount,'RB',0,'R',false);
		$pdf->Ln();
}
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(32,6,'','',0,'L',false);
		$pdf->Cell(38,6,'','',0,'C',false);
		$pdf->Cell(58,6,'Total Discount & Paid:','',0,'R',false);
		$pdf->Cell(20,6,number_format($totaldiscount,2),'',0,'R',false);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(20,6,number_format($totalpaid,2),'',0,'R',false);
		$pdf->Ln(20);

}	
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',9);
		$pdf->Cell(111,5,'NOTE / TERMS:','',0,'L',false);
		$pdf->Ln();

if($invoice_note1 != ''){
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(111,5,$invoice_note1,'',0,'L',false);
		$pdf->Ln();
}
if($invoice_note2 != ''){
		$pdf->SetX(20);
		$pdf->Cell(111,5,$invoice_note2,'',0,'L',false);
		$pdf->Ln();
}
if($invoice_note3 != ''){
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(111,5,$invoice_note3,'',0,'L',false);
		$pdf->Ln();
}
if($invoice_note4 != ''){
		$pdf->SetX(20);
		$pdf->Cell(111,5,$invoice_note4,'',0,'L',false);
		$pdf->Ln();
}
if($invoice_note5 != ''){
		$pdf->SetX(20);
		$pdf->SetFont('Helvetica','',8);
		$pdf->Cell(111,5,$invoice_note5,'',0,'L',false);
		$pdf->Ln();
}

		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(115,5,'','',0,'C',false);
		$pdf->Cell(50,5,'','',0,'C',false);
		$pdf->Cell(10,5,'','',0,'C',false);
		$pdf->Ln();
		
		$pdf->SetX(21);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->Cell(115,5,'','',0,'C',false);
		$pdf->Cell(50,5,'Authorized Signature','T',0,'C',false);
		$pdf->Cell(10,5,'','',0,'C',false);
		$pdf->Ln();

		$pdf->Output();
}
?>