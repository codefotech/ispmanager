<?php
$titel = "Client Profile";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type = '1' or $user_type = '2'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(104, $access_arry)){
//---------- Permission -----------

$ids = $_GET['id'];
extract($_POST);

$queryddd = mysql_query("SELECT tree_id FROM network_tree WHERE c_id ='$ids'");
$rowdd = mysql_fetch_assoc($queryddd);
$treeid = $rowdd['tree_id'];
if($treeid != ''){
	$sqltree = mysql_query("SELECT a.tree_id AS tid1, a.name AS dname1, l.d_name AS device_name1, a.in_color AS color1, b.tree_id AS tid2, b.name AS dname2, m.d_name AS device_name2, b.in_color AS color2, c.tree_id AS tid3, c.name AS dname3, n.d_name AS device_name3, c.in_color AS color3, d.tree_id AS tid4, d.name AS dname4, o.d_name AS device_name4, d.in_color AS color4, e.tree_id AS tid5, e.name AS dname5, p.d_name AS device_name5, e.in_color AS color5, f.tree_id AS tid6, f.name AS dname6, q.d_name AS device_name6, f.in_color AS color6, g.tree_id AS tid7, g.name AS dname7, r.d_name AS device_name7, g.in_color AS color7, h.tree_id AS tid8, h.name AS dname8, s.d_name AS device_name8, h.in_color AS color8
	FROM network_tree AS a 
							LEFT JOIN network_tree AS b ON b.tree_id = a.parent_id
							LEFT JOIN network_tree AS c ON c.tree_id = b.parent_id
							LEFT JOIN network_tree AS d ON d.tree_id = c.parent_id
							LEFT JOIN network_tree AS e ON e.tree_id = d.parent_id
							LEFT JOIN network_tree AS f ON f.tree_id = e.parent_id
							LEFT JOIN network_tree AS g ON g.tree_id = f.parent_id
							LEFT JOIN network_tree AS h ON h.tree_id = g.parent_id
							
							LEFT JOIN device AS l ON l.id = a.device_type
							LEFT JOIN device AS m ON m.id = b.device_type
							LEFT JOIN device AS n ON n.id = c.device_type
							LEFT JOIN device AS o ON o.id = d.device_type
							LEFT JOIN device AS p ON p.id = e.device_type
							LEFT JOIN device AS q ON q.id = f.device_type
							LEFT JOIN device AS r ON r.id = g.device_type
							LEFT JOIN device AS s ON s.id = h.device_type

WHERE a.tree_id = '$treeid'");
}

$sql36sst = mysql_query("SELECT o.id, o.p_id, p.pro_name, o.p_sl_no, c.c_name, c.c_id, c.cell, o.qty, o.out_date, e.e_name AS out_by, k.e_name AS receive_by, o.note, DATE_FORMAT(o.out_date_time, '%D %M %Y %r') AS out_date_time FROM store_out_instruments AS o
						LEFT JOIN product AS p ON p.id = o.p_id
						LEFT JOIN emp_info AS e	ON e.e_id = o.out_by
						LEFT JOIN emp_info AS k	ON k.e_id = o.receive_by 
						LEFT JOIN clients AS c ON c.c_id = o.c_id
						WHERE o.c_id = '$ids'");
$sql36sstcount = mysql_num_rows($sql36sst);

$sql36 = mysql_query("SELECT p.id, p.c_id, a.p_name AS old_package, a.p_price AS old_price, q.p_name AS nw_package, q.p_price AS nw_price, DATE_FORMAT(p.up_date, '%D %M %Y') AS up_date FROM package_change AS p
					LEFT JOIN package AS a
					ON a.p_id = p.c_package
					LEFT JOIN package AS q
					ON q.p_id = p.new_package
					WHERE c_id = '$ids' ORDER BY p.id DESC");
$sql36count = mysql_num_rows($sql36);
					
$sql360 = mysql_query("SELECT s.c_id, s.bank, b.type, s.amount, s.pay_date, s.bill_dsc, e.e_name FROM bill_signup AS s
					LEFT JOIN bills_type AS b ON b.bill_type = s.bill_type
					LEFT JOIN emp_info AS e ON e.e_id = s.ent_by
					WHERE c_id = '$ids' ORDER BY s.pay_date DESC");
$sql360count = mysql_num_rows($sql360);

$sql35 = mysql_query("SELECT m.id, m.ticket_no, m.c_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.ticket_sts, DATE_FORMAT(m.close_date_time, '%D %M %Y %h:%i%p') AS close_date_time, e.e_name, m.sts FROM complain_master AS m 
					LEFT JOIN department_info AS d
					ON d.dept_id = m.dept_id
					LEFT JOIN emp_info AS e
					ON e.e_id = m.close_by
					WHERE c_id = '$ids' ORDER BY m.ticket_no DESC");
$sql35count = mysql_num_rows($sql35);

$sql34 = mysql_query("SELECT s.id, s.c_id, c.c_name, s.con_sts, s.update_date, s.update_time, s.update_date_time, (case when (s.update_by = 'Auto') THEN 'Auto' ELSE e.e_name END) AS updateby, e.e_id AS updatebyid, s.note FROM con_sts_log AS s LEFT JOIN clients AS c ON c.c_id = s.c_id LEFT JOIN emp_info AS e ON e.e_id = s.update_by					
					WHERE s.c_id = '$ids' ORDER BY s.id DESC");
$sql34count = mysql_num_rows($sql34);


				

										
$result55 = mysql_query("SELECT c_id, c_name, cell, address FROM clients WHERE c_id = '$ids'");
$row55 = mysql_fetch_array($result55);	

$sql1 = mysql_query("SELECT pay_date, pay_amount, bill_discount FROM payment WHERE c_id = '$ids' ORDER BY pay_date");

$query = mysql_query("SELECT c.id, c.com_id, c.c_id, c.ip, c.breseller, c.raw_download, c.mac, c.ip, c.raw_upload, c.youtube_bandwidth, c.total_price, c.father_name, c.latitude, c.longitude, c.mk_id, c.connectivity_type, c.flat_no, c.onu_mac, c.house_no, c.road_no, c.thana, c.payment_deadline, e.e_name AS billman, w.e_name AS technician, c.b_date, b.b_name, c.mac_user, l.log_sts, l.image, l.nid_fond, l.nid_back, l.pw, c.c_name, c.z_id, z.z_name, z.z_bn_name, p.mk_profile, p.p_name, p.bandwith, p.p_price, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address,
 c.old_address, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.occupation, c.previous_isp, c.con_type, c.req_cable, c.cable_type, c.cable_sts, c.nid, c.p_id, c.signup_fee, c.note, c.sts, c.con_sts FROM clients AS c
					LEFT JOIN zone AS z	ON z.z_id = c.z_id
					LEFT JOIN box AS b ON b.box_id = c.box_id
					LEFT JOIN package AS p ON p.p_id = c.p_id 
					LEFT JOIN login AS l ON l.user_id = c.c_id 
					LEFT JOIN emp_info AS e ON e.e_id = c.bill_man 
					LEFT JOIN emp_info AS w ON w.e_id = c.technician 
					WHERE c_id ='$ids'");
$row = mysql_fetch_assoc($query);

$com_id = $row['com_id'];
$c_id = $row['c_id'];
$c_name = $row['c_name'];
$z_name = $row['z_name'];
$z_id = $row['z_id'];
$onu_mac = $row['onu_mac'];
$b_name = $row['b_name'];
$father_name = $row['father_name'];
$flat_no = $row['flat_no'];
$house_no = $row['house_no'];
$road_no = $row['road_no'];
$thana = $row['thana'];
$billman = $row['billman'];
$technician = $row['technician'];
$z_bn_name = $row['z_bn_name'];
$connectivity_type = $row['connectivity_type'];
$p_name = $row['p_name'];
$p_price = $row['p_price'];
$bandwith = $row['bandwith'];
$cell = $row['cell'];
$cell1 = $row['cell1'];
$cell2 = $row['cell2'];
$cell3 = $row['cell3'];
$cell4 = $row['cell4'];
$email = $row['email'];
$address = $row['address'];
$old_address = $row['old_address'];
$join = $row['joinn'];
$occupation = $row['occupation'];
$previous_isp = $row['previous_isp'];
$con_type = $row['con_type'];
$req_cable = $row['req_cable'];
$cable_type = $row['cable_type'];
$cable_sts = $row['cable_sts'];
$nid = $row['nid'];
$signup_fee = $row['signup_fee'];
$note = $row['note'];
$con_sts = $row['con_sts'];
$log_sts = $row['log_sts'];
$mk_id = $row['mk_id'];
$mac_user = $row['mac_user'];
$image = $row['image'];
$nid_fond = $row['nid_fond'];
$nid_back = $row['nid_back'];
$payment_deadline = $row['payment_deadline'];
$b_date = $row['b_date'];
$passid = $row['pw'];
$mk_profile = $row['mk_profile'];
$sts = $row['sts'];
$latitude = $row['latitude'];
$longitude = $row['longitude'];
$breseller = $row['breseller'];
$raw_download = $row['raw_download'];
$raw_upload = $row['raw_upload'];
$youtube_bandwidth = $row['youtube_bandwidth'];
$total_price = $row['total_price'];
$ipppp = $row['ip'];


if($mac_user == '0'){
	if($breseller == '2'){
		$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.invoice_id, a.paydate, a.bill_date AS date, a.bill_amount, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
								(
								SELECT b.c_id, b.invoice_date AS bill_date, b.invoice_id, '' AS paydate, SUM(b.total_price) AS bill_amount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.date_time AS pay_date_time
																		FROM billing_invoice AS b
																		LEFT JOIN clients AS c ON c.c_id = b.c_id
																		WHERE b.c_id = '$ids' AND b.sts = '0' GROUP BY b.invoice_id
														UNION
								SELECT p.c_id, p.pay_date AS bill_date, '' AS invoice_id, pay_date AS paydate, '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
															LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
															WHERE p.c_id = '$ids' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");
					
	$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(total_price) AS bill FROM billing_invoice WHERE sts = '0' GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment WHERE sts = '0' GROUP BY c_id)p
						ON p.c_id = c.c_id
						WHERE c.c_id = '$ids'");
	}
	else{
		$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.p_name, a.p_price, a.raw_download, a.raw_upload, a.total_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, p.p_name, p.p_price, c.raw_download, c.raw_upload, c.total_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$ids'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, '', '', '', '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$ids' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");
					
		$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$ids'");
	}
}
else{
		$sql = mysql_query("SELECT b.id, b.c_id, b.z_id, p.p_name, b.start_date, b.end_date, b.days, b.p_price, b.bill_amount, b.entry_by, b.entry_date FROM billing_mac AS b 
						LEFT JOIN package AS p ON p.p_id = b.p_id
						WHERE b.c_id = '$ids' Order by b.id desc");
						
		$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing_mac_client GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment_mac_client GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$ids'");
}

$rows = mysql_fetch_array($sql2);
$Dew = $rows['due'];

if($Dew > 0){
	$color = 'style="color:red;float: right; padding: 10px 8px 0 0;"';					
} else{
	$color = 'style="color:#000;float: right; padding: 10px 8px 0 0;"';
}

if($con_sts == 'Active'){
	$clss = 'ownbtn3';
	$dd = 'Inactive';
	$ee = "<i class='iconfa-play'></i>";
}
if($con_sts == 'Inactive'){
	$clss = 'ownbtn4';
	$dd = 'Active';
	$ee = "<i class='iconfa-pause'></i>";
}

if($log_sts == '0'){
	$aa = 'btn ownbtn6';
	$bb = "<i class='iconfa-unlock'></i>";
	$cc = 'Lock';
}
if($log_sts == '1'){
	$aa = 'btn ownbtn10';
	$bb = "<i class='iconfa-lock pad4'></i>";
	$cc = 'Unlock';
}


$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, online_sts, secret_h, graph, web_port FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk1 = mysql_fetch_assoc($sqlmk1);
		
		$ServerIP = $rowmk1['ServerIP'];
		$Username = $rowmk1['Username'];
		$Pass= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
		$Port = $rowmk1['Port'];
		$graph = $rowmk1['graph'];
		$web_port = $rowmk1['web_port'];
		$online_stsssss = $rowmk1['online_sts'];
		
//		<pppoe-BP@116MOHSIN>
		
		$interid = 'pppoe-'.$ids;

if($online_stsssss == '0'){
$API = new routeros_api();
$API->debug = false;

if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
	if($breseller == '0'){
		$API->write('/ppp/active/print', false);
		$API->write('?name='.$ids);
		$res=$API->read(true);

		$ppp_name = $res[0]['name'];
		$ppp_mac = $res[0]['caller-id'];
		$ppp_ip = $res[0]['address'];
		$ppp_uptime = $res[0]['uptime'];
		
		$API->write('/ppp/secret/print', false);
		$API->write('?name='.$ids);
		$ress=$API->read(true);
		$API->disconnect();
		
		$pppoe_mac = $ress[0]['caller-id'];
		$ppp_lastloggedout = $ress[0]['last-logged-out'];
		
		if($pppoe_mac == ''){
			$bindmac = 'Yes';
			$colllmac = 'iconfa-signin';
			$pppmac = $ppp_mac;
			$collr = 'color: green;';
			$claaaaa = 'ownbtn3';
			$title = 'Bind MAC';
		}
		else{
			$bindmac = 'No';
			$colllmac = 'iconfa-trash';
			$pppmac = '';
			$collr = 'color: red;';
			$claaaaa = 'ownbtn4';
			$title = 'Remove MAC';
		}
		if($pppoe_mac != '' && $ppp_mac != ''){
		$macccc = "<form action='MkToTisMacBind' method='post' title='{$title}' enctype='multipart/form-data'>
						<input type='hidden' name='bind' value='{$bindmac}'/> 
						<input type='hidden' name='mk_id' value='{$mk_id}'/> 
						<input type='hidden' name='mkc_id' value='{$c_id}'/> 
						<input type='hidden' name='wayyy' value='clientview'/>
						<input type='hidden' name='mkmac' value='{$pppmac}'/>
						<input type='hidden' name='c_id' value='{$c_id}'/>
						<button class='btn {$claaaaa}' style='padding: 1px 3px;'><i class='{$colllmac}' style='{$collr}'></i></button>
					</form>"; 
		}
		elseif($pppoe_mac != '' && $ppp_mac == ''){
			$macccc = "<form action='MkToTisMacBind' method='post' title='{$title}' enctype='multipart/form-data'>
						<input type='hidden' name='bind' value='{$bindmac}'/> 
						<input type='hidden' name='mk_id' value='{$mk_id}'/> 
						<input type='hidden' name='mkc_id' value='{$c_id}'/> 
						<input type='hidden' name='wayyy' value='clientview'/>
						<input type='hidden' name='mkmac' value='{$pppmac}'/>
						<input type='hidden' name='c_id' value='{$c_id}'/>
						<button class='btn {$claaaaa}' style='padding: 1px 3px;'><i class='{$colllmac}' style='{$collr}'></i></button>
					</form>"; 
		}
		elseif($pppoe_mac == '' && $ppp_mac != ''){
			$macccc = "<form action='MkToTisMacBind' method='post' title='{$title}' enctype='multipart/form-data'>
						<input type='hidden' name='bind' value='{$bindmac}'/> 
						<input type='hidden' name='mk_id' value='{$mk_id}'/> 
						<input type='hidden' name='mkc_id' value='{$c_id}'/> 
						<input type='hidden' name='wayyy' value='clientview'/>
						<input type='hidden' name='mkmac' value='{$pppmac}'/>
						<input type='hidden' name='c_id' value='{$c_id}'/>
						<button class='btn {$claaaaa}' style='padding: 1px 3px;'><i class='{$colllmac}' style='{$collr}'></i></button>
					</form>"; 
		}
		else{
			$macccc = "";
		}
	}
	if($breseller == '1'){
		
		$breseller_ip = $ipppp;
		
		$API->write('/ip/arp/getall', false);
		$API->write('?address='.$breseller_ip);
		$res=$API->read(true);
//		$API->disconnect();
		
		$ppp_mac = $res[0]['mac-address'];
		$macccc = "";
	}
	}
else{
	echo 'Network are not Connected';
	$query12312rr ="update mk_con set online_sts = '1' WHERE id = '$maikro_id'";
	$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error());
}
}
else{echo 'Network are Offline.';}
if($ppp_mac != ''){
	$ppp_mac_replace = str_replace(":","-",$ppp_mac);
	$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
		
	$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
	$macsearchaa = mysql_fetch_assoc($macsearch);
	$response = $macsearchaa['info'];
}
elseif($pppoe_mac != ''){
	$ppp_mac_replace = str_replace(":","-",$pppoe_mac);
	$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
		
	$macsearch = mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'");
	$macsearchaa = mysql_fetch_assoc($macsearch);
	$response = $macsearchaa['info'];
}
else{
	$response = '';
}


$query1="SELECT dept_id, dept_name FROM department_info ORDER BY dept_id ASC";
$result1 = mysql_query($query1);
$result2 = mysql_query("SELECT id, subject FROM complain_subject ORDER BY subject ASC");

$queryfdgh = "DELETE FROM realtime_speed WHERE c_id = '$c_id'";
if(!mysql_query($queryfdgh)){die('Error: ' . mysql_error());}

$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' AND z.z_id != '$z_id' order by e.e_name");
$resultsdfg1=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id = '' AND z.z_id != '$z_id' order by z.z_id");

$drhdrh = mysql_query("SELECT IFNULL(sum(`pay_amount`), 0.00) AS payamount FROM `payment` WHERE c_id = '$c_id'");
$drtrhr = mysql_fetch_assoc($drhdrh);
$payamount = $drtrhr['payamount'];

if($mac_user == '1'){
$sql1zfff = mysql_query("SELECT SUM(b.bill_amount) AS craditamount, b.z_id, e.e_name AS resellername, e.e_id AS resellerid, z.z_name AS resellerzone FROM billing_mac AS b 
LEFT JOIN emp_info AS e ON e.z_id = b.z_id
LEFT JOIN zone AS z ON z.z_id = e.z_id

WHERE b.c_id = '$c_id'");
$rowwzddd = mysql_fetch_array($sql1zfff);

$craditamount = $rowwzddd['craditamount'];
$resellernameee = $rowwzddd['resellername'];
$reselleriddd = $rowwzddd['resellerid'];
$resellerzoneee = $rowwzddd['resellerzone'];

$query1ghfh=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' order by id ASC");

$fgfsgsgggs=mysql_query("SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC");
}

?>
<link rel="stylesheet" href="css/reset-fonts-grids.css" type="text/css" />
<link rel="stylesheet" href="css/resume.css" type="text/css" />
	<script language="javascript">
		function PrintMe(DivID) {
		var disp_setting="toolbar=yes,location=no,";
		disp_setting+="directories=yes,menubar=yes,";
		disp_setting+="scrollbars=yes,width=1050, height=800, left=50, top=25";
		   var content_vlue = document.getElementById(DivID).innerHTML;
		   var docprint=window.open("","",disp_setting);
		   docprint.document.open();
		   docprint.document.write('<link rel="stylesheet" href="css/resume_print.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/reset-fonts-grids_print.css" type="text/css" />');
		   docprint.document.write('<link rel="stylesheet" href="css/style.default.css" type="text/css" />');
		   docprint.document.write('<head><title>Client Profile</title>');
		   docprint.document.write('<style type="text/css">body{ margin:0px;');
		   docprint.document.write('font-family:verdana,Arial;color:#000;');
		   docprint.document.write('font-family:Verdana, Geneva, sans-serif; font-size:12px;}');
		   docprint.document.write('a{color:#000;text-decoration:none;} </style>');
		   docprint.document.write('</head><body onLoad="self.print()"><center>');
		   docprint.document.write(content_vlue);
		   docprint.document.write('</center></body></html>');
		   docprint.document.close();
		   docprint.focus();
		}
	</script>
	
<!-- ------------------------------------------------------------------------------------------------------------------------------------- -->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal345345">
	<div id='Pointdiv122'></div>
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal34534555">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="padding: 0px 4px 8px 4px;">
				<div class="row">
					<div class="popdiv">
						<div id='Pointdiv1'></div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="SupportQuery">
	<input type="hidden" name="way" value="client" />
	<!---<input type="hidden" name="sentsms" value="Yes" />--->
	<input type="hidden" name="entry_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="entry_date_time" value="<?php echo $dateAndTime; ?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Complain</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Client:</div>
						<div class="col-2"> 
							<input type="hidden" name="c_id" required="" value="<?php echo $c_id; ?>" />
							<input type="text" value="<?php echo $c_name; ?> - <?php echo $c_id; ?>" readonly class="input-xlarge" />
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Complain To</div>
						<div class="col-2"> 
							<select data-placeholder="Department" name="dept_id" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row1=mysql_fetch_array($result1)) { ?>
								<option value="<?php echo $row1['dept_id']?>"><?php echo $row1['dept_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Subject</div>
						<div class="col-2">
							<select data-placeholder="Subject" name="sub" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row1=mysql_fetch_array($result2)) { ?>
								<option value="<?php echo $row1['subject']?>"><?php echo $row1['subject']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Complain</div>
						<div class="col-2"> 
							<textarea type="text" name="massage" placeholder="Write your Massege Here" required="" id="" style="width:270px;" /></textarea>
						</div>
					</div><br>
					<div class="popdiv">
						<div class="col-1">Send SMS?</div>
						<div class="col-2"> 
							<input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;
							<input type="radio" name="sentsms" value="No" checked="checked"> No
						</div>
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal22">
	<form id="form2" class="stdform" method="post" action="ClientToMacClient">
	<input type='hidden' name='wayyyyyy' value='clienttomacclient'/> 
	<input type='hidden' name='mk_id' value='<?php echo $mk_id;?>'/> 
	<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
	<input type='hidden' name='c_name' value='<?php echo $c_name;?>'/> 
	<input type='hidden' name='passid' value='<?php echo $passid;?>'/>
	<input type='hidden' name='mk_profile' value='<?php echo $mk_profile;?>'/>
	<input type='hidden' name='p_m' value='<?php echo $p_m;?>'/>
	<input type='hidden' name='mac_user' value='<?php echo $mac_user;?>'/>
	<input type='hidden' name='con_sts' value='<?php echo $con_sts;?>'/>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Transfer to Reseller Client</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Choose Reseller</div>
						<div class="col-2"> 
							<select data-placeholder="Choose Area" name="z_id" class="chzn-select"  style="width:333px;" onchange="submit();">
									<option value=""></option>
									<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
											<option value="<?php echo $row345['z_id']?>"><?php echo $row345['resellername']; ?> - <?php echo $row345['resellerid']; ?> - <?php echo $row345['z_name']; ?></option>
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

<?php if($mac_user == '1'){ ?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21">
	<form id="form2" class="stdform" method="post" action="ClientToMacClientQuery">
	<input type='hidden' name='wayyyyyy' value='clienttoownclient'/> 
	<input type='hidden' name='old_mk_id' value='<?php echo $mk_id;?>'/> 
	<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
	<input type='hidden' name='c_name' value='<?php echo $c_name;?>'/> 
	<input type='hidden' name='passid' value='<?php echo $passid;?>'/>
	<input type='hidden' name='old_mk_profile' value='<?php echo $mk_profile;?>'/>
	<input type='hidden' name='p_m' value='<?php echo $p_m;?>'/>
	<input type='hidden' name='mac_user' value='<?php echo $mac_user;?>'/>
	<input type='hidden' name='con_sts' value='<?php echo $con_sts;?>'/>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Transfer to Own Client</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="width: 20%;">Zone*</div>
						<div class="col-2"> 
							<select data-placeholder="Choose Zone" name="z_id" class="chzn-select" style="width:333px;" required="" >
									<option value=""></option>
									<?php while ($row345=mysql_fetch_array($resultsdfg1)) { ?>
											<option value="<?php echo $row345['z_id']?>"><?php echo $row345['z_id']; ?> - <?php echo $row345['z_name']; ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="width: 20%;">Network*</div>
						<div class="col-2"> 
							<select data-placeholder="Choose a Network" id="mk_id" name="mk_id" class="chzn-select" style="width:333px;" required="" >
										<option value=""></option>
									<?php while ( $row11ddd = mysql_fetch_array($fgfsgsgggs) ) { ?>
										<option value="<?php echo $row11ddd['id'];?>"><?php echo $row11ddd['Name'];?> (<?php echo $row11ddd['ServerIP'];?>)</option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="width: 20%;">Package*</div>
						<div class="col-2"> 
							<select data-placeholder="Choose a Package" id="p_id" name="p_id" class="chzn-select" style="width:333px;" required="" >
										<option value=""></option>
									<?php while ($row1=mysql_fetch_array($query1ghfh)) { ?>
										<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
									<?php } ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="popdiv">
					<?php if($mac_user == '1'){?>
							<p style="padding-right: 0px;">
									<span class="field" style="margin-left: 0px;font-weight: bold;font-size: 13px;"><a style="color: red;">Worning:</a> If you click submit, <a style="color: red;"><?php echo $craditamount;?></a> TK will credited in <a style="color: red;"><?php echo $resellerzoneee;?> (<?php echo $resellernameee;?> - <?php echo $reselleriddd;?>)</a> account balance.</span>
							</p>
							<?php } ?>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<?php } ?>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2177">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Send SMS To <?php echo $c_name;?> (<?php echo $c_id;?>)</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
							<form id="form2" class="stdform" method="post" action="ClientSMS">
									<input type='hidden' name='smsway' value='write'/> 
									<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cell;?>'/> 
									<input type='hidden' name='c_name' value='<?php echo $c_name;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
								<button class="btn ownbtn2" type="submit" style="float: left;margin-right: 1%;font-size: 12px;">Write SMS</button>
							</form>
							<form id="form2" class="stdform" method="post" action="ClientSMSSent">
									<input type='hidden' name='smsway' value='welcome'/> 
									<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cell;?>'/> 
								<button class="btn ownbtn8" type="submit" style="float: left;margin-right: 1%;font-size: 12px;">Welcome</button>
							</form>
							<form id="form2" class="stdform" method="post" action="ClientSMSSent">
									<input type='hidden' name='smsway' value='duebill'/> 
									<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cell;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
								<button class="btn ownbtn1" type="submit" style="float: left;margin-right: 1%;font-size: 12px;">Due Bill</button>
							</form>
							<form id="form2" class="stdform" method="post" action="ClientSMSSent">
									<input type='hidden' name='smsway' value='1remainder'/> 
									<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cell;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
								<button class="btn ownbtn3" type="submit" style="float: left;margin-right: 1%;font-size: 12px;">1st Remainder</button>
							</form>
							<form id="form2" class="stdform" method="post" action="ClientSMSSent">
									<input type='hidden' name='smsway' value='2remainder'/> 
									<input type='hidden' name='c_id' value='<?php echo $c_id;?>'/> 
									<input type='hidden' name='cell' value='<?php echo $cell;?>'/> 
									<input type='hidden' name='send_by' value='<?php echo $e_id;?>'/> 
								<button class="btn ownbtn3" type="submit" style="float: left;font-size: 12px;">2nd Remainder</button>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div><!--#myModal-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2111">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Ping</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
					<div class="growl00">
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
		<?php if(in_array(130, $access_arry)){?>
			<a data-placement='top' data-rel='tooltip' href='BillPaymentView?id=<?php echo $c_id; ?>' title='Ledger' target='_blank' class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></a>
		<?php } if(in_array(128, $access_arry)){?>
			<form action='PaymentAdd' method='post' target='_blank' style="float: left;padding-right: 3px;" data-placement='top' data-rel='tooltip' title='Add Payment'>
				<input type='hidden' name='c_id' value=<?php echo $c_id; ?> />
				<button class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-money'></i></button>
			</form>
		<?php } if($con_sts == 'Active' && $breseller != '2'){?>
			<form action='PackageChange' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='Change Package' style="float: left;padding-right: 3px;">
				<input type='hidden' name='cid' value=<?php echo $c_id; ?> />
				<button class='btn ownbtn6' style='padding: 6px 9px;'><i class='iconfa-signout'></i></button>
			</form>
		<?php } if($con_sts == 'Active' && $breseller == '2'){?>
			<form action='ClientEditMonthlyInvoice' method='post' target='_blank' data-placement='top' data-rel='tooltip' title='Edit Monthly Invoice' style="float: left;padding-right: 3px;">
				<input type='hidden' name='c_id' value=<?php echo $c_id; ?> />
				<button class='btn ownbtn6' style='padding: 6px 9px;'><i class='iconfa-signout'></i></button>
			</form>
		<?php } ?>
				<a data-placement='top' data-rel='tooltip' href='#myModal' title='Open Ticket' class='btn ownbtn3' style='padding: 6px 9px;' data-toggle="modal"><i class='iconfa-comments-alt'></i></a>
		<?php if($user_type == 'admin' || $user_type == 'superadmin' && $sts != '1' && $breseller != '1' && $breseller != '2'){ if($mac_user == '0' && $payamount == '0' or $mac_user == '1'){?>
				<a href='#myModal22' title='Transfer To reseller' class='btn ownbtn12' style='padding: 6px 9px;' data-toggle="modal"><i class='iconfa-refresh'></i></a>
		<?php }} if($user_type == 'admin' || $user_type == 'superadmin' && $sts != '1' && $breseller != '1' && $breseller != '2'){ if($mac_user == '1'){?>
				<a href='#myModal21' title='Transfer To Own' class='btn ownbtn12' style='padding: 6px 9px;' data-toggle="modal"><i class='iconfa-refresh'></i></a>
		<?php }} if(in_array(105, $access_arry)){?>
				<a href='#myModal2177' title='Send SMS' class='btn ownbtn1' style='padding: 6px 9px;' data-toggle="modal" /><i class='iconfa-envelope'></i></a>
			<button class='btn ownbtn10' style='padding: 6px 9px;' type="button" name="btnprint" value="Print" title='Print' onclick="PrintMe('divid')" style="float: right;" /><i class="iconfa-print"></i></button>
		<?php } if(in_array(102, $access_arry) && $sts != '1'){ ?>
			<form action='ClientDelete' method='post' data-placement='top' data-rel='tooltip' title='Delete' style="float: right;padding-right: 3px;"><input type='hidden' name='c_id' value='<?php echo $c_id;?>' /><button class='btn ownbtn4' style='padding: 6px 9px;' onclick="return checkDelete()"><i class='iconfa-trash'></i></button></form>
		<?php } if(in_array(103, $access_arry)){ ?>
			<form href='#myModal345345' data-toggle='modal' data-placement='top' data-rel='tooltip' title='<?php echo $dd;?>' style="float: right;padding-right: 3px;"><button type='submit' value="<?php echo $row['c_id'].'&consts='.$dd;?>" class='btn <?php echo $clss;?>' style='padding: 6px 9px;' onClick='getRoutePoint11(this.value)'><?php echo $ee;?></button></form>
		<?php } if(in_array(106, $access_arry) && $mac_user == '0'){ ?>
			<a data-placement='top' data-rel='tooltip' href='ClientLock?id=<?php echo $c_id; ?>' title='<?php echo $cc; ?>' class='<?php echo $aa; ?>' style='padding: 6px 9px;' onclick='return checkLock()'><?php echo $bb; ?></a>
		<?php } if(in_array(101, $access_arry)){ if($sts == '0'){ ?>
			<form action='<?php if($breseller == '2'){?>ClientEditInvoice<?php } else{?>ClientEdit<?php } ?>' method='post' data-placement='top' data-rel='tooltip' title='Edit' style="float: right;padding-right: 3px;padding-left: 3px;">
				<input type='hidden' name='c_id' value=<?php echo $c_id; ?> />
				<button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-edit'></i></button>
			</form>
		<?php }} if($graph == '1' && $web_port != '' && $breseller == '0'){?>
			<a data-placement='top' data-rel='tooltip' href='<?php echo 'http://'.$ServerIP.':'.$web_port.'/graphs/iface/<pppoe-'.$c_id.'>/';?>' title='User Graph' target='_blank' class='btn ownbtn11' style='padding: 6px 9px;'><i class='iconfa-bar-chart'></i></a>
		<?php } if($graph == '1' && $web_port != '' && $breseller == '1'){?>
			<a data-placement='top' data-rel='tooltip' href='<?php echo 'http://'.$ServerIP.':'.$web_port.'/graphs/queue/'.$c_id.'/';?>' title='User Graph' target='_blank' class='btn ownbtn11' style='padding: 6px 9px;'><i class='iconfa-bar-chart'></i></a>
        <?php } ?>
		</div>
		
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Client Profile</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<h5>Client Information</h5>
		</div>
		<div class="box-body">
			<div id="divid">
				<div id="doc2" class="yui-t7">
					<div id="inner">
						<div id="hd">
							<div class="yui-gc">
								<div class="yui-u first" style="width: 40%;">
									<h1><?php echo $c_name; ?></h1> 
									<h2><?php echo $c_id; ?></h2>
									<h2><?php echo $z_name.' ('.$z_bn_name.')';?></h2>
									<h2><?php echo 'Since  '.$join; ?></h2>
									<a><?php echo $cell; ?></a>
									<h3><?php echo $email; ?></h3>
								</div>
								<div class="yui-u first" style="width: 55%;">
								<?php if($image != ''){?>
								<div style="margin: 0;float: right;">
										<a href='<?php echo $image;?>' target='_blank' /><img src="<?php echo $image; ?>" height="105px" width="90px" style="border: 2px solid gray;"/></a>									
								</div>
								<?php } if($nid_back != ''){?>
								<div style="margin: 0 3.5% 0 0;float: right;">
										<a href='<?php echo $nid_back;?>' target='_blank' /><img src="<?php echo $nid_back; ?>" style="height: 100px;padding: 2px;border: 2px solid gray;" /></a>
								</div>
								<?php } if($nid_fond != ''){?>
								<div style="margin: 0 1% 0 0;float: right;">
										<a href='<?php echo $nid_fond;?>' target='_blank' /><img src="<?php echo $nid_fond; ?>" style="height: 100px;padding: 2px;border: 2px solid gray;" /></a>								
								</div>
								<?php } ?>
								</div>
							</div><!--// .yui-gc -->
							<?php if($breseller != '2'){?>
							<div class="row" style="margin-top: 10px;border-top: 1px solid #ddd;padding-top: 10px;">
								<div style="padding-left: 15px; width: 100%;">
									<table class="table table-bordered table-invoice" style="width: 47%; float: left;margin-right: 3%;">
										<?php if($breseller == '1'){?>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">MAC Address</td>
											<td class="width70" ><?php echo $ppp_mac; ?></td>
										</tr>
										<?php } else{ if($ppp_mac != ''){?>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">UPTIME</td>
											<td class="width70" style="font-family: gorgia;"><?php echo $ppp_uptime; ?></td>
										</tr>
										<?php } ?>
										<tr>
											<td style="text-align: right;font-weight: bold;">Last Logout</td>
											<td><?php echo $ppp_lastloggedout; ?></td>
										</tr>
										<?php } if($ppp_mac != ''){?>
										<tr>
											<td style="text-align: right;font-weight: bold;">Device Vendor</td>
											<td><?php echo $response; ?></td>
										</tr>
										<?php } if($ppp_mac != ''){?>
										<tr>
											<td style="text-align: right;font-weight: bold;">Status</td>
											<td style="color: green;font-weight: bold;">ONLINE<div class='rxxxx'></div></td>
										</tr>
										<?php } else{ } ?>
									</table>

									<table class="table table-bordered table-invoice" style="width: 47%; float: left;">
										<?php if($breseller == '0'){ if($ppp_mac != ''){?>
										<tr>
											<td style="text-align: right;font-weight: bold;">IP Address </td>
											<td style="padding: 5px 0px 5px 9px;"><div style="float: left;"><?php echo $ppp_ip;?></div><div style="float: left;margin-left: 15px;"><form href='#myModal34534555' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Click for Ping'><button type='submit' value="<?php echo $ppp_ip;?>&mk_id=<?php echo $mk_id;?>" class='btn ownbtn2' style='padding: 1px 3px;' onClick='getRoutePoint(this.value)'><i class='iconfa-chevron-right'></i></button></form></div></td>
										</tr>
										<?php }if($ppp_mac != '' || $pppoe_mac != ''){ ?>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">MAC Address</td>
											<td class="width70" style="padding: 5px 0px 5px 9px;"><div style="float: left;"><?php if($ppp_mac == ''){echo $pppoe_mac;} else{echo $ppp_mac;}?></div><div style="float: left;margin-left: 15px;"><?echo $macccc; ?></div></td>
										</tr>
										<?php }} else{ ?>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">IP Address </td>
											<td class="width70" style="padding: 5px 0px 5px 9px;"><div style="float: left;"><?php echo $breseller_ip;?></div><div style="float: left;margin-left: 15px;"><form href='#myModal34534555' data-toggle='modal' data-placement='top' data-rel='tooltip' title='Click for Ping'><button type='submit' value="<?php echo $breseller_ip;?>&mk_id=<?php echo $mk_id;?>" class='btn ownbtn2' style='padding: 1px 3px;' onClick='getRoutePoint(this.value)'><i class='iconfa-chevron-right'></i></button></form></div></td>
										</tr>
										<?php } if($ppp_mac != ''){} else{ ?>
										<tr>
											<td style="text-align: right;font-weight: bold;">Status</td>
											<td style="color: red;font-weight: bold;">OFFLINE</td>
										</tr>
										<?php } ?>
									</table>
									<div id='responsecontainer_tx'></div>
								</div><!--col-md-6-->
							</div><br><?php } ?>
							<?php if($ppp_mac != ''){?>
								<!--<div id='Client_graph'></div><br>-->
								<div id="container"></div>
							<?php if($graph == '1' && $web_port != ''){?>
								<table class="table" style="width: 100%;">
									<tr>
										<th style="background: white;padding: 0px;border-right: 1px solid #ddd;border-top: 1px solid #ddd;"><img src="<?php echo 'http://'.$ServerIP.':'.$web_port.'/graphs/iface/%3Cpppoe%2D'.$c_id.'%3E/daily.gif';?>" height="100px" width="100%"/></th>
										<th style="background: white;padding: 0px;border-top: 1px solid #ddd;border-right: 1px solid #ddd;"><img src="<?php echo 'http://'.$ServerIP.':'.$web_port.'/graphs/iface/%3Cpppoe%2D'.$c_id.'%3E/weekly.gif';?>" height="100px" width="100%"/></th>
										<th style="background: white;padding: 0px;border-top: 1px solid #ddd;border-right: 1px solid #ddd;"><img src="<?php echo 'http://'.$ServerIP.':'.$web_port.'/graphs/iface/%3Cpppoe%2D'.$c_id.'%3E/monthly.gif';?>" height="100px" width="100%"/></th>
										<th style="background: white;padding: 0px;border-top: 1px solid #ddd;"><img src="<?php echo 'http://'.$ServerIP.':'.$web_port.'/graphs/iface/%3Cpppoe%2D'.$c_id.'%3E/yearly.gif';?>" height="100px" width="100%"/></th>
									</tr>
									<tr>
										<td style="font-weight: bold;text-align: center;text-transform: uppercase;font-size: 11px;color: #317eac;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;font-family: arial,helvetica,clean,sans-serif;">"Daily" (5 Min Average)</td>
										<td style="font-weight: bold;text-align: center;text-transform: uppercase;font-size: 11px;color: #317eac;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;font-family: arial,helvetica,clean,sans-serif;">"Weekly" (30 Min Average)</td>
										<td style="font-weight: bold;text-align: center;text-transform: uppercase;font-size: 11px;color: #317eac;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;font-family: arial,helvetica,clean,sans-serif;">"Monthly" (2 Hr Average)</td>
										<td style="font-weight: bold;text-align: center;text-transform: uppercase;font-size: 11px;color: #317eac;border-bottom: 1px solid #ddd;font-family: arial,helvetica,clean,sans-serif;">"Yearly" (1 Day Average)</td>
									</tr>
									<!--<tr>
										<td colspan="4">Graph</td>
									</tr>-->
								</table>
							
							<?php }} else{ }?>
							</div>
																	<?php  if($treeid != ''){?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Diagram Tree Details</b></th>
					</tr>	
				</table>
			</div>

			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">Device-1</th>
							<th class="head0">Device-2</th>
							<th class="head1">Device-3</th>
							<th class="head0">Device-4</th>
							<th class="head1">Device-5</th>
							<th class="head0">Device-6</th>
							<th class="head1">Device-7</th>
							<th class="head0">Device-8</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								while( $rowwqw = mysql_fetch_assoc($sqltree) )
								{
									echo
										"<tr class='gradeX'>
											<td style='color: {$rowwqw['color1']};font-weight: bold;'>{$rowwqw['tid1']}<br>{$rowwqw['dname1']}<br>{$rowwqw['device_name1']}</td>
											<td style='color: {$rowwqw['color2']};font-weight: bold;'>{$rowwqw['tid2']}<br>{$rowwqw['dname2']}<br>{$rowwqw['device_name2']}</td>
											<td style='color: {$rowwqw['color3']};font-weight: bold;'>{$rowwqw['tid3']}<br>{$rowwqw['dname3']}<br>{$rowwqw['device_name3']}</td>
											<td style='color: {$rowwqw['color4']};font-weight: bold;'>{$rowwqw['tid4']}<br>{$rowwqw['dname4']}<br>{$rowwqw['device_name4']}</td>
											<td style='color: {$rowwqw['color5']};font-weight: bold;'>{$rowwqw['tid5']}<br>{$rowwqw['dname5']}<br>{$rowwqw['device_name5']}</td>
											<td style='color: {$rowwqw['color6']};font-weight: bold;'>{$rowwqw['tid6']}<br>{$rowwqw['dname6']}<br>{$rowwqw['device_name6']}</td>
											<td style='color: {$rowwqw['color7']};font-weight: bold;'>{$rowwqw['tid7']}<br>{$rowwqw['dname7']}<br>{$rowwqw['device_name7']}</td>
											<td style='color: {$rowwqw['color8']};font-weight: bold;'>{$rowwqw['tid8']}<br>{$rowwqw['dname8']}<br>{$rowwqw['device_name8']}</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
			</div>
			
							<?php } ?>
							<div id="yui-main">
								<div class="yui-b">
									<div class="yui-gf">
									<div class="yui-u first">
										<h2 style="font-size:14px;">Basic Info</h2>
									</div>
									<div class="yui-u">
										<table style="width: 90%;">
											<thead>
											  <tr>
												<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Client Name</th>
												<th style="font-weight: bold;padding: 0px;">:</th>
												<th style="padding: 0 0px 0px 10px;width: 45%"><?php echo $c_name;?></th>
												<th style="padding: 0 10px 0 10px;"></th>
												<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Father</th>
												<th style="font-weight: bold;padding: 0px;">:</th>
												<th style="padding: 0 0px 0px 10px;width: 25%;"><?php echo $father_name;?></th>
											  </tr>
											  <tr>
												<td style="font-weight: bold;height: 25px;">Client ID</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $c_id;?></td>
												<td></td>
												<td style="font-weight: bold;height: 25px;">Company ID</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $com_id;?></td>
											  </tr>
											   <tr>
												<td style="font-weight: bold;height: 25px;">Occupation</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $occupation;?></td>
												<td></td>
												<td style="font-weight: bold;height: 25px;">National ID</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $nid;?></td>
											  </tr>
											   <tr>
												<td style="font-weight: bold;height: 25px;"><?php if($breseller == '0'){?>Package<?php } else{ ?>Bandwidth<?php } ?></td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php if($breseller == '0'){echo $p_name.' ('.$bandwith.')';} else{ echo $raw_download.'mbps/'.$raw_upload.'mbps';}?></td>
												<td></td>
												
												<td style="font-weight: bold;height: 25px;">Package Rate</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php if($breseller == '0'){echo $p_price.' tk';} else{echo $total_price.' tk';} ?></td>
											  </tr>
											  <tr>
												<td style="font-weight: bold;height: 25px;">Signup Fee</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $signup_fee; ?></td>
												<td></td>
												<td style="font-weight: bold;height: 25px;">Previous ISP</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $previous_isp;?></td>
											  </tr>
											   <tr>
												<td style="font-weight: bold;height: 25px;">P.Deadline</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $payment_deadline;?></td>
												<td></td>
												<td style="font-weight: bold;height: 25px;">B.Deadline</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $b_date;?></td>
											  </tr>
											</thead>
										</table>
									</div>
									</div>
									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Address</h2>
										</div>
										<div class="yui-u">
											<table style="width: 90%;">
												<thead>
													<tr>
														<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Zone</th>
														<th style="font-weight: bold;padding: 0px;">:</th>
														<th style="padding: 0 0px 0px 10px;width: 45%"><?php echo $z_name.' ('.$z_bn_name.')';?></th>
														<th></th>
														<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Box</th>
														<th style="font-weight: bold;padding: 0px;">:</th>
														<th style="padding: 0 0px 0px 10px;width: 25%;"><?php echo $b_name;?></th>									
													</tr>
													<tr>
														<td style="font-weight: bold;height: 25px;">Flat No</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $flat_no;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">House No</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $house_no;?></td>
													 </tr>
													<tr>
														<td style="font-weight: bold;height: 25px;">Road No</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $road_no;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">Thana</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $thana;?></td>
													 </tr>
													 <tr>
														<td style="font-weight: bold;height: 25px;">Present Address</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $address;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">Old Address</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $old_address;?></td>
													 </tr>
												</thead>
											</table> 
										</div>
									</div><!--// .yui-gf-->
									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Technical Info</h2>
										</div>
										<div class="yui-u">
											<table style="width: 90%;">
												<thead>
													<tr>
														<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Client Type</th>
														<th style="font-weight: bold;padding: 0px;">:</th>
														<th style="padding: 0 0px 0px 10px;width: 45%"><?php echo $con_type;?></th>
														<th></th>
														<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Connectivity</th>
														<th style="font-weight: bold;padding: 0px;">:</th>
														<th style="padding: 0 0px 0px 10px;width: 25%;"><?php echo $connectivity_type;?></th>									
													</tr>
													<tr>
														<td style="font-weight: bold;height: 25px;">Bill Man</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $billman;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">Technician</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $technician;?></td>
													  </tr>
													<tr>
														<td style="font-weight: bold;height: 25px;">Cable Type</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $cable_type;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">ONU Mac</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $onu_mac; ?></td>
													 </tr>
													 <tr>
														<td style="font-weight: bold;height: 25px;">Required Cable</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $req_cable;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">Cable Status</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $cable_sts;?></td>
													  </tr>
													  <tr>
														<td style="font-weight: bold;height: 25px;">Line Status</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $con_sts;?></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
													  </tr>
												</thead>
											</table> 
										</div>
									</div><!--// .yui-gf-->
									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Contacts</h2>
										</div>
										<div class="yui-u">
											<table style="width: 90%;">
												<thead>
													<tr>
														<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Main Cell No</th>
														<th style="font-weight: bold;padding: 0px;">:</th>
														<th style="padding: 0 0px 0px 10px;width: 45%"><?php echo $cell; ?> &nbsp; &nbsp;<a data-placement='top' data-rel='tooltip' href='ClientSMS?id=<?php echo $c_id; ?>' data-original-title='Send SMS' class='btn col1'><i class='iconfa-comment'></i></a></th>
														<th></th>
														<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 15%;">Email</th>
														<th style="font-weight: bold;padding: 0px;">:</th>
														<th style="padding: 0 0px 0px 10px;width: 25%;"><?php echo $email;?></th>									
													</tr>
													<tr>
														<td style="font-weight: bold;height: 25px;">Alternative 1</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $cell1;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">Alternative 2</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $cell2;?></td>
													 </tr>
													 <tr>
														<td style="font-weight: bold;height: 25px;">Alternative 3</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $cell3;?></td>
														<td></td>
														<td style="font-weight: bold;height: 25px;">Alternative 4</td>
														<td style="font-weight: bold;">:</td>
														<td style="padding: 0 0px 0px 10px;"><?php echo $cell4;?></td>
													  </tr>
												</thead>
											</table> 
										</div>
									</div><!--// .yui-gf-->
									<div class="yui-gf">
										<div class="yui-u first">
											<h2 style="font-size:14px;">Note</h2>
										</div>
										<div class="yui-u">
											<table style="width: 90%;">
												<thead>
													<tr>
														<th style="font-weight: bold;padding: 0px;padding-right: 25px;height: 25px;width: 100%;"><?php echo $note; ?></th>
													</tr>
												</thead>
											</table> 
										</div>
									</div><!--// .yui-gf-->
								</div><!--// .yui-b -->
							</div><!--// yui-main -->
				<div id="hd">
					<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
						<tr>
							<th style="text-align:left"><b>Billing Information</b></th>
							<td <?php echo $color; ?>> <b>Total Due:</b> &nbsp; &nbsp; <?php echo number_format($Dew,2).'tk'; ?></td>
						</tr>	
					</table>
				</div>
					<?php if($mac_user == '1'){?>
				<div id="hd">
					<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">Start Date</th>
							<th class="head0">End Date</th>
							<th class="head1">Package/Rate</th>
							<th class="head0">Days</th>
							<th class="head1">Cost</th>
							<th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rowm = mysql_fetch_assoc($sql) )
								{
									$yrdata= strtotime($rowm['start_date']);
									$month = date('d F, Y', $yrdata);
									
									$yrdata1= strtotime($rowm['end_date']);
									$month1 = date('d F, Y', $yrdata1);
									
									if($rowm['entry_by'] == 'Archived'){
										$sgssgfg = "<form action='MacResellerClientBillHistory' method='post' target='_blank'><input type='hidden' name='c_id' value='{$c_id}'/><input type='hidden' name='way' value='archive'/><button type='submit' class='btn' style='font-weight: bold;font-size: 15px;color: #0866c6;'>Archived</button></form>";
									}
									echo
										"<tr class='gradeX'>
											<td>{$month}</td>
											<td>{$month1}</td>
											<td>{$rowm['p_name']} ({$rowm['p_price']})</td>
											<td>{$rowm['days']}</td>
											<td>{$rowm['bill_amount']} tk</td>
											<td>{$sgssgfg}</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
				</div>
							<?php } else{ if($breseller == '2'){?>
				<div id="hd">
					<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
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
							<th class="head1">Date</th>
							<th class="head0 center">Invoice No</th>
							<th class="head1 right">Total Bill</th>
							<th class="head0 right">Discount</th>
							<th class="head1 right">Payment</th>
							<th class="head0 center">Mathod</th>
							<th class="head1 center">MR/TrxID</th>
							<th class="head0 center">Entry By</th>
							<th class="head1 center hidedisplay">Print</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rown = mysql_fetch_assoc($sql) )
								{
										if(in_array(245, $access_arry) && $rown['pay_idd'] == '#'){
											$invoprint = "<li><form action='fpdf/BillPrintInvoiceClient' title='Print Invoice' method='post' target='_blank'><input type='hidden' name='invoice_id' value='{$rown['invoice_id']}'/><button class='btn ownbtn6' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>";
										}
										else{
											$invoprint = "";
										} 
									echo
										"<tr class='gradeX'>
											<td>{$rown['dateee']}</td>
											<td class='center'><a href='BillInvoiceView.php?id={$rown['invoice_id']}' style='font-size: 15px;font-weight: bold;'>{$rown['invoice_id']}</a></td>
											<td class='right'>{$rown['bill_amount']}</td>
											<td class='right'>{$rown['discount']}</td>
											<td class='right'>{$rown['payment']}</td>
											<td class='center'>{$rown['pay_mode']}</td>
											<td class='center'>{$rown['moneyreceiptno']}{$rown['sender_no']}<br>{$rown['trxid']}</td> 
											<td class='center'>{$rown['entrybyname']}</td>
											<td class='center hidedisplay' style='width: 100px !important;'>
												<ul class='tooltipsample'>
												{$invoprint}
												</ul>
											</td>
										</tr>\n";
								}
							?>
					</tbody>
				</table>
				</div>
							
							<?php } else{ ?>
				<div id="hd">
					<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
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
							<th class="head1">Date</th>
							<th class="head0">Package/Bandwidth</th>
							<th class="head1">Package Rate</th>
							<th class="head0">P.Discount</th>
							<th class="head0">P.Extra Bill</th>
							<th class="head1">Total Bill</th>
							<th class="head0">Discount</th>
							<th class="head1">Payment</th>
							<th class="head0">Mathod</th>
							<th class="head1">MR/TrxID</th>
							<th class="head0">Entry By</th>
							<th class="head1">Print</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rown = mysql_fetch_assoc($sql) )
								{
									
									if($rown['pay_idd'] != '#'){
										$ee = "<li><form action='fpdf/MRPrint' method='post' target='_blank' enctype='multipart/form-data'><input type='hidden' name='mrno' value='{$rown['pay_idd']}'/> <button class='btn ownbtn2' title='Print Money Receipt' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>"; 
									}
									else{
										$ee = '';
									}
									if($breseller == '0'){
										$packageeee = $rown['p_name'];
										$pacprice = $rown['p_price'];
									}
									else{
										if($rown['pay_idd'] == '#'){
											$packageeee = $rown['raw_download'].'mbps/'.$rown['raw_upload'].'mbps';
										}
										else{
											$packageeee = '';
										}
										$pacprice = $rown['total_price'];
									}
									echo
										"<tr class='gradeX'>
											<td>{$rown['dateee']}</td>
											<td>{$packageeee}</td>
											<td>{$pacprice}</td>
											<td>{$rown['p_discount']}</td>
											<td>{$rown['extra_bill']}</td>
											<td>{$rown['bill_amount']}</td>
											<td>{$rown['discount']}</td>
											<td>{$rown['payment']}</td>
											<td>{$rown['pay_mode']}</td>
											<td>{$rown['moneyreceiptno']}{$rown['sender_no']}<br>{$rown['trxid']}</td>
											<td>{$rown['entrybyname']}</td>
											<td class='center' style='width: 80px !important;'>
												<ul class='tooltipsample'>
												{$ee}
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
				</div>
							<?php }} if($mac_user == '1'){} else{ if($sql360count > '0'){?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Others Bill History</b></th>
					</tr>	
				</table>
			</div>
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
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
							<th class="head0">S/L</th>
							<th class="head1">Date</th>
							<th class="head0">Bill Type</th>
							<th class="head1">Amount</th>
							<th class="head0">Note</th>
							<th class="head1">Entry By</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowwqq = mysql_fetch_assoc($sql360) )
								{
									$yrdataa= strtotime($rowwqq['pay_date']);
									$months = date('d F, Y', $yrdataa);
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$months}</td>
											<td>{$rowwqq['type']}</td>
											<td>{$rowwqq['amount']} TK</td>
											<td>{$rowwqq['bill_dsc']}</td>
											<td>{$rowwqq['e_name']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
							<?php }} if($sql34count > '0'){?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Active/Inactive History</b></th>
						<!---<td <?php echo $color; ?>> <b>Total Active:</b> &nbsp; &nbsp; <?php echo $Dew; ?></td>
						<td <?php echo $color; ?>> <b>Total Inactive:</b> &nbsp; &nbsp; <?php echo $Dew; ?></td>-->
					</tr>	
				</table>
			</div>
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">S/L</th>
							<th class="head1">Date</th>
							<th class="head0">Time</th>
							<th class="head1">Status</th>
							<th class="head0">Update By</th>
							<th class="head1">Note</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $roww = mysql_fetch_assoc($sql34) )
								{
									if($roww['updateby'] != 'Auto'){
										$aaaaad = '('.$roww['updatebyid'].')';
									}
									else{
										$aaaaad = '';
									}
									$yrata= strtotime($roww['update_date']);
									$date_mon = date('d F, Y', $yrata);
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$date_mon}</td>
											<td>{$roww['update_time']}</td>
											<td>{$roww['con_sts']}</td>
											<td>{$roww['updateby']} {$aaaaad}</td>
											<td>{$roww['note']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
				<?php } if($sql36sstcount > '0'){?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Instruments Details</b></th>
					</tr>	
				</table>
			</div>
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">S/L</th>
							<th class="head0">Date</th>
							<th class="head0">Product</th>
							<th class="head0">Product Codes</th>
							<th class="head1">qty</th>
							<th class="head1">Out by</th>
							<th class="head0">Used by</th>
							<th class="head1">Note</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowwrr = mysql_fetch_assoc($sql36sst) )
								{
									echo
										"<tr class='gradeX'>
											<td class='center'>$x</td>
											<td><b>{$rowwrr['out_date_time']}</b></td>
											<td>{$rowwrr['pro_name']}</td>
											<td>{$rowwrr['p_sl_no']}</td>
											<td><b>{$rowwrr['qty']}</b></td>
											<td>{$rowwrr['out_by']}</td>
											<td>{$rowwrr['receive_by']}</td>
											<td>{$rowwrr['note']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
					<?php } if($sql36count > '0'){?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Package Change History</b></th>
						<!---<td <?php echo $color; ?>> <b>Total Active:</b> &nbsp; &nbsp; <?php echo $Dew; ?></td>
						<td <?php echo $color; ?>> <b>Total Inactive:</b> &nbsp; &nbsp; <?php echo $Dew; ?></td>-->
					</tr>	
				</table>
			</div>
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
						<col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">S/L</th>
							<th class="head1">Old Package</th>
							<th class="head0">New Package</th>
							<th class="head1">Change Date</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowwq = mysql_fetch_assoc($sql36) )
								{
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$rowwq['old_package']} [{$rowwq['old_price']}TK]</td>
											<td>{$rowwq['nw_package']} [{$rowwq['nw_price']}TK]</td>
											<td>{$rowwq['up_date']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
							<?php } if($userr_typ != 'mreseller'){ if($sql35count > '0'){?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Complain History</b></th>
						<!---<td <?php echo $color; ?>> <b>Total Active:</b> &nbsp; &nbsp; <?php echo $Dew; ?></td>
						<td <?php echo $color; ?>> <b>Total Inactive:</b> &nbsp; &nbsp; <?php echo $Dew; ?></td>-->
					</tr>	
				</table>
			</div>
			<div id="hd">
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
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
							<th class="head0">S/L</th>
							<th class="head1">Ticket No</th>
							<th class="head0">Subject</th>
							<th class="head1">Massage</th>
							<th class="head0">Entry Date</th>
							<th class="head1">Status</th>
							<th class="head0">Closeing Date</th>
							<th class="head1">Close By</th>
							<th class="head0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowws = mysql_fetch_assoc($sql35) )
								{
									if($rowws['sts'] == 0){
										$stss = 'Open';
									}
									if($rowws['sts'] == 1){
										$stss = 'Close';
									}
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$rowws['ticket_no']}</td>
											<td>{$rowws['sub']}</td>
											<td>{$rowws['massage']}</td>
											<td>{$rowws['entry_date_time']}</td>
											<td>{$stss}</td>
											<td>{$rowws['close_date_time']}</td>
											<td>{$rowws['e_name']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='SupportMassage?id=",$id,"{$rowws['ticket_no']}' data-original-title='View' target='_blank' class='btn col1'><i class='iconfa-eye-open'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
				<?php } } if($latitude != '' && $longitude != '' && $tree_sts_permission == '0'){?>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Geometric Location</b></th>
					</tr>	
				</table>
			</div>
			<div id="hd">
				<div id="googleMap" style="width:100%;height:300px;"></div>
			</div>	
				<?php } ?>
		</div>
		<!-- <div id="chart_div"></div> -->
		<div id="ft">
			<p><?php echo $CompanyName; ?> &mdash; <a href=""><?php echo $CompanyEmail; ?></a> &mdash; <?php echo $CompanyPhone; ?></p>
		</div><!--// footer -->
	</div><!-- // inner -->
</div><!--// doc -->
</div>
</div>	
		<div class="modal-footer">
			<button class="btn ownbtn12" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')">Print</button>
		</div>
<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				
<?php
}
else{
	header("Location:/index");
}
include('include/footer.php');
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
	
	function getRoutePoint11(afdId) {		
		
		var strURL="client-status-change-note.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv122').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint(afdId) {		
		
		var strURL="ip-ping-check2.php?ip="+afdId;
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
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete This Client !!  Are you sure?');
}

function checkStatus(){
    return confirm('Change Status?  Are you sure?');
}

function checkLock(){
    return confirm('Lock This Client?  Are you sure?');
}
</script>
<?php if($ppp_ip != '' && $online_stsssss == '0' && $ppp_mac != '' || $breseller_ip != '' && $online_stsssss == '0' && $ppp_mac != ''){?>

<script>
																var chart;
																function requestDatta(){
																	$.ajax({
																		url: 'Client_Tx_Rx1.php?mk_id=<?php echo $mk_id;?>&c_id=<?php echo $c_id;?>',
																		datatype: "json",
																		success: function(data){
																			var midata = JSON.parse(data);
																			if( midata.length > 0 ){
																				var TX=parseInt(midata[0].data);
																				var RX=parseInt(midata[1].data);
																				var x = (new Date()).getTime(); 
																				shift=chart.series[0].data.length > 50;
																				chart.series[0].addPoint([x, TX], true, shift);
																				chart.series[1].addPoint([x, RX], true, shift);
																			}
																		},
																		error: function(XMLHttpRequest, textStatus, errorThrown){ 
																			console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
																		}       
																	});
																}
																
																$(document).ready(function (){
																	Highcharts.setOptions({
																		global: {
																			useUTC: false
																		}, chart: {
																			height: 300
																		}
																	});
																	Highcharts.addEvent(Highcharts.Series, "afterInit", function (){
																		this.symbolUnicode = {
																			circle: "●",
																			diamond: "♦",
																			square: "■",
																			triangle: "▲",
																			"triangle-down": "▼"
																		}[this.symbol] || "●";
																	});

																	chart = new Highcharts.Chart({
																		chart: {
																			renderTo: 'container',animation: Highcharts.svg, type: "areaspline",
																			animation: Highcharts.svg,
																			events: {
																				load: function (){
																					setInterval(function (){
																						requestDatta(document.getElementById("interface").value);
																					}, 1000);
																				}				
																			}
																		},

																		title: {
																			text: 'Live Traffic'
																		},
																		xAxis: {
																		  type: 'datetime',
																		  tickPixelInterval: 150,
																		  maxZoom: 20 * 1000,
																		},
																		yAxis: {
																			minPadding: 0.1, 
																			maxPadding: 0.1, 
																			title: {
																				text: null
																			},
																			labels: {
																				formatter: function () {
																					var bytes = this.value;
																					var sizes = ["bps", "kbps", "Mbps", "Gbps", "Tbps"];
																					if (bytes == 0) return "0 bps";
																					var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
																					return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + " " + sizes[i];
																				}
																			}
																		},
																		series: [{
																			name: "Download", 
																			data: [], 
																			marker: {
																				symbol: "circle"
																			}
																		}, {
																			name: "Upload",
																			data: [],
																			marker: {
																				symbol: "circle"
																			}
																		}],
																		
																		tooltip: {
																			formatter: function (){
																				var s = [];
																				$.each(this.points, function (_0x3735x2, _0x3735x3){
																					var _0x3735x4 = _0x3735x3.y;
																					var _0x3735x5 = ["bps", "kbps", "Mbps", "Gbps", "Tbps"];
																					if (_0x3735x4 == 0) {
																					s.push('<span style="color:' + this.series.color + '; font-size: 1.5em;">' + this.series.symbolUnicode + "</span><b>" + this.series.name + ":</b> 0 bps");
																					}
																					;
																					var _0x3735x2 = parseInt(Math.floor(Math.log(_0x3735x4) / Math.log(1024)));
																					s.push('<span style="color:' + this.series.color + '; font-size: 1.5em;">' + this.series.symbolUnicode + "</span><b>" + this.series.name + ":</b> " + parseFloat((_0x3735x4 / Math.pow(1024, _0x3735x2)).toFixed(2)) + " " + _0x3735x5[_0x3735x2]);
																				});
																				return "<b>Time: </b>" + Highcharts.dateFormat("%H:%M:%S", new Date(this.x)) + "<br />" + s.join(" <br/> ");
																			}, shared: true
																		}
																	});
															  });
															</script>
															<script type="text/javascript" src="js/highcharts.js"></script>
															<script type="text/javascript" src="js/hc.light.js"></script>
															
															<input type=hidden name="interface" id="interface" type="text" />
<?php } ?>
<?php if($latitude != '' && $longitude != ''){?>
<script type="text/javascript">
function my_map_add() {
var myMapCenter = new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>);
var myMapProp = {center:myMapCenter, zoom:20, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("googleMap"),myMapProp);
var marker = new google.maps.Marker({position:myMapCenter});
marker.setMap(map);
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkwr5rmzY9btU08sQlU9N0qfmo8YmE91Y&libraries&callback=my_map_add"></script>
<?php } ?>

