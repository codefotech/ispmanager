<?php
require('mysql_table.php');
require('connection.php');

$con_sts = $_REQUEST['con_sts'];
$inactive_type = $_REQUEST['inactive_type'];
$f_date = $_REQUEST['f_date'];
$t_date = $_REQUEST['t_date'];

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
					$this->SetDrawColor(8, 102, 198);
					parent::Footer();
				}
}

$pdf=new PDF();
$pdf->AddPage();
if($inactive_type == 'all'){
			$sql2 = mysql_query("SELECT s.c_id, c.c_id, c.c_name, z.z_name, c.cell, c.address, c.join_date, p.p_name, p.bandwith, s.update_date_time FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' GROUP BY s.c_id ORDER BY s.c_id DESC");
			$total = mysql_num_rows($sql2);
			
			$pdf->SetXY(5, 5);
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Write(0, 'Date: ');
			$pdf->Write(0, $f_date);
			$pdf->Write(0, ' To ');
			$pdf->Write(0, $t_date);
			$pdf->Write(0, ' [ All Zone ]');
			$pdf->SetXY(185, 5);
			$pdf->Write(0, 'Total: ');
			$pdf->Write(0, $total);
			
			$pdf->SetXY(30, 8);
			$pdf->AddCol('update_date_time',25,'Inactive Date','c');
			$pdf->AddCol('c_id',32,'Clint ID','L');
			$pdf->AddCol('c_name',30,'Clint Name','L');
			$pdf->AddCol('address',55,'Address','L');
			$pdf->AddCol('cell',20,'Cell','L');
			$pdf->AddCol('p_name',25,'Package','L');
			$pdf->AddCol('bandwith',15,'bandwith','L');


			$prop=array('HeaderColor'=>array(160, 160, 160),
						'padding'=>1);
						
			$pdf->Table("SELECT s.c_id, c.c_id, c.c_name, z.z_name, c.cell, c.address, c.join_date, p.p_name, p.bandwith, s.update_date_time FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' GROUP BY s.c_id ORDER BY s.update_date DESC",$prop);
}
if($inactive_type == 'auto'){
			$sql2 = mysql_query("SELECT s.c_id FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' AND s.update_by = 'Auto' GROUP BY s.c_id");
			$total = mysql_num_rows($sql2);
			
			$pdf->SetXY(5, 5);
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Write(0, 'Date: ');
			$pdf->Write(0, $f_date);
			$pdf->Write(0, ' To ');
			$pdf->Write(0, $t_date);
			$pdf->Write(0, ' [ All Zone ]');
			$pdf->SetXY(185, 5);
			$pdf->Write(0, 'Total: ');
			$pdf->Write(0, $total);
			
			$pdf->SetXY(30, 8);
			$pdf->AddCol('update_date_time',25,'Inactive Date','c');
			$pdf->AddCol('c_id',32,'Clint ID','L');
			$pdf->AddCol('c_name',30,'Clint Name','L');
			$pdf->AddCol('address',55,'Address','L');
			$pdf->AddCol('cell',20,'Cell','L');
			$pdf->AddCol('p_name',25,'Package','L');
			$pdf->AddCol('bandwith',15,'bandwith','L');


			$prop=array('HeaderColor'=>array(160, 160, 160),
						'padding'=>1);
						
			$pdf->Table("SELECT s.c_id, c.c_id, c.c_name, z.z_name, c.cell, c.address, c.join_date, p.p_name, p.bandwith, s.update_date_time FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' AND s.update_by = 'Auto' GROUP BY s.c_id ORDER BY s.update_date DESC",$prop);
}
if($inactive_type == 'notauto'){
			$sql2 = mysql_query("SELECT s.c_id FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' AND s.update_by != 'Auto' GROUP BY s.c_id");
			$total = mysql_num_rows($sql2);
			
			$pdf->SetXY(5, 5);
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Write(0, 'Date: ');
			$pdf->Write(0, $f_date);
			$pdf->Write(0, ' To ');
			$pdf->Write(0, $t_date);
			$pdf->Write(0, ' [ All Zone ]');
			$pdf->SetXY(185, 5);
			$pdf->Write(0, 'Total: ');
			$pdf->Write(0, $total);
			
			$pdf->SetXY(30, 8);
			$pdf->AddCol('update_date_time',25,'Inactive Date','c');
			$pdf->AddCol('c_id',32,'Clint ID','L');
			$pdf->AddCol('c_name',30,'Clint Name','L');
			$pdf->AddCol('address',55,'Address','L');
			$pdf->AddCol('cell',20,'Cell','L');
			$pdf->AddCol('p_name',25,'Package','L');
			$pdf->AddCol('bandwith',15,'bandwith','L');


			$prop=array('HeaderColor'=>array(160, 160, 160),
						'padding'=>1);
						
			$pdf->Table("SELECT s.c_id, c.c_id, c.c_name, z.z_name, c.cell, c.address, c.join_date, p.p_name, p.bandwith, s.update_date_time FROM con_sts_log AS s
							LEFT JOIN clients AS c ON c.c_id = s.c_id
							LEFT JOIN zone AS z	ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							WHERE s.update_date BETWEEN '$f_date' AND '$t_date' AND s.con_sts = '$con_sts' AND c.con_sts = '$con_sts' AND c.mac_user = '0' AND s.update_by != 'Auto' GROUP BY s.c_id ORDER BY s.update_date DESC",$prop);
}
$pdf->Output();
?>