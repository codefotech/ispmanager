<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index?way=logout");
		exit();
	}
include("conn/connection.php");
extract($_POST);

$thanaa = implode(',', $_POST['thana']);

if($minimum_day > '0'){

$sqlc = mysql_query("SELECT user_id FROM login WHERE user_id = '$new_id'");
$rowc = mysql_fetch_assoc($sqlc);
if($rowc['user_id'] == ''){
	
$date2 =$_POST['e_j_date'];
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$y = date("Y");
$m = date("m");
$dat = $y.$m;

$sql = ("SELECT id FROM emp_info ORDER BY id DESC LIMIT 1");
		$query2 = mysql_query($sql);
		$row = mysql_fetch_assoc($query2);
		$old_id = $row['id'];
		if($old_id == ''){
			$new_id = $dat.'1';
		}
		else{
			$new = $old_id + 1;
			$new_id = $dat.$new;
		}

$pass = sha1($passid);

 if($mk_id != ''){
	$minimum_days = implode(',', $_POST['minimum_days']);
	
	if($default_logo == '0'){
		$uploadfilem = 'images/logo.png';
		$defaultlogo = '0';
	}
		if($_FILES['reseller_logo']['tmp_name'] != ''){
		$uploaddirm = 'emp_images/';
		$uploadfilem = $uploaddirm . $new_id . '_' . basename($_FILES['reseller_logo']['name']); move_uploaded_file($_FILES['reseller_logo']['tmp_name'], $uploadfilem);
		$defaultlogo = '1';
		}
		else{
			$uploadfilem = 'images/logo.png';
			$defaultlogo = '0';
			}

	 if($_FILES['image']['tmp_name'] != ''){ $uploaddir = 'emp_images/'; $uploadfile = $uploaddir . $new_id . '_' . basename($_FILES['image']['name']); move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);}else {$uploadfile = '';} 
	 
	 
	 $query="insert into emp_info (e_id, e_des, dept_id, mk_id, z_id, billing_type, over_due, e_name, e_f_name, e_m_name, e_b_date, e_j_date, e_gender, married_stu, bgroup, n_id, pre_address, per_address, e_cont_per, e_cont_office, e_cont_family, email, skype, e_image, reseller_logo, default_logo, last_id, minimum_day, minimum_days, minimum_sts, auto_recharge, prefix, com_percent, count_commission, agent_id, whatsapp, note)
			 VALUES
			 ('$new_id', '$e_des', '0', '$mk_id', '$zz_id', '$billing_type', '$over_due', '$e_name', '$e_f_name', '$e_m_name', '$e_b_date', '$e_j_date', '$e_gender', '$married_stu', '$bgroup', '$n_id', '$pre_address', '$per_address', '$e_cont_per', '$e_cont_office', '$e_cont_family', '$email', '$skype', '$uploadfile', '$uploadfilem', '$defaultlogo', '$last_id', '$minimum_day', '$minimum_days', '$minimum_sts', '$auto_recharge', '$prefix', '$com_percent', '$count_commission', '$agent_id', '$whatsapp', '$note')";
	 $result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
			if($result){
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, email, image) VALUES ('$e_name', '$new_id', '$c_id', '$pass', 'mreseller', '$email', '$uploadfile')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
				if($result1){
					$query2 = "insert into zone (z_name, z_bn_name, e_id, thana) VALUES ('$z_name', '$z_bn_name', '$new_id', '$thanaa')";
					$result2 = mysql_query($query2) or die("inser_query failed: " . mysql_error() . "<br />");
				}
			}
	if($result){
			$query244 = mysql_query("SELECT z_id FROM zone WHERE e_id = '$new_id'");
			$row2ss = mysql_fetch_assoc($query244);
			$ziddd = $row2ss['z_id'];
			
			if(empty($_POST['mk_profile1']) || empty($_POST['p_name1']) || empty($_POST['bandwith1']) || empty($_POST['p_price1'])){}
			else{
				$sql_cus1 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus1 = mysql_fetch_array($sql_cus1);
				$p_id1 = $row_cus1['p_id']+1;
				
				$query11 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id1', '$mk_profile1', '$p_name1', '$p_price1', '$bandwith1', '$ziddd', '$mk_id')";
				$result11 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
			if(empty($_POST['mk_profile2']) || empty($_POST['p_name2']) || empty($_POST['bandwith2']) || empty($_POST['p_price2'])){}
			else{
				$sql_cus2 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus2 = mysql_fetch_array($sql_cus2);
				$p_id2 = $row_cus2['p_id']+1;
				
				$query12 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id2', '$mk_profile2', '$p_name2', '$p_price2', '$bandwith2', '$ziddd', '$mk_id')";
				$result12 = mysql_query($query12) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
			if(empty($_POST['mk_profile3']) || empty($_POST['p_name3']) || empty($_POST['bandwith3']) || empty($_POST['p_price3'])){}
			else{
				$sql_cus3 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus3 = mysql_fetch_array($sql_cus3);
				$p_id3 = $row_cus3['p_id']+1;
				
				$query13 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id3', '$mk_profile3', '$p_name3', '$p_price3', '$bandwith3', '$ziddd', '$mk_id')";
				$result13 = mysql_query($query13) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
			if(empty($_POST['mk_profile4']) || empty($_POST['p_name4']) || empty($_POST['bandwith4']) || empty($_POST['p_price4'])){}
			else{
				$sql_cus4 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus4 = mysql_fetch_array($sql_cus4);
				$p_id4 = $row_cus4['p_id']+1;
				
				$query14 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id4', '$mk_profile4', '$p_name4', '$p_price4', '$bandwith4', '$ziddd', '$mk_id')";
				$result14 = mysql_query($query14) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				
			if(empty($_POST['mk_profile5']) || empty($_POST['p_name5']) || empty($_POST['bandwith5']) || empty($_POST['p_price5'])){}
			else{
				$sql_cus5 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus5 = mysql_fetch_array($sql_cus5);
				$p_id5 = $row_cus5['p_id']+1;
				
				$query15 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id5', '$mk_profile5', '$p_name5', '$p_price5', '$bandwith5', '$ziddd', '$mk_id')";
				$result15 = mysql_query($query15) or die("inser_query failed: " . mysql_error() . "<br />");
				}
			if(empty($_POST['mk_profile6']) || empty($_POST['p_name6']) || empty($_POST['bandwith6']) || empty($_POST['p_price6'])){}
			else{
				$sql_cus6 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus6 = mysql_fetch_array($sql_cus6);
				$p_id6 = $row_cus6['p_id']+1;
				
				$query16 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id6', '$mk_profile6', '$p_name6', '$p_price6', '$bandwith6', '$ziddd', '$mk_id')";
				$result16 = mysql_query($query16) or die("inser_query failed: " . mysql_error() . "<br />");
				}
			if(empty($_POST['mk_profile7']) || empty($_POST['p_name7']) || empty($_POST['bandwith7']) || empty($_POST['p_price7'])){}
			else{
				$sql_cus7 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus7 = mysql_fetch_array($sql_cus7);
				$p_id7 = $row_cus7['p_id']+1;
				
				$query17 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id7', '$mk_profile7', '$p_name7', '$p_price7', '$bandwith7', '$ziddd', '$mk_id')";
				$result17 = mysql_query($query17) or die("inser_query failed: " . mysql_error() . "<br />");
				}
			if(empty($_POST['mk_profile8']) || empty($_POST['p_name8']) || empty($_POST['bandwith8']) || empty($_POST['p_price8'])){}
			else{
				$sql_cus8 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
				$row_cus8 = mysql_fetch_array($sql_cus8);
				$p_id8 = $row_cus8['p_id']+1;
				
				$query18 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id8', '$mk_profile8', '$p_name8', '$p_price8', '$bandwith8', '$ziddd', '$mk_id')";
				$result18 = mysql_query($query18) or die("inser_query failed: " . mysql_error() . "<br />");
				}
		}
}
else{
	echo 'Error!! Please Select a Network.';
}	
mysql_close($con);
?>


<html>
<body>
     <form action="MacReseller" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>

<?php } else{ echo 'Username Already Used.';}


} else{ echo 'Minimum Recharge Day are Invalid';}?>