<?php
include("conn/connection.php") ;
include('company_info.php');
include('include/smsapi.php');
extract($_POST);
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');
$pay_date_time = date('Y-m-d H:i:s', time());

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$c_idd = $c_id;

if($way == 'signup'){
$query = "insert into bill_signup (c_id, bank, bill_type, amount, pay_date, pay_date_time, bill_dsc, ent_by) VALUES ('$c_id', '$bank', '$bill_type', '$amount', '$pay_date', '$pay_date_time', '$bill_dsc', '$send_by')";
$sql = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");	
//start
if($sentsms=='Yes'){
$sqlsdf = mysql_query("SELECT sms_msg FROM sms_msg WHERE id= '6'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];

$sql330 = ("SELECT b.id, b.c_id, c.c_name, c.cell, q.type, b.amount, e.e_name FROM bill_signup AS b LEFT JOIN clients AS c ON c.c_id = b.c_id LEFT JOIN bills_type AS q ON q.bill_type = b.bill_type LEFT JOIN emp_info AS e ON e.e_id = b.ent_by WHERE b.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
					
			$query330 = mysql_query($sql330);
			$row330 = mysql_fetch_assoc($query330);
			$c_name= $row330['c_name'];
			$cell= $row330['cell'];
			$amount= $row330['amount'];
			$type= $row330['type'];
			
$replacements = array(
	'c_id' => $c_id,
	'c_name' => $c_name,
	'PaymentAmount' => $amount,
	'BillType' => $type,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
	
$from_page = 'Others Bill';

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}
}


if($way == 'extra'){
$query = "insert into bill_extra (be_name, cell, bank, bill_type, amount, pay_date, pay_date_time, bill_dsc, ent_by) VALUES ('$be_name', '$cell', '$bank', '$bill_type', '$amount', '$pay_date', '$pay_date_time', '$bill_dsc', '$send_by')";$sql = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");	
//start
if($sentsms=='Yes'){
	
$sqlsdfex = mysql_query("SELECT sms_msg FROM sms_msg WHERE id= '7'");
$rowsmex = mysql_fetch_assoc($sqlsdfex);
$sms_msg= $rowsmex['sms_msg'];
	
$sql330 = ("SELECT bill_type, type, bill_type_disc FROM bills_type WHERE bill_type = '$bill_type'");
					
			$query330 = mysql_query($sql330);
			$row330 = mysql_fetch_assoc($query330);
			$bill_type= $row330['bill_type'];
			$type= $row330['type'];
			$bill_type_disc= $row330['bill_type_disc'];

$replacements = array(
	'Name' => $be_name,
	'PaymentAmount' => $amount,
	'BillType' => $type,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
			
$from_page = 'Extra Income';

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}
}

if($way == 'billtype'){
$query = "insert into bills_type (type, bill_type_disc) VALUES ('$type', '$bill_type_disc')";

$sql = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");	

}
//end	


	if ($sql)
	{
		header("location: SignupBill");
	}
else
	{
		echo 'Error, Please try again';
	}
mysql_close($con);

?>
