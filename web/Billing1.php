<?php
$titel = "Billing";
$Billing = 'active';
$_SESSION['module_name'] = $Billing;
include("conn/connection.php") ;
include("mk_api.php");
include('include/hader.php');
date_default_timezone_set('Etc/GMT-6');
$type = isset($_GET['id']) ? $_GET['id']  : '';

extract($_POST); 
$dateTime = date('Y-m-d', time());
$dateTimedd = date('Y-m-01', time());

if(empty($_POST['bill_month'])){
$todaydate = date('Y-m-d', time());
$thismonth = date('F-Y', time());
$t_edate = date('Y-m-01', time());
$f_edate = date('Y-m-d', time());
}
else{
$todaydate = $bill_month;
$yrdata= strtotime($bill_month);
$thismonth = date('F-Y', $yrdata);
$t_edate = date('Y-m-01', strtotime($bill_month));
$f_edate = date('Y-m-t', strtotime($bill_month));
}


$API = new routeros_api();
$API->debug = false;


if($client_onlineclient_sts == '1' && $user_type == 'mreseller' || $client_onlineclient_sts == '1' && $type != ''){
$items = array();
$itemss = array();
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
					}
				
				if($active_queue == '1'){
				$arrIDD = $API->comm('/ip/arp/getall');
					foreach($arrIDD as $x => $x_valuee) {
							$clip = $x_valuee['address'];
							$macsearch = mysql_query("SELECT c_id FROM clients WHERE ip = '$clip'");
							$macsearchaa = mysql_fetch_assoc($macsearch);	
							if($macsearchaa['c_id'] != ''){
								$itemss[] = $macsearchaa['c_id'];
							}
					}
				}
				else{
					$itemss = array();
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
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];

