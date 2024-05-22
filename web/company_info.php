<?php
//session_start();
$e_id = $_SESSION['SESS_EMP_ID'];
include("conn/connection.php") ;

$PageNameee = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); 

$query2 = mysql_query("SELECT name, phone, address, address2, com_email, website, gapikey, logo, use_diagram_client, external_online_link, external_online_link_mac, online_off, invoice_note1, invoice_note2, invoice_note3, invoice_note4, invoice_note5, invoice_logo_size, tree_sts, latitude, longitude, tis_api, tisapisms, version, copmaly_boss_cell, minimize_load, mainlink, weblink, mlink, onlineclient_sts, search_with_reseller, search_way, onlineclient_search_sts, client_terminate, reseller_downgrade, tis_id, user_limit, bill_amount, ppoe_comment, location_service, clients_per_del, delete_clients_till, reseller_per_del, delete_reseller_till, active_queue, sts, edit_last_id, inactive_way, realtime_graph, cpu, cpu_interval, reseller_client_login, reseller_client_online_payment_sts, division_id, district_id, upazila_id, union_id, chat_access FROM app_config");
$row2 = mysql_fetch_assoc($query2);
$comp_name = $row2['name'];
$version = $row2['version'];
$company_cell = $row2['phone'];
$copmaly_boss = $row2['copmaly_boss_cell'];
$copmaly_address = $row2['address'];
$copmaly_address2 = $row2['address2'];
$copmaly_com_email = $row2['com_email'];
$copmaly_website = $row2['website'];
$copmaly_latitude = $row2['latitude'];
$copmaly_longitude = $row2['longitude'];$gapikey = $row2['gapikey'];
$mainlink = $row2['mainlink'];
$weblink = $row2['weblink'];
$mlink = $row2['mlink'];
$tis_id = $row2['tis_id'];
$com_sts = $row2['sts'];
$com_ststis = $row2['sts'];
$monthly_bill_amount = $row2['bill_amount'];
$edit_last_id = $row2['edit_last_id'];
$user_limit = $row2['user_limit'];
$ppoe_comment = $row2['ppoe_comment'];
$online_btn_off = $row2['online_off'];
$location_service = $row2['location_service'];
$active_queue = $row2['active_queue'];
$reseller_downgrade = $row2['reseller_downgrade'];
$client_terminate = $row2['client_terminate'];
$client_use_diagram_client = $row2['use_diagram_client'];
$external_online_link = $row2['external_online_link'];
$external_online_link_mac = $row2['external_online_link_mac'];
$reseller_client_login = $row2['reseller_client_login'];
$reseller_client_online_payment_sts = $row2['reseller_client_online_payment_sts'];
$chat_access = explode(',',$row2['chat_access']);
 
if($online_btn_off == '0'){
	$client_onlineclient_sts = $row2['onlineclient_sts'];
}
else{
	$client_onlineclient_sts = '0';
}

$client_onlineclient_search_sts = $row2['onlineclient_search_sts'];
$tree_sts_permission = $row2['tree_sts'];
$inactive_way_sts = $row2['inactive_way'];
//$search_way = $row2['search_way'];
$realtime_graph_sts = $row2['realtime_graph'];
$cpu_load = $row2['cpu'];
$cpu_interval = $row2['cpu_interval'];
$clients_per_delete = $row2['clients_per_del'];
$delete_clients_till_time = $row2['delete_clients_till'];
$reseller_per_delete = $row2['reseller_per_del'];
$delete_reseller_till_time = $row2['delete_reseller_till'];
$minimize_data_load = $row2['minimize_load'];
$tis_api = $row2['tis_api'];
$tisapismsss = $row2['tisapisms'];
$search_with_reseller_client = $row2['search_with_reseller'];
$company_main_logo = $row2['logo'];
$invoice_note1 = $row2['invoice_note1'];
$invoice_note2 = $row2['invoice_note2'];
$invoice_note3 = $row2['invoice_note3'];
$invoice_note4 = $row2['invoice_note4'];
$invoice_note5 = $row2['invoice_note5'];
$invoice_logo_size = $row2['invoice_logo_size'];
$company_division_id = $row2['division_id'];
$company_district_id = $row2['district_id'];
$company_upazila_id = $row2['upazila_id'];
$company_union_id = $row2['union_id'];

