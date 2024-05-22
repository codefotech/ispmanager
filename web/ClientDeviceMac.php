<?php
include("conn/connection.php") ;
include("mk_api.php");
$mk_id = $_GET['mk_id'];
$c_id = $_GET['c_id'];
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '1'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;



    if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

	
		$API->write('/interface/print',false);
		$API->write('=from=<pppoe-'.$c_id.'>',false);
		$API->write('=stats-detail');
		$ressi=$API->read(true);
		
//		$int_name = $ressi[0]['name'];
//		$int_rx = $ressi[0]['rx-byte'];
		$int_tx = $ressi[0]['tx-byte'];
		
		$download_speedd = $int_tx/1000000;
//		$upload_speedd = $int_rx/1000000;
		$download_speed = number_format($download_speedd,3);
		    
$API->write('/interface/monitor-traffic',false);
$API->write('=interface=<pppoe-'.$c_id.'>',false);
$API->write('=once');
$ARRAY = $API->read();
		
$rx_bits = $ARRAY['0']['rx-bits-per-second'] / 1000;
$tx_bits = $ARRAY['0']['tx-bits-per-second'] / 1000;
   $API->disconnect();
	?>

			<a style="color: #444;"><?php echo $download_speed; ?> mb</a> | <a style="color: red;"><?php echo $tx_bits; ?> kbps</a>
	<?php }else{echo 'Selected Network are not Connected.';}
  
?>
