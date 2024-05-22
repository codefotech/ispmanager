<?php
session_start();
$userr_typp = $_SESSION['SESS_USER_TYPE'];
include("conn/connection.php");
include("company_info.php");

mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());

if($client_onlineclient_search_sts == '1'){
	if($client_onlineclient_sts == '1'){
		
	include("mk_api.php");	
	$API = new routeros_api();
	$API->debug = false;	
		
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
					foreach($arrID as $x => $x_value) {
						$items[] = $x_value['name'];
						$itemss_uptime[$x_value['name']] = $x_value['uptime'];
						$itemss_address[$x_value['name']] = $x_value['address'];
						$itemss_mac[$x_value['name']] = $x_value['caller-id'];
					}
				
				if($active_queue == '1'){
				$arrIDD = $API->comm('/ip/arp/getall');
					foreach($arrIDD as $x => $x_valuee) {
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
$padddding = 'style="padding: 5px 0px;"';

if($tot_mk == $mk_offlinecounterr){
	$query12312 ="update app_config set onlineclient_sts = '0'";
	$resuldfsdt = mysql_query($query12312) or die("inser_query failed: " . mysql_error() . "<br />");
}
}
else{
	$padddding = 'style="padding: 15px 0px;"';
}
}
  if($userr_typp != '') 
  {
      $comid     = strip_tags(isset($_POST['com_id']) ? $_POST['com_id'] : '');
      $cid     = strip_tags(isset($_POST['c_id']) ? $_POST['c_id'] : '');
      $cname     = strip_tags(isset($_POST['c_name']) ? $_POST['c_name'] : '');
	  $cell     = strip_tags(isset($_POST['cell']) ? $_POST['cell'] : '');
	  $address     = strip_tags(isset($_POST['address']) ? $_POST['address'] : '');
	  $onu_mac     = strip_tags(isset($_POST['onu_mac']) ? $_POST['onu_mac'] : '');
	  $ip     = strip_tags(isset($_POST['ip']) ? $_POST['ip'] : '');
	  $cable_type     = strip_tags(isset($_POST['cable_type']) ? $_POST['cable_type'] : '');
	  $z_id     = strip_tags(isset($_POST['z_id']) ? $_POST['z_id'] : '');
	  $payment_deadline     = strip_tags(isset($_POST['payment_deadline']) ? $_POST['payment_deadline'] : '');
	  $b_date     = strip_tags(isset($_POST['b_date']) ? $_POST['b_date'] : '');

if($search_with_reseller_client == '1'){
     if($comid != ''){
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.com_id = '$comid' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND address = '$comid' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND address = '$comid' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Company ID: '.$comid;
	}
	 if($cid != ''){
		$ccid = '%'.$cid.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.c_id LIKE '$ccid' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND c_id LIKE '$ccid' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND c_id LIKE '$ccid' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Client ID: '.$cid;
	 }
	 
	  if($cname != ''){
		$ccname = '%'.$cname.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.c_name LIKE '$ccname' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND c_name LIKE '$ccname' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND c_name LIKE '$ccname' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Client Name: '.$cname;
	 }
	 
	 if($cell != ''){
		 $phone = '%'.$cell.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.cell != '' AND c.cell LIKE '$phone' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND cell != '' AND cell LIKE '$phone' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND cell != '' AND cell LIKE '$phone' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Cell No: '.$cell;
	 }
	 
	 if($address != ''){
		$aaa = '%'.$address.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.address != '' AND c.address LIKE '$aaa' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND address != '' AND address LIKE '$aaa' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND address != '' AND address LIKE '$aaa' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Address: '.$address;
	 }
	 if($onu_mac != ''){
		$bbb = $onu_mac.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, m.Name, c.onu_mac, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.onu_mac != '' AND c.onu_mac LIKE '$bbb' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND onu_mac != '' AND onu_mac LIKE '$bbb' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND onu_mac != '' AND onu_mac LIKE '$bbb' AND con_sts = 'Inactive'");
		$searchby = 'Searching By ONU MAC: '.$onu_mac;
	 }
	 if($ip != ''){
		$bbb = $ip.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, m.Name, c.onu_mac, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.ip != '' AND c.ip LIKE '$bbb' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND ip != '' AND ip LIKE '$bbb' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND ip != '' AND ip LIKE '$bbb' AND con_sts = 'Inactive'");
		$searchby = 'Searching By IP Address: '.$ip;
	 }
	 
	 if($cable_type != ''){
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.cable_type != '' AND c.cable_type = '$cable_type' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND cable_type != '' AND cable_type = '$cable_type' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND cable_type != '' AND cable_type = '$cable_type' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Cable Type: '.$cable_type;
	 }
	if($z_id != ''){
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.z_id != '' AND c.z_id = '$z_id' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND z_id != '' AND z_id = '$z_id' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND z_id != '' AND z_id = '$z_id' AND con_sts = 'Inactive'");
		
		$resultff=mysql_query("SELECT * FROM zone WHERE z_id = '$z_id'");
		$row2ff = mysql_fetch_assoc($resultff);
		$z_name = $row2ff['z_name'];
		$searchby = 'Searching By Zone: '.$z_name;
	 }
	 
	 if($payment_deadline != ''){
		if($payment_deadline < '10'){
			$dfhhfh = strlen($payment_deadline);
			if($dfhhfh < '2'){
				$fhhjdj = '0'.$payment_deadline;
			}
			else{
			$fhhjdj = $payment_deadline;
		}
		}
		else{
			$fhhjdj = $payment_deadline;
		}
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.payment_deadline != '' AND c.payment_deadline = '$fhhjdj' ORDER BY c.com_id ASC");
		$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND payment_deadline = '$fhhjdj' AND con_sts = 'Active' ORDER BY id DESC");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND payment_deadline = '$fhhjdj' AND con_sts = 'Inactive' ORDER BY id DESC");
		$searchby = 'Searching By P.Deadline: '.$fhhjdj;
	}
	
	 if($b_date != ''){
		if($b_date < '10'){
			$dfhhfhd = strlen($b_date);
			if($dfhhfhd < '2'){
				$fhhjdjd = '0'.$b_date;
			}
			else{
			$fhhjdjd = $b_date;
		}
		}
		else{
			$fhhjdjd = $b_date;
		}
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.b_date != '' AND c.b_date = '$fhhjdjd' ORDER BY c.com_id ASC");
		$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND b_date = '$fhhjdjd' AND con_sts = 'Active' ORDER BY id DESC");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND b_date = '$fhhjdjd' AND con_sts = 'Inactive' ORDER BY id DESC");
		$searchby = 'Searching By B.Deadline: '.$fhhjdjd;
	}
}
else{
     if($comid != ''){
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.com_id = '$comid' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND address = '$comid' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND address = '$comid' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Company ID: '.$comid;
	}
	 if($cid != ''){
		$ccid = '%'.$cid.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.c_id LIKE '$ccid' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND c_id LIKE '$ccid' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND c_id LIKE '$ccid' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Client ID: '.$cid;
	 }
	 
	  if($cname != ''){
		$ccname = '%'.$cname.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.c_name LIKE '$ccname' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND c_name LIKE '$ccname' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND c_name LIKE '$ccname' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Client Name: '.$cname;
	 }
	 
	 if($cell != ''){
		 $phone = '%'.$cell.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.cell != '' AND c.cell LIKE '$phone' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND cell != '' AND cell LIKE '$phone' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND cell != '' AND cell LIKE '$phone' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Cell No: '.$cname;
	 }
	 
	 if($address != ''){
		$aaa = '%'.$address.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.address != '' AND c.address LIKE '$aaa' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND address != '' AND address LIKE '$aaa' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND address != '' AND address LIKE '$aaa' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Address: '.$address;
	 }
	 if($onu_mac != ''){
		$bbb = $onu_mac.'%';
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, m.Name, c.onu_mac, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.onu_mac != '' AND c.onu_mac LIKE '$bbb' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND onu_mac != '' AND onu_mac LIKE '$bbb' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND onu_mac != '' AND onu_mac LIKE '$bbb' AND con_sts = 'Inactive'");
		$searchby = 'Searching By ONU MAC: '.$onu_mac;
	 }
	 if($cable_type != ''){
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.cable_type != '' AND c.cable_type = '$cable_type' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND cable_type != '' AND cable_type = '$cable_type' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND cable_type != '' AND cable_type = '$cable_type' AND con_sts = 'Inactive'");
		$searchby = 'Searching By Cable Type: '.$cable_type;
	 }
	if($z_id != ''){
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.termination_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user !='1' AND c.z_id != '' AND c.z_id = '$z_id' ORDER BY c.com_id ASC");
	 	$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND z_id != '' AND z_id = '$z_id' AND con_sts = 'Active'");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND z_id != '' AND z_id = '$z_id' AND con_sts = 'Inactive'");
		
		$resultff=mysql_query("SELECT * FROM zone WHERE z_id = '$z_id'");
		$row2ff = mysql_fetch_assoc($resultff);
		$z_name = $row2ff['z_name'];
		$searchby = 'Searching By Zone: '.$z_name;
	 }
	 
	 if($payment_deadline != ''){
		if($payment_deadline < '10'){
			$dfhhfh = strlen($payment_deadline);
			if($dfhhfh < '2'){
				$fhhjdj = '0'.$payment_deadline;
			}
			else{
			$fhhjdj = $payment_deadline;
		}
		}
		else{
			$fhhjdj = $payment_deadline;
		}
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.payment_deadline != '' AND c.mac_user !='1' AND c.payment_deadline = '$fhhjdj' ORDER BY c.com_id ASC");
		$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND payment_deadline = '$fhhjdj' AND con_sts = 'Active' ORDER BY id DESC");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND payment_deadline = '$fhhjdj' AND con_sts = 'Inactive' ORDER BY id DESC");
		$searchby = 'Searching By P.Deadline: '.$fhhjdj;
	}
	
	 if($b_date != ''){
		if($b_date < '10'){
			$dfhhfhd = strlen($b_date);
			if($dfhhfhd < '2'){
				$fhhjdjd = '0'.$b_date;
			}
			else{
			$fhhjdjd = $b_date;
		}
		}
		else{
			$fhhjdjd = $b_date;
		}
		$sql = mysql_query("SELECT c.c_name, c.com_id, e.e_name AS technician, c.c_id, c.payment_deadline, c.b_date, c.onu_mac, m.Name, c.mac_user, c.breseller, c.p_id, p.p_name, p.bandwith, p.p_price, c.raw_download, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw, l.image, l.nid_fond, l.nid_back FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
                                                LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.b_date != '' AND c.b_date = '$fhhjdjd' AND c.mac_user !='1' ORDER BY c.com_id ASC");
		$query2266 = mysql_query("SELECT count(id) as active_count FROM clients WHERE sts = '0' AND mac_user !='1' AND b_date = '$fhhjdjd' AND con_sts = 'Active' ORDER BY id DESC");
		$query66 = mysql_query("SELECT count(id) as inactive_count FROM clients WHERE sts = '0' AND mac_user !='1' AND b_date = '$fhhjdjd' AND con_sts = 'Inactive' ORDER BY id DESC");
		$searchby = 'Searching By B.Deadline: '.$fhhjdjd;
	}
}
	
	$total_count = mysql_num_rows($sql);
	
	$row22222 = mysql_fetch_assoc($query2266);
	$active_count = $row22222['active_count'];
	
	$row666 = mysql_fetch_assoc($query66);
	$inactive_count = $row666['inactive_count'];
	  
	  if($total_count == '0')
	  {
		  echo "<br><br><center><span style='color:red;font-weight: bold;font-size: 30px;'>No Data Found.</span></center>";
	  }
	  else
	  {

?>
	<div class="box box-primary" style="padding: 0px;">
		<div class="box-header">
			<h5 style="font-size: 17px;font-weight: bold;margin: 5px 0 -10px 10px;">Total Found:  <i style="color: #317EAC"><?php echo $total_count;?></i>&nbsp; &nbsp;|&nbsp; &nbsp;Active: <i style="color: #30ad23"><?php echo $active_count;?></i>&nbsp; &nbsp;|&nbsp; &nbsp;Inactive: <i style="color: #e3052e"><?php echo $inactive_count;?></i>&nbsp; &nbsp;|&nbsp; &nbsp;<a style="color:#444;">[ <?php echo $searchby;?> ]</a></h5>
		</div>
		<div class="box-body">
			<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
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
							<th class="head0 center">Com_ID</th>
							<th class="head1">ID/Name/Pass/Cell</th>
							<th class="head0 center">Image</th>
							<th class="head1">Zone/Address/CCR/ONU</th>
							<th class="head0">Package/Joining</th>
							<th class="head1">Deadline</th>
							<th class="head0 center">Status</th>
							<th class="head1">IP/MAC/Uptime</th>
                            <th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
								$x = 1;				
								 
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($client_onlineclient_sts == '1' && $client_onlineclient_search_sts == '1'){
									if(in_array($row['c_id'], $itemss1)){
										$clientactive = "<tr>
															<td class='center' style='border-right: none;border-left: none;'>
																<ul class='tooltipsample'>
																	<b style='color:#0866c6; width: 80px;font-size: 14px;'>Online</b>
																</ul>
															</td>
														</tr>";
										$activecount = 1;
										$inactivecount = 0;
										$colorrr = 'style="color:#0866c6; width: 80px;font-size: 16px;"';
										
										$uptime_val = $itemss_uptime[$row['c_id']];
										$address_val = $itemss_address[$row['c_id']];
										$mac_val = $itemss_mac[$row['c_id']];
									}
									else{
										$clientactive = "<tr>
															<td class='center' style='border-right: none;border-left: none;'>
																<ul class='tooltipsample'>
																	<b style='color:red; width: 80px;font-size: 14px;'>Offline</b>
																</ul>
															</td>
														</tr>";
										$activecount = 0;
										$inactivecount = 1;
										$colorrr = '';
										
										$uptime_val = '';
										$address_val = '';
										$mac_val = '';
									}
									}
									else{
										$clientactive = "";
										$activecount = 0;
										$inactivecount = 0;
										
										$uptime_val = '';
										$address_val = '';
										$mac_val = '';
									}
									
									$activecountt += $activecount;
									$inactivecountt += $inactivecount;
									
									if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
										$colo = 'style="color:green; width: 80px;font-size: 14px;"';
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
										$colo = 'style="color:red; width: 80px;font-size: 14px;"';	
									}
									if($row['log_sts'] == '0'){
										$aa = 'btn col2';
										$bb = "<i class='iconfa-unlock'></i>";
										$cc = 'Lock';
									}else{
										$aa = 'btn col3';
										$bb = "<i class='iconfa-lock pad4'></i>";
										$cc = 'Unlock';
									}
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['raw_download'] .' + U: '.$row['raw_upload'].' + Y: '.$row['youtube_bandwidth'].' = '.$row['total_bandwidth'].'mb <br> Rate: '.$row['total_price'];
									}
									else{
										$hhhh = $row['p_name'].'<br>'.$row['bandwith'].' - '.$row['p_price'].'tk';
									}
									
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
									
									if($row['mac_user'] == '1'){
									$diff = abs(strtotime($row['termination_date']) - strtotime($dateTimeee))/86400;
									if($row['termination_date'] < $dateTimeee){ $diff = '0';}
									if($diff <= '7'){
										$colorrrr = 'style="color: red;font-size: 17px;font-weight: bold;"'; 
									}
									else{
										$colorrrr = 'style="font-size: 17px;font-weight: bold;"'; 
									}
									
										$yrdata1= strtotime($row['termination_date']);
										$enddatess = date('d F, Y', $yrdata1);
										$enddate = "<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b style='color: green;font-size: 12px;'>End Date: {$enddatess}</b>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b style='font-weight: bold;'>Day Remaining:</b> <b $colorrrr>{$diff}</b>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>";
									}
									else{
										$enddate = "<table style='width: 100%;'>
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
												</table>";
									}
									
									echo
										"<tr class='gradeX'>
											<td class='center' style='padding: 25px 0;font-size: 15px;font-weight: bold;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b><br>{$row['pw']}<br>{$row['cell']}</td>
											{$allimg}
											<td>{$row['z_name']}<br>{$row['address']}<br><b>[{$row['Name']}]<br>{$row['onu_mac']}</b></td>
											<td>{$hhhh}<br><br><b>{$row['join_date']}</b></td>
											<td style='padding: 15px 0px;'>
											{$enddate}
											</td>
											<td style='padding: 15px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='center' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample'>
																<b $colo>{$ee}</b>
															</ul>
														</td>
													</tr>
													{$clientactive}
													</tbody>
												</table>
											</td>
											<td><b>{$address_val}</b><br>{$mac_val}<br><b style='color: #008000d9;font-size: 15px;'>{$uptime_val}</b></td>
											<td class='center' style='width: 30px !important;'>
												<ul class='tooltipsample' style='padding: 20px 0;'>
													<li><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='{$row['c_id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;' title='View Profile'><i class='iconfa-eye-open'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}?>
					</tbody>
</table>
		<?php if($client_onlineclient_sts == '1'){?>
			<div class='actionBar' style="padding: 10px;border: 1px solid #ddd;margin-top: 2px;">
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: #0866c6;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Online:  <i><?php echo $activecountt;?></i></div> 
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: red;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Offline: <i><?php echo $inactivecountt;?></i></div> 
			</div>
		<?php } ?>
</div>
</div>

  <?php  } } else{echo "<br><br><center><span style='color:red;font-weight: bold;font-size: 30px;'>You are logged out. Please login again.</span></center>";}?>


<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<style>
#dyntable_length{display: none;}
</style>
