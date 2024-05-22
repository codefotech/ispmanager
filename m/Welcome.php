<?php
$titel = "Welcome To Total ISP Solution";
include('include/hader.php');
include("mk_api.php");
extract($_POST);
//$userr_typ = $_SESSION['SESS_userr_typ'];
date_default_timezone_set('Etc/GMT-6');
$dateTime = date('Y-m-d', time());
$y_dateTime = date('Y-m-d',strtotime("-1 days"));

if($userr_typ == 'client'){
$ids = $_SESSION['SESS_EMP_ID'];
//$_SESSION['SESS_EMP_ID'] = $member['e_id'];
$result = mysql_query("SELECT c.c_id, c.c_name, c.mk_id, l.log_sts, c.cell, c.address, c.join_date, c.con_type, c.con_sts, c.discount, p.p_name, p.p_price,l.pw, c.mac_user, c.breseller, c.termination_date, c.payment_deadline FROM clients AS c
						LEFT JOIN package AS p
						ON p.p_id = c.p_id 
						LEFT JOIN login AS l 
						ON l.e_id = c.c_id 
						WHERE c_id = '$ids'");
$row = mysql_fetch_array($result);	

$mk_id = $row['mk_id'];

$sql360 = mysql_query("SELECT s.c_id, s.bank, b.type, s.amount, s.pay_date, s.bill_dsc, e.e_name FROM bill_signup AS s
					LEFT JOIN bills_type AS b ON b.bill_type = s.bill_type
					LEFT JOIN emp_info AS e ON e.e_id = s.ent_by
					WHERE c_id = '$ids' ORDER BY s.pay_date DESC");
					
$sql36 = mysql_query("SELECT p.id, p.c_id, a.p_name AS old_package, a.p_price AS old_price, a.p_price_reseller AS oldpackprice, q.p_name AS nw_package, q.p_price AS nw_price, q.p_price_reseller AS newpackprice, DATE_FORMAT(p.up_date, '%D %M %Y') AS up_date FROM package_change AS p
					LEFT JOIN package AS a
					ON a.p_id = p.c_package
					LEFT JOIN package AS q
					ON q.p_id = p.new_package
					WHERE c_id = '$ids' ORDER BY p.id DESC");

$sql35 = mysql_query("SELECT m.id, m.ticket_no, m.c_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.ticket_sts, DATE_FORMAT(m.close_date_time, '%D %M %Y %h:%i%p') AS close_date_time, e.e_name, m.sts FROM complain_master AS m 
					LEFT JOIN department_info AS d
					ON d.dept_id = m.dept_id
					LEFT JOIN emp_info AS e
					ON e.e_id = m.close_by

					WHERE c_id = '$ids' ORDER BY m.ticket_no DESC");

$sql34 = mysql_query("SELECT s.id, s.c_id, c.c_name, s.con_sts, s.update_date, s.update_time, s.update_date_time, s.update_by, e.e_name AS updateby FROM con_sts_log AS s
					LEFT JOIN clients AS c
					ON c.c_id = s.c_id
					LEFT JOIN emp_info AS e ON e.e_id = s.update_by
					WHERE s.c_id = '$ids' ORDER BY s.id DESC");
					


if($row['breseller'] == '2'){
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
		if($row['mac_user'] == '0'){
		$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.p_name, a.p_price, a.raw_download, a.raw_upload, a.total_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, '' AS sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
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
		else{
		$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.paydate, a.c_id, a.bill_date AS date, a.p_name, a.p_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.sender_no, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, '' AS paydate, p.p_name, p.p_price_reseller AS p_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS sender_no, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing_mac_client AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$ids'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, pay_date AS paydate, '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.sender_no, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment_mac_client AS p
							LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by
							WHERE p.c_id = '$ids' GROUP BY p.pay_date_time
					) AS a
					ORDER BY a.pay_date_time");
					
		$sql2 = mysql_query("SELECT c.c_id, (b.bill-IFNULL(p.paid,0)) AS due FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing_mac_client GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment_mac_client GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$ids'");
		}
	}
	
$rows = mysql_fetch_array($sql2);
$Dew = $rows['due'];			
if($Dew > 0){
	$color = 'style="color:red;text-align: right;padding-right: 20px;"';					
	$color1 = 'style="color:red;text-align: right;padding-right: 20px;font-size: 20px;"';					
} else{
	$color = 'style="color:#555555;text-align: right;padding-right: 20px;"';
	$color1 = 'style="color:#555555;text-align: right;padding-right: 20px;font-size: 20px;"';
}

if($row['con_sts'] == 'Active'){
	$clss = 'col2';
	$dd = 'Inactive';
	$ee = "<i class='iconfa-play'></i>";
}
if($row['con_sts'] == 'Inactive'){
	$clss = 'col3';
	$dd = 'Active';
	$ee = "<i class='iconfa-pause'></i>";
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

$sqlq = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h, online_sts FROM mk_con WHERE id = '$mk_id'");
$row2 = mysql_fetch_assoc($sqlq);
$online_stssssss = $row2['online_sts'];
$passs = openssl_decrypt($row2['Pass'], $row2['e_Md'], $row2['secret_h']);
$interid = 'pppoe-'.$ids;

if($row2['online_sts'] == '0'){
$API = new routeros_api();
$API->debug = false;
if ($API->connect($row2['ServerIP'], $row2['Username'], $passs, $row2['Port'])) {
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
		
		$ppp_lastloggedout = $ress[0]['last-logged-out'];
		
		$API->write('/interface/print', false);
		$API->write('from=<pppoe-'.$ids.'> stats-detail');
		$ressi=$API->read(true);
		
		$int_name = $ressi[0]['name'];
		$int_rx = $ressi[0]['rx-byte'];
		$int_tx = $ressi[0]['tx-byte'];
		
		$download_speed = $int_tx;
		$upload_speed = $int_rx;
		$API->disconnect();
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
else{
	$response = '';
}

$queryfdgh = "DELETE FROM realtime_speed WHERE c_id = '$ids'";
if(!mysql_query($queryfdgh)){die('Error: ' . mysql_error());}
}


if($userr_typ == 'mreseller'){
$sql12 = mysql_query("SELECT COUNT(id) AS TotalNewClients FROM clients WHERE MONTH(join_date) = MONTH('$dateTime') AND YEAR(join_date) = YEAR('$dateTime') AND sts = '0' AND z_id = '$macz_id'");
$row12 = mysql_fetch_array($sql12);
}
else{
$sql12 = mysql_query("SELECT COUNT(id) AS TotalNewClients FROM clients WHERE MONTH(join_date) = MONTH('$dateTime') AND YEAR(join_date) = YEAR('$dateTime') AND sts = '0'");
$row12 = mysql_fetch_array($sql12);
}

if($userr_typ == 'mreseller'){
$sql1 = mysql_query("SELECT COUNT(id) AS TotalClients FROM clients WHERE sts = '0' AND z_id = '$macz_id'");
$row1 = mysql_fetch_array($sql1);
}
else{
$sql1 = mysql_query("SELECT COUNT(id) AS TotalClients FROM clients WHERE sts = '0'");
$row1 = mysql_fetch_array($sql1);
}

if($userr_typ == 'mreseller'){
$sql2 = mysql_query("SELECT COUNT(con_sts) AS TotalActive FROM clients WHERE con_sts = 'Active' AND sts = '0' AND z_id = '$macz_id'");
$row2 = mysql_fetch_array($sql2);
}
else{
$sql2 = mysql_query("SELECT COUNT(con_sts) AS TotalActive FROM clients WHERE con_sts = 'Active' AND sts = '0'");
$row2 = mysql_fetch_array($sql2);
}

if($userr_typ == 'mreseller'){
$sql3 = mysql_query("SELECT COUNT(id) AS packages FROM package WHERE sts = '0' AND z_id = '$macz_id'");
$row3 = mysql_fetch_array($sql3);
}
else{
$sql3 = mysql_query("SELECT COUNT(id) AS packages FROM package WHERE sts = '0'");
$row3 = mysql_fetch_array($sql3);
}

if($userr_typ == 'admin' || $userr_typ == 'superadmin' || $userr_typ == 'accounts'){
$sql4 = mysql_query("SELECT count(ticket_no) as totalopen FROM complain_master WHERE sts = '0'");
$row4 = mysql_fetch_array($sql4);

$sql5 = mysql_query("SELECT IFNULL(SUM(amount),'0') AS totalexpance FROM expanse WHERE `status` = '0' AND ex_date = '$dateTime'");
$row5 = mysql_fetch_array($sql5);

$sql6 = mysql_query("SELECT IFNULL(SUM(pay_amount),'0') AS todaycollection FROM payment WHERE sts = '0' AND pay_date = '$dateTime'");
$row6 = mysql_fetch_array($sql6);

$sql7 = mysql_query("SELECT COUNT(l.c_id) AS todayautodisable FROM con_sts_log AS l
					RIGHT JOIN clients AS c
					ON c.c_id = l.c_id
					WHERE l.update_by = 'Auto' AND l.con_sts = 'Inactive' AND l.update_date = '$y_dateTime' AND c.con_sts != 'Active'");
$row7 = mysql_fetch_array($sql7);

$sql8 = mysql_query("SELECT IFNULL(sum(amount),'0') AS othersbill FROM bill_signup WHERE pay_date = '$dateTime'");
$row8 = mysql_fetch_array($sql8);

$sql9 = mysql_query("SELECT (SUM(t2.bill) - (SUM(t3.allpayments))) AS payablebill FROM
								(
								SELECT c.c_id, c.address, c.cell, z.z_name, c.p_id, p.p_price, c.note, c.p_m FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE c.sts = '0' AND c.mac_user = '0'
								)t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount) AS bill FROM billing AS b
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id
								LEFT JOIN
								(
								SELECT p.c_id, (SUM(p.pay_amount) + SUM(p.bill_discount)) AS allpayments FROM payment AS p 
								GROUP BY p.c_id
								)t3
								ON t1.c_id = t3.c_id");
$row9 = mysql_fetch_array($sql9);

$sql10 = mysql_query("SELECT SUM(p.pay_amount) AS totalmonthcollection
								FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id
								LEFT JOIN package AS pk ON c.p_id = pk.p_id
								LEFT JOIN emp_info AS e ON e.e_id = p.pay_ent_by
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE MONTH(p.pay_date) = MONTH('$dateTime') AND YEAR(p.pay_date) = YEAR('$dateTime') AND c.mac_user = '0'");
$row10 = mysql_fetch_array($sql10);

$Totalbills = $row9['payablebill'] + $row10['totalmonthcollection'];

$sql11 = mysql_query("SELECT SUM(signup_fee) AS thismonthsignupfee FROM clients WHERE MONTH(join_date) = MONTH('$dateTime') AND YEAR(join_date) = YEAR('$dateTime') AND signup_fee != '0' AND mac_user = '0' AND sts = '0'");
$row11 = mysql_fetch_array($sql11);

$sql19 = mysql_query("SELECT SUM(t2.discount) AS permanentdiscount FROM
								(
								SELECT c.c_id, c.address, c.cell, z.z_name, c.p_id, p.p_price, c.note, c.p_m FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE c.sts = '0' AND c.mac_user = '0'
								)t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount), SUM(b.discount) AS discount FROM billing AS b WHERE b.`day` = '0' AND MONTH(b.bill_date) = MONTH('$dateTime') AND YEAR(b.bill_date) = YEAR('$dateTime') 
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id");
$row19 = mysql_fetch_array($sql19);

$sql20 = mysql_query("SELECT IFNULL(SUM(t2.discount),'0.00') AS paiddiscount FROM
								(
								SELECT c.c_id, c.address, c.cell, z.z_name, c.p_id, p.p_price, c.note, c.p_m FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE c.sts = '0' AND c.mac_user = '0'
								)t1
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.pay_amount), SUM(b.bill_discount) AS discount FROM payment AS b WHERE b.bill_discount != '0.00' AND MONTH(b.pay_date) = MONTH('$dateTime') AND YEAR(b.pay_date) = YEAR('$dateTime')
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id");
$row20 = mysql_fetch_array($sql20);
}


$inactive = $row1['TotalClients'] - $row2['TotalActive'];

?>
	<?php if($sts == 'Recharge_add'){?>
			<div class="alert alert-success" style="padding: 3px 0 3px 10px;">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>You Recharged <?php echo $amount.' TK';?> Successfully!!</strong>.
			</div><!--alert-->
	<?php } if($sts == 'faild_add'){?>
			<div class="alert alert-error" style="padding: 3px 0 3px 10px;">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>You Recharged <?php echo $amount.' TK';?> Unsuccessful!!</strong>.
			</div><!--alert-->
	<?php } ?>
	<div class="box box-primary">
		<div class="box-body" style="padding: 0px 10px 0 10px;">
		<div class="pageheader" style="padding: 0px 10px 0 10px;">
        <div class="pagetitle">
		
            <center><h5>Welcome To <?php echo $comp_name; ?></h5>
			<?php if($userr_typ == 'admin' || $userr_typ == 'superadmin' || $userr_typ == 'billing_manager' || $userr_typ == 'accounts' || $userr_typ == 'mreseller' || $userr_typ == 'support' || $userr_typ == 'ets' || $userr_typ == 'support_manager'){ ?>
			<p>
				<input type="text" name="ccc_id" placeholder="Search" id="mainclientsearch" value= "" style="width:90%;border: 1px solid #00000030;height: 30px;border-radius: 5px;font-size: 20px;padding-left: 7px;color: gray;" />
			</p>
			<?php } ?>
			<div class="modal-body" style="padding: 5px;">
				<span id="searchresult">
			<?php if($userr_typ == 'admin' || $userr_typ == 'superadmin' || $userr_typ == 'accounts'){ ?>
					<div class="row">
						<div style="width: 100%;">
							<table class="table table-bordered table-invoice" style="width: 100%;font-weight: bold;">
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='Clients'>Total Clients</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><a href='Clients'><?php echo $row1['TotalClients']; ?></a></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='Clients?id=active'>Active Clients</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row2['TotalActive']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>Inactive Clients</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $inactive; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>New Clients</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row12['TotalNewClients']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>Auto Inactive</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row7['todayautodisable']; ?></td>
								</tr>
							</table>
							<table class="table table-bordered table-invoice" style="width: 100%;font-weight: bold;">
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='Support'>Open Ticket</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><a href='Clients'><?php echo $row4['totalopen']; ?><a></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Today Expanse</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row5['totalexpance']; ?>৳</td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Others Bill</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row8['othersbill']; ?>৳</td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>P.Discount</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row19['permanentdiscount']; ?>৳</td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Paid Discount</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row20['paiddiscount']; ?>৳</td>
								</tr>
							</table>
							<table class="table table-bordered table-invoice" style="width: 100%;font-weight: bold;">
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Payable Bill</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $Totalbills; ?>৳</td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Month Collection</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row10['totalmonthcollection']; ?>৳</td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Total Dues</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row9['payablebill']; ?>৳</td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Today Collection</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row6['todaycollection']; ?>৳</td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='#'>Signup Fee</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row11['thismonthsignupfee']; ?>৳</td>
								</tr>
							</table>
						</div><!--col-md-6-->
					</div>

			<?php } if($userr_typ == 'mreseller'){ 
			
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
			?>
					<div class="row">
						<div style="width: 100%;">
							<table class="table table-bordered table-invoice" style="width: 100%;font-weight: bold;">
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='Clients'>Online | Offline</a></td>
									<td style='font-size: 20px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;padding: 0 0 0 5px;vertical-align: middle;'><a href='Clients' style="color: green;"><?php echo $total_online_count;?></a> | <a href='Clients' style="color: red;"><?php echo $total_offline_count;?></a></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='Clients'>Total Clients</a></td>
									<td style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><a href='Clients'><?php echo $row1['TotalClients']; ?></a></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href='Clients?id=active'>Active Clients</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row2['TotalActive']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>Inactive Clients</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $inactive; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>New Clients</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo $row12['TotalNewClients']; ?></td>
								</tr>
								<?php if($billing_typee == 'Prepaid' && $over_due_balance < '0.00'){ ?>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>Max Due Limit</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'><?php echo number_format($over_due_balance_main,2);?>৳</td>
								</tr>
								<?php } ?>	
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>Balance</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;<?php echo $color; ?>'><?php echo number_format($aaaa, 2);?>৳</td>
								</tr>
		
								<?php if($userr_typ == 'mreseller' && in_array(1, $online_getway) || $userr_typ == 'mreseller' && in_array(6, $online_getway) || $userr_typ == 'mreseller' && in_array(4, $online_getway) || $userr_typ == 'mreseller' && in_array(2, $online_getway) || $userr_typ == 'mreseller' && in_array(5, $online_getway) || $userr_typ == 'mreseller' && in_array(3, $online_getway)){?>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 14px;font-weight: bold;text-align: right;"><a href=''>Recharge</a></td>
									<td class="" style='padding-top: 10px;font-size: 14px;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 50%;'>
									<form id="form" class="stdform" method="post" action="form">
										<input type="hidden" name="wayyy" value="reseller" />
										<input type="text" name="dewamount" required="" style="width: 50%;" />&nbsp;&nbsp;৳<br>
												<?php if(in_array(1, $online_getway)){?>
													<input class="btn ownbtn2" style="margin: 5px 0 0 0;" type="submit" value="bKash" onclick="javascript: form.action='PaymentOnline?gateway=bKash';"/>
												<?php } if(in_array(6, $online_getway)){?>
													<input class="btn ownbtn2" style="margin: 5px 0 0 0;" type="submit" value="bKashT" onclick="javascript: form.action='PaymentOnline?gateway=bKashT';"/>
												<?php } if(in_array(4, $online_getway)){?>
													<input class="btn ownbtn2" style="margin: 5px 0 0 0;" type="submit" value="Rocket" onclick="javascript: form.action='PaymentOnline?gateway=Rocket';"/>
												<?php } if(in_array(2, $online_getway)){?>
													<input class="btn ownbtn2" style="margin: 5px 0 0 0;" type="submit" value="iPay" onclick="javascript: form.action='PaymentOnline?gateway=iPay';"/>
												<?php } if(in_array(5, $online_getway)){?>
													<input class="btn ownbtn2" style="margin: 5px 0 0 0;" type="submit" value="Nagad" onclick="javascript: form.action='PaymentOnline?gateway=Nagad';"/>
												<?php } if(in_array(3, $online_getway)){?>
													<input class="btn ownbtn2" style="margin: 5px 0 0 0;" type="submit" value="SSLCommerz" onclick="javascript: form.action='PaymentOnline?gateway=SSLCommerz';"/>
												<?php } ?>
									</form>
									</td>
								</tr>
								<?php } ?>
							</table>
						</div><!--col-md-6-->
					</div>
			<?php } ?>
				</span>
			</div>
			<?php if($userr_typ == 'client' || $userr_typ == 'breseller'){ if($Dew > '9'){?>
				<div class="box-header" style="padding-top: 0px;">
				<?php if($row['mac_user'] == '1'){ if($external_online_link_mac == '1'){ if(in_array(1, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>&gateway=bKash"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(6, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>&gateway=bKashT"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(4, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=Rocket"><img src="<?php echo $weblink;?>imgs/rocket_s.png" title="Rocket" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(5, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=Nagad"><img src="<?php echo $weblink;?>imgs/nagad_s.png" title="Nagad" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(2, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=iPay"><img src="<?php echo $weblink;?>imgs/ip_rbttn.png" title="iPay" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(3, $online_getway)){?>
							<a href="<?php echo $weblink;?>PaymentOnlineExternal?clientid=<?php echo $row['c_id'];?>gateway=SSLCommerz"><img src="<?php echo $weblink;?>imgs/ssl.png" title="SSLCommerz" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
				<?php }} else {}} else{ ?>
						<?php if(in_array(1, $online_getway)){?>
							<a href="PaymentOnline?gateway=bKash"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(6, $online_getway)){?>
							<a href="PaymentOnline?gateway=bKashT"><img src="<?php echo $weblink;?>imgs/bk_rbttn.png" title="bKash" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(4, $online_getway)){?>
							<a href="PaymentOnline?gateway=Rocket"><img src="<?php echo $weblink;?>imgs/rocket_s.png" title="Rocket" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(5, $online_getway)){?>
							<a href="PaymentOnline?gateway=Nagad"><img src="<?php echo $weblink;?>imgs/nagad_s.png" title="Nagad" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php } if(in_array(2, $online_getway)){?>
							<a href="PaymentOnline?gateway=iPay"><img src="<?php echo $weblink;?>imgs/ip_rbttn.png" title="iPay" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
						<?php } if(in_array(3, $online_getway)){?>
							<a href="PaymentOnline?gateway=SSLCommerz"><img src="<?php echo $weblink;?>imgs/ssl.png" title="SSLCommerz" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
						<?php }} ?>
				</div>
				<?php } ?>
					<div class="row">
						<div style="padding-left: 5px; width: 100%;">
							<table class="table table-bordered table-invoice" style="width: 98%;font-weight: bold;margin-bottom: 0px;">
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>Total Due</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><a <?php echo $color1; ?>><?php echo number_format($Dew,2).'tk'; ?></a></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href=''>Status</a></td>
									<?php if($ppp_mac != ''){?>
										<td class="" style='padding-top: 10px;font-size: 14px;color: green;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'>ONLINE</td>
									<?php } else{ ?>
										<td class="" style='padding-top: 10px;font-size: 14px;color: red;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'>OFFLINE</td>
									<?php } ?>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>PPPoE ID</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $row['c_id']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>Password</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $row['pw']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>Name</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $row['c_name']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>cell</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><a href='#'><?php echo $row['cell']; ?></a></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>Address</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $row['address']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>Joining</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $row['join_date']; ?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>IP Address</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $ppp_ip;?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>MAC Address</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $ppp_mac;?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>UPTIME</a></td>
									<td style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $ppp_uptime;?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href='#'>Last Logout</a></td>
									<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $ppp_lastloggedout;?></td>
								</tr>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href=''>Device</a></td>
									<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $response; ?></td>
								</tr>
							<?php if($row['mac_user'] == '0'){ ?>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href=''>Deadline</a></td>
									<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $row['payment_deadline']; ?></td>
								</tr>
							<?php } ?>
								<tr>
									<td class="btn btn-info btn-rounded" style="width: 100%;border-radius: 0;border: 1px solid white;font-size: 10px;font-weight: bold;text-align: right;"><a href=''>Termination</a></td>
									<td class="" style='padding-top: 10px;font-size: 10px;color: #555555;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;width: 78%;'><?php echo $row['termination_date']; ?></td>
								</tr>
							</table>
								<div id='responsecontainer_tx'></div>
						</div><!--col-md-6-->

				<table style="width:100%;background: #eeeeee;font-size: 10px;">
					<tr>
						<th style="text-align:left;padding-left: 10px;"><b>Billing Information</b></th>
						<td <?php echo $color; ?>> <b>Total Due: &nbsp; &nbsp; <?php echo number_format($Dew,2).'tk'; ?></b></td>
					</tr>	
				</table>
		<?php if($row['breseller'] == '2'){ ?>
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
							<th class="head0" style="font-size: 9px;padding: 4px;">Date</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px;">Invoice No</th>
							<th class="head0 center" style="font-size: 9px;padding: 4px;">Bill</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px;">Dis</th>
							<th class="head0 center" style="font-size: 9px;padding: 4px;">Paid</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px;">MR</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rown = mysql_fetch_assoc($sql) )
								{
									if($rown['pay_idd'] == '#'){
											$invoprint = "<li><form action='fpdf/BillPrintInvoiceClient' title='Print Invoice' method='post' target='_blank'><input type='hidden' name='invoice_id' value='{$rown['invoice_id']}'/><button class='btn ownbtn6' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>";
										}
										else{
											$invoprint = "";
										}
									echo
										"<tr class='gradeX'>
											<td style='font-size: 9px;font-weight: bold;'>{$rown['dateee']}</td>
											<td class='center'><a href='#' style='font-size: 11px;font-weight: bold;'>{$rown['invoice_id']}</a></td>
											<td style='font-size: 11px;font-weight: bold;' class='center'>{$rown['bill_amount']}</td>
											<td style='font-size: 9px;font-weight: bold;' class='center'>{$rown['discount']}</td>
											<td style='font-size: 11px;font-weight: bold;' class='center'>{$rown['payment']}<br>{$rown['moneyreceiptno']}{$rown['trxid']}</td>
											<td style='font-size: 9px;font-weight: bold;' class='center hidedisplay'>
												<ul class='tooltipsample'>
													{$invoprint}
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
		<?php } else{ ?>
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
							<th class="head0" style="font-size: 9px;padding: 4px 0px 0px 4px;vertical-align: middle;">Date</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Pkg/Rate/ETC</th>
							<th class="head0 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Bill</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Dis</th>
							<th class="head0 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">Paid</th>
							<th class="head1 center" style="font-size: 9px;padding: 4px 0px 0px 0px;vertical-align: middle;">MR</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rown = mysql_fetch_assoc($sql) )
								{
									if($row['breseller'] == '0'){
										$packprice = $rown['p_price'];
									}
									else{
										$packprice = $rown['total_price'];
									}
									
									if($rown['pay_idd'] != '#'){
										$ee = "<li><form action='fpdf/MRPrint' method='post' target='_blank' enctype='multipart/form-data'><input type='hidden' name='mrno' value='{$rown['pay_idd']}'/> <input type='hidden' name='c_id' value='{$ids}'/> <button class='btn ownbtn2' title='Print Money Receipt' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>"; 
									}
									else{
										$ee = '';
									}
									
									if($row['breseller'] == '0'){
										$packageeee = $rown['p_name'];
									}
									else{
										if($rown['pay_idd'] == '#'){
											$packageeee = $rown['raw_download'].'mbps/'.$rown['raw_upload'].'mbps';
										}
										else{
											$packageeee = '';
										}
									}
									
									if($packageeee == ''){
										if($rown['sender_no'] != '' && $rown['trxid'] != ''){
											$onlineinfo = '<br>'.$rown['sender_no'].'<br>'.$rown['trxid'];
										}
										$packageeee = $rown['pay_mode'].$onlineinfo;
									}
									echo
										"<tr class='gradeX'>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;'>{$rown['dateee']}</td>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;' class='center'>{$packageeee}<br>{$packprice}</td>
											<td style='font-size: 15px;font-weight: bold;color: red;vertical-align: middle;' class='center'>{$rown['bill_amount']}</td>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;' class='center'>{$rown['discount']}</td>
											<td style='font-size: 9px;font-weight: bold;vertical-align: middle;' class='center'><b style='font-size: 15px;color: green;'>{$rown['payment']}</b></td>
											<td class='center' style='font-size: 9px;font-weight: bold;vertical-align: middle;'>
												<ul class='tooltipsample' style='margin: 0px;'>
													{$ee}
												</ul>
											</td>
										</tr>\n";
								}  
							?>
					</tbody>
				</table>
			<?php } ?>
			<?php if(mysql_num_rows($sql360) > '0'){?>
				<table style="width:100%;background: #eeeeee;font-size: 10px;">
					<tr>
						<th style="text-align:left;padding-left: 10px;"><b>Others Bill History</b></th>
					</tr>	
				</table>
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1" style="font-size: 9px;">Date</th>
							<th class="head0" style="font-size: 9px;">Type</th>
							<th class="head1" style="font-size: 9px;">Amount</th>
							<th class="head1" style="font-size: 9px;">Entry</th>
                        </tr>
                    </thead>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								while( $rowwqq = mysql_fetch_assoc($sql360) )
								{
									$yrdataa= strtotime($rowwqq['pay_date']);
									$months = date('d F, Y', $yrdataa);
									echo
										"<tr class='gradeX'>
											<td style='font-size: 9px;font-weight: bold;'>{$months}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowwqq['type']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowwqq['amount']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowwqq['e_name']}</td>
										</tr>\n ";
								} 
						?>
					</tbody>
				</table>
			<?php } if(mysql_num_rows($sql36) > '0'){?>
				<table style="width:100%;background: #eeeeee;font-size: 10px;">
					<tr>
						<th style="text-align:left;padding-left: 10px;"><b>Package Change History</b></th>
					</tr>	
				</table>
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0" style="font-size: 9px;">Date</th>
							<th class="head0" style="font-size: 9px;">Old Pkg</th>
							<th class="head1" style="font-size: 9px;">New Pkg</th>
                        </tr>
                    </thead>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								$x = 1;				
								while( $rowwq = mysql_fetch_assoc($sql36) )
								{
									if($row['mac_user'] == '1'){
										$oldpackprice = $rowwq['oldpackprice'];
										$newpackprice = $rowwq['newpackprice'];
									}
									else{
										$oldpackprice = $rowwq['old_price'];
										$newpackprice = $rowwq['nw_price'];
									}
									echo
										"<tr class='gradeX'>
											<td style='font-size: 9px;font-weight: bold;'>{$rowwq['up_date']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowwq['old_package']} [{$oldpackprice}TK]</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowwq['nw_package']} [{$newpackprice}TK]</td>
										</tr>\n ";
									$x++;	
								} 
						?>
					</tbody>
				</table>
<?php } if(mysql_num_rows($sql35) > '0'){?>
				<table style="width:100%;background: #eeeeee;font-size: 10px;">
					<tr>
						<th style="text-align:left;padding-left: 10px;"><b>Complain History</b></th>
					</tr>	
				</table>
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
							<th class="head1" style="font-size: 9px;">Date</th>
							<th class="head0" style="font-size: 9px;">Tkt_No</th>
							<th class="head1" style="font-size: 9px;">Subject</th>
							<th class="head1" style="font-size: 9px;">Massage</th>
							<th class="head0" style="font-size: 9px;">Status</th>
                        </tr>
                    </thead>
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
											<td style='font-size: 9px;font-weight: bold;'>{$rowws['entry_date_time']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowws['ticket_no']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowws['sub']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$rowws['massage']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$stss}</td>
											
										</tr>\n ";
									$x++;	
								}
						?>
					</tbody>
				</table>

<?php } if(mysql_num_rows($sql34) > '0'){?>
				<table style="width:100%;background: #eeeeee;font-size: 10px;">
					<tr>
						<th style="text-align:left;padding-left: 10px;"><b>Connection History</b></th>
					</tr>	
				</table>
				<table id="dyntable" class="table table-bordered responsive" style="width: 100% !important;float: left;margin-right: 10px;">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1" style="font-size: 9px;">Date</th>
							<th class="head1" style="font-size: 9px;">Time</th>
							<th class="head1" style="font-size: 9px;">Status</th>
                        </tr>
                    </thead>
                        </tr>
                    </thead>
                    <tbody>
						<?php		
								$x = 1;				
								while( $roww = mysql_fetch_assoc($sql34) )
								{
									if($roww['update_by'] == 'Auto'){
										$updatebyy = 'Auto';
									}
									else{
										$updatebyy = $roww['updateby'];
									}
									$yrata= strtotime($roww['update_date']);
									$date_mon = date('d F, Y', $yrata);
									echo
										"<tr class='gradeX'>
											<td style='font-size: 9px;font-weight: bold;'>{$date_mon}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$roww['update_time']}</td>
											<td style='font-size: 9px;font-weight: bold;'>{$roww['con_sts']}</td>
										</tr>\n ";
									$x++;	
								}  
						?>
					</tbody>
				</table>
				
		<?php } ?>
		</div>
			<?php } ?>
<br/><br/><br/>
				
			</center>
			
        </div>
    </div><!--pageheader-->
			</div>			
	</div>	
			
<?php
include('include/footer.php');

if($ppp_ip != '' && $online_stssssss == '0' || $breseller_ip != '' && $online_stssssss == '0'){?>
<script language="JavaScript" type="text/javascript">
 $(document).ready(function() {
 	 $("#responsecontainer_tx").load("Client_Tx_Rx.php?mk_id=<?php echo $mk_id;?>&c_id=<?php echo $ids;?>");
   var refreshId = setInterval(function() {
      $("#responsecontainer_tx").load('Client_Tx_Rx.php?mk_id=<?php echo $mk_id;?>&c_id=<?php echo $ids;?>');
   }, 5000);
   $.ajaxSetup({ cache: false });
});
</script>
<?php } else{} ?>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#mainclientsearch").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 2)
  {  
   $("#searchresult").html('');
   $.ajax({
    
    type : 'POST',
    url  : 'MainClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
          $("#searchresult").html(data);
        }
    });
    return false;
  }
  else
  {
   $("#searchresult").html('Searching...');
  }
 });
});
</script>