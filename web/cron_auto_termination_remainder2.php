<?php
include("conn/connection.php");
include('company_info.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');

$deadl = date('d',strtotime("+1 days"));
$update_date = date('Y-m', time()).'-'.$deadl;

			$sql = mysql_query("SELECT c.c_id, c.c_name, c.cell, DATE_FORMAT(c.termination_date, '%D %M %Y') AS termination_date, c.z_id, e.e_name AS empname, e.e_id AS resellerid, IFNULL(e.auto_recharge, 0) AS auto_recharge, e.minimum_day, c.p_id, p.p_price, c.mac_user, e.e_cont_per, c.mk_id, c.mac_user FROM clients AS c
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								LEFT JOIN emp_info AS e ON e.e_id = z.e_id
								LEFT JOIN package AS p ON p.p_id = c.p_id
								WHERE c.con_sts = 'Active' AND c.termination_date = '$update_date' AND c.termination_date != '0000-00-00' AND c.mac_user = '1' AND c.sts = '0'");
								
	while( $row = mysql_fetch_assoc($sql) ){
	
	$mkk_id = $row['mk_id'];
	$c_idd = $row['c_id'];
	$mac_user = $row['mac_user'];
	$z_id = $row['z_id'];
	$c_name = $row['c_name'];
	$cell = $row['cell'];
	$auto_recharge = $row['auto_recharge'];
	$minimum_day = $row['minimum_day'];
	$p_id = $row['p_id'];
	$p_price = $row['p_price'];
	$termination_daterr = date('jS F, Y', strtotime($row['termination_date']));
	$send_by = $row['resellerid'];
	
		$query88h = mysql_query("SELECT s.id, s.link, s.username, s.password, s.status, e.e_name AS reseller_fullnamee, e.e_cont_per AS reseller_celll FROM sms_setup AS s LEFT JOIN emp_info AS e ON e.z_id = s.z_id WHERE s.status = '0' AND s.z_id = '$z_id'");
		$row88a = mysql_fetch_assoc($query88h);
		$link= $row88a['link'];
		$username= $row88a['username'];
		$password= $row88a['password'];
		$status= $row88a['status'];
		$reseller_fullnamee= $row88a['reseller_fullnamee'];
		$reseller_celll= $row88a['reseller_celll'];
		
	if($username != ''){
		$sqlsdf = mysql_query("SELECT sms_msg, from_page, send_sts FROM sms_msg WHERE z_id= '$z_id' AND from_page = '1st Remainder'");
		$rowsm = mysql_fetch_assoc($sqlsdf);
		$sms_msg= $rowsm['sms_msg'];
		$from_page= $rowsm['from_page'];
		$send_sts= $rowsm['send_sts'];
	}
	else{
		$send_sts= '1';
	}
	
	
if($send_sts == '0'){
	$replacements = array(
	'c_id' => $c_idd,
	'c_name' => $c_name,
	'termination_date' => $termination_daterr,
	'package_price' => $p_price,
	'reseller_name' => $reseller_fullnamee,
	'reseller_cell' => $reseller_celll,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
	
$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}
}
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

echo 'Remainder-2: Done<br>';
?>

