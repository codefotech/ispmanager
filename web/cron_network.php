<?php
include("conn/connection.php");
include('include/telegramapi.php');
include("mk_api.php");

$query2 = mysql_query("SELECT inactive_way, weblink FROM app_config");
$row2 = mysql_fetch_assoc($query2);
$inactive_way_sts = $row2['inactive_way'];
$weblink = $row2['weblink'];

$API = new routeros_api();
$API->debug = false;
						$sql = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h, online_sts, auto_sync_sts, auto_client_mk_sts FROM mk_con WHERE sts = '0' ORDER BY id ASC");
						$tot_mk = mysql_num_rows($sql);
								while( $row = mysql_fetch_assoc($sql) )
								{
									$maikro_id = $row['id'];
									$online_stss = $row['online_sts'];
									$auto_sync_stss = $row['auto_sync_sts'];
									$auto_client_mk_stss = $row['auto_client_mk_sts'];
									$Pass= openssl_decrypt($row['Pass'], $row['e_Md'], $row['secret_h']);
									
									if ($API->connect($row['ServerIP'], $row['Username'], $Pass, $row['Port'])) {
										if($online_stss == '1'){
											$query12312rr ="update mk_con set online_sts = '0' WHERE id = '$maikro_id'";
											$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error());
										}
										else{}
										if($auto_sync_stss == '1'){
											if($inactive_way_sts == '0'){
												$secretsync = $weblink.'NetworkPPPSecretSync.php?ids=auto&mk_id='.$maikro_id;
											}
											else{
												$secretsync = $weblink.'NetworkPPPSecretSyncInactive.php?ids=auto&mk_id='.$maikro_id;
											}	
											$ch11 = curl_init();
											curl_setopt($ch11, CURLOPT_URL,$secretsync); 
											curl_setopt($ch11, CURLOPT_RETURNTRANSFER,1); // return into a variable 
											curl_setopt($ch11, CURLOPT_CONNECTTIMEOUT, 0); 
											curl_setopt($ch11, CURLOPT_TIMEOUT, 200); 
											$result1d = curl_exec($ch11); 
											curl_close($ch11);
											
											$query12312rrd ="update mk_con set last_synced = '$result1d' WHERE id = '$maikro_id'";
											$resuldfsdddt = mysql_query($query12312rrd) or die("inser_query failed: " . mysql_error());
											$crrnt_sts = '-S';
										}
										else{
											$crrnt_sts = '';
										}
										
										if($auto_client_mk_stss == '1'){
												$clientorgmk = $weblink.'AutoActiveClientsmk.php?id='.$maikro_id;
												$ch111 = curl_init();
												curl_setopt($ch111, CURLOPT_URL,$clientorgmk); 
												curl_setopt(ch111); // return into a variable 
												curl_setopt($ch111, CURLOPT_CONNECTTIMEOUT, 0); 
												curl_setopt($ch111, CURLOPT_TIMEOUT, 200); 
												$result1dd = curl_exec($ch111); 
												curl_close($ch111);
												
												$clint_mk= '-C';
										}
										else{
											$clint_mk= '';
										}
										
										$mk_offlinecounter = 0;
										echo $maikro_id.':ok'.$crrnt_sts.$clint_mk.',';
									}
									else{
										if($online_stss == '0'){
											$query12312rr ="update mk_con set online_sts = '1' WHERE id = '$maikro_id'";
											$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error());
										}
										else{}
										$mk_offlinecounter = 1;
										echo $maikro_id.':dc,';
										
//-----------------Telegram-------------------------------
if($tele_sts == '0' && $tele_network_sts == '0'){
$telete_way = 'network_down';
$msg_body='..::[Mikrotik Disconnected]::..

ID: '.$maikro_id.'
IP: '.$row['ServerIP'].'
Name: '.$row['Name'].'

Has Been Disconnected.
Please connect as soon as possible.

'.$tele_footer.'';

include('include/telegramapicore.php');
}
//-----------------Telegram-------------------------------
									}
									$mk_offlinecounterr += $mk_offlinecounter;
								}
								
							$onlineount = $tot_mk - $mk_offlinecounterr;
							
							if($tot_mk == $mk_offlinecounterr){
								$query12312 ="update app_config set onlineclient_sts = '0'";
								echo $mk_offlinecounterr.':off';
							}
							else{
								$query12312 ="update app_config set onlineclient_sts = '1'";
								echo $onlineount.':on,'.$mk_offlinecounterr.':off';
							}
							$resufsddt = mysql_query($query12312) or die("inser_query failed: " . mysql_error());

?>

