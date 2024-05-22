<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
	
include("conn/connection.php");
include("mk_api.php");
extract($_POST); 

$sqlmkhhdd = mysql_query("SELECT `user_type` FROM `login` WHERE `user_id` = '$old_c_id'");
		$rowmkccii = mysql_fetch_assoc($sqlmkhhdd);
		$usertype = $rowmkccii['user_type'];

if($usertype == 'client'){
$sqlmkhh = mysql_query("SELECT id, c_id, mk_id FROM clients WHERE c_id = '$old_c_id'");
		$rowmkcc = mysql_fetch_assoc($sqlmkhh);
		$mkid = $rowmkcc['mk_id'];
		
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkid'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port']; 
		
			$API = new routeros_api();
			$API->debug = false;
				if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
						$arrID =	$API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $old_c_id,));
									$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"name" => $c_id));
						$API->disconnect();

					$query = "UPDATE billing SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if(!mysql_query($query))
					{
						die('Error: ' . mysql_error());
					}
					
					$query_dwidth = "UPDATE client_bandwidth SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if(!mysql_query($query_dwidth))
					{
						die('Error: ' . mysql_error());
					}
					
					$query_mc = "UPDATE billing_mac_client SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if(!mysql_query($query_mc))
					{
						die('Error: ' . mysql_error());
					}
					
					$query1 = "UPDATE billing_mac SET c_id ='$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query1))
					{
						die('Error: ' . mysql_error());

					}

					$query2 = "UPDATE clients SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
						if (!mysql_query($query2))
					{
						die('Error: ' . mysql_error());
					}
				
					$query3 = "UPDATE complain_detail SET rep_by = '$c_id' WHERE rep_by = '$old_c_id'";
					if (!mysql_query($query3))
					{
						die('Error: ' . mysql_error());
					}
					
					$query4 = "UPDATE complain_master SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query4))
					{
						die('Error: ' . mysql_error());
					}

					$query6 = "UPDATE con_sts_log SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query6))
					{
						die('Error: ' . mysql_error());
					}
					
					$query8 = "UPDATE login SET e_id = '$c_id', user_id = '$c_id' WHERE user_id = '$old_c_id'";
					if (!mysql_query($query8))
					{
						die('Error: ' . mysql_error());
					}
					
					$query9 = "UPDATE log_info SET u_id = '$c_id' WHERE u_id = '$old_c_id'";
					if (!mysql_query($query9))
					{
						die('Error: ' . mysql_error());
					}
					
					$query10 = "UPDATE package_change SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query10))
					{
						die('Error: ' . mysql_error());
					}
					
					$query11 = "UPDATE payment SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query11))
					{
						die('Error: ' . mysql_error());
					}
					
					$query12 = "UPDATE payment_delete SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query12))
					{
						die('Error: ' . mysql_error());
					}
					
					$query13 = "UPDATE sms_send SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query13))
					{
						die('Error: ' . mysql_error());
					}

					$query15 = "UPDATE store_out_instruments SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query15))
					{
						die('Error: ' . mysql_error());
					}
					
					$query16 = "UPDATE store_out_fiber SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query16))
					{
						die('Error: ' . mysql_error());
					}
					
					$query20 = "UPDATE bill_signup SET c_id = '$c_id' WHERE c_id = '$old_c_id'";
					if (!mysql_query($query20))
					{
						die('Error: ' . mysql_error());
					}
					
					$query1rr5 = "UPDATE bill_signup SET c_id = '$c_id' WHERE c_id = '$old_c_id'";if(!mysql_query($query1rr5)){die('Error: ' . mysql_error());}$query14 = "INSERT INTO username_change (old_c_id, new_c_id, note, change_by) VALUES ('$old_c_id', '$c_id', '$note', '$change_by')";
					if (!mysql_query($query14))
					{
						die('Error: ' . mysql_error());
					}
					if($retarnway == 'ClientEdit'){ ?>
<html>
	<body>
		<form action="ClientEdit" method="post" name="ok">
			<input type="hidden" name="sts" value="change">
			<input type="hidden" name="old_c_idd" value="<?php echo $old_c_id;?>">
			<input type="hidden" name="new_c_id" value="<?php echo $c_id;?>">
			<input type="hidden" name="c_id" value="<?php echo $c_id;?>">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
<?php } else{ ?>
<html>
	<body>
		<form action="Users" method="post" name="ok">
			<input type="hidden" name="sts" value="change">
			<input type="hidden" name="old_c_idd" value="<?php echo $old_c_id;?>">
			<input type="hidden" name="new_c_id" value="<?php echo $c_id;?>">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
				
				<?php }} else{ echo "Error!! No Connected Network Found.";}} else{

$query8 = "UPDATE login SET user_id = '$c_id' WHERE user_id = '$old_c_id'";
					if (!mysql_query($query8))
					{
						die('Error: ' . mysql_error());
					}
					
$query8tg = "UPDATE log_info SET u_id = '$c_id' WHERE u_id = '$old_c_id'";
					if (!mysql_query($query8tg))
					{
						die('Error: ' . mysql_error());
					}

$query14 = "INSERT INTO username_change (old_mreseller_username, new_mreseller_username, note, change_by) VALUES ('$old_c_id', '$c_id', '$note', '$change_by')";
					if (!mysql_query($query14))
					{
						die('Error: ' . mysql_error());
					}
?>
<html>
	<body>
		<form action="Users" method="post" name="ok">
			<input type="hidden" name="sts" value="change">
			<input type="hidden" name="old_c_idd" value="<?php echo $old_c_id;?>">
			<input type="hidden" name="new_c_id" value="<?php echo $c_id;?>">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>

<?php } ?>
