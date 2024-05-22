<?php
require('mysql_table.php');
require('connection.php');

$z_id = $_REQUEST['z_id'];
$payment_type = $_REQUEST['payment_type'];
$box_id = $_REQUEST['box_id'];
$user_type = $_REQUEST['user_type'];
$e_id = $_REQUEST['e_id'];
$way = $_REQUEST['way'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

if($way == 'none'){
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
			
			$this->Cell(8,6,'S/L','LTB',0,'C',true);
			$this->Cell(16,6,'Date','LTB',0,'L',true);
			$this->Cell(36,6,'PPoE ID','LTB',0,'L',true);
			$this->Cell(11,6,'ComID','LTB',0,'L',true);
			$this->Cell(22,6,'Cell No','LTB',0,'C',true);
			$this->Cell(10,6,'Bill','LTB',0,'C',true);
			$this->Cell(14,6,'Discount','LTB',0,'C',true);
			$this->Cell(12,6,'Amount','LTB',0,'C',true);
			$this->Cell(26,6,'Recive By','LTB',0,'C',true);
			$this->Cell(21,6,'MR No','LTBR',0,'C',true);
			$this->Cell(30,6,'Bank','LTBR',0,'C',true); 
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
		$pdf->AddPage();
		$sql4 = "SELECT DATE_FORMAT(p.pay_date, '%d-%m-%Y') AS pay_date, c.c_id, c.com_id, p.moneyreceiptno, p.trxid, p.payment_type, c.address, b.id AS b_id, b.bank_name, c.cell, pk.p_price, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc, p.pay_ent_by, e.e_name, c.note
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id 
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
								LEFT JOIN bank AS b ON b.id = p.bank
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date' AND c.mac_user = '0'";
				if ($z_id != 'all'){
					$sql4 .= " AND c.z_id = '{$z_id}'";
				}
				if ($user_type == 'billing'){
					$sql4 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
				}
				if ($payment_type != 'all'){
					if ($payment_type == 'CASH'){
						$sql4 .= " AND p.pay_mode = '{$payment_type}'";
					}
					else{
						$sql4 .= " AND p.pay_mode != 'CASH'";
					}
					
				}
				$sql4 .= " GROUP BY p.c_id ORDER BY p.pay_date_time DESC";
				
			$result = mysql_query($sql4);					
		
			$ActualBill = 0;
			$BillDiscount = 0;
			$TotalPayment = 0;
			$x = 1;
		while ($row=mysql_fetch_array($result)) {
				$date = $row['pay_date'];
				$ent_by = $row['e_name'];
				$c_id = $row['c_id'];
				$com_id = $row['com_id'];
				$address = $row['address'];
				$cell = $row['cell'];
				$p_price = $row['p_price'];
				$bill_disc = $row['bill_disc'];
				$pay = $row['pay'];
				$mrno = $row['moneyreceiptno'];
				$b_id = $row['b_id'];
				$bank_name = $row['bank_name'];
				$trxid = $row['trxid'];
				$paymenttype = $row['payment_type'];
				if($paymenttype == '2'){
					$entby = 'Webhook';
				}
				elseif($paymenttype == '6'){
					$entby = 'bKashT';
				}
				else{
					$entby = $ent_by;
				}
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(2);
				
				$pdf->Cell(8,5,$x,'LTB',0,'C',true);
				$pdf->Cell(16,5,$date,'LTB',0,'L',true);
				$pdf->Cell(36,5,$c_id,'LTB',0,'L',true);
				$pdf->Cell(11,5,$com_id,'LTB',0,'C',true);
				$pdf->Cell(22,5,$cell,'LTB',0,'L',true);
				$pdf->Cell(10,5,number_format($p_price,0),'LTB',0,'R',true); 
				$pdf->Cell(14,5,number_format($bill_disc,0),'LTB',0,'R',true);
				$pdf->SetFont('Helvetica','B',8);
				$pdf->Cell(12,5,number_format($pay,0),'LTB',0,'R',true);
				$pdf->SetFont('Helvetica','',8);
				$pdf->Cell(26,5,$entby,'LTB',0,'L',true);
				$pdf->Cell(21,5,$mrno.$trxid,'LTBR',0,'L',true);
				$pdf->Cell(30,5,$bank_name,'LTBR',0,'L',true);
				$pdf->Ln();
				
			$ActualBill += $p_price;
			$BillDiscount += $bill_disc;
			$TotalPayment += $pay;
			$x++;

		}
			$pdf->SetX(2);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetFont('Helvetica','B',12);
			
			$pdf->Cell(101,6,'Total','LTB',0,'C',true);
			$pdf->Cell(16,6,number_format($BillDiscount,0),'TBR',0,'R',true);
			$pdf->Cell(22,6,number_format($TotalPayment,0),'LTB',0,'L',true);
			$pdf->Cell(67,6,'','TBR',0,'L',true);
			
			
			$pdf->Ln();
			
		
}
else{
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
			
			
			$this->Cell(8,6,'S/L','LTB',0,'C',true);
			$this->Cell(16,6,'Date','LTB',0,'C',true);
			$this->Cell(36,6,'PPoE ID','LTB',0,'L',true);
			$this->Cell(13,6,'ComID','LTB',0,'C',true);
			$this->Cell(24,6,'Cell No','LTB',0,'C',true);
			$this->Cell(14,6,'Method','LTB',0,'C',true);
			$this->Cell(10,6,'Bill','LTB',0,'R',true);
			$this->Cell(14,6,'Discount','LTB',0,'R',true);
			$this->Cell(14,6,'Amount','LTB',0,'R',true);
			$this->Cell(30,6,'Recive By','LTB',0,'C',true);
			$this->Cell(27,6,'MR No','LTBR',0,'C',true);
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
		$pdf->AddPage();

		$sql = "SELECT DATE_FORMAT(p.pay_date, '%d-%m-%Y') AS pay_date, c.com_id, c.c_id, p.moneyreceiptno, c.address, c.cell, pk.p_price_reseller AS p_price, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc, p.pay_ent_by, e.e_name, c.note, p.payment_type, p.pay_mode
								FROM payment_mac_client AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
								WHERE p.pay_date BETWEEN '$f_date' AND '$t_date' AND c.z_id = '$z_id' AND c.mac_user = '1'";

					if($box_id != 'all'){
						$sql .= " AND c.box_id = '{$box_id}'";
					}
					if($payment_type != 'all'){
						if ($payment_type == 'CASH'){
							$sql .= " AND p.pay_mode = 'CASH'";
						}
						else{
							$sql .= " AND p.pay_mode != 'CASH'";
						}
						
					}
						$sql .= " GROUP BY p.c_id ORDER BY p.pay_date";  	
		
		$result = mysql_query($sql);
		
			$ActualBill = 0;
			$BillDiscount = 0;
			$TotalPayment = 0;
			$x = 1;
			
		while ($row=mysql_fetch_array($result)) {
				$date = $row['pay_date'];
				$ent_by = $row['e_name'];
				$c_id = $row['c_id'];
				$com_id = $row['com_id'];
				$address = $row['address'];
				$cell = $row['cell'];
				$p_price = $row['p_price'];
				$bill_disc = $row['bill_disc'];
				$pay = $row['pay'];
				$mrno = $row['moneyreceiptno'];
				$paymode = $row['pay_mode'];
				$paymenttype = $row['payment_type'];
				if($paymenttype == '2'){
					$entby = 'Webhook';
				}
				elseif($paymenttype == '6'){
					$entby = 'bKashT';
				}
				else{
					$entby = $ent_by;
				}
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(2);
				
				$pdf->Cell(8,5,$x,'LTB',0,'C',true);
				
				$pdf->SetFont('Helvetica','B',8);
				$pdf->Cell(16,5,$date,'LB',0,'L',true);
				
				$pdf->SetFont('Helvetica','',8);
				$pdf->Cell(36,5,$c_id,'LB',0,'L',true);
				$pdf->Cell(13,5,$com_id,'LB',0,'C',true);
				$pdf->Cell(24,5,$cell,'LB',0,'L',true);
				$pdf->Cell(14,5,$paymode,'LB',0,'C',true);
				$pdf->Cell(10,5,number_format($p_price,0),'LB',0,'R',true);
				
				$pdf->SetFont('Helvetica','B',9);
				$pdf->Cell(14,5,number_format($bill_disc,0),'LB',0,'R',true);
				$pdf->Cell(14,5,number_format($pay,0),'LB',0,'R',true);
				
				$pdf->SetFont('Helvetica','',8);
				$pdf->Cell(30,5,$entby,'LB',0,'C',true);
				$pdf->Cell(27,5,$mrno.$trxid,'LBR',0,'L',true);
				$pdf->Ln();
				
			$ActualBill += $p_price;
			$BillDiscount += $bill_disc;
			$TotalPayment += $pay;
			$x++;
		}
			$pdf->SetX(2);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetFont('Helvetica','B',10);
			
			$pdf->Cell(121,6,'Total','LTB',0,'C',true);
			$pdf->Cell(14,6,number_format($BillDiscount,0),'LTB',0,'R',true);
			$pdf->Cell(14,6,number_format($TotalPayment,0),'LTB',0,'R',true);
			$pdf->Cell(57,6,'','TBR',0,'L',true);
			
			$pdf->Ln();
}
$pdf->Output();
?>