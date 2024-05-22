<?php
include("../web/conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
include("mk_api.php");
extract($_POST);

$new_id = str_replace(' ', '', $c_id);
$durationn = floor($duration);

$sqlqqmm = mysql_query("SELECT minimum_day, minimum_days, minimum_sts, billing_type, over_due FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);

$billing_type = $row22m['billing_type'];
$minimum_days = $row22m['minimum_days'];
$minimum_sts = $row22m['minimum_sts'];
$over_due_bal = '-'.$row22m['over_due'];

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

if($durationn < $minimum_day || $p_id == ''){echo 'Invilade Submission!! Please Check All Inputs. Yor Minimum Recharge Day is '.$minimum_day.'.';}else{
$sqlqq = mysql_query("SELECT mk_profile, p_price, p_price_reseller FROM package WHERE p_id = '$p_id'");
$row22 = mysql_fetch_assoc($sqlqq);

$ppriceee = $row22['p_price'];
$p_price_reseller = $row22['p_price_reseller'];

$sql1q = mysql_query("SELECT c_id, SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$z_id'");
$rowq = mysql_fetch_array($sql1q);

$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p	WHERE p.z_id = '$z_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);
$aaaa = $rowwz['retotalpayments']-$rowq['totbill'];

$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$new_id'");
$rowc = mysql_fetch_assoc($sqlc);

if($rowc['user_id'] == ''){

$sqlqqq = mysql_query("SELECT z.z_id, z.e_id, e.e_name, e.mk_id FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.z_id = '$z_id'");
$row2222 = mysql_fetch_assoc($sqlqqq);

$mk_id = $row2222['mk_id'];

ini_alter('date.timezone','Asia/Almaty');
$todayyyy = date('Y-m-d', time());
$todayyyy_time = date('H:i:s', time());
$termination_date = date('Y-m-d', strtotime($todayyyy . " + ".$durationn." day"));
$bill_date_time = date('Y-m-d H:i:s', time());

$packageoneday = $ppriceee/30;
$daycost = $durationn*$packageoneday;
			
$checkbalance = $aaaa-$daycost;

if($checkbalance > $over_due_bal && $billing_type == 'Prepaid' || $billing_type == 'Postpaid'){

$sqlq = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h, add_date_time, note FROM mk_con WHERE id = '$mk_id'");
$row2 = mysql_fetch_assoc($sqlq);

$Pass= openssl_decrypt($row2['Pass'], $row2['e_Md'], $row2['secret_h']);
$API = new routeros_api();
$API->debug = false;
if ($API->connect($row2['ServerIP'], $row2['Username'], $Pass, $row2['Port'])) {
	
//	 $ico = "<img src='images/icon_led_green.png' />";


	$pass = sha1($passid);

		
//................IMAGE.......................//
if($_FILES['image']['tmp_name'] != '')
{
 $uploaddir = 'emp_images/';
 $uploadfile = $uploaddir .$new_id .'_'. basename($_FILES['image']['name']);
 move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
}
else {
	$uploadfile = '';
}
//................IMAGE.......................//

//--------Add PPPoE in Mikrotik-------

		$nombre =  $new_id;
        $password = $passid;
        $service = 'pppoe';
        $profile = $row22['mk_profile'];
		$pprice = $ppriceee;
		$remote = $ip;
if($ip != ''){
        $API->comm("/ppp/secret/add", array(
           "name"     => $nombre,
			"password" => $password,
			"profile"  => $profile,
			"service"  => $service,
			"remote-address" => $remote,
        ));
}
else{
			$API->comm("/ppp/secret/add", array(
			"name"     => $nombre,
			"password" => $password,
			"profile"  => $profile,
			"service"  => $service,
        ));
}
$API->disconnect();

//--------Add PPPoE in Mikrotik-------
$query2asd = mysql_query("SELECT reseller_client_login FROM app_config");
$row2sczsdf = mysql_fetch_assoc($query2asd);
$reseller_client_login = $row2sczsdf['reseller_client_login'];
if($reseller_client_login == '1'){
	$canlog = '0';
}
else{
	$canlog = '1';
}
		
$cellc = filter_var($cell, FILTER_SANITIZE_NUMBER_INT);
$cellc1 = filter_var($cell1, FILTER_SANITIZE_NUMBER_INT);
$cellc2 = filter_var($cell2, FILTER_SANITIZE_NUMBER_INT);
$cellc3 = filter_var($cell3, FILTER_SANITIZE_NUMBER_INT);
$cellc4 = filter_var($cell4, FILTER_SANITIZE_NUMBER_INT);
		if($new_id != ''){
			$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, cell, cell1, cell2, cell3, cell4, opening_balance, email, address, thana, previous_isp, join_date, occupation, con_type, connectivity_type, ip, mac, req_cable, cable_type, con_sts, nid, p_id, p_m, signup_fee, discount, extra_bill, note, entry_by, entry_date, entry_time, father_name, old_address)
					  VALUES ('$new_id', '$com_id', '$c_name', '$z_id', '$mk_id', '$termination_date', '$mac_user', '$cellc', '$cellc1', '$cellc2', '$cellc3', '$cellc4', '$opening_balance', '$email', '$address', '$thana', '$previous_isp', '$join_date', '$occupation', '$con_type', '$connectivity_type', '$ip', '$mac', '$req_cable', '$cable_type', '$con_sts', '$nid', '$p_id', '$p_m', '$signup_fee', '$discount', 'extra_bill', '$note','$entry_by', '$entry_date', '$entry_time', '$father_name', '$old_address')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($result)
			{
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, email, image, log_sts, pw) VALUES ('$c_name', '$new_id', '$new_id', '$pass', 'client', '$email', '$uploadfile', '$canlog', '$passid')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			
			if($qcalculation == 'Manual')
			{
				$dis_price = ($p_price_reseller - $discount) + $extra_bill;
				$query20r = "insert into billing_mac_client (c_id, bill_date, p_id, p_price, bill_amount, extra_bill, discount, bill_date_time) VALUES ('$nombre', '$entry_date', '$p_id', '$p_price_reseller', '$dis_price', '$extra_bill', '$discount', '$bill_date_time')";
				if (!mysql_query($query20r)){
					die('Error: ' . mysql_error());
				}
			}
			
			if($qcalculation == 'Auto')
			{
			$todayy = date('d', time());
			$lastdayofthismonth = date('t');
			$aa = $lastdayofthismonth - $todayy;
			$onedaynewprice = (($p_price_reseller + $extra_bill) - $discount) / $lastdayofthismonth;
			$unusedday = $aa * $onedaynewprice;
			$discountt = $p_price_reseller - $unusedday;
			
				$query20r = "insert into billing_mac_client (c_id, bill_date, p_id, p_price, discount, extra_bill, bill_amount, bill_date_time, day) VALUES ('$nombre', '$entry_date', '$p_id', '$p_price_reseller', '$discountt', '$extra_bill', '$unusedday', '$bill_date_time', '$aa')";
				if (!mysql_query($query20r)){
					die('Error: ' . mysql_error());
				}
			}
			$sqlqqrrm = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$nombre' AND start_date = '$todayyyy'");
			if(mysql_num_rows($sqlqqrrm)<=0){
			$query2 = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time) VALUES ('$nombre', '$z_id', '$p_id', '$todayyyy', '$todayyyy_time', '$termination_date', '$durationn', '$pprice', '$daycost', '$entry_by', '$todayyyy', '$todayyyy_time')";
			if (!mysql_query($query2)){
				die('Error: ' . mysql_error());
			}}
			
			$query20 = "UPDATE emp_info SET last_id = '$com_id' WHERE z_id = '$z_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
			
			}
		else{
			echo 'Invilade Id';
		}
?>

<html>
<body>
     <form action="Success" method="post" name="cus_id">
       <input type="hidden" name="new_id" value="<?php echo $new_id; ?>">
	   <input type="hidden" name="passid" value="<?php echo $passid; ?>">
	   <input type="hidden" name="sentsms" value="<?php echo $sentsms; ?>">
	   <input type="hidden" name="mk_name" value="<?php echo $row2['Name']; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.cus_id.submit();
     </script>
     <noscript><input type="submit" value="<? echo $new_id; ?>"></noscript>
</body>
</html>

<?php
}
else{
	echo 'Selected Network are not Connected';
}
}
else{echo 'Have not sufficient balance.';}
}
else{
	echo 'Client ID Already Existed';
}}
?>