//$query2ddd = mysql_query("SELECT last_search FROM app_search WHERE e_id = '$e_id' AND last_search != '' ORDER BY id DESC LIMIT 1");
//$row2sss = mysql_fetch_assoc($query2ddd);
$last_search = $row2sss['last_search'];

if($last_search == ''){
	$search_way = $row2['search_way'];
}
else{
	$search_way = $last_search;
}
//$sqllimi = mysql_query("SELECT id FROM clients WHERE sts = '0' AND con_sts = 'Active'");
//$total_client = mysql_num_rows($sqllimi);

$limit_access = 10000 - $total_client;
if($limit_access >= '0'){
	$limit_accs = 'Yes';
} else{
	$limit_accs = 'No';
}

//$onlinepayyy = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS online_payment FROM payment_online_setup WHERE sts = '0'"));
//$online_getway = explode(',',$onlinepayyy['online_payment']);

//$onlineweb = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS online_webhook FROM payment_online_setup WHERE webhook_sts = '0'"));
//$online_webhook_getway = explode(',',$onlineweb['online_webhook']);

//ini_alter('date.timezone','Asia/Almaty');

// Display the page loading time
$user_infoo = 'Your IP: '.$_SERVER['REMOTE_ADDR'].'  |  '.date("jS F, Y h:i A");
$footer = '&copy; '.date('Y', time()).'. <a href="">One Man</a>, All Rights Reserved  |  '.$version.' ';

if($PageNameee != 'index.php'){
$desin_by = '';
}

//------------TIS API-----------
if($tis_api == '1'){
//$fulllinkk= 'https://tis.web.asthatec.net/tisapi.php?tis_id='.$tis_id;

//$chhhh = curl_init();
//curl_setopt($chhhh, CURLOPT_URL, $fulllinkk); 
//curl_setopt($chhhh, CURLOPT_RETURNTRANSFER,1); // return into a variable 
//curl_setopt($chhhh, CURLOPT_TIMEOUT, 10); 
//$alldata = curl_exec($chhhh);
//$tisapi = json_decode($alldata, true);

$constssss = 'Active';
$billamounttta = $tisapi['bill_amount'];
$userlimittt = $tisapi['user_limit'];
$tisdueuu = $tisapi['tisdue'];
$tislogout = $tisapi['logout'];
$logout_till = $tisapi['logout_till'];

$date_noww = date('Y-m-d H:i:s', time());

if($tislogout == '1' && $logout_till > $date_noww){
	session_unset();
	session_destroy();
}

if($constssss == 'Active'){
	$connstsaa = '0';
}
else{
	$connstsaa = '1';
	session_unset();
	session_destroy();
} 

if($alldata != ''){
if($connstsaa != $com_ststis){
//	$query1q ="UPDATE app_config SET sts = '$connstsaa' WHERE tis_id = '$tis_id'";
	if (!mysql_query($query1q)){die('Error: ' . mysql_error());}
}

if($billamounttta != $monthly_bill_amount){
//	$query1qe ="UPDATE app_config SET bill_amount = '$billamounttta' WHERE tis_id = '$tis_id'";
	if (!mysql_query($query1qe)){die('Error: ' . mysql_error());}
}

if($userlimittt != $user_limit){
//	$query1qe ="UPDATE app_config SET user_limit = '$userlimittt' WHERE tis_id = '$tis_id'";
	if (!mysql_query($query1qe)){die('Error: ' . mysql_error());}
}
}
}
 
//------------TIS News API-----------
if($tisapismsss == '1'){
//$fulllinkk1= 'https://tis.web.asthatec.net/tisapisms.php?tis_id='.$tis_id;

//$chhhh1 = curl_init();
//curl_setopt($chhhh1, CURLOPT_URL, $fulllinkk1); 
//curl_setopt($chhhh1, CURLOPT_RETURNTRANSFER,1); // return into a variable 
//curl_setopt($chhhh1, CURLOPT_TIMEOUT, 10); 
//$alldata1 = curl_exec($chhhh1);
//$tisapinews = json_decode($alldata1, true);

$news_body = $tisapinews['sms_body'];
$news_body1 = $tisapinews['sms_body1'];
}
?>