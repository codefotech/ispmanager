<?php
include("conn/connection.php");
include("mk_api.php");
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');
$todayyyy = date('Y-m-d', time());

$new_id = str_replace(' ', '', $c_id);

if($wayyyyyy == 'clienttomacclient'){
$durationn = floor($duration);

$sqlqqmm = mysql_query("SELECT minimum_day, billing_type FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);
$minimum_day = $row22m['minimum_day'];
$billing_type = $row22m['billing_type'];

if($durationn < $minimum_day || $p_id == ''){echo 'Invilade Submission!! Please Check All Inputs. Yor Minimum Recharge Day is '.$minimum_day.'.';}else{
$sqlqq = mysql_query("SELECT mk_profile, p_price, p_price_reseller FROM package WHERE p_id = '$p_id'");
$row22 = mysql_fetch_assoc($sqlqq);
$ppriceee = $row22['p_price'];
$p_price_reseller = $row22['p_price_reseller'];
$mk_profile = $row22['mk_profile'];

$sqlqqfgdfg = mysql_query("SELECT mk_profile FROM package WHERE p_id = '$old_p_id'");
$row22sddf = mysql_fetch_assoc($sqlqqfgdfg);
$old_mk_profile = $row22sddf['mk_profile'];

$sql1q = mysql_query("SELECT c_id, SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$z_id'");
$rowq = mysql_fetch_array($sql1q);

$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p	WHERE p.z_id = '$z_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);
$aaaa = $rowwz['retotalpayments']-$rowq['totbill'];

$sqlqqq = mysql_query("SELECT z.z_id, z.e_id, e.e_name, e.mk_id FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.z_id = '$z_id'");
$row2222 = mysql_fetch_assoc($sqlqqq);
$mk_id = $row2222['mk_id'];

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
		
$ServerIP = $rowmk['ServerIP'];
$Username = $rowmk['Username'];
$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
$Port = $rowmk['Port']; 
		
$API = new routeros_api();
$API->debug = false;


$todayyyy_time = date('H:i:s', time());
$termination_date = date('Y-m-d', strtotime($todayyyy . " + ".$durationn." day"));

$packageoneday = $ppriceee/30;
$daycost = $durationn*$packageoneday;
			
$checkbalance = $aaaa-$daycost;

if($checkbalance > 0 && $billing_type == 'Prepaid' || $billing_type == 'Postpaid'){
		if($p_id != ''){
			if($mac_user == '1'){
				$querywer = "DELETE FROM billing_mac WHERE c_id = '$new_id'";
				$resultefg = mysql_query($querywer) or die("inser_query failed: " . mysql_error() . "<br />");
				if ($resultefg)
					{
						$querywerff = "DELETE FROM billing_mac_client WHERE c_id = '$new_id'";
						$resultefgff = mysql_query($querywerff) or die("inser_query failed: " . mysql_error() . "<br />");
					}
			}
			else{
					$querywer = "DELETE FROM billing WHERE c_id = '$new_id'";
					$resultefg = mysql_query($querywer) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			if ($resultefg)
			{
				$queryrtrts="UPDATE clients SET
				z_id = '$z_id',
				com_id = '$com_id',
				box_id = '',
				technician = '',
				bill_man = '',
				req_cable = '',
				signup_fee = '',
				note = '$note',
				payment_deadline = '',
				p_id = '$p_id',
				mac_user = '1',
				termination_date = '$termination_date',
				b_date = '',
				c_terminate = '0',
				c_terminate_date_time = '0000-00-00',
				c_terminate_by = ''

				WHERE c_id = '$c_id'";

			$resultffhr = mysql_query($queryrtrts) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($resultffhr)
			{
				$queryefkl="UPDATE login SET log_sts  = '1'	WHERE e_id = '$new_id'";
				$result1dd = mysql_query($queryefkl) or die("inser_query failed: " . mysql_error() . "<br />");
			}
			
			if($qcalculation == 'Manual')
			{
				$dis_price = $p_price_reseller;
				$query20r = "insert into billing_mac_client (c_id, bill_date, p_id, p_price, bill_amount) VALUES ('$new_id', '$entry_date', '$p_id', '$p_price_reseller', '$p_price_reseller')";
				if (!mysql_query($query20r)){
					die('Error: ' . mysql_error());
				}
			}
			
			if($qcalculation == 'Auto')
			{
			$todayy = date('d', time());
			$lastdayofthismonth = date('t');
			$aa = $lastdayofthismonth - $todayy;

			$onedaynewprice = $p_price_reseller / $lastdayofthismonth;
			$unusedday = $aa * $onedaynewprice;
			$discountt = $p_price_reseller - $unusedday;
			
				$query20r = "insert into billing_mac_client (c_id, bill_date, p_id, p_price, discount, bill_amount) VALUES ('$new_id', '$entry_date', '$p_id', '$p_price_reseller', '$discountt', '$unusedday')";
				if (!mysql_query($query20r)){
					die('Error: ' . mysql_error());
				}
			}
			$sqlqqrrm = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$new_id' AND start_date = '$todayyyy'");
			if(mysql_num_rows($sqlqqrrm)<=0){
			$query2 = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time) VALUES ('$new_id', '$z_id', '$p_id', '$todayyyy', '$todayyyy_time', '$termination_date', '$durationn', '$ppriceee', '$daycost', '$entry_by', '$todayyyy', '$todayyyy_time')";
			if (!mysql_query($query2)){
				die('Error: ' . mysql_error());
			}}
			
			$query20 = "UPDATE emp_info SET last_id = '$com_id' WHERE z_id = '$z_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}}
			
			if($mk_profile != $old_mk_profile){
				if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
					$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $new_id,));
					$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => $mk_profile));
					
					$API->disconnect();
				}
			}
			}
		else{
			echo 'Invilade Id';
		}
