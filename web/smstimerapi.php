<?php
include("conn/connection.php");

$sqlsdfq = mysql_query("SELECT id AS ina, time_hr AS in_time_hr, time_min AS in_time_min, sts AS in_sts FROM sms_msg WHERE id = '2'");
$rowbk=mysql_fetch_array($sqlsdfq);

$sqlsdfqq = mysql_query("SELECT id AS r1, time_hr AS r1_time_hr, time_min AS r1_time_min, send_sts AS r1_sts FROM sms_msg WHERE id = '12'");
$rowbkq=mysql_fetch_array($sqlsdfqq);

$sqlsdfqqd = mysql_query("SELECT id AS r2, time_hr AS r2_time_hr, time_min AS r2_time_min, send_sts AS r2_sts FROM sms_msg WHERE id = '13'");
$rowbkqd=mysql_fetch_array($sqlsdfqqd);

$all = '{"ina":"'.$rowbk['ina'].'","in_time_hr":"'.$rowbk['in_time_hr'].'","in_time_min":"'.$rowbk['in_time_min'].'","in_sts":"'.$rowbk['in_sts'].'","r1":"'.$rowbkq['r1'].'","r1_time_hr":"'.$rowbkq['r1_time_hr'].'","r1_time_min":"'.$rowbkq['r1_time_min'].'","r1_sts":"'.$rowbkq['r1_sts'].'","r2":"'.$rowbkqd['r2'].'","r2_time_hr":"'.$rowbkqd['r2_time_hr'].'","r2_time_min":"'.$rowbkqd['r2_time_min'].'","r2_sts":"'.$rowbkqd['r2_sts'].'"}';
echo $all;
?>

