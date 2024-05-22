<?php
include("conn/connection.php");
session_start(); // NEVER FORGET TO START THE SESSION!!!
	if($_SESSION['SESS_USER_TYPE'] == '') {
		echo '<script type="text/javascript">window.close()</script>';
	}
include("mk_api.php");
$mk_id = $_GET['mk_id'];
$c_id = $_GET['c_id'];

$query2ee = mysql_query("SELECT realtime_graph FROM app_config");
$row2s = mysql_fetch_assoc($query2ee);
$realtime_graph_sts = $row2s['realtime_graph'];

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
		$API->write('/ppp/active/print', false);
		$API->write('?name='.$c_id);
		$res=$API->read(true);
		$ppp_name = $res[0]['name'];
		
	if($ppp_name != ''){
	$rowsq = array();
	$rows2q = array();

	$API->write("/interface/monitor-traffic",false);
	$API->write('=interface=<pppoe-'.$c_id.'>',false);
	$API->write("=once=");
	$ARRAY = $API->read();

	$rx = $ARRAY[0]["rx-bits-per-second"];
	$tx = $ARRAY[0]["tx-bits-per-second"];

	$rowsq['name'] = 'Tx';
	$rowsq['data'][] = $tx;
	$rows2q['name'] = 'Rx';
	$rows2q['data'][] = $rx;
	
$resultq = array();
array_push($resultq,$rowsq);
array_push($resultq,$rows2q);
print json_encode($resultq);
	}	else{ ?>
									<table class="table table-bordered" style="width: 47%; float: left;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;background: #eee;"></td>
											<td class="width70" style="padding: 6px;background: white;"><a style="color: red;font-weight: bold;">Recently Offline</a></td>
										</tr>
									</table>
<html>
<body>
    <form action="<?php if($_SESSION['SESS_USER_TYPE'] == 'client' || $_SESSION['SESS_USER_TYPE'] == 'breseller'){echo 'welcome';} else{echo 'ClientView';}?>" method="post" name="ok">
		<input type="hidden" name="ids" value="<?php echo $c_id;?>">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
	<?php }} else{
	
	
		$API->write('/ip/arp/getall', false);
		$API->write('?address='.$ip);
		$res=$API->read(true);
		$qu_name = $res[0]['name'];
		
	if($qu_name != ''){
	$API->write('/queue/simple/print', false);
	$API->write('?target='.$ip.'/32');
	$ressi=$API->read(true);
	$API->disconnect();
		
		$queueDown = explode('/',$ressi[0]['rate'])[1];		
		$mk_download = $queueDown / 1000;
		
		$queueUp = explode('/',$ressi[0]['rate'])[0];
		$mk_upload = $queueUp / 1000;

if($mk_download >= 1024){
	$mk_download1 = $mk_download / 1000;
	$q_download = number_format($mk_download1,2).' mbps';
}
else{
	$q_download = number_format($mk_download,2).' kbps';
}
if($mk_upload >= 1024){
	$mk_upload1 = $mk_upload / 1000;
	$q_upload = number_format($mk_upload1,2).' mbps';
}
else{
	$q_upload = number_format($mk_upload,2).' kbps';
}
if($mk_download != '0' && $realtime_graph_sts == '1'){
	$query1ww = "insert into realtime_speed (c_id, rx, tx) VALUES ('$c_id', '$mk_upload', '$mk_download')";
	$result1 = mysql_query($query1ww) or die("inser_query failed: " . mysql_error() . "<br />");
}
?>
									<table class="table table-bordered" style="width: 47%; float: left;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;background: #eee;">Upload</td>
											<td class="width70" style="padding: 6px;background: white;"><a style="color: green;font-weight: bold;"><?php echo $q_upload;?></a></td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;background: #eee;">Download</td>
											<td style="padding: 6px;background: white;"><a style="color: red;font-weight: bold;"><?php echo $q_download;?></a></td>
										</tr>
									</table>
<?php } else{?>
									<table class="table table-bordered" style="width: 47%; float: left;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;background: #eee;"></td>
											<td class="width70" style="padding: 6px;background: white;"><a style="color: red;font-weight: bold;">Recently Offline</a></td>
										</tr>
									</table>
									
<html>
<body>
    <form action="<?php if($_SESSION['SESS_USER_TYPE'] == 'client' || $_SESSION['SESS_USER_TYPE'] == 'breseller'){echo 'welcome';} else{echo 'ClientView';}?>" method="post" name="ok">
		<input type="hidden" name="ids" value="<?php echo $c_id;?>">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>

<?php }}} else{echo 'Network are not Connected.';
	$query12312rr ="update mk_con set online_sts = '1' WHERE id = '$maikro_id'";
	$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error());
}
  
}

 ?>