<?php
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

$send_date = date("Y-m-d");
$send_time = date("h:i a");
$month = date("M", time()); 

	if($userr_typ == 'mreseller'){
		$sqlaaa = "SELECT t.c_id, c.c_name, c.com_id, c.cell, c.z_id, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS paybleamount, c.payment_deadline, c.termination_date, c.mk_id FROM
							(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing_mac_client AS b GROUP BY b.c_id)t
							LEFT JOIN
							(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment_mac_client AS p GROUP BY p.c_id)l
							ON t.c_id = l.c_id
							LEFT JOIN clients AS c
							ON c.c_id = t.c_id
							WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.mac_user = '1' AND c.z_id = '$z_id' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.mac_user = '1' AND c.cell REGEXP '^-?[0-9]+$'";
		if($box_id != 'all'){
		$sqlaaa .= " AND c.box_id = '$box_id'";
		}
		if($con_sts != 'all'){
			$sqlaaa .= " AND c.con_sts = '$con_sts'";
		}
	}
	else{
		$sqlaaa = "SELECT t.c_id, c.c_name, c.com_id, c.cell, c.z_id, (t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00)) AS paybleamount, c.payment_deadline, c.termination_date, c.mk_id FROM
						(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
						LEFT JOIN
						(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
						ON t.c_id = l.c_id
						LEFT JOIN clients AS c
						ON c.c_id = t.c_id
						WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.mac_user = '0' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.cell REGEXP '^-?[0-9]+$'";
		if($z_id != 'all'){
			$sqlaaa .= " AND c.z_id = '$z_id'";
		}
		if($con_sts != 'all'){
			$sqlaaa .= " AND c.con_sts = '$con_sts'";
		}
	}
	
	$sqlsdftry = mysql_query($sqlaaa);
	while( $row = mysql_fetch_assoc($sqlsdftry) ){

	$c_idd = $row['c_id'];
	$com_id = $row['com_id'];
	$c_name = $row['c_name'];
	$cell = $row['cell'];
	$paybleamount = $row['paybleamount'];
	$payment_deadline = $row['payment_deadline'];
	$termination_datess = $row['termination_date'];
	$termination_daterr = date('jS F, Y', strtotime($termination_datess));
	
	$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_name,
	'c_deadline' => $payment_deadline,
	'termination_date' => $termination_daterr,
	'company_name' => $comp_name,
	'company_cell' => $company_cell,
	'reseller_name' => $reseller_fullnamee,
	'reseller_cell' => $reseller_celll,
	'this_month' => $month,
	'total_due' => $paybleamount
	);

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
	}
	
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}
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