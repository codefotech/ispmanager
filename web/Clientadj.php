<?php
$titel = "Re-connect";
$Client = 'active';
include("conn/connection.php");
$c_id = $_GET['id'];

$ques = mysql_query("SELECT c.c_id, c.z_id, c.p_id, p.p_price, c.termination_date FROM clients AS c
LEFT JOIN package AS p ON p.p_id = c.p_id
WHERE c.c_id = '$c_id'");
$roww = mysql_fetch_assoc($ques);
$c_id = $roww['c_id'];
$z_id = $roww['z_id'];
$p_id = $roww['p_id'];
$p_price = $roww['p_price'];
$termination_date = $roww['termination_date'];

ini_alter('date.timezone','Asia/Almaty');
$todayyyy = date('Y-m-d', time());
$todayyyy_time = date('H:i:s', time());

$diff = abs(strtotime($termination_date) - strtotime($todayyyy))/86400;

$packageoneday = $p_price/30;
$daycost = $diff*$packageoneday;

$query2bb = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time) VALUES 
									('$c_id', '$z_id', '$p_id', '$todayyyy', '$todayyyy_time', '$termination_date', '$diff', '$p_price', '$daycost', '$entry_by', '$todayyyy', '$todayyyy_time')";
							if (!mysql_query($query2bb))
							{
							die('Error: ' . mysql_error());
							}
echo '<script type="text/javascript">window.close()</script>';

?>