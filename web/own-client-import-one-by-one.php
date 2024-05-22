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
		
		$payment_deadline = $_POST['payment_deadline'];
		$radiofield=$_POST['radiofield'];
		$z_id = $_POST['z_id'];
		$mk_id = $_POST['mk_id'];
		$cidd = $_POST['c_id'];
		$comment = $_POST['comment'];
		$passworddd = $_POST['password'];
		$pass = sha1($passworddd);
		
		$maccc = $_POST['mac'];
		$ippp = $_POST['ip'];
		$con_sts = $_POST['con_sts'];
		$p_iddd = $_POST['p_id'];
		$p_priceee = $_POST['p_price'];

		$query2oo = mysql_query("SELECT last_id FROM app_config");
		$row2ff = mysql_fetch_assoc($query2oo);
		$idzff = $row2ff['last_id'];
		$com_id = $idzff + 1;
		
		$query2ooss = mysql_query("SELECT z_name FROM zone WHERE z_id = '$z_id'");
		$row2ffdd = mysql_fetch_assoc($query2ooss);
		$zname = $row2ffdd['z_name'];
				
		$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$cidd'");
		$rowc = mysql_fetch_assoc($sqlc);
		
		if($rowc['user_id'] == ''){
			if($z_id != '' && $mk_id != ''){
			$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, payment_deadline, b_date, join_date, con_type, connectivity_type, ip, mac, con_sts, cable_type, p_id, p_m, entry_by, entry_date, entry_time, note)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$payment_deadline', '$payment_deadline', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', '$con_sts', 'UTP', '$p_iddd', 'Home Cash', '$eee_id', '$todayyyy', '$todayyyy_time', '$comment')";
				$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
				if ($result){
					$query1 = "insert into login (user_name, e_id, user_id, password, user_type, log_sts, pw) VALUES ('$cidd', '$cidd', '$cidd', '$pass', 'client', '0', '$passworddd')";
					$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
			if($radiofield == 'without_bill'){
				$sqlqqrrm = mysql_query("SELECT id FROM billing WHERE c_id = '$cidd'");
				if(mysql_num_rows($sqlqqrrm)<=0){
				$query20r = "insert into billing (c_id, bill_date, p_id, p_price, bill_amount, bill_date_time)
						VALUES ('$cidd', '$todayyyy', '$p_iddd', '$p_priceee', '0.00', '$bill_date_time')";
					if (!mysql_query($query20r)){
						die('Error: ' . mysql_error());
					}
				}
				$errormsg = 'DONE';
			}
			else{
				$sqlqqrrm = mysql_query("SELECT id FROM billing WHERE c_id = '$cidd'");
				if(mysql_num_rows($sqlqqrrm)<=0){
				$query20r = "insert into billing (c_id, bill_date, p_id, p_price, bill_amount, bill_date_time) 
				VALUES ('$cidd', '$todayyyy', '$p_iddd', '$p_priceee', '$p_priceee', '$bill_date_time')";
					if (!mysql_query($query20r)){
						die('Error: ' . mysql_error());
					}}
				$errormsg = 'DONE';
			}
			
			$query20 = "UPDATE app_config SET last_id = '$com_id'";
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
	echo json_encode(array("z_name" => $zname,"cidd" => $cidd,"p_priceee" => $p_priceee,"payment_deadline" => $payment_deadline,"b_date" => $payment_deadline,"errormsg" => $errormsg));
} 
else{
	echo json_encode(array("errormsg" => $errormsg));
}

?>