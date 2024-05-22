<?php
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);
date_default_timezone_set('Etc/GMT-6');
$dateTime = date('Y-m-01', time());

	if($userr_typ == 'mreseller'){
		$sql = "SELECT t.c_id, GROUP_CONCAT(c.cell SEPARATOR ',') AS cell, COUNT(cell) AS countcell FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing_mac_client AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment_mac_client AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								LEFT JOIN (SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment_mac_client AS p WHERE MONTH(p.pay_date) = MONTH('$dateTime') AND YEAR(p.pay_date) = YEAR('$dateTime') GROUP BY p.c_id)p ON p.c_id = t.c_id
								WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.mac_user = '1' AND c.cell REGEXP '^-?[0-9]+$'";  
		if($partial != 'all'){
			if($partial != '1') {
				$sql .= " AND p.totalpaymentamount is null";
			}
			else{
				$sql .= " AND p.totalpaymentamount != '0.00'";
			}
		}
		if ($z_id != 'all'){
			$sql .= " AND c.z_id = '{$z_id}'";
		}
		if ($box_id != 'all'){
			$sql .= " AND c.box_id = '{$box_id}'";
		}
		if ($p_m != 'all'){
			$sql .= " AND c.p_m = '{$p_m}'";
		}
		if ($con_sts != 'all'){
			$sql .= " AND c.con_sts = '{$con_sts}'";
		}
	}
	else{
		$sql = "SELECT t.c_id, GROUP_CONCAT(c.cell SEPARATOR ',') AS cell, COUNT(cell) AS countcell FROM
								(SELECT b.c_id, SUM(b.bill_amount) AS totalbillamount FROM billing AS b GROUP BY b.c_id)t
								LEFT JOIN
								(SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p GROUP BY p.c_id)l
								ON t.c_id = l.c_id
								LEFT JOIN clients AS c
								ON c.c_id = t.c_id
								LEFT JOIN (SELECT p.c_id, (SUM(p.pay_amount)+SUM(p.bill_discount)) AS totalpaymentamount FROM payment AS p WHERE MONTH(p.pay_date) = MONTH('$dateTime') AND YEAR(p.pay_date) = YEAR('$dateTime') GROUP BY p.c_id)p ON p.c_id = t.c_id
								WHERE c.sts = '0' AND t.totalbillamount - IFNULL(l.totalpaymentamount, 0.00) >= '1' AND c.cell !='0' AND c.cell !='88' AND c.cell !='' AND c.mac_user = '0' AND c.cell REGEXP '^-?[0-9]+$'";  
		if($partial != 'all'){
			if($partial != '1') {
				$sql .= " AND p.totalpaymentamount is null";
			}
			else{
				$sql .= " AND p.totalpaymentamount != '0.00'";
			}
		}
		if ($df_date != 'all' && $dt_date != 'all'){
			$sql .= " AND c.payment_deadline BETWEEN '{$df_date}' AND '{$dt_date}'";
		}
		if ($df_date != 'all' && $dt_date == 'all'){
			$sql .= " AND c.payment_deadline = '{$df_date}'";
		}
		if ($df_date == 'all' && $dt_date != 'all'){
			$sql .= " AND c.payment_deadline BETWEEN '{$dt_date}' AND '{$dt_date}'";
		}
		if ($z_id != 'all'){
			$sql .= " AND c.z_id = '{$z_id}'";
		}
		if ($p_m != 'all'){
			$sql .= " AND c.p_m = '{$p_m}'";
		}
		if ($con_sts != 'all'){
			$sql .= " AND c.con_sts = '{$con_sts}'";
		}
	}
		
$resultyy = mysql_query($sql);
$row = mysql_fetch_assoc($resultyy);

if($z_id == 'all'){
$from_page = 'All Zone';
}
else{
$sqlsdf = mysql_query("SELECT z_name FROM zone WHERE z_id= '$z_id'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$z_name = $rowsm['z_name'];

$from_page = '['.$z_name.'] All Clients';
}

$cell = $row['cell'];
$countcell= $row['countcell'];
$c_idd = 'Total Number: '.$countcell;

include('include/smsapicore.php');
mysql_close($con);
?>

<html>
<body>
     <form action="SMS" method="post" name="done">
       <input type="text" name="sts" value="smssent">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>