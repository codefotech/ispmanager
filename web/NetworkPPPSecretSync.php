<?php
include("conn/connection.php") ;
include("mk_api.php");
$ids = isset($_GET['ids']) ? $_GET['ids']  : '';
$mk_id = isset($_GET['mk_id']) ? $_GET['mk_id']  : '';
if($ids = 'auto'){
	$sync_by = 'Auto';
	$restor_clients = 'No';
	$sts_sync = 'Yes';
	$mac_sync = 'Yes';
	$ip_sync = 'Yes';
	$pack_sync = 'Yes';
	$pass_sync = 'Yes';
	$mk_id = $mk_id;
	$wayyyyy = 'auto';
	}
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
$sync_date = date('Y-m-d', time());
$sync_time = date('H:i:s', time());
$last_synced = date('Y-m-d H:i:s', time());

$sqlmklog = mysql_query("SELECT `job_id` FROM `network_sync_log` ORDER BY `job_id` DESC LIMIT 1");
$rowmklog = mysql_fetch_assoc($sqlmklog);
$job_id = $rowmklog['job_id']+1;

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;

						if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
							if($restor_clients == 'Yes'){
								$sql442 = mysql_query("SELECT c.c_name, c.c_id, p.mk_profile, c.breseller, c.p_id, p.p_name, p.bandwith, c.address, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.ip, c.mac, l.log_sts, l.pw FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												WHERE c.mk_id = '$mk_id' AND c.sts = '0' ORDER BY c.id DESC");
							while( $rows1w = mysql_fetch_assoc($sql442) ){

								$client_id = $rows1w['c_id'];
								$passssss = $rows1w['pw'];
								$mk_pac = $rows1w['mk_profile'];
								
								$API->write('/ppp/secret/print', false);
								$API->write('?name='.$client_id);
								$res=$API->read(true);

								$ppp_name = $res[0]['name']; 
								if($ppp_name == ''){
									$API->comm("/ppp/secret/add", array(
									  "name"     => $client_id,
									  "password" => $passssss,
									  "profile"  => $mk_pac,
									  "service"  => 'pppoe',
									));
									
								if($rows1w['con_sts'] == 'Inactive'){
								$arrIDD =	$API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $client_id,));
											$API->comm("/ppp/secret/set", array(".id" => $arrIDD[0][".id"],"disabled"  => "yes",));
								}
								else{}
								
								$query1f11 = "insert into network_sync_log (c_id, job_id, action, sync_date, sync_time, mk_id, sync_by, sync_name) VALUES ('$client_id', '$job_id', 'Add User in Mikrotik', '$sync_date', '$sync_time', '$mk_id', '$sync_by', 'restor_clients')";
								$result1aaq = mysql_query($query1f11) or die("inser_query failed: " . mysql_error() . "<br />");
								}
							} 
							}
								$arrID = $API->comm('/ppp/secret/getall');
								foreach($arrID as $x => $x_value) {
									
									$aaaaa = $x_value['name'];
									$mk_mac = $x_value['caller-id'];
									$sql44 = mysql_query("SELECT c.c_name, c.c_id, c.payment_deadline, m.Name, p.mk_profile, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, z.z_id, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.ip, c.mac, l.log_sts, l.pw FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												WHERE c.c_id = '$aaaaa' AND c.mk_id = '$mk_id' AND l.user_type = 'client' ORDER BY c.id DESC");
									$rows1 = mysql_fetch_assoc($sql44);

									if($rows1['c_name'] != ''){
											
											$fghgdh = $rows1['c_id'];
											$sqlc1 = mysql_query("SELECT e_id FROM login WHERE user_id = '$fghgdh'");
											$rowc1 = mysql_fetch_assoc($sqlc1);
											$log_id = $rowc1['e_id'];
											$passs = sha1($x_value['password']);
											
											if($log_id == ''){
												$query=mysql_query("SELECT e_id FROM zone WHERE z_id = '{$rows1['z_id']}'");
												$row2ff = mysql_fetch_assoc($query);
												$e_id = $row2ff['e_id'];
																								
												if($e_id == ''){
													$query1fff = "insert into login (user_name, e_id, user_id, password, user_type, pw) VALUES ('{$rows1['c_name']}', '$fghgdh', '$fghgdh', '$passs', 'client', '{$x_value['password']}')";
													$result1aa = mysql_query($query1fff) or die("inser_query failed: " . mysql_error() . "<br />");
													}
													else{
													$query1fff = "insert into login (user_name, e_id, user_id, password, user_type, pw, log_sts) VALUES ('{$rows1['c_name']}', '$fghgdh', '$fghgdh', '$passs', 'client', '{$x_value['password']}', '1')";
													$result1aa = mysql_query($query1fff) or die("inser_query failed: " . mysql_error() . "<br />");
													}
											}
											
											if($sts_sync == 'Yes'){
											if($x_value['profile'] == 'Inactive'){
												$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $aaaaa,));
														 $API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => $rows1['mk_profile']));
											}
											
											if($x_value['disabled'] == 'false' && $rows1['con_sts'] == 'Inactive'){
												$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $aaaaa,));
														 $API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
														
												$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $aaaaa,));
														 $API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
														
											$query1f11 = "insert into network_sync_log (c_id, job_id, mk_con_sts, ap_con_sts, action, sync_date, sync_time, mk_id, sync_by, sync_name) VALUES ('$aaaaa', '$job_id', 'Active', 'Inactive', 'Inactive in Mikrotik', '$sync_date', '$sync_time', '$mk_id', '$sync_by', 'con_sts')";
											$result1aaq = mysql_query($query1f11) or die("inser_query failed: " . mysql_error() . "<br />");
											}

											if($x_value['disabled'] == 'true' && $rows1['con_sts'] == 'Active'){
												$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $aaaaa,));
														 $API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "no",));
															
											$query1f11 = "insert into network_sync_log (c_id, job_id, mk_con_sts, ap_con_sts, action, sync_date, sync_time, mk_id, sync_by, sync_name) VALUES ('$aaaaa', '$job_id', 'Inactive', 'Active', 'Active in Mikrotik', '$sync_date', '$sync_time', '$mk_id', '$sync_by', 'con_sts')";
											$result1aaq = mysql_query($query1f11) or die("inser_query failed: " . mysql_error() . "<br />");
											}
											}

											if($pack_sync == 'Yes'){
											if($x_value['profile'] != $rows1['mk_profile']){
												$mk_package = $x_value['profile'];
												$ap_package = $rows1['mk_profile'];
												$sync_action_pack = 'Change package from ['.$mk_package.'] to ['.$ap_package.'] in Mikrotik';
												
												$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $aaaaa,));
														 $API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => $rows1['mk_profile']));

											$query1f11 = "insert into network_sync_log (c_id, job_id, mk_package, ap_package, action, sync_date, sync_time, mk_id, sync_by, sync_name) VALUES ('$aaaaa', '$job_id', '$mk_package', '$ap_package', '$sync_action_pack', '$sync_date', '$sync_time', '$mk_id', '$sync_by', 'package')";
											$result1aaq = mysql_query($query1f11) or die("inser_query failed: " . mysql_error() . "<br />");
											}
											}
												
											if($ip_sync == 'Yes'){
											if($x_value['remote-address'] != $rows1['ip']){
												$mk_ip = $x_value['remote-address'];
												$ap_ip = $rows1['ip'];
												$sync_action_ip = 'Change ip from ['.$ap_ip.'] to ['.$mk_ip.'] in Application';
												
													$queryfghh="UPDATE clients SET ip = '{$x_value['remote-address']}' WHERE c_id = '{$fghgdh}'";
													$resultger = mysql_query($queryfghh) or die("inser_query failed: " . mysql_error() . "<br />");
													
											$query1f11 = "insert into network_sync_log (c_id, job_id, mk_ip, ap_ip, action, sync_date, sync_time, mk_id, sync_by, sync_name) VALUES ('$aaaaa', '$job_id', '$mk_ip', '$ap_ip', '$sync_action_ip', '$sync_date', '$sync_time', '$mk_id', '$sync_by', 'ip')";
											$result1aaq = mysql_query($query1f11) or die("inser_query failed: " . mysql_error() . "<br />");
											}
											}
												
												
											if($mac_sync == 'Yes'){
											if($mk_mac != $rows1['mac']){
												$ap_mac = $rows1['mac'];
												$sync_action_mac = 'Change MAC from ['.$ap_mac.'] to ['.$mk_mac.'] in Application';
												
													$queryfghhm="UPDATE clients SET mac = '{$mk_mac}' WHERE c_id = '{$fghgdh}'";
													$resultger = mysql_query($queryfghhm) or die("inser_query failed: " . mysql_error() . "<br />");
													
											$query1f11 = "insert into network_sync_log (c_id, job_id, mk_mac, ap_mac, action, sync_date, sync_time, mk_id, sync_by, sync_name) VALUES ('$aaaaa', '$job_id', '$mk_mac', '$ap_mac', '$sync_action_mac', '$sync_date', '$sync_time', '$mk_id', '$sync_by', 'mac')";
											$result1aaq = mysql_query($query1f11) or die("inser_query failed: " . mysql_error() . "<br />");
											}
											}
												
											if($pass_sync == 'Yes'){
											if($x_value['password'] != $rows1['pw']){
												$mk_pass = $x_value['password'];
												$sync_action_pass = 'Set password ['.$mk_pass.'] in Application';
												
													$queryfghhm="UPDATE login SET pw = '{$x_value['password']}', password = '$passs' WHERE e_id = '{$fghgdh}' AND user_type = 'client'";
													$resultger = mysql_query($queryfghhm) or die("inser_query failed: " . mysql_error() . "<br />");
													
											$query1f11 = "insert into network_sync_log (c_id, job_id, password, action, sync_date, sync_time, mk_id, sync_by, sync_name) VALUES ('$aaaaa', '$job_id', '$mk_pass', '$sync_action_pass', '$sync_date', '$sync_time', '$mk_id', '$sync_by', password)";
											$result1aaq = mysql_query($query1f11) or die("inser_query failed: " . mysql_error() . "<br />");
												}
											}
									}
									}

if($wayyyyy == 'auto'){ echo $last_synced;} else{ ?>
<html>
<body>
     <form action="NetworkSyncLog" method="post" name="ok">
       <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
       <input type="hidden" name="sts" value="sync_done">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php
									}
						}
						else{echo 'Selected Network are not Connected.';}
?>

