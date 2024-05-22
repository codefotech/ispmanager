<?php
session_start();
extract($_POST);
$eee_id = $_SESSION['SESS_EMP_ID'];
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

ini_alter('date.timezone','Asia/Almaty');
$todayyyy = date('Y-m-d', time());
$todayyyy_time = date('H:i:s', time());
$bill_date_time = date('Y-m-d H:i:s', time());
$yesterday_date = date('Y-m-d', strtotime($todayyyy . " - 1 day"));
$yf_date = date('Y-m-d', strtotime($todayyyy . " - 2 day"));

		$slno = $_POST['slno'];
		$cid  = $_POST['c_id'];
		$passwordd = $_POST['password'];
		$macc = $_POST['mac'];
		$ipp = $_POST['ip'];
		$p_idd = $_POST['p_id'];
		$p_pricee = $_POST['p_price'];
		$mk_id = $_POST['mk_id'];
		$z_id = $_POST['z_id'];
		$radiofield = $_POST['radiofield'];
		$inputcvb = $_POST['input'];

if($inputcvb == 'reseller'){
		$p_price_resellerr = $_POST['p_price_reseller'];
		$f_date = $_POST['f_date'];
		
		$termination_date = $_POST['t_date'];
		$durationn = floor($_POST['duration']);
			
if($mk_id != '' && $z_id != '' && $f_date != '' && $termination_date != '' && $durationn != '' && $radiofield != '' && $f_date <= $termination_date){
	foreach($slno as $key => $value){
		
		$cidd = $cid[$value];
		$passworddd = $passwordd[$value];
		$pass = sha1($passworddd);
		
		$maccc = $macc[$value];
		$ippp = $ipp[$value];
		$p_iddd = $p_idd[$value];
		$p_priceee = $p_pricee[$value];
		$p_price_resellerrr = $p_price_resellerr[$value];
		
		$query2oo = mysql_query("SELECT last_id FROM emp_info WHERE z_id = '$z_id'");
		$row2ff = mysql_fetch_assoc($query2oo);
		$lastid = $row2ff['last_id'];
		$com_id = $lastid + 1;

		$packageoneday = $p_priceee/30;
		$daycost = $durationn*$packageoneday;
				
		$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$cidd'");
		$rowc = mysql_fetch_assoc($sqlc);
		
		if($rowc['user_id'] == ''){
			if($radiofield == 'but_disable'){
				$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, join_date, occupation, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$yesterday_date', '1', '$todayyyy', '$occupation', 'Home', 'Shared', '$ippp', '$maccc', 'Inactive', '$p_iddd', 'Home Cash')";
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
			}

			elseif($radiofield == 'without_recharge'){
				$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, join_date, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$termination_date', '1', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', 'Active', '$p_iddd', 'Home Cash')";
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
						VALUES ('$cidd', '$z_id', '$p_iddd', '$f_date', '$todayyyy_time', '$termination_date', '$durationn', '$p_priceee', '0.00', '$eee_id', '$todayyyy', '$todayyyy_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}}
			}
			else{
				$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, termination_date, mac_user, join_date, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$termination_date', '1', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', 'Active', '$p_iddd', 'Home Cash')";
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
						VALUES ('$cidd', '$z_id', '$p_iddd', '$f_date', '$todayyyy_time', '$termination_date', '$durationn', '$p_priceee', '$daycost', '$eee_id', '$todayyyy', '$todayyyy_time')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}}
			}
			
			$query20 = "UPDATE emp_info SET last_id = '$com_id' WHERE z_id = '$z_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
		} 
		else{ 
			echo 'Client ID Already Existed';
		}
	}
?>
<html>
<body>
    <form action="NetworkImportClients?id=<?php echo $mk_id;?>&input=<?php echo $inputcvb;?>&zid=<?php echo $z_id;?>" method="post" name="ok">
       <input type="hidden" name="sts" value="Successfully">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php 

} else{echo 'Something Wrong....';}
}
else{
	
$payment_deadlinee = $_POST['payment_deadline'];	
$payment_deadline1 = $_POST['payment_deadline1'];	
$con_stss = $_POST['con_sts'];

if($mk_id != '' && $z_id != ''){
	foreach($slno as $key => $value){
		
		$cidd = $cid[$value];
		$con_stsss = $con_stss[$value];
		$passworddd = $passwordd[$value];
		$pass = sha1($passworddd);
		
		$maccc = $macc[$value];
		$ippp = $ipp[$value];
		$p_iddd = $p_idd[$value];
		$p_priceee = $p_pricee[$value];
		$payment_deadlineee = $payment_deadlinee[$value];
		
		if($payment_deadlineee == ''){
			$payment_deadlineeee = $payment_deadline1;
		}
		else{
			$payment_deadlineeee = $payment_deadlineee;
		}
		
		$query2oo = mysql_query("SELECT last_id FROM app_config");
		$row2ff = mysql_fetch_assoc($query2oo);
		$lastid = $row2ff['last_id'];
		$com_id = $lastid + 1;

		$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$cidd'");
		$rowc = mysql_fetch_assoc($sqlc);
		
		if($rowc['user_id'] == ''){
			$query = "insert into clients (c_id, com_id, c_name, z_id, mk_id, payment_deadline, b_date, join_date, con_type, connectivity_type, ip, mac, con_sts, p_id, p_m, entry_by, entry_date, entry_time)
						  VALUES ('$cidd', '$com_id', '$cidd', '$z_id', '$mk_id', '$payment_deadlineeee', '$payment_deadlineeee', '$todayyyy', 'Home', 'Shared', '$ippp', '$maccc', '$con_stsss', '$p_iddd', 'Home Cash', '$eee_id', '$todayyyy', '$todayyyy_time')";
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
			}
			else{
				$sqlqqrrm = mysql_query("SELECT id FROM billing WHERE c_id = '$cidd'");
				if(mysql_num_rows($sqlqqrrm)<=0){
				$query20r = "insert into billing (c_id, bill_date, p_id, p_price, bill_amount, bill_date_time) 
				VALUES ('$cidd', '$todayyyy', '$p_iddd', '$p_priceee', '$p_priceee', '$bill_date_time')";
					if (!mysql_query($query20r)){
						die('Error: ' . mysql_error());
					}}
			}
			
			$query20 = "UPDATE app_config SET last_id = '$com_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
		}
		else{ 
			echo 'Client ID Already Existed';
		}
	}
?>
<html>
<body>
    <form action="NetworkImportOwnClients?id=<?php echo $mk_id;?>&input=<?php echo $inputcvb;?>" method="post" name="ok">
       <input type="hidden" name="sts" value="Successfully">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php 

} else{echo "Select a Zone Please....";}
}
?>