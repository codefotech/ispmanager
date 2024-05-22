<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!

$userr_typp = $_SESSION['SESS_USER_TYPE'];
$maczoneidd = $_SESSION['SESS_MAC_ZID'];

if($_SESSION['SESS_USER_TYPE'] == '') {
	header("Location:index.php");
}
else{
include("../web/conn/connection.php") ;
include("../web/company_info.php") ;
ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());

$acce_arry = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS page_access FROM module_page WHERE $userr_typp = '1' or $userr_typp = '2'"));
$access_arry = explode(',',$acce_arry['page_access']);

  if($_POST) 
  {
if($client_onlineclient_search_sts == '1'){
	if($client_onlineclient_sts == '1'){

	include("mk_api.php");	
	$API = new routeros_api();
	$API->debug = false;	
		
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
	  
      $cid     = strip_tags($_POST['ccc_id']);

if($cid != ''){
$ccid = '%'.$cid.'%';
if($userr_typp == 'mreseller'){
$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
						LEFT JOIN zone AS z
						ON z.z_id = c.z_id
						LEFT JOIN package AS p
						ON p.p_id = c.p_id 
						LEFT JOIN login AS l
						ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' AND c.z_id = '$maczoneidd' ORDER BY c.com_id ASC");
}
else{
$sqlser = mysql_query("SELECT c.id, c.com_id, c.c_id, c.mk_id, l.log_sts, c.c_name, c.z_id, z.z_name, c.payment_deadline, c.b_date, z.z_bn_name, c.mac_user, DATE_FORMAT(c.termination_date, '%D %M, %Y') AS terminationdate, c.termination_date, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address, c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts, l.image FROM clients AS c
						LEFT JOIN zone AS z
						ON z.z_id = c.z_id
						LEFT JOIN package AS p
						ON p.p_id = c.p_id 
						LEFT JOIN login AS l
						ON l.user_id = c.c_id WHERE c.c_id LIKE '$ccid' ORDER BY c.com_id ASC");
} ?>
<table class='table table-bordered responsive'><tbody>
<?php
while( $roww = mysql_fetch_assoc($sqlser) )
								{
$c_iddd = $roww['c_id'];

if($roww['image'] == ''){
	$img = '/web/emp_images/no_img.jpg';
}
else{
	$img = "/web/".$roww['image'];
}

if($roww['con_sts'] == 'Active'){
	$collo = 'style="color: #008000c4;line-height: normal;"';
	$cngpkg = "<form action='PackageChange' method='post' data-placement='top' data-rel='tooltip' title='Change Package' style='float: left;'><input type='hidden' name='cid' value='$c_iddd' /><button class='btn col2' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 1px solid #bbb;'><i class='iconfa-signout'></i></button></form>";
}
else{
	$collo = 'style="color: #ff0000ab;line-height: normal;"';
	$cngpkg = "";
}

if($roww['mac_user'] == '0'){
	
$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$c_iddd'");
$rows = mysql_fetch_array($sql2);
	
	if($rows['due'] > '0'){
		$colllo = 'style="color: #ff0000ba;line-height: normal;font-weight: bold;"';
	}
	else{
		$colllo = 'style="color: #999;line-height: normal;"';
	}
		if(in_array(128, $access_arry)){
			$cashpayment = "<form action='PaymentAdd' method='post' data-placement='top' data-rel='tooltip' title='Add Cash Payment' style='float: left;'><input type='hidden' name='id' value='$c_iddd' /><button class='btn col1' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 0px solid #bbb;'><i class='iconfa-money'></i></button></form>";
		}
		if(in_array(129, $access_arry)){
			$onlinepayment = "<form action='PaymentOnlineAdd' method='post' data-placement='top' data-rel='tooltip' title='Add Online Payment' style='float: left;'><input type='hidden' name='id' value='$c_iddd' /><button class='btn col2' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 0px solid #bbb;margin-right: 3px;'><i class='iconfa-shopping-cart'></i></button></form>";
		}
		if(in_array(128, $access_arry) || in_array(129, $access_arry)){
			$payment_recharge = '<br>'.$onlinepayment.' '.$cashpayment;
		}
		else{
			$payment_recharge = "";
		}

	$pdbd = '[PD:'.$roww['payment_deadline'].' | BD:'.$roww['b_date'].']';
	$totaldue = 'Total Due: <b '.$colllo.'>'.$rows['due'].'৳</b>';
	$totaldue1 = '';
	$remainingdays = '';
		if(in_array(104, $access_arry)){
			$clientview = "<form action='ClientView' method='post' data-placement='top' data-rel='tooltip' title='Profile' style='float: left;'><input type='hidden' name='ids' value='{$c_iddd}' /><button class='btn col1' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 0px solid #bbb;margin-right: 3px;'><i class='iconfa-eye-open'></i></button></form><form action='AddTicket' method='post' data-placement='top' data-rel='tooltip' title='Add Ticket' style='float: left;'><input type='hidden' name='ids' value='{$c_iddd}' /><button class='btn col4' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 0px solid #bbb;'><i class='iconfa-comments-alt'></i></button></form>";
		}
		else{
			$clientview = "";
		}
}
else{
	if(in_array(115, $access_arry) || $userr_typp == 'mreseller'){
	$terminationdatee = date('d M, Y', strtotime($roww['terminationdate']));
	
	$colllo = 'style="line-height: normal;"';
	if(in_array(107, $access_arry) || $userr_typp == 'mreseller'){
		$payment_recharge = "<br><form action='ClientsRecharge' method='post' data-placement='top' data-rel='tooltip' title='Recharge' style='float: left;'><input type='hidden' name='c_id' value='$c_iddd' /><button class='btn col3' style='padding: 3px 6px 3px 6px;font-size: 10px;font-weight: bold;border: 0px solid #bbb;'><i class='iconfa-globe'></i></button></form>";
	}
	else{
		$payment_recharge = "";
	}
	$pdbd = '[Last Date: '.$terminationdatee.']';
	
$yrdata1= strtotime($roww['termination_date']);
$enddate = date('d F, Y', $yrdata1);
									
$diff = abs(strtotime($roww['termination_date']) - strtotime($dateTimeee))/86400;
if($roww['termination_date'] < $dateTimeee){ $diff = '0';}
if($diff <= '7'){
	$colorrrr = 'style="color: red;font-weight: bold;"'; 
}
else{
	$colorrrr = 'style="font-weight: bold;color: blue;"'; 
}
	$totaldue = '';
	$totaldue1 = 'Remaining: '.$diff.' Days';
	$remainingdays = 'Remaining: <b '.$colorrrr.'>'.$diff.'</b> Days';
	
		if(in_array(104, $access_arry) || $userr_typp == 'mreseller'){
			$clientview = "<form action='ClientView' method='post' data-placement='top' data-rel='tooltip' title='Profile' style='float: left;'><input type='hidden' name='ids' value='{$c_iddd}' /><button class='btn col1' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 0px solid #bbb;margin-right: 3px;'><i class='iconfa-eye-open'></i></button></form><form action='AddTicket' method='post' data-placement='top' data-rel='tooltip' title='Add Ticket' style='float: left;'><input type='hidden' name='ids' value='{$c_iddd}' /><button class='btn col4' style='padding: 3px 5px 3px 5px;font-size: 10px;font-weight: bold;border: 0px solid #bbb;'><i class='iconfa-comments-alt'></i></button></form>";
		}
		else{
			$clientview = "";
		}
	}
}

if($client_onlineclient_search_sts == '1'){
	if($client_onlineclient_sts == '1'){
		if(in_array($c_iddd, $itemss1)){
			$clientactive = "<img src='/m/images/icon_led_green.png' style='width: 15px;margin-left: 5px;' alt='Online'/>";
		}
		else{
			$clientactive = "<img src='/m/images/icon_led_grey.png' style='width: 12px;margin-left: 5px;' alt='Offline'/>";
		}
	}
	else{
		$clientactive = "";
	}
}

								echo
									"<tr>
										<td style='width: 80%;'>
											<div>
												<img src='{$img}' class='userlistimg' title='Com ID: {$roww['com_id']}\r\nName: {$roww['c_name']}\r\nZone: {$roww['z_name']}\r\nAddress: {$roww['address']}\r\nCell: {$roww['cell']}\r\nPackage: {$roww['p_name']}-{$roww['bandwith']}\r\nPrice: {$roww['p_price']}৳ \r\n{$totaldue}{$totaldue1}\r\n{$pdbd}' />
												<div class='userlistfo'>
													<h5 title='{$roww['c_name']}\r\n{$roww['cell']}'>{$c_iddd}{$clientactive}</h5>
													<span class='pos'>{$roww['z_name']} <a {$collo}>[{$roww['con_sts']}]</a></span>
													<span>{$pdbd}</span>
													<span title='{$roww['p_name']}-{$roww['bandwith']}\r\nPrice: {$roww['p_price']}৳ \r\n{$pdbd}'>{$totaldue}{$remainingdays}</span>
												</div>
											</div>
										</td>
										
										<td style='vertical-align: middle;'>
											<div>
												{$clientview}
												{$payment_recharge}
											<div>
										</td>
										</tr>";
								}
							?>
</tbody></table>

<?php  }} else{} }?>
	  
<style type="text/css">
.userlist1 {
	display: block;
	border-bottom: 1px solid #ddd;
	padding: 7px 0px 20px 20px;
	cursor: pointer;
	list-style: none;
}

.userlistimg {
	display: block;
	width: 50px;
	float: left;
	border-radius: 5px;
	border: 1px solid #a9a9a963;
}

.userlistfo {
	margin-left: 65px;
	text-align: left;
}

.userlistfo h5 {
	font-size: 14px;
	text-transform: none;
	color: #0866c6;
	margin-bottom: 2px;
	font-family: 'LatoBold', 'Helvetica Neue', Helvetica, sans-serif;
	font-weight: normal;
	margin-top: 0px;
}

.userlistfo span.pos{
	display: block;
	font-size: 11px;
	line-height: 16px;
	color: #666;
}

.userlistfo span {
	display: block;
	font-size: 11px;
	line-height: 16px;
	color: #999;
}
</style>