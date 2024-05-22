<?php
include("conn/connection.php");
include("mk_api.php");	
date_default_timezone_set('Etc/GMT-6');
$right_now = date('Y-m-d H:i:s', time());
$right_now_date = date('Y-m-d', time());
$right_now_h = date('H', time());
$date_old_6 = date('Y-m-d',strtotime("-3 days"));

$mk_id = $_GET['mk_id'];

//$onlinepayyy = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(session_id SEPARATOR ',') AS session_id FROM client_bandwidth"));
//$session_id_arry = explode(',',$onlinepayyy['session_id']);

$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk1 = mysql_fetch_assoc($sqlmk1);

$ServerIP1 = $rowmk1['ServerIP'];
$Username1 = $rowmk1['Username'];
$Pass1= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
$Port1 = $rowmk1['Port'];
$API = new routeros_api();
$API->debug = false;
				if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
						$arrID = $API->comm('/ppp/active/getall');
						$mk_online = count($arrID);
						/* foreach($arrID as $x => $x_value) {
							
							$aaaaa = $x_value['name'];
							
							$session_uptime = $x_value['uptime'];
							$session_ip = $x_value['address'];
							$session_mac = $x_value['caller-id'];
//							$session_id = $x_value['.id'];
							$session_uptime_day = substr($session_uptime, 0, 2);
								
							$sql44 = mysql_query("SELECT c_id, c_name FROM clients WHERE c_id = '$aaaaa'");
							$rows1 = mysql_fetch_assoc($sql44);
							$c_id = $rows1['c_id'];

							if($session_uptime_day == '1d'){
								$arrID1 = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
								$API->comm("/ppp/active/remove", array(".id" => $arrID1[0][".id"],));
							}
								
							if($rows1['c_name'] != ''){
								$API->write('/interface/print',false);
								$API->write('=from=<pppoe-'.$c_id.'>',false);
								$API->write('=stats-detail');
								$ressi=$API->read(true);
								
								$int_tx = $ressi[0]['tx-byte'];
								$int_rx = $ressi[0]['rx-byte'];
								$session_id = $ressi[0]['.id'];
								
								if($session_id != ''){
									if(in_array($session_id, $session_id_arry)){
										$sql4s4 = mysql_query("SELECT COUNT(id) AS idcount FROM client_bandwidth WHERE session_id = '$session_id' AND c_id = '$c_id'");
										$rowss1 = mysql_fetch_assoc($sql4s4);
										$idcount = $rowss1['idcount'];
										
										if($idcount > '0'){
											$sql4s4d = mysql_query("SELECT id AS old_id, session_date AS old_session_date, DATE_FORMAT(start_time,'%H') AS start_h FROM client_bandwidth WHERE session_id = '$session_id' AND c_id = '$c_id' ORDER BY id DESC LIMIT 1");
											$rowss1d = mysql_fetch_assoc($sql4s4d);
											$old_session_date = $rowss1d['old_session_date'];
											$old_start_h = $rowss1d['start_h'];
											$old_id = $rowss1d['old_id'];
											
											if($old_session_date == $right_now_date){
												$sql4ss4ds = mysql_query("SELECT sum(tx_byte) AS tx_byte, sum(rx_byte) AS rx_byte FROM client_bandwidth WHERE session_id = '$session_id' AND c_id = '$c_id' AND session_date = '$right_now_date' AND hour(session_time) != '$right_now_h'");
												$rowssaa1ds = mysql_fetch_assoc($sql4ss4ds);
												$new_tx_byte = $int_tx - $rowssaa1ds['tx_byte'];
												$new_rx_byte = $int_rx - $rowssaa1ds['rx_byte'];
												
												if($old_start_h == $right_now_h){
													$query12312rrd ="update client_bandwidth set tx_byte = '$new_tx_byte', rx_byte = '$new_rx_byte', session_tx_byte = '$int_tx', session_rx_byte = '$int_rx', end_time = '$right_now', session_uptime = '$session_uptime', session_ip = '$session_ip', session_mac = '$session_mac' WHERE id = '$old_id'";
													$resuldfsdddt = mysql_query($query12312rrd) or die("inser_query failed: " . mysql_error());
												}
												else{
													$query12312rrd ="insert into client_bandwidth (c_id, session_id, tx_byte, rx_byte, session_tx_byte, session_rx_byte, start_time, mk_id, session_uptime, session_ip, session_mac) VALUES ('$c_id', '$session_id', '$new_tx_byte', '$new_rx_byte', '$int_tx', '$int_rx', '$right_now', '$mk_id', '$session_uptime', '$session_ip', '$session_mac')";
													$resuldfsdddt = mysql_query($query12312rrd) or die("inser_query failed: " . mysql_error() . "<br />");
												}
											}
											else{
												$old_session_date_time = $old_session_date.' 23:59:59';
												$query12312rrd ="update client_bandwidth set tx_byte = '$int_tx', rx_byte = '$int_rx', session_tx_byte = '$int_tx', session_rx_byte = '$int_rx', end_time = '$old_session_date_time', session_uptime = '$session_uptime', session_ip = '$session_ip', session_mac = '$session_mac' WHERE id = '$old_id'";
												$resuldfsdddt = mysql_query($query12312rrd) or die("inser_query failed: " . mysql_error());
												
//												$arrID1 = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
//												$API->comm("/ppp/active/remove", array(".id" => $arrID1[0][".id"],));
											}
										}
										else{
											$query12312rrd ="insert into client_bandwidth (c_id, session_id, tx_byte, rx_byte, session_tx_byte, session_rx_byte, start_time, mk_id, session_uptime, session_ip, session_mac) VALUES ('$c_id', '$session_id', '$int_tx', '$int_rx', '$int_tx', '$int_rx', '$right_now', '$mk_id', '$session_uptime', '$session_ip', '$session_mac')";
											$resuldfsdddt = mysql_query($query12312rrd) or die("inser_query failed: " . mysql_error() . "<br />");
										}
									}
									else{
										$query12312rrd ="insert into client_bandwidth (c_id, session_id, tx_byte, rx_byte, session_tx_byte, session_rx_byte, start_time, mk_id, session_uptime, session_ip, session_mac) VALUES ('$c_id', '$session_id', '$int_tx', '$int_rx', '$int_tx', '$int_rx', '$right_now', '$mk_id', '$session_uptime', '$session_ip', '$session_mac')";
										$resuldfsdddt = mysql_query($query12312rrd) or die("inser_query failed: " . mysql_error() . "<br />");
									}
									$clientsount = 1;
								}				
							}
							$clientsountt += $clientsount;
						} */
						echo $mk_online;
						$API->disconnect();
				}
				
/* $queewqd = mysql_query("SELECT id FROM client_bandwidth WHERE session_date < '$date_old_6'");
while( $robbwss = mysql_fetch_assoc($queewqd) ){
	
	$del_id = $robbwss['id'];
	
	if($del_id != ''){
		$querdel="DELETE FROM client_bandwidth WHERE id = '$del_id'";
		$resdel = mysql_query($querdel) or die("inser_query failed: " . mysql_error() . "<br />");
	}
} */
?>
