<?php
include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$now_timee = date('H:i', time());
$date_timee = date('Y-m-d H:i:s', time());

$resultset=mysql_query("SELECT weblink FROM app_config");
$rowset=mysql_fetch_array($resultset);
$weblink=$rowset['weblink'];


$sqlsdfq = mysql_query("SELECT time_hr, time_min FROM sms_msg WHERE id= '2' AND sts = '0'");
$rowsmq = mysql_fetch_assoc($sqlsdfq);
$auto_inactive_time = $rowsmq['time_hr'].':'.$rowsmq['time_min'];
if($auto_inactive_time == $now_timee){
$job_linkk = $weblink.'cron_auto_inactive.php';
	
		$ch1 = curl_init();
		curl_setopt($ch1, CURLOPT_URL,$job_linkk); 
		curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1); // return into a variable 
		curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($ch1, CURLOPT_TIMEOUT, 100000); 
		$result1 = curl_exec($ch1); 
		curl_close($ch1);
}

$sqls1std = mysql_query("SELECT time_hr, time_min FROM sms_msg WHERE id = '12' AND send_sts = '0'");
$rows1st = mysql_fetch_assoc($sqls1std);
$auto_remainding_time = $rows1st['time_hr'].':'.$rows1st['time_min'];
if($auto_remainding_time == $now_timee){
$job_linkkk = $weblink.'cron_auto_termination_remainder1.php';
	
		$ch11 = curl_init();
		curl_setopt($ch11, CURLOPT_URL,$job_linkkk); 
		curl_setopt($ch11, CURLOPT_RETURNTRANSFER,1); // return into a variable 
		curl_setopt($ch11, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($ch11, CURLOPT_TIMEOUT, 100000); 
		$result1d = curl_exec($ch11); 
		curl_close($ch11);
}

$sqls1stdd = mysql_query("SELECT time_hr, time_min FROM sms_msg WHERE id= '13' AND send_sts = '0'");
$rows1std = mysql_fetch_assoc($sqls1stdd);
$auto_remainding_time2 = $rows1std['time_hr'].':'.$rows1std['time_min'];
if($auto_remainding_time2 == $now_timee){
$job_linkkk2 = $weblink.'cron_auto_termination_remainder2.php';
	
		$ch112 = curl_init();
		curl_setopt($ch112, CURLOPT_URL,$job_linkkk2); 
		curl_setopt($ch112, CURLOPT_RETURNTRANSFER,1); // return into a variable 
		curl_setopt($ch112, CURLOPT_CONNECTTIMEOUT, 0); 
		curl_setopt($ch112, CURLOPT_TIMEOUT, 100000); 
		$result1d2 = curl_exec($ch112); 
		curl_close($ch112);
}
?>

