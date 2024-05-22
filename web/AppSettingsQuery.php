<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
include("conn/connection.php");
extract($_POST);
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

if($way == 'basic'){
		$query ="update app_config set name = '$name', postal_code = '$postal_code', fax = '$fax', website = '$website', address = '$address', address2 = '$address2', latitude = '$latitude', longitude = '$longitude', phone = '$phone', division_id = '$division_id', district_id = '$district_id', upazila_id = '$upazila_id', union_id = '$union_id' WHERE tis_id = '$tis_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="AppSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Basic Informations">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'owner'){
		$query ="update app_config set owner_name = '$owner_name', copmaly_boss_cell = '$copmaly_boss_cell', com_email = '$com_email' WHERE tis_id = '$tis_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="AppSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Owner Informations">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}
			
if($way == 'backup'){
		$query ="update app_config set email = '$email' WHERE tis_id = '$tis_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="AppSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Backup Informations">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Gateway'){
	if($bkmerchant_number != '' && $bkapp_key != '' && $bkapp_secret != '' && $bkusername != '' && $bkpassword != '' && $bkbank != '' && $bkcharge_sts != '' && $bkcharge != ''){
		$query ="update payment_online_setup set merchant_number = '$bkmerchant_number', app_key = '$bkapp_key', app_secret = '$bkapp_secret', username = '$bkusername', password = '$bkpassword', bank = '$bkbank', charge_sts = '$bkcharge_sts', charge = '$bkcharge', sts = '$bksts', webhook_sts = '$bkwebhook_sts' WHERE id = '$bkid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$query ="update payment_online_setup set sts = '$bksts' WHERE id = '$bkid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	
	if($bkmerchant_numbert != '' && $bkapp_keyt != '' && $bkapp_secrett != '' && $bkusernamet != '' && $bkpasswordt != '' && $bkbankt != '' && $bkcharge_stst != '' && $bkcharget != ''){
		$queryt ="update payment_online_setup set merchant_number = '$bkmerchant_numbert', app_key = '$bkapp_keyt', app_secret = '$bkapp_secrett', username = '$bkusernamet', password = '$bkpasswordt', bank = '$bkbankt', charge_sts = '$bkcharge_stst', charge = '$bkcharget', sts = '$bkstst' WHERE id = '$bkidt'";
		$resultt = mysql_query($queryt) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$queryt ="update payment_online_setup set sts = '$bkstst' WHERE id = '$bkidt'";
		$resultt = mysql_query($queryt) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	
	if($rocketmerchant_number != '' && $rocketbank != '' && $rocketcharge_sts != '' && $rocketcharge != ''){
		$query11 ="update payment_online_setup set merchant_number = '$rocketmerchant_number', bank = '$rocketbank', charge_sts = '$rocketcharge_sts', charge = '$rocketcharge', sts = '$rocketsts', webhook_sts = '$rockewebhook_sts' WHERE id = '$rocketid'";
		$result11 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$query11 ="update payment_online_setup set sts = '$rocketsts' WHERE id = '$rocketid'";
		$result11 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	
	if($nagadmerchant_number != '' && $nagadbank != '' && $nagadcharge_sts != '' && $nagadcharge != ''){
		$query1122 ="update payment_online_setup set merchant_number = '$nagadmerchant_number', bank = '$nagadbank', charge_sts = '$nagadcharge_sts', charge = '$nagadcharge', sts = '$nagadsts', webhook_sts = '$agadwebhook_sts' WHERE id = '$nagadid'";
		$result1122 = mysql_query($query1122) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$query1122 ="update payment_online_setup set sts = '$nagadsts' WHERE id = '$nagadid'";
		$result1122 = mysql_query($query1122) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	
	if($ipaymerchant_number != '' && $ipayapp_key != '' && $ipaybank != '' && $ipaycharge_sts != '' && $ipaycharge != ''){
		$query33 ="update payment_online_setup set merchant_number = '$ipaymerchant_number', app_key = '$ipayapp_key', bank = '$ipaybank', charge_sts = '$ipaycharge_sts', charge = '$ipaycharge', sts = '$ipaysts', webhook_sts = '$ipaywebhook_sts' WHERE id = '$ipayid'";
		$result33 = mysql_query($query33) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$query33 ="update payment_online_setup set sts = '$ipaysts' WHERE id = '$ipayid'";
		$result33 = mysql_query($query33) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	
	if($sslmerchant_number != '' && $sslstore_id != '' && $sslpassword != '' && $sslbank != '' && $sslcharge_sts != '' && $sslcharge != ''){
		$query330 ="update payment_online_setup set merchant_number = '$sslmerchant_number', store_id = '$sslstore_id', password = '$sslpassword', bank = '$sslbank', charge_sts = '$sslcharge_sts', charge = '$sslcharge', sts = '$sslsts', webhook_sts = '$sslwebhook_sts' WHERE id = '$sslid'";
		$result330 = mysql_query($query330) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$query330 ="update payment_online_setup set sts = '$sslsts' WHERE id = '$sslid'";
		$result330 = mysql_query($query330) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	
	$queryfghgc ="update app_config set external_online_link = '$external_online_link_sts', external_online_link_mac = '$external_online_link_mac_sts'";
	$resultfsdf = mysql_query($queryfghgc) or die("inser_query failed: " . mysql_error() . "<br />");
	
	$queryex1 = mysql_query("update external_access set show_sts = '$a101' WHERE id = '1'");
	$queryex2 = mysql_query("update external_access set show_sts = '$a102' WHERE id = '2'");
	$queryex3 = mysql_query("update external_access set show_sts = '$a103' WHERE id = '3'");
	$queryex4 = mysql_query("update external_access set show_sts = '$a104' WHERE id = '4'");
	$queryex5 = mysql_query("update external_access set show_sts = '$a105' WHERE id = '5'");
	$queryex6 = mysql_query("update external_access set show_sts = '$a106' WHERE id = '6'");
	$queryex7 = mysql_query("update external_access set show_sts = '$a107' WHERE id = '7'");
	$queryex8 = mysql_query("update external_access set show_sts = '$a108' WHERE id = '8'");
	$queryex9 = mysql_query("update external_access set show_sts = '$a109' WHERE id = '9'");
	$queryex10 = mysql_query("update external_access set show_sts = '$a110' WHERE id = '10'");
	
		if($result || $result11 || $result1122 || $result33 || $result330)
			{
?>
<html>
<body>
    <form action="AppSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Gateway">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'sms'){
		$query ="update sms_setup set link = '$link', username = '$username', password = '$password' WHERE id = '1'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="AppSettings" method="post" name="ok">
		<input type="hidden" name="way" value="SMS API">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'telegram'){
	if($sts == '0'){
		$query ="update telegram_setup set t_link = '$t_link', bot_id = '$bot_id', chat_id = '$chat_id', sts = '$sts', add_user = '$add_user', add_user_chat_id = '$add_user_chat_id', add_payment = '$add_payment', add_payment_chat_id = '$add_payment_chat_id', webhook_client_payment = '$webhook_client_payment', webhook_client_payment_chat_id = '$webhook_client_payment_chat_id', webhook_reseller_recharge = '$webhook_reseller_recharge', webhook_reseller_recharge_chat_id = '$webhook_reseller_recharge_chat_id', client_status = '$client_status', client_status_chat_id = '$client_status_chat_id', expense_sts = '$expense_sts', expense_sts_chat_id = '$expense_sts_chat_id', client_recharge = '$client_recharge', client_recharge_chat_id = '$client_recharge_chat_id', instruments_in_sts = '$instruments_in_sts', instruments_in_chat_id = '$instruments_in_chat_id', instruments_out_sts = '$instruments_out_sts', instruments_out_chat_id = '$instruments_out_chat_id', fund_transfer_sts = '$fund_transfer_sts', fund_transfer_chat_id = '$fund_transfer_chat_id', onu_ping_check = '$onu_ping_check', onu_ping_check_chat_id = '$onu_ping_check_chat_id' WHERE id = '1'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	else{
		$query ="update telegram_setup set sts = '$sts' WHERE id = '1'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
		if ($result)
			{
?>
<html>
<body>
    <form action="AppSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Telegram API">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'others'){
		$query ="update app_config set last_id = '$last_id', ppoe_comment = '$ppoe_comment', use_diagram_client = '$use_diagram_client', client_terminate = '$client_terminate', reseller_downgrade = '$reseller_downgrade', location_service = '$location_service', onlineclient_sts = '$onlineclient_sts', search_with_reseller = '$search_with_reseller', active_queue = '$active_queue', edit_last_id = '$edit_last_id', invoice_logo_size = '$invoice_logo_sizee', invoice_note1 = '$invoice_notee1', invoice_note2 = '$invoice_notee2', invoice_note3 = '$invoice_notee3', invoice_note4 = '$invoice_notee4', invoice_note5 = '$invoice_notee5' WHERE tis_id = '$tis_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="AppSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Others Settings">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'admin'){
	$chat_access = implode(',', $_POST['chat_access']);
	if($tree_sts_copmaly == '0'){
		$query55 ="update app_config set tree_sts = '$tree_sts_copmaly', tis_api = '$tis_api', inactive_way = '$inactive_way', online_off = '$online_btns_off', realtime_graph = '$realtime_graph', cpu = '$cpu_load', cpu_interval = '$cpu_interval', reseller_per_del = '$reseller_per_deletee', delete_reseller_till = '$delete_reseller_till', clients_per_del = '$clients_per_deletee', delete_clients_till = '$delete_clients_till', onlineclient_search_sts = '$onlineclient_search_sts', minimize_load = '$minimize_loaddd', reseller_client_login = '$reseller_client_loginn', reseller_client_online_payment_sts = '$reseller_client_online_payment_stss', chat_access = '$chat_access' WHERE tis_id = '$tis_id'";
	}
	else{
		$query55 ="update app_config set use_diagram_client = '0', location_service = '0', tis_api = '$tis_api', tree_sts = '$tree_sts_copmaly', online_off = '$online_btns_off', inactive_way = '$inactive_way', realtime_graph = '$realtime_graph', cpu = '$cpu_load', cpu_interval = '$cpu_interval', reseller_per_del = '$reseller_per_deletee', delete_reseller_till = '$delete_reseller_till', clients_per_del = '$clients_per_deletee', delete_clients_till = '$delete_clients_till', onlineclient_search_sts = '$onlineclient_search_sts', minimize_load = '$minimize_loaddd', reseller_client_login = '$reseller_client_loginn', reseller_client_online_payment_sts = '$reseller_client_online_payment_stss', chat_access = '$chat_access' WHERE tis_id = '$tis_id'";
	}
		$result55 = mysql_query($query55) or die("inser_query failed: " . mysql_error() . "<br />");
		
if($result55){
		if($reseller_client_loginn == '1'){
			$result55ff = mysql_query("UPDATE login SET log_sts = '0' WHERE e_id IN (SELECT c_id AS e_id FROM clients WHERE mac_user = '1' AND sts = '0')");
		}
		else{
			$result55ff = mysql_query("UPDATE login SET log_sts = '1' WHERE e_id IN (SELECT c_id AS e_id FROM clients WHERE mac_user = '1')");
		}

		if($external_online_link_mac_sts == '1'){
			$resultfsdf = mysql_query("update app_config set external_online_link_mac = '1'");
		}
		else{
			$resultfsdf = mysql_query("update app_config set external_online_link_mac = '0'");
		}
		?>
		<html>
		<body>
			<form action="AppSettings" method="post" name="ok">
				<input type="hidden" name="way" value="admin">
			</form>
			<script language="javascript" type="text/javascript">
				document.ok.submit();
			</script>
		</body>
		</html>
<?php
}
		else
			{
				echo 'Error, Please try again';
			}
}

//----------------SMS Setup Start---------------------------------------------------
if($z_id == ''){
if($way == 'Add Client'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg' WHERE id = '$sms_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="<?php echo $way;?>">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Auto_Inactive'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg', send_sts = '$send_sts', accpt_amount = '$accpt_amount', sts = '$sts', time_hr = '$time_hr', time_min = '$time_min' WHERE id = '$sms_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Auto Inactive SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Due Bill'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg', send_sts = '$send_sts' WHERE id = '$sms_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Due Bill SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Bill Payment'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg' WHERE id = '$sms_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		$query11 ="UPDATE sms_msg SET sms_msg = '$sms_msg1' WHERE id = '$sms_id1'";
		$result11 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Bill Payment SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Others Collection'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg_client' WHERE id = '$sms_cid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$queryqq ="UPDATE sms_msg SET sms_msg = '$sms_msg_extra' WHERE id = '$sms_ext'";
		$result11 = mysql_query($queryqq) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Others Collection SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Support'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg_client' WHERE id = '$sms_cid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$queryqq ="UPDATE sms_msg SET sms_msg = '$sms_msg_assign' WHERE id = '$sms_ext'";
		$result11 = mysql_query($queryqq) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Support SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}
if($way == 'Reseller Payment'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg' WHERE id = '$sms_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		$query2 ="UPDATE sms_msg SET sms_msg = '$sms_msg1' WHERE id = '$sms_id1'";
		$result2 = mysql_query($query2) or die("inser_query failed: " . mysql_error() . "<br />");
		
		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Reseller Payment SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Generate Bill'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg', send_sts = '$send_sts' WHERE id = '$sms_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Generate Bill SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}

if($way == 'Bill Rimainder'){
	if($day_2 > '0'){
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg_2', send_sts = '$send_sts_2', day = '$day_2', time_hr = '$time_hr_2', time_min = '$time_min_2' WHERE id = '13'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
	if($day_1 > '0'){
		$queryws ="UPDATE sms_msg SET sms_msg = '$sms_msg_1', send_sts = '$send_sts_1', day = '$day_1', time_hr = '$time_hr_1', time_min = '$time_min_1' WHERE id = '12'";
		$result1 = mysql_query($queryws) or die("inser_query failed: " . mysql_error() . "<br />");
	}
		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="Bill Rimainder SMS">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}
}
}
else{
		$query ="UPDATE sms_msg SET sms_msg = '$sms_msg', send_sts = '$send_sts' WHERE id = '$sms_id' AND z_id = '$z_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result)
			{
?>
<html>
<body>
    <form action="SMSSettings" method="post" name="ok">
		<input type="hidden" name="way" value="<?php echo $way;?>">
    </form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
</body>
</html>
<?php
			}
		else
			{
				echo 'Error, Please try again';
			}

}
mysql_close($con);
?>