<?php
require('mysql_table.php');
require('connection.php');

$z_id = $_REQUEST['z_id'];
$box_id = $_REQUEST['box_id'];
$sts = $_REQUEST['sts'];
$e_id = $_REQUEST['e_id'];
$user_type = $_REQUEST['user_type'];
$p_id = $_REQUEST['p_id'];

$p_m = $_REQUEST['p_m'];
$con_sts = $_REQUEST['con_sts'];

//$f_date = $_REQUEST['f_date'];
//$t_date = $_REQUEST['t_date'];

$df_date = $_REQUEST['df_date'];
$dt_date = $_REQUEST['dt_date'];

class PDF extends PDF_MySQL_Table
{

function Footer()
				{
					global $comp_name;
					//Position at 1.5 cm from bottom
					$this->SetY(-15);
					//Arial italic 8
					$this->SetFont('Helvetica','I',8);
					//Page number
					$this->Cell(0,10,'Page '.$this->PageNo().'/'.$comp_name,'T',0,'C');
					$this->SetDrawColor(0, 0, 0);
					parent::Footer();
				}
}

$pdf=new PDF();
$pdf->AddPage('L', 'A4');

			$sql1 = mysql_query("SELECT * FROM zone WHERE z_id = '$z_id'");
			$row1 = mysql_fetch_array($sql1);
			$z_name = $row1['z_name'];
			
			$sql2 = "SELECT c.id FROM clients AS c
					LEFT JOIN zone AS z ON z.z_id = c.z_id 
					WHERE c.sts = '0'";
				
				if ($user_type == 'billing'){
					$sql2 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
				}
				if ($z_id != 'all'){
					$sql2 .= " AND c.z_id = '{$z_id}'";
				}
				if ($box_id != 'all'){
					$sql2 .= " AND c.box_id = '{$box_id}'";
				}
				if ($p_id != 'all'){
					$sql2 .= " AND c.p_id = '{$p_id}'";
				}
				if ($p_m != 'all'){
					$sql2 .= " AND c.p_m = '{$p_m}'";
				}
				if ($con_sts != 'all'){
					$sql2 .= " AND c.con_sts = '{$con_sts}'";
				}
				if ($df_date != 'all' && $dt_date != 'all'){
					$sql2 .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$dt_date}'";
				}
				if ($df_date != 'all' && $dt_date == 'all'){
					$sql2 .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$df_date}'";
				}
				if ($df_date == 'all' && $dt_date == 'all'){
					$sql2 .= "";
				}
				if ($df_date == 'all' && $dt_date != 'all'){
					$sql2 .= " AND c.payment_deadline BETWEEN '{$dt_date}' AND '{$dt_date}'";
				}
