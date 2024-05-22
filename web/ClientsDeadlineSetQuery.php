<?php
session_start();
$e_id = $_SESSION['SESS_EMP_ID'];
$user_type = $_SESSION['SESS_USER_TYPE'];

include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());

$query2oo = mysql_query("SELECT log_id FROM deadline_log ORDER BY id DESC LIMIT 1");
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['log_id'];
$new_log_id = $idzff + 1;

extract($_POST);
if($user_type == 'admin' || $user_type == 'superadmin'){
	$sqlssw = "SELECT t1.id, t1.com_id, t1.c_id, t1.c_name, t1.cell, t1.p_name, t1.address, t1.p_price, t1.bandwith, t1.con_sts, t1.z_name, t1.payment_deadline, t1.b_date, (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) AS dueamount FROM
												(
												SELECT c.id, c.com_id, c.address, c.c_id, c.c_name, c.cell, p.p_name, p.p_price, p.bandwith, z.z_name, c.payment_deadline, c.b_date, c.con_sts FROM clients AS c 
												LEFT JOIN zone AS z ON z.z_id = c.z_id
												LEFT JOIN package AS p ON p.p_id = c.p_id
												WHERE c.mac_user = '0' AND c.sts = '0' AND c.breseller != '2'";  							
									if ($z_id != 'all') {
										$sqlssw .= " AND c.z_id = '$z_id'";
									}
									if ($p_id != 'all') {
										$sqlssw .= " AND c.p_id = '$p_id'";
									}
									if ($old_con_sts != 'all') {
										$sqlssw .= " AND c.con_sts = '$old_con_sts'";
									}
									if ($old_payment_deadline != 'all'){
										$sqlssw .= " AND c.payment_deadline = '$old_payment_deadline'";
									}
									else{
										$sqlssw .= " AND c.payment_deadline = ''";
									}
									if ($old_b_date != 'all'){
										$sqlssw .= " AND c.b_date = '$old_b_date'";
									}
									else{
										$sqlssw .= " AND c.b_date = ''";
									}
										$sqlssw .= ")t1
												LEFT JOIN
												(
												SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
												GROUP BY b.c_id
												)t2
												ON t1.c_id = t2.c_id
												LEFT JOIN
												(
												SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 											
												GROUP BY p.c_id
												)t3
												ON t1.c_id = t3.c_id"; 
									if ($only_due != 'no'){
										$sqlssw .= " WHERE (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
									}
$sqlddry = mysql_query($sqlssw);
while( $row = mysql_fetch_assoc($sqlddry) )
{
	$clientid = $row['c_id'];
	$con_sts = $row['con_sts'];
	$due_amount = $row['dueamount'];
	$payment_deadline = $row['payment_deadline'];
	$b_date = $row['b_date'];
	
	if($new_payment_deadline == 'no_change'){
		$new_paymentdeadline = $row['payment_deadline'];
	}
	else{
		$new_paymentdeadline = $new_payment_deadline;
	}
	
	if($new_b_date == 'no_change'){
		$new_bdate = $row['b_date'];
	}
	else{
		$new_bdate = $new_b_date;
	}
	
	$query1q ="INSERT INTO deadline_log (c_id, con_sts, update_date, update_time, update_by, due_amount, old_payment_deadline, new_payment_deadline, old_b_date, new_b_date, log_id) VALUES ('$clientid', '$con_sts', '$update_date', '$update_time', '$e_id', '$dueamount', '$payment_deadline', '$new_paymentdeadline', '$b_date', '$new_bdate', '$new_log_id')";
		if (!mysql_query($query1q)){die('Error: ' . mysql_error());}
		else{
			$queryww=mysql_query("UPDATE clients SET payment_deadline = '$new_paymentdeadline', b_date = '$new_bdate' WHERE c_id = '$clientid'");
		}
}
?>

<html>
<body>
     <form action="ClientsDeadlineSet?log_id=<?php echo $new_log_id;?>" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php } ?>