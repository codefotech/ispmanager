<?php 
session_start();
$clientid=$_POST['c_id'];
$slno=$_POST['slno'];
$old_duration=$_POST['old_duration'];

include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$todayy = date('Y-m-d', time());

$quesww = mysql_query("SELECT b.id, b.c_id, b.z_id, c.termination_date, b.days, b.start_date, b.start_time, b.end_date, p.p_price FROM billing_mac AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$clientid' ORDER BY b.id DESC LIMIT 1");
$rowwww = mysql_fetch_assoc($quesww);
$idq = $rowwww['id'];
$z_id = $rowwww['z_id'];
$start_date = $rowwww['start_date'];
$start_time = $rowwww['start_time'];
$enddate = $rowwww['end_date'];
$p_price = $rowwww['p_price'];
$termination_date = $rowwww['termination_date'];
$yrdata1= strtotime($termination_date);
$enddatefff = date('d-M, y', $yrdata1);

if($enddate < $todayy){
	$aaaa = $todayy;
}
else{
	$aaaa = $enddate;
}


$durations = strip_tags($_POST['duration']);
$new_duration = $old_duration + $durations;
$Date2 = date('Y-m-d', strtotime($aaaa . " + ".$durations." day"));
$yrdata= strtotime($Date2);
$dateee = date('d-M, y', $yrdata);

$packageoneday = $p_price/30;
$daycost = $durations*$packageoneday;

$diff = abs(strtotime($termination_date) - strtotime($todayy))/86400;
if($termination_date < $todayy){ $diff = '0';}
if($diff <= '7'){
	$colorrrr = 'style="color: red;font-size: 10px;font-weight: bold;"'; 
}
else{
	$colorrrr = 'style="font-size: 10px;font-weight: bold;"'; 
}

$sqlqqmm = mysql_query("SELECT minimum_day, minimum_days, minimum_sts, terminate FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);


$minimum_days = $row22m['minimum_days'];
$minimum_sts = $row22m['minimum_sts'];

if($minimum_sts != '1' && $minimum_days != ''){
	$minimum_days_array = explode(',',$minimum_days);
	$trimSpaces = array_map('trim',$minimum_days_array);
	asort($trimSpaces);
	$minimum_days_arrays = implode(',',$trimSpaces);
	$minimum_arraydd =  explode(',', $minimum_days_arrays);
	$minimum_day = min(explode(',', $minimum_days_arrays));
}
else{
	$minimum_day = $row22m['minimum_day'];
}

if($durations != ''){
	if($durations >= $minimum_day){
if($daycost != '' || $dateee != '' || $slno != ''){
echo json_encode(array("olddate" => $enddatefff,"daycost" => number_format($daycost,2),"slno" => $slno,"clientid" => $clientid,"newdate" => $dateee,"newdurations" => $durations,"new_duration" => $new_duration));
}}} ?>