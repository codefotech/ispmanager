<?php
require('mysql_table.php');
require('connection.php');
ini_alter('date.timezone','Asia/Almaty');
$way = $_REQUEST['way'];

$z_id = $_REQUEST['z_id'];
$user_type = $_REQUEST['user_type'];
$e_id = $_REQUEST['e_id'];
$p_m = $_REQUEST['p_m'];
$con_sts = $_REQUEST['con_sts'];
$sts = $_REQUEST['sts'];
$partial = $_REQUEST['partial'];
$box_id = $_REQUEST['box_id'];

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
			$this->SetFont('Helvetica','B',8);
			$this->SetX(3, 5);
			
			$this->Cell(8,6,'S/L','LTB',0,'C',true);
			$this->Cell(12,6,'ComID','LTB',0,'C',true);
			$this->Cell(38,6,'Client ID','LTB',0,'C',true);
			$this->Cell(40,6,'Client Name','LTB',0,'C',true);
			$this->Cell(43,6,'Zone','LTBR',0,'C',true);
			$this->Cell(23,6,'Cell No','LTB',0,'C',true);
			$this->Cell(31,6,'Package','LTB',0,'C',true);
			$this->Cell(13,6,'Status','LTB',0,'C',true);
			$this->Cell(14,6,'B.D | P.D','LTB',0,'C',true);
			$this->Cell(15,6,'Actual Bill','LTB',0,'C',true); 
			$this->Cell(13,6,'Due','LTB',0,'C',true);
			$this->Cell(13,6,'Total Bill','LTB',0,'R',true);
			$this->Cell(13,6,'Paid','LTB',0,'R',true);
			$this->Cell(15,6,'Balance','LTBR',0,'R',true);
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
		$sql = "SELECT t1.c_id, t1.com_id, t1.z_name, t1.p_name, t1.con_sts, t1.c_name, t1.note, t1.cell, t1.b_date, t1.p_price, t1.payment_deadline, t2.dis, t2.bill, t3.bill_disc, t1.p_m, t3.pay FROM
								(
								SELECT c.c_id, c.com_id, c.c_name, c.con_sts, c.address, z.z_name, c.b_date, c.payment_deadline, c.cell, c.p_id, p.p_price_reseller AS p_price, c.note, c.p_m, p.p_name FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z on z.z_id = c.z_id
								WHERE c.sts = '0' AND c.mac_user = '1'";  							
					if ($z_id != 'all') {
						$sql .= " AND c.z_id = '{$z_id}'";
					}
					if ($box_id != 'all'){
						$sql .= " AND box_id = '{$box_id}'";
					}
					if ($p_m != 'all') {
						$sql .= " AND c.p_m = '{$p_m}'";
					}
					$sql .= ")t1
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
								ON t1.c_id = t3.c_id ORDER BY t1.con_sts";
	}
	else{
		$sql = "SELECT t1.c_id, t1.com_id, t1.z_name, t1.p_name, t1.con_sts, t1.c_name, t1.note, t1.cell, t1.b_date, t1.p_price, t1.payment_deadline, t2.dis, t2.bill, IFNULL(t3.bill_disc, 0) AS bill_disc, t1.p_m, IFNULL(t3.pay, 0) AS pay FROM
								(
								SELECT c.c_id, c.com_id, c.c_name, c.con_sts, c.address, z.z_name, c.cell, c.b_date, c.payment_deadline, c.p_id, p.p_price, c.note, c.p_m, p.p_name FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z on z.z_id = c.z_id
								WHERE c.mac_user = '0'";
					if ($z_id != 'all') {
						$sql .= " AND c.z_id = '{$z_id}'";
					}
					if ($box_id != 'all'){
						$sql .= " AND box_id = '{$box_id}'";
					}
					if ($user_type == 'billing'){
						$sql .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
					}
					if ($p_m != 'all') {
						$sql .= " AND c.p_m = '{$p_m}'";
					}
					if ($sts != 'all') {
						$sql .= " AND c.sts = '{$sts}'";
					}
					if ($con_sts != 'all') {
						$sql .= " AND c.con_sts = '{$con_sts}'";
					}
					if ($df_date != 'all' && $dt_date != 'all'){
						$sql .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$dt_date}'";
					}
					if ($df_date != 'all' && $dt_date == 'all'){
						$sql .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$df_date}'";
					}
					if ($df_date == 'all' && $dt_date == 'all'){
						$sql .= "";
					}
					if ($df_date == 'all' && $dt_date != 'all'){
						$sql .= " AND c.payment_deadline BETWEEN '{$dt_date}' AND '{$dt_date}'";
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
								ON t1.c_id = t3.c_id"; 
					if ($partial != 'all') {
						if ($partial != '1') {
							$sql .= " WHERE IFNULL(t3.pay, 0)+IFNULL(t3.bill_disc, 0) = '0'";
						}
						else{
							$sql .= " WHERE IFNULL(t3.pay, 0)+IFNULL(t3.bill_disc, 0) != '0'";
						}
					}
						$sql .= " ORDER BY t1.con_sts";
	}
		$result = mysql_query($sql);

		$x = 1;	
		$ppricee = 0;
		$dewssss = 0;
		$TotalPpaid = 0;
		$TotalPpay = 0;
		$TotalPayment = 0;
		while ($row=mysql_fetch_array($result)) {
				$date = $row['pay_date'];
				$c_id = $row['c_id'];
				$com_id = $row['com_id'];
				$c_name = $row['c_name'];
				$z_name = $row['z_name'];
				$p_name = $row['p_name'];
				$cell = $row['cell'];
				$p_price = $row['p_price'];
				$discount = $row['dis'];
				$bill = $row['bill'];
				$b_date = $row['b_date'];
				$payment_deadline = $row['payment_deadline'];
				$bill_disc = $row['bill_disc'];
				$pay = $row['pay'];
				$note = $row['note'];
				$pa_m = $row['p_m'];
				$con_sts = $row['con_sts'];
				
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
				
				if($dew < 0.01){
					$dews = 0;
					$advs = abs($dew);
				}else{
					$dews = $dew;
					$advs = 0;
				}
				
				$total_payable = $balance + $dew;
				
			if($total_payable <= 0.01){
					
			}else{
				
				$pdf->SetFillColor(255, 255, 255);
				$pdf->SetTextColor(0,0,0);
				$pdf->SetFont('Helvetica','',8);
				$pdf->SetX(3, 5);
				
				$pdf->Cell(8,5,$x,'LTB',0,'C',true);
				$pdf->Cell(12,5,$com_id,'LTB',0,'C',true);
				$pdf->Cell(38,5,$c_id,'LTB',0,'L',true);
				$pdf->Cell(40,5,$c_name,'LTB',0,'L',true);
				$pdf->Cell(43,5,$z_name,'LTB',0,'L',true);
				$pdf->Cell(23,5,$cell,'LTB',0,'L',true);
				$pdf->Cell(31,5,$p_name,'LTB',0,'L',true);
				$pdf->Cell(13,5,$con_sts,'LTB',0,'C',true);
				$pdf->SetFont('Helvetica','B',9);
				$pdf->Cell(14,5,$b_date.' | '.$payment_deadline,'LTB',0,'C',true);
				$pdf->SetFont('Helvetica','',8);
				$pdf->Cell(15,5,number_format($p_price,0),'LTB',0,'R',true); 
				$pdf->Cell(13,5,number_format($dews,0),'LTB',0,'R',true);
				$pdf->Cell(13,5,number_format($bill,0),'LTB',0,'R',true);
				$pdf->Cell(13,5,number_format($pay,0),'LTB',0,'R',true);
				$pdf->SetFont('Helvetica','B',9);
				$pdf->Cell(15,5,number_format($total_payable,0),'LTBR',0,'R',true);
				$pdf->Ln();
				
			$x++;
			$ppricee += $p_price;
			$dewssss += $dews;
			$TotalPpaid += $bill;
			$TotalPpay += $pay;
			$TotalPayment += $total_payable;
			}
			
		}
		$pdf->SetX(3);
			$pdf->SetFillColor(160, 160, 160);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetFont('Helvetica','B',9);
			
			$pdf->Cell(222,5,'Total','LTB',0,'C',true);
			$pdf->Cell(15,5,number_format($ppricee,0),'TB',0,'R',true);
			$pdf->Cell(13,5,number_format($dewssss,0),'LTB',0,'R',true);
			$pdf->Cell(13,5,number_format($TotalPpaid,0),'LTB',0,'R',true);
			$pdf->Cell(13,5,number_format($TotalPpay,0),'LTB',0,'R',true);
			$pdf->Cell(15,5,number_format($TotalPayment,0),'LTBR',0,'R',true);
			$pdf->Ln();
$pdf->Output();
?>