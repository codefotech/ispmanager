<?php
require('mysql_table.php');
require('connection.php');

$z_id = $_REQUEST['z_id'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];
$payment_type = $_REQUEST['payment_type'];

if($z_id == 'all'){
	class PDF extends PDF_MySQL_Table
		{
		function Header()
		{
			parent::Header();
			
			$this->SetFillColor(160, 160, 160);
			$this->SetTextColor(0,0,0);
			$this->SetDrawColor(8, 102, 198);
			$this->SetFont('Helvetica','',8);
			$this->SetX(2);
			
			$this->Cell(8,6,'S/L','LTB',0,'L',true);
			$this->Cell(30,6,'Zone','LTB',0,'L',true);
			$this->Cell(30,6,'Reseller','LTB',0,'L',true);
			$this->Cell(25,6,'Bank','LTB',0,'C',true);
			$this->Cell(20,6,'Mode','LTB',0,'C',true);
			$this->Cell(25,6,'Entry By','LTB',0,'C',true);
			$this->Cell(15,6,'Discount','LTB',0,'C',true);
			$this->Cell(15,6,'Amount','LTB',0,'C',true);
			$this->Cell(38,6,'Note','LTBR',0,'C',true); 
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
		
		$sql4 = "SELECT p.id, p.e_id, e.e_name AS reselername, p.z_id, z.z_name, p.bank, b.bank_name, p.pay_date, p.pay_time, p.pay_mode, sum(p.pay_amount) AS amount, sum(p.discount) AS discount, p.entry_by, h.e_name AS entrybay, p.date_time, p.sts, p.note FROM payment_macreseller AS p
								LEFT JOIN emp_info AS e ON e.e_id = p.e_id
								LEFT JOIN zone AS z ON z.z_id = p.z_id
								LEFT JOIN bank AS b ON b.id = p.bank
								LEFT JOIN emp_info AS h ON h.e_id = p.e_id

								WHERE p.sts = '0' AND p.pay_date BETWEEN '$f_date' AND '$t_date'";  

				if ($payment_type != 'all'){
					if ($payment_type == 'Cash'){
						$sql4 .= " AND p.pay_mode = '{$payment_type}'";
					}
					else{
						$sql4 .= " AND p.pay_mode != 'Cash'";
					}
				}
				$sql4 .= " GROUP BY z.z_id ORDER BY z.z_name";
		$result = mysql_query($sql4);
		
			$BillDiscount = 0;
			$TotalPayment = 0;
			$x = 1;
		while ($row=mysql_fetch_array($result)) {
				$reselername = $row['reselername'];
				$z_name = $row['z_name'];
				$bank_name = $row['bank_name'];
				$pay_date = $row['pay_date'];
				$pay_mode = $row['pay_mode'];
				$amount = $row['amount'];
				$discount = $row['discount'];
				$entrybay = $row['entrybay'];
				$note = $row['note'];
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(2);
				
				$pdf->Cell(8,5,$x,'LTB',0,'L',true);
				$pdf->Cell(30,5,$z_name,'LTB',0,'L',true);
				$pdf->Cell(30,5,$reselername,'LTB',0,'L',true);
				$pdf->Cell(25,5,$bank_name,'LTB',0,'L',true);
				$pdf->Cell(20,5,$pay_mode,'LTB',0,'C',true);
				$pdf->Cell(25,5,$entrybay,'LTB',0,'L',true);
				$pdf->Cell(15,5,number_format($discount,0),'LTB',0,'R',true); 
				$pdf->Cell(15,5,number_format($amount,0),'LTB',0,'R',true);
				$pdf->Cell(38,5,$note,'LTBR',0,'L',true);
				$pdf->Ln();
				
			$BillDiscount += $discount;
			$TotalPayment += $amount;
			$x++;

		}
			$pdf->SetX(2);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(8, 102, 198);
			$pdf->SetFont('Helvetica','',8);
			
			$pdf->Cell(138,6,'Total','LTB',0,'C',true);
			$pdf->Cell(15,6,number_format($BillDiscount,0),'LTBR',0,'R',true);
			$pdf->Cell(15,6,number_format($TotalPayment,0),'LTBR',0,'R',true);
			$pdf->Cell(38,6,'','LTBR',0,'L',true);
			
			
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
			$this->SetDrawColor(8, 102, 198);
			$this->SetFont('Helvetica','',8);
			$this->SetX(2);
			
			
			$this->Cell(8,6,'S/L','LTB',0,'L',true);
			$this->Cell(30,6,'Date','LTB',0,'L',true);
			$this->Cell(35,6,'Bank','LTB',0,'L',true);
			$this->Cell(20,6,'Mode','LTB',0,'C',true);
			$this->Cell(35,6,'Entry By','LTB',0,'C',true);
			$this->Cell(15,6,'Discount','LTB',0,'C',true);
			$this->Cell(15,6,'Amount','LTB',0,'C',true);
			$this->Cell(48,6,'Note','LTBR',0,'C',true); 
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
		
		$sql4 = "SELECT p.id, p.e_id, e.e_name AS reselername, p.z_id, z.z_name, p.bank, b.bank_name, p.pay_date, p.pay_time, p.pay_mode, p.pay_amount AS amount, p.discount AS discount, p.entry_by, h.e_name AS entrybay, p.date_time, p.sts, p.note FROM payment_macreseller AS p
								LEFT JOIN emp_info AS e ON e.e_id = p.e_id
								LEFT JOIN zone AS z ON z.z_id = p.z_id
								LEFT JOIN bank AS b ON b.id = p.bank
								LEFT JOIN emp_info AS h ON h.e_id = p.e_id

								WHERE p.sts = '0' AND p.pay_date BETWEEN '$f_date' AND '$t_date' AND z.z_id = '$z_id'";  							
				if ($payment_type != 'all'){
					if ($payment_type == 'Cash'){
						$sql4 .= " AND p.pay_mode = '{$payment_type}'";
					}
					else{
						$sql4 .= " AND p.pay_mode != 'Cash'";
					}
				}
				$sql4 .= " ORDER BY p.date_time ASC";
		$result = mysql_query($sql4);
		
			$BillDiscount = 0;
			$TotalPayment = 0;
			$x = 1;
			
		while ($row=mysql_fetch_array($result)) {
				$reselername = $row['reselername'];
				$z_name = $row['z_name'];
				$bank_name = $row['bank_name'];
				$pay_date = $row['pay_date'];
				$pay_time = $row['pay_time'];
				$pay_mode = $row['pay_mode'];
				$amount = $row['amount'];
				$discount = $row['discount'];
				$entrybay = $row['entrybay'];
				$note = $row['note'];
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(2);
				
				$pdf->Cell(8,5,$x,'LTB',0,'L',true);
				$pdf->Cell(30,5,$pay_date.' '.$pay_time,'LTB',0,'L',true);
				$pdf->Cell(35,5,$bank_name,'LTB',0,'L',true);
				$pdf->Cell(20,5,$pay_mode,'LTB',0,'C',true);
				$pdf->Cell(35,5,$entrybay,'LTB',0,'L',true);
				$pdf->Cell(15,5,number_format($discount,0),'LTB',0,'R',true); 
				$pdf->Cell(15,5,number_format($amount,0),'LTB',0,'R',true);
				$pdf->Cell(48,5,$note,'LTBR',0,'L',true);
				$pdf->Ln();
				
			$BillDiscount += $discount;
			$TotalPayment += $amount;
			$x++;
		}
			$pdf->SetX(2);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(8, 102, 198);
			$pdf->SetFont('Helvetica','',8);

			$pdf->Cell(128,6,'Total','LTB',0,'C',true);
			$pdf->Cell(15,6,number_format($BillDiscount,0),'LTBR',0,'R',true);
			$pdf->Cell(15,6,number_format($TotalPayment,0),'LTBR',0,'R',true);
			$pdf->Cell(48,6,'','LTBR',0,'L',true);
			
			$pdf->Ln();
}
$pdf->Output();
?>