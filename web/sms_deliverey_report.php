<?php
include("conn/connection.php") ;
include('include/smsapi.php');

$api_id = $_GET['api_id'];

if($api_id == 'checkall'){
$sql = mysql_query("SELECT api_id AS messageid FROM sms_send WHERE send_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 3 DAY ) ) AND DATE ( NOW() ) AND `api_id` != '' AND `delivery_report` != 'DELIVRD' AND `delivery_report` = '' or `delivery_report` = 'SENT' or `delivery_report` = 'PENDING' AND c_cell REGEXP '^-?[0-9]+$' ORDER BY `id` DESC");
while( $row = mysql_fetch_assoc($sql) )
{
$messageid = $row['messageid'];
$full_link= $link.'getstatus?'.$username.'&messageid='.$messageid;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$full_link); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
	$result = curl_exec($ch); 
	curl_close($ch);
$smsapi = json_decode($result, true);
$text = $smsapi['Text'];

$query ="update sms_send set delivery_report = '$text' WHERE api_id = '$messageid'";
$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
}
echo '<script type="text/javascript">window.close()</script>';
}
else{
	
$quelij = mysql_query("SELECT delivery_report FROM sms_send WHERE api_id = '$api_id'");
$rowilh = mysql_fetch_assoc($quelij);
$deliveryreport = $rowilh['delivery_report'];

if($deliveryreport != 'DELIVRD'){
$full_link= $link.'getstatus?'.$username.'&messageid='.$api_id;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$full_link); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
	$result = curl_exec($ch); 
	curl_close($ch);
$smsapi = json_decode($result, true);
$text = $smsapi['Text'];
$sms_id = $smsapi['Message_ID'];

if($text == 'DELIVRD'){
	$colorrr = 'style="font-weight: bold;font-size: 17px;color: blue;margin-right: 10px;"';
}
elseif($text == 'REJECTD'){
	$colorrr = 'style="font-weight: bold;font-size: 17px;color: red;margin-right: 10px;"';
}
elseif($text == 'SENT'){
	$colorrr = 'style="font-weight: bold;font-size: 17px;color: Green;margin-right: 10px;"';
}
else{
	$colorrr = 'style="font-weight: bold;font-size: 17px;color: black;margin-right: 10px;"';
}

$query ="update sms_send set delivery_report = '$text' WHERE api_id = '$api_id'";
$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<p style="text-align: center;">
	<a style="font-size: 17px;font-weight: bold;margin-right: 10px;">SMS ID: <?php echo $api_id;?></a> <a style="font-size: 15px;margin-right: 10px;">   Has Been   </a> <a <?php echo $colorrr;?>><?php echo $text;?></a><a style="font-size: 15px;"> By SMS Server.</a>
</p>
<?php } else{ ?>
<p style="text-align: center;">
	<a style="font-size: 17px;font-weight: bold;margin-right: 10px;">SMS ID: <?php echo $api_id;?></a> <a style="font-size: 15px;margin-right: 10px;">   Has Been   </a> <a style="font-weight: bold;font-size: 17px;color: blue;margin-right: 10px;">DELIVRD</a><a style="font-size: 15px;"> By SMS Server.</a>
</p>
 <?php }} ?>