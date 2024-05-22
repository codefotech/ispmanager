<?php
$titel = "Dashboard";
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'welcome' AND $user_type = '1' or '2'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '1' AND $user_type = '1' or '2'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------
//$wayyy = $_POST['wayyy'];
date_default_timezone_set('Etc/GMT-6');
$dateTime = date('Y-m-d', time());
$lastmonth = date("Y-n-j", strtotime("first day of previous month"));
$lastmonthlastday = date("Y-n-j", strtotime("last day of previous month"));
$y_dateTime = date('Y-m-d');
$y11_dateTime = date('Y-m-d',strtotime("-1 days"));;
$Date = date('d/m/Y');
$f_edate = date("Y-m-01", time());
$t_edate = date("Y-m-d", time());
$thismonth = date('F-Y', time());

if(empty($_POST['f_date']) || empty($_POST['t_date'])){
	$f_date = date("Y-m-01");
	$t_date = date("Y-m-d");
}

$bill_month = isset($_POST['bill_month']) ? $_POST['bill_month'] : '';
$bill_monthhh = isset($_POST['bill_monthhh']) ? $_POST['bill_monthhh'] : '';
$sts_month = isset($_POST['sts_month']) ? $_POST['sts_month'] : '';

if($bill_month == ''){
	$bill_month = $f_date;
	$thismonthsearch = date('F-Y', time());
}
else{
	$bill_month = $bill_month;
	$thismonthsearch = date('F-Y', strtotime($bill_month));
}

if($bill_monthhh == ''){
	$bill_monthhh = $f_date;
	$thismonthsearch1 = date('F-Y', time());
}
else{
	$bill_monthhh = $bill_monthhh;
	$thismonthsearch1 = date('F-Y', strtotime($bill_monthhh));
}

if($sts_month == ''){
	$sts_month = $f_date;
}
else{
	$sts_month = $sts_month;
}

$thismonthword = date('M-y', time());
$lastmonthword = date('M-y', strtotime("first day of previous month"));

//$query2dddd = mysql_query("SELECT active_tab FROM app_search WHERE e_id = '$e_id' AND active_tab != '' ORDER BY id DESC LIMIT 1");
//$row2sssd = mysql_fetch_assoc($query2dddd);
$active_tab = $row2sssd['active_tab'];

if($userr_typ == 'mreseller'){
$sql12 = mysql_query("SELECT COUNT(id) AS TotalNewClients FROM clients WHERE MONTH(join_date) = MONTH('$dateTime') AND YEAR(join_date) = YEAR('$dateTime') AND sts = '0' AND z_id = '$macz_id' AND mac_user = '1'");
$row12 = mysql_fetch_array($sql12);
}
else{
$sql12 = mysql_query("SELECT COUNT(id) AS TotalNewClients FROM clients WHERE MONTH(join_date) = MONTH('$dateTime') AND YEAR(join_date) = YEAR('$dateTime') AND sts = '0' AND mac_user != '1'");
$row12 = mysql_fetch_array($sql12);
}

if($userr_typ == 'mreseller'){
$sql1 = mysql_query("SELECT COUNT(id) AS TotalClients FROM clients WHERE sts = '0' AND z_id = '$macz_id' AND mac_user = '1'");
$row1 = mysql_fetch_array($sql1);
}
else{
$sql1 = mysql_query("SELECT COUNT(id) AS TotalClients FROM clients WHERE sts = '0' AND mac_user != '1'");
$row1 = mysql_fetch_array($sql1);
}