//				$sql2 .= " AND join_date BETWEEN '$f_date' AND '$t_date'";
				
			$result1 = mysql_query($sql2);
			$total = mysql_num_rows($result1);

			
			$sql3 = "SELECT c.id FROM clients AS c
					LEFT JOIN zone AS z ON z.z_id = c.z_id 
					WHERE c.sts = '0'";
				if ($user_type == 'billing'){
					$sql3 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
				}
				if ($z_id != 'all'){
					$sql3 .= " AND c.z_id = '{$z_id}'";
				}
				if ($box_id != 'all'){
					$sql3 .= " AND c.box_id = '{$box_id}'";
				}
				if ($p_id != 'all'){
					$sql3 .= " AND c.p_id = '{$p_id}'";
				}
				if ($p_m != 'all'){
					$sql3 .= " AND c.p_m = '{$p_m}'";
				}
				if ($df_date != 'all' && $dt_date != 'all'){
					$sql3 .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$dt_date}'";
				}
				if ($df_date != 'all' && $dt_date == 'all'){
					$sql3 .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$df_date}'";
				}
				if ($df_date == 'all' && $dt_date == 'all'){
					$sql3 .= "";
				}
				if ($df_date == 'all' && $dt_date != 'all'){
					$sql3 .= " AND c.payment_deadline BETWEEN '{$dt_date}' AND '{$dt_date}'";
				}
				$sql3 .= " AND c.con_sts = 'Active'";
				
			$result2 = mysql_query($sql3);
			$active = mysql_num_rows($result2);
			
			$sql4 = "SELECT c.id FROM clients AS c
					LEFT JOIN zone AS z ON z.z_id = c.z_id 
					WHERE c.sts = '0'";
				if ($user_type == 'billing'){
					$sql4 .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
				}
				if ($z_id != 'all'){
					$sql4 .= " AND c.z_id = '{$z_id}'";
				}
				if ($box_id != 'all'){
					$sql4 .= " AND c.box_id = '{$box_id}'";
				}
				if ($p_id != 'all'){
					$sql4 .= " AND c.p_id = '{$p_id}'";
				}
				if ($p_m != 'all'){
					$sql4 .= " AND c.p_m = '{$p_m}'";
				}
				if ($df_date != 'all' && $dt_date != 'all'){
					$sql4 .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$dt_date}'";
				}
				if ($df_date != 'all' && $dt_date == 'all'){
					$sql4 .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$df_date}'";
				}
				if ($df_date == 'all' && $dt_date == 'all'){
					$sql4 .= "";
				}
				if ($df_date == 'all' && $dt_date != 'all'){
					$sql4 .= " AND c.payment_deadline BETWEEN '{$dt_date}' AND '{$dt_date}'";
				}
				$sql4 .= " AND c.con_sts = 'Inactive'";
				
			$result3 = mysql_query($sql4);
			$inactive = mysql_num_rows($result3);

			
			$pdf->SetXY(5, 5);
			$pdf->SetFont('Helvetica','B',8);
		
			$pdf->Write(0, $z_name.' [ All Clients ]');
			$pdf->SetXY(220, 5);
			$pdf->Write(0, 'Active: ');
			$pdf->Write(0, $active);
			$pdf->Write(0, '  ||  ');
			$pdf->Write(0, 'Inactive: ');
			$pdf->Write(0, $inactive);
			$pdf->Write(0, '  ||  ');
			$pdf->Write(0, 'Total: ');
			$pdf->Write(0, $total);
			
			$pdf->SetXY(30, 8);
			$pdf->AddCol('c_id',43,'Client ID','L');
			$pdf->AddCol('c_name',40,'Name','L');
			$pdf->AddCol('z_name',45,'Zone','L');
			$pdf->AddCol('address',69,'Address','L');
			$pdf->AddCol('bandwith',15,'Bandwith','L');
			$pdf->AddCol('p_price',15,'Rate','R');
			$pdf->AddCol('p_m',15,'P.M','L');
			$pdf->AddCol('cell',20,'Cell No','L');
			$pdf->AddCol('payment_deadline',7,'PD','C');
			$pdf->AddCol('b_date',7,'BD','C');
			$pdf->AddCol('con_sts',13,'Status','L');


			$prop=array('HeaderColor'=>array(160, 160, 160),
						'padding'=>1);
						
			$sql = "SELECT c.c_id, c.c_name, z.z_name, c.p_m, c.cell, c.email, c.address, c.payment_deadline, c.b_date, p.bandwith, p.p_price, IF(l.log_sts = '0', 'UNLOCKED', IF(l.log_sts = '1', 'LOCKED', l.log_sts)) AS sts, c.con_sts FROM clients AS c
							LEFT JOIN package AS p
							ON p.p_id = c.p_id
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN login AS l
							ON l.e_id = c.c_id
							WHERE c.sts = '0'";  	
		if ($user_type == 'billing'){
			$sql .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
		}							
		if ($z_id != 'all'){
			$sql .= " AND c.z_id = '{$z_id}'";
		}
		if ($box_id != 'all'){
			$sql .= " AND c.box_id = '{$box_id}'";
		}
		if ($p_id != 'all'){
			$sql .= " AND c.p_id = '{$p_id}'";
		}
		if ($p_m != 'all'){
			$sql .= " AND c.p_m = '{$p_m}'";
		}
		if ($con_sts != 'all'){
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
		$sql .= " ORDER BY c.address DESC";
		
//		$result = mysql_query($sql);			
			
		
			$pdf->Table($sql,$prop);
		

$pdf->Output();
?>