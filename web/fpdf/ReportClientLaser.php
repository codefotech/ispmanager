<?php
require('mysql_table.php');
require('connection.php');

$z_id = $_REQUEST['z_id'];
$box_id = $_REQUEST['box_id'];
$way = $_REQUEST['way'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];
$e_id = $_REQUEST['e_id'];
$user_type = $_REQUEST['user_type'];


	class PDF extends PDF_MySQL_Table
		{
		function Header()
		{
			parent::Header();
			
			$this->SetFillColor(160, 160, 160);
			$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0,0,0);
			$this->SetFont('Helvetica','B',8);
			$this->SetX(2);
			
			$this->Cell(8,5,'S/L','LTB',0,'L',true);
			$this->Cell(11,5,'ComID','LTB',0,'C',true);
			$this->Cell(37,5,'Client ID','LTB',0,'L',true);
			$this->Cell(54,5,'Clint Address','LTBR',0,'C',true);
			$this->Cell(22,5,'Cell No','LTB',0,'C',true);
			$this->Cell(12,5,'Act Bill','LTB',0,'R',true); 
			$this->Cell(12,5,'P.Dis','LTB',0,'R',true);
			$this->Cell(12,5,'Due','LTB',0,'R',true);
			$this->Cell(12,5,'Adv','LTB',0,'R',true);
			$this->Cell(14,5,'Total Due','LTB',0,'R',true);
			$this->Cell(12,5,'Dis','LTB',0,'R',true);
			$this->Cell(14,5,'Paid','LTB',0,'R',true);
			$this->Cell(13,5,'Balance','LTB',0,'R',true);
			$this->Cell(60,5,'Note','LTBR',0,'C',true); 
			$this->Ln();
			
		}
		function Footer()
				{
					global $comp_name;
					//Position at 1.5 cm from bottom
					$this->SetY(-15);
					//Arial italic 8
					$this->SetFont('Helvetica','I',8);
					//Page number
					$this->Cell(0,10,'Page '.$this->PageNo().'/'.$comp_name,'T',0,'C');
					$this->SetDrawColor(8, 102, 198);
					parent::Footer();
				}
		}

		//Connect to database
		include("connection.php");

		$pdf=new PDF();
		$pdf->AddPage('L', 'A4');
				if($way == 'macreseller'){
					if($box_id == 'all'){
						$result = mysql_query("SELECT t1.c_id, t1.com_id, t1.address, t1.cell, t1.discount AS diss, t1.note, t1.p_price_reseller AS p_price, t2.dis, t2.bill, t3.bill_disc, t3.pay FROM
										(
										SELECT c.c_id, c.com_id, c.address, c.cell, c.p_id, p.p_price_reseller, c.discount, c.note FROM clients AS c 
										LEFT JOIN package AS p ON c.p_id = p.p_id
										WHERE c.sts = 0 AND c.z_id = '$z_id' AND c.mac_user = '1'
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
										SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment_mac_client AS p 
										WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'
										GROUP BY p.c_id
										)t3
										ON t1.c_id = t3.c_id ORDER BY t1.com_id ASC");
					}
					else{
						$result = mysql_query("SELECT t1.c_id, t1.com_id, t1.address, t1.cell, t1.discount AS diss, t1.note, t1.p_price_reseller AS p_price, t2.dis, t2.bill, t3.bill_disc, t3.pay FROM
										(
										SELECT c.c_id, c.com_id, c.address, c.cell, c.p_id, p.p_price_reseller, c.discount, c.note FROM clients AS c 
										LEFT JOIN package AS p ON c.p_id = p.p_id
										WHERE c.sts = 0 AND c.z_id = '$z_id' AND c.mac_user = '1' AND c.box_id = '$box_id'
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
										SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment_mac_client AS p 
										WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'
										GROUP BY p.c_id
										)t3
										ON t1.c_id = t3.c_id ORDER BY t1.com_id ASC");
					}
				}
				else{
						$sql2 = "SELECT t1.c_id, t1.com_id, t1.address, t1.cell, t1.discount AS diss, t1.note, t1.p_price, t2.dis, t2.bill, t3.bill_disc, t3.pay FROM
								(
								SELECT c.c_id, c.com_id, c.address, c.cell, c.p_id, p.p_price, c.discount, c.note FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id 
								WHERE c.sts = '0' AND c.mac_user = '0'";
				
					if ($z_id != 'all'){
						$sql2 .= " AND c.z_id = '{$z_id}'";
					}
					if ($user_type == 'billing'){
						$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
						$sql2 .= ")t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
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
								ON t1.c_id = t3.c_id ORDER BY t1.com_id ASC";
				
						$result = mysql_query($sql2);
				}
				
			$ActualBill = 0;
			$DewsBill = 0;
			$AdvanceBill = 0;
			$TotalBill = 0;
			$BillDiscount = 0;
			$TotalPayment = 0;
			$Balance = 0;
			$disss = 0;
			$x=1;
		while ($row=mysql_fetch_array($result)) {
				$c_id = $row['c_id'];
				$com_id = $row['com_id'];
				$address = $row['address'];
				$cell = $row['cell'];
				$p_price = $row['p_price'];
				$discount = $row['dis'];
				$bill = $row['bill'];
				$bill_disc = $row['bill_disc'];
				$pay = $row['pay'];
				$diss = $row['diss'];
				$note = $row['note'];
				
				$balance = $bill - ($bill_disc + $pay);
				if($way == 'macreseller'){
				$results = mysql_query("SELECT t2.c_id, t2.dis, t2.bill, t3.bill_disc, t3.pay FROM
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
				}
				$rows = mysql_fetch_array($results);					
				$dew = $rows['bill'] - ($rows['bill_disc'] + $rows['pay']);
				
				if($dew < 0){
					$dews = 0;
					$advs = abs($dew);
				}else{
					$dews = $dew;
					$advs = 0;
				}
				
				$total_bill = ($bill + $dews)-$advs;
				$total_payable = $balance + $dew;
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(2);
				
				$pdf->Cell(8,5,$x,'LTB',0,'L',true);
				$pdf->Cell(11,5,$com_id,'LTB',0,'C',true);
				$pdf->Cell(37,5,$c_id,'LTB',0,'L',true);
				$pdf->Cell(54,5,$address,'LTBR',0,'L',true);
				$pdf->Cell(22,5,$cell,'LTB',0,'L',true);
				$pdf->SetFont('Helvetica','B',9);
				$pdf->Cell(12,5,number_format($p_price,0),'LTB',0,'R',true); 
				$pdf->Cell(12,5,number_format($diss,0),'LTB',0,'R',true); 
				$pdf->Cell(12,5,number_format($dews,0),'LTB',0,'R',true);
				$pdf->Cell(12,5,number_format($advs,0),'LTB',0,'R',true);
				$pdf->Cell(14,5,number_format($total_bill,0),'LTB',0,'R',true);
				$pdf->Cell(12,5,number_format($bill_disc,0),'LTB',0,'R',true);
				$pdf->Cell(14,5,number_format($pay,0),'LTB',0,'R',true);
				$pdf->Cell(13,5,number_format($total_payable,0),'LTB',0,'R',true);
				$pdf->SetFont('Helvetica','',8);
				$pdf->Cell(60,5,$note,'LTBR',0,'L',true);
				$pdf->Ln();
				
			$ActualBill += $p_price;
			$DewsBill += $dews;
			$AdvanceBill += $advs;
			$TotalBill += $total_bill;
			$BillDiscount += $bill_disc;
			$TotalPayment += $pay;
			$Balance += $total_payable;
			$disss += $diss;
			$x++;
		}
			$pdf->SetX(2);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetFont('Helvetica','B',10);
			
			$pdf->Cell(111,6,'TOTAL','LTB',0,'C',true);
			$pdf->Cell(33,6,number_format($ActualBill,0),'TB',0,'R',true); 
			$pdf->Cell(12,6,number_format($disss,0),'LTB',0,'R',true); 
			$pdf->Cell(12,6,number_format($DewsBill,0),'LTB',0,'R',true);
			$pdf->Cell(12,6,number_format($AdvanceBill,0),'LTB',0,'R',true);
			$pdf->Cell(14,6,number_format($TotalBill,0),'LTBR',0,'R',true);
			$pdf->Cell(12,6,number_format($BillDiscount,0),'LTB',0,'R',true);
			$pdf->Cell(14,6,number_format($TotalPayment,0),'LTBR',0,'R',true);
			$pdf->Cell(13,6,number_format($Balance,0),'LTBR',0,'R',true);
			$pdf->Cell(60,6,'','LTBR',0,'L',true);
			$pdf->Ln();
		
$pdf->Output();
?>