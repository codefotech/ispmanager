<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
	if($_SESSION['SESS_USER_TYPE'] == '') {
		echo '<script type="text/javascript">window.close()</script>';
	}
include("../web/conn/connection.php");
include("../web/company_info.php");
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
		$API->write('/ppp/active/print', false);
		$API->write('?name='.$c_id);
		$res=$API->read(true);
		$ppp_name = $res[0]['name'];
		
	IF($ppp_name != ''){
		$API->write('/interface/print',false);
		$API->write('=from=<pppoe-'.$c_id.'>',false);
		$API->write('=stats-detail');
		$ressi=$API->read(true);

		$int_tx = $ressi[0]['tx-byte'];
		$download_speedd = $int_tx/1000000;
		$download_speed = number_format($download_speedd,3);
		$int_rx = $ressi[0]['rx-byte'];		
		$upload_speedd = $int_rx/1000000;
		$upload_speed = number_format($upload_speedd,3);
		    
$API->write('/interface/monitor-traffic',false);
$API->write('=interface=<pppoe-'.$c_id.'>',false);
$API->write('=once');
$ARRAY = $API->read();
		
$tx_bits = $ARRAY['0']['tx-bits-per-second'] / 1000;
   
if($tx_bits >= 1024){
	$tx_bitss1 = $tx_bits / 1000;
	$tx_bitss = number_format($tx_bitss1,2).' mbps';
}
else{
	$tx_bitss = number_format($tx_bits,2).' kbps';
}

$rx_bits = $ARRAY['0']['rx-bits-per-second'] / 1000;
   
if($rx_bits >= 1024){
	$rx_bitss1 = $rx_bits / 1000;
	$rx_bitss = number_format($rx_bitss1,2).' mbps';
}
else{
	$rx_bitss = number_format($rx_bits,2).' kbps';
}
   $API->disconnect();
   
if($tx_bits != '0' && $realtime_graph_sts == '1'){
	$query1ww = "insert into realtime_speed (c_id, rx, tx) VALUES ('$c_id', '$rx_bits', '$tx_bits')";
	$result1 = mysql_query($query1ww) or die("inser_query failed: " . mysql_error() . "<br />");
}
	?>								<table class="table table-bordered" style="width: 98%;font-weight: bold;">
										<tr>
											<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;background: #eee;"><a href=''>Upload</a></td>
											<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><a style="color: #444;"><?php echo $upload_speed; ?> mb</a> | <a style="color: green;font-weight: bolder;"><?php echo $rx_bitss;?></a></td>
										</tr>
										<tr>
											<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;background: #eee;"><a href=''>Download</a></td>
											<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><a style="color: #444;"><?php echo $download_speed; ?> mb</a> | <a style="color: red;font-weight: bolder;"><?php echo $tx_bitss;?></a></td>
										</tr>
									</table>
										<?php }	else{ ?>
									<table class="table table-bordered" style="width: 98%;font-weight: bold;">
										<tr>
											<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;background: #eee;"><a href=''></a></td>
											<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><a style="color: red;font-weight: bold;">Recently Offline</a></td>
										</tr>
									</table>
<html>
<body>
    <form action="<?php if($_SESSION['SESS_USER_TYPE'] == 'client' || $_SESSION['SESS_USER_TYPE'] == 'breseller'){echo 'Welcome';} else{echo 'ClientView';}?>" method="post" name="ok">
		<input type="hidden" name="ids" value="<?php echo $c_id;?>">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php }}
else{
	
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
									<table class="table table-bordered" style="width: 98%;font-weight: bold;">
										<tr>
											<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;background: #eee;"><a href=''>Upload</a></td>
											<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><a style="color: green;font-weight: bolder;"><?php echo $q_upload;?></a></td>
										</tr>
										<tr>
											<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;background: #eee;"><a href=''>Download</a></td>
											<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><a style="color: red;font-weight: bolder;"><?php echo $q_download;?></a></td>
										</tr>
									</table>
<?php
}
$API->disconnect();
}else{echo 'Network are not Connected.';
	$query12312rr ="update mk_con set online_sts = '1' WHERE id = '$maikro_id'";
	$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error());
}

  
if($realtime_graph_sts == '1'){
$sql3 = mysql_query("SELECT DATE_FORMAT(date_time,'%h:%m:%s') AS dat2ss, rx, tx FROM realtime_speed 
WHERE date_time BETWEEN DATE_SUB( CURTIME() , INTERVAL 1 MINUTE ) AND CURTIME() AND c_id = '$c_id' GROUP BY date_time ORDER BY id DESC");

$myurl3[]="['Date','Upload (kb)','Download (kb)']";
while($r3=mysql_fetch_assoc($sql3)){
	
	$paydate = $r3['dat2ss'];
	$collections = $r3['rx'];
	$discountss = $r3['tx'];
	$myurl3[]="['".$paydate."',".$collections.",".$discountss."]";
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl3));?>
        ]);

        var options = {
		  title: '..::Realtime Uses Graph::..',
		  fontSize: 9,
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));

        chart.draw(data, options);
      }
 </script>
 <div id="chart_div3" style="text-align: center; height: 150px; width: 98%;float: left;margin-bottom: 5px;margin-top: 2px;"></div>
 <?php 
 } 
 }
else{echo 'Network are Offline.';}?>