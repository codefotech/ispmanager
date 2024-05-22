<?php 
session_start();
$eee_id = $_SESSION['SESS_EMP_ID'];
include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$todayyyy = date('Y-m-d', time());
$todayyyy_time = date('H:i:s', time());
$bill_date_time = date('Y-m-d H:i:s', time());
$yesterday_date = date('Y-m-d', strtotime($todayyyy . " - 1 day"));
$yf_date = date('Y-m-d', strtotime($todayyyy . " - 2 day"));
		
		$durationn = $_POST['duration'];
		$radiofield=$_POST['radiofield'];
		$z_id = $_POST['z_id'];
		$mk_id = $_POST['mk_id'];
		$f_date = $_POST['f_date'];
		$t_date = $_POST['t_date'];
		$cidd = $_POST['c_id'];
		$passworddd = $_POST['password'];
		$pass = sha1($passworddd);
		
		$maccc = $_POST['mac'];
		$ippp = $_POST['ip'];
		$con_sts = $_POST['con_sts'];
		$p_iddd = $_POST['p_id'];
		$p_priceee = $_POST['p_price'];
		$p_price_resellerrr = $_POST['p_price_reseller'];
		
		$query2oo = mysql_query("SELECT e.last_id, e.e_name, z.z_name FROM emp_info AS e LEFT JOIN zone AS z ON z.z_id = e.z_id WHERE e.z_id = '$z_id'");
		$row2ff = mysql_fetch_assoc($query2oo);
		$lastid = $row2ff['last_id'];
		$resellernamee = $row2ff['e_name'];
		$zname = $row2ff['z_name'];
		$com_id = $lastid + 1;

		$packageoneday = $p_priceee/30;
		$daycost = $durationn*$packageoneday;
				
		$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$cidd'");
		$rowc = mysql_fetch_assoc($sqlc);
		
$query2asd = mysql_query("SELECT reseller_client_login FROM app_config");
$row2sczsdf = mysql_fetch_assoc($query2asd);
$reseller_client_login = $row2sczsdf['reseller_client_login'];
if($reseller_client_login == '1'){
	$canlog = '0';
}
else{
	$canlog = '1';
}
		
		if($rowc['user_id'] == ''){
			if($z_id != '' && $durationn != '' && $f_date != '' && $t_date != ''){
 			if($radiofield == 'but_disable'){
				$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, join_date, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m, entry_by, entry_date, entry_time)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$yesterday_date', '1', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', 'Inactive', '$p_iddd', 'Home Cash', '$eee_id', '$todayyyy', '$todayyyy_time')";
				$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
				if ($result){
					$query1 = "insert into login (user_name, e_id, user_id, password, user_type, log_sts, pw) VALUES ('$cidd', '$cidd', '$cidd', '$pass', 'client', '$canlog', '$passworddd')";
					$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
				$query20r = "insert into billing_mac_client (c_id, bill_date, p_id, p_price, bill_amount, extra_bill, discount, bill_date_time)
						VALUES ('$cidd', '$todayyyy', '$p_iddd', '$p_price_resellerrr', '0.00', '0.00', '0.00', '$bill_date_time')";
					if (!mysql_query($query20r)){
						die('Error: ' . mysql_error());
					}
				
				$sqlqqrrm = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$cidd'");
				if(mysql_num_rows($sqlqqrrm)<=0){
				$query2 = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time)
					VALUES ('$cidd', '$z_id', '$p_iddd', '$yf_date', '$todayyyy_time', '$yesterday_date', '2', '$p_priceee', '0.00', '$eee_id', '$todayyyy', '$todayyyy_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}}
				
				$errormsg = 'DONE';
			}

			elseif($radiofield == 'without_recharge'){
				$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, join_date, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m, entry_by, entry_date, entry_time)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$t_date', '1', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', '$con_sts', '$p_iddd', 'Home Cash', '$eee_id', '$todayyyy', '$todayyyy_time')";
				$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
				if ($result){
					$query1 = "insert into login (user_name, e_id, user_id, password, user_type, log_sts, pw) VALUES ('$cidd', '$cidd', '$cidd', '$pass', 'client', '$canlog', '$passworddd')";
					$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
				$query20r = "insert into billing_mac_client (c_id, bill_date, p_id, p_price, bill_amount, extra_bill, discount, bill_date_time)
						VALUES ('$cidd', '$todayyyy', '$p_iddd', '$p_price_resellerrr', '0.00', '0.00', '0.00', '$bill_date_time')";
					if (!mysql_query($query20r)){
						die('Error: ' . mysql_error());
					}
				
				$sqlqqrrm = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$cidd'");
				if(mysql_num_rows($sqlqqrrm)<=0){
				$query2 = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time)
						VALUES ('$cidd', '$z_id', '$p_iddd', '$f_date', '$todayyyy_time', '$t_date', '$durationn', '$p_priceee', '0.00', '$eee_id', '$todayyyy', '$todayyyy_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}}
				
				$errormsg = 'DONE';
			}
			else{
				$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, join_date, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m, entry_by, entry_date, entry_time)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$t_date', '1', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', '$con_sts', '$p_iddd', 'Home Cash', '$eee_id', '$todayyyy', '$todayyyy_time')";
				$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
				if ($result){
					$query1 = "insert into login (user_name, e_id, user_id, password, user_type, log_sts, pw) VALUES ('$cidd', '$cidd', '$cidd', '$pass', 'client', '$canlog', '$passworddd')";
					$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
				$query20r = "insert into billing_mac_client (c_id, bill_date, p_id, p_price, bill_amount, extra_bill, discount, bill_date_time) VALUES ('$cidd', '$todayyyy', '$p_iddd', '$p_price_resellerrr', '$p_price_resellerrr', '0.00', '0.00', '$bill_date_time')";
					if (!mysql_query($query20r)){
						die('Error: ' . mysql_error());
					}
				
				$sqlqqrrm = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$cidd'");
				if(mysql_num_rows($sqlqqrrm)<=0){
				$query2 = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time)
						VALUES ('$cidd', '$z_id', '$p_iddd', '$f_date', '$todayyyy_time', '$t_date', '$durationn', '$p_priceee', '$daycost', '$eee_id', '$todayyyy', '$todayyyy_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}}
				
				$errormsg = 'DONE';
			}
			
			$query20 = "UPDATE emp_info SET last_id = '$com_id' WHERE z_id = '$z_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
		}
		else{
			$errormsg = 'Not Possible';
		}
		}
		else{ 
			$errormsg = 'Already Existed';
		}


if($errormsg == 'DONE'){
	if($durationn > 0 || $durationn != ''){
	echo json_encode(array("z_name" => $zname,"resellernamee" => $resellernamee,"cidd" => $cidd,"p_priceee" => $p_priceee,"t_date" => $t_date,"errormsg" => $errormsg));
	}
} 
else{
	echo json_encode(array("errormsg" => $errormsg));
}

?>