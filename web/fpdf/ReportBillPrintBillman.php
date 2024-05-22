<?php
require('mysql_table.php');
require('connection.php');

ini_alter('date.timezone','Asia/Almaty');
$bill_man = $_REQUEST['bill_man'];
$p_m = $_REQUEST['p_m'];

$query_date = date("Y-m-d");

$df_date = $_REQUEST['df_date'];
$dt_date = $_REQUEST['dt_date'];

$f_date = date('Y-m-01', strtotime($query_date));
$t_date = date('Y-m-t', strtotime($query_date));
class PDF extends PDF_MySQL_Table
		{
		function Header()
		{
			parent::Header();
			
			$this->SetFillColor(160, 160, 160);
			$this->SetTextColor(0,0,0);
			$this->SetDrawColor(0, 0, 0);
			$this->SetFont('Helvetica','',8);
			$this->SetX(5, 5);
			
			$this->Cell(30,6,'PPPoE ID','LTB',0,'C',true);
			$this->Cell(63,6,'Address','LTBR',0,'C',true);
			$this->Cell(23,6,'Cell No','LTB',0,'C',true);
			$this->Cell(17,6,'Joining Date','LTB',0,'C',true);
			$this->Cell(13,6,'Actual Bill','LTB',0,'C',true); 
			$this->Cell(13,6,'Due','LTB',0,'C',true);
			$this->Cell(13,6,'Total Bill','LTB',0,'C',true);
			$this->Cell(13,6,'Total Pay','LTB',0,'C',true);
			$this->Cell(13,6,'Balance','LTBR',0,'C',true);
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
										
		$sql = "SELECT t1.c_id, t1.z_name, t1.p_name, t1.con_sts, t1.c_name, t1.join_date, t1.address, t1.note, t1.cell, t1.p_price, t2.dis, t2.bill, t3.bill_disc, t1.p_m, t3.pay FROM
								(
								SELECT c.c_id, c.c_name, c.con_sts, c.join_date, c.address, z.z_name, c.cell, c.p_id, p.p_price, c.note, c.p_m, p.p_name FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z on z.z_id = c.z_id
								WHERE c.sts = 0 AND c.mac_user != '1'";  							
					if ($bill_man != 'all') {
						$sql .= " AND c.bill_man = '{$bill_man}'";
					}
					if ($p_m != 'all') {
						$sql .= " AND c.p_m = '{$p_m}'";
					}
					$sql .= ")t1
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
								ON t1.c_id = t3.c_id ORDER BY t1.con_sts";
		$result = mysql_query($sql);

		$x = 1;	
		while ($row=mysql_fetch_array($result)) {
				$date = $row['pay_date'];
				$c_id = $row['c_id'];
				$c_name = $row['c_name'];
				$z_name = $row['z_name'];
				$address = $row['address'];
				$p_name = $row['p_name'];
				$cell = $row['cell'];
				$p_price = $row['p_price'];
				$discount = $row['dis'];
				$bill = $row['bill'];
				$bill_disc = $row['bill_disc'];
				$pay = $row['pay'];
				$note = $row['note'];
				$pa_m = $row['p_m'];
				$join_date = $row['join_date'];
				$con_sts = $row['con_sts'];
				
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
				
			if($total_payable <= 0.99){
					
			}else{
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(5, 5);
				$pdf->SetX(5, 5);
				
				$pdf->Cell(30,5,$c_id,'LTB',0,'L',true);
				$pdf->Cell(63,5,$address,'LTBR',0,'L',true);
				$pdf->Cell(23,5,$cell,'LTB',0,'L',true);
				$pdf->Cell(17,5,$join_date,'LTB',0,'L',true);
				$pdf->Cell(13,5,number_format($p_price,0),'LTB',0,'R',true); 
				$pdf->Cell(13,5,number_format($dews,0),'LTB',0,'R',true);
				$pdf->Cell(13,5,number_format($bill,0),'LTB',0,'R',true);
				$pdf->Cell(13,5,number_format($pay,0),'LTB',0,'R',true);
				$pdf->Cell(13,5,number_format($total_payable,0),'LTBR',0,'R',true);
				$pdf->Ln();
				$x++;
			}
		}
$pdf->Output();
?>