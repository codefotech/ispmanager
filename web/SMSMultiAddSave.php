<?php
session_start();
extract($_POST);
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$e_id = $_SESSION['SESS_EMP_ID'];
$send_by = $enty_by;
$send_date = $entry_date;
$send_time = $entry_time;

if($way == 'Welcome'){
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

	$from_page = 'Welcome SMS';
	if($userr_typ == 'mreseller'){
		$sqlaaa = "SELECT c.c_name, c.c_id, c.com_id, c.termination_date, c.payment_deadline, l.user_id, l.pw, c.cell, c.email, c.address, c.join_date, c.opening_balance, c.con_type, c.cable_sts, c.discount, c.con_sts, c.req_cable, c.cable_type, c.nid, c.p_id, p.p_name, c.signup_fee, c.note FROM clients AS c
		LEFT JOIN login AS l ON l.user_id = c.c_id LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.mac_user = '1' AND c.z_id = '$z_id' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.cell REGEXP '^-?[0-9]+$'";
		
		if($box_id != 'all'){
			$sqlaaa .= " AND c.box_id = '$box_id'";
		}
		
		if ($p_m != 'all'){
			$sqlaaa .= " AND c.p_m = '$p_m'";
		}
		if($con_sts != 'all'){
			$sqlaaa .= " AND c.con_sts = '$con_sts'";
		}
	}
	else{
		$sqlaaa = "SELECT c.c_name, c.c_id, c.com_id, c.payment_deadline, l.user_id, l.pw, c.cell, c.email, c.address, c.join_date, c.opening_balance, c.con_type, c.cable_sts, c.discount, c.con_sts, c.req_cable, c.cable_type, c.nid, c.p_id, p.p_name, c.signup_fee, c.note FROM clients AS c
		LEFT JOIN login AS l ON l.user_id = c.c_id LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.mac_user = '0' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.cell REGEXP '^-?[0-9]+$'";
		
		if($z_id != 'all'){
			$sqlaaa .= " AND c.z_id = '$z_id'";
		}
		if ($box_id != 'all'){
			$sqlaaa .= " AND c.box_id = '$box_id'";
		}
		if ($p_m != 'all'){
			$sqlaaa .= " AND c.p_m = '$p_m'";
		}
		if($con_sts != 'all'){
			$sqlaaa .= " AND c.con_sts = '$con_sts'";
		}
	}
	
	$sqlsdftry = mysql_query($sqlaaa);
	while( $rowsdf = mysql_fetch_assoc($sqlsdftry) ){

		$c_name= $rowsdf['c_name'];
		$cell = $rowsdf['cell'];
		$c_idd = $rowsdf['c_id'];
		$com_id= $rowsdf['com_id'];
		$user_id= $rowsdf['user_id'];
		$passid= $rowsdf['pw'];
		$p_name= $rowsdf['p_name'];
		$payment_deadline= $rowsdf['payment_deadline'];
	
$replacements = array(
	'user_id' => $user_id,
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'password' => $passid,
	'package' => $p_name,
	'deadline' => $payment_deadline,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
	}
}
//** Zone Wise SMS to All Clients START **//
if($way == 'ZoneWiseSMS'){
if($userr_typ == 'mreseller'){
$sqlsdf = mysql_query("SELECT b_name FROM box WHERE box_id= '$box_id'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$z_name= $rowsm['b_name'];

$sql = "SELECT GROUP_CONCAT(cell SEPARATOR ',') AS cell, COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '1' AND z_id = '$z_id'";  							
		if ($box_id != 'all'){
			$sql .= " AND box_id = '{$box_id}'";
		}
		if ($p_m != 'all'){
			$sql .= " AND p_m = '{$p_m}'";
		}
		if ($con_sts != 'all'){
			$sql .= " AND con_sts = '{$con_sts}'";
		}
}
else{
$sqlsdf = mysql_query("SELECT z_name FROM zone WHERE z_id= '$z_id'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$z_name= $rowsm['z_name'];

$sql = "SELECT GROUP_CONCAT(cell SEPARATOR ',') AS cell, COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '0'";  							
		if ($z_id != 'all'){
			$sql .= " AND z_id = '{$z_id}'";
		}
		if ($box_id != 'all'){
			$sql .= " AND box_id = '{$box_id}'";
		}
		if ($p_m != 'all'){
			$sql .= " AND p_m = '{$p_m}'";
		}
		if ($con_sts != 'all'){
			$sql .= " AND con_sts = '{$con_sts}'";
		}
}

	
$sqlsdftrygg = mysql_query($sql);
$rowsmt = mysql_fetch_assoc($sqlsdftrygg);

$cell= $rowsmt['cell'];
$countcell= $rowsmt['countcell'];
$c_idd = 'Total Number: '.$countcell;

if($z_id == 'all' || $box_id == 'all'){
$from_page = 'All Zone';
}
else{
$from_page = '['.$z_name.'] All Clients';
}

include('include/smsapicore.php');
mysql_close($con);
}
//** Zone Wise SMS to All Clients END **//


//** Package Wise SMS to All Clients START **//
if($way == 'PackageWiseSMS'){
	
$sqlsdf = mysql_query("SELECT p_name FROM package WHERE p_id= '$p_id'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$p_name= $rowsm['p_name'];

if($userr_typ == 'mreseller'){
$sql = "SELECT GROUP_CONCAT(cell SEPARATOR ',') AS cell, COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '1' AND z_id = '$z_id'";  							
		if ($p_id != 'all'){
			$sql .= " AND p_id = '{$p_id}'";
		}
		if ($con_sts != 'all'){
			$sql .= " AND con_sts = '{$con_sts}'";
		}
}
else{
$sql = "SELECT GROUP_CONCAT(cell SEPARATOR ',') AS cell, COUNT(cell) AS countcell FROM clients WHERE sts = '0' AND cell !='0' AND cell !='88' AND cell !='' AND cell REGEXP '^-?[0-9]+$' AND mac_user = '0'";  							
		if ($p_id != 'all'){
			$sql .= " AND p_id = '{$p_id}'";
		}
		if ($con_sts != 'all'){
			$sql .= " AND con_sts = '{$con_sts}'";
		}
}
$result11 = mysql_query($sql);
$rowsmtp = mysql_fetch_assoc($result11);

$cell= $rowsmtp['cell'];
$countcell= $rowsmtp['countcell'];
$c_idd = 'Total Number: '.$countcell;

if($p_id == 'all'){
$from_page = 'All Package';
}
else{
$from_page = '['.$p_name.'] All Clients';
}

include('include/smsapicore.php');
mysql_close($con);
}
//** Package Wise SMS to All Clients END **//
?>

<html>
<body>
     <form action="SMS" method="post" name="done">
       <input type="hidden" name="sts" value="smssent">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>