<?php
$titel = "Client";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");

$type = isset($_GET['id']) ? $_GET['id'] : '';
$zone_id = isset($_GET['zid']) ? $_GET['zid'] : '';
$box_id = isset($_GET['boxid']) ? $_GET['boxid'] : '';
$RealtimeStatus = isset($_GET['RealtimeStatus']) ? $_GET['RealtimeStatus'] : '';
$loadsts = isset($_POST['loadsts']) ? $_POST['loadsts'] : '';
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());
$current_date_time = date('Y-m-d H:i:s', time());

if($minimize_data_load == '0'){
	$loadval = 'yes';
	$bttn_icon = 'iconfa-resize-small';
	$load_titel = 'Minimize Data Loading';
	$load_class = 'ownbtn8';
}
else{
	$loadval = 'no';
	$bttn_icon = 'iconfa-resize-full';
	$load_titel = 'Maximize Data Loading';
	$load_class = 'ownbtn2';
}

$API = new routeros_api();
$API->debug = false;

$sql34 = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND online_sts = '0'");
$tot_mk = mysql_num_rows($sql34);

if($client_onlineclient_sts == '1' && $user_type == 'mreseller' || $client_onlineclient_sts == '1' && $type != ''){
$items = array();
$itemss = array();
$itemss_uptime[] = array();
$itemss_address[] = array();
$itemss_mac[] = array();
while ($roww = mysql_fetch_assoc($sql34)) {
		$maikro_id = $roww['id'];
		$maikro_Name = $roww['Name'];
		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
				$arrID = $API->comm('/ppp/active/getall');
					foreach($arrID as $xx => $x_value) {
						$items[] = $x_value['name'];
						$itemss_uptime[$x_value['name']] = $x_value['uptime'];
						$itemss_address[$x_value['name']] = $x_value['address'];
						$itemss_mac[$x_value['name']] = $x_value['caller-id'];
					}
				
				if($active_queue == '1'){
				$arrIDD = $API->comm('/ip/arp/getall');
					foreach($arrIDD as $xx => $x_valuee) {
							$clip = $x_valuee['address'];
							$macsearch = mysql_query("SELECT c_id FROM clients WHERE ip = '$clip'");
							$macsearchaa = mysql_fetch_assoc($macsearch);	
							if($macsearchaa['c_id'] != ''){
								$itemss[] = $macsearchaa['c_id'];
								$itemss_uptime[] = array();
								$itemss_address[$macsearchaa['c_id']] = $x_valuee['address'];
								$itemss_mac[$macsearchaa['c_id']] = $x_valuee['mac-address'];
							}
					}
				}
				else{
					$itemss = array();
					$itemss_uptime[] = array();
					$itemss_address[] = array();
					$itemss_mac[] = array();
				}
			
			$API->disconnect();
			$errorrrrr_style = '';
			$errorrrrr_msg = '';
			$mk_offlinecounter = 0;
		}
		else{
			$query12312rr ="UPDATE mk_con SET online_sts = '1' WHERE id = '$maikro_id'";
			$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error() . "<br />");
			
			$errorrrrr_style = 'style="font-size: 14px;"';
			$errorrrrr_msg = $maikro_Name.' ('.$ServerIP1.') are Disconnected.<br>';
			$mk_offlinecounter = 1;
		}
			$mk_offlinecounterr += $mk_offlinecounter;
}

$itemss1 = array_merge($itemss, $items);
$total_active_connection = key(array_slice($itemss1, -1, 1, true))+1;
$queryss = "INSERT INTO mk_active_count (total_active) VALUES ('$total_active_connection')";
$sqssl = mysql_query($queryss) or die("Error" . mysql_error());
$padddding = 'style="padding: 5px 0px;"';

		if($tot_mk == $mk_offlinecounterr){
			$query12312 ="update app_config set onlineclient_sts = '0'";
			$resuldfsdt = mysql_query($query12312) or die("inser_query failed: " . mysql_error() . "<br />");
		}
}
else{
$padddding = 'style="padding: 15px 0px;"';
}

