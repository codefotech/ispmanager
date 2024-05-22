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
		
		
		$cidd = $_POST['c_id'];
		$slid = $_POST['slid'];
		
		
	/*	if($rowc['user_id'] == ''){
			if($z_id != '' && $durationn != '' && $f_date != '' && $t_date != ''){
 			 if($radiofield == 'but_disable'){
				$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, join_date, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m, entry_by, entry_date, entry_time)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$yesterday_date', '1', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', 'Inactive', '$p_iddd', 'Home Cash', '$eee_id', '$todayyyy', '$todayyyy_time')";
				$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
				if ($result){
					$query1 = "insert into login (user_name, e_id, user_id, password, user_type, log_sts, pw) VALUES ('$cidd', '$cidd', '$cidd', '$pass', 'client', '1', '$passworddd')";
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
					$query1 = "insert into login (user_name, e_id, user_id, password, user_type, log_sts, pw) VALUES ('$cidd', '$cidd', '$cidd', '$pass', 'client', '1', '$passworddd')";
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
					$query1 = "insert into login (user_name, e_id, user_id, password, user_type, log_sts, pw) VALUES ('$cidd', '$cidd', '$cidd', '$pass', 'client', '1', '$passworddd')";
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
			$errormsg = 'DONE';
			$undo_btn = "add";
			$fgbnfgn = "ADD";*/
			
			/* $query20 = "UPDATE emp_info SET last_id = '$com_id' WHERE z_id = '$z_id'";
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
		}*/


//if($errormsg == 'DONE'){
//	if($durationn > 0 || $durationn != ''){
	echo json_encode(array("z_name" => $cidd,"slid" => $slid));
//	}
//} 
//else{
//	echo json_encode(array("errormsg" => $errormsg));
//}

?>