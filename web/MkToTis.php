<?php
include("conn/connection.php") ;
extract($_POST);


$query2gh = mysql_query("SELECT user_limit FROM app_config");
$row2df = mysql_fetch_assoc($query2gh);
$user_limit = $row2df['user_limit'];

$sqllimi = mysql_query("SELECT id FROM clients WHERE sts = '0' AND con_sts = 'Active'");
$total_client = mysql_num_rows($sqllimi);

$limit_access = $user_limit - $total_client;

$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$new_id'");
$rowc = mysql_fetch_assoc($sqlc);

if($limit_access >= '0'){
if($rowc['user_id'] == ''){
	$pass = sha1($passid);
	$new_id = $c_id;
	
$sql2oo ="SELECT last_id FROM app_config";

$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['last_id'];
$com_id = $idzff + 1;
	
$sqlqq = mysql_query("SELECT mk_profile, p_price, p_id FROM package WHERE mk_profile = '$mk_profile' AND z_id = '0' ORDER BY p_price DESC LIMIT 1");
$row22 = mysql_fetch_assoc($sqlqq);

$pppppp_id = $row22['p_id'];
if($con_sts == 'Active'){
$p_priceee = $row22['p_price'];
}
else{
$p_priceee = '0.00';
}
	if($pppppp_id != ''){
		if($new_id != ''){
			
			$query = "insert into clients (c_id, c_name, com_id, z_id, mk_id, box_id, join_date, con_type, connectivity_type, cable_type, con_sts, p_id, p_m, entry_by, entry_date, entry_time)
					  VALUES ('$new_id', '$c_name', '$com_id', '$z_id', '$mk_id', '$box_id', '$join_date', '$con_type', '$connectivity_type', '$cable_type', '$con_sts', '$pppppp_id', '$p_m', '$entry_by', '$entry_date', '$entry_time')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if ($result)
			{
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, pw) VALUES ('$c_name', '$new_id', '$new_id', '$pass', 'client', '$passid')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");

			}
				$query2 = "insert into billing (c_id, bill_date, p_id, p_price, bill_amount) VALUES ('$new_id', '$entry_date', '$pppppp_id', '$p_priceee', '$p_priceee')";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());

			}
			$query20 = "UPDATE app_config SET last_id = '$com_id'";
			if (!mysql_query($query20)){
				die('Error: ' . mysql_error());
			}
			
		}
		else{
			echo 'Invilade Id';
		}
echo '<script type="text/javascript">window.close()</script>';

	}
	else{ echo 'No package found like this profile name ['.$mk_profile.']';}
}
else{
	echo 'Client ID Already Existed';
}
} else{
	echo 'User Limit Exceeded';
}
?>