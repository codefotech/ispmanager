<?php
require('mysql_table.php');
require('connection.php');

$way = $_REQUEST['way'];
$bill_type = $_REQUEST['bill_type'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

if($way == 'client'){
class PDF extends PDF_MySQL_Table
		{
		function Header()
		{
			parent::Header();
			
			$this->SetFillColor(160, 160, 160);
			$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0, 0, 0);
			$this->SetFont('Helvetica','',8);
			$this->SetXY(4, 5);
			
			$this->Cell(8,6,'S/L','LTB',0,'C',true);
			$this->Cell(17,6,'Date','LTB',0,'C',true);
			$this->Cell(40,6,'Clint ID','LTBR',0,'C',true);
			$this->Cell(23,6,'Cell No','LTB',0,'C',true);
			$this->Cell(40,6,'Bill Type','LTB',0,'C',true); 
			$this->Cell(15,6,'Amount','LTB',0,'C',true);
			$this->Cell(59,6,'Note','LTBR',0,'C',true);
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

		$pdf=new PDF();
		$pdf->AddPage();

		
		$sql = "SELECT b.id, c.c_id, c.cell, t.type, c.c_name, b.pay_date, b.amount, b.bill_dsc FROM bill_signup AS b
				LEFT JOIN clients AS c ON b.c_id = c.c_id
				LEFT JOIN bills_type AS t ON t.bill_type = b.bill_type
				WHERE b.pay_date BETWEEN '$f_date' AND '$t_date'";  	
				
		if($bill_type != 'all'){
			$sql .= " AND b.bill_type = '{$bill_type}'";
		}
		
		$sql .= " ORDER BY b.pay_date DESC";
		
		$result = mysql_query($sql);
		
		$tot_bill = 0;
		$x = 1;
		while ($row=mysql_fetch_array($result)) {
			
				$amount = $row['amount'];
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(4);
				
				$pdf->Cell(8,6,$x,'LTB',0,'C',true);
				$pdf->Cell(17,6,$row['pay_date'],'LTB',0,'L',true);
				$pdf->Cell(40,6,$row['c_id'],'LTBR',0,'L',true);
				$pdf->Cell(23,6,$row['cell'],'LTB',0,'L',true);
				$pdf->Cell(40,6,$row['type'],'LTB',0,'L',true);
				$pdf->Cell(15,6,number_format($amount,0),'LTB',0,'R',true); 
				$pdf->Cell(59,6,$row['bill_dsc'],'LTBR',0,'L',true);
				$pdf->Ln();
				
			
			$tot_bill += $amount;
			$x++;

		}
			$pdf->SetX(4);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(8, 102, 198);
			$pdf->SetFont('Helvetica','B',8);
			
			$pdf->Cell(128,6,'Total','LTB',0,'R',true);
			$pdf->Cell(15,6,number_format($tot_bill,0),'LTBR',0,'R',true);
			$pdf->Cell(59,6,'','LTBR',0,'C',true);
			
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
			$this->SetDrawColor(0, 0, 0);
			$this->SetFont('Helvetica','',8);
			$this->SetXY(4, 5);
			
			$this->Cell(8,6,'S/L','LTB',0,'C',true);
			$this->Cell(17,6,'Date','LTB',0,'C',true);
			$this->Cell(49,6,'Name','LTBR',0,'C',true);
			$this->Cell(23,6,'Cell No','LTB',0,'C',true);
			$this->Cell(40,6,'Bill Type','LTB',0,'C',true); 
			$this->Cell(15,6,'Amount','LTB',0,'C',true);
			$this->Cell(50,6,'Note','LTBR',0,'C',true);
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

		$pdf=new PDF();
		$pdf->AddPage();

		
		$sql = "SELECT e.id, e.be_name, e.cell, b.type, e.amount, e.pay_date, e.bill_dsc FROM bill_extra AS e
				LEFT JOIN bills_type AS b ON b.bill_type = e.bill_type
				WHERE e.pay_date BETWEEN '$f_date' AND '$t_date'";  	
				
		if($bill_type != 'all'){
			$sql .= " AND e.bill_type = '{$bill_type}'";
		}
		
		$sql .= " ORDER BY e.pay_date DESC";
		
		$result = mysql_query($sql);
		
		$tot_bill = 0;
		$x = 1;
		while ($row=mysql_fetch_array($result)) {
			
				$amount = $row['amount'];
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(4);
				
				$pdf->Cell(8,6,$x,'LTB',0,'C',true);
				$pdf->Cell(17,6,$row['pay_date'],'LTB',0,'L',true);
				$pdf->Cell(49,6,$row['be_name'],'LTBR',0,'L',true);
				$pdf->Cell(23,6,$row['cell'],'LTB',0,'L',true);
				$pdf->Cell(40,6,$row['type'],'LTB',0,'L',true);
				$pdf->Cell(15,6,number_format($amount,0),'LTB',0,'R',true); 
				$pdf->Cell(50,6,$row['bill_dsc'],'LTBR',0,'L',true);
				$pdf->Ln();
				
			
			$tot_bill += $amount;
			$x++;

		}
			$pdf->SetX(4);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(8, 102, 198);
			$pdf->SetFont('Helvetica','B',8);
			
			$pdf->Cell(137,6,'Total','LTB',0,'R',true);
			$pdf->Cell(15,6,number_format($tot_bill,0),'LTBR',0,'R',true);
			$pdf->Cell(50,6,'','LTBR',0,'C',true);
			
			$pdf->Ln();
}
$pdf->Output();
?>