if($userr_typ == 'mreseller'){
$sql2 = mysql_query("SELECT COUNT(con_sts) AS TotalActive FROM clients WHERE con_sts = 'Active' AND sts = '0' AND z_id = '$macz_id'");
$row2 = mysql_fetch_array($sql2);
}
else{
$sql2 = mysql_query("SELECT COUNT(con_sts) AS TotalActive FROM clients WHERE con_sts = 'Active' AND sts = '0' AND mac_user != '1'");
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

if(in_array(224, $access_arry)){
$sql4 = mysql_query("SELECT count(ticket_no) as totalopen FROM complain_master WHERE sts = '0'");
$row4 = mysql_fetch_array($sql4);
}

if(in_array(227, $access_arry)){
$sql5 = mysql_query("SELECT IFNULL(SUM(amount),'0') AS totalexpance FROM expanse WHERE `status` = '2' AND ex_date = '$dateTime'");
$row5 = mysql_fetch_array($sql5);
}

if(in_array(225, $access_arry)){
$sql50000 = mysql_query("SELECT IFNULL(SUM(amount),'0') AS totalexpance FROM expanse WHERE `status` = '2' AND MONTH(ex_date) = MONTH('$dateTime') AND YEAR(ex_date) = YEAR('$dateTime')");
$row50000 = mysql_fetch_array($sql50000);
}

if(in_array(233, $access_arry)){
$sql6 = mysql_query("SELECT IFNULL(SUM(pay_amount),'0') AS todaycollection FROM payment WHERE sts = '0' AND pay_date = '$dateTime'");
$row6 = mysql_fetch_array($sql6);
}

if(in_array(226, $access_arry)){
	if($userr_typ == 'mreseller'){
	$sql7qqw = mysql_query("SELECT COUNT(l.c_id) AS todayautodisable FROM con_sts_log AS l
						RIGHT JOIN clients AS c	ON c.c_id = l.c_id
						WHERE l.update_by = 'Auto' AND l.con_sts = 'Inactive' AND l.update_date = '$y_dateTime' AND c.con_sts != 'Active' AND c.z_id = '$macz_id'");
	$row7sds = mysql_fetch_array($sql7qqw);
	}
	else{
	$sql7 = mysql_query("SELECT COUNT(l.c_id) AS todayautodisable FROM con_sts_log AS l
						RIGHT JOIN clients AS c	ON c.c_id = l.c_id
						WHERE l.update_by = 'Auto' AND l.con_sts = 'Inactive' AND l.update_date = '$y_dateTime' AND c.con_sts != 'Active' AND c.mac_user = '0'");
	$row7 = mysql_fetch_array($sql7);
	}
}


$sql8 = mysql_query("SELECT IFNULL(sum(amount),'0') AS othersbill FROM bill_signup WHERE pay_date = '$dateTime'");
$row8 = mysql_fetch_array($sql8);

$sql9 = mysql_query("SELECT ((SUM(t2.bill) + IFNULL(SUM(t4.invoice_price), 0.00)) - (SUM(t3.allpayments))) AS payablebill FROM
								(
								SELECT c.c_id FROM clients AS c 
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
								ON t1.c_id = t3.c_id
                                
                             	LEFT JOIN
								(
                                SELECT c_id, IFNULL(SUM(total_price), 0.00) AS invoice_price FROM billing_invoice
								GROUP BY c_id
								)t4
								ON t1.c_id = t4.c_id");
$row9 = mysql_fetch_array($sql9);

$sql99999 = mysql_query("SELECT ((SUM(t2.bill) + IFNULL(SUM(t4.invo_bill),0.00)) - (SUM(t3.allpayments))) AS payablebill FROM
								(
								SELECT c.c_id, c.address, c.cell, z.z_name, c.p_id, p.p_price, c.note, c.p_m FROM clients AS c 
								LEFT JOIN package AS p ON c.p_id = p.p_id
								LEFT JOIN zone AS z ON z.z_id = c.z_id
								WHERE c.sts = '0' AND c.mac_user = '0'
								)t1
                                
								LEFT JOIN
								(
								SELECT b.c_id, SUM(b.bill_amount) AS bill FROM billing AS b WHERE bill_date <= '$lastmonthlastday'
								GROUP BY b.c_id
								)t2
								ON t1.c_id = t2.c_id
                                
								LEFT JOIN
								(
								SELECT c_id, IFNULL(SUM(total_price),0.00) AS invo_bill FROM billing_invoice WHERE sts = '0' AND invoice_date <= '$lastmonthlastday'
								GROUP BY c_id
								)t4
								ON t1.c_id = t4.c_id
                                
								LEFT JOIN
								(
								SELECT p.c_id, (SUM(p.pay_amount) + SUM(p.bill_discount)) AS allpayments FROM payment AS p WHERE pay_date <= '$lastmonthlastday'
								GROUP BY p.c_id
								)t3
								ON t1.c_id = t3.c_id");
$row99999 = mysql_fetch_array($sql99999);

$sql20 = mysql_query("SELECT IFNULL(SUM(bill_discount), 0.00) AS paiddiscount FROM payment WHERE bill_discount != '0.00' AND MONTH(pay_date) = MONTH('$dateTime') AND YEAR(pay_date) = YEAR('$dateTime')");
$row20 = mysql_fetch_array($sql20);

$sql19 = mysql_query("SELECT IFNULL(SUM(discount), 0.00) AS permanentdiscount FROM billing WHERE day = '0' AND MONTH(bill_date) = MONTH('$dateTime') AND YEAR(bill_date) = YEAR('$dateTime')");
$row19 = mysql_fetch_array($sql19);

$sql110 = mysql_query("SELECT SUM(bill_amount) AS bill FROM billing WHERE MONTH(bill_date) = MONTH('$dateTime') AND YEAR(bill_date) = YEAR('$dateTime')");
$row11110 = mysql_fetch_array($sql110);

$sql110invo = mysql_query("SELECT IFNULL(SUM(total_price), 0.00) AS invo_bill FROM billing_invoice WHERE sts = '0' AND MONTH(invoice_date) = MONTH('$dateTime') AND YEAR(invoice_date) = YEAR('$dateTime')");
$row11110invo = mysql_fetch_array($sql110invo);


$sql11011 = mysql_query("SELECT SUM(bill_amount) AS lastmonthbill FROM billing WHERE MONTH(bill_date) = MONTH('$lastmonth') AND YEAR(bill_date) = YEAR('$lastmonth')");
$row1111011 = mysql_fetch_array($sql11011);

$sql110invoss = mysql_query("SELECT IFNULL(SUM(total_price), 0.00) AS invo_bill FROM billing_invoice WHERE sts = '0' AND MONTH(invoice_date) = MONTH('$lastmonth') AND YEAR(invoice_date) = YEAR('$lastmonth')");
$row11110invoss = mysql_fetch_array($sql110invoss);

$sql10111 = mysql_query("SELECT (SUM(pay_amount) + SUM(bill_discount)) AS lastmonthcollection FROM payment WHERE MONTH(pay_date) = MONTH('$lastmonth') AND YEAR(pay_date) = YEAR('$lastmonth')");
$row10111111 = mysql_fetch_array($sql10111);

$lastmonthdues = ($row1111011['lastmonthbill']+$row11110invoss['invo_bill']) - $row10111111['lastmonthcollection'];

$sql110rr = mysql_query("SELECT IFNULL(SUM(pay_amount),'0') AS repay_amount FROM payment_macreseller WHERE MONTH(pay_date) = MONTH('$dateTime') AND YEAR(pay_date) = YEAR('$dateTime') AND sts = '0'");
$row11110rr = mysql_fetch_array($sql110rr);

$sql10 = mysql_query("SELECT (SUM(pay_amount) + SUM(bill_discount)) AS totalmonthcollection FROM payment WHERE MONTH(pay_date) = MONTH('$dateTime') AND YEAR(pay_date) = YEAR('$dateTime')");
$row10 = mysql_fetch_array($sql10);

$Totalbills = $row9['payablebill'] + $row10['totalmonthcollection'];

$sqlreseller = mysql_query("SELECT q.z_name, q.z_id AS zid, IFNULL(q.e_name,'') AS resellerz, q.totaloff, IFNULL(w.totalon,0) AS totalon from 
							(SELECT z.z_name, c.z_id, e.e_name, COUNT(l.c_id) AS totaloff FROM con_sts_log AS l
							LEFT JOIN clients AS c ON c.c_id = l.c_id
							LEFT JOIN emp_info AS e ON e.z_id = c.z_id
							LEFT JOIN zone AS z ON z.z_id = c.z_id
							WHERE MONTH(l.update_date) = MONTH('$sts_month') AND YEAR(l.update_date) = YEAR('$sts_month') AND l.update_by = 'Auto' AND c.sts = '0' GROUP BY c.z_id)q
							LEFT JOIN
							(SELECT c.z_id, COUNT(l.c_id) AS totalon FROM con_sts_log AS l 
							LEFT JOIN clients AS c ON c.c_id = l.c_id
							WHERE l.update_by = 'Auto' AND l.con_sts = 'Inactive' AND MONTH(l.update_date) = MONTH('$sts_month') AND YEAR(l.update_date) = YEAR('$sts_month') AND c.con_sts = 'Active' AND c.sts = '0' GROUP BY c.z_id )w
							on q.z_id = w.z_id ORDER BY q.totaloff DESC");

$sql11 = mysql_query("SELECT IFNULL(SUM(amount),'0') AS thismonthsignupfee FROM bill_signup WHERE bill_type = '5' AND MONTH(pay_date) = MONTH('$dateTime') AND YEAR(pay_date) = YEAR('$dateTime')");
$row11 = mysql_fetch_array($sql11);


$queryddgaddd = mysql_query("SELECT b.z_id, z.z_name,CONCAT(z.z_name,' - ',e.e_name) AS itemm, e.e_name, sum(b.bill_amount) AS tottt FROM billing_mac AS b
					LEFT JOIN zone AS z ON z.z_id = b.z_id
					LEFT JOIN emp_info AS e ON e.e_id = z.e_id
					WHERE MONTH(b.entry_date) = MONTH('$bill_monthhh') AND YEAR(b.entry_date) = YEAR('$bill_monthhh') AND b.bill_amount != '0.00' AND b.sts = '0' GROUP BY b.z_id");
		$tnameeee = 'Mac Reseller Expense';
		
$myurl133[]="['Reseller','Expense']";
while($qqqq=mysql_fetch_assoc($queryddgaddd)){
	
	$Itemm = $qqqq['itemm'];
	$Totall = $qqqq['tottt'];
	$myurl133[]="['".$Itemm."',".$Totall."]";
}



$inactive = $row1['TotalClients'] - $row2['TotalActive'];

if($userr_typ == 'mreseller'){
	$queryddga = mysql_query("SELECT l.b_name AS item, (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) AS tot  FROM
									(
									SELECT z.box_id, z.b_name, SUM(b.bill_amount) AS TotalBill, SUM(b.discount) AS TotalDiscount FROM billing_mac_client AS b 
									LEFT JOIN clients AS c ON c.c_id = b.c_id 
									LEFT JOIN box AS z ON z.box_id = c.box_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
									WHERE MONTH(b.bill_date) =  MONTH('$bill_month') AND YEAR(b.bill_date) = YEAR('$bill_month') AND c.z_id = '$macz_id'
									GROUP BY c.box_id
									)l
									LEFT JOIN
									(
									SELECT z.box_id, z.b_name, SUM(p.pay_amount) AS TotalBills, SUM(p.bill_discount) AS TotalDiscount1 FROM payment_mac_client AS p 
									LEFT JOIN clients AS c ON c.c_id = p.c_id 
									LEFT JOIN box AS z ON z.box_id = c.box_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
									WHERE MONTH(p.pay_date) =  MONTH('$bill_month') AND YEAR(p.pay_date) = YEAR('$bill_month') AND c.z_id = '$macz_id'
									GROUP BY c.box_id
									)t
									ON l.box_id = t.box_id WHERE (IFNULL(l.TotalBill, 0.00) - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) >= '0' ORDER BY (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) DESC");
			$tnamee = 'Due Bill Summary';
			
	$myurl1[]="['Zone','Total']";
	while($q=mysql_fetch_assoc($queryddga)){
		
		$Item = $q['item'];
		$Total = $q['tot'];
		$myurl1[]="['".$Item."',".$Total."]";
	}
	
	
	$sql = mysql_query("SELECT DATE_FORMAT(c.join_date,'%d-%b') AS dat, COUNT(c.c_id) AS total FROM clients AS c
	WHERE c.join_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND c.sts = '0' AND c.z_id = '$macz_id' AND c.mac_user = '1'
	GROUP BY c.join_date");
	
	$sqlcount = mysql_num_rows($sql);
	$myurl[]="['Date','Total']";
	while($r=mysql_fetch_assoc($sql)){
		
		$Item = $r['dat'];
		$Total = $r['total'];
		$myurl[]="['".$Item."',".$Total."]";
	}

	$sql2 = mysql_query("SELECT DATE_FORMAT(p.pay_date,'%d-%b') AS dat2, sum(p.pay_amount) AS total2 FROM payment_mac_client AS p
	LEFT JOIN clients AS c ON c.c_id = p.c_id
	WHERE c.z_id = '$macz_id' AND p.pay_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND p.sts = '0' GROUP BY p.pay_date");

	$sql2count = mysql_num_rows($sql2);
	$myurl2[]="['Date','Total']";
	while($r2=mysql_fetch_assoc($sql2)){
		
		$Item2 = $r2['dat2'];
		$Total2 = $r2['total2'];
		$myurl2[]="['".$Item2."',".$Total2."]";
	}

	$sql3 = mysql_query("SELECT DATE_FORMAT(l.update_date,'%d-%b') AS dat3, COUNT(l.c_id) AS total3 FROM con_sts_log AS l LEFT JOIN clients AS c ON c.c_id = l.c_id
	WHERE l.update_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND l.update_by = 'Auto' AND c.z_id = '$macz_id' GROUP BY l.update_date");
	
	$sql3count = mysql_num_rows($sql3);
	$myurl3[]="['Date','Total']";
	while($r3=mysql_fetch_assoc($sql3)){
		
		$Item3 = $r3['dat3'];
		$Total3 = $r3['total3'];
		$myurl3[]="['".$Item3."',".$Total3."]";
	}

	$sql30 = mysql_query("SELECT DATE_FORMAT(b.entry_date,'%d-%b') AS dat2ss, IFNULL(SUM(b.bill_amount),0.00) AS paydiscounts, sum(b.days) AS totaldays FROM billing_mac AS b
LEFT JOIN clients AS c ON c.c_id = b.c_id
WHERE b.entry_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 62 DAY ) ) AND DATE ( NOW() ) AND c.mac_user = '1' AND b.z_id = '$macz_id' GROUP BY MONTH(b.entry_date), YEAR(b.entry_date), DATE(b.entry_date)");

	$sql30count = mysql_num_rows($sql30);
	$myurl30[]="['Date','Expense']";
	while($r30=mysql_fetch_assoc($sql30)){
		
		$paydate = $r30['dat2ss'];
		$collections = $r30['totaldays'];
		$discountss = $r30['paydiscounts'];
		$myurl30[]="['".$paydate."',".$discountss."]";
	}
$grptitel = '..::Expense [30 Days]::..';
}

else{

$queryddga = mysql_query("SELECT CONCAT(l.z_name,' - ',l.z_bn_name) AS item, (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) AS tot  FROM
								(
								SELECT z.z_id, z.z_name, z.z_bn_name, SUM(b.bill_amount) AS TotalBill, SUM(b.discount) AS TotalDiscount FROM billing AS b 
								LEFT JOIN clients AS c ON c.c_id = b.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
								WHERE MONTH(b.bill_date) =  MONTH('$bill_month') AND YEAR(b.bill_date) = YEAR('$bill_month')
								GROUP BY c.z_id
								)l
								LEFT JOIN
								(
								SELECT z.z_id, z.z_name, SUM(p.pay_amount) AS TotalBills, SUM(p.bill_discount) AS TotalDiscount1 FROM payment AS p 
								LEFT JOIN clients AS c ON c.c_id = p.c_id 
								LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN mk_con AS m ON m.id = c.mk_id
								WHERE MONTH(p.pay_date) =  MONTH('$bill_month') AND YEAR(p.pay_date) = YEAR('$bill_month')
								GROUP BY c.z_id
								)t
								ON l.z_id = t.z_id WHERE (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) >= '0' ORDER BY (l.TotalBill - IFNULL((t.TotalBills + t.TotalDiscount1), 0.00)) DESC");
		$tnamee = 'Due Bill Summary';
		
$myurl1[]="['Zone','Total']";
while($q=mysql_fetch_assoc($queryddga)){
	
	$Item = $q['item'];
	$Total = $q['tot'];
	$myurl1[]="['".$Item."',".$Total."]";
}
	
if(in_array(219, $access_arry)){
	$sql = mysql_query("SELECT DATE_FORMAT(c.join_date,'%d-%b') AS dat, COUNT(c.c_id) AS total FROM clients AS c
WHERE c.join_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND c.sts = '0' GROUP BY c.join_date");

$sqlcount = mysql_num_rows($sql);
$myurl[]="['Date','Total']";
while($r=mysql_fetch_assoc($sql)){
	
	$Item = $r['dat'];
	$Total = $r['total'];
	$myurl[]="['".$Item."',".$Total."]";
}
}

if(in_array(220, $access_arry)){
$sql2 = mysql_query("SELECT DATE_FORMAT(pay_date,'%d-%b') AS dat2, sum(pay_amount) AS total2 FROM payment
WHERE pay_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND sts = '0' GROUP BY pay_date");

$sql2count = mysql_num_rows($sql2);
$myurl2[]="['Date','Total']";
while($r2=mysql_fetch_assoc($sql2)){
	
	$Item2 = $r2['dat2'];
	$Total2 = $r2['total2'];
	$myurl2[]="['".$Item2."',".$Total2."]";
}
}

if(in_array(221, $access_arry)){
$sql3 = mysql_query("SELECT DATE_FORMAT(update_date,'%d-%b') AS dat3, COUNT(c_id) AS total3 FROM con_sts_log
WHERE update_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 30 DAY ) ) AND DATE ( NOW() ) AND update_by = 'Auto' GROUP BY update_date");

$sql3count = mysql_num_rows($sql3);

$myurl3[]="['Date','Total']";
while($r3=mysql_fetch_assoc($sql3)){
	
	$Item3 = $r3['dat3'];
	$Total3 = $r3['total3'];
	$myurl3[]="['".$Item3."',".$Total3."]";
}
}

if(in_array(222, $access_arry)){
$sql30 = mysql_query("SELECT DATE_FORMAT(pay_date,'%d-%b') AS dat2ss, IFNULL(SUM(pay_amount),0.00) AS payamountss, IFNULL(SUM(bill_discount),0.00) AS paydiscounts FROM payment 
WHERE pay_date BETWEEN DATE( DATE_SUB( NOW() , INTERVAL 182 DAY ) ) AND DATE ( NOW() ) GROUP BY pay_date");

$sql30count = mysql_num_rows($sql30);
$myurl30[]="['Date','Collection','Discount']";
while($r30=mysql_fetch_assoc($sql30)){
	
	$paydate = $r30['dat2ss'];
	$collections = $r30['payamountss'];
	$discountss = $r30['paydiscounts'];
	$myurl30[]="['".$paydate."',".$collections.",".$discountss."]";
}
$grptitel = '..::Collection Vs Discount [180 Days]::..';
}

if(in_array(257, $access_arry)){
$sql3333 = mysql_query("SELECT id, MAX(total_active) AS total_active, DATE_FORMAT(date_time, '%d-%b, %H:%i') AS datetime FROM mk_active_count WHERE date_time >= DATE_SUB(NOW(), INTERVAL 3 DAY) GROUP BY YEAR(date_time), MONTH(date_time), DAY(date_time), HOUR(date_time), MINUTE(date_time) DIV 10 ORDER BY datetime ASC");

//$sql3333count = mysql_num_rows($sql3333);
$myurl333[]="['Date','Total Online']";
//while($r3dd=mysql_fetch_assoc($sql3333)){
	
//	$datetime = $r3dd['datetime'];
//	$totaactive = $r3dd['total_active'];
//	$myurl333[]="['".$datetime."',".$totaactive."]";
//}
}
}
if(in_array(257, $access_arry) || in_array(222, $access_arry) || in_array(221, $access_arry) || in_array(220, $access_arry) || in_array(219, $access_arry)){
?>
<!-- -------------------------------------------------------------------------------------------------- -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl333));?>
        ]);

        var options = {
		title: '..:: Online Clients Count (Last 3 Days)::..',
		  chartArea:{left:'3%',right:'1%','backgroundColor':'#fff'},
		  height: 150,
		  fontSize: 11,
          curveType: 'function',
		  colors: ['#e9573f'],
          legend: { position: 'none' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div3aa'));
        chart.draw(data, options);
      }
    </script>
	<script type="text/javascript">
		google.charts.load('current', {packages: ['corechart', 'bar']});
		google.charts.setOnLoadCallback(drawBasic);
		 function drawBasic() {
			
			var data = new google.visualization.arrayToDataTable([
				<?php echo(implode(",",$myurl));?>
			]);
					
			var options = {
				title: "Last 30 Days New Clients",
				height: 250,
//				Width: 300,
//				vAxis: {title: 'New Clients'},
//				hAxis: {title: 'New Clients in Last 30 days'},
				bar: {groupWidth: "85%"},
				fontSize: 9,
				legend: { position: "none" },
				chartArea: {left:'5%',right:'1%','backgroundColor':'#fff'},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				colors: ['#1b9e77']
			  };				

			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		  }
    </script>
	
	<script type="text/javascript">
		google.charts.load('current', {packages: ['corechart', 'bar']});
		google.charts.setOnLoadCallback(drawBasic);
		 function drawBasic() {
			var data = new google.visualization.arrayToDataTable([
				<?php echo(implode(",",$myurl2));?>
			]);
		
			var options = {
				title: "Last 30 Days Bill Collection",
//				Width: 300,
				height: 250,
//				vAxis: {title: 'Bill Collection'},
//				hAxis: {title: 'Bill Collection in Last 30 days'},
				bar: {groupWidth: "75%"},
				fontSize: 9,
				legend: { position: "none" },
				chartArea: {left:'7%',right:'1%','backgroundColor':'#fff'},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				colors: ['#4a89dc']
			  };				

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
			chart.draw(data, options);
		  }
    </script>
	<script type="text/javascript">
		google.charts.load('current', {packages: ['corechart', 'bar']});
		google.charts.setOnLoadCallback(drawBasic);
		 function drawBasic() {
			var data = new google.visualization.arrayToDataTable([
				<?php echo(implode(",",$myurl3));?>
			]);
		
			var options = {
				title: "Last 30 Days Auto Inactive Clients",
//				Width: 300,
				height: 250,
//				vAxis: {title: 'Inactive by Auto'},
//				hAxis: {title: 'Inactive in Last 30 days'},
				bar: {groupWidth: "85%"},
				fontSize: 9,
				legend: { position: "none" },
				chartArea: {left:'5%',right:'1%','backgroundColor':'#fff'},
				bars: 'vertical',
				vAxis: {format: 'decimal'},
				colors: ['#e9573f']
			  };				

			var chart = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
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
			var options = {'title':'',
							chartArea:{left:'2%',top:'1%',width:'96%',height:'96%'},
							Width: 300,
							height: 447,
							is3D:true,
							pieHole: 0.4,
							'allowHtml': true};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
			chart.draw(data, options);
		  }
    </script>
	<script type="text/javascript">
		  google.load('visualization', '1.0', {'packages':['corechart']});
		  google.setOnLoadCallback(drawChart);
		  
		  function drawChart() {
			var data = new google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl133));?>
		]);

			// Set chart options
			var options = {'title':'',
							chartArea:{left:'2%',top:'1%',right:'1%',width:'96%',height:'96%'},
							Width: 350,
							height: 405,
							is3D:true,
							pieHole: 0.4,
							'allowHtml': true};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div1333'));
			chart.draw(data, options);
		  }
    </script>

	<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl30));?>
        ]);

        var options = {
		  title: '<?php echo $grptitel;?>',
		  chartArea:{left:'3%',right:'1%',width:'98%'},
		  height: 200,
//		  Width: '150%',
		  fontSize: 9,
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div38'));
        chart.draw(data, options);
      }
    </script>
<!-- -------------------------------------------------------------------------------------------------- -->
<?php } if($user_type == 'client' || $user_type == 'breseller'){
	
include("mk_api.php");

$ids = $_SESSION['SESS_EMP_ID'];
$sql3600 = mysql_query("SELECT b.pay_date, t.type, b.amount, b.bill_dsc, e.e_name AS othremp FROM bill_signup AS b
						LEFT JOIN bills_type AS t ON t.bill_type = b.bill_type
						LEFT JOIN emp_info AS e ON e.e_id = b.ent_by
						WHERE b.c_id = '$ids' ORDER BY b.pay_date DESC");

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


$sql34 = mysql_query("SELECT s.id, s.c_id, c.c_name, s.con_sts, s.update_date, s.update_time, s.update_date_time FROM con_sts_log AS s
					LEFT JOIN clients AS c
					ON c.c_id = s.c_id

					WHERE s.c_id = '$ids' ORDER BY s.id DESC");
					
										
$result55 = mysql_query("SELECT c_id, c_name, cell, address FROM clients WHERE c_id = '$ids'");
$row55 = mysql_fetch_array($result55);	

$sql1 = mysql_query("SELECT pay_date, pay_amount, bill_discount FROM payment WHERE c_id = '$ids' ORDER BY pay_date");



$query = mysql_query("SELECT c.id, c.com_id, c.c_id, c.father_name, c.breseller, DATE_FORMAT(c.termination_date, '%D %M %Y') AS termination_date, c.total_price, c.mk_id, c.ip, c.connectivity_type, c.flat_no, c.onu_mac, c.house_no, c.road_no, c.thana, c.payment_deadline, e.e_name AS billman, w.e_name AS technician, c.b_date, b.b_name, c.mac_user, l.log_sts, l.image, l.nid_fond, l.nid_back, l.pw, c.c_name, c.z_id, z.z_name, z.z_bn_name, p.mk_profile, p.p_name, p.bandwith, p.p_price, p.p_price_reseller, c.cell, c.cell1, c.cell2, c.cell3, c.cell4, c.email, c.address,
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
$mac_user = $row['mac_user'];
if($mac_user == '1'){
	$p_price = $row['p_price_reseller'];
}
else{
	$p_price = $row['p_price'];
}
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
$image = $row['image'];
$nid_fond = $row['nid_fond'];
$nid_back = $row['nid_back'];
$payment_deadline = $row['payment_deadline'];
$b_date = $row['b_date'];
$passid = $row['pw'];
$mk_profile = $row['mk_profile'];
$sts = $row['sts'];
$breseller = $row['breseller'];
$total_price = $row['total_price'];
$termination_date = $row['termination_date'];


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
		if($mac_user == '0'){
		$sql = mysql_query("SELECT DATE_FORMAT(a.bill_date, '%D %M %Y') AS dateee, a.p_name, a.p_price, a.raw_download, a.raw_upload, a.total_price, a.p_discount, a.bill_amount, a.extra_bill, a.discount, a.payment, a.moneyreceiptno, a.trxid, a.pay_mode, a.pay_idd, a.entrybyname FROM
					(SELECT b.c_id, b.bill_date, p.p_name, p.p_price, c.raw_download, c.raw_upload, c.total_price, b.bill_amount, b.extra_bill AS extra_bill, b.discount AS p_discount, '' AS discount, '' AS Payment, '' AS moneyreceiptno, '' AS trxid, '' AS pay_mode, '#' AS pay_idd, '' AS entrybyname, b.bill_date_time AS pay_date_time
										FROM billing AS b
										LEFT JOIN package AS p ON p.p_id = b.p_id
										LEFT JOIN clients AS c ON c.c_id = b.c_id
										WHERE b.bill_amount != '0' AND b.c_id = '$ids'
						UNION
							SELECT p.c_id, p.pay_date AS bill_date, '', '', '', '', '', '', '', '', SUM(p.bill_discount) AS bill_discount, SUM(p.pay_amount) AS pay_amount, p.moneyreceiptno, p.trxid, p.pay_mode, p.id AS pay_idd, e.e_name as entrybyname, p.pay_date_time FROM payment AS p
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
	$color = 'style="color:red;float: right; padding: 10px 8px 0 0;"';					
} else{
	$color = 'style="color:#000;float: right; padding: 10px 8px 0 0;"';
}

if($con_sts == 'Active'){
	$clss = 'col2';
	$dd = 'Inactive';
	$ee = "<i class='iconfa-play'></i>";
}
if($con_sts == 'Inactive'){
	$clss = 'col3';
	$dd = 'Active';
	$ee = "<i class='iconfa-pause'></i>";
}

if($log_sts == '0'){
	$aa = 'btn col2';
	$bb = "<i class='iconfa-unlock'></i>";
	$cc = 'Lock';
}
if($log_sts == '1'){
	$aa = 'btn col3';
	$bb = "<i class='iconfa-lock pad4'></i>";
	$cc = 'Unlock';
}

$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h, online_sts FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk1 = mysql_fetch_assoc($sqlmk1);
		
		$ServerIP = $rowmk1['ServerIP'];
		$Username = $rowmk1['Username'];
		$Pass= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
		$Port = $rowmk1['Port'];
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
		$macccc = "<form action='#' method='post' title='{$title}' enctype='multipart/form-data'>
						<input type='hidden' name='bind' value='{$bindmac}'/> 
						<input type='hidden' name='mk_id' value='{$mk_id}'/> 
						<input type='hidden' name='mkc_id' value='{$c_id}'/> 
						<input type='hidden' name='wayyy' value='clientview'/>
						<input type='hidden' name='mkmac' value='{$pppmac}'/>
						<input type='hidden' name='c_id' value='{$c_id}'/>
					</form>"; 
		}
		elseif($pppoe_mac != '' && $ppp_mac == ''){
			$macccc = "<form action='#' method='post' title='{$title}' enctype='multipart/form-data'>
						<input type='hidden' name='bind' value='{$bindmac}'/> 
						<input type='hidden' name='mk_id' value='{$mk_id}'/> 
						<input type='hidden' name='mkc_id' value='{$c_id}'/> 
						<input type='hidden' name='wayyy' value='clientview'/>
						<input type='hidden' name='mkmac' value='{$pppmac}'/>
						<input type='hidden' name='c_id' value='{$c_id}'/>
					</form>"; 
		}
		elseif($pppoe_mac == '' && $ppp_mac != ''){
			$macccc = "<form action='#' method='post' title='{$title}' enctype='multipart/form-data'>
						<input type='hidden' name='bind' value='{$bindmac}'/> 
						<input type='hidden' name='mk_id' value='{$mk_id}'/> 
						<input type='hidden' name='mkc_id' value='{$c_id}'/> 
						<input type='hidden' name='wayyy' value='clientview'/>
						<input type='hidden' name='mkmac' value='{$pppmac}'/>
						<input type='hidden' name='c_id' value='{$c_id}'/>
					</form>"; 
		}
		else{
			$macccc = "";
		}
	}
	else{
		
		$breseller_ip = $row['ip'];
		
		$API->write('/ip/arp/getall', false);
		$API->write('?address='.$breseller_ip);
		$res=$API->read(true);
		$API->disconnect();
		
		$ppp_mac = $res[0]['mac-address'];
		$macccc = "";
	}
	}
else{
	echo 'Selected Network are not Connected';
	$query12312rr ="update mk_con set online_sts = '1' WHERE id = '$maikro_id'";
	$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error());
}
}
else{}
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
		   docprint.document.write('<head><title>Business Network</title>');
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
<?php if($ppp_ip != '' && $online_stsssss == '0' || $breseller_ip != '' && $online_stsssss == '0'){?>
<script>
 $(document).ready(function() {
 	 $("#responsecontainer_tx").load("Client_Tx_Rx.php?mk_id=<?php echo $mk_id;?>&c_id=<?php echo $c_id;?>");
   var refreshId = setInterval(function() {
      $("#responsecontainer_tx").load('Client_Tx_Rx.php?mk_id=<?php echo $mk_id;?>&c_id=<?php echo $c_id;?>');
   }, 5000);
   $.ajaxSetup({ cache: false });
});
</script>
<?php } ?>
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
<!-- ------------------------------------------------------------------------------------------------------------------------------------- -->
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
	<div class="pageheader">
        <div class="searchbar" style="top: 22%;right: 30px;">
			<?php if($Dew > '2'){if(in_array(1, $online_getway)){?>
				<a href="PaymentOnline?gateway=bKash"><img src="imgs/bk_rbttn.png" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
			<?php } if(in_array(6, $online_getway)){?>
				<a href="PaymentOnline?gateway=bKashT"><img src="imgs/bk_rbttn.png" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
			<?php } if(in_array(4, $online_getway)){?>
				<a href="PaymentOnline?gateway=Rocket"><img src="imgs/rocket_s.png" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
			<?php } if(in_array(5, $online_getway)){?>
				<a href="PaymentOnline?gateway=Nagad"><img src="imgs/nagad_s.png" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
			<?php } if(in_array(2, $online_getway)){?>
				<a href="PaymentOnline?gateway=iPay"><img src="imgs/ip_rbttn.png" style="width: 40px;padding: 0px;margin-top: -3px;"></a>
			<?php } if(in_array(3, $online_getway)){?>
				<a href="PaymentOnline?gateway=SSLCommerz"><img src="imgs/ssl.png" style="width: 40px;padding: 0px;margin-top: -3px;border-radius: 10px;"></a>
			<?php }} ?>
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
								<div class="yui-u first" style="width: 38%;">
									<h1><?php echo $c_name; ?></h1> 
									<h2><?php echo $c_id; ?></h2>
									<h2><?php echo $z_name.' ('.$z_bn_name.')';?></h2>
									<h2><?php echo 'Since  '.$join; ?></h2>
									<a><?php echo $cell; ?></a>
									<h3><?php echo $email; ?></h3>
									
								</div>
								<?php if($image != ''){?>
								<div class="yui-u" style="width: 12%;">
									<div class="contact-info userloggedinfo1">
										<a href="<?php echo $image;?>" target='_blank' /><img src="<?php echo $image;?>" style="width: 93px;height: 98px;" /></a>							
									</div><!--// .contact-info -->
								</div>
								<?php } if($nid_back != ''){?>
								<div class="yui-u" style="width: 17%;">
									<div class="contact-info userloggedinfo1">
										<a href="<?php echo $nid_back;?>" target='_blank' /><img src="<?php echo $nid_back; ?>" style="width: 180px;height: 100px;padding: 3px;" /></a>	
									</div><!--// .contact-info -->
								</div>
								<?php } if($nid_fond != ''){?>
								<div class="yui-u" style="width: 17%;">
									<div class="contact-info userloggedinfo1">
										<a href="<?php echo $nid_fond;?>" target='_blank' /><img src="<?php echo $nid_fond; ?>" style="width: 180px;height: 100px;padding: 3px;"/></a>									
									</div><!--// .contact-info -->
								</div>
								<?php } ?>
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
											<td style="color: green;font-weight: bold;">ONLINE</td>
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
							</div><br>
							<?php } ?>
							<?php if($ppp_mac != ''){?>
							<?php } else{ }?>
						</div><!--// hd -->
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
											 <?php if($mac_user == '1'){ ?>
											<tr>
												<td style="font-weight: bold;height: 25px;">Termination Date</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $termination_date;?></td>
												<td></td>
												<td style="font-weight: bold;height: 25px;"></td>
												<td style="font-weight: bold;"></td>
												<td style="padding: 0 0px 0px 10px;"></td>
											  </tr>
											 <?php } else{ ?>
											 <tr>
												<td style="font-weight: bold;height: 25px;">P.Deadline</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $payment_deadline;?></td>
												<td></td>
												<td style="font-weight: bold;height: 25px;">B.Deadline</td>
												<td style="font-weight: bold;">:</td>
												<td style="padding: 0 0px 0px 10px;"><?php echo $b_date;?></td>
											  </tr>
											  <?php } ?>
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
														<th style="padding: 0 0px 0px 10px;width: 45%"><?php echo $cell; ?> </th>
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
<?php if($breseller == '2'){?>
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
										if($rown['pay_idd'] == '#'){
											$invoprint = "<li><form action='fpdf/BillPrintInvoiceClient' title='Print Invoice' method='post' target='_blank'><input type='hidden' name='invoice_id' value='{$rown['invoice_id']}'/><button class='btn ownbtn6' style='padding: 6px 9px;'><i class='iconfa-print'></i></button></form></li>";
										}
										else{
											$invoprint = "";
										} 
									echo
										"<tr class='gradeX'>
											<td>{$rown['dateee']}</td>
											<td class='center'><a href='#' style='font-size: 15px;font-weight: bold;'>{$rown['invoice_id']}</a></td>
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
									if($breseller == '0'){
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
									if($breseller == '0'){
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
									echo
										"<tr class='gradeX'>
											<td>{$rown['dateee']}</td>
											<td>{$packageeee}</td>
											<td>{$packprice}</td>
											<td>{$rown['p_discount']}</td>
											<td>{$rown['extra_bill']}</td>
											<td>{$rown['bill_amount']}</td>
											<td>{$rown['discount']}</td>
											<td>{$rown['payment']}</td>
											<td>{$rown['pay_mode']}</td>
											<td>{$rown['moneyreceiptno']}{$row['sender_no']}<br>{$rown['trxid']}</td>
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
							<?php } ?>
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
						
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">S/L</th>
							<th class="head1">Date</th>
							<th class="head0">Bill Type</th>
							<th class="head1">Description</th>
							<th class="head0">Entry By</th>
							<th class="head1">Amount (TK)</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $rowwq00 = mysql_fetch_assoc($sql3600) )
								{
									$yrdataa= strtotime($rowwq00['pay_date']);
									$monthh = date('d F, Y', $yrdataa);
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$monthh}</td>
											<td>{$rowwq00['type']}</td>
											<td>{$rowwq00['bill_dsc']}</td>
											<td>{$rowwq00['othremp']}</td>
											<td>{$rowwq00['amount']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
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
							
							if($mac_user == '1'){
								$oldpackprice = $rowwq['oldpackprice'];
								$newpackprice = $rowwq['newpackprice'];
							}
							else{
								$oldpackprice = $rowwq['old_price'];
								$newpackprice = $rowwq['nw_price'];
							}
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$rowwq['old_package']} [{$oldpackprice}TK]</td>
											<td>{$rowwq['nw_package']} [{$newpackprice}TK]</td>
											<td>{$rowwq['up_date']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
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
													<li><a data-placement='top' data-rel='tooltip' href='SupportMassage?id={$rowws['ticket_no']}' data-original-title='View' target='_blank' class='btn col1'><i class='iconfa-eye-open'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
			<div id="hd">
				<table style="width:100%;background: #eeeeee;font-size: 14px;height: 30px;">
					<tr>
						<th style="text-align:left"><b>Active/Inactive History</b></th>
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
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $roww = mysql_fetch_assoc($sql34) )
								{
									$yrata= strtotime($roww['update_date']);
									$date_mon = date('d F, Y', $yrata);
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$date_mon}</td>
											<td>{$roww['update_time']}</td>
											<td>{$roww['con_sts']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>
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
			<button class="btn ownbtn2" type="button" name="btnprint" value="Print" onclick="PrintMe('divid')">Print</button>
		</div>
	</div>
<?php } ?>
<?php if(!in_array(223, $access_arry)){ ?>	
	<div class="row-fluid" style="padding: 0;">
		<div style="width: 100% !important;overflow: hidden;">
			<?php if($sql2count > '0' && in_array(220, $access_arry)){ ?><div id="chart_div2" class="span5" style="text-align: center; height: 250px;border: 1px solid #ccc;float: left;margin: 5px 0 0 3px;"></div><?php }?>
			<?php if($sqlcount > '0' && in_array(219, $access_arry)){ ?><div id="chart_div" class="span3" style="text-align: center; height: 250px; border: 1px solid #ccc;float: left;margin: 5px 0 0 3px;"></div><?php }?>
			<?php if($sql3count > '0' && in_array(221, $access_arry)){ ?><div id="chart_div3" class="span4" style="text-align: center; height: 250px; border: 1px solid #ccc;float: left;margin: 5px 0 0 3px;width: 35.7%;"></div><?php }?>
			

		</div>
    </div>
    
    
    <!---------------------------pageheader-->

	<div style="height: 45px;">
	<?php if(in_array(110, $access_arry)){ ?>	
	
		<?php } ?>
	<div style="margin-top: 10px;">
		<div style="width: 13%;min-height:1px; padding-left:7px; padding-right:7px; position:relative; float:left;"> 
			<a href='Clients?id=new'>
			<div style="border: 5px solid #05A7B4;background: #05A7B4 none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
				<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size:22px; height:52px; line-height: 67px;text-align: center;width:40px; color: #fff !important;background-color: #05A7B4 !important;"> <i class="faa iconfa-user" style="margin-top: 16px;"></i>
				</span>
				<div style="margin-left: 35px;padding: 5px 10px;">
					<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">New Clients</span>
					<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo $row12['TotalNewClients']; ?></span>
				</div>
			</div>
			</a>
		</div>
	</div>
	
	

	<div style="margin-top: 10px;">
		<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
			<a href='Clients'>
			<div style="border: 5px solid #00c0ef;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
				<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #00c0ef !important;">
					<i class="faa iconfa-group" style="margin-top: 16px;"></i>
				</span>
				<div style="margin-left: 35px;padding: 5px 10px;">
					<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Total Clients</span>
					<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo $row1['TotalClients']; ?></span>
				</div>
			</div>
			</a>
		</div>
	</div>
	

	
	
	
	
	<?php if(in_array(112, $access_arry)){ ?>	
	<div style="margin-top: 10px;">
		<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
			<a href='Clients?id=active'>
			<div style="border: 5px solid #00A65A;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
				<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #00a65a !important;">
					<i class="faa iconfa-ok" style="margin-top: 16px;"></i>
				</span>
				<div style="margin-left: 35px;padding: 5px 10px;">
					<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Active Clients</span>
					<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo $row2['TotalActive']; ?></span>
				</div>
			</div>
			</a>
		</div>
	</div>
	
	
	<?php } if(in_array(113, $access_arry)){ ?>
	<div style="margin-top: 10px;">
		<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
			<a href='Clients?id=inactive'>
			<div style="border: 5px solid #000;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
				<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #000 !important;">
					<i class="iconfa-warning-sign" style="margin-top: 16px;"></i>
				</span>
				<div style="margin-left: 35px;padding: 5px 10px;">
					<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Inactive Clients</span>
					<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo $inactive; ?></span>
				</div>
			</div>
			</a>
		</div>
	</div>
	

<?php } if(in_array(224, $access_arry)){ ?>
		<div style="margin-top: 10px;">
		<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
			<a href='Support?id=pending'>
			<div style="border: 5px solid #982a2acc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
				<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #982a2acc !important;">
					<i class="faa iconfa-comments-alt" style="margin-top: 16px;"></i>
				</span>
				<div style="margin-left: 35px;padding: 5px 10px;">
					<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Open Ticket</span>
					<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo $row4['totalopen']; ?></span>
				</div>
			</div>
			</a>
		</div>
	</div>
<?php } if(in_array(225, $access_arry)){ ?>
	<div style="margin-top: 10px;">
		<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
			<a href='Expanse'>
			<div style="border: 5px solid #4454ab;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
				<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #4454ab !important;">
					<i class="faa iconfa-signout" style="margin-top: 16px;"></i>
				</span>
				<div style="margin-left: 35px;padding: 5px 10px;">
					<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;"><?php echo $thismonthword; ?> Expense</span>
					<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row50000['totalexpance'], 2);?></span>
				</div>
			</div>
			</a>
		</div>
	</div>
	<?php } if(in_array(226, $access_arry)){ ?>
	<div style="margin-top: 10px;">
		<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
			<a href='<?php if($user_type == 'mreseller'){ ?>#<?php } else{?>Clients?id=auto<?php } ?>'>
			<div style="border: 5px solid #ec1f27;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
				<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #ec1f27 !important;">
					<i class="faa iconfa-remove" style="margin-top: 16px;"></i>
				</span>
				<div style="margin-left: 35px;padding: 5px 10px;">
					<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Auto Inactive</span>
					<span style="display: block;font-size: 15px;font-weight: bold;"><?php if($user_type == 'mreseller'){echo $row7sds['todayautodisable'];} else{echo $row7['todayautodisable'];}?></span>
				</div>
			</div>
			</a>
		</div>
	</div>
	</div>
	<?php } if($user_type == 'mreseller'){ ?>	
	<br>
			<div style="height: 45px;">
				<?php if($billing_typee == 'Prepaid' && $over_due_balance < '0.00'){ ?>	
				<div style="margin-top: 10px;">
					<div style="width: 13%;min-height: 5px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
						<div style="<?php echo $bdcolor; ?>background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
							<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;<?php echo $bcolor; ?>">
								<i class="faa iconfa-warning-sign" style="margin-top: 16px;"></i>
							</span>
							<div style="margin-left: 35px;padding: 5px 10px;">
								<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Max Due Limit</span>
								<span style="display: block;font-size: 12px;font-weight: bold;"><?php echo number_format($over_due_balance_main,2);?> TK</span>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>	
				<div style="margin-top: 10px;">
					<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
						<div style="<?php echo $bdcolor; ?>background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 5px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
							<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;<?php echo $bcolor; ?>">
								<i class="faa iconfa-credit-card" style="margin-top: 16px;"></i>
							</span>
							<div style="margin-left: 35px;padding: 5px 10px;">
								<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Balance</span>
								<span style="display: block;font-size: 12px;font-weight: bold;<?php echo $color; ?>"><?php echo number_format($aaaa,2);?> TK</span>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php } ?>	
	
	
	<?php if(in_array(227, $access_arry) || in_array(228, $access_arry) || in_array(229, $access_arry) || in_array(230, $access_arry) || in_array(231, $access_arry) || in_array(232, $access_arry) || in_array(233, $access_arry)){ ?>
	<br/>
	<div style="height: 45px;">
		<?php if(in_array(227, $access_arry)){ ?>	
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<a href='Expanse'>
				<div style="border: 5px solid #4454ab;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #4454ab !important;">
						<i class="faa iconfa-signout" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Today Expense</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row5['totalexpance'], 2);?></span>
					</div>
				</div>
				</a>
			</div>
		</div>
		<?php } if(in_array(228, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<a href='SignupBill'>
				<div style="border: 5px solid #0866c6cc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #0866c6cc !important;">
						<i class="faa iconfa-plus" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Today Others</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row8['othersbill'], 2);?></span>
					</div>
				</div>
				</a>
			</div>
		</div>
		<?php } if(in_array(229, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<div style="border: 5px solid #FF00FF;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #FF00FF !important;">
						<i class="faa iconfa-random" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Reseller Collection</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row11110rr['repay_amount'], 2);?></span>
					</div>
				</div>
			</div>
		</div>
		<?php } if(in_array(230, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<div style="border: 5px solid #3d5c99;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #3d5c99 !important;">
						<i class="faa iconfa-random" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Signup Fee</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row11['thismonthsignupfee'], 2);?></span>
					</div>
				</div>
			</div>
		</div>
		<?php } if(in_array(231, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<a href='#'>
				<div style="border: 5px solid #97512e;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #97512e !important;">
						<i class="iconfa-magic" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Paid Discount</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row20['paiddiscount'], 2);?></span>
					</div>
				</div>
				</a>
			</div>
		</div>
		<?php } if(in_array(232, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<a href='Billing?id=pdiscount'>
				<div style="border: 5px solid #8730ff;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #8730ff !important;">
						<i class="iconfa-asterisk" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">P. Discount</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row19['permanentdiscount'], 2);?></span>
					</div>
				</div>
				</a>
			</div>
		</div>
		<?php } if(in_array(233, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<a href='Collection?id=<?php echo $dateTime;?>'>
				<div style="border: 5px solid #1b9e77;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #1b9e77 !important;">
						<i class="faa iconfa-signin" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Today Collection</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row6['todaycollection'], 2); ?></span>
					</div>
				</div>
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
	<br/>
	
<?php } if(in_array(234, $access_arry) || in_array(235, $access_arry) || in_array(236, $access_arry) || in_array(237, $access_arry) || in_array(238, $access_arry) || in_array(239, $access_arry) || in_array(240, $access_arry)){ ?>
	<div style="height: 45px;">
		<?php if(in_array(234, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<div style="border: 5px solid #540b0bcc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #540b0bcc !important;">
						<i class="faa iconfa-money" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Old Dues</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row99999['payablebill'], 2); ?></span>
					</div>
				</div>
			</div>
		</div>
		<?php } if(in_array(235, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<div style="border: 5px solid #FFA500;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #FFA500 !important;">
						<i class="faa iconfa-random" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;"><?php echo $thismonthword; ?> Bill</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php $intotalbill = $row11110['bill'] + $row11110invo['invo_bill']; echo number_format($intotalbill, 2);?></span>
					</div>
				</div>
			</div>
		</div>
		<?php } if(in_array(236, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<a href='Collection'>
				<div style="border: 5px solid #5d1069cc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #5d1069cc !important;">
						<i class="faa iconfa-check" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;"><?php echo $thismonthword; ?> Collection</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row10['totalmonthcollection'], 2);?></span>
					</div>
				</div>
				</a>
			</div>
		</div>
		<?php } if(in_array(237, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">

				<div style="border: 5px solid #846704cc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #846704cc !important;">
						<i class="faa iconfa-remove-sign" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;">Total Dues</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row9['payablebill'], 2);?></span>
					</div>
				</div>
			</div>
		</div>
		<?php } if(in_array(238, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<div style="border: 5px solid #540b0bcc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #540b0bcc !important;">
						<i class="faa iconfa-money" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;"><?php echo $lastmonthword;?> Bill</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format(($row1111011['lastmonthbill']+$row11110invoss['invo_bill']), 2);?></span>
					</div>
				</div>
			</div>
		</div>
		<?php } if(in_array(239, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<div style="border: 5px solid #540b0bcc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #540b0bcc !important;">
						<i class="faa iconfa-money" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;"><?php echo $lastmonthword;?> Collection</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($row10111111['lastmonthcollection'], 2);?></span>
					</div>
				</div>
			</div>
		</div>
	<!------------------------------------->
		<?php } if(in_array(240, $access_arry)){ ?>
		<div style="margin-top: 10px;">
			<div style="width: 13%;min-height: 1px;padding-left: 7px;padding-right: 7px;position: relative;float: left;">
				<div style="border: 5px solid #540b0bcc;background: #fff none repeat scroll 0 0;border-radius: 10px;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);display: block;margin-bottom: 17px;min-height: 52px;width: 100%;">
					<span style="background: rgba(0, 0, 0, 0.2) none repeat scroll 0 0;background-color: rgba(0, 0, 0, 0.2);border-radius: 2px 0 0 2px;display: block;float: left;font-size: 22px;height: 52px;line-height: 67px;text-align: center;width: 40px;color: #fff !important;background-color: #540b0bcc !important;">
						<i class="faa iconfa-money" style="margin-top: 16px;"></i>
					</span>
					<div style="margin-left: 35px;padding: 5px 10px;">
						<span style="display: block;font-size: 12px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;text-transform: uppercase;"><?php echo $lastmonthword;?> Due</span>
						<span style="display: block;font-size: 15px;font-weight: bold;"><?php echo number_format($lastmonthdues, 2);?></span>
					</div>
				</div>
			</div>
		</div>
			<!------------------------------------->
		<?php } ?>
	</div>
	<?php } ?>
		<?php if($sql3333count > '0' && in_array(257, $access_arry)){ ?><div id="chart_div3aa" style="text-align: center; height: 150px; width: 99.2%;border: 2px solid #ccc;float: left;margin: -5px 0px 5px 3px;"></div><?php }?>
	<?php  if($user_type == 'mreseller'){ ?>	
				<br>
				<div id="dashboard-left" class="span8" style="margin-top: 25px;float: none;">
				<div class="tabbedwidget tab-primary">
					<ul style="height: 35px;">
						<li><a href="#tabs-1"><span class="iconfa-user" style="font-size: 19px;margin-top: -5px;width: auto;"></span></a></li>
					</ul>
					<div id="tabs-1" class="nopadding">
						<h5 class="tabtitle">Today's Terminated Clients</h5>
						<ul class="userlist">
						<?php
						$sql33r = mysql_query("SELECT l.c_id, c.c_name, p.p_name, p.p_price FROM con_sts_log AS l LEFT JOIN clients AS c ON c.c_id = l.c_id LEFT JOIN package AS p ON p.p_id = c.p_id WHERE l.update_date = '$y_dateTime' AND l.update_by = 'Auto' AND c.sts = '0' AND c.con_sts = 'Inactive' AND c.mac_user ='1' AND c.z_id = '$macz_id' ORDER BY c.com_id DESC");?>
							<table id="dyntable" class="table table-bordered responsive">
								<thead>
									<tr class="newThead">
										<th class="head1 center" style="padding: 3px 0px 3px 5px;">S/L</th>
										<th class="head0" style="padding: 3px 0px 3px 5px;">ID/ZONE</th>
										<th class="head0" style="padding: 3px 0px 3px 5px;">RESELLER/CELL</th>
										<th class="head1 center" style="padding: 3px 0px 3px 5px;">PROFILE</th>
									</tr>
								</thead>
								<tbody>
								 <?php 
								 $xxxr = 1;
								 while( $row33e = mysql_fetch_assoc($sql33r) ){
									echo
										"<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 14px;'>{$xxxr}</td>
											<td style='padding: 2px 0px 2px 5px;'><a href='#' style='color: #0866c6;font-weight: bold;'>{$row33e['c_id']}</a><br><b>{$row33e['c_name']}</b></td>
											<td style='padding: 2px 0px 2px 5px;'><a href='#' style='color: #0866c6;font-weight: bold;'>{$row33e['p_name']}</a><br><b>{$row33e['p_price']}TK</b></td>
											<td class='center' style='vertical-align: middle;'>
											<form action='ClientsRecharge' method='post' title='Recharge' target='_blank'><input type='hidden' name='c_id' value='{$row33e['c_id']}'><button class='btn ownbtn3' style='padding: 6px 9px;' title='Recharge'><i class='iconfa-globe'></i></button></form></td>\n";
									$xxxr++;
									}
								 ?>
								 
								 </tr>
								</tbody>
							</table>
						</ul>
					</div>
				</div><!--tabbedwidget-->
				</div>
				<div id="dashboard-right" class="span8" style="margin-top: 25px;float: none;">
				<div class="span8 modal-content" style="border: 2px solid #ccc;margin-left: 0;">
					<div class="" style="overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
						<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 10px;font-weight: bold;background: none;float: left;"><?php echo $tnamee;?> [<?php echo $thismonthsearch;?>]</div>
						<form id="form2" class="stdform" style="width: 20%;float: right;" method="post" action="<?php echo $PHP_SELF;?>">
							<select name="bill_month" class="" style="height: 30px;border-bottom: none;border-top: none;border-right: none;" onchange="submit();">
								<option value="<?php echo date("Y-m-01") ?>"><?php echo date("M-Y") ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
							</select>
						</form>
					</div>
						<div class="" style="overflow: hidden;">
							<div id="chart_div1"></div>
						</div><!--widgetcontent-->
				</div>
				</div>
				</div></div><br><br>
	<?php } ?>
			<div class="row-fluid" style="float: left;">
				<?php if(in_array(241, $access_arry) || in_array(244, $access_arry)){ ?>
				<div id="dashboard-left" class="span5" style="margin-left: 3px;">	
				<?php if($client_onlineclient_sts == '1'){?>
					<div class="modal-content" style="border: 2px solid #ccc;margin-bottom: 5px;">
						<div class="" style="overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
							<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #00b500;font-size: 13px;padding: 5px 0px 4px 10px;font-weight: bold;background: none;float: left;">Online Clients [LIVE]</div><div style="float: right;padding: 3px 10px 0px 0px;"><img src="images/loaders/loader17.gif"/></div>
						</div>
							<div class="" style="overflow: hidden;">
								<ul class="sidebarlist">
									<div id='responsecontainer1'></div>
								</ul>
							</div><!--widgetcontent-->
					</div> 
				<?php } ?>
				<?php if(in_array(241, $access_arry)){ ?>
					<div class="modal-content" style="border: 2px solid #ccc;">
						<div class="" style="overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
							<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 10px;font-weight: bold;background: none;float: left;"><?php echo $tnamee;?> [<?php echo $thismonthsearch;?>]</div>
							<form id="form2" class="stdform" style="width: 85px;float: right;" method="post" action="<?php echo $PHP_SELF;?>">
								<select name="bill_month" class="" style="height: 30px;border-bottom: none;border-top: none;border-right: none;padding: 5px;font-weight: bold;color: #36c;" onchange="submit();">
									<option value="<?php echo date("Y-m-01") ?>"><?php echo date("M-Y") ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
								</select>
							</form>
						</div>
						<div class="" style="overflow: hidden;">
							<div id="chart_div1"></div>
						</div>
					</div>
					<?php } if(in_array(244, $access_arry)){ ?>
					<div class="modal-content" style="border: 2px solid #ccc;margin: 5px 0px 0px 0px;">
						<div class="" style="overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
							<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 10px;font-weight: bold;background: none;float: left;"><?php echo $tnameeee;?> [<?php echo $thismonthsearch1;?>]</div>
							<form id="form2" class="stdform" style="width: 85px;float: right;" method="post" action="<?php echo $PHP_SELF;?>">
								<select name="bill_monthhh" class="" style="height: 30px;border-bottom: none;border-top: none;border-right: none;padding: 5px;font-weight: bold;color: #36c;" onchange="submit();">
									<option value="<?php echo date("Y-m-01") ?>"><?php echo date("M-Y") ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_monthhh == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
								</select>
							</form>
						</div>
						<div class="" style="overflow: hidden;">
							<div id="chart_div1333"></div>
						</div><!--widgetcontent-->
					</div>	
					<?php } ?>
				</div>
				<?php } if(in_array(242, $access_arry)){ ?>
				
				<div id="dashboard-left" class="span3" style="margin-left: 5px;">
					<div class="modal-content" style="border: 2px solid #ccc;">
					<div class="" style="overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
						<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 10px;font-weight: bold;background: none;float: left;">AUTO Inactive/Terminated</div>
						<form id="form2" class="stdform" style="width:85px;float: right;" method="post" action="<?php echo $PHP_SELF;?>">
							<select name="sts_month" class="" style="height: 30px;border-bottom: none;border-top: none;border-right: none;padding: 5px;font-weight: bold;color: #36c;" onchange="submit();">
								<option value="<?php echo date("Y-m-01") ?>"><?php echo date("M-Y") ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
								<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($sts_month == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
							</select>
						</form>
					</div>
						<div class="" style="overflow: hidden;">
							<ul class="sidebarlist">
							<?php
								while( $rowws = mysql_fetch_assoc($sqlreseller) )
								{
									if($rowws['resellerz'] != ''){
										$reseller_nam = '- '.$rowws['resellerz'];
									}
									else{
										$reseller_nam = '';
									}
									echo
										"<li style='padding: 1% 0% 1% 1%;font-size: 12px;font-weight: bold;'><i class='iconfa-angle-right'></i> <a href='#' style='color: #0866c6;'>{$rowws['z_name']}<span style='padding: 0% 3% 0% 2%;border-left: 1px solid #ddd;font-size: 14px;color: #008000a8;width: 20px;text-align: right;'>{$rowws['totalon']}</span><span style='padding: 0% 4% 0% 0%;font-size: 14px;color: #ec1f27a8;width: 20px;text-align: right;'>{$rowws['totaloff']}</span></a></li>";
								}  
							?>
							
							</ul>
						</div><!--widgetcontent-->
					</div> 								
				</div>
				<?php } if(in_array(243, $access_arry) || in_array(260, $access_arry) || in_array(258, $access_arry) || in_array(259, $access_arry)){ $menuactive = 'class="ui-tabs-active ui-state-active"';?>
				
				<div id="dashboard-right" class="span4" style="margin-left: 5px;">
				<div class="tabbedwidget tab-primary" style="border: 2px solid #ccc;">
                            <ul style="height: 35px;">
								<?php if(in_array(260, $access_arry)){ ?>
									<li <?php if($active_tab == 'inactivated'){echo $menuactive;}?>><a href="#tabs-1"><span class="iconfa-user" style="font-size: 19px;margin-top: -5px;width: auto;"></span></a></li>
								<?php } if(in_array(258, $access_arry)){ ?>
									<li <?php if($active_tab == 'macreseller_terminated'){echo $menuactive;}?>><a href="#tabs-2"><span class="iconfa-user" style="font-size: 19px;margin-top: -5px;width: auto;"></span></a></li>
								<?php } if(in_array(243, $access_arry)){ ?>
									<li <?php if($active_tab == 'activities'){echo $menuactive;}?>><a href="#tabs-3"><span class="iconfa-random"  style="font-size: 19px;margin-top: -5px;width: auto;"></span></a></li>
                                <?php } if(in_array(259, $access_arry)){ ?>
									<li <?php if($active_tab == 'update'){echo $menuactive;}?>><a href="#tabs-4"><span class="iconfa-cogs"  style="font-size: 19px;margin-top: -5px;width: auto;"></span></a></li>
								<?php } ?>
                            </ul>
							<?php if(in_array(260, $access_arry)){ ?>
                            <div id="tabs-1" class="nopadding">
                                <h5 class="tabtitle" style="margin-top: 0;">Last 200 Auto Inactivated<?php if($active_tab != 'inactivated'){ ?><a href="ActionAdd?typ=tab&way=inactivated&eid=<?php echo $e_id;?>" style="float: right;line-height: 1;color: red;" title="Active This Tab"><button class="btn ownbtn4" style="padding: 0px 3px;"><i class="iconfa-thumbs-up"></i></button></a><?php } ?><a href="Clients?id=auto" style="float: right;line-height: 1;color: blue;margin-right: 2px;" title="Check All Auto Inactivated Clients"><button class="btn ownbtn2" style="padding: 2px 4px;font-size: 11px;"><i class="iconfa-eye-open"></i></button></a></h5>
                                <ul class="userlist">
								<?php
								$sql33 = mysql_query("SELECT * FROM clients AS c WHERE c.sts = '0' AND c.con_sts = 'Inactive' AND c.mac_user !='1' AND c.auto_sts = '1' ORDER BY c.auto_inactive_date_time DESC LIMIT 200");?>
									<table id="dyntable2" class="table table-bordered responsive">
										<thead>
											<tr class="newThead">
												<th class="head1 center" style="padding: 3px 0px 3px 5px;vertical-align: middle;line-height: 0.429;">S/L</th>
												<th class="head0" style="padding: 3px 0px 3px 5px;vertical-align: middle;line-height: 0px;">ID/NAME/CELL</th>
												<th class="head1 center">DO</th>
											</tr>
										</thead>
										<tbody>
										 <?php 
										 $xxx = 1;
										 while( $row33 = mysql_fetch_assoc($sql33) ){
											echo
												"<tr class='gradeX'>
													<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 14px;'>{$xxx}</td>
													<td style='padding: 2px 0px 2px 5px;'><a href='#' style='color: #0866c6;font-weight: bold;'>{$row33['c_name']}</a> ({$row33['c_id']} - {$row33['cell']})<br><b>At {$row33['note_auto']}</b></td>\n";?>
													<td class='center' style='vertical-align: middle;padding: 0px;'>
														<div class="btn-group">
															<button class="btn dropdown-toggle" style="border-radius: 3px;border: 0px solid #0866c6;font-size: 17px;color: #0866c6;background: transparent;height: 46px;" data-toggle="dropdown"><i class='iconfa-chevron-down'></i></button>
															<ul class="dropdown-menu" style="width: 160px;padding: 2px;right: 0;left: unset;">
																<?php if(in_array(128, $access_arry)){?>
																	<li style="margin-bottom: 2px;"><form action='PaymentAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row33['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #044a8e;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Cash Payment'><i class='iconfa-money'></i>&nbsp;&nbsp;&nbsp;Cash Payment</button></form></li>
																<?php } if(in_array(129, $access_arry)){?>
																	<li style="margin-bottom: 2px;"><form action='PaymentOnlineAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row33['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: green;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Online Payment'><i class='iconfa-shopping-cart'></i>&nbsp;&nbsp;&nbsp;Online Payment</button></form></li>
																<?php } ?>
																	<li class="divider"></li>
																<?php if(in_array(104, $access_arry)){?>
																	<li style="margin-bottom: 2px;"><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row33['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #0866c6;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Profile'><i class='iconfa-eye-open'></i>&nbsp;&nbsp;&nbsp;Profile</button></form></li>
																<?php } if(in_array(101, $access_arry)){?>
																	<li style="margin-bottom: 2px;"><form action='ClientEdit' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row33['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #a0f;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Edit'><i class='iconfa-edit'></i>&nbsp;&nbsp;&nbsp;Edit</button></form></li>
																<?php } if(in_array(105, $access_arry)){?>
																	<li style="margin-bottom: 2px;"><form action='ClientSMS' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row33['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: green;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Send SMS'><i class='iconfa-envelope'></i>&nbsp;&nbsp;&nbsp;Send SMS</button></form></li>
																<?php } ?>
															</ul>
														</div>
													</td>
											
											 <?php $xxx++;} ?>
										 </tr>
										</tbody>
									</table>
                                </ul>
                            </div>
							<?php } if(in_array(258, $access_arry)){ ?>
							<div id="tabs-2" class="nopadding">
                                <h5 class="tabtitle" style="margin-top: 0;">Today's Macreseller's Terminated Clients<?php if($active_tab != 'macreseller_terminated'){ ?><a href="ActionAdd?typ=tab&way=macreseller_terminated&eid=<?php echo $e_id;?>" style="float: right;line-height: 1;color: red;" title="Active This Tab"><button class="btn ownbtn4" style="padding: 0px 3px;"><i class="iconfa-thumbs-up"></i></button></a><?php } ?></h5>
                                <ul class="userlist">
								<?php
								$sql33r = mysql_query("SELECT l.c_id, c.c_name, e.e_cont_per, z.z_name AS tzonename, e.e_name AS tresellername FROM con_sts_log AS l LEFT JOIN clients AS c ON c.c_id = l.c_id LEFT JOIN zone AS z ON z.z_id = c.z_id LEFT JOIN emp_info AS e on e.e_id = z.e_id WHERE l.update_date = '$y_dateTime' AND l.update_by = 'Auto' AND c.sts = '0' AND c.con_sts = 'Inactive' AND c.mac_user ='1' ORDER BY z.z_name ASC");?>
									<table id="dyntable" class="table table-bordered responsive">
										<thead>
											<tr class="newThead">
												<th class="head1 center" style="padding: 3px 0px 3px 5px;">S/L</th>
												<th class="head0" style="padding: 3px 0px 3px 5px;">ID/ZONE</th>
												<th class="head0" style="padding: 3px 0px 3px 5px;">RESELLER/CELL</th>
												<th class="head1 center" style="padding: 3px 0px 3px 5px;">PROFILE</th>
											</tr>
										</thead>
										<tbody>
										 <?php 
										 $xxxr = 1;
										 while( $row33e = mysql_fetch_assoc($sql33r) ){
											echo
												"<tr class='gradeX'>
													<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 14px;'>{$xxxr}</td>
													<td style='padding: 2px 0px 2px 5px;'><a href='#' style='color: #0866c6;font-weight: bold;'>{$row33e['c_id']}</a><br><b>{$row33e['tzonename']}</b></td>
													<td style='padding: 2px 0px 2px 5px;'><a href='#' style='color: #0866c6;font-weight: bold;'>{$row33e['tresellername']}</a><br><b>{$row33e['e_cont_per']}</b></td>
													<td class='center' style='vertical-align: middle;'><form action='ClientView' method='post' title='Profile' target='_blank'><input type='hidden' name='ids' value='{$row33e['c_id']}'><button class='btn ownbtn2' style='padding: 6px 9px;' title='Profile'><i class='iconfa-eye-open'></i></button></form></td>\n";
											$xxxr++;
											}
										 ?>
										 
										 </tr>
										</tbody>
									</table>

                                </ul>
                            </div>
							<?php } if(in_array(243, $access_arry)){ ?>
                            <div id="tabs-3" class="nopadding">
                                <h5 class="tabtitle" style="margin-top: 0;">Employee Activities<?php if($active_tab != 'activities'){ ?><a href="ActionAdd?typ=tab&way=activities&eid=<?php echo $e_id;?>" style="float: right;line-height: 1;color: red;" title="Active This Tab"><button class="btn ownbtn4" style="padding: 0px 3px;"><i class="iconfa-thumbs-up"></i></button></a><?php } ?></h5>
                                <ul class="userlist">
								<?php
								$sql33 = mysql_query("SELECT e.id, e.e_id, e.c_id, e.module_name, e.titel, DATE_FORMAT(e.date_time, '%D %M, %Y') AS datetime, e.date_time, e.date, e.time, e.action, e.action_details, l.user_name, l.image, u.u_des AS user_type FROM emp_log AS e
													LEFT JOIN login AS l ON l.e_id = e.e_id
                                                    LEFT JOIN user_typ AS u ON u.u_type = l.user_type
                                                    
                                                    WHERE e.sts = '0' ORDER BY e.id DESC LIMIT 12");
								while( $row33 = mysql_fetch_assoc($sql33) ){
									
									if($row33['image'] != ''){
										$empimage = $row33['image'];
									}
									else{
										$empimage = 'emp_images/no_img.jpg';
									}
									
									?>
                                    <li>
                                        <div>
                                            <img src="<?php echo $empimage;?>" alt="" height="50px" width="50px" class="pull-left" />
                                            <div class="uinfo">
                                                <h5><?php echo $row33['user_name'];?></h5>
                                                <span class="pos" style="text-transform: none;"><?php echo $row33['action_details'];?></span>
                                                <span style="float: left;text-transform: uppercase;">[<?php echo $row33['user_type'];?>]</span>
                                                <span style="text-align: right;"><?php echo $row33['datetime'].' '.$row33['time'];?></span>
                                            </div>
                                        </div>
                                    </li>
								<?php } ?>
                                </ul>
                            </div>
							<?php } if(in_array(259, $access_arry)){ ?>
                            <div id="tabs-4" class="nopadding">
                               <h5 class="tabtitle" style="margin-top: 0;">Recent Update in <?php echo $version;?><?php if($active_tab != 'update'){ ?><a href="ActionAdd?typ=tab&way=update&eid=<?php echo $e_id;?>" style="float: right;line-height: 1;color: red;" title="Active This Tab"><button class="btn ownbtn4" style="padding: 0px 3px;"><i class="iconfa-thumbs-up"></i></button></a><?php } ?></h5>
                                <ul class="userlist" style="padding: 15px 10px 0px 15px;">
								<?php
								$sql = mysql_query("SELECT id, version, update_subject, update_desc, update_time, update_by, publish_time, new, position FROM updates WHERE status = '0' AND publish_status = 'Yes' ORDER BY id desc limit 15");
								while( $row = mysql_fetch_assoc($sql) ){
									$update_subject=$row['update_subject'];
									$update_desc=$row['update_desc'];
									$update_by=$row['update_by'];
									$new=$row['new'];
									if ($new=='Yes'){$new='[NEW]';}else{$new='';}
									$position=$row['position'];
									$crrnt = date("Y-m-d H:i:s");
									if ($crrnt > $row['publish_time']){
									
									$yrdata= strtotime($row['update_time']);
									$date = date('d-F-Y', $yrdata);
									$time = date('H:i a', $yrdata);
										if($position=='1'){
									echo "<blockquote class='pull-right' style='width: 85%;padding: 0 40px 2px 0;'>
									<p style='font-size: 15px;'>{$new}&nbsp;&nbsp;{$update_desc}</p>
										<small style='padding-top: 10px;'><span style='float: left;'>[{$date} at <cite title='Source Title'>{$time}</cite>]</span><cite title='Source Title'>{$update_by}</cite></small>
									</blockquote><div class='divider15' style='border-top: 1px solid #ccc;'></div>";
										}
										else{
									echo "<blockquote style='width: 85%;'>
									<p style='font-size: 15px;'>{$update_desc}&nbsp;&nbsp;{$new}&nbsp;&nbsp;</p>
										<small style='padding-top: 10px;'><cite title='Source Title'>{$update_by}</cite><span style='float: right;'>[{$date} at <cite title='Source Title'>{$time}</cite>]</span></small>
									</blockquote><div class='divider15'></div>";
									}}
								} ?>
                                </ul>
                            </div>
							<?php } ?>
                        </div><!--tabbedwidget-->
				</div>
				<?php } ?>
			</div>
			
<?php } else{ if($user_type == 'agent'){ $agent_id = $e_id; ?>

<div class="span9 rightside"  style="width: 100% !important; margin-left: 0px !important;">
	<div class="pageheader">
        <div class="searchbar" style="right: 0px;">
		<form id="" name="form" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
			<input type="text" name="f_date" id="" style="width:30%;text-align: center;" placeholder="From Date" class="surch_emp datepicker" value="<?php echo $f_date; ?>"/>
			<input type="text" name="t_date" id="" style="width:30%;text-align: center;" placeholder="To Date" class="surch_emp datepicker" value="<?php echo $t_date; ?>"/>
			<input type="hidden" name="bank" value="<?php echo $bank; ?>"/>
			<button class="btn col1" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Your Cash Details</h1>
        </div>
	</div><!--pageheader-->
	<div class="box" style=" margin: 0px;">
		<div class="box-body" style="min-height: 85vh;">
					
					<?php
					$sqlop1 = mysql_query("SELECT SUM(amount) AS ISP FROM agent_commission WHERE sts = '0' AND agent_id = '$agent_id' AND bill_date < '$f_date'");

					$rowop1 = mysql_fetch_array($sqlop1);
					$fundReceivedOp = $rowop1['ISP'];
					
					$sqlopCr1 = mysql_query("SELECT SUM(amount) AS VPT FROM expanse WHERE agent_id = '$agent_id' AND status = '2' AND ex_date < '$f_date'");
					
					$rowop7 = mysql_fetch_array($sqlopCr1);
					$fundSendOp = $rowop7['VPT'];
					
					
					$openingRecived = $fundReceivedOp;
					$openingPayment = $fundSendOp;
					
					$openingBalance = $openingRecived - $openingPayment;
					
					$Bankkk = mysql_query("SELECT e_id, e_name, e_cont_per, email, com_percent, e_j_date AS join_date FROM agent WHERE e_id = '$agent_id'");
					$Bnkkk=mysql_fetch_array($Bankkk);
					$agentname = $Bnkkk['e_name'];
					$agentcell = $Bnkkk['e_cont_per'];
					$agentcom_percent = $Bnkkk['com_percent'];
					$agentemail = $Bnkkk['email'];
					$agentjoin_date = $Bnkkk['join_date'];
					?>

					<table id="dyntable" class="table table-bordered responsive">
						<colgroup>
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
									<th class="head0">Date</th>
									<th class="head1">Particulars</th>
									<th class="head0">Commission </th>
									<th class="head1">Paid Amount</th>
									<th class="head0">Balance</th>
									<th class="head1">Note</th>
								</tr>
						</thead>
					<tbody>
					<tr class='gradeX'>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;"><b>Opeaning Balance:</b></td>
					<td><b><?php echo $openingBalance; ?></b></td>
					<td></td>
					</tr>
					<?php			
					$x = 1;
					$TotBalanceTransferRcv = 0;	
					$TotalVendCr = 0;
					
		while (strtotime($f_date) <= strtotime($t_date)) {	
		//------------------------------------------------------------Received Amount---------------------------------------------------------------------------------	
			
			$sqlfgj = mysql_query("SELECT p.id AS vp_id, p.payment_amount, q.e_name AS resellername, p.purpose, q.e_id AS agentidddd, c.cell, c.c_name, p.c_id, p.com_percent AS compercent, DATE_FORMAT(p.bill_date, '%D %b-%y') AS bill_date, DATE_FORMAT(p.bill_time, '%h:%i%p') AS bill_time, p.agent_id, a.e_name AS agent_name, a.e_cont_per, a.com_percent, p.amount, p.entry_by, e.e_name, p.sts, p.note FROM `agent_commission` AS p
											LEFT JOIN agent AS a ON a.e_id = p.agent_id
											LEFT JOIN emp_info AS q ON q.e_id = p.reseller_id
											LEFT JOIN emp_info AS e ON e.e_id = p.entry_by
											LEFT JOIN clients AS c ON c.c_id = p.c_id
											WHERE p.sts = '0' AND p.agent_id = '$agent_id' AND p.bill_date = '$f_date' ORDER BY p.bill_date_time DESC");
			$InstumentPurchase = 0;
			while ($rowert = mysql_fetch_array($sqlfgj)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $rowert['bill_date'];?></b><br><?php echo $rowert['bill_time']; ?></td>
				<?php if($rowert['c_id'] == '' && $rowert['agentidddd'] == ''){?>
					<td>Extra Commission Added for <?php echo $rowert['purpose'];?> [By <?php echo $rowert['e_name'];?>]</td>
				<?php } else{?>
					<td><b><?php echo $rowert['compercent'];?>%</b> Commission for <b><?php echo $rowert['c_name'];?><?php echo $rowert['resellername'];?> (<?php echo $rowert['c_id'];?><?php echo $rowert['agentidddd'];?>)</b> Payment <b><?php echo $rowert['payment_amount'];?>tk</b> [By <?php echo $rowert['e_name'];?>]</td>
				<?php } ?>
					<td><?php echo $rowert['amount'].'/='; ?></td>
					<td class='center'>-</td>
					<td></td>
					<td><?php echo $rowert['note'];?></td>
				</tr>
			<?php	$InstumentPurchase += $rowert['amount'];
			}
		

	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
	
			$sqlCr = mysql_query("SELECT e.voucher, x.ex_type, DATE_FORMAT(e.ex_date, '%D %b-%y') AS ex_date, e.`ex_by`, i.e_name AS ex_by, e.`type`, e.`amount`, e.`mathod`, e.`entry_by`, q.e_name AS entry_by, DATE_FORMAT(e.enty_date, '%h:%i%p') AS enty_date , e.`note`, e.`v_id`, b.bank_name FROM `expanse` AS e 
									LEFT JOIN expanse_type AS x ON x.id = e.type
									LEFT JOIN emp_info AS i ON i.e_id = e.ex_by
									LEFT JOIN emp_info AS q ON q.e_id = e.entry_by
									LEFT JOIN bank AS b ON b.id = e.bank
									WHERE e.agent_id = '$agent_id' AND e.`status` = '2' AND e.`ex_date` = '$f_date' ORDER BY e.ex_date DESC");
			$VendorPaymentAmountCr = 0;
			while ($rowCr = mysql_fetch_array($sqlCr)) {?>
				<tr class='gradeX'>
					<td><b><?php echo $rowCr['ex_date']; ?></b><br><?php echo $rowCr['enty_date']; ?></td>
					<td><?php echo $rowCr['ex_type']; ?> [Paid by <?php echo $rowCr['ex_by'];?> by <?php echo $rowCr['mathod'];?>] [Bank: <?php echo $rowCr['bank_name'];?>]</td>
					<td class="center">-</td>
					<td><?php echo $rowCr['amount'].'/='; ?></td>
					<td></td>
					<td><?php echo $rowCr['note']; ?></td>
				</tr>
			<?php	$VendorPaymentAmountCr += $rowCr['amount'];
			}
			

			$f_date = date ("Y-m-d", strtotime("+1 days", strtotime($f_date)));
			$x++;
			$TotBalanceTransferRcv += $InstumentPurchase;
			$TotalVendCr += $VendorPaymentAmountCr;
		}	

			$ReciveTotal = $TotBalanceTransferRcv;
			$PaidTotal = $TotalVendCr;?>

				<tr class='gradeX'>
					<td></td>
					<td style="text-align: right;font-size: 16px;"><b>TOTAL</b></td>
					<td style="text-align: right;"><b><?php echo number_format($ReciveTotal,2); ?> ৳</b></td>
					<td style="text-align: right;"><b><?php echo number_format($PaidTotal,2); ?> ৳</b></td>
					<td style="text-align: right;font-size: 16px;color: red;"><b><?php echo number_format((($ReciveTotal + $openingBalance) - $PaidTotal),2); ?> ৳</b></td>
					<td></td>
				</tr>
					</tbody>
					</table>
</div></div></div>
<?php } else{ ?>
<div class="span9 rightside"  style="width: 100% !important; margin-left: 0px !important;">
	<div class="pageheader">
        <div class="searchbar" style="right: 0px;">
		<form id="" name="form" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
			<input type="text" name="f_date" id="" style="width:30%;text-align: center;" placeholder="From Date" class="surch_emp datepicker" value="<?php echo $f_date; ?>"/>
			<input type="text" name="t_date" id="" style="width:30%;text-align: center;" placeholder="To Date" class="surch_emp datepicker" value="<?php echo $t_date; ?>"/>
			<input type="hidden" name="bank" value="<?php echo $bank; ?>"/>
			<input type="hidden" name="wayyy" value="nothing"/>
			<button class="btn col1" type="submit"><i class="iconsweets-magnifying iconsweets-white"></i></button>
		</form>
        </div>
        <div class="pageicon"><i class="iconfa-bar-chart"></i></div>
        <div class="pagetitle">
            <h1>Your Cash Details</h1>
        </div>
    </div><!--pageheader-->
				<div class="box" style=" margin: 0px;">
					<div class="box-body" style="min-height: 440px;">
<?php

$Bankkkk = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
$rowbbk = mysql_fetch_array($Bankkkk);
$bank = $rowbbk['id'];

					$sqlop1 = mysql_query("SELECT SUM(transfer_amount) AS TFR FROM fund_transfer WHERE fund_received = '$bank' AND transfer_date < '$f_date'");
					$sqlop2 = mysql_query("SELECT SUM(amount) AS TLR FROM loan_receive WHERE bank = '$bank' AND loan_date < '$f_date'");
					$sqlop3 = mysql_query("SELECT SUM(pay_amount) AS TBC FROM payment WHERE bank = '$bank' AND pay_date  < '$f_date'");
					$sqlop400 = mysql_query("SELECT SUM(amount) AS OBS FROM bill_signup WHERE bank = '$bank' AND pay_date < '$f_date'");
					$sqlop600 = mysql_query("SELECT SUM(amount) AS EBS FROM bill_extra WHERE bank = '$bank' AND pay_date < '$f_date'");
					$sqlop500 = mysql_query("SELECT SUM(pay_amount) AS MRP FROM payment_macreseller WHERE sts = '0' AND bank = '$bank' AND pay_date < '$f_date'");

					$rowop1 = mysql_fetch_array($sqlop1);
					$fundReceivedOp = $rowop1['TFR'];
					
					$rowop2 = mysql_fetch_array($sqlop2);
					$loanReceiveOp = $rowop2['TLR'];
					
					$rowop3 = mysql_fetch_array($sqlop3);
					$billCollectionOp = $rowop3['TBC'];
					
					$rowop400 = mysql_fetch_array($sqlop400);
					$billSignupOp = $rowop400['OBS'];
					
					$rowop500 = mysql_fetch_array($sqlop500);
					$MacresellerPaymentOp = $rowop500['MRP'];
					
					$rowop600 = mysql_fetch_array($sqlop600);
					$ExtraBillOp = $rowop600['EBS'];
					
					
					$sqlopCr1 = mysql_query("SELECT SUM(transfer_amount) AS TFS FROM fund_transfer WHERE fund_send = '$bank' AND transfer_date < '$f_date'");
					$sqlopCr2 = mysql_query("SELECT SUM(amount) AS TLP FROM loan_payment WHERE bank = '$bank' AND payment_date < '$f_date'");
					$sqlopCr4 = mysql_query("SELECT SUM(amount) AS TP FROM expanse WHERE bank = '$bank' AND status = '2' AND ex_date < '$f_date'");
					$sqlopCr5 = mysql_query("SELECT SUM(amount) AS SAP FROM emp_salary_payment WHERE bank = '$bank' AND payment_date < '$f_date'");
					
					$rowop7 = mysql_fetch_array($sqlopCr1);
					$fundSendOp = $rowop7['TFS'];
					
					$rowop8 = mysql_fetch_array($sqlopCr2);
					$loanPaidOp = $rowop8['TLP'];
					
					$rowop10 = mysql_fetch_array($sqlopCr4);
					$allPaymentOp = $rowop10['TP'];
					
					$rowop11 = mysql_fetch_array($sqlopCr5);
					$allSalaryOp = $rowop11['SAP'];
					
					$openingRecived = $fundReceivedOp + $loanReceiveOp + $billSignupOp + $ExtraBillOp + $billCollectionOp + $MacresellerPaymentOp;
					$openingPayment = $fundSendOp + $loanPaidOp + $allPaymentOp + $allSalaryOp;
					
					$openingBalance = $openingRecived - $openingPayment;
					
					$Bankkk = mysql_query("SELECT b.bank_name, b.id, e.e_id, e.e_name, e.e_cont_per, d.dept_name FROM bank AS b LEFT JOIN emp_info AS e ON e.e_id = b.emp_id LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE b.id = '$bank'");
					$Bnkkk=mysql_fetch_array($Bankkk);
					$Bankname = $Bnkkk['bank_name'];
					$Bankid = $Bnkkk['id'];
					$BanEmpName = $Bnkkk['e_name'];
					$BanDeptName = $Bnkkk['dept_name'];
					$BanEid = $Bnkkk['e_id'];
					$BanEmpCell = $Bnkkk['e_cont_per'];
					?>
					
					<table id="dyntable2" class="table table-bordered responsive">
						<colgroup>
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
									<th class="head0">Date</th>
									<th class="head1">Particulars</th>
									<th class="head0">Received Amount</th>
									<th class="head1 center">Paid Amount</th>
									<th class="head0 center">Balance</th>
									<th class="head1">Remarks/Narration</th>
								</tr>
						</thead>
					<tbody>
					<tr class='gradeX'>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;font-size: 14px;"><b>Opeaning Balance</b></td>
					<td style="text-align: right;font-size: 16px;"><b><?php echo number_format($openingBalance,2);?> ৳</b></td>
					<td></td>
					</tr>
					<?php			
					$x = 1;
					$TotBalanceTransferRcv = 0;	
					$TotalLoanAmount = 0;
					$TotalBillCollection = 0;
					$TotaltransferAmountCr = 0;
					$TotalAmountCr = 0;
					$TotalExAmountCr = 0;
					$TotalSalaryCr = 0;
					$TotalVendCr = 0;
					$TotOtherAmounttt = 0;
					$TotMacPayAmounttt = 0;
					
		while (strtotime($f_date) <= strtotime($t_date)) {	
		//------------------------------------------------------------Received Amount---------------------------------------------------------------------------------	
			
			$sql = mysql_query("SELECT f.transfer_date, b.bank_name, f.transfer_amount, f.note FROM fund_transfer AS f
									LEFT JOIN bank AS b ON b.id = f.fund_send
									WHERE f.fund_received = '$bank' AND f.transfer_date = '$f_date'");
			$BalanceTransferRcv = 0;
			while ($row = mysql_fetch_array($sql)) {?>
				<tr class='gradeX'>
					<td><?php echo $row['transfer_date']; ?></td>
					<td><?php echo 'Fund Received from '.$row['bank_name']; ?></td>
					<td><?php echo $row['transfer_amount']; ?> ৳</td>
					<td></td>
					<td></td>
					<td><?php echo $row['note']; ?></td>
				</tr>
			<?php	$BalanceTransferRcv += $row['transfer_amount'];
			}
						
			$sql1 = mysql_query("SELECT l.loan_from, f.name, l.amount, l.loan_date, l.note FROM loan_receive AS l 
								LEFT JOIN loan_from AS f ON f.id = l.loan_from
								WHERE l.bank = '$bank' AND l.loan_date = '$f_date'");
			$TotLoanAmount = 0;
			while ($row1 = mysql_fetch_array($sql1)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1['loan_date']; ?></td>
					<td><?php echo 'Loan received from '.$row1['name']; ?></td>
					<td><?php echo $row1['amount']; ?> ৳</td>
					<td></td>
					<td></td>
					<td><?php echo $row1['note']; ?></td>
				</tr>
			<?php	$TotLoanAmount += $row1['amount'];
			}
			
			$sql1qqq = mysql_query("SELECT b.id, b.c_id, c.c_name, b.bill_type, b.amount, b.pay_date, b.bill_dsc, t.type, b.bank FROM bill_signup AS b
								LEFT JOIN bills_type AS t ON t.bill_type = b.bill_type
								LEFT JOIN clients AS c ON c.c_id = b.c_id
								WHERE b.bank = '$bank' AND b.pay_date = '$f_date'");
			$TotOtherAmount = 0;
			while ($row1qqq = mysql_fetch_array($sql1qqq)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1qqq['pay_date']; ?></td>
					<td><?php echo 'Payment received from '.$row1qqq['c_name'].' ('.$row1qqq['c_id'].') for '.$row1qqq['type']; ?></td>
					<td><?php echo $row1qqq['amount']; ?> ৳</td>
					<td></td>
					<td></td>
					<td><?php echo $row1qqq['bill_dsc']; ?> </td>
				</tr>
			<?php	$TotOtherAmount += $row1qqq['amount'];
			}
			
			$sql1qqqeee = mysql_query("SELECT b.id, b.be_name, b.bill_type, b.amount, b.pay_date, b.bill_dsc, t.type, b.bank FROM bill_extra AS b
								LEFT JOIN bills_type AS t ON t.bill_type = b.bill_type
								WHERE b.bank = '$bank' AND b.pay_date = '$f_date'");
			$TotExtraAmount = 0;
			while ($row1qqqeee = mysql_fetch_array($sql1qqqeee)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1qqqeee['pay_date']; ?></td>
					<td><?php echo 'Payment received from '.$row1qqqeee['be_name'].' for '.$row1qqqeee['type']; ?></td>
					<td><?php echo $row1qqqeee['amount']; ?> ৳</td>
					<td></td>
					<td></td>
					<td><?php echo $row1qqqeee['bill_dsc']; ?></td>
				</tr>
			<?php	$TotExtraAmount += $row1qqqeee['amount'];
			}
			
			$sql1qqqmm = mysql_query("SELECT m.e_id, e.e_name, z.z_name, m.pay_date, m.pay_amount, m.discount, m.note FROM payment_macreseller AS m
									LEFT JOIN zone AS z ON z.z_id = m.z_id
									LEFT JOIN emp_info AS e ON e.e_id = m.e_id
									WHERE m.sts = '0' AND m.bank = '$bank' AND m.pay_date = '$f_date'");
			$TotMacPayAmount = 0;
			while ($row1qqqmm = mysql_fetch_array($sql1qqqmm)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1qqqmm['pay_date']; ?></td>
					<td><?php echo 'Reseller payment received from '.$row1qqqmm['e_name'].' ('.$row1qqqmm['z_name'].')'; ?></td>
					<td><?php echo $row1qqqmm['pay_amount']; ?> ৳</td>
					<td></td>
					<td></td>
					<td><?php echo $row1qqqmm['note']; ?></td>
				</tr>
			<?php	$TotMacPayAmount += $row1qqqmm['pay_amount'];
			}
			
			$sql2 = mysql_query("SELECT p.c_id, c.c_name, p.pay_amount, p.pay_date, p.pay_desc, p.pay_mode, p.moneyreceiptno, p.trxid FROM payment AS p LEFT JOIN clients AS c ON c.c_id = p.c_id WHERE p.bank = '$bank' AND p.pay_date = '$f_date'");
			$TotBillCollection = 0;
			while ($row2 = mysql_fetch_array($sql2)) {?>
				<tr class='gradeX'>
					<td><?php echo $row2['pay_date']; ?></td>
					<td><?php echo 'Bill collection From '.$row2['c_name'].' ('.$row2['c_id'].') by '.$row2['pay_mode'].'. MR/TrxID: '.$row2['moneyreceiptno'].$row2['trxid']; ?></td>
					<td><?php echo $row2['pay_amount']; ?> ৳</td>
					<td></td>
					<td></td>
					<td><?php echo $row2['pay_desc']; ?></td>
				</tr>
			<?php	$TotBillCollection += $row2['pay_amount'];
			}

	//------------------------------------------------------------Paid Amount---------------------------------------------------------------------------------
	
			$sqlCr = mysql_query("SELECT f.transfer_date, b.bank_name, f.transfer_amount, f.note FROM fund_transfer AS f
									LEFT JOIN bank AS b ON b.id = f.fund_received
									WHERE f.fund_send = '$bank' AND f.transfer_date = '$f_date'");
			$TottransferAmountCr = 0;
			while ($rowCr = mysql_fetch_array($sqlCr)) {?>
				<tr class='gradeX'>
					<td><?php echo $rowCr['transfer_date']; ?></td>
					<td><?php echo 'Fund send to '.$rowCr['bank_name']; ?></td>
					<td></td>
					<td><?php echo $rowCr['transfer_amount']; ?> ৳</td>
					<td></td>
					<td><?php echo $rowCr['note']; ?></td>
				</tr>
			<?php	$TottransferAmountCr += $rowCr['transfer_amount'];
			}
			
			$sql1Cr = mysql_query("SELECT l.loan_payment_to, f.name, l.amount, l.payment_date, l.note FROM loan_payment AS l 
								LEFT JOIN loan_from AS f ON f.id = l.loan_payment_to
								WHERE l.bank = '$bank' AND l.payment_date = '$f_date'");
			$TotAmountCr = 0;
			while ($row1Cr = mysql_fetch_array($sql1Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row1Cr['payment_date']; ?></td>
					<td><?php echo 'Loan paid to '.$row1Cr['name']; ?></td>
					<td></td>
					<td><?php echo $row1Cr['amount']; ?> ৳</td>
					<td></td>
					<td><?php echo $row1Cr['note']; ?></td>
				</tr>
			<?php	$TotAmountCr += $row1Cr['amount'];
			}
			
			$sql2Cr = mysql_query("SELECT e.ex_date, t.ex_type, e.amount, e.note FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									WHERE e.bank = '$bank' AND e.category = '0' AND e.status = '2' AND e.ex_date = '$f_date'");
			$TotExAmountCr = 0;
			while ($row2Cr = mysql_fetch_array($sql2Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row2Cr['ex_date']; ?></td>
					<td><?php echo 'Paid for '.$row2Cr['ex_type'];?> [Office Expance]</td>
					<td></td>
					<td><?php echo $row2Cr['amount']; ?> ৳</td>
					<td></td>
					<td><?php echo $row2Cr['note']; ?></td>
				</tr>
			<?php	$TotExAmountCr += $row2Cr['amount'];
			}
			
			$sql3Cr = mysql_query("SELECT p.payment_date, p.amount, p.note, e.e_name FROM emp_salary_payment AS p 
									LEFT JOIN emp_info AS e ON p.payment_to = e.e_id 
									WHERE p.bank = '$bank' AND p.payment_date = '$f_date'");
			$TotSalaryCr = 0;
			while ($row3Cr = mysql_fetch_array($sql3Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row3Cr['payment_date']; ?></td>
					<td><?php echo 'Paid to employee salary ('.$row3Cr['e_name'].')'; ?></td>
					<td></td>
					<td><?php echo $row3Cr['amount']; ?> ৳</td>
					<td></td>
					<td><?php echo $row3Cr['note']; ?></td>
				</tr>
			<?php	$TotSalaryCr += $row3Cr['amount'];
				
			}
			
			$sql4Cr = mysql_query("SELECT e.ex_date, t.ex_type, e.amount, e.note, v.v_name, v.cell, v.location FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									LEFT JOIN vendor AS v ON v.id = e.v_id
									WHERE e.bank = '$bank' AND e.category = '1' AND e.status = '2' AND e.ex_date = '$f_date'");
			$TotVendrCr = 0;
			while ($row4Cr = mysql_fetch_array($sql4Cr)) {?>
				<tr class='gradeX'>
					<td><?php echo $row4Cr['ex_date']; ?></td>
					<td><?php echo 'Paid to Vendor ('.$row4Cr['v_name'].'-'.$row4Cr['location'].')'; ?></td>
					<td></td>
					<td><?php echo $row4Cr['amount']; ?> ৳</td>
					<td></td>
					<td><?php echo $row4Cr['note']; ?></td>
				</tr>
			<?php	$TotVendrCr += $row4Cr['amount'];
				
			}
			
			$sql4CrAg = mysql_query("SELECT e.ex_date, t.ex_type, e.amount, e.note, a.e_name, a.e_cont_per FROM expanse AS e
									LEFT JOIN expanse_type AS t ON t.id = e.type
									LEFT JOIN agent AS a ON a.e_id = e.agent_id
									WHERE e.bank = '$bank' AND e.category = '2' AND e.status = '2' AND e.ex_date = '$f_date'");
			$TotAgCr = 0;
			while ($row4CrAg = mysql_fetch_array($sql4CrAg)) {?>
				<tr class='gradeX'>
					<td><?php echo $row4CrAg['ex_date']; ?></td>
					<td><?php echo 'Commission Paid to Agent ('.$row4CrAg['e_name'].'-'.$row4CrAg['e_cont_per'].')'; ?></td>
					<td></td>
					<td><?php echo $row4CrAg['amount']; ?> ৳</td>
					<td></td>
					<td><?php echo $row4CrAg['note']; ?></td>
				</tr>
			<?php	$TotAgCr += $row4CrAg['amount'];
				
			}

			$f_date = date ("Y-m-d", strtotime("+1 days", strtotime($f_date)));
			$x++;
			$TotBalanceTransferRcv += $BalanceTransferRcv;
			$TotalLoanAmount += $TotLoanAmount;
			$TotOtherAmounttt += $TotOtherAmount;
			$TotExtraAmounttt += $TotExtraAmount;
			$TotMacPayAmounttt += $TotMacPayAmount;
			$TotalBillCollection += $TotBillCollection;

			$TotaltransferAmountCr += $TottransferAmountCr;
			$TotalAmountCr += $TotAmountCr;
			$TotalExAmountCr += $TotExAmountCr;
			$TotalSalaryCr += $TotSalaryCr;
			$TotalVendCr += $TotVendrCr;
			$TotalAgeCr += $TotAgCr;
		}	

			$ReciveTotal = $TotBalanceTransferRcv + $TotalLoanAmount + $TotOtherAmounttt + $TotExtraAmounttt + $TotMacPayAmounttt + $TotalBillCollection;
			$PaidTotal = $TotaltransferAmountCr + $TotalAmountCr + $TotalExAmountCr + $TotalSalaryCr + $TotalVendCr + $TotalAgeCr;?>
				<tr class='gradeX'>
					<td></td>
					<td style="text-align: right;font-size: 16px;"><b>TOTAL</b></td>
					<td style="text-align: right;"><b><?php echo number_format($ReciveTotal,2); ?> ৳</b></td>
					<td style="text-align: right;"><b><?php echo number_format($PaidTotal,2); ?> ৳</b></td>
					<td style="text-align: right;font-size: 16px;color: red;"><b><?php echo number_format((($ReciveTotal + $openingBalance) - $PaidTotal),2); ?> ৳</b></td>
					<td></td>
				</tr>
					</tbody>
						</table>
					</div></div></div>
<?php }}}
else{
	header("Location:/index");
	}
include('include/footer.php');

?>

<?php if($client_onlineclient_sts == '1'){ ?>
<script>
 $(document).ready(function() {
 	 $("#responsecontainer1").load("AutoActiveClientsCount1.php");
   var refreshId = setInterval(function() {
	 $("#responsecontainer1").load("AutoActiveClientsCount1.php");
   }, 5000);
   $.ajaxSetup({ cache: false });
});
</script>
<?php } if($userr_typ == 'mreseller'){ ?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<?php } elseif($userr_typ == 'client'){
	
} else{ ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 20,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'asc']],
            "sScrollY": "924px"
        });
    });
</script>
<?php } ?>
<style>
#dyntable_length{display: none;}
.dataTables_filter{display: none;}
</style>
