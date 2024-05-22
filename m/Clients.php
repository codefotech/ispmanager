<?php
$titel = "Clients";
$Clients = 'active';
include("mk_api.php");	
include('include/hader.php');
$type = $_GET['id'];
extract($_POST); 

$dateTimeee = date('Y-m-d', time());
$dateMonth = date('F Y', time());
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$API = new routeros_api();
$API->debug = false;

if($client_onlineclient_sts == '1'){
$items = array();
$itemss = array();

$itemss_uptime[] = array();
$itemss_address[] = array();
$itemss_mac[] = array();
$sql34 = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND online_sts = '0'");
$tot_mk = mysql_num_rows($sql34);
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
$ghjghjgj = implode(',', array_unique($itemss1));
$total_active_connection = key(array_slice($itemss1, -1, 1, true))+1;
$queryss = "INSERT INTO mk_active_count (total_active, client_array) VALUES ('$total_active_connection', '$ghjghjgj')";
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

			if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets'){
							if($type == 'all' || $type == '' && in_array(114, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND mac_user !='1' ORDER BY c.id DESC");
												
							$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user !='1'");
							$sqlss = mysql_query("SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1' AND mac_user !='1'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$loc = mysql_num_rows($sqlss);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total:  <i style='color: #317EAC'>{$tot}</i></div>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Active:  <i style='color: #30ad23'>{$act}</i></div>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'macclient' && in_array(115, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, c.termination_date, e.e_name AS technician, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND mac_user ='1' ORDER BY c.id DESC");
												
							$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user ='1'");
							$sqlss = mysql_query("SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1' AND mac_user ='1'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$loc = mysql_num_rows($sqlss);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'active' && in_array(112, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.onu_mac, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.breseller, c.mac_user, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Active' AND mac_user !='1' ORDER BY c.id DESC");
							$tot = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Active Clints:  <i style='color: #30ad23'>{$tot}</i></div>
									</div>";
							}
							if($type == 'inactive' && in_array(113, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.onu_mac, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.breseller, c.mac_user, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND mac_user !='1' ORDER BY c.id DESC");
							$inact = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Inactive Clints: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'lock' && in_array(117, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.onu_mac, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.breseller, c.mac_user, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND l.log_sts = '1' AND mac_user !='1' ORDER BY c.id DESC");
							$locks = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Lock Clints: <i style='color: #f66305'>{$locks}</i></div>
									</div>";
							}
							if($type == 'auto' && in_array(116, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.onu_mac, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.breseller, c.mac_user, c.p_id, p.p_name, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN con_sts_log AS o ON o.c_id = c.c_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND mac_user !='1' AND o.update_by = 'Auto' ORDER BY o.update_date DESC LIMIT 200");
							$locks = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'>Auto Inactive Clients for Due Bill</div>
									</div>";
							}
							if($type == 'new'){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.onu_mac, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND MONTH(c.join_date) = MONTH('$dateTimeee') AND YEAR(c.join_date) = YEAR('$dateTimeee') AND mac_user !='1' ORDER BY c.id DESC");
							$locks = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'>$dateMonth New Clients.</div>
									</div>";
							}
							$queryrgg = mysql_query("SELECT c_id, c_name, cell, address FROM clients WHERE sts = '0' AND mac_user = '0' ORDER BY c_name");
							
						$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
						$result11=mysql_query($query11);
						}
					if($user_type == 'billing'){
							if($type == 'all' || $type == '' && in_array(114, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.breseller, c.mac_user, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND mac_user !='1' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.id DESC");
							$sqls = mysql_query("SELECT c.c_id FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 AND c.con_sts = 'Active' AND c.mac_user !='1'");
							$sqlss = mysql_query("SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 AND l.log_sts = '1' AND mac_user !='1'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$loc = mysql_num_rows($sqlss);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'active' && in_array(112, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, e.e_name AS technician, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Active' AND mac_user !='1' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.id DESC");
							$tot = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Active Clints:  <i style='color: #30ad23'>{$tot}</i></div>
									</div>";
							}
							if($type == 'inactive' && in_array(113, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, e.e_name AS technician, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND mac_user !='1' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.id DESC");
							$inact = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Inactive Clints: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'lock' && in_array(117, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, e.e_name AS technician, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND l.log_sts = '1' AND mac_user !='1' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.id DESC");
							$locks = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Lock Clints: <i style='color: #f66305'>{$locks}</i></div>
									</div>";
							}
							if($type == 'auto' && in_array(116, $access_arry)){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, e.e_name AS technician, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN con_sts_log AS o ON o.c_id = c.c_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND mac_user !='1' AND o.update_by = 'Auto' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY o.update_date DESC LIMIT 200");
							$locks = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'>Auto Inactive Clients for Due Bill</div>
									</div>";
							}
							if($type == 'new'){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, e.e_name AS technician, c.c_id, c.payment_deadline, m.Name, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND MONTH(c.join_date) = MONTH('$dateTimeee') AND YEAR(c.join_date) = YEAR('$dateTimeee') AND mac_user !='1' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.id DESC");
							$locks = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'>$dateMonth New Clients.</div>
									</div>";
							}
							$queryrgg = mysql_query("SELECT c.c_id, c.c_name, c.cell, c.address FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND c.mac_user = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.c_name");
						}
						
					if($user_type == 'mreseller')
						{
							if($type == '' || $type == 'all' || $type == 'recharge'){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, c.termination_date, e.e_name AS technician, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND z.z_id = '$macz_id' ORDER BY c.termination_date ASC");
												
							$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user = '1' AND z_id = '$macz_id'");
							$sqlss = mysql_query("SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1' AND c.mac_user = '1' AND c.z_id = '$macz_id'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$loc = mysql_num_rows($sqlss);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Inactive: <i style='color: #e3052e'>{$inact}</i></div>
									</div>";
							}
							if($type == 'active'){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, c.termination_date, e.e_name AS technician, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Active' AND z.z_id = '$macz_id' ORDER BY c.termination_date ASC");
							$tot = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Active Clints:  <i style='color: #30ad23'>{$tot}</i></div>
									</div>";
							}
							if($type == 'inactive'){
							$sql = mysql_query("SELECT c.c_name, l.pw, c.com_id, c.onu_mac, c.termination_date, e.e_name AS technician, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND z.z_id = '$macz_id' ORDER BY c.termination_date ASC");
							$inact = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil' style='font-size: 10px;padding: 0 5px 0 0;'> Total Inactive Clints: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							$queryrgg = mysql_query("SELECT c_id, c_name, cell, address FROM clients WHERE sts = '0' AND mac_user = '1' AND z_id = '$macz_id' ORDER BY c_name");
							
						$queryaaaa = mysql_query("SELECT mk_id FROM emp_info WHERE e_id = '$e_id'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);
									$mkid = $rowaaaa['mk_id'];
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
$qaaaa = mysql_query("SELECT client_array AS client_array FROM mk_active_count WHERE sts = '0' AND client_array != '' ORDER BY id DESC LIMIT 1");
$roaa = mysql_fetch_assoc($qaaaa);
$client_array = $roaa['client_array'];
$all_online_client_array = explode(',', $client_array);

$qyaaaa = mysql_query("SELECT GROUP_CONCAT(c_id SEPARATOR ',') AS c_id FROM clients WHERE z_id = '$macz_id' AND sts = '0'");
$rohha = mysql_fetch_assoc($qyaaaa);
$all_client_arrayy = $rohha['c_id'];
$all_client_array = explode(',', $all_client_arrayy);
$totalcount = count($all_client_array);

$commonValues = array_intersect($all_online_client_array, $all_client_array);
$total_online_count = count($commonValues)-1;

$total_offline_count = $totalcount - $total_online_count;
						}
?>
	<div class="box box-primary">
		<div class="box-header">
		<?php if($userr_typ == 'mreseller'){ if($aaaa > $over_due_balance && $billing_typee == 'Prepaid' || $billing_typee == 'Postpaid'){ if($limit_accs == 'Yes'){ if($type == 'recharge'){ if($minimum_sts == '2' && $minimum_days_arrays != ''){ ?>
			<select name="duration" id="duration" style="float: right;border: 1px solid red;color: red;width: 45px;font-weight: bold;font-size: 16px;height: 24px;text-align: center;border-radius: 3px;" placeholder="<?php echo $minimum_day;?>" required="">
				<?php foreach ($minimum_arraydd as $item) { 
						echo "<option value='$item'>$item</option>";
					}?>
			</select>
			<?php } else{ ?>
			<input type="text" name="duration" id="duration" value="<?php echo $minimum_day;?>" style="float: right;margin-right: 2px;border: 1px solid blue;color: red;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;border-radius: 3px;width: 35px;font-weight: bold;font-size: 15px;height: 24px;" placeholder="Days" class="surch_emp" required=""/>
			<?php }} else{ ?>
			<a class="btn ownbtn3" style="float: right;margin-right: 2px;font-weight: bold;padding: 2px 6px;" href="MACClientAdd"><i class="iconfa-plus" style="font-size: 17px;"></i></a>
			<a class="btn ownbtn12" style="float: right;margin-right: 2px;font-weight: bold;" href="Clients?id=recharge">Recharge</a>
		<?php } ?>
		<?php } else{ ?> 
				<a style='font-size: 10px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[Contact Admin]</a>			
		<?php }}?>
			<a class="btn ownbtn4" style="float: right;margin-right: 2px;font-weight: bold;" href="Clients?id=inactive">Inactive</a>
			<a class="btn ownbtn3" style="float: right;margin-right: 2px;font-weight: bold;" href="Clients?id=active">Active</a> 
		<?php if($client_onlineclient_sts == '0'){ ?>
			<a class="btn ownbtn12" style="float: right;margin-right: 2px;font-size: 9px;font-weight: bold;" href="MacResellerActiveClients">Current Status</a>
		<?php }} if($userr_typ == 'admin' || $userr_typ == 'superadmin' || $userr_typ == 'support' || $userr_typ == 'accounts' || $userr_typ == 'billing' || $userr_typ == 'billing_manager' || $userr_typ == 'support_manager' || $userr_typ == 'ets'){ ?>
		<?php if(in_array(110, $access_arry)){ if($limit_accs == 'Yes'){ ?>
			<a class="btn ownbtn3" style="float: right;margin-right: 2px;font-weight: bold;" href="ClientAdd"><i class="iconfa-plus" style="font-size: 14px;"></i></a>
		<?php } else{ ?> 
			<a style='font-size: 10px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[User Limit Exceeded]</a>
		<?php }} if(in_array(115, $access_arry)){ ?>
			<a class="btn ownbtn12" style="float: right;margin-right: 2px;font-weight: bold;" href="Clients?id=macclient">MAC Clients</a>
		<?php } if(in_array(113, $access_arry)){ ?>
			<a class="btn ownbtn4" style="float: right;margin-right: 2px;font-weight: bold;" href="Clients?id=inactive">Inactive</a>
		<?php } if(in_array(112, $access_arry)){ ?>
			<a class="btn ownbtn3" style="float: right;margin-right: 2px;font-weight: bold;" href="Clients?id=active">Active</a> 
		<?php } if(in_array(114, $access_arry)){ ?>
			<a class="btn ownbtn2" style="float: right;margin-right: 2px;font-weight: bold;" href="Clients?id=all">All</a>
		<?php }} if($mk_id != ''){?>
			
			<?php } else{?>
			<h6 style="float: left;margin-top: 0px;"><?php echo $tit; ?></h6> 
			<?php } ?>
		</div><br />
			<div class="box-body" style="padding: 2px;">
			<?php if($user_type == 'admin' || $user_type == 'superadmin'){ if($mk_id != ''){?>
			<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
				<select data-placeholder="Realtime Active" name="mk_id" class="chzn-select"  style="width:95%;text-align: center;font-size: 12px;font-weight: bold;border-radius: 5px;" onchange="submit();">
						<option value=""></option>
						<?php while ($row11=mysql_fetch_array($result11)) { ?>
							<option value="<?php echo $row11['id']?>" <?php if($mk_id==$row11['id']) echo 'selected="selected"';?>><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
						<?php } ?>
				</select>
			</form>
			<?php } else{?>
			<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
				<select data-placeholder="Realtime Active Connections" name="mk_id" class="chzn-select"  style="width:100%;text-align: center;font-size: 12px;font-weight: bold;" onchange="submit();">
						<option value=""></option>
						<?php while ($row11=mysql_fetch_array($result11)) { ?>
							<option value="<?php echo $row11['id']?>" <?php if($mk_id==$row11['id']) echo 'selected="selected"';?>><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
						<?php } ?>
				</select>
			</form>
			<?php }} if($user_type == 'mreseller'){?> 
				<div class="modal-body" style="padding: 0;">
					<form id="form2" class="stdform" method="post" action="ClientView" style="width:70%;">
					<p style="margin: 2px 0;width:70%;float:left;">
						<select data-placeholder="Search Client" name="ids" class="chzn-select"  style="text-align: center;font-size: 12px;font-weight: bold;" required="" onchange='this.form.submit()'>
							<option value=""></option>
							<?php while ($row2gg=mysql_fetch_array($queryrgg)) { ?>
							<option value="<?php echo $row2gg['c_id']?>"><?php echo $row2gg['c_name']; ?> | <?php echo $row2gg['c_id']; ?> | <?php echo $row2gg['cell']; ?></option>
							<?php } ?>
						</select>
					</p>
					</form>

					<p style="width:20%;float:right;font-size: 20px;padding: 8px 0 0 5px;font-weight: bold;">
						<a title='ONLINE' style="color:teal;padding: 0px 5px 0px 0px;"><?php echo $total_online_count;?></a><a title='OFFLINE' style="color:red;border-left: 1px solid #bbb;padding: 0px 0px 0px 5px;"><?php echo $total_offline_count;?></a>
					</p>
				</div>
			
			<?php } else{if(in_array(104, $access_arry)){?>
			<!---<form id="form2" class="stdform" method="post" action="ClientView">
				<div class="modal-body" style="padding: 0;">
					<p style="margin: 2px 0;">
						<select data-placeholder="Search Client" name="ids" class="chzn-select"  style="width:100%;text-align: center;font-size: 12px;font-weight: bold;" required="" onchange='this.form.submit()'>
							<option value=""></option>
							<?php// while ($row2gg=mysql_fetch_array($queryrgg)) { ?>
							<option value="<?php// echo $row2gg['c_id']?>"><?php// echo $row2gg['c_name']; ?> | <?php// echo $row2gg['c_id']; ?> | <?php// echo $row2gg['cell']; ?></option>
							<?php// } ?>
						</select>
					</p>
				</div>
			</form>--->
			<?php }} if(in_array(119, $access_arry)){?>
								<div class="modal-content" style="margin: 0 0 2px 0;">
										<div class="par">
											<input type="text" name="com_id" placeholder="ComID" id="appendedInputButtons" style="width: 15%;float: left;margin-right: 0.5%;border-radius: 3px 0px 0px 3px;" class="span2">
										</div>
										<div class="par">
											<input type="text" name="c_id" placeholder="PPPoE ID" id="appendedInputButtonsCid" style="width: 30%;float: left;margin-right: 0.5%;border-radius: 0px 0px 0px 0px;" class="span2">
										</div>
										<div class="par">
											<input type="text" name="cell" placeholder="Cell No" id="appendedInputButtonsCell" style="width: 30%;float: left;margin-right: 0.5%;border-radius: 0px 0px 0px 0px;" class="span2">
										</div>
										<div class="par">
											<input type="text" name="address" placeholder="Address" id="appendedInputButtonsAddress" style="width: 23.5%;border-radius: 0px 3px 3px 0px;" class="span2">
										</div>
								</div>
			<?php } ?>
			<span id="result">
			<?php if($mk_id != ''){?>
			<div id='responsecontainer1' style="font-size: 12px;font-weight: bold;text-align: center;padding: 0px;border-left: 1px solid #ddd;border-right: 1px solid #ddd;"></div>
					<table id="dyntable" class="table table-bordered responsive">
				 <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0" style="font-size: 10px;padding: 5px;text-align: center;">ID/Name/Cell</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">IP/Uptime/Mac</th>
							<th class="head0 center" style="font-size: 10px;padding: 5px;text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
		$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk1 = mysql_fetch_assoc($sqlmk1);
		
		$ServerIP1 = $rowmk1['ServerIP'];
		$Username1 = $rowmk1['Username'];
		$Pass1= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
		$Port1 = $rowmk1['Port'];
		
						if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)) {
								$arrID = $API->comm('/ppp/active/getall');
								
								echo "<div class='' id='responsecontainer'></div>";
								foreach($arrID as $x => $x_value) {
									
									$aaaaa = $x_value['name'];
									$sql44 = mysql_query("SELECT c.c_name, c.c_id, c.payment_deadline, m.Name, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												WHERE c.c_id = '$aaaaa' ORDER BY c.id DESC");
									$rows1 = mysql_fetch_assoc($sql44);
									
									$sqlcon = mysql_query("SELECT s.c_id, s.con_sts, DATE_FORMAT(s.update_date, '%D %M %Y') AS update_date, s.update_time, s.update_by, e.e_name FROM con_sts_log AS s 
									LEFT JOIN emp_info AS e ON e.e_id = s.update_by
									WHERE s.c_id = '$aaaaa' AND s.con_sts = 'inactive' ORDER BY s.id DESC LIMIT 1");
									$rowcon = mysql_fetch_assoc($sqlcon);
									
									if($rows1['c_name'] == ''){
										$colorrrr = 'style="color: red;font-size: 10px;padding: 3px 5px 3px 5px;font-weight: bold;line-height: 1.3;"'; 
										$qqqqq = 'ID Not Matched'; 
										$bbbbb = '';
										$wwww = 'Not found';
										$wwwws = 'Not found';
										$dddd = "";
										$bbb = $aaaaa;
										$bbbcell = "";
										} 
										else{
											$bbb = "<a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;' href='ClientView?id=".$aaaaa."' class=''>".$aaaaa."</a>";
											$bbbcell = "<a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;' href='' class=''>".$rows1['cell']."</a>";
											$colorrrr = 'style="font-size: 10px;padding: 0;line-height: 1.3;"'; 
											$qqqqq = "<a data-placement='top' data-rel='tooltip' href='ClientView?id=".$rows1['c_id']."' data-original-title='View Client' target='_blank' class='btn col1'><i class='fa iconfa-eye-open'></i></a>";
												if($rows1['con_sts'] == 'Active'){
													$clss = 'act';
													$ee = 'Active';
													$wwww = '-';
													$colorrrr = 'style="font-size: 10px;padding: 0;line-height: 1.3;"';
//													$bbbbb = "<a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid #bbb;' class='btn {$clss}'>{$ee}</a>";
													$bbbbb = "";
													$dddd = "";
													$wwwws = '';
												}
												if($rows1['con_sts'] == 'Inactive'){
													$clss = 'inact';
													$ee = 'Inactive';
													$colorrrr = 'style="color: red;padding: 0;font-size: 10px;font-weight: bold;line-height: 1.3;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = $ee.' in application but Active in Mikrotik Since '.$rowcon['update_date'].' by '.$empname;
//													$bbbbb = "<a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid #bbb;line-height: 1;' href='NetworkActiveTOInactive?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts1()'>Inactive<br>him<br>in<br>Mikrotik</a>";
													$bbbbb = "";
//													$dddd = "OR<br><a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid #bbb;color: green;line-height: 1;' href='ClientStatus?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Active<br>him<br>in<br>App</a>";
													$dddd = "";
													$wwwws = '';
												}
											}
											
								if($user_type == 'admin' || $user_type == 'superadmin'){
									echo "<tr class='gradeX' style='line-height: 1.2;'>
											<td class='center' $colorrrr>".$bbb."<br>". $rows1['c_name'] ."<br> ".$bbbcell."</td>
											<td class='center' $colorrrr><b style='line-height: 1.3;'>" . $x_value['address'] ."<br>" . $x_value['uptime'] ."<br>" . $x_value['caller-id'] ."</b></td>
											<td class='center' style='padding: 8px 0px 2px 2px;'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li $colorrrr><b style='line-height: 1.3;'>".$wwwws."".$bbbbb."<br>".$dddd."</b></li>
												</ul>
											</td>
										</tr>";
								}
								}
								 $API->disconnect();

						}
						else{echo 'Selected Network are not Connected.';}
?>
</tbody>
</table>

				<?php } else{ ?>
				
				<table id="dyntable2" class="table table-bordered responsive">
                    <colgroup>
						<col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
						<?php if($userr_typ == 'mreseller'){?>
                            <th class="head0" style="font-size: 10px;padding: 5px;text-align: center;">PPPoE ID</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">Left</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">ACTION</th>
						<?php } else{if($type == 'macclient'){?>
							<th class="head0" style="font-size: 10px;padding: 5px;text-align: center;">PPPoE ID</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">Left</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">ACTION</th>
						<?php } else{?>
							<th class="head0" style="font-size: 10px;padding: 5px;text-align: center;">Client ID</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">Mobile</th>
							<th class="head1" style="font-size: 10px;padding: 5px;text-align: center;">ACTION</th>
						<?php }} ?>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						$xkey = 0;
								while( $row = mysql_fetch_assoc($sql) )
								{
								if($client_onlineclient_sts == '1'){
									if(in_array($row['c_id'], $itemss1)){
										$clientactive = "<button style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid #0866c6;color: #0866c6;margin-top: 1px;' class='btn '>Online</button>";
										$uptime_val = $itemss_uptime[$row['c_id']];
										$address_val = $itemss_address[$row['c_id']];
										$mac_val = $itemss_mac[$row['c_id']];
									}
									else{
										$clientactive = "<button style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid red;color: red;margin-top: 1px;' class='btn inact'>Offline</button>";
										$uptime_val = '';
										$address_val = '';
										$mac_val = '';
										$running_device = '';
									}
									if(in_array($row['c_id'], $itemss1)){
										$clientactive1 = "<img src='images/icon_led_green.png' style='width: 15px;margin-left: 5px;' alt='Online'/>";
										$uptime_val = $itemss_uptime[$row['c_id']];
										$address_val = $itemss_address[$row['c_id']];
										$mac_val = $itemss_mac[$row['c_id']];
									}
									else{
										$clientactive1 = "<img src='images/icon_led_grey.png' style='width: 12px;margin-left: 5px;' alt='Offline'/>";
										$uptime_val = '';
										$address_val = '';
										$mac_val = '';
										$running_device = '';
									}
								}
								else{
									$clientactive = "";
									$clientactive1 = "";
								}
								if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
										$colllr = 'green';
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
										$colllr = 'red';
									}
									if($row['log_sts'] == '0'){
										$aa = 'btn col2';
										$bb = "<i class='iconfa-unlock'></i>";
										$cc = 'Lock';
									}
									if($row['log_sts'] == '1'){
										$aa = 'btn col3';
										$bb = "<i class='iconfa-lock pad4'></i>";
										$cc = 'Unlock';
									}
									$yrdata1= strtotime($row['termination_date']);
									$enddate = date('d-M, y', $yrdata1);
									
									$diff = abs(strtotime($row['termination_date']) - strtotime($dateTimeee))/86400;
									if($row['termination_date'] < $dateTimeee){ $diff = '0';}
									if($diff <= '7'){
										$colorrrr = 'style="color: red;font-size: 15px;font-weight: bold;padding: 0px;"'; 
										$colorrrrqq = 'style="color: red;font-size: 10px;font-weight: bold;"'; 
									}
									else{
										$colorrrr = 'style="font-size: 15px;font-weight: bold;padding: 0px;"'; 
										$colorrrrqq = 'style="font-size: 10px;font-weight: bold;"'; 
									}
									
								if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets'){
									if($type == 'macclient'){
									echo
										"<tr class='gradeX'>
											<td class='center' rowspan='2'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li style='font-size: 10px;padding: 0 5px 0 0;font-weight: bold;'><a style='line-height: 13px;' href='ClientView?id={$row['c_id']}'>{$row['c_id']}</a>{$clientactive1}<div>{$row['pw']}</div><a style='line-height: 13px;color: green;'>{$address_val} - {$uptime_val}</a><div style='line-height: 13px;'>{$mac_val}</div></li>
												</ul>
											</td>
											<td rowspan='2' class='center' $colorrrr>{$diff}<br><div style='margin-top: 10px;font-size: 10px;'>{$enddate}</div></td>
											<td class='center' style='padding: 0;'>\n"; 
											if(in_array(103, $access_arry)){?>
												<a data-placement='top' data-rel='tooltip' style='font-size: 13px;font-weight: bold;width: 100%;border-radius: 0;padding: 10px 0px 10px 0;' href='ClientStatus?id=<?php echo $row['c_id'];?>' data-original-title='<?php echo $dd;?>' class='btn <?php echo $clss;?>' onclick='return checksts()'><?php echo $ee;?></a>
											<?php } else{?>
												<a data-placement='top' data-rel='tooltip' style='font-size: 13px;font-weight: bold;width: 100%;border-radius: 0;padding: 10px 0px 10px 0;' data-original-title='<?php echo $dd;?>' class='btn <?php echo $clss;?>'><?php echo $ee;?></a>
											<?php }
											echo "</td>
										</tr>
										<tr>
											<td class='center' style='padding: 0;'>
												<form action='ClientsRecharge' method='post' target='_blank'><input type='hidden' name='c_id' value='{$row['c_id']}' /><button class='btn' style='font-size: 10px;font-weight: bold;width: 100%;border-radius: 0;padding: 10px 0px 10px 0;color: #337ab7;background: #ffeaf3;'>Recharge</button></form>
											</td>
										</tr>\n";
									}
									else{
									echo
										"<tr class='gradeX'>
											<td class='center'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li style='font-size: 10px;padding: 0 5px 0 0;'><a style='line-height: 8px;' href='ClientView?id={$row['c_id']}'>{$row['c_id']}</a><div>{$row['c_name']}</div><a style='line-height: 8px;'>{$mac_val}</a></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li style='font-size: 10px;padding: 0 5px 0 0;'><a style='line-height: 8px;' href='tel:{$row['cell']}'>{$row['cell']}</a><div>{$row['z_name']}</div><a style='line-height: 8px;'>{$address_val} - {$uptime_val}</a></li>
												</ul>
											</td>
											<td class='center' style='vertical-align: middle;'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>\n"; 
											if(in_array(103, $access_arry)){?>
													<li><a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid <?php echo $colllr;?>;' href='ClientStatus?id=<?php echo $row['c_id'];?>' data-original-title='<?php echo $dd;?>' class='btn <?php echo $clss;?>' onclick="return checksts()"><?php echo $ee;?></a><?php if($client_onlineclient_sts == '1'){echo '<br>'.$clientactive;}?></li>
											<?php } else{?>
													<li><a data-placement='top' data-rel='tooltip' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid <?php echo $colllr;?>;' data-original-title='<?php echo $dd;?>' class='btn <?php echo $clss;?>'><?php echo $ee;?></a><?php if($client_onlineclient_sts == '1'){echo '<br>'.$clientactive;}?></li>
											<?php }
										echo "</ul>
											</td>
										</tr>\n ";
									}}
								if($userr_typ == 'mreseller'){
									if($type == 'recharge'){
									echo
										"<tr class='gradeX'>
											<td class='center' rowspan='2'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li style='font-size: 10px;padding: 0 5px 0 0;font-weight: bold;'><a style='line-height: 13px;' href='ClientView?id={$row['c_id']}'>{$row['c_id']}</a>{$clientactive1}<div style='line-height: 13px;'>{$row['pw']}</div><a style='line-height: 13px;color: green;'>{$address_val} - {$uptime_val}</a><div style='line-height: 13px;'>{$mac_val}</div></li>
												</ul>
											</td>
											<td rowspan='2' class='center' $colorrrr><div id='Pointdiv1$xkey'><div id='olddate$xkey'>{$diff}<br><div style='margin-top: 10px;font-size: 10px;'>{$enddate}</div></div></div></td>
											<td class='center' style='padding: 0;'>
												<a data-placement='top' data-rel='tooltip' style='font-size: 13px;font-weight: bold;width: 100%;border-radius: 0;padding: 10px 0px 10px 0;' data-original-title='{$dd}' class='btn {$clss}'>{$ee}</a>
											</td>
										</tr>
										<tr id='Pointdiv2$xkey'>
											<td>
												<input type='hidden' name='c_id$xkey' id='c_id$xkey' value='{$row['c_id']}' />
												<input type='hidden' name='old_duration$xkey' id='old_duration$xkey' value='{$diff}' />
												<input type='checkbox' class='gdgdg' name='slno$xkey' id='slno$xkey' value='$xkey'/>
											</td>
										</tr>\n";?>
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
											</script>
												<script type='text/javascript'>
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
																	$('#olddate<?php echo $xkey;?>').html("<table style='width: 100%;'><tr><td style='border-bottom: 1px solid #ddd;border-left: none;'><div style='line-height: 15px;text-align: center;font-size: 10px;' title='Old Date'>"+data.olddate+"</div></td><td style='border-left: 1px solid #ddd;border-right: none;vertical-align: middle;text-align: center;' rowspan='2'><button type='button' class='' style='border-radius: 3px;color: red;border: 1px solid red;' value='"+data.clientid+"&dura="+data.newdurations+"' onClick='getRoutePoint<?php echo $xkey;?>(this.value); run(this);'>OK</button></td></tr><tr><td style='border-left: none;'><a style='color: red;font-size: 10px;font-weight: bold;line-height: 15px;' title='Cost & Days'>Cost: "+data.daycost+"৳ </a><br><b style='color: #337ab7;font-size: 10px;font-weight: bold;line-height: 15px;'>Days: "+data.newdurations+"</b><br><a style='color: green;font-size: 10px;font-weight: bold;' title='New Date'>Till: "+data.newdate+"</a></td></tr></table>");
																	$('#olddatee<?php echo $xkey;?>').html(data.new_duration);
																}
														});
														return false;

														}
														else{
															$('#olddate<?php echo $xkey;?>').html("<div style='font-size: 10px;font-weight: bold;' title='Old Date' id='olddate<?php echo $xkey;?>'><div style='font-size: 15px;font-weight: bold;'><?php echo $diff;?></div><?php echo $enddate;?></div>");
															$('#olddatee<?php echo $xkey;?>').html("<div style='font-size: 10px;font-weight: bold;' id='olddatee<?php echo $xkey;?>'></div>");
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
										"<tr class='gradeX'>
											<td class='center' rowspan='2'>
												<ul class='tooltipsample' style='margin-bottom: 0px !important;'>
													<li style='font-size: 10px;padding: 0 5px 0 0;font-weight: bold;'><a style='line-height: 13px;' href='ClientView?id={$row['c_id']}'>{$row['c_id']}</a>{$clientactive1}<div style='line-height: 13px;'>{$row['pw']}</div><a style='line-height: 13px;color: green;'>{$address_val} - {$uptime_val}</a><div style='line-height: 13px;'>{$mac_val}</div></li>
												</ul>
											</td>
											<td rowspan='2' class='center' $colorrrr>{$diff}<br><div style='margin-top: 10px;font-size: 10px;'>{$enddate}</div></td>
											<td class='center' style='padding: 0;'>
												<a data-placement='top' data-rel='tooltip' style='font-size: 13px;font-weight: bold;width: 100%;border-radius: 0;padding: 10px 0px 10px 0;' href='ClientStatus?id={$row['c_id']}' data-original-title='{$dd}' class='btn {$clss}' onclick='return checksts()'>{$ee}</a>
											</td>
										</tr>
										<tr>
											<td class='center' style='padding: 0;'>
												<form action='ClientsRecharge' method='post' target='_blank'><input type='hidden' name='c_id' value='{$row['c_id']}' /><button class='btn' style='font-size: 10px;font-weight: bold;width: 100%;border-radius: 0;padding: 10px 0px 10px 0;color: #337ab7;background: #ffeaf3;'>Recharge</button></form>
											</td>
										</tr>\n";
									}
								}
								$xkey++;}
							?>
					</tbody>
				</table>
				<?php } ?>
				</span>
			</div>	
	</div>
				
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}

function checksts(){
    return confirm('Change connection status!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}
</script>

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
 
});


$(document).ready(function()
{    
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
 
});

$(document).ready(function()
{    
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
 
});

$(document).ready(function()
{    
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
 
});


$(document).ready(function()
{    
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
 
});
</script>

<?php if($mk_id != ''){?>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
 $(document).ready(function() {
 	 $("#responsecontainer1").load("AutoActiveClientsCount.php?ids=<?php echo $mk_id;?>");
   var refreshId = setInterval(function() {
	  $("#responsecontainer1").load('AutoActiveClientsCount.php?ids=<?php echo $mk_id;?>');
   }, 50);
   $.ajaxSetup({ cache: false });
});
</script>
<?php } ?>
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
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'desc']],
            "sScrollY": "1100px"
        });
    });
</script>