$access = mysql_query("SELECT * FROM module WHERE module_name = 'Billing' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '11' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

						if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets' || $user_type == 'billing'){
								if($type == 'all' && in_array(135, $access_arry)){
									if($user_type == 'billing'){
									$sql = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.com_id, l.emp_id, l.z_name, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.emp_id, x.z_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.com_id, c.c_name, c.payment_deadline, m.Name AS mk_name, c.b_date, c.address, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) > '1' AND l.emp_id = '$e_id'  ORDER BY l.com_id asc");
												
									$sql3 = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.emp_id, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
												(SELECT x.amt, x.c_id, x.c_name, x.payment_deadline, x.mk_name, x.b_date, x.emp_id, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.c_name, c.address, z.emp_id, c.payment_deadline, m.Name AS mk_name, c.b_date, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id 
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) <= '0' AND l.emp_id = '$e_id'  ORDER BY l.c_id");
								
									$tot_allbills = mysql_num_rows($sql);
									$tot_allpaid = mysql_num_rows($sql3);
									$tot_allunpaid = $tot_allbills - $tot_allpaid;
									
									
									
									$tit = "<div class='box-header'>
												<div class='hil'> Due Bills : <i style='color: #e3052e'>{$tot_allbills}</i></div> 
											</div>";
									}
									
									else{
										$sql = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.com_id, l.z_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.emp_id, x.z_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.c_name, c.com_id, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id asc");
									
									$sql3 = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
												(SELECT x.amt, x.c_id, x.c_name, x.payment_deadline, x.mk_name, x.b_date, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.c_name, c.address, c.raw_download, c.payment_deadline, m.Name AS mk_name, c.b_date, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id 
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) <= '0' ORDER BY l.c_id");
												
									$tot_allbills = mysql_num_rows($sql);
									$tot_allpaid = mysql_num_rows($sql3);
									$tot_allunpaid = $tot_allbills - $tot_allpaid;
									
									
									
									$tit = "<div class='box-header'>
												<div class='hil'> Total Bill :  <i style='color: #317EAC'>{$tot_allbills}</i></div> 
												<div class='hil'> Paid :  <i style='color: #30ad23'>{$tot_allpaid}</i></div> 
												<div class='hil'> Due Bills : <i style='color: #e3052e'>{$tot_allunpaid}</i></div> 
											</div>";
									}
									
								}
								
								if($type == 'invoice_client' && in_array(135, $access_arry)){
									if($user_type == 'billing'){
									$sql = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.com_id, l.z_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.emp_id, x.z_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto FROM
													(SELECT b.c_id, c.c_name, c.com_id, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.total_price) AS amt, c.note, c.note_auto
													FROM billing_invoice AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) > '1' AND l.emp_id = '$e_id'  ORDER BY l.com_id asc");
												
									$sql3 = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
												(SELECT x.amt, x.c_id, x.c_name, x.payment_deadline, x.mk_name, x.b_date, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto FROM
													(SELECT b.c_id, c.c_name, c.address, c.raw_download, c.payment_deadline, m.Name AS mk_name, c.b_date, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto
													FROM billing_invoice AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id 
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) <= '0' AND l.emp_id = '$e_id'  ORDER BY l.c_id");
								
									$tot_allbills = mysql_num_rows($sql);
									$tot_allpaid = mysql_num_rows($sql3);
									$tot_allunpaid = $tot_allbills - $tot_allpaid;
									
									
									
									$tit = "<div class='box-header'>
												<div class='hil'> Due Bills : <i style='color: #e3052e'>{$tot_allbills}</i></div> 
											</div>";
									}
									
									else{
										$sql = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.com_id, l.z_name, l.emp_id, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.emp_id, x.z_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto FROM
													(SELECT b.c_id, c.c_name, c.com_id, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.total_price) AS amt, c.note, c.note_auto
													FROM billing_invoice AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id ORDER BY l.com_id asc");
									
									$sql3 = mysql_query("SELECT l.c_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
												(SELECT x.amt, x.c_id, x.c_name, x.payment_deadline, x.mk_name, x.b_date, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto FROM
													(SELECT b.c_id, c.c_name, c.address, c.raw_download, c.payment_deadline, m.Name AS mk_name, c.b_date, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto
													FROM billing_invoice AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id 
													LEFT JOIN mk_con AS m ON m.id = c.mk_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) <= '0' ORDER BY l.c_id");
												
									$tot_allbills = mysql_num_rows($sql);
									$tot_allpaid = mysql_num_rows($sql3);
									$tot_allunpaid = $tot_allbills - $tot_allpaid;
									
									
									
									$tit = "<div class='box-header'>
												<div class='hil'> Total Bill :  <i style='color: #317EAC'>{$tot_allbills}</i></div> 
												<div class='hil'> Paid :  <i style='color: #30ad23'>{$tot_allpaid}</i></div> 
												<div class='hil'> Due Bills : <i style='color: #e3052e'>{$tot_allunpaid}</i></div> 
											</div>";
									}
									
								}
								
								if($type == 'search' && in_array(138, $access_arry)){
									$ziddd = $_POST['z_id'];
									$p_mmmm = $_POST['p_m'];
									$stsssss = $_POST['sts'];
									$constsss = $_POST['con_sts'];
									$df_dateeee = $_POST['df_date'];
									$dt_dateeee = $_POST['dt_date'];
										$sqlww = "SELECT t1.id, t1.c_id, t1.com_id, t1.c_name, t1.payment_deadline, t1.mk_name, t1.b_date, t1.address, t1.raw_download, t1.breseller, t1.mac_user, t1.raw_upload, t1.youtube_bandwidth, t1.total_bandwidth, t1.bandwidth_price, t1.youtube_price, t1.total_price, t1.join_date, t1.z_name, t1.p_name, t1.discount, t1.extra_bill, t1.con_sts, t1.note, t1.cell, t1.p_price, t2.dis, t2.bill, t1.note_auto, IFNULL(t3.bill_disc, 0) AS bill_disc, t1.p_m, IFNULL(t3.pay, 0) AS pay, (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) AS payable FROM
												(
												SELECT c.id, c.c_id, c.com_id, c.c_name, c.payment_deadline, m.Name AS mk_name, c.b_date, c.con_sts, c.address, c.raw_download, c.breseller, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, IFNULL(c.discount, 0.00) AS discount, IFNULL(c.extra_bill, 0.00) AS extra_bill, z.z_name, c.cell, c.email, c.p_id, p.p_price, c.note, c.p_m, p.p_name, c.mac_user, c.note_auto FROM clients AS c 
												LEFT JOIN package AS p ON c.p_id = p.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id
												WHERE c.mac_user != '1'";  							
									if ($ziddd != 'all') {
										$sqlww .= " AND c.z_id = '{$ziddd}'";
									}
									if ($p_mmmm != 'all') {
										$sqlww .= " AND c.p_m = '{$p_mmmm}'";
									}
									if ($stsssss != 'all') {
										$sqlww .= " AND c.sts = '{$stsssss}'";
									}
									if ($constsss != 'all') {
										$sqlww .= " AND c.con_sts = '{$constsss}'";
									}
									if ($df_dateeee != 'all' && $dt_dateeee != 'all'){
										$sqlww .= " AND c.payment_deadline BETWEEN '{$df_dateeee}' AND '{$dt_dateeee}'";
									}
									if ($df_dateeee != 'all' && $dt_dateeee == 'all'){
										$sqlww .= " AND c.payment_deadline BETWEEN '{$df_dateeee}' AND '{$df_dateeee}'";
									}
									if ($df_dateeee == 'all' && $dt_dateeee == 'all'){
										$sqlww .= "";
									}
									if ($df_dateeee == 'all' && $dt_dateeee != 'all'){
										$sqlww .= " AND c.payment_deadline BETWEEN '{$dt_dateeee}' AND '{$dt_dateeee}'";
									}
										$sqlww .= ")t1
												LEFT JOIN
												(
												SELECT b.c_id, SUM(b.bill_amount) AS bill, SUM(b.discount) AS dis FROM billing AS b
												GROUP BY b.c_id
												)t2
												ON t1.c_id = t2.c_id
												LEFT JOIN
												(
												SELECT p.c_id, SUM(p.pay_amount) AS pay, SUM(p.bill_discount) AS bill_disc FROM payment AS p 											
												GROUP BY p.c_id
												)t3
												ON t1.c_id = t3.c_id"; 
									if (isset($_POST['partial']) != 'all'){
										if(isset($_POST['partial']) != '1'){
											$sqlww .= " WHERE IFNULL(t3.pay, 0)+IFNULL(t3.bill_disc, 0) = '0' AND (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
										}
										else{
											$sqlww .= " WHERE IFNULL(t3.pay, 0)+IFNULL(t3.bill_disc, 0) != '0' AND (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
										}
									}
									else{
											$sqlww .= " WHERE (t2.bill - (IFNULL(t3.pay, 0.00)+IFNULL(t3.bill_disc, 0))) > '0.99'";
										}
											$sqlww .= " ORDER BY t1.id DESC";
										
										$sql = mysql_query($sqlww);
										
									$totallbills = mysql_num_rows($sql);
									
									$tit = "<div class='box-header'>
												<div class='hil'> Total Clients: <i style='color: #e3052e'>{$totallbills}</i></div> 
											</div>";
								}
								
								if($type == 'unpaid' && in_array(137, $access_arry)){
									if($user_type == 'billing'){
									$sql = mysql_query("SELECT l.c_id, l.c_name, l.com_id, l.payment_deadline, l.mk_name, l.b_date, l.emp_id, l.z_name, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.amt, x.com_id, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.emp_id, x.z_name, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.c_name, c.com_id, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, z.emp_id, z.z_name, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) > '1' AND l.emp_id = '$e_id'  ORDER BY l.com_id asc");
												
									}
									else{
										$sql = mysql_query("SELECT l.c_id, l.com_id, l.z_name, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.com_id, x.z_name, x.amt, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.com_id, c.c_name, z.z_name, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) > '1' ORDER BY l.com_id asc");
										
									}
									$tot_allbills = mysql_num_rows($sql);
									
									$tit = "<div class='box-header'>
												<div class='hil'> Due Bills: <i style='color: #e3052e'>{$tot_allbills}</i></div> 
											</div>";
								}
								
								if($type == 'paid' && in_array(136, $access_arry)){
									if($user_type == 'billing'){
									$sql = mysql_query("SELECT l.c_id, l.com_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.emp_id, l.z_name, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.com_id, x.amt, x.payment_deadline, x.mk_name, x.b_date, x.emp_id, x.z_name, x.c_id, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.com_id, c.c_name, z.emp_id, c.payment_deadline, m.Name AS mk_name, c.b_date, z.z_name, c.address, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) <= '0' AND l.emp_id = '$e_id' ORDER BY l.com_id asc");
									}
									else{
										$sql = mysql_query("SELECT l.c_id, l.com_id, l.c_name, l.z_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.com_id, x.z_name, x.amt, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.com_id, z.z_name, c.c_name, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) <= '0' ORDER BY l.com_id asc");
										
									}
									
									$query_date = date("Y-m-d");

									$f_date = date('Y-m-01', strtotime($query_date));
									$t_date = date('Y-m-t', strtotime($query_date));
									
									
												
									$sqlkk = mysql_query("SELECT p.c_id, SUM(p.pay_amount) AS paym, SUM(p.bill_discount) AS bill_discc FROM payment AS p 
															WHERE p.pay_date BETWEEN '$f_date' AND '$t_date'");
									
									$rowkk = mysql_fetch_array($sqlkk);					
									$paym = $rowkk['paym'];
									$bill_discc = $rowkk['bill_discc'];
									$totalpayment = $paym + $bill_discc;
												
									$tot_allbills = mysql_num_rows($sql);
									$tit = "<div class='box-header'>
												<div class='hil'> Paid :  <i style='color: #30ad23'>{$tot_allbills}</i></div> 
											</div>";
												
								}
								if($type == 'pdiscount'){
									$sql = mysql_query("SELECT l.c_id, l.com_id, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.join_date, l.cell, l.email, l.p_name, l.p_price, u.per_discount, l.discount, l.extra_bill, u.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, (u.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
												(SELECT x.com_id, x.c_id, x.payment_deadline, x.mk_name, x.b_date, x.c_name, x.address, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note FROM
													(SELECT b.c_id, c.com_id, c.c_name, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, c.note
													FROM billing AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '0' AND b.`day` = '0' AND MONTH(b.bill_date) = MONTH('$dateTime') AND YEAR(b.bill_date) = YEAR('$dateTime') AND b.discount != '0' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id
												LEFT JOIN 
												(
													SELECT c_id, SUM(bill_amount) AS amt, SUM(discount) AS per_discount FROM billing 
													WHERE sts = '0' GROUP BY c_id
												)u
												ON u.c_id = l.c_id");
												
									$tot_allbills = mysql_num_rows($sql);
									
									$sql19 = mysql_query("SELECT SUM(t2.discount) AS permanentdiscount FROM
															(
															SELECT c.c_id, c.address, c.cell, c.email, z.z_name, c.p_id, p.p_price, c.note, c.p_m FROM clients AS c 
															LEFT JOIN package AS p ON c.p_id = p.p_id
															LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
															WHERE c.sts = '0' AND c.sts = '0' AND c.mac_user = '0'
															)t1
															LEFT JOIN
															(
															SELECT b.c_id, SUM(b.bill_amount), SUM(b.discount) AS discount FROM billing AS b WHERE b.`day` = '0' AND MONTH(b.bill_date) = MONTH('$dateTime') AND YEAR(b.bill_date) = YEAR('$dateTime') 
															GROUP BY b.c_id
															)t2
															ON t1.c_id = t2.c_id");
									$row19 = mysql_fetch_array($sql19);
									
									$tit = "<div class='box-header'>
												<div class='hil'> Total Clients: <i style='color: #e3052e'>{$tot_allbills}</i></div> 
												<div class='hil'> Total Permanent Discount ({$thismonth}) : <i style='color: #e3052e'>{$row19['permanentdiscount']}</i></div> 
											</div>";
								}
								if($type == 'paydiscount'){

									$sql = mysql_query("SELECT l.c_id, l.com_id, l.payment_deadline, l.mk_name, l.b_date, l.c_name, l.address, l.join_date, l.cell, l.email, l.p_name, l.p_price, t.per_discount, l.discount, l.extra_bill, t.amt, IFNULL(u.dic, 0.00) AS dic, IFNULL(l.disco, 0.00) AS disco, l.con_sts, l.con_sts_date, IFNULL(u.pay, 0.00) AS pay, l.note, (t.amt - (IFNULL(u.pay, 0.00)+IFNULL(u.dic, 0.00))) AS payable FROM
												(SELECT x.com_id, x.c_id, x.payment_deadline, x.mk_name, x.b_date, x.c_name, x.address, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.disco FROM
													(SELECT m.c_id, c.com_id, c.c_name, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, c.note, SUM(m.bill_discount) AS disco 
													FROM payment AS m
													LEFT JOIN clients AS c ON c.c_id = m.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													
													WHERE c.mac_user = '0' AND c.sts = '0' AND m.bill_discount != '0.00' AND MONTH(m.pay_date) = MONTH('$dateTime') AND YEAR(m.pay_date) = YEAR('$dateTime') GROUP BY m.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(bill_amount) AS amt, SUM(discount) AS per_discount FROM billing
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id
												LEFT JOIN 
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic  FROM payment 
													WHERE sts = '0' GROUP BY c_id
												)u
												ON u.c_id = l.c_id");
												
									$tot_allbills = mysql_num_rows($sql);
									
									$sql19 = mysql_query("SELECT SUM(t2.discount) AS paiddiscount FROM
															(
															SELECT c.c_id, c.address, c.cell, c.email, z.z_name, c.p_id, p.p_price, c.note, c.p_m FROM clients AS c 
															LEFT JOIN package AS p ON c.p_id = p.p_id
															LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
															WHERE c.sts = '0' AND c.mac_user = '0'
															)t1
															LEFT JOIN
															(
															SELECT b.c_id, SUM(b.pay_amount), SUM(b.bill_discount) AS discount FROM payment AS b WHERE b.bill_discount != '0.00' AND MONTH(b.pay_date) = MONTH('$dateTime') AND YEAR(b.pay_date) = YEAR('$dateTime')
															GROUP BY b.c_id
															)t2
															ON t1.c_id = t2.c_id");
									$row19 = mysql_fetch_array($sql19);
									
									$tit = "<div class='box-header'>
												<div class='hil'> Total Clients: <i style='color: #e3052e'>{$tot_allbills}</i></div> 
												<div class='hil'> Total Payment Discount ({$thismonth}) : <i style='color: #e3052e'>{$row19['paiddiscount']}</i></div> 
											</div>";
								}
							
							}
							
							if($user_type == 'mreseller'){
								if($type == 'all' && in_array(135, $access_arry)){
									$sql = mysql_query("SELECT l.c_id, l.z_id, l.com_id, l.b_name, l.c_name, l.mk_name, l.address, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, t.dic, l.con_sts, l.con_sts_date, t.pay, l.note, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
														(
															SELECT b.c_id, c.com_id, f.b_name, c.z_id, c.c_name, m.Name AS mk_name, c.address, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price_reseller AS p_price, SUM(b.bill_amount) AS amt, c.note, SUM(b.discount) AS per_discount
															FROM billing_mac_client AS b
															LEFT JOIN clients AS c ON c.c_id = b.c_id
															LEFT JOIN package AS p ON p.p_id = c.p_id
															LEFT JOIN box AS f ON f.box_id = c.box_id
															
															LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
															WHERE b.sts = 0 AND c.sts = '0' AND c.z_id = '$macz_id' AND c.mac_user = '1' GROUP BY b.c_id
														)l
														LEFT JOIN
														(
															SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment_mac_client
															GROUP BY c_id
														)t
														ON l.c_id = t.c_id ORDER BY l.com_id");
									
									$sql3 = mysql_query("SELECT x.amt, x.c_id, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount, (x.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
															(SELECT b.c_id, c.c_name, c.address, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
															FROM billing_mac_client AS b
															LEFT JOIN clients AS c ON c.c_id = b.c_id
															LEFT JOIN package AS p ON p.p_id = c.p_id
															LEFT JOIN zone AS z ON z.z_id = c.z_id 
															LEFT JOIN mk_con AS m ON m.id = c.mk_id
															
															WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '1' AND c.z_id = '$macz_id' GROUP BY b.c_id) AS x
														LEFT JOIN
														(
															SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment_mac_client
															GROUP BY c_id
														)t
														ON x.c_id = t.c_id WHERE x.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) <= '1' ORDER BY x.c_id");
														
											$tot_allbills = mysql_num_rows($sql);
											$tot_allpaid = mysql_num_rows($sql3);
											$tot_allunpaid = $tot_allbills - $tot_allpaid;
											
									$tit = "<div class='box-header'>
												<div class='hil'> Total :  <i style='color: #317EAC'>{$tot_allbills}</i></div> 
												<div class='hil'> Paid :  <i style='color: #30ad23'>{$tot_allpaid}</i></div> 
												<div class='hil'> Due : <i style='color: #e3052e'>{$tot_allunpaid}</i></div> 
											</div>";
								}
								if($type == 'unpaid' && in_array(137, $access_arry)){
										$sql = mysql_query("SELECT l.c_id, l.com_id, l.z_name, l.c_name, l.payment_deadline, l.mk_name, l.b_date, l.address, l.raw_download, l.breseller, l.mac_user, l.raw_upload, l.youtube_bandwidth, l.total_bandwidth, l.bandwidth_price, l.youtube_price, l.total_price, l.join_date, l.cell, l.email, l.p_name, l.p_price, l.per_discount, l.discount, l.extra_bill, l.amt, IFNULL(t.dic, 0.00) AS dic, l.con_sts, l.con_sts_date, IFNULL(t.pay, 0.00) AS pay, l.note, l.note_auto, (l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00))) AS payable FROM
													(SELECT x.com_id, x.z_name, x.amt, x.payment_deadline, x.mk_name, x.b_date, x.c_id, x.c_name, x.address, x.raw_download, x.breseller, x.mac_user, x.raw_upload, x.youtube_bandwidth, x.total_bandwidth, x.bandwidth_price, x.youtube_price, x.total_price, x.join_date, x.discount, x.extra_bill, x.cell, x.email, x.p_name, x.con_sts, x.con_sts_date, x.p_price, x.note, x.note_auto, x.per_discount FROM
													(SELECT b.c_id, c.com_id, c.c_name, z.z_name, c.address, c.payment_deadline, m.Name AS mk_name, c.b_date, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.join_date, c.discount, c.extra_bill, c.cell, c.email, p.p_name, c.con_sts, c.con_sts_date, p.p_price, SUM(b.bill_amount) AS amt, c.note, c.note_auto, SUM(b.discount) AS per_discount
													FROM billing_mac_client AS b
													LEFT JOIN clients AS c ON c.c_id = b.c_id
													LEFT JOIN package AS p ON p.p_id = c.p_id
													
													LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
													WHERE b.sts = '0' AND c.sts = '0' AND c.mac_user = '1' AND c.z_id = '$macz_id' GROUP BY b.c_id) AS x
												)l
												LEFT JOIN
												(
													SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment_mac_client
													GROUP BY c_id
												)t
												ON l.c_id = t.c_id WHERE l.amt - (IFNULL(t.pay, 0.00)+IFNULL(t.dic, 0.00)) > '1' ORDER BY l.com_id asc");
										
									
									$tot_allbills = mysql_num_rows($sql);
									
									$tit = "<div class='box-header'>
												<div class='hil'> Due Bills: <i style='color: #e3052e'>{$tot_allbills}</i></div> 
											</div>";
								}
							}
							
if($user_type == 'mreseller'){
	$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '$e_id'");
}
else{
	if($user_type == 'billing'){
	$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name");
	$resultedfg=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' AND emp_id = '$e_id' order by z_name");
	}else{
	$result1=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
	$resultedfg=mysql_query("SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name");
	}}
if(!empty($_POST['bill_month']) || empty($_POST['bill_month'])){
$queryddga = mysql_query("SELECT CONCAT(l.z_name,' - ',l.z_bn_name) AS item, (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) AS tot  FROM
								(
								SELECT z.z_id, z.z_name, z.z_bn_name, SUM(b.bill_amount) AS TotalBill, SUM(b.discount) AS TotalDiscount FROM billing AS b 
								LEFT JOIN clients AS c ON c.c_id = b.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
								WHERE b.bill_date BETWEEN '$t_edate' AND '$f_edate'
								GROUP BY c.z_id
								)l
								LEFT JOIN
								(
								SELECT z.z_id, z.z_name, SUM(p.pay_amount) AS TotalBills, SUM(p.bill_discount) AS TotalDiscount1 FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
								WHERE p.pay_date BETWEEN '$t_edate' AND '$f_edate'
								GROUP BY c.z_id
								)t
								ON l.z_id = t.z_id WHERE (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) >= '0'");
		$tnamee = 'Due Bills Summary [All Zone]';
		
$myurl1[]="['item','tot']";
while($q=mysql_fetch_assoc($queryddga)){
	
	$Item = $q['item'];
	$Total = $q['tot'];
	$myurl1[]="['".$Item."',".$Total."]";
}}
	
if(empty($_POST['bill_month']) || $bill_month == $dateTimedd){
$queryyutyu = mysql_query("SELECT DATE_FORMAT(b.bill_date, '%b, %Y') AS datemonth, IFNULL(SUM(b.bill_amount), 0.00) AS billamount, IFNULL(t1.payment_amount, 0.00) AS payment_amount, (IFNULL(t1.discount, 0.00) + IFNULL(SUM(b.discount), 0.00)) AS discount, IFNULL(t1.discount, 0.00) AS payment_discount FROM billing AS b
							LEFT JOIN 
							(SELECT c_id, pay_date AS date, IFNULL(SUM(pay_amount), 0.00) AS payment_amount, IFNULL(SUM(bill_discount), 0.00) AS discount FROM payment
							WHERE pay_date >= DATE_SUB(DATE_ADD(subdate(curdate(), (day(curdate())-1)), INTERVAL 1 MONTH),INTERVAL 12 MONTH)  GROUP BY MONTH(pay_date), YEAR(pay_date)
							)t1
							ON MONTH(b.bill_date) = MONTH(t1.date)
							WHERE b.bill_date >= DATE_SUB(DATE_ADD(subdate(curdate(), (day(curdate())-1)), INTERVAL 1 MONTH),INTERVAL 12 MONTH) GROUP BY MONTH(b.bill_date), YEAR(b.bill_date) ORDER BY b.bill_date ASC");

$myurl[]="['datemonth', 'Bill', 'Collection', 'Discount']";
while($r=mysql_fetch_assoc($queryyutyu)){
	
	$datemonth = $r['datemonth'];
	$billamount = $r['billamount'];
	$payment_amount = $r['payment_amount'];
	$discount = $r['discount'];
//	$payment_discount = $r['payment_discount'];
	$myurl[]="['".$datemonth."', ".$billamount.", ".$payment_amount.", ".$discount."]";
}
$tname = "Monthly Bills, Collections, Bill Discount & Payment Discount";
$tname1 = "Last 11 Months";
}
else{
	$queryyutyu = mysql_query("SELECT z.z_id, z.z_name, IFNULL(SUM(t1.bill_amount), 0.00) AS billamounts, IFNULL(SUM(t2.pay_amount), 0.00) AS totalpaid, (IFNULL(SUM(t1.discount), 0.00) + IFNULL(SUM(t2.bill_discount), 0.00)) AS totaldiscount FROM zone AS z
											LEFT JOIN (SELECT c_id, z_id FROM clients)c1
											ON z.z_id = c1.z_id

											LEFT JOIN (SELECT b.c_id, b.bill_date, b.bill_amount, b.discount FROM billing AS b
											LEFT JOIN clients AS c ON c.c_id = b.c_id WHERE MONTH(b.bill_date) = MONTH('$todaydate') AND YEAR(b.bill_date) = YEAR('$todaydate')
											)t1
											ON t1.c_id = c1.c_id

											LEFT JOIN (SELECT p.c_id, p.pay_date, p.pay_amount, p.bill_discount FROM payment AS p
											LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE MONTH(p.pay_date) = MONTH('$todaydate') AND YEAR(p.pay_date) = YEAR('$todaydate')
											)t2
											ON t2.c_id = c1.c_id
											WHERE z.e_id = '' AND z.status = '0' GROUP BY c1.z_id ORDER BY z.z_id ASC");

$myurl[]="['datemonth', 'Bill', 'Collection', 'Discount']";
while($r=mysql_fetch_assoc($queryyutyu)){
	
	$datemonth = $r['z_name'];
	$billamount = $r['billamounts'];
	$payment_amount = $r['totalpaid'];
	$discount = $r['totaldiscount'];
//	$payment_discount = $r['payment_discount'];
	$myurl[]="['".$datemonth."', ".$billamount.", ".$payment_amount.", ".$discount."]";
}
$tname = "All Zone Bills, Collections & Discount in ".$thismonth;
$tname1 = "[".$thismonth."]";
}

?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = new google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl));?>
]);
        var options = {
          'title':'<?php echo $tname;?>',
          vAxis: {title: 'Bill vs Collection'},
          hAxis: {'title':'<?php echo $tname1;?>'},
          seriesType: 'bars',
          series: {5: {type: 'line'}}        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
		  google.load('visualization', '1.0', {'packages':['corechart']});
		  google.setOnLoadCallback(drawChart);
		  
		  function drawChart() {
			var data = new google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl1));?>
		]);

			// Set chart options
			var options = {'title':'<?php echo $tnamee;?> [<?php echo $thismonth;?>]',
							//is3D:true,
							pieHole: 0.4,
							'allowHtml': true};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
			chart.draw(data, options);
		  }
    </script>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal11">
	<div id='Pointdiv2'></div>
</div>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" target="_blank" action="fpdf/BillsPrint">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Print Invoice</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Zone</div>
							<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select" style="width:250px;">
								<?php if($user_type == 'mreseller'){ } else{?>
								<option value="all"> All Zone </option><?php } ?>
										<?php while ($row=mysql_fetch_array($result1)) { ?>
								<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?></option>
										<?php } ?>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Payment Method</div>
							<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:250px;">
											<option value="">All Payment Method</option>
											<option value="Cash">Cash</option>
											<option value="Home Cash">Cash from Home</option>
											<option value="Office">Office</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Clients Status</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="con_sts">
								<option value="">All Clients</option>
								<option value="Active">Active</option>
								<option value="Inactive">Inactive</option>
							</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2">
	<form id="form2" class="stdform" method="post" action="Billing?id=search">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Due Clients Search</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Zone</div>
							<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select" style="width:250px;">
							<?php if($user_type == 'billing'){} else{ ?>
								<option value="all"<?php if('all' == (isset($_POST['z_id']) ? $_POST['z_id'] : '')) echo 'selected="selected"';?>> All Zone </option>
							<?php } while ($rowdd=mysql_fetch_array($resultedfg)) { ?>
								<option value="<?php echo $rowdd['z_id']?>"<?php if($rowdd['z_id'] == (isset($_POST['z_id']) ? $_POST['z_id'] : '')) echo 'selected="selected"';?>><?php echo $rowdd['z_name']; ?></option>
										<?php } ?>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Clients Status</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="con_sts">
								<option value="all"<?php if('all' == (isset($_POST['con_sts']) ? $_POST['con_sts'] : '')) echo 'selected="selected"';?>>All Clients</option>
								<option value="Active"<?php if('Active' == (isset($_POST['con_sts']) ? $_POST['con_sts'] : '')) echo 'selected="selected"';?>>Active</option>
								<option value="Inactive"<?php if('Inactive' == (isset($_POST['con_sts']) ? $_POST['con_sts'] : '')) echo 'selected="selected"';?>>Inactive</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Deleted Status</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="sts">
								<option value="all"<?php if('all' == (isset($_POST['sts']) ? $_POST['sts'] : '')) echo 'selected="selected"';?>> All Status </option>
								<option value="1"<?php if('1' == (isset($_POST['sts']) ? $_POST['sts'] : '')) echo 'selected="selected"';?>>Deleted</option>
								<option value="0"<?php if('0' == (isset($_POST['sts']) ? $_POST['sts'] : '')) echo 'selected="selected"';?>>Not Deleted</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Payment Method</div>
							<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select"  style="width:250px;">
								<option value="all"<?php if('all' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>> All Payment Method </option>
								<option value="Home Cash"<?php if('Home Cash' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Cash from Home</option>
								<option value="Cash"<?php if('Cash' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Cash</option>
								<option value="Office"<?php if('Office' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Office</option>
								<option value="bKash"<?php if('bKash' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>bKash</option>
								<option value="Rocket"<?php if('Rocket' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Rocket</option>
								<option value="iPay"<?php if('iPay' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>iPay</option>
								<option value="Card"<?php if('Card' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Card</option>
								<option value="Bank"<?php if('Bank' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Bank</option>
								<option value="Corporate"<?php if('Corporate' == (isset($_POST['p_m']) ? $_POST['p_m'] : '')) echo 'selected="selected"';?>>Corporate</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Partial</div>
							<select class="select-ext-large chzn-select" style="width:250px;" name="partial">
								<option value="all"<?php if('all' == (isset($_POST['partial']) ? $_POST['partial'] : '')) echo 'selected="selected"';?>> All Due </option>
								<option value="1"<?php if('1' == (isset($_POST['partial']) ? $_POST['partial'] : '')) echo 'selected="selected"';?>>Partial Due</option>
								<option value="2"<?php if('2' == (isset($_POST['partial']) ? $_POST['partial'] : '')) echo 'selected="selected"';?>>Not Partial Due</option>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">Deadline</div>
							<select class="chzn-select" style="width:125px;" name="df_date">
								<option value="all"<?php if('all' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> From Deadline </option>
									<option value="01"<?php if('01' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 1st<?php echo date(' M Y', time());?></option>
									<option value="02"<?php if('02' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 2nd<?php echo date(' M Y', time());?></option>
									<option value="03"<?php if('03' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 3rd<?php echo date(' M Y', time());?></option>
									<option value="04"<?php if('04' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 4th<?php echo date(' M Y', time());?></option>
									<option value="05"<?php if('05' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 5th<?php echo date(' M Y', time());?></option>
									<option value="06"<?php if('06' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 6th<?php echo date(' M Y', time());?></option>
									<option value="07"<?php if('07' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 7th<?php echo date(' M Y', time());?></option>
									<option value="08"<?php if('08' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 8th<?php echo date(' M Y', time());?></option>
									<option value="09"<?php if('09' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 9th<?php echo date(' M Y', time());?></option>
									<option value="10"<?php if('10' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 10th<?php echo date(' M Y', time());?></option>
									<option value="11"<?php if('11' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 11th<?php echo date(' M Y', time());?></option>
									<option value="12"<?php if('12' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 12th<?php echo date(' M Y', time());?></option>
									<option value="13"<?php if('13' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 13th<?php echo date(' M Y', time());?></option>
									<option value="14"<?php if('14' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 14th<?php echo date(' M Y', time());?></option>
									<option value="15"<?php if('15' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 15th<?php echo date(' M Y', time());?></option>
									<option value="16"<?php if('16' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 16th<?php echo date(' M Y', time());?></option>
									<option value="17"<?php if('17' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 17th<?php echo date(' M Y', time());?></option>
									<option value="18"<?php if('18' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 18th<?php echo date(' M Y', time());?></option>
									<option value="19"<?php if('19' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 19th<?php echo date(' M Y', time());?></option>
									<option value="20"<?php if('20' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 20th<?php echo date(' M Y', time());?></option>
									<option value="21"<?php if('21' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 21th<?php echo date(' M Y', time());?></option>
									<option value="22"<?php if('22' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 22th<?php echo date(' M Y', time());?></option>
									<option value="23"<?php if('23' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 23th<?php echo date(' M Y', time());?></option>
									<option value="24"<?php if('24' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 24th<?php echo date(' M Y', time());?></option>
									<option value="25"<?php if('25' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 25th<?php echo date(' M Y', time());?></option>
									<option value="26"<?php if('26' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 26th<?php echo date(' M Y', time());?></option>
									<option value="27"<?php if('27' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 27th<?php echo date(' M Y', time());?></option>
									<option value="28"<?php if('28' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 28th<?php echo date(' M Y', time());?></option>
									<option value="29"<?php if('29' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 29th<?php echo date(' M Y', time());?></option>
									<option value="30"<?php if('30' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 30th<?php echo date(' M Y', time());?></option>
									<option value="31"<?php if('31' == (isset($_POST['df_date']) ? $_POST['df_date'] : '')) echo 'selected="selected"';?>> 31th<?php echo date(' M Y', time());?></option>
							</select>
							<select data-placeholder="Choose a Deadline" name="dt_date" class="chzn-select"  style="width:125px;">
									<option value="all"<?php if('all' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> To Deadline </option>
									<option value="01"<?php if('01' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 1st<?php echo date(' M Y', time());?></option>
									<option value="02"<?php if('02' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 2nd<?php echo date(' M Y', time());?></option>
									<option value="03"<?php if('03' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 3rd<?php echo date(' M Y', time());?></option>
									<option value="04"<?php if('04' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 4th<?php echo date(' M Y', time());?></option>
									<option value="05"<?php if('05' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 5th<?php echo date(' M Y', time());?></option>
									<option value="06"<?php if('06' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 6th<?php echo date(' M Y', time());?></option>
									<option value="07"<?php if('07' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 7th<?php echo date(' M Y', time());?></option>
									<option value="08"<?php if('08' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 8th<?php echo date(' M Y', time());?></option>
									<option value="09"<?php if('09' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 9th<?php echo date(' M Y', time());?></option>
									<option value="10"<?php if('10' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 10th<?php echo date(' M Y', time());?></option>
									<option value="11"<?php if('11' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 11th<?php echo date(' M Y', time());?></option>
									<option value="12"<?php if('12' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 12th<?php echo date(' M Y', time());?></option>
									<option value="13"<?php if('13' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 13th<?php echo date(' M Y', time());?></option>
									<option value="14"<?php if('14' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 14th<?php echo date(' M Y', time());?></option>
									<option value="15"<?php if('15' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 15th<?php echo date(' M Y', time());?></option>
									<option value="16"<?php if('16' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 16th<?php echo date(' M Y', time());?></option>
									<option value="17"<?php if('17' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 17th<?php echo date(' M Y', time());?></option>
									<option value="18"<?php if('18' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 18th<?php echo date(' M Y', time());?></option>
									<option value="19"<?php if('19' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 19th<?php echo date(' M Y', time());?></option>
									<option value="20"<?php if('20' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 20th<?php echo date(' M Y', time());?></option>
									<option value="21"<?php if('21' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 21th<?php echo date(' M Y', time());?></option>
									<option value="22"<?php if('22' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 22th<?php echo date(' M Y', time());?></option>
									<option value="23"<?php if('23' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 23th<?php echo date(' M Y', time());?></option>
									<option value="24"<?php if('24' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 24th<?php echo date(' M Y', time());?></option>
									<option value="25"<?php if('25' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 25th<?php echo date(' M Y', time());?></option>
									<option value="26"<?php if('26' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 26th<?php echo date(' M Y', time());?></option>
									<option value="27"<?php if('27' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 27th<?php echo date(' M Y', time());?></option>
									<option value="28"<?php if('28' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 28th<?php echo date(' M Y', time());?></option>
									<option value="29"<?php if('29' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 29th<?php echo date(' M Y', time());?></option>
									<option value="30"<?php if('30' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 30th<?php echo date(' M Y', time());?></option>
									<option value="31"<?php if('31' == (isset($_POST['dt_date']) ? $_POST['dt_date'] : '')) echo 'selected="selected"';?>> 31th<?php echo date(' M Y', time());?></option>
							</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
		<div class="searchbar" style="margin-right: 10px;">
		<?php if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets' || $user_type == 'billing' || $user_type == 'mreseller'){ ?>
		
			<?php if(in_array(133, $access_arry) || in_array(134, $access_arry)){?>
			<div class="input-append" style="float: left;padding-right: 1px;">
				<div class="btn-group">
				<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid green;color: green;font-size: 14px;margin-right: 2px;">Collections <span class="caret" style="border-top: 4px solid green;"></span></button>
					<ul class="dropdown-menu" style="min-width: 100px;border-radius: 0 0 5px 5px;">
						<?php if(in_array(133, $access_arry)){?>
							<li><a href="Collection" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #0a6bce;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;">All Collections</a></li>
						<?php } if(in_array(134, $access_arry)){?>
							<li>
								<a style="padding: 3px 0 5px 1px;">
									<form id="" name="form" class="stdform" method="post" action="Collection">
										<input type="hidden" name="f_date" value="<?php echo date('Y-m-d', time());?>" />
										<input type="hidden" name="t_date" value="<?php echo date('Y-m-d', time());?>" />
										<input type="hidden" name="radiofield" value="collections" />
										<button type="submit" style="color: #30AD23;font-size: 14px;font-weight: bold;border: 0px;background: transparent;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">Today's Collections</button>
									</form>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<?php } ?>
		
		<?php if(in_array(135, $access_arry) || in_array(136, $access_arry) || in_array(137, $access_arry) || in_array(248, $access_arry)){?>
						<?php if(in_array(248, $access_arry)){?>
						<a href="Billing?id=invoice_client" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #ff5400;border: 1px solid #ff5400;font-size: 14px;">Invoice Clients</a>
						<?php } ?> 
						<div class="input-append" style="float: left;padding-right: 2px;">
							<div class="btn-group">
							<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 14px;">Billing <span class="caret" style="border-top: 4px solid #0866c6;"></span></button>
								<ul class="dropdown-menu" style="min-width: 92px;border-radius: 0px 0px 5px 5px;">
									<?php if(in_array(135, $access_arry)){?>
										<li><a href="Billing?id=all" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;"> All Bills </a></li>
									<?php } if(in_array(136, $access_arry)){?>
										<li><a href="Billing?id=paid" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: green;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"> Paid Bills</a></li>
									<?php } if(in_array(137, $access_arry)){?>
										<li><a href="Billing?id=unpaid" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ac3131c4;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title=''> Due Bills</a></li>
									<?php } ?> 
								</ul>
							</div>
						</div>
						<?php } if(in_array(139, $access_arry)){?>
							<button class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #a0f;border: 1px solid #a0f;font-size: 14px;" href="#myModal" data-toggle="modal"  title='Print All Dues Invoice'>Print Invoice</button>
						<?php }if(in_array(138, $access_arry)){?>
							<a class="btn" style="border-radius: 3px;border: 1px solid red;color: red;padding: 6px 9px;" href="#myModal2" data-toggle="modal" title='Search Due Clients'><i class="iconfa-search"></i></a>
						<?php }}?>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Billing</h1>
        </div>
    </div><!--pageheader-->
	<?php if('error' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Error!!</strong> This Payment Already Added.
		</div>
		<?php } ?>
	<?php if($type != ''){?>
	<div class="box box-primary">
		<div class="box-header">
			<h5> <?php echo $tit; ?></h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Cell</th>
                            <th class="head1">Address/Zone/CCR</th>
							<th class="head0">Package</th>
							<th class="head1 center">Status</th>
							<th class="head0">Deadline</th>
							<th class="head1">Discount/Ex.Bill</th>
							<th class="head0 center">Payable</th>
							<th class="head1 center">Note</th>
                            <th class="head0 center" style="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									//$payable = number_format(($row['amt'] - ($row['pay'] + $row['dic'])),2);
									
									$payable = number_format($row['payable'], 2);
									
									if($payable > 0){
										$color = 'style="color:red; font-weight: bold;font-size: 16px;padding: 20px 0;"';					
									} 
									if($payable < 0){
										$color = 'style="color:blue; font-weight: bold;font-size: 16px;padding: 20px 0;"';					
									}
									if($payable == 0){
										$color = 'style="font-weight: bold;font-size: 13px;padding: 20px 0;"';					
									}
									if ($row['con_sts']=='Inactive')
									{
										$colo = 'style="color:red; width: 80px;font-size: 15px;"';	
									}
									else
									{
										$colo = 'style="color:green; width: 80px;font-size: 16px;"';
									}
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['raw_download'] .' + U: '.$row['raw_upload'].' + Y: '.$row['youtube_bandwidth'].' = '.$row['total_bandwidth'].'mb <br> Rate: '.$row['total_price'];
									}
									elseif($row['breseller'] == '2'){
									$queryaaaa = mysql_query("SELECT SUM(total_price) AS totalpriceeee FROM monthly_invoice WHERE c_id = '{$row['c_id']}'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);
									$totalpriceeee = $rowaaaa['totalpriceeee'];
									
										$hhhh = '<b>'.$totalpriceeee.'tk</b>';
										
									$quain = mysql_query("SELECT invoice_id FROM billing_invoice WHERE c_id = '{$row['c_id']}' AND sts = '0' ORDER BY invoice_id DESC LIMIT 1");
									$rowin = mysql_fetch_assoc($quain);
									$invoiceidd = $rowin['invoice_id'];
									}
									else{
										$hhhh = $row['p_name'].'<br> ('.$row['p_price'].'tk)';
										$invoiceidd = '';
									}
									if($client_onlineclient_sts == '1'){
									if(in_array($row['c_id'], $itemss1)){
										$clientactive = "<tr>
															<td class='center' style='border-right: none;border-left: none;'>
																<ul class='tooltipsample'>
																	<b style='color:#0866c6; width: 80px;font-size: 16px;'>Online</b>
																</ul>
															</td>
														</tr>";
										$activecount = 1;
										$inactivecount = 0;
										$colorrr = 'style="color:#0866c6; width: 80px;font-size: 16px;"';
										
									}
									else{
										$clientactive = "<tr>
															<td class='center' style='border-right: none;border-left: none;'>
																<ul class='tooltipsample'>
																	<b style='color:red; width: 80px;font-size: 15px;'>Offline</b>
																</ul>
															</td>
														</tr>";
										$activecount = 0;
										$inactivecount = 1;
										$colorrr = '';
									}
									}
									else{
										$clientactive = "";
										$activecount = 0;
										$inactivecount = 0;
									}
									
									$dfhdh = "<div class='btn-group' style='width: 100%;'>
												  <button class='btn' style='width: 20%;padding: 3px;'><i class='iconsweets-preview'></i></button>
												  <button class='btn' style='width: 20%;padding: 3px;'><i class='iconsweets-speech'></i></button>
												  <button class='btn' style='width: 20%;padding: 3px;'><i class='iconsweets-repeat'></i></button>
												  <button class='btn' style='width: 20%;padding: 3px;'><i class='iconsweets-wifi'></i></button>
												  <button class='btn' style='width: 20%;padding: 3px;'><i class='iconsweets-create'></i></button>
												</div>";
								if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets' || $user_type == 'billing'){
									echo
										"<tr class='gradeX'>
											<td class='center' style='padding: 20px 0;font-size: 15px;font-weight: bold;'>{$row['com_id']}</td>
											<td style='padding: 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='' style='border-right: none;border-left: none;padding: 6px 0px 0px 8px;'>
															<ul class='tooltipsample'>
																<b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}<br>{$row['email']}
															</ul>
														</td>
													</tr>
													<!---<tr>
														<td class='' style='border-right: none;border-left: none;padding: 0px;'>
															<ul class='tooltipsample'>
																<b>{$dfhdh}</b>
															</ul>
														</td>
													</tr>--->
													</tbody>
												</table>
											</td>
											<td>{$row['address']}<br>{$row['z_name']}<br><b>[{$row['mk_name']}]</b></td>
											<td>{$hhhh}</td>
											<td style='padding: 8px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='center' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample'>
																<b $colo>{$row['con_sts']}</b>
															</ul>
														</td>
													</tr>
													{$clientactive}
													</tbody>
												</table>
											</td>
											<td style='padding: 8px 0px;'>
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
											<td style='padding: 8px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>Pr.D: {$row['discount']}</b>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>Ex.B: {$row['extra_bill']}</b>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
											<td $color class='center'>{$payable}</td>\n";
								}
								if($user_type == 'mreseller'){
									echo
										"<tr class='gradeX'>
											<td class='center' style='padding: 20px 0;font-size: 15px;font-weight: bold;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}<br>{$row['email']}</td>
											<td>{$row['address']}<br>{$row['z_name']}<br><b>[{$row['mk_name']}]</b></td>
											<td>{$hhhh}</td>
											<td style='padding: 8px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='center' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample'>
																<b $colo>{$row['con_sts']}</b>
															</ul>
														</td>
													</tr>
													{$clientactive}
													</tbody>
												</table>
											</td>
											<td></td>
											<td style='padding: 8px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample'>
																<b>Pr.D: {$row['discount']}</b>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample'>
																<b>Ex.B: {$row['extra_bill']}</b>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
											<td $color class='center'>{$payable}</td>\n";
								} ?>
											<td class='center'>
												<ul class='popoversample' style="padding: 10px 0px;">
													<li><?php if($row['note_auto'] != '' || $row['note'] != ''){ ?><form href='#myModal11' data-toggle='modal'><button type='submit' value="<?php echo $row['c_id'];?>" class='btn' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid green;color: green;font-size: 14px;" onClick='getRoutePoint1(this.value)'>Note</button></form><?php } ?></li>
												</ul>
											</td>
											
											<td style="padding: 0px 0px;">
												<table style="width: 100%;">
													<tbody>
													<tr>
														<td class='center' style="border-right: none;border-left: none;">
															<ul class='tooltipsample'>
															<?php if(in_array(128, $access_arry)){?>
																<li><form action='PaymentAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class='btn' style="border-radius: 3px;border: 1px solid #044a8e;color: #044a8e;padding: 6px 9px;" title='Cash Payment'><i class='iconfa-money'></i></button></form></li>
															<?php } if(in_array(129, $access_arry)){?>
																<li><form action='PaymentOnlineAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class='btn' style="border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;" title='Online Payment'><i class='iconfa-shopping-cart'></i></button></form></li>
															<?php } if(in_array(130, $access_arry)){?>
																<li><form action='BillPaymentView' method='post' target='_blank'><input type='hidden' name='id' value='<?php echo $row['c_id'];?>' /><button class='btn' style="border-radius: 3px;border: 1px solid #a0f;color: #a0f;padding: 6px 9px;" title='View Bill & Payment'><i class='iconfa-eye-open'></i></button></form></li>
															<?php } ?>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='center' style="border-right: none;border-left: none;">
															<ul class='tooltipsample'>
															<?php if(in_array(131, $access_arry)){ if($row['mac_user'] == '0'){ if($row['breseller'] == '2'){?>
																<li><form action='fpdf/BillPrintInvoiceClient' method='post' target='_blank'><input type='hidden' name='invoice_id' value='<?php echo $invoiceidd;?>' /><button class='btn' style="border-radius: 3px;border: 1px solid red;color: red;padding: 6px 9px;" title='Print Invoice'><i class='iconfa-print'></i></button></form></li>
															<?php } else{ ?>
																<li><form action='fpdf/BillPrintInvoice' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='e_id' value='<?php echo $e_id;?>' /><button class='btn' style="border-radius: 3px;border: 1px solid red;color: red;padding: 6px 9px;" title='Print Invoice'><i class='iconfa-print'></i></button></form></li>
																<li><form action='fpdf/ClientInvoiceMail' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='e_id' value='<?php echo $e_id;?>' /><button class='btn' style="border-radius: 3px;border: 1px solid #044a8e;color: #044a8e;padding: 6px 9px;" title='Mail Invoice'><i class='iconfa-envelope'></i></button></form></li>
															<?php }} else{ ?>
																<li><a href='BillPrintInvoice?id=<?php echo $row['c_id'];?>' target='_blank' class='btn' style="border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;" title='Print Invoice'><i class='iconfa-print'></i></a></li>
															<?php }} if(in_array(132, $access_arry)){ if($row['breseller'] == '2'){?>
																<li><form action='ClientsBillAdjust' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='Add/Adjustment Invoice'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='usertype' value='<?php echo $user_type;?>'/><button class='btn' style="border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;"><i class='iconfa-plus'></i></button></form></li>
															<?php } else{ ?>
																<li><form action='ClientsBillAdjust' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='Bill Adjustment'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><input type='hidden' name='usertype' value='<?php echo $user_type;?>' /><button class='btn' style="border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;"><i class='iconfa-refresh'></i></button></form></li>
															<?php }} ?>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
										</tr>
								
								<?php } ?>
					</tbody>
				</table>
			</div>			
	</div>

<?php } else{
	if($user_type == 'mreseller'){

	}else{
	?>
			<div class="modal-content">
				<div class="modal-body" style="padding: 5px;">
				<?php if(in_array(140, $access_arry)){?>
					<div class="par" style="float: left;margin-right: 1%;">
                        <div class="input-append">
							<input type="text" name="com_id" placeholder="Com_ID" id="appendedInputButtons" class="span1">
                        </div>
                    </div>
					<div class="par" style="float: left;margin-right: 3%;">
                        <div class="input-append">
							<input type="text" name="c_id" placeholder="Client ID" id="appendedInputButtonsCid" class="span2">
                        </div>
                    </div>
					<div class="par" style="float: left;margin-right: 3%;">
                        <div class="input-append">
							<input type="text" name="c_name" placeholder="Client Name" id="appendedInputButtonsCname" class="span2">
                        </div>
                    </div>
					<div class="par" style="float: left;margin-right: 3%;">
                        <div class="input-append">
							<input type="text" name="cell" placeholder="Phone No" id="appendedInputButtonsCell" class="span2">
                        </div>
                    </div>
					<div class="par" style="float: left;margin-right: 3%;">
                        <div class="input-append">
							<input type="text" name="address" placeholder="Address" id="appendedInputButtonsAddress" class="span2">
                        </div>
                    </div>
							<input type="text" name="payment_deadline" style="float: left;margin-right: 3%;width: 5%;" placeholder="Deadline" id="appendedInputButtonsDeadline" class="span2">
					<div class="par">
                        <div class="input-append">
							<form id="form2" class="stdform" method="post" action="<?php $PHP_SELF;?>">
								<select name="bill_month" class="" style="height: 30px;width: 100%;" onchange="submit();">
									<option value="<?php echo date("Y-m-01") ?>"><?php echo date("F-Y") ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if((isset($_POST['bill_month']) ? $_POST['bill_month'] : '') == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("F-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
								</select>
							</form>
                        </div>
                    </div>
				<?php } ?>
				</div>
			</div>
	<span id="result">
	<?php if(in_array(142, $access_arry)){?>
		<div id="chart_div" style="width: 100%; height: 300px;"></div>
	<?php } ?>
		<?php if(in_array(141, $access_arry)){?>
		<div class="box box-primary">
			<div class="box-header">
				<h4>Bills vs Collections (<?php echo $thismonth; ?>)</h4>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">SL</th>
                            <th class="head1">Zone</th>
							<th class="head0 center">Generated Bill</th>
							<th class="head1 center">Collection</th>
							<th class="head0 center">Discount</th>
							<th class="head1 center">Total Due</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
						$sql = mysql_query("SELECT z.z_id, z.z_name, if(z.z_bn_name = '', '', CONCAT(' (',z.z_bn_name,')')) AS z_bn_name, IFNULL(SUM(t1.bill_amount), 0.00) AS billamounts, IFNULL(SUM(t2.pay_amount), 0.00) AS totalpaid, IFNULL(SUM(t2.bill_discount), 0.00) AS totaldiscount,  IFNULL(SUM(t1.bill_amount), 0.00) - IFNULL(SUM(t2.pay_amount), 0.00) AS totalduess FROM zone AS z
											LEFT JOIN (SELECT c_id, z_id FROM clients WHERE sts = '0')c1
											ON z.z_id = c1.z_id

											LEFT JOIN 
											
											(SELECT b.c_id, b.bill_date, b.bill_amount, b.discount FROM billing AS b
											LEFT JOIN clients AS c ON c.c_id = b.c_id WHERE MONTH(b.bill_date) = MONTH('$todaydate') AND YEAR(b.bill_date) = YEAR('$todaydate')
											)t1
											ON t1.c_id = c1.c_id

											LEFT JOIN (SELECT p.c_id, p.pay_date, p.pay_amount, p.bill_discount FROM payment AS p
											LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE MONTH(p.pay_date) = MONTH('$todaydate') AND YEAR(p.pay_date) = YEAR('$todaydate')
											)t2
											ON t2.c_id = c1.c_id
											WHERE z.e_id = '' AND z.status = '0' GROUP BY c1.z_id ORDER BY IFNULL(SUM(t1.bill_amount), 0.00) desc");
								$x=1;
								while( $row = mysql_fetch_assoc($sql) )
								{
									
									$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND z_id = '{$row['z_id']}' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$activeclient = $rowaaaa['activeclient'];
									
									$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND z_id = '{$row['z_id']}' AND sts = '0'");
									$rowiii = mysql_fetch_assoc($queryiiiii);

									$inactiveclient = $rowiii['inactiveclient'];
									
									$totalclients = $activeclient + $inactiveclient;
									
									$paiddddd = $row['totalpaid']+$row['totaldiscount'];
									
									if($row['billamounts'] == '0.00'){
										$achipment = $paiddddd/100;
									}
									else{
										$achipment = $paiddddd/$row['billamounts']*100;
									}
									$achipok = number_format($achipment,2);
									$achipok11 = 100 - $achipok;
									
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-size: 13px;font-weight: bold;'>{$x}</td>
											<td><b style='font-weight: bold;font-size: 16px;'>{$row['z_name']}{$row['z_bn_name']}</b><br><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$activeclient}<br><b style='color: #b94a48;font-weight: bold;'>Inactive:</b> {$inactiveclient}</td>
											<td class='center' style='font-size: 17px;font-weight: bold;color: #973877;padding-top: 20px;'>{$row['billamounts']}</td>
											<td class='center' style='font-size: 17px;font-weight: bold;padding-top: 20px;color: #437323;'>{$row['totalpaid']}</td>
											<td class='center' style='font-size: 17px;font-weight: bold;padding-top: 20px;color: #12509f;'>{$row['totaldiscount']}</td>
											<td class='center' style='font-size: 17px;font-weight: bold;padding-top: 20px;color: red;'>{$row['totalduess']}</td>
										</tr>
										<tr>
											<td colspan='2' style='font-size: 13px;border-bottom: 2px solid #ddd;'><b style='font-weight: bold;margin-left: 3%;'>Total Clients:</b> <b>{$totalclients}</b><b style='font-weight: bold;color: #8e5000d9;float: right;'>Collection & Due (Ratio)</td>
											<td class='center' colspan='3' style='font-size: 17px;font-weight: bold;color: #8e5000d9;border-bottom: 2px solid #ddd;'>{$achipok}%</td>
											<td class='center' style='font-size: 17px;font-weight: bold;color: #8e5000d9;border-bottom: 2px solid #ddd;'>{$achipok11}%</td>
										</tr>\n";
										$x++;
								}
						
							?>
					</tbody>
				</table>
			</div>			
		</div>
								<div id="chart_div1" style="width: 100%; text-align: center; height: 600px; margin: 0 auto; padding: 0 auto"></div>
					
		<?php } ?>
	</span>

<?php }}}
else{
	include('include/index');
}
include('include/footer.php');
?>
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
    });
</script>
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
    url  : 'BillingSearchResult.php',
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
<script type="text/javascript">
$(document).ready(function()
{    
 $("#appendedInputButtonsCid").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'BillingSearchResult.php',
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
    url  : 'BillingSearchResult.php',
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
<script type="text/javascript">
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
    url  : 'BillingSearchResult.php',
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
<script type="text/javascript">
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
    url  : 'BillingSearchResult.php',
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
<script type="text/javascript">
$(document).ready(function()
{    
 $("#appendedInputButtonsDeadline").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#result").html('Searching...');
   $.ajax({
    
    type : 'POST',
    url  : 'BillingSearchResult.php',
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
</script>