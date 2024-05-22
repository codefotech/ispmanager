<?php
include("conn/connection.php") ;
include("mk_api.php");
$mk_id = $_GET['mk_id'];
$c_id = $_GET['c_id'];

$sqlcli = mysql_query("SELECT breseller, ip FROM clients WHERE c_id = '$c_id'");
$rowcal = mysql_fetch_assoc($sqlcli);
$breseller = $rowcal['breseller'];
$ip = $rowcal['ip'];

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h, online_sts FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
		$online_stsss = $rowmk['online_sts'];
		
if($online_stsss == '0'){
$API = new routeros_api();
$API->debug = false;

if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
if($breseller == '0'){
		$API->write('/interface/print',false);
		$API->write('=from=<pppoe-'.$c_id.'>',false);
		$API->write('=stats-detail');
		$ressi=$API->read(true);

		$int_tx = $ressi[0]['tx-byte'];
		$download_speedd = $int_tx/1000000;
		$download_speed = number_format($download_speedd,3);
		    
$API->write('/interface/monitor-traffic',false);
$API->write('=interface=<pppoe-'.$c_id.'>',false);
$API->write('=once');
$ARRAY = $API->read();
		
$tx_bits = $ARRAY['0']['tx-bits-per-second'] / 1000;
   $API->disconnect();
   
if($tx_bits >= 1024){
	$tx_bitss1 = $tx_bits / 1000;
	$tx_bitss = number_format($tx_bitss1,2).' mbps';
}
else{
	$tx_bitss = number_format($tx_bits,2).' kbps';
}
if($tx_bits != '0'){
	$query1ww = "insert into realtime_speed (c_id, rx, tx) VALUES ('$c_id', '$rx_bits', '$tx_bits')";
	$result1 = mysql_query($query1ww) or die("inser_query failed: " . mysql_error() . "<br />");
}
	?>
			<a style="color: #444;"><?php echo $download_speed; ?> mb</a> | <a style="color: red;"><?php echo $tx_bitss;?></a>
	<?php }
else{
	
	$API->write('/queue/simple/print', false);
	$API->write('?target=172.16.150.1/32');
	$ressi=$API->read(true);
	$API->disconnect();
		
		$queueDown = explode('/',$ressi[0]['rate'])[1];		
		$mk_download = $queueDown / 1000;

if($mk_download >= 1024){
	$mk_download1 = $mk_download / 1000;
	$q_download = number_format($mk_download1,2).' mbps';
}
else{
	$q_download = number_format($mk_download,2).' kbps';
}
?>
<a style="color: red;"><?php echo $q_download;?></a>
<?php
}
}else{echo 'Network are not Connected.';
	$query12312rr ="update mk_con set online_sts = '1' WHERE id = '$maikro_id'";
	$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error());
}
}
else{echo 'Network are Offline.';}
  
?>