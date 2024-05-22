<?php
extract($_POST);
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');
$send_date = date('Y-m-d', time());
$send_time = date('H:i:s', time());

if($cell !=''){
$query5 = mysql_query("SELECT c.id, c.c_id, z.z_name FROM clients as c 
						LEFT JOIN zone as z
						ON z.z_id = c.z_id WHERE c.cell = '$cell'");
$row5 = mysql_fetch_assoc($query5);
		$cus_id= $row5['c_id'];
		$z_name= $row5['z_name'];
		if($cus_id !=''){
		$c_id = $cus_id.'-'.$z_name;}
}
		
if($cus_id ==''){
			$c_id= 'Bulk SMS';
		}
$from_page = 'Bulk SMS';

$fileURL2 = urlencode($sms_write);
$full_link= $link.'&message='.$fileURL2.'&mobile_no='.$cell;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$full_link); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
	$result = curl_exec($ch); 
	curl_close($ch);

$smsapi = json_decode($result, true);
$api_id = $smsapi['Message_ID'];
	
$query2 ="insert into sms_send (c_id , c_cell, sms_body, send_by, send_date, send_time, api_id, from_page, username) VALUES ('$c_id', '$cell', '$sms_write', '$send_by', '$send_date', '$send_time', '$api_id', '$from_page', '$password')";
$result2 = mysql_query($query2) or die("inser_query failed: " . mysql_error() . "<br />");
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