if($userr_typ == 'mreseller'){
$sqlass = mysql_query("SELECT DATE_FORMAT(c.join_date,'%d-%m') AS dat, COUNT(c.c_id) AS total FROM clients AS c
WHERE c.join_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND c.sts = '0' AND c.z_id = '$macz_id' AND c.mac_user = '1'
GROUP BY c.join_date");

$myurl[]="['dat','total']";
while($r=mysql_fetch_assoc($sqlass)){
	
	$Item = $r['dat'];
	$Total = $r['total'];
	$myurl[]="['".$Item."',".$Total."]";
}}

else{
if($user_type == 'billing'){
	$sqlass = mysql_query("SELECT DATE_FORMAT(c.join_date,'%b-%y') AS dat, COUNT(c.c_id) AS total FROM clients AS c
LEFT JOIN zone AS z ON z.z_id = c.z_id
WHERE c.join_date >= DATE_SUB(DATE_ADD(subdate(curdate(), (day(curdate())-1)), INTERVAL 1 MONTH),INTERVAL 12 MONTH) AND c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 GROUP BY MONTH(c.join_date), YEAR(c.join_date) ORDER BY c.join_date");


$sql3 = mysql_query("SELECT DATE_FORMAT(s.update_date,'%d %b') AS dat3, COUNT(s.c_id) AS total3 FROM con_sts_log AS s
LEFT JOIN clients AS c ON c.c_id = s.c_id
LEFT JOIN zone AS z ON z.z_id = c.z_id
WHERE s.update_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND s.update_by = 'Auto' AND c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 GROUP BY s.update_date");

$queryxxrrrw = mysql_query("SELECT CONCAT(z.z_name,' - ',z.z_bn_name) AS Territory, count(c.c_id) AS Total FROM zone AS z
								LEFT JOIN clients AS c ON c.z_id = z.z_id
								WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0
								GROUP BY z.z_id");
	
$titd = 'Zone All Clients';
}
else{
	$sqlass = mysql_query("SELECT DATE_FORMAT(c.join_date,'%b-%y') AS dat, COUNT(c.c_id) AS total FROM clients AS c
WHERE c.join_date >= DATE_SUB(DATE_ADD(subdate(curdate(), (day(curdate())-1)), INTERVAL 1 MONTH),INTERVAL 12 MONTH) AND c.sts = '0' GROUP BY MONTH(c.join_date), YEAR(c.join_date) ORDER BY c.join_date");

$sql3 = mysql_query("SELECT DATE_FORMAT(update_date,'%d %b') AS dat3, COUNT(c_id) AS total3 FROM con_sts_log
WHERE update_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND update_by = 'Auto' GROUP BY update_date");

$queryxxrrrw = mysql_query("SELECT CONCAT(z.z_name,' - ',z.z_bn_name) AS Territory, count(c.c_id) AS Total FROM zone AS z
								LEFT JOIN clients AS c ON c.z_id = z.z_id
								WHERE c.sts = '0'
								GROUP BY z.z_id");
	
$titd = 'Zone All Clients';
}

$myurl[]="['dat','New']";
while($r=mysql_fetch_assoc($sqlass)){
	
	$Item = $r['dat'];
	$Total = $r['total'];
	$myurl[]="['".$Item."',".$Total."]";
}

$myurl3[]="['dat3','total3']";
while($r3=mysql_fetch_assoc($sql3)){
	
	$Item3 = $r3['dat3'];
	$Total3 = $r3['total3'];
	$myurl3[]="['".$Item3."',".$Total3."]";
}

$myurl4[]="['Territory','Total']";
while($r4=mysql_fetch_assoc($queryxxrrrw)){
	
	$Item = $r4['Territory'];
	$Total = $r4['Total'];
	$myurl4[]="['".$Item."',".$Total."]";
}	
if($user_type == 'billing'){
$queryff="SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name";
}
else{
if($search_with_reseller_client == '1'){
$queryff="SELECT * FROM zone WHERE status = '0' order by z_name";
}
else{
$queryff="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
}
$resultff=mysql_query($queryff);
}

if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'billing' || $user_type == 'support_manager' || $user_type == 'ets'){
						if($type == 'all' && in_array(114, $access_arry)){
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND c.mac_user !='1' AND c.breseller != '2'";
											
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											$allclients .= " ORDER BY c.id DESC";
							
							if($user_type == 'billing'){
								$allactiveclient= "SELECT c.c_id FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 AND c.con_sts = 'Active' AND c.mac_user !='1' AND c.breseller != '2'";
								
											if($box_id != ''){
												$allactiveclient .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allactiveclient .= " AND c.z_id = '{$zone_id}'";
											}
								
								$sqls = mysql_query($allactiveclient);

								$allinactiveclient= "SELECT c_id FROM clients AS c LEFT JOIN login AS l ON l.e_id = c.c_id LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 AND l.log_sts = '1' AND mac_user !='1' AND c.breseller != '2'";
								
											if($box_id != ''){
												$allinactiveclient .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allinactiveclient .= " AND c.z_id = '{$zone_id}'";
											}

								$sqlss = mysql_query($allinactiveclient);
							}
							else{
								$allactiveclient= "SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user !='1'";
								if($box_id != ''){
												$allactiveclient .= " AND box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allactiveclient .= " AND z_id = '{$zone_id}'";
											}
								$sqls = mysql_query($allactiveclient);
								
								$allinactiveclient= "SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1' AND c.mac_user !='1'";
								
											if($box_id != ''){
												$allinactiveclient .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allinactiveclient .= " AND c.z_id = '{$zone_id}'";
											}

								$sqlss = mysql_query($allinactiveclient);
							}
						}
							
						if($type == 'invoice' && in_array(249, $access_arry)){
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND c.mac_user !='1' AND c.breseller = '2'";
											
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											$allclients .= " ORDER BY c.id DESC";

						if($user_type == 'billing'){
								$allactiveclient= "SELECT c.c_id FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 AND c.con_sts = 'Active' AND c.mac_user !='1' AND c.breseller == '2'";
								
											if($box_id != ''){
												$allactiveclient .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allactiveclient .= " AND c.z_id = '{$zone_id}'";
											}
								
								$sqls = mysql_query($allactiveclient);

								$allinactiveclient= "SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 AND l.log_sts = '1' AND mac_user !='1' AND c.breseller == '2'";
								
											if($box_id != ''){
												$allinactiveclient .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allinactiveclient .= " AND c.z_id = '{$zone_id}'";
											}

								$sqlss = mysql_query($allinactiveclient);
							}
							else{
								$allactiveclient= "SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user !='1' AND breseller = '2'";
								if($box_id != ''){
												$allactiveclient .= " AND box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allactiveclient .= " AND z_id = '{$zone_id}'";
											}
								$sqls = mysql_query($allactiveclient);
								
								$allinactiveclient= "SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1' AND c.mac_user !='1' AND c.breseller = '2'";
								
											if($box_id != ''){
												$allinactiveclient .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allinactiveclient .= " AND c.z_id = '{$zone_id}'";
											}

								$sqlss = mysql_query($allinactiveclient);
							}
						}
						if($type == 'macclient' && in_array(115, $access_arry)){
							$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by e.e_name");
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND c.mac_user ='1'";
											
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											
											$allclients .= " ORDER BY c.id DESC";
							
							$sgthj = "SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user ='1'";
									if ($zone_id != ''){
										$sgthj .= " AND z_id = '{$zone_id}'";
									}
							$sqls = mysql_query($sgthj);
							
							$sgtzczhj = "SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1' AND c.mac_user = '1'";
									if ($zone_id != ''){
										$sgthj .= " AND z_id = '{$zone_id}'";
									}
							$sqlss = mysql_query($sgtzczhj);
						}
						
						if($type == 'active' && in_array(112, $access_arry)){
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND c.mac_user !='1' AND c.breseller != '2' AND c.con_sts = 'Active'";
											 
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											$allclients .= " ORDER BY c.id DESC";
							
							$sqldd = mysql_query($allclients);
							$actt = mysql_num_rows($sqldd);
						}
						
						if($type == 'inactive' && in_array(113, $access_arry)){
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND c.mac_user !='1' AND c.breseller != '2' AND c.con_sts = 'Inactive'";
											 
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											$allclients .= " ORDER BY c.con_sts_date DESC";
							
							$sqldd = mysql_query($allclients);
							$inactt = mysql_num_rows($sqldd);
						}
						
						if($type == 'lock' && in_array(117, $access_arry)){
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												LEFT JOIN login AS l ON l.e_id = c.c_id";
												
												$allclients .= " WHERE c.sts = '0' AND l.log_sts = '1' AND c.mac_user !='1' AND c.breseller != '2'";
											 
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											
											$allclients .= " ORDER BY c.id DESC";
							
							$sqldd = mysql_query($allclients);
							$loccc = mysql_num_rows($sqldd);
						}
						
						if($type == 'auto' && in_array(116, $access_arry)){
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND c.mac_user !='1' AND c.auto_sts = '1'";
											 
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											$allclients .= " ORDER BY c.auto_inactive_date_time DESC";
							
							$sqldddd = mysql_query($allclients);
							$autoooo = mysql_num_rows($sqldddd);
						}
						
						if($type == 'new'){
							$allclients = "SELECT *, m.id as mk_id, c.z_id as zoneiddd FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND MONTH(c.join_date) = MONTH('$dateTimeee') AND YEAR(c.join_date) = YEAR('$dateTimeee') AND c.mac_user !='1'";
											 
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											$allclients .= " ORDER BY c.id DESC";
							
							$sqldddddd = mysql_query($allclients);
							$newww = mysql_num_rows($sqldddddd);
						}
						
						if($type == 'left' && in_array(118, $access_arry)){
							$allclients = "SELECT c.c_name, c.z_id as zoneiddd, c.com_id, c.onu_mac, c.termination_date, b.b_name, c.b_date, c.c_id, c.mk_id, c.payment_deadline, c.raw_download, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, q.e_name AS delete_by, DATE_FORMAT(c.delete_date_time, '%D %M, %Y %r') AS delete_date_time, c.delete_date_time AS delete_datetime FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												LEFT JOIN emp_info AS q ON q.e_id = c.delete_by";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '1'";
											 
											if ($user_type == 'billing'){
												$allclients .= " AND FIND_IN_SET('$e_id', z.emp_id) > 0";
											}
											if($box_id != ''){
												$allclients .= " AND c.box_id = '{$box_id}'";
											}
											if($zone_id != ''){
												$allclients .= " AND c.z_id = '{$zone_id}'";
											}
											$allclients .= " ORDER BY c.delete_date_time DESC";
							
							$sqdedd = mysql_query($allclients);
							$deltttt = mysql_num_rows($sqdedd);
						}
						if($type != ''){
							$sql = mysql_query($allclients);
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$loc = mysql_num_rows($sqlss);
							$inact = $tot - $act;
						}
							
						if($type == 'macclient'){
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
						}
						elseif($type == 'active'){
							$tit = "<div class='box-header'>
										<div class='hil'>Total Active:  <i style='color: #30ad23;'>{$actt}</i></div> 
									</div>";
						}
						elseif($type == 'inactive'){
							$tit = "<div class='box-header'>
										<div class='hil'>Total Inactive:  <i style='color: #e3052e;'>{$inactt}</i></div> 
									</div>";
						}
						elseif($type == 'lock'){
							$tit = "<div class='box-header'>
										<div class='hil'> Total Locked: <i style='color: #f66305'>{$loccc}</i></div>
									</div>";
						}
						elseif($type == 'auto'){
							$tit = "<div class='box-header'>
										<div class='hil'> Auto Inactive Clients for Dues: <i style='color: #f66305'>{$autoooo}</i></div>
									</div>";
						}
						elseif($type == 'new'){
							$tit = "<div class='box-header'>
										<div class='hil'> New Clients On This Month: <i style='color: #317EAC'>{$newww}</i></div>
									</div>";
						}
						elseif($type == 'left'){
							$tit = "<div class='box-header'>
										<div class='hil'> Total Left Clients: <i style='color: #f66305'>{$deltttt}</i></div>
									</div>";
						}
						else{
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
										<div class='hil'> Lock: <i style='color: #f66305'>{$loc}</i></div>
									</div>";
						}
							
}

if($userr_typ == 'mreseller'){
							if($type == '' || $type == 'all' || $type == 'recharge'){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, l.pw, c.termination_date, b.b_name AS z_name, c.mk_id, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												 LEFT JOIN login AS l ON l.e_id = c.c_id
												WHERE c.sts = '0' AND z.z_id = '$macz_id' ORDER BY c.id DESC");
							$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND z_id = '$macz_id'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'active'){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, l.pw, c.termination_date, c.mk_id, b.b_name AS z_name, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												 LEFT JOIN login AS l ON l.e_id = c.c_id
												WHERE c.sts = '0' AND c.con_sts = 'Active' AND z.z_id = '$macz_id' ORDER BY c.id DESC");
							$tot = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> Total Active Clients:  <i style='color: #30ad23'>{$tot}</i></div>
									</div>";
							}
							if($type == 'inactive'){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, l.pw, c.termination_date, c.mk_id, b.b_name AS z_name, c.c_id, c.b_date, c.payment_deadline, c.raw_download, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												 LEFT JOIN login AS l ON l.e_id = c.c_id
												WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND z.z_id = '$macz_id' ORDER BY c.id DESC");
							$inact = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> Total Inactive Clients: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'left'){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, l.pw, c.termination_date, b.b_name AS z_name, c.b_date, c.mk_id, c.c_id, c.payment_deadline, c.raw_download, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, q.e_name AS delete_by, DATE_FORMAT(c.delete_date_time, '%D %M, %Y %r') AS delete_date_time, c.delete_date_time AS delete_datetime FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												LEFT JOIN emp_info AS q ON q.e_id = c.delete_by
												 LEFT JOIN login AS l ON l.e_id = c.c_id
												WHERE c.sts = '1' AND mac_user ='1' AND c.z_id = '$macz_id' ORDER BY c.delete_date_time DESC");
							$inact = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> Total Left Clients: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'new'){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, l.pw, c.termination_date, c.c_id, c.b_date, c.mk_id, c.payment_deadline, m.Name, c.breseller, c.mac_user, c.p_id, p.p_name, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, c.auto_inactive_date_time FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												 LEFT JOIN login AS l ON l.e_id = c.c_id
												WHERE c.sts = '0' AND MONTH(c.join_date) = MONTH('$dateTimeee') AND YEAR(c.join_date) = YEAR('$dateTimeee') AND c.mac_user ='1' AND c.z_id = '$macz_id' ORDER BY c.id DESC");
							$newclients = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> This Month New Clients: <i style='color: #f66305'>{$newclients}</i></div>
									</div>";
							}
							if($type == 'auto'){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, l.pw, c.termination_date, c.c_id, c.b_date, c.mk_id, c.payment_deadline, m.Name, c.breseller, c.mac_user, c.p_id, p.p_name, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, c.auto_inactive_date_time FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN con_sts_log AS l ON l.c_id = c.c_id
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												 LEFT JOIN login AS l ON l.e_id = c.c_id
												WHERE l.update_by = 'Auto' AND l.con_sts = 'Inactive' AND l.update_date = '$dateTimeee' AND c.con_sts != 'Active' AND c.z_id = '$macz_id' ORDER BY c.auto_inactive_date_time DESC LIMIT 2000");
							$auto_inactive_count = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> Auto Inactive Clients: <i style='color: #f66305'>{$auto_inactive_count}</i></div>
									</div>";
							}
$sqlqqmm = mysql_query("SELECT minimum_day, minimum_days, minimum_sts, terminate FROM emp_info WHERE z_id = '$macz_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);

$minimum_days = $row22m['minimum_days'];
$minimum_sts = $row22m['minimum_sts'];

if($minimum_sts != '1' && $minimum_days != ''){
	$minimum_days_array = explode(',',$minimum_days);
	$trimSpaces = array_map('trim',$minimum_days_array);
	asort($trimSpaces);
	$minimum_days_arrays = implode(',',$trimSpaces);
	$minimum_arraydd =  explode(',', $minimum_days_arrays);
	$minimum_day = min(explode(',', $minimum_days_arrays));
}
else{
	$minimum_day = $row22m['minimum_day'];
}
}

$result=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
$result1=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");


?>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="MACClientAdd1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">MacReseller Area</h5>
				</div>
				<div class="modal-body">
					<div class="row" style="height: 300px;">
						<div class="popdiv">
							<div class="col-1">Mac Area </div>
							<div class="col-2"> 
								<select data-placeholder="Choose Area" name="z_id" class="chzn-select"  style="width:280px;" onchange="submit();">
									<option value=""></option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['resellername']; ?>)</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal3345">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Real Time Bandwith</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
								<div id='Pointdiv3yyyy'></div>
						</div>
					</div>
				</div>
			</div>
		</div>	
</div><!--#myModal-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal3345s">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Last Loged Out</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
								<div id='Pointdiv3yyyyd'></div>
						</div>
					</div>
				</div>
			</div>
		</div>	
</div><!--#myModal-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal11">
	<div id='Pointdiv2'></div>
</div>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal345345">
	<div id='Pointdiv1'></div>
</div><!--#myModal-->

	<div class="pageheader">
		<div class="searchbar" style="margin-right: 10px;">
		<?php if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $userr_typ == 'mreseller' || $user_type == 'accounts' || $user_type == 'billing' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets'){ ?>
			<?php if($type == 'macclient' && $zone_id != '' && $client_onlineclient_sts == '0'){ ?>
				<a class="btn" href="MacResellerActiveClients?id=<?php echo $zone_id;?>" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #b70505;color: #b70505;font-size: 14px;" title="Active Connection">Current Status</a>
			<?php } if($userr_typ == 'mreseller'){ if($aaaa > $over_due_balance && $billing_typee == 'Prepaid' || $billing_typee == 'Postpaid'){ if($limit_accs == 'Yes'){ if($type == 'recharge'){ if($minimum_sts == '2' && $minimum_days_arrays != ''){ ?>
				<select name="duration" id="duration" style="width: 55px;font-weight: bold;font-size: 16px;height: 30px;text-align: center;border: 1px solid red;border-radius: 3px;padding: 0;color: red;" placeholder="<?php echo $minimum_day;?>" required="">
					<?php foreach ($minimum_arraydd as $item) { 
							echo "<option value='$item'>$item</option>";
						}?>
				</select>
				<?php } else{ ?>
				<input type="text" name="duration" id="duration" value="<?php echo $minimum_day;?>" style="border: 1px solid #f00;color: #f00;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;border-radius: 3px;width: 45px;font-weight: bold;font-size: 18px;height: 12px;" placeholder="Days" class="surch_emp" required=""/>
			<?php }} else{ ?>
				<a class="btn" href="Clients?id=recharge" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #c60a0a;color: #c60a0a;font-size: 14px;" title="Recharge">Recharge</a>
			<?php } ?> 
				<a class="btn" href="MACClientAdd1" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 14px;" title="Add New PPPoE Client">Add</a>
			<?php if($client_onlineclient_sts == '0'){ ?>
				<a class="btn" href="MacResellerActiveClients" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #b70505;color: #b70505;font-size: 14px;" title="Active Connection">Current Status</a>
			<?php }} else{ ?> 
				<a style='font-size: 15px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[Contact Admin]</a>			
			<?php } }?>
			<?php }	else{  if($limit_accs == 'Yes'){ ?>
				<div class="input-append">
					<div class="btn-group">
						<?php if(in_array(110, $access_arry) || in_array(111, $access_arry)){?>
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 14px;" title="Add New PPPoE or Static or Reseller Client">Add <span class="caret" style="border-top: 4px solid #0866c6;"></span></button>
						<ul class="dropdown-menu" style="min-width: 115px;border-radius: 0px 0px 5px 5px;">
						<?php if(in_array(110, $access_arry)){?>
							<li><a href="ClientAdd" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Add New PPPoE Client">PPPoE</a></li>
							<li><a href="BResellerAdd" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ac3131c4;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Queue Client">Static IP</a></li>
						<?php } if(in_array(247, $access_arry)){ ?>
							<li><a href="ClientAddInvoice" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Invoice Client">Invoice Client</a></li>
						<?php } if(in_array(111, $access_arry)){ ?>
							<li><a href="#myModal" data-toggle="modal" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: green;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Mac Reseller Client">Reseller MAC</a></li>
						<?php } ?> 
						</ul>
						<?php } ?> 
					</div>
				</div>
			<?php } else{ ?> 
				<a style='font-size: 15px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[User Limit Exceeded]</a>
			<?php }} if($online_btn_off == '1' && $tot_mk > '0' && $user_type != 'mreseller' && $zone_id == ''){ ?>
				<a class="btn" href="ClientsCurrentStatus" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #b70505;color: #b70505;font-size: 14px;" title="Active Connection">Current Status</a>
			<?php } ?> 
				<div class="input-append" style="margin-right: 2px;">
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid <?php if($type == ''){echo '#028795;color: #028795;';} elseif($type == 'all'){echo '#8b00ff;color: #8b00ff;';} elseif($type == 'left'){echo 'red;color: red;';} elseif($type == 'active'){echo 'GREEN;color: GREEN;';} elseif($type == 'inactive'){echo '#ff00a7;color: #ff00a7;';} elseif($type == 'lock'){echo '#716d6d;color: #716d6d;';} elseif($type == 'auto'){echo '#ea11d2;color: #ea11d2;';} elseif($type == 'invoice'){echo '#ff5400;color: #ff5400;';} elseif($type == 'recharge'){echo '#c60a0a;color: #c60a0a;';} else{echo '#097f71;color: #097f71;';}?>font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"><?php if($type == 'all'){ ?>All Clients<?php } elseif($type == ''){ echo 'Clients';} elseif($type == 'left'){ echo 'All Deleted Clients';} elseif($type == 'active'){ echo 'Active';} elseif($type == 'inactive'){ echo 'Inactive';} elseif($type == 'lock'){ echo 'Locked';} elseif($type == 'auto'){ echo 'Auto Inactive';} elseif($type == 'invoice'){ echo 'Invoice Clients';} elseif($type == 'recharge'){ echo 'Recharge';} else{ echo 'Reseller';}?> <span class="caret" style="border-top: 4px solid <?php if($type == 'all'){echo '#8b00ff';} elseif($type == ''){echo '#028795';} elseif($type == 'active'){echo 'GREEN';} elseif($type == 'left'){echo 'red';} elseif($type == 'inactive'){echo '#ff00a7';} elseif($type == 'lock'){echo '#716d6d';} elseif($type == 'auto'){echo '#ea11d2';} elseif($type == 'invoice'){echo '#ff5400';} elseif($type == 'recharge'){echo '#c60a0a';} else{echo '#097f71';}?>;"></span></button>
						<ul class="dropdown-menu" style="min-width: 95px;border-radius: 0px 0px 5px 5px;">
							<?php if(in_array(114, $access_arry)){ ?>
								<li <?php if($type == 'all'){echo 'style="display: none;"';}?>><a href="Clients?id=all" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #8b00ff;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Show All Clients List">All Clients</a></li>
							<?php } if(in_array(112, $access_arry)){ ?>
								<li <?php if($type == 'active'){echo 'style="display: none;"';}?>><a href="Clients?id=active" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: GREEN;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Active Clients List">Active</a></li>
							<?php } if(in_array(113, $access_arry)){ ?>
								<li <?php if($type == 'inactive'){echo 'style="display: none;"';}?>><a href="Clients?id=inactive" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ff00a7;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Inactive Clients List">Inactive</a></li>
							<?php } if(in_array(117, $access_arry)){?>
								<li <?php if($type == 'lock'){echo 'style="display: none;"';}?>><a href="Clients?id=lock" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #716d6d;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Locked Clients List">Locked </a></li>
							<?php } if(in_array(116, $access_arry)){ ?>
								<li <?php if($type == 'auto'){echo 'style="display: none;"';}?>><a href="Clients?id=auto" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ea11d2;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Deadline Wise Off Clients">Auto Inactive </a></li>
							<?php } if(in_array(249, $access_arry)){ ?>
								<li <?php if($type == 'invoice'){echo 'style="display: none;"';}?>><a href="Clients?id=invoice" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ff5400;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Invoice Clients">Invoice Clients </a></li>
							<?php } if(in_array(115, $access_arry) && $type != 'macclient'){ ?>
								<li <?php if($type == 'macclient'){echo 'style="display: none;"';}?>><a href="Clients?id=macclient" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #097f71;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Mac Reseller Clients">Reseller Clients </a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			<?php if(in_array(115, $access_arry) && ($type == 'macclient')){?>
						<form method="GET" action="Clients" style="float: left;margin-right: 4px;">
							<input type='hidden' name='id' value='<?php echo $_GET['id'];?>'/> 
							<select name="zid" style="border: 1px solid #317eac;color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 3px;" onchange="submit();">
									<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">All Reseller</option>
									<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
											<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['z_id']?>"<?php if ($row345['z_id'] == $zone_id) echo 'selected="selected"';?>><?php echo $row345['resellername']; ?> - <?php echo $row345['z_name'];?></option>
									<?php } ?>
							</select>
						</form>
			<?php } if(in_array(118, $access_arry)){?>
				<a href="Clients?id=left" class="btn btn-danger btn-circle" style="border: 1px solid red;float: right;padding: 5px 5px;font-size: 17px;" title="Recycle Bin"><i class="iconfa-trash" style="color: red;"></i></a>
			<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
				<a class="btn" style="border-radius: 3px;border: 1px solid #a0f;color: #a0f;padding: 5px 6px;font-size: 17px;float: right;margin-right: 2px;" href="ClientsDeadlineSet" title='Set Clients Deadline'><i class="iconfa-cogs"></i></a>
				<form action='ActionAdd' method='post' data-placement='top' data-rel='tooltip' title='<?php echo $load_titel;?>' style="float: right;padding-right: 2px;"><input type='hidden' name='typee' value='load_mini' /><input type='hidden' name='tis_id' value='<?php echo $tis_id;?>' /><input type='hidden' name='loadsts' value='<?php echo $loadval;?>' /><button class='btn <?php echo $load_class;?>' style='padding: 5px 8px;font-size: 17px;' onclick="return checkLoad()"><i class='<?php echo $bttn_icon;?>'></i></button></form>
			<?php } ?>
		<?php }} ?>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Clients</h1>
        </div>
    </div><!--pageheader-->
		<?php if($errorrrrr_msg != ''){?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong <?php echo $errorrrrr_style;?>><?php echo $maikro_Name .' ('. $ServerIP1.') are Disconnected';?></strong>
			</div><!--alert-->
		<?php } if('delete' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.
			</div><!--alert-->
		<?php } if('add' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
			</div><!--alert-->
		<?php } if('Lock0' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Locked in Your System.
			</div><!--alert-->
		<?php } if('Lock1' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Unlocked in Your System.
			</div><!--alert-->
		<?php } if('StatusActive' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Inactive in Your System.
			</div><!--alert-->
		<?php } if('StatusInactive' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Active in Your System.
			</div><!--alert-->
		<?php } if('StatusRechargeDone' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Recharged.
			</div><!--alert-->
		<?php } if('smssent' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Send The SMS.
			</div><!--alert-->
		<?php } if('trnsferdone' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Transfer [<?php echo $new_id;?>] To Reseller Account.
			</div><!--alert-->
		<?php } if('owntrnsferdone' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Transfer [<?php echo $new_id;?>] as Own Client.
			</div><!--alert-->
		<?php } if('edit' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.
			</div><!--alert-->
		<?php } if('return' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Client Successfully return in Your System.
			</div><!--alert-->
		<?php } if('yes' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Your Clients Data Has Been Minimized.
			</div><!--alert-->
		<?php } if('no' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Your Clients Data Has Been Maximized.
			</div><!--alert-->
		<?php } ?>
	
<?php if($type != '' || $userr_typ == 'mreseller'){?>
	<div class="box box-primary">
		<div class="box-header">
			<h5><?php echo $tit;?></h5>
		</div>
			<div class="box-body">
				<table id="dyntable2" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />												
						<col class="con0" />
						<col class="con1" />	
                    </colgroup>
                   <thead>
                        <tr  class="newThead">
						<?php if($minimize_data_load == '0'){ if($userr_typ == 'mreseller'){ ?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Pass/Cell</th>
							<th class="head1 center">Image</th>
							<th class="head0">Zone/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0 center">Termination Date</th>
							<th class="head1 center">Remaining</th>
							<?php if($type != 'recharge' && $client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head1 center">Status</th>
                            <th class="head0 center"></th>
						<?php } else{ if($type == 'macclient'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Pass/Cell</th>
							<th class="head1 center">Image</th>
							<th class="head0">Zone/Box/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0 center">Termination Date</th>
							<th class="head1 center">Remaining</th>
							<?php if($client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head1 center">Status</th>
                            <th class="head0 center"></th>
						<?php } elseif($type == 'auto'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Pass/Cell</th>
							<th class="head1 center">Image</th>
							<th class="head0">Zone/Box/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0">Inactive Date</th>
							<th class="head1">Deadline</th>
							<?php if($client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head1 center">Status</th>
                            <th class="head0 center"></th>
						<?php } else{?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Pass/Cell</th>
							<th class="head1 center">Image</th>
							<th class="head0">Zone/Box/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0">Deadline</th>
							<?php if($client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
						<?php }} } else{ ?>
						<?php if($user_type == 'mreseller'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head1 center">Image</th>
							<th class="head0">Zone/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0 center">Termination Date</th>
							<th class="head1 center">Remaining</th>
							<?php if($type != 'recharge' && $client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
						<?php } else{ if($type == 'macclient'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Zone/Box/Address/Onu</th>
							<th class="head0">Package/Joining Date</th>
							<th class="head1 center">Termination Date</th>
							<th class="head0 center">Remaining</th>
							<?php if($client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
						<?php } elseif($type == 'clientmksts'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Package/Joining Date</th>
							<th class="head1">Realtime Info</th>
							<th class="head1 center">Status</th>
                            <th class="head0 center"></th>
						<?php } elseif($type == 'auto'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Zone/Box/Address/Onu</th>
							<th class="head0">Package/Joining Date</th>
							<th class="head1">Inactive Date</th>
							<th class="head0">Deadline</th>
							<?php if($client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
						<?php } else{?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head0">Zone/Box/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0">Deadline</th>
							<?php if($client_onlineclient_sts == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
						<?php }}} ?>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$xkey = 100;
								$onlinecounter = 0;
								while( $row = mysql_fetch_assoc($sql) )
								{
									$yrdata1= strtotime($row['join_date']);
									$join_date = date('jS F Y', $yrdata1);
									
									$clientid = $row['c_id'];
									$mk_idsfsf = $row['mk_id'];
									if($client_onlineclient_sts == '1'){
									if(in_array($row['c_id'], $itemss1)){
										$clientactive = "<form href='#myModal3345' data-toggle='modal' title='Status'><button type='submit' value= '{$row['c_id']}&mk_id={$mk_idsfsf}' style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 13px;margin-top: 2px;padding: 3px 9px 3px;' class='btn' onClick='getRoutePointsp(this.value)'>Online</button></form>";
										$activecount = 1;
										$inactivecount = 0;
										$uptime_val = $itemss_uptime[$row['c_id']];
										$address_val = $itemss_address[$row['c_id']];
										$mac_val = $itemss_mac[$row['c_id']];
										
										if($mac_val != '' && $minimize_data_load == '0'){
											$ppp_mac_replace = str_replace(":","-",$mac_val);
											$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
												
											$macsearchaa = mysql_fetch_assoc(mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'"));
											$running_device = $macsearchaa['info'];
										}
										else{
											$running_device = '';
										}
										
										if($RealtimeStatus == 'Online'){
											$showw = "";
										}
										elseif($RealtimeStatus == 'Offline'){
											$showw = "style='display: none;'";
										}
										else{
											$showw = "";
										}
									}
									else{
//										$clientactive = "<button style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid red;color: red;font-size: 12px;margin-top: 2px;padding: 3px 8px 3px;' class='btn'>Offline</button>";
										$clientactive = "<form href='#myModal3345s' data-toggle='modal' title='Status'><button type='submit' value= '{$row['c_id']}&mk_id={$mk_idsfsf}&sts=offline' style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid red;color: red;font-size: 12px;margin-top: 2px;padding: 3px 8px 3px;' class='btn' onClick='getRoutePointspd(this.value)'>Offline</button></form>";
										$activecount = 0;
										$inactivecount = 1;
										$uptime_val = '';
										$address_val = '';
										$mac_val = '';
										$running_device = '';
										
										if($RealtimeStatus == 'Online'){
											$showw = "style='display: none;'";
										}
										elseif($RealtimeStatus == 'Offline'){
											$showw = "";
										}
										else{
											$showw = "";
										}
									}
									
									$activecountt += $activecount;
									$inactivecountt += $inactivecount;
									}
									else{
										$showw = "";
										$clientactive = "";
									}
									if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
										$collllr = 'border: 1px solid green;color: green;font-size: 13px;padding: 3px 10px 3px;';
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
										$collllr = 'border: 1px solid red;color: red;font-size: 12px;padding: 3px 5px 3px;';
									}
									if($minimize_data_load == '0'){
									if($row['log_sts'] == '0'){
										$aa = 'btn';
										$bb = "<i class='iconfa-unlock'></i>";
										$cc = 'Lock';
										$www = 'style="border-radius: 3px;border: 1px solid #236db3;color: #236db3;padding: 6px 9px;"';
										$www1 = "color: #236db3;";
									}
									else{
										$aa = 'btn';
										$bb = "<i class='iconfa-lock'></i>";
										$cc = 'Unlock';
										$www = 'style="border-radius: 3px;border: 1px solid #236db3;color: #f66305;padding: 6px 9px;"';
										$www1 = "color: #f66305;";
									}
									}
									if($row['mac_user'] == '1'){
										$hhhh = $row['p_name'].' - '.$row['bandwith'].'<br>['.$row['p_price'].'tk & '.$row['p_price_reseller'].'tk]';
										$editaction = "";
										$monthlyinv = "";
									}
									else{
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['raw_download'] .' + U: '.$row['raw_upload'].' + Y: '.$row['youtube_bandwidth'].' = '.$row['total_bandwidth'].'mb <br> Rate: '.$row['total_price'];
										$editaction = "ClientEdit";
										$monthlyinv = "<form action='PackageChange' method='post' target='_blank'><input type='hidden' name='cid' value='{$row['c_id']}' /><button style='border-top: 1px solid #80808040;color: #bb9605;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;' title='Change Bandwith'><i class='iconfa-signout'></i>&nbsp;&nbsp;&nbsp;Change Bandwith</button></form>";
									}
									elseif($row['breseller'] == '2'){
										$hhhh ="";
										$editaction = "ClientEditInvoice";
										$monthlyinv = "<form action='ClientEditMonthlyInvoice' method='post' target='_blank'><input type='hidden' name='c_id' value='{$row['c_id']}' /><button style='border-top: 1px solid #80808040;color: #bb9605;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;' title='Edit Monthly Invoice'><i class='iconfa-signout'></i>&nbsp;&nbsp;&nbsp;Edit Invoice</button></form>";
									}
									else{
										$hhhh = $row['p_name'].'<br>'.$row['bandwith'].' - '.$row['p_price'].'tk';
										$editaction = "ClientEdit";
										$monthlyinv = "<form action='PackageChange' method='post' target='_blank'><input type='hidden' name='cid' value='{$row['c_id']}' /><button style='border-top: 1px solid #80808040;color: #bb9605;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;' title='Change Package'><i class='iconfa-signout'></i>&nbsp;&nbsp;&nbsp;Change Package</button></form>";
									}
									}
									if($row['mac_user'] == '1'){
									$yrdata1= strtotime($row['termination_date']);
										$enddate = date('d F, Y', $yrdata1);
									
									$diff = abs(strtotime($row['termination_date']) - strtotime($dateTimeee))/86400;
									if($row['termination_date'] < $dateTimeee){ $diff = '0';}
									if($diff <= '7'){
										$colorrrr = 'style="vertical-align: middle;color: red;font-size: 25px;font-weight: bold;"'; 
										$colorrrr1 = 'style="vertical-align: middle;color: red;font-size: 35px;font-weight: bold;padding: 5px 5px;"'; 
										$colorrrraa = 'style="vertical-align: middle;color: red;font-size: 15px;font-weight: bold;padding: 0px;min-width: 150px;"'; 
									}
									else{
										$colorrrr = 'style="vertical-align: middle;font-size: 25px;font-weight: bold;"'; 
										$colorrrr1 = 'style="vertical-align: middle;font-size: 35px;color:#0866c6;font-weight: bold;padding: 5px 5px;"'; 
										$colorrrraa = 'style="vertical-align: middle;color: #0866c6;font-size: 15px;font-weight: bold;padding: 0px;min-width: 150px;"'; 
									}
									}
									else{
										$enddate = '';
									}
									
								if($minimize_data_load == '0'){
									if($row['nid_back'] != ''){
										$nid_back = "<a href='{$row['nid_back']}' target='_blank' /><img src='/{$row['nid_back']}' width='33%' height='15' alt='{$row['c_id']}_nid_back' style='border: 1px solid gray;'/></a>";
									}
									else{
										$nid_back = "";
									}
									if($row['nid_fond'] != ''){
										$nid_fond = "<a href='{$row['nid_fond']}' target='_blank' /><img src='/{$row['nid_fond']}' width='33%' height='15' alt='{$row['c_id']}_nid_fond' style='border: 1px solid gray;margin-right: 1px;'/></a>";
									}
									else{
										$nid_fond = "";
									}
									if($row['image'] != ''){
										$imgeeeee = "<a href='{$row['image']}' target='_blank' /><img src='/{$row['image']}' width='50' height='50' alt='{$row['c_id']}_main_image' style='border: 1px solid gray;margin-bottom: 3px;'/></a>";
									}
									else{
										$imgeeeee = "";
									}
									
									$passload = '<br>'.$row['pw'];
									$allimg = "<td class='center'>{$imgeeeee}<br>{$nid_fond}{$nid_back}</td>";
								}
								else{
									$passload= '';
									$allimg = "";
								}
									
									if($row['onu_mac'] != ''){
										$onumac = '&nbsp;['.$row['onu_mac'].']';
									}
									else{
										$onumac = '';
									}
								
								if($client_onlineclient_sts == '1'){
									$onlineinfo = "<td style='width: 15%;'><b>{$address_val}</b><br>{$mac_val}<br><a style='font-size: 10px;line-height: 10px;'>{$running_device}</a><br><b style='color: #008000d9;font-size: 15px;'><div id='defaultCountdown{$xkey}'>{$uptime_val}</div></b></td>";
								}
								else{
									$onlineinfo = "";
								}
								if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets'){
								if($type == 'left'){
									echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 50px;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b>{$passload}<br><a href='tel:{$row['cell']}'>{$row['cell']}</a></td>
											{$allimg}
											<td style='width: 15%;'><a href='Clients?id=all&zid={$row['z_id']}'>{$row['z_name']}</a><br>{$row['b_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
											<td><b style='color: red;'>{$row['delete_datetime']} by {$row['delete_by']}</b><br><b>{$hhhh}</b><br>{$join_date}</td>
											<td><b>PD: {$row['payment_deadline']}<br>BD: {$row['b_date']}</b><br><br><b style='color: green;font-size: 12px;'>{$enddate}</b></td>
											{$onlineinfo}\n";
									}
								elseif($type == 'macclient'){
									echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 50px;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b>{$passload}<br><a href='tel:{$row['cell']}'>{$row['cell']}</a></td>
											{$allimg}
											<td style='width: 15%;'><a href='Clients?id=macclient&zid={$row['zoneiddd']}'>{$row['z_name']}</a><br>{$row['b_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
											<td>{$hhhh}<br><br><b>{$join_date}</b></td>
											<td class='center' $colorrrraa>{$enddate}</td>
											<td class='center' $colorrrr>{$diff}</td>
											{$onlineinfo}\n";
								}
								elseif($type == 'auto'){
									echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 50px;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b>{$passload}<br><a href='tel:{$row['cell']}'>{$row['cell']}</a></td>
											{$allimg}
											<td style='width: 15%;'><a href='Clients?id=all&zid={$row['zoneiddd']}'>{$row['z_name']}</a><br>{$row['b_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
											<td>{$hhhh}<br><br><b>{$join_date}</b></td>
											<td><b>{$row['auto_inactive_date_time']}</b></td>
											<td style='padding: 16px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>PD: {$row['payment_deadline']}</b>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>BD: {$row['b_date']}</b>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
											{$onlineinfo}\n";
								}
								else{
									echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 50px;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b>{$passload}<br><a href='tel:{$row['cell']}'>{$row['cell']}</a></td>
											{$allimg}
											<td style='width: 15%;'><a href='Clients?id=all&zid={$row['zoneiddd']}'>{$row['z_name']}</a><br>{$row['b_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
											<td>{$hhhh}<br><br><b>{$join_date}</b></td>
											<td style='padding: 16px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>PD: {$row['payment_deadline']}</b>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>BD: {$row['b_date']}</b>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
											{$onlineinfo}\n";
											
								}
								}
								if($user_type == 'mreseller'){
									if($type == 'left'){
										echo
											"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 50px;'>{$row['com_id']}</td>
												<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b>{$passload}<br><a href='tel:{$row['cell']}'>{$row['cell']}</a></td>
												<td class='center'>{$imgeeeee}<br>{$nid_fond}{$nid_back}</td>
												<td style='width: 15%;'>{$row['z_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
												<td><b style='color: red;'>{$row['delete_datetime']} by {$row['delete_by']}</b><br><b>{$hhhh}</b><br>{$row['join_date']}</td>
												<td class='center' $colorrrraa>{$enddate}</td>
												<td class='center' $colorrrr>{$diff}</td>
												{$onlineinfo}\n";
									}
									elseif($type == 'recharge'){
										echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 50px;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b><br>{$row['pw']}<br><a href='tel:{$row['cell']}'>{$row['cell']}</a></td>
											<td class='center'>{$imgeeeee}<br>{$nid_fond}{$nid_back}</td>
											<td style='width: 15%;'>{$row['z_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
											<td>{$hhhh}<br><b>{$row['join_date']}</b></td>
											<td class='center' $colorrrraa><div id='Pointdiv1$xkey'><div id='olddate$xkey'>{$enddate}</div></div></td>
											<td style='padding: 0px;' class='center'>
												
													<div id='Pointdiv2$xkey'>
														<table style='width: 100%;'>
															<tbody>
															<tr style='height: 44px;'>
																<td class='center' style='border-right: none;border-left: none;'>
																	<ul class='tooltipsample'>
																		<li $colorrrr1><div id='olddatee$xkey'>{$diff}</div></li>
																	</ul>
																</td>
															</tr>
															<tr style='height: 44px;'>
																<td class='center' style='border-right: none;border-left: none;'>
																	<ul class='tooltipsample'>
																		<input type='hidden' name='c_id$xkey' id='c_id$xkey' value='{$row['c_id']}' />
																		<input type='hidden' name='old_duration$xkey' id='old_duration$xkey' value='{$diff}' />
																		<li><input type='checkbox' class='gdgdg' name='slno$xkey' id='slno$xkey' value='$xkey'/></li>
																	</ul>
																</td>
															</tr>
															</tbody>
														</table>
													</div>
											</td>\n";
?>
											<script language="javascript" type="text/javascript">
												function getXMLHTTP() { //fuction to return the xml http object
														var xmlhttp=false;	
														try{
															xmlhttp=new XMLHttpRequest();
														}
														catch(e){		
															try{			
																xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
															}
															catch(e){
																try{
																xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
																}
																catch(e1){
																	xmlhttp=false;
																}
															}
														}
														return xmlhttp;
													}
													
													function getRoutePoint<?php echo $xkey;?>(afdId) {		
														
														var strURL="durationdayextendsubmit.php?c_id="+afdId;
														var req = getXMLHTTP();
														
														if (req) {
															
															req.onreadystatechange = function() {
																if (req.readyState == 4) {
																	// only if "OK"
																	if (req.status == 200) {						
																		document.getElementById('Pointdiv1<?php echo $xkey;?>').innerHTML=req.responseText;						
																		document.getElementById('Pointdiv2<?php echo $xkey;?>').innerHTML='';						
																	} else {
																		alert("Problem while using XMLHTTP:\n" + req.statusText);
																	}
																}				
															}			
															req.open("GET", strURL, true);
															req.send(null);
														}		
													}

												$(document).ready(function(){  
													$("#slno<?php echo $xkey;?>").on('change',function(){
														var duration = $('#duration').val();
														var c_id = $('#c_id<?php echo $xkey;?>').val();
														var old_duration = $('#old_duration<?php echo $xkey;?>').val();
														var slno = $('input[name="slno<?php echo $xkey;?>"]:checked').val();
														if(slno){
														$.ajax({  
																type: 'POST',
																url: "mac-client-multi-duration",
																data:{duration:duration,c_id:c_id,slno:slno,old_duration:old_duration},
																success:function(data){
																	data = JSON.parse(data);
																	$('#olddate<?php echo $xkey;?>').html("<table style='width: 100%;'><tr><td style='border-bottom: 1px solid #ddd;border-left: none;'><div style='line-height: 15px;text-align: center;' title='Old Date'>"+data.olddate+"</div></td><td style='border-left: 1px solid #ddd;border-right: none;vertical-align: middle;text-align: center;' rowspan='2'><button type='button' class='' style='border-radius: 3px;color: red;border: 1px solid red;' value='"+data.clientid+"&dura="+data.newdurations+"' onClick='getRoutePoint<?php echo $xkey;?>(this.value); run(this);'>OK</button></td></tr><tr><td style='border-left: none;'><a style='color: red;font-size: 10px;font-weight: bold;line-height: 15px;' title='Cost & Days'>Cost: "+data.daycost+"৳ </a><br><b style='color: #337ab7;font-size: 10px;font-weight: bold;line-height: 15px;'>Days: "+data.newdurations+"</b><br><a style='color: green;font-size: 10px;font-weight: bold;' title='New Date'>Till: "+data.newdate+"</a></td></tr></table>");
																	$('#olddatee<?php echo $xkey;?>').html(data.new_duration);
																}
														});
														return false;

														}
														else{
															$('#olddate<?php echo $xkey;?>').html("<div $colorrrr title='Old Date' id='olddate<?php echo $xkey;?>'><?php echo $enddate;?></div>");
															$('#olddatee<?php echo $xkey;?>').html("<div $colorrrr1 id='olddatee<?php echo $xkey;?>'><?php echo $diff;?></div>");
														}
													});  
												});
												
												function run(thisButton) {
												  console.log('run');
												  disablebutton(thisButton)
												}

												function disablebutton(button){
													console.log(button);
													button.disabled = true;
												}
											</script>
									<?php }
									else{
										echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;width: 50px;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b><br>{$row['pw']}<br><a href='tel:{$row['cell']}'>{$row['cell']}</a></td>
											<td class='center'>{$imgeeeee}<br>{$nid_fond}{$nid_back}</td>
											<td style='width: 15%;'>{$row['z_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
											<td>{$hhhh}<br><b>{$row['join_date']}</b></td>
											<td class='center' $colorrrraa>{$enddate}</td>
											<td class='center' $colorrrr>{$diff}</td>
											{$onlineinfo}\n";
									}
								} ?>
											<td class='center' style="vertical-align: middle;">
												<ul class='popoversample'>
												<?php if($type == 'left'){ ?>
													<li><button class='btn <?php echo $clss;?>' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;<?php echo $collllr;?>"><?php echo $ee;?></button><br><?php if($client_onlineclient_sts == '1'){echo $clientactive;}?></li>
												<?php } else{ if(in_array(103, $access_arry)){?>
													<li><form href='#myModal345345' data-toggle='modal' title='<?php echo $dd;?>'><button type='submit' value="<?php echo $row['c_id'].'&consts='.$dd;?>" class='btn <?php echo $clss;?>' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;<?php echo $collllr;?>" onClick='getRoutePoint(this.value)'><?php echo $ee;?></button></form><?php if($client_onlineclient_sts == '1'){echo $clientactive;}?></li>
												<?php } else{?>
													<li><button class='btn <?php echo $clss;?>' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;<?php echo $collllr;?>"><?php echo $ee;?></button></li>
												<?php }} ?>
												</ul>
											</td>
											<?php if($type == 'left'){ ?>
											<td class='center' style="vertical-align: middle;">
												<ul class='tooltipsample'>
													<?php if(in_array(104, $access_arry)){?>
														<li><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row['c_id'];?>' /><button class="btn" style="border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 9px;" title='Client Profile'><i class='iconfa-eye-open'></i></button></form></li>
													<?php } if(in_array(108, $access_arry)){?>
														<li><form action='ClientDeleteRetarn' method='post' target='_blank' method='post' title='Restore'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='c_name' value='<?php echo $row['c_name'];?>' /><input type='hidden' name='cell' value='<?php echo $row['cell'];?>' /><input type='hidden' name='bname' value='<?php echo $row['b_name'];?>' /><input type='hidden' name='address' value='<?php echo $row['address'];?>' /><input type='hidden' name='join_date' value='<?php echo $row['join_date'];?>' /><button class='btn' style="border-radius: 3px;border: 1px solid #b76700;color: #b76700;padding: 6px 9px;" title='Restore Deleted Client'><i class='iconfa-retweet'></i></button></form></li>
													<?php } if($clients_per_delete == '1' && $user_type == 'admin' && $delete_clients_till_time > $current_date_time || $clients_per_delete == '1' && $user_type == 'superadmin' && $delete_clients_till_time > $current_date_time){ ?>
														<li><form action='ClientPerDelete' onclick='return checkPreDelete()' method='post'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='user_type' value='<?php echo $user_type;?>' /><button class='btn' style="border-radius: 3px;border: 1px solid red;color: red;padding: 6px 9px;" title='Permanent Delete'><i class='iconfa-trash'></i></button></form></li>
													<?php } ?>
												</ul>
											</td>
											<?php } elseif($type == 'macclient'){ ?>
											<td class='center' style="vertical-align: middle;">
												<div class="btn-group">
													<?php if($row['note_auto'] != '' || $row['note'] != ''){ ?>
														<ul class='popoversample' style="padding: 2px 0px;">
															<li style="margin-right: 0px;"><form href='#myModal11' data-toggle='modal'><button type='submit' value="<?php echo $row['c_id'];?>" class='btn' style="border-radius: 3px;text-transform: uppercase;border: 1px solid green;font-size: 13px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;padding: 3px 22px 3px;" onClick='getRoutePoint1(this.value)'>Note</button></form></li>
														</ul>
													<?php } ?>
													<button class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid #c60a0a;font-size: 13px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #c60a0a;padding: 3px 7px 3px;font-weight: bold;" data-toggle="dropdown"><span class="caret" style="border-top: 4px solid #c60a0a;margin-left: 0;"></span>&nbsp; Action </button>
													<ul class="dropdown-menu" style="width: 160px;padding: 2px;right: 0;left: unset;">
														<?php if(in_array(104, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #0866c6;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Profile'><i class='iconfa-eye-open'></i>&nbsp;&nbsp;&nbsp;Profile</button></form></li>
														<?php } if(in_array(101, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientEdit' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #a0f;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Edit'><i class='iconfa-edit'></i>&nbsp;&nbsp;&nbsp;Edit</button></form></li>
														<?php } if($row['con_sts'] == 'Active'){ ?>
															<li style="margin-bottom: 2px;"><form action='PackageChange' method='post' target='_blank'><input type='hidden' name='cid' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #bb9605;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Change Package'><i class='iconfa-signout'></i>&nbsp;&nbsp;&nbsp;Change Package</button></form></li>
														<?php } ?>
															<li class="divider"></li>
														<?php if(in_array(107, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientsRecharge' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #2ab105;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Recharge'><i class='iconfa-globe'></i>&nbsp;&nbsp;&nbsp;Recharge</button></form></li>
														<?php } ?>
															<li class="divider"></li>
														<?php if(in_array(102, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientDelete' method='post'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='breseller' value='<?php echo $row['breseller'];?>'/><button class="" onclick="return checkDelete()" style="border-top: 1px solid #80808040;color: red;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Delete'><i class='iconfa-trash'></i>&nbsp;&nbsp;&nbsp;Delete</button></form></li>
														<?php } ?>
													</ul>
												</div>
											</td>
											<?php } else{ ?>
											<td class='center' style="vertical-align: middle;">
												<div class="btn-group">
													<?php if($row['note_auto'] != '' || $row['note'] != ''){ ?>
														<ul class='popoversample' style="padding: 2px 0px;">
															<li style="margin-right: 0px;"><form href='#myModal11' data-toggle='modal'><button type='submit' value="<?php echo $row['c_id'];?>" class='btn' style="border-radius: 3px;text-transform: uppercase;border: 1px solid green;font-size: 13px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;padding: 3px 22px 3px;" onClick='getRoutePoint1(this.value)'>Note</button></form></li>
														</ul>
													<?php } ?>
													<button class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid #c60a0a;font-size: 13px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #c60a0a;padding: 3px 7px 3px;font-weight: bold;" data-toggle="dropdown"><span class="caret" style="border-top: 4px solid #c60a0a;margin-left: 0;"></span>&nbsp; Action </button>
													<ul class="dropdown-menu" style="width: 160px;padding: 2px;right: 0;left: unset;">
														<?php if(in_array(104, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #0866c6;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Profile'><i class='iconfa-eye-open'></i>&nbsp;&nbsp;&nbsp;Profile</button></form></li>
														<?php } if(in_array(101, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='<?php if($userr_typ == 'mreseller'){ echo 'ClientEdit';} else{ echo $editaction;}?>' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #a0f;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Edit'><i class='iconfa-edit'></i>&nbsp;&nbsp;&nbsp;Edit</button></form></li>
														<?php } if(in_array(105, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientSMS' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: green;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Send SMS'><i class='iconfa-envelope'></i>&nbsp;&nbsp;&nbsp;Send SMS</button></form></li>
														<?php } if($row['con_sts'] == 'Active'){ ?>
															<li style="margin-bottom: 2px;"><?php echo $monthlyinv;?></li>
														<?php } ?>
															<li class="divider"></li>
														<?php if(in_array(128, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='PaymentAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #044a8e;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Cash Payment'><i class='iconfa-money'></i>&nbsp;&nbsp;&nbsp;Cash Payment</button></form></li>
														<?php } if(in_array(129, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='PaymentOnlineAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: green;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Online Payment'><i class='iconfa-shopping-cart'></i>&nbsp;&nbsp;&nbsp;Online Payment</button></form></li>
														<?php } if($userr_typ == 'mreseller'){?>
															<li style="margin-bottom: 2px;"><form action='ClientsRecharge' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #2ab105;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Recharge'><i class='iconfa-globe'></i>&nbsp;&nbsp;&nbsp;Recharge</button></form></li>
														<?php } ?>
															<li class="divider"></li>
														<?php if(in_array(106, $access_arry) && $minimize_data_load == '0'){?>
															<li style="margin-bottom: 2px;"><form action='ClientLock' method='post' target='_blank'><input type='hidden' name='id' value='<?php echo $row['c_id'];?>' /><button class="" onclick="return checkLock()" style="border-top: 1px solid #80808040;<?php echo $www1;?>border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;"><?php echo $bb;?>&nbsp;&nbsp;&nbsp;<?php echo $cc;?></button></form></li>
														<?php } if(in_array(102, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientDelete' method='post'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='breseller' value='<?php echo $row['breseller'];?>'/><button class="" onclick="return checkDelete()" style="border-top: 1px solid #80808040;color: red;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Delete'><i class='iconfa-trash'></i>&nbsp;&nbsp;&nbsp;Delete</button></form></li>
														<?php } ?>
													</ul>
												</div>
											</td>
											<?php } ?>
										</tr>
						<?php $xkey++; } if($type == 'clientmksts'){ ?>
							<td class='center'></td>
							<td class='center'></td>
							<td class='center'></td>
							<td class='center'><a style="color: red;font-weight: bold;margin-top: 10px;font-size: 15px;">Offline</a></td>
							<td class='center'><a style="color: red;font-weight: bold;margin-top: 10px;font-size: 20px;"><?php echo $xx-$onlinecounter;?></a></td>
							<td class='center'></td>
							<td class='center'><a style="color: green;font-weight: bold;margin-top: 10px;font-size: 15px;">Online</a></td>
							<td class='center'><a style="color: green;font-weight: bold;margin-top: 10px;font-size: 20px;"><?php echo $onlinecounter;?></a></td>
						<?php } ?>
					</tbody>
				</table>
		<?php if($client_onlineclient_sts == '1'){?>
			<div class='actionBar' style="padding: 10px;border: 1px solid #ddd;margin-top: 2px;">
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: #0866c6;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Online:  <i><?php echo $activecountt;?></i></div> 
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: red;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Offline: <i><?php echo $inactivecountt;?></i></div> 
					<div style="position: absolute;top: 12%;right: 10px;">
						<form id="form2" class="stdform" method="GET" action="<?php echo $PHP_SELF;?>">
							<?php if($type != ''){ ?>
								<input type='hidden' name='id' value='<?php echo $type;?>'/> 
							<?php } if($zone_id != ''){ ?>
								<input type='hidden' name='zid' value='<?php echo $zone_id;?>'/> 
							<?php } ?>
							<select name="RealtimeStatus" style="font-weight: bold;font-size: 15px;width:185px;" onchange="submit();">
								<option value="all"<?php if($RealtimeStatus == 'all' || $RealtimeStatus == '') echo 'selected="selected"';?>>All Clients</option>
								<option value="Online"<?php if($RealtimeStatus == 'Online') echo 'selected="selected"';?> style="color: green;">Online Clients</option>
								<option value="Offline"<?php if($RealtimeStatus == 'Offline') echo 'selected="selected"';?> style="color: red;">Offline Clients</option>
							</select>
						</form>        
					</div>
			</div>
		<?php } ?>
			</div>
		</div>
<?php } else{ if(in_array(119, $access_arry)){ ?>
			<div class="modal-content">
				<div class="modal-body" style="padding: 5px;">
					<table style="width: 100%;border-bottom: 0px;" class="table table-bordered responsive">
						<thead>
						  <tr>
							<td class='center' style="width: 5%;padding: 0px;"><input type="text" name="com_id" style="width: 70%;font-size: 13px;font-weight: bold;" placeholder="Com ID" id="appendedInputButtons" class=""></td>
							<td class='center' style="width: 10%;padding: 0px;"><input type="text" name="c_id" placeholder="Client ID" style="width: 80%;font-size: 13px;font-weight: bold;" id="appendedInputButtonsCid" class=""></td>
							<td class='center' style="width: 10%;padding: 0px;"><input type="text" name="c_name" placeholder="Client Name" style="width: 80%;font-size: 13px;font-weight: bold;" id="appendedInputButtonsCname" class=""></td>
							<td class='center' style="width: 8%;padding: 0px;"><input type="text" name="cell" placeholder="Phone No" style="width: 80%;font-size: 13px;font-weight: bold;" id="appendedInputButtonsCell" class=""></td>
							<td class='center' style="width: 12%;padding: 0px;"><input type="text" name="address" placeholder="Address" style="width: 80%;font-size: 13px;font-weight: bold;" id="appendedInputButtonsAddress" class=""></td>
							<td class='center' style="width: 5%;padding: 0px;"><input type="text" name="payment_deadline" style="width: 80%;font-size: 13px;font-weight: bold;" placeholder="P.Deadline" id="appendedInputButtonsDeadline" class=""></td>
							<td class='center' style="width: 5%;padding: 0px;"><input type="text" name="b_date" style="width: 80%;font-size: 13px;font-weight: bold;" placeholder="B.Deadline" id="appendedInputButtonsbDeadline" class=""></td>
							<td class='center' style="width: 5%;padding: 0px;"><input type="text" name="ip" placeholder="IP" style="width: 80%;font-size: 13px;font-weight: bold;" id="appendedInputButtonsIp" class=""></td>
							<td class='center' style="width: 5%;padding: 0px;"><input type="text" name="onu_mac" placeholder="Onu MAC" style="width: 80%;font-size: 13px;font-weight: bold;" id="appendedInputButtonsOnuMac" class=""></td>
							<td class='center' style="width: 16%;padding: 0px;font-size: 13px;font-weight: bold;">
								<select name="z_id" style="width:100%;" data-placeholder="Select a Zone" id="" class="chzn-select"/>
									<option value=""></option>
									<?php while ($rowz=mysql_fetch_array($resultff)) { ?>
										<option style="text-align: Left;" value="<?php echo $rowz['z_id']?>"><?php echo $rowz['z_name'];?> <?php if($rowz['z_bn_name'] != ''){echo '('.$rowz['z_bn_name'].')';}?></option>
									<?php } ?>
								</select>
							</td>
							<td class='center' style="width: 7%;padding: 0px;font-size: 13px;font-weight: bold;">
								<select name="cable_type" style="width:100%;" data-placeholder="Cable Type" id="" class="chzn-select"/>
									<option value=""></option>
									<option value="UTP">UTP</option>
									<option value="FIBER">FIBER</option>
								</select>
							</td>
						  </tr>
						</thead>
					</table>
				</div>
			</div>
<?php } ?>
					<span id="result">
					<?php if(in_array(216, $access_arry)){?>
						<div id="chart_div4" style="width: 100%; text-align: center; height: 480px; margin: 0 auto; padding: 0 auto"></div>
					<?php } else{ echo '<br/><br/>';}?>
						<div id="chart_div" style="text-align: center; height: 350px; width: 45%;border: 1px solid #00A65A;float: left;margin-left: 20px;"></div>
						<div id="chart_div3" style="text-align: center; height: 350px; width: 45%;border: 1px solid #00A65A;float: right;margin-right: 20px;"></div>
					</span>
<?php }  

}
else{
	header("Location:/index");
}
include('include/footer.php');
if($userr_typ == 'mreseller'){ if($type == 'left'){ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[<?php if($minimize_data_load == '0'){echo '4';} else{echo '3';}?>,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[<?php if($minimize_data_load == '0'){echo '4';} else{echo '3';}?>,'desc']],
            "sScrollY": "1000px"
        });
    });
</script>
<?php } else{ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[<?php if($minimize_data_load == '0'){echo '6';} else{echo '5';}?>,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[<?php if($minimize_data_load == '0'){echo '6';} else{echo '5';}?>,'asc']],
            "sScrollY": "1000px"
        });
    });
</script>
<?php }} elseif($type == 'auto'){ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[<?php if($minimize_data_load == '0'){echo '5';} else{echo '4';}?>,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 20,
			"aaSorting": [[<?php if($minimize_data_load == '0'){echo '5';} else{echo '4';}?>,'desc']],
            "sScrollY": "1000px"
        });
    });
</script>
<?php } elseif($type == 'left'){ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[<?php if($minimize_data_load == '0'){echo '4';} else{echo '3';}?>,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[<?php if($minimize_data_load == '0'){echo '4';} else{echo '3';}?>,'desc']],
            "sScrollY": "1100px"
        });
    });
</script>
<?php } else{ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		jQuery('#dyntable2').dataTable({
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'desc']],
            "sScrollY": "1100px"
        });
    });
</script>
<?php } ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
function checkPreDelete(){
    return confirm('Permanent Delete!!  No way to undo. Are you sure?');
}
function checksts(){
    return confirm('Change connection status!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}

function checkLoad(){
    return confirm('Are you sure?  Do You Want To <?php echo $load_titel;?>?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#appendedInputButtons").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
  
 $("#appendedInputButtonsCid").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 2)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
  
 $("#appendedInputButtonsCname").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 2)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
  
 $("#appendedInputButtonsCell").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 2)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
  
 $("#appendedInputButtonsAddress").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 2)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
  
 $("#appendedInputButtonsOnuMac").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 5)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });  
 
 $("#appendedInputButtonsIp").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 5)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
    
 $("#appendedInputButtonsDeadline").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
 

 $("#appendedInputButtonsbDeadline").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'ClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
 
		jQuery('select[name="cable_type"]').on('change',function(){
			var p_id = jQuery(this).val(); 
				$.ajax({
				type : 'POST',
				url  : 'ClientSearchResult.php',
				data : jQuery(this),
				success : function(data)
					{
						$("#result").html(data);
					}
				});
		return false;
		});
		
		jQuery('select[name="z_id"]').on('change',function(){
			var p_id = jQuery(this).val(); 
				$.ajax({
				type : 'POST',
				url  : 'ClientSearchResult.php',
				data : jQuery(this),
				success : function(data)
					{
						$("#result").html(data);
					}
				});
		return false;
		});
	});
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">

		  // Load the Visualization API and the piechart package.
		google.charts.load('current', {packages: ['corechart', 'bar']});
		  // Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(drawBasic);

		  // Callback that creates and populates a data table,
		  // instantiates the pie chart, passes in the data and
		  // draws it.
		 function drawBasic() {
			
			// Create the data table.
			var data = new google.visualization.arrayToDataTable([
				<?php echo(implode(",",$myurl));?>
			]);
		

			// Set chart options
			
			var options = {
				title: "Monthly New Clients",
				height: 350,
				vAxis: {title: 'New Clients'},
				hAxis: {title: 'New Clients in Last One Year'},
				bar: {groupWidth: "80%"},
				fontSize: 12,
				legend: { position: "none" },
				chartArea: {'backgroundColor':'#fff',width:'90%'},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				colors: ['#1b9e77']
			  };				

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		  }
    </script>
		<script type="text/javascript">

		  // Load the Visualization API and the piechart package.
		google.charts.load('current', {packages: ['corechart', 'bar']});
		  // Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(drawBasic);

		  // Callback that creates and populates a data table,
		  // instantiates the pie chart, passes in the data and
		  // draws it.
		 function drawBasic() {
			
			// Create the data table.
			var data = new google.visualization.arrayToDataTable([
				<?php echo(implode(",",$myurl3));?>
			]);
		

			// Set chart options
			
			var options = {
				title: "Last 30 Days Auto Inactive Clients by Deadline",
				height: 350,
				vAxis: {title: 'Inactive by Deadline'},
				hAxis: {title: 'Inactive in Last 30 days by Deadline'},
				bar: {groupWidth: "70%"},
				fontSize: 12,
				legend: { position: "none" },
				chartArea: {'backgroundColor':'#fff',width:'90%'},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				colors: ['#1b9e77']
			  };				

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
			chart.draw(data, options);
		  }
    </script>
	<script type="text/javascript">

		  // Load the Visualization API and the piechart package.
		  google.load('visualization', '1.0', {'packages':['corechart']});

		  // Set a callback to run when the Google Visualization API is loaded.
		  google.setOnLoadCallback(drawChart);

		  // Callback that creates and populates a data table,
		  // instantiates the pie chart, passes in the data and
		  // draws it.
		  function drawChart() {

			// Create the data table.
			var data = new google.visualization.arrayToDataTable([
				<?php echo(implode(",",$myurl4));?>
			]);
		

			// Set chart options
			
			var options = {
				title: "Zone Wise Clients Counting",
				height: 450,
				vAxis: {title: 'Zone Wise Clients Counting'},
				bar: {groupWidth: "75%"},
				fontSize: 12,
				legend: { position: "none" },
				chartArea: {'backgroundColor':'#fff',width:'90%'},
				colors: ['#1b9e77']
			  };				

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div4'));
			chart.draw(data, options);
		  }
    </script>
<script language="javascript" type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
	function getRoutePoint(afdId) {		
		
		var strURL="client-status-change-note.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint1(afdId) {		
		var strURL="client-note.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv2').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getRoutePointsp(afdId) {		
		var strURL="client-online-mb.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv3yyyy').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
	}
	function getRoutePointspd(afdId) {		
		var strURL="client-offline-out.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv3yyyyd').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
	}
	
</script>