<?php
include("conn/connection.php");
include("company_info.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

$c_idd = $c_id;

if($smsway == 'write'){
$from_page = 'Client SMS';
include('include/smsapicore.php');
}
else{
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}
	
if($smsway == 'welcome'){
$sqler = ("SELECT c.c_name, c.com_id, c.payment_deadline, l.user_id, l.pw, c.cell, c.email, c.address, c.join_date, c.opening_balance, c.con_type, c.cable_sts, c.discount, c.con_sts, c.req_cable, c.cable_type, c.nid, c.p_id, p.p_name, c.signup_fee, c.note FROM clients AS c
		LEFT JOIN login AS l ON l.user_id = c.c_id LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c_id ='$c_idd'");
		
$querydfg = mysql_query($sqler);
$rowsdf = mysql_fetch_assoc($querydfg);
		$c_name= $rowsdf['c_name'];
		$com_id= $rowsdf['com_id'];
		$user_id= $rowsdf['user_id'];
		$passid= $rowsdf['pw'];
		$p_name= $rowsdf['p_name'];
		$payment_deadline= $rowsdf['payment_deadline'];
		
$sqlsdf = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE id= '1'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];

$replacements = array(
	'user_id' => $user_id,
	'c_id' => $user_id,
	'com_id' => $com_id,
	'password' => $passid,
	'package' => $p_name,
	'deadline' => $payment_deadline,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
}

elseif($smsway == 'duebill'){
$month = date("M", time()); 
$sqlsrg = mysql_query("SELECT t.c_id, c.c_name, c.com_id, c.cell, c.z_id, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS paybleamount, c.payment_deadline, c.mk_id FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								WHERE t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.mac_user = '0' AND c.c_id = '$c_idd'");
$rosdf = mysql_fetch_assoc($sqlsrg);
	$c_idd = $rosdf['c_id'];
	$com_id = $rosdf['com_id'];
	$c_name = $rosdf['c_name'];
	$paybleamount = $rosdf['paybleamount'];
	$payment_deadline = $rosdf['payment_deadline'];

$sqlsdf = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE id= '4'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];

	$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_name,
	'c_deadline' => $payment_deadline,
	'company_name' => $comp_name,
	'company_cell' => $company_cell,
	'this_month' => $month,
	'total_due' => $paybleamount
	);
}

elseif($smsway == '1remainder'){
$this_month = date("M", time()); 
$sqlgh = mysql_query("SELECT t.c_id, c.c_name, c.com_id, c.cell, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS totdueclients, c.payment_deadline, c.mk_id FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
WHERE t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.payment_deadline != '' AND c.mac_user = '0' AND c.c_id = '$c_idd'");

$rosdaaf = mysql_fetch_assoc($sqlgh);
	$c_idd = $rosdaaf['c_id'];
	$com_id = $rosdaaf['com_id'];
	$c_name = $rosdaaf['c_name'];
	$payment_deadline = $rosdaaf['payment_deadline'];
	$totdueclients = $rosdaaf['totdueclients'];


$sqlsdf = mysql_query("SELECT sms_msg, from_page, send_sts, day FROM sms_msg WHERE id= '12'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];

	$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_name,
	'c_deadline' => $payment_deadline,
	'this_month' => $this_month,
	'TotalDue' => $totdueclients,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
}

elseif($smsway == '2remainder'){
$this_month = date("M", time()); 
$sqlgh = mysql_query("SELECT t.c_id, c.c_name, c.com_id, c.cell, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS totdueclients, c.payment_deadline, c.mk_id FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
WHERE t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.payment_deadline != '' AND c.mac_user = '0' AND c.c_id = '$c_idd'");

$rosdaaf = mysql_fetch_assoc($sqlgh);
	$c_idd = $rosdaaf['c_id'];
	$com_id = $rosdaaf['com_id'];
	$c_name = $rosdaaf['c_name'];
	$payment_deadline = $rosdaaf['payment_deadline'];
	$totdueclients = $rosdaaf['totdueclients'];


$sqlsdf = mysql_query("SELECT sms_msg, from_page, send_sts, day FROM sms_msg WHERE id= '13'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];

	$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_name,
	'c_deadline' => $payment_deadline,
	'this_month' => $this_month,
	'TotalDue' => $totdueclients,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);
}

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}
?>

<html>
<body>
     <form action="ClientView?id=<?php echo $c_idd;?>" method="post" name="done">
       <input type="hidden" name="sts" value="smssent">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