?>

<html>
<body>
     <form action="Clients" method="post" name="cus_id">
       <input type="hidden" name="new_id" value="<?php echo $new_id; ?>">
	   <input type="hidden" name="sts" value="trnsferdone">
     </form>

     <script language="javascript" type="text/javascript">
		document.cus_id.submit();
     </script>
     <noscript><input type="submit" value="<? echo $new_id; ?>"></noscript>
</body>
</html>

<?php

}
else{echo 'Have not sufficient balance.';}
}
}
else{
$sqlqqff = mysql_query("SELECT mk_profile, p_price FROM package WHERE p_id = '$p_id'");
$row22sss = mysql_fetch_assoc($sqlqqff);
$p_price = $row22sss['p_price'];
$mk_profile = $row22sss['mk_profile'];

$sql2oo ="SELECT last_id FROM app_config";

$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['last_id'];
$com_idff = $idzff + 1;

if($p_id != ''){
$querywerww = "DELETE FROM billing_mac WHERE c_id = '$new_id'";
$resultefgaa = mysql_query($querywerww) or die("inser_query failed: " . mysql_error() . "<br />");

if ($resultefgaa)
	{
		$querywerff = "DELETE FROM billing_mac_client WHERE c_id = '$new_id'";
		$resultefgff = mysql_query($querywerff) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$queryrtrtsaa="UPDATE clients SET
				z_id = '$z_id',
				com_id = '$com_idff',
				mk_id = '$mk_id',
				termination_date = '0000-00-00',
				p_id = '$p_id',
				mac_user = '0',
				c_terminate = '0',
				c_terminate_date_time = '0000-00-00',
				c_terminate_by = ''

				WHERE c_id = '$new_id'";
		$resultffhr = mysql_query($queryrtrtsaa) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($resultffhr)
			{
				$query20grg = "UPDATE app_config SET last_id = '$com_idff'";
					if (!mysql_query($query20grg)){
						die('Error: ' . mysql_error());
					}
					
				$query2reyey = "insert into billing (c_id, bill_date, p_id, p_price, bill_amount) VALUES ('$new_id', '$todayyyy', '$p_id', '$p_price', '$p_price')";
				if (!mysql_query($query2reyey)){
					die('Error: ' . mysql_error());
				}
			}
		
		if($resultffhr)
			{
				$queryefkl="UPDATE login SET log_sts  = '0'	WHERE e_id = '$new_id'";
				$result1dd = mysql_query($queryefkl) or die("inser_query failed: " . mysql_error() . "<br />");
			}
		
		$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
			$rowmk = mysql_fetch_assoc($sqlmk);
					
			$ServerIP = $rowmk['ServerIP'];
			$Username = $rowmk['Username'];
			$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
			$Port = $rowmk['Port']; 
					
			$API = new routeros_api();
			$API->debug = false;
		
		if($mk_id != $old_mk_id){
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
			$nombre =  $new_id;
			$password = $passid;
			$service = 'pppoe';
			$profile = $mk_profile;
			
			$API->comm("/ppp/secret/add", array(
			  "name"     => $nombre,
			  "password" => $password,
			  "profile"  => $profile,
			  "service"  => $service,
			));
			
			$API->disconnect();
		}
		}
		
		if($mk_profile != $old_mk_profile){
				if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
					$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $new_id,));
					$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => $mk_profile));
					
			$API->disconnect();
		}
		}
	}

}

?>

<html>
<body>
     <form action="Clients" method="post" name="cus_id">
       <input type="hidden" name="new_id" value="<?php echo $new_id; ?>">
	   <input type="hidden" name="sts" value="owntrnsferdone">
     </form>

     <script language="javascript" type="text/javascript">
		document.cus_id.submit();
     </script>
     <noscript><input type="submit" value="<? echo $new_id; ?>"></noscript>
</body>
</html>

<?php
}
?>