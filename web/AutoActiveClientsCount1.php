<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!

if(!$_SESSION['page_counter']){
	$_SESSION['page_counter'] = 0;
}
else{
	$_SESSION['page_counter'] = $_SESSION['page_counter'];
}

$_SESSION['page_counter']++;


if($_SESSION['page_counter'] < '200'){
include_once ("conn/connection.php") ;
include("mk_api.php");	

$API = new routeros_api();
$API->debug = false;

$query2 = mysql_query("SELECT onlineclient_sts FROM app_config");
$row2 = mysql_fetch_assoc($query2);
$onlineclient_sts = $row2['onlineclient_sts'];

if($onlineclient_sts == '1'){
$sql34 = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND online_sts = '0' ORDER BY id ASC");
$tot_mk = mysql_num_rows($sql34);
$items = array();
while ($roww = mysql_fetch_assoc($sql34)) {
		$maikro_id = $roww['id'];
		$maikro_Name = $roww['Name'];
		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)) {
			$arrID1 = $API->comm('/ppp/active/getall');
			foreach($arrID1 as $x => $x_value) {
				$items[] = $x_value['name'];
			}
			$mk_online = count($arrID1);

			$ARRAY = $API->comm("/system/resource/print");
			$first = $ARRAY['0'];
			$cpu = '['.$first['cpu-load'].'%]';
			$uptime = $first['uptime'];
			
			$API->disconnect();
			$mk_offlinecounter = 0;
			}
		else{
			$items[] = '';
			$mk_online = '0';
			$cpu = '';
			$uptime = '';
			$query12312rr ="UPDATE mk_con SET online_sts = '1' WHERE id = '$maikro_id'";
			$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error() . "<br />");
			$mk_offlinecounter = 1;
		}
			$mk_offlinecounterr += $mk_offlinecounter;
			$total_mk_online += $mk_online;

$query233 = mysql_query("SELECT COUNT(id) AS db_clients FROM clients WHERE mk_id = '$maikro_id' AND sts = '0' AND con_sts = 'Active'");
$row233 = mysql_fetch_assoc($query233);
$db_clients = $row233['db_clients'];

echo "<li style='padding: 1% 0% 1% 1%;font-size: 13px;font-weight: bold;'><i class='iconfa-angle-right'></i> <a style='color: #958c8c;font-size: 10px;line-height: 10px;padding: 0px 0px 0px 5px;' title='{$ServerIP1}\n{$first['board-name']}\n{$uptime}'>{$cpu}<div style='color: #0866c6;float: left;font-size: 13px;'>{$maikro_id}. {$maikro_Name} [{$ServerIP1}]</div> <span style='padding: 0% 3% 0% 3%;width: 30px;border-left: 1px solid #ddd;font-size: 14px;color: #008000a8;' title='On Mikrotik'>{$mk_online}</span><span style='padding: 0% 3% 0% 3%;width: 30px;font-size: 14px;color: #ec1f27a8;' title='On Database'>{$db_clients}</span></a></li>";
}
		
		$ghjghjgj = implode(',', array_unique($items));
		$queryss = "INSERT INTO mk_active_count (total_active, client_array) VALUES ('$total_mk_online', '$ghjghjgj')";
		$sqssl = mysql_query($queryss) or die("Error" . mysql_error());

if($tot_mk == $mk_offlinecounterr){
	$query12312 ="update app_config set onlineclient_sts = '0'";
	$resuldfsdt = mysql_query($query12312) or die("inser_query failed: " . mysql_error() . "<br />");
}

$query233aa = mysql_query("SELECT COUNT(id) AS db_clients FROM clients WHERE sts = '0' AND con_sts = 'Active'");
$row233ss = mysql_fetch_assoc($query233aa);
$total_db_clients = $row233ss['db_clients'];

echo "<li style='padding: 1% 0% 1% 1%;font-size: 13px;font-weight: bold;'><div style='color: #0866c6;text-align: right;padding: 3px 0px 0px 0px;font-size: 17px;'><span style='padding: 0% 3% 0% 3%;width: 30px;font-size: 25px;color: #ec1f27a8;'>{$total_db_clients}</span><span style='padding: 0% 3% 0% 3%;width: 30px;font-size: 25px;color: #008000a8;border-left: 1px solid #ddd;'>{$total_mk_online}</span></div></li>";
}
	}
	else{
		echo 'Please Reload The page.';
	}
?>



