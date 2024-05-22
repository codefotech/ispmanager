<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!

$userr_typp = $_SESSION['SESS_USER_TYPE'];
$maczoneidd = $_SESSION['SESS_MAC_ZID'];
$e_id = $_SESSION['SESS_EMP_ID'];
if($_SESSION['SESS_USER_TYPE'] == '') {
	echo '<script type="text/javascript">window.close()</script>';
}
else{
include("conn/connection.php") ;
include("company_info.php") ;
ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());

$acce_arry = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS page_access FROM module_page WHERE $userr_typp = '1' or $userr_typp = '2'"));
$access_arry = explode(',',$acce_arry['page_access']);

$acce_ary = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS menu_access FROM module WHERE $userr_typp = '1'"));
$access_ary = explode(',',$acce_ary['menu_access']);

  if($_POST) 
  {
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
							$clip = $x_valuee['mac-address'];
							$disableddd = $x_valuee['disabled'];
							if($disableddd == 'false'){
								$macsearch = mysql_query("SELECT c_id FROM clients WHERE mac = '$clip'");
								$macsearchaa = mysql_fetch_assoc($macsearch);	
								if($macsearchaa['c_id'] != ''){
									$itemss[] = $macsearchaa['c_id'];
									$itemss_uptime[] = array();
									$itemss_address[$macsearchaa['c_id']] = $x_valuee['address'];
									$itemss_mac[$macsearchaa['c_id']] = $x_valuee['mac-address'];
								}
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
}


$searchway     = strip_tags(isset($_POST['searchway']) ? $_POST['searchway'] : '');
$ccid = '%'.$searchway.'%';
$ccid1 = $searchway.'%';

if($searchway != ''){
if($search_way == 'c_id'){
	if($userr_typp == 'mreseller'){
	$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
	}
	else{
		if ($userr_typp == 'billing'){
			$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.com_id ASC");
		}
		else{
			$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' ORDER BY c.com_id ASC");
		}
	}
}

elseif($search_way == 'com_id'){
	if($userr_typp == 'mreseller'){
	$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.com_id = '$searchway' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
	}
	else{
		if ($userr_typp == 'billing'){
			$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.com_id = '$searchway' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.com_id ASC");
		}
		else{
			$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.com_id = '$searchway' ORDER BY c.com_id ASC");
		}
	}
}

elseif($search_way == 'c_name'){
	if($userr_typp == 'mreseller'){
	$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_name LIKE '$ccid' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
	}
	else{
		if ($userr_typp == 'billing'){
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_name LIKE '$ccid' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.com_id ASC");
		}
		else{
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_name LIKE '$ccid' ORDER BY c.com_id ASC");
		}
	}
}

elseif($search_way == 'cell'){
	if($userr_typp == 'mreseller'){
	$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.cell LIKE '$ccid' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
	}
	else{
		if ($userr_typp == 'billing'){
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.cell LIKE '$ccid' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.com_id ASC");
		}
		else{
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.cell LIKE '$ccid' ORDER BY c.com_id ASC");
		}
	}
}


elseif($search_way == 'ip'){
	if($userr_typp == 'mreseller'){
	$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.ip LIKE '$ccid1' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
	}
	else{
		if ($userr_typp == 'billing'){
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.ip LIKE '$ccid' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.com_id ASC");
		}
		else{
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.ip LIKE '$ccid' ORDER BY c.com_id ASC");
		}
	}
}

elseif($search_way == 'mac'){
	if($userr_typp == 'mreseller'){
	$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.mac LIKE '$ccid' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
	}
	else{
		if ($userr_typp == 'billing'){
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.mac LIKE '$ccid' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.com_id ASC");
		}
		else{
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.mac LIKE '$ccid' ORDER BY c.com_id ASC");
		}
	}
}

else{
	if($userr_typp == 'mreseller'){
	$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
	}
	else{
		if ($userr_typp == 'billing'){
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' AND FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY c.com_id ASC");
		}
		else{
				$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, c.ip, c.mac, c.total_price, c.breseller, c.total_bandwidth, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
							LEFT JOIN zone AS z
							ON z.z_id = c.z_id
							LEFT JOIN package AS p
							ON p.p_id = c.p_id 
							LEFT JOIN login AS l
							ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' ORDER BY c.com_id ASC");
		}
	}
}

while( $roww = mysql_fetch_assoc($sqlser) )
								{
$c_iddd = $roww['c_id'];

if($roww['image'] == ''){
	$img = 'emp_images/no_img.jpg';
}
else{
	$img = $roww['image'];
}

	if($roww['con_sts'] == 'Active'){
		$collo = 'style="color: #008000c4;line-height: normal;"';
		if(in_array(29, $access_ary)){
			if($roww['breseller'] == '2'){
				$cngpkg = "<form action='ClientEditMonthlyInvoice' method='post' data-placement='top' data-rel='tooltip' title='Change Package' style='float: left;' target='_blank'><input type='hidden' name='cid' value='$c_iddd' /><input type='hidden' name='ccccc_id' value='$c_iddd' /><button class='btn ownbtn6' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;'><i class='iconfa-signout'></i></button></form>";
			}
			else{
				$cngpkg = "<form action='PackageChange' method='post' data-placement='top' data-rel='tooltip' title='Change Package' style='float: left;' target='_blank'><input type='hidden' name='cid' value='$c_iddd' /><input type='hidden' name='ccccc_id' value='$c_iddd' /><button class='btn ownbtn6' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;'><i class='iconfa-signout'></i></button></form>";
			}
		}
		else{
			$cngpkg = "";
		}
	}
	else{
		$collo = 'style="color: #ff0000ab;line-height: normal;"';
		$cngpkg = "";
	}

if($roww['mac_user'] == '0'){
if($roww['breseller'] == '2'){
$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(total_price) AS bill FROM billing_invoice WHERE sts = '0' GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment WHERE sts = '0' GROUP BY c_id)p
						ON p.c_id = c.c_id
						WHERE c.c_id = '$c_iddd'");
}
else{
$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$c_iddd'");
}
$rows = mysql_fetch_array($sql2);
	
	if($rows['due'] > '0'){
		$colllo = 'style="color: #ff0000ba;line-height: normal;font-weight: bold;"';
	}
	else{
		$colllo = 'style="color: #008000c4;line-height: normal;"';
	}
		if(in_array(128, $access_arry)){
			$cashpayment = "<form action='PaymentAdd' method='post' data-placement='top' data-rel='tooltip' title='Add Cash Payment' style='float: left;' target='_blank'><input type='hidden' name='ccccc_id' value='$c_iddd' /><input type='hidden' name='c_id' value='$c_iddd' /><button class='btn ownbtn3' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;'><i class='iconfa-money'></i></button></form>";
		}
		if(in_array(129, $access_arry)){
			$onlinepayment = "<form action='PaymentOnlineAdd' method='post' data-placement='top' data-rel='tooltip' title='Add Online Payment' style='float: left;' target='_blank'><input type='hidden' name='ccccc_id' value='$c_iddd' /><input type='hidden' name='c_id' value='$c_iddd' /><button class='btn ownbtn8' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;'><i class='iconfa-shopping-cart'></i></button></form>";
		}
		if(in_array(128, $access_arry) || in_array(129, $access_arry)){
			$payment_recharge = $onlinepayment.' '.$cashpayment;
		}
		else{
			$payment_recharge = "";
		}
	
	$pdbd = '[PD:'.$roww['payment_deadline'].' | BD:'.$roww['b_date'].']';
	$totaldue = 'Total Due: '.$rows['due'].'৳';
	$totaldue1 = '';
	$remainingdays = '';
	if($userr_typp != 'mreseller'){
		if(in_array(132, $access_arry)){
			$bill_adjustment = "<form action='ClientsBillAdjust' method='post' data-placement='top' data-rel='tooltip' title='Bill Adjustment' style='float: left;' target='_blank'><input type='hidden' name='c_id' value='$c_iddd' /><input type='hidden' name='ccccc_id' value='$c_iddd' /><input type='hidden' name='usertype' value='$userr_typp' /><button class='btn ownbtn4' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;'><i class='iconfa-refresh'></i></button></form>";
		}
		else{
			$bill_adjustment = "";
		}
	}
	else{
		$bill_adjustment = "";
	}
	if(in_array(104, $access_arry)){
		$clientview = "<form action='ClientView' method='post' data-placement='top' data-rel='tooltip' title='Profile' style='float: left;' target='_blank'><input type='hidden' name='ids' value='{$c_iddd}' /><input type='hidden' name='ccccc_id' value='{$c_iddd}' /><button class='btn ownbtn3' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;color: #0866c6;'><i class='iconfa-eye-open'></i></button></form>";
	}
	else{
		$clientview = "";
	}
	if(in_array(101, $access_arry)){
		if($roww['breseller'] == '2'){
			$clientedit = "<form action='ClientEditInvoice' method='post' data-placement='top' data-rel='tooltip' title='Edit' style='float: left;' target='_blank'><input type='hidden' name='c_id' value='{$c_iddd}' /><input type='hidden' name='ccccc_id' value='{$c_iddd}' /><button class='btn ownbtn2' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;color: #f200d8a8;'><i class='iconfa-edit'></i></button></form>";
		}
		else{
			$clientedit = "<form action='ClientEdit' method='post' data-placement='top' data-rel='tooltip' title='Edit' style='float: left;' target='_blank'><input type='hidden' name='c_id' value='{$c_iddd}' /><input type='hidden' name='ccccc_id' value='{$c_iddd}' /><button class='btn ownbtn2' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;color: #f200d8a8;'><i class='iconfa-edit'></i></button></form>";
		}
	}
	else{
		$clientedit = "";
	}
}
else{
	if(in_array(115, $access_arry) || $userr_typp == 'mreseller'){
		$colllo = 'style="line-height: normal;"';
		if(in_array(107, $access_arry) || $userr_typp == 'mreseller'){
			$payment_recharge = "<form action='ClientsRecharge' method='post' data-placement='top' data-rel='tooltip' title='Recharge' style='float: left;' target='_blank'><input type='hidden' name='ccccc_id' value='$c_iddd' /><input type='hidden' name='c_id' value='$c_iddd' /><button class='btn ownbtn3' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;'><i class='iconfa-globe'></i></button></form>";
		}
		else{
			$payment_recharge = "";
		}
		$pdbd = '[Termination Date: '.$roww['terminationdate'].']';
		
	$yrdata1= strtotime($roww['termination_date']);
	$enddate = date('d F, Y', $yrdata1);
										
	$diff = abs(strtotime($roww['termination_date']) - strtotime($dateTimeee))/86400;
	if($roww['termination_date'] < $dateTimeee){ $diff = '0';}
	if($diff <= '7'){
		$colorrrr = 'style="color: red;font-weight: bold;padding: 0px;line-height: normal;"'; 
	}
	else{
		$colorrrr = 'style="font-weight: bold;color: blue;font-weight: bold;padding: 0px;line-height: normal;"'; 
	}
		$totaldue = '';
		$totaldue1 = 'Remaining: '.$diff.' Days';
		$remainingdays = 'Remaining: <a '.$colorrrr.'>'.$diff.'</a> Days';
		if($userr_typp == 'mreseller'){
			$bill_adjustment = "<form action='ClientsBillAdjust' method='post' data-placement='top' data-rel='tooltip' title='Bill Adjustment' style='float: left;' target='_blank'><input type='hidden' name='ccccc_id' value='$c_iddd' /><input type='hidden' name='c_id' value='$c_iddd' /><input type='hidden' name='usertype' value='$userr_typp' /><button class='btn ownbtn4' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;'><i class='iconfa-refresh'></i></button></form>";
		}
		else{
			$bill_adjustment = "";
		}
		if(in_array(104, $access_arry) || $userr_typp == 'mreseller'){
			$clientview = "<form action='ClientView' method='post' data-placement='top' data-rel='tooltip' title='Profile' style='float: left;' target='_blank'><input type='hidden' name='ids' value='{$c_iddd}' /><input type='hidden' name='ccccc_id' value='{$c_iddd}' /><button class='btn ownbtn3' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;color: #0866c6;'><i class='iconfa-eye-open'></i></button></form>";
		}
		else{
			$clientview = "";
		}
		
		if(in_array(101, $access_arry) || $userr_typp == 'mreseller'){
			$clientedit = "<form action='ClientEdit' method='post' data-placement='top' data-rel='tooltip' title='Edit' style='float: left;' target='_blank'><input type='hidden' name='c_id' value='{$c_iddd}' /><input type='hidden' name='ccccc_id' value='{$c_iddd}' /><button class='btn ownbtn2' style='padding: 0px 2px 0px 2px;font-size: 12px;border: none;background: none;color: #f200d8a8;'><i class='iconfa-edit'></i></button></form>";
		}
		else{
			$clientedit = "";
		}
	}
}
if($client_onlineclient_search_sts == '1'){
	if($client_onlineclient_sts == '1'){
		if(in_array($c_iddd, $itemss1)){
			$clientactive = "<img src='images/icon_led_green.png' style='width: 15px;margin-left: 5px;' />";
			
			$uptime_val = $itemss_uptime[$c_iddd];
			$address_val = $itemss_address[$c_iddd];
			$mac_val = $itemss_mac[$c_iddd];
		}
		else{
			$clientactive = "<img src='images/icon_led_grey.png' style='width: 12px;margin-left: 5px;' />";
			
			$uptime_val = '';
			$address_val = '';
			$mac_val = '';
		}
	}
	else{
		$clientactive = "";
	}
}

if($roww['breseller'] == '1'){
	$packprice = $roww['total_price'];
	$bandwidthh = $roww['total_bandwidth'].'mb';
}
else{
	$packprice = $roww['p_price'];
	$bandwidthh = $roww['p_name'].'-'.$roww['bandwith'];
}
								echo
								"<li style='overflow: hidden;padding: 5px 0 3px 0;border-bottom: 1px solid gainsboro;line-height: 13px;'><img src='{$img}' width='45' height='45' class='userthumb' title='Com ID: {$roww['com_id']}\r\nName: {$roww['c_name']}\r\nZone: {$roww['z_name']}\r\nAddress: {$roww['address']}\r\nCell: {$roww['cell']}\r\nPackage: {$bandwidthh}\r\nPrice: {$packprice}৳ \r\n{$totaldue}{$totaldue1}\r\nIP: {$roww['ip']}\r\nMAC: {$roww['mac']}\r\n{$pdbd}' style='margin-left: 7px;border: 2px solid #8080804f;'/><strong title='{$roww['c_name']}\r\n{$roww['cell']}'>{$c_iddd}{$clientactive}</strong><small><span style='color: #0866c6;line-height: normal;'>[{$address_val}-{$uptime_val}]</span> <span {$collo}>[{$roww['con_sts']}]</span></small><br/><small title='{$roww['p_name']}-{$roww['bandwith']}\r\nPrice: {$roww['p_price']}৳ \r\n{$pdbd}'><span {$colllo}>{$totaldue}{$remainingdays}</span></small><br>
								{$clientview}
								{$clientedit}
								{$cngpkg}
								{$payment_recharge}
								{$bill_adjustment}
								</li>";
								}
							?>


<?php  }} else{} }?>
