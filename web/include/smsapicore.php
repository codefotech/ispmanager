<?php
ini_alter('date.timezone','Asia/Almaty');
$send_date = date('Y-m-d', time());
$send_time = date('H:i:s', time());

$fileURL2 = urlencode($sms_body);
$full_linkd= $link.'&message='.$fileURL2.'&mobile_no='.$cell;

	$chg = curl_init();
	curl_setopt($chg, CURLOPT_URL,$full_linkd); 
	curl_setopt($chg, CURLOPT_RETURNTRANSFER,1); // return into a variable 
	curl_setopt($chg, CURLOPT_TIMEOUT, 10); 
	$resultdgfb = curl_exec($chg); 
	curl_close($chg);

$smsapidd = json_decode($resultdgfb, true);
$api_iddd = $smsapidd['Message_ID'];

$query2 ="insert into sms_send (c_id, c_cell, sms_body, send_by, send_date, send_time, api_id, from_page, username) VALUES ('$c_idd', '$cell', '$sms_body', '$send_by', '$send_date', '$send_time', '$api_iddd', '$from_page', '$password')";
$result2 = mysql_query($query2) or die("inser_query failed: " . mysql_error() . "<br />");
?>
