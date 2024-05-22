<?php
session_start();
include("conn/connection.php") ;
include('include/smsapi.php');
extract($_POST);

$entry_by = $_SESSION['SESS_EMP_ID'];

date_default_timezone_set('Etc/GMT-6');
$send_date = date('Y-m-d', time());
$send_time = date('H:i:s', time());
$close_date_time = date('Y-m-d G:i:s', time());

$sqlsdf = mysql_query("SELECT sms_msg FROM sms_msg WHERE id= '9'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

if($stss == 'Assign'){
	$query="UPDATE complain_master SET assign = '$assign', assign_by = '$assign_by' WHERE ticket_no = '$ticket_no'";
	$sql = mysql_query($query);	
	if ($sql)
		{
			


//SMS Start....
			$sql330 = ("SELECT c.id, c.ticket_no, c.c_id, z.c_name, j.z_name, z.cell, z.address, d.dept_name, c.sub, c.massage, e.e_name AS assignby, q.e_name AS assignperson, c.assign, q.e_cont_per, q.e_cont_office FROM complain_master AS c
							LEFT JOIN department_info AS d
							ON d.dept_id = c.dept_id
							LEFT JOIN clients AS z
							ON z.c_id = c.c_id 
							LEFT JOIN zone AS j
							ON j.z_id = z.z_id
							LEFT JOIN emp_info AS e
							ON e.e_id = c.assign_by
							LEFT JOIN emp_info AS q
							ON q.e_id = c.assign
							WHERE c.ticket_no = '$ticket_no'");
					
			$query330 = mysql_query($sql330);
			$row330 = mysql_fetch_assoc($query330);
			$c_idd= $row330['c_id'];
			$ticket_no= $row330['ticket_no'];
			$e_idd= $row330['assign'];
			$dept_namee= $row330['dept_name'];
			$subb= $row330['sub'];
			$celll= $row330['cell'];
			$cell = $row330['e_cont_per'];
			$e_cont_office = $row330['e_cont_office'];
			$addresss = $row330['address'];
			$c_namee= $row330['c_name'];
			$assignpersonn= $row330['assignperson'];
			$assignbyy= $row330['assignby'];
			$zname= $row330['z_name'];
			$massa= $row330['massage'];
			
$replacements = array(
	'c_id' => $c_idd,
	'c_name' => $c_namee,
	'ClientCellNo' => $celll,
	'ClientAddresss' => $addresss,
	'EmployeeName' => $assignpersonn,
	'TicketNo' => $ticket_no,
	'DepartmentTo' => $dept_namee,
	'SupportSubject' => $subb,
	'SupportMassage' => $massa,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$from_page = 'Assign for Support';

$sms_body = bind_to_template($replacements, $sms_msg);
$send_by = $assign_by;
include('include/smsapicore.php');

//end
			if($way == 'client'){
			header("location: SupportMassage$back");
			}
			if($way == 'internal'){
			header("location: SupportMassageInternal$back");
			}
		}
	else
		{
			echo 'Error, Please try again';
		}

mysql_close($con);
}

if($stss == 'closs'){
	$query="UPDATE complain_master SET ticket_sts = '$ticket_sts' WHERE ticket_no = '$ticket_no'";
	$sql = mysql_query($query);	
	if ($sql)
		{
			if($way == 'client'){
			header("location: SupportMassage$back");
			}
			if($way == 'internal'){
			header("location: SupportMassageInternal$back");
			}
		}
	else
		{
			echo 'Error, Please try again';
		}

mysql_close($con);
}

if($stss == 'end'){
	$query="UPDATE complain_master SET sts = '1', close_date_time = '$close_date_time', close_by = '$close_by' WHERE ticket_no = '$ticket_no'";
	$sql = mysql_query($query);	
	if ($sql)
		{
			if($way == 'client'){
			header("location: Support");
			}
			if($way == 'internal'){
			header("location: SupportMassageInternal$back");
			}
		}
	else
		{
			echo 'Error, Please try again';
		}

mysql_close($con);
}
?>