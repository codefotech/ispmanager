<?php
include("conn/connection.php");
extract($_POST); 
include('include/smsapi.php');
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');
$userr_typ = 'admin';

$todayssss = strtotime(date('Y-m-d', time()));
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$date_time = date('Y-m-d H:i:s', time());
$querysasa = mysql_query("SELECT e_name FROM emp_info WHERE e_id = '$eidddd'");
$row5sds = mysql_fetch_assoc($querysasa);
$enamefsdf = $row5sds['e_name'];

if($wayy == 'Terminate'){
	$query2 = "UPDATE emp_info SET terminate = '1', terminate_date_time = '$date_time', terminate_by = '$eidddd' WHERE z_id = '$z_id'";
			if (!mysql_query($query2))	{	die('Error: ' . mysql_error());	}
			
if($sentsms == 'Yes'){
	
$cell = $reseller_no;
$c_idd = $reseller_id;
$send_by = $eidddd;
$send_date = $update_date;
$send_time = $update_time;
$from_page = 'Terminated Reseller';

$sms_body = 'Dear '.$reseller_name.',
Your account has been terminated by '.$enamefsdf.'.
Total '.$totalzoneclients.' clients Inactivated.

'.$sms_footer.'';

include('include/smsapicore.php');
}

	$sql = mysql_query("SELECT c_id, mk_id, c_terminate FROM clients WHERE z_id = '$z_id' AND mac_user = '1' AND con_sts = 'Active' AND sts = '0' AND c_terminate = '0'");

	while( $rowwqw = mysql_fetch_assoc($sql) ){

	$mkk_id = $rowwqw['mk_id'];
	$c_idddd = $rowwqw['c_id'];

		$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkk_id'");
		while( $rowmk = mysql_fetch_assoc($sqlmk) ){
			
			$ServerIP = $rowmk['ServerIP'];
			$Username = $rowmk['Username'];
			$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
			$Port = $rowmk['Port'];
			
			$API = new routeros_api();
			$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
				$arrID = $API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_idddd,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
						
				$arrID = $API->comm("/ppp/active/print",
						  array(".proplist"=> ".id","?name" => $c_idddd,));

						$API->comm("/ppp/active/remove",
						array(".id" => $arrID[0][".id"],));
						
			$query = "UPDATE clients SET con_sts = 'Inactive', c_terminate = '1', c_terminate_date_time = '$date_time', c_terminate_by = '$eidddd' WHERE c_id = '$c_idddd'";
			if (!mysql_query($query))
					{
					die('Error: ' . mysql_error());
					}
					
			$query1 = "INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$c_idddd', 'Inactive', '$update_date', '$update_time', '$eidddd')";
			if (!mysql_query($query1))
					{
					die('Error: ' . mysql_error());
					}
}}
?>
<html>
<body>
     <form action="MacResellerBillHistory?id=<?php echo $z_id; ?>" method="post" name="done">
       <input type="hidden" name="sts" value="Terminated">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
	
<?php }}

if($wayy == 'Determinate'){

$query2 = "UPDATE emp_info SET terminate = '0' WHERE z_id = '$z_id'";
if (!mysql_query($query2))	{	die('Error: ' . mysql_error());	}
			
if($sentsms == 'Yes'){
$cell = $reseller_no;
$c_idd = $reseller_id;
$send_by = $eidddd;
$send_date = $update_date;
$send_time = $update_time;
$from_page = 'Determinated Reseller';

$sms_body = 'Dear '.$reseller_name.',
Your account has been Determinated by '.$enamefsdf.'.
Total '.$totalzoneclientsdetar.' clients Activated.

'.$sms_footer.'';

include('include/smsapicore.php');
}

	$sql = mysql_query("SELECT c_id, mk_id, c_terminate FROM clients WHERE z_id = '$z_id' AND mac_user = '1' AND con_sts = 'Inactive' AND sts = '0' AND c_terminate = '1'");

	while( $rowwqw = mysql_fetch_assoc($sql) ){
		
	$mkk_id = $rowwqw['mk_id'];
	$c_idddd = $rowwqw['c_id'];

$ques = mysql_query("SELECT start_date, end_date FROM billing_mac WHERE c_id = '$c_idddd' ORDER BY id DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$start_date = strtotime($roww['start_date']);
$end_date = strtotime($roww['end_date']);

if($todayssss >= $start_date && $todayssss < $end_date || $todayssss <= $start_date && $todayssss < $end_date) {
		$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkk_id'");
		while( $rowmk = mysql_fetch_assoc($sqlmk) ){
			
			$ServerIP = $rowmk['ServerIP'];
			$Username = $rowmk['Username'];
			$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
			$Port = $rowmk['Port'];
			
			$API = new routeros_api();
			$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
				$arrID = $API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_idddd,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"disabled"  => "no",));
						
			$API->disconnect();
			$query = "UPDATE clients SET con_sts = 'Active', c_terminate = '0' WHERE c_id = '$c_idddd'";
			if (!mysql_query($query))
					{
					die('Error: ' . mysql_error());
					}
					
			$query1 = "INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$c_idddd', 'Active', '$update_date', '$update_time', '$eidddd')";
			if (!mysql_query($query1))
					{
					die('Error: ' . mysql_error());
					}
					
}}}
else{
			$query = "UPDATE clients SET c_terminate = '0', c_terminate_date_time = '$date_time', c_terminate_by = '$eidddd' WHERE c_id = '$c_idddd'";
			if (!mysql_query($query))
					{
					die('Error: ' . mysql_error());
					}
}
?>
<html>
<body>
     <form action="MacResellerBillHistory?id=<?php echo $z_id; ?>" method="post" name="done">
       <input type="hidden" name="sts" value="Determinated">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
<?php } }?>