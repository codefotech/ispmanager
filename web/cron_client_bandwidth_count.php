<?php
include("conn/connection.php");
include("mk_api.php");

$query2 = mysql_query("SELECT weblink FROM app_config");
$row2 = mysql_fetch_assoc($query2);
$weblink = $row2['weblink'];

$API = new routeros_api();
$API->debug = false;

$sql = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h, online_sts, auto_sync_sts, auto_client_mk_sts, tx_rx_count_sts, online_count_sts FROM mk_con WHERE sts = '0' AND online_sts = '0' ORDER BY id ASC");
$tot_mk = mysql_num_rows($sql);
$items = array();
$itemss = array();
		while( $row = mysql_fetch_assoc($sql) )
		{
			$maikro_id = $row['id'];
			$online_stss = $row['online_sts'];
			$auto_sync_stss = $row['auto_sync_sts'];
			$tx_rx_count_sts = $row['tx_rx_count_sts'];
			$online_count_sts = $row['online_count_sts'];
			$auto_client_mk_stss = $row['auto_client_mk_sts'];
			$Pass= openssl_decrypt($row['Pass'], $row['e_Md'], $row['secret_h']);
			
			if ($API->connect($row['ServerIP'], $row['Username'], $Pass, $row['Port'])) {
				if($tx_rx_count_sts == '1'){
					$secretsync = $weblink.'ClientBandwidthCount.php?mk_id='.$maikro_id;
					
					$ch11 = curl_init();
					curl_setopt($ch11, CURLOPT_URL,$secretsync); 
					curl_setopt($ch11, CURLOPT_RETURNTRANSFER,1); // return into a variable 
					curl_setopt($ch11, CURLOPT_CONNECTTIMEOUT, 0); 
					curl_setopt($ch11, CURLOPT_TIMEOUT, 1000); 
					$result1d = curl_exec($ch11); 
					curl_close($ch11);
					
					$crrnt_sts = $result1d;
				}
				else{
					$crrnt_sts = ':No';
				}
				
				if($online_count_sts == '1'){
					$secretsync = $weblink.'ClientmkonlineCount.php?mk_id='.$maikro_id;
					
					$ch11 = curl_init();
					curl_setopt($ch11, CURLOPT_URL,$secretsync); 
					curl_setopt($ch11, CURLOPT_RETURNTRANSFER,1); // return into a variable 
					curl_setopt($ch11, CURLOPT_CONNECTTIMEOUT, 0); 
					curl_setopt($ch11, CURLOPT_TIMEOUT, 1000); 
					$result1d = curl_exec($ch11); 
					curl_close($ch11);
					
					$online_count = $result1d;
				}
				else{
					$online_count = ':No';
				}
				
				$arrID = $API->comm('/ppp/active/getall');
					foreach($arrID as $xx => $x_value) {
						$items[] = $x_value['name'];
					}
				
				$arrIDD = $API->comm('/ip/arp/getall');
					foreach($arrIDD as $xx => $x_valuee) {
							$clip = $x_valuee['address'];
							$macsearch = mysql_query("SELECT c_id FROM clients WHERE ip = '$clip'");
							$macsearchaa = mysql_fetch_assoc($macsearch);	
							if($macsearchaa['c_id'] != ''){
								$itemss[] = $macsearchaa['c_id'];
							}
					}

			$API->disconnect();
			}
			
			echo '['.$maikro_id.':'.$online_count.']';
			
			if($online_count != ':No'){
				$total_mk_online += $online_count;
			}
		}
		$itemss1 = array_merge($itemss, $items);
			$ghjghjgj = implode(',', array_unique($itemss1));
				
				$queryss = "INSERT INTO mk_active_count (total_active, client_array) VALUES ('$total_mk_online', '$ghjghjgj')";
				$sqssl = mysql_query($queryss) or die("Error" . mysql_error());
//echo $ghjghjgj;
?>

