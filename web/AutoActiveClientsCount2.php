<?php
include_once ("conn/connection.php") ;
include("mk_api.php");	
$mk_id = $_GET['id'];

$API = new routeros_api();
$API->debug = false;

$query2 = mysql_query("SELECT onlineclient_sts FROM app_config");
$row2 = mysql_fetch_assoc($query2);
$onlineclient_sts = $row2['onlineclient_sts'];

if($onlineclient_sts == '1'){
$sql34 = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND online_sts = '0' AND id = '$mk_id'");
$roww = mysql_fetch_assoc($sql34);

		$maikro_Name = $roww['Name'];
		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)) {
			$arrID1 = $API->comm('/ppp/active/getall');
			$mk_online = count($arrID1);
			$API->disconnect();
			}
		else{
			$mk_online = '0';
			$query12312rr ="UPDATE mk_con SET online_sts = '1' WHERE id = '$mk_id'";
			$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error() . "<br />");
		}

echo $mk_online;
}
?>



