<?php
include("conn/connection.php");
include("mk_api.php");	
date_default_timezone_set('Etc/GMT-6');
$right_now = date('Y-m-d H:i:s', time());
$mk_id = $_GET['mk_id'];

$onlinepayyy = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(session_id SEPARATOR ',') AS session_id FROM client_bandwidth"));
$session_id_arry = explode(',',$onlinepayyy['session_id']);

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
						foreach($arrID as $x => $x_value) {
							
							$aaaaa = $x_value['name'];
							
							$session_uptime = $x_value['uptime'];
							$session_ip = $x_value['address'];
							$session_mac = $x_value['caller-id'];
							$session_uptime_day = substr($session_uptime, 0, 2);
								
							$sql44 = mysql_query("SELECT c_id, c_name FROM clients WHERE c_id = '$aaaaa'");
							$rows1 = mysql_fetch_assoc($sql44);
							$c_id = $rows1['c_id'];
							
							echo $session_uptime_day;
							
							if($rows1['c_name'] != ''){
								$API->write('/interface/print',false);
								$API->write('=from=<pppoe-'.$c_id.'>',false);
								$API->write('=stats-detail');
								$ressi=$API->read(true);
								
								$int_tx = $ressi[0]['tx-byte'];
								$int_rx = $ressi[0]['rx-byte'];
								$session_id = $ressi[0]['.id'];
						
								if($session_uptime_day == '1d'){
									$arrID1 = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
									$API->comm("/ppp/active/remove", array(".id" => $arrID1[0][".id"],));
								}
						
							}
						}
						$API->disconnect();
				}
?>
