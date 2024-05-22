<?php 		
$query88tt = mysql_query("SELECT * FROM telegram_setup WHERE sts = '0'");
$row88t = mysql_fetch_assoc($query88tt);
		$t_link= $row88t['t_link'];
		$bot_id= $row88t['bot_id'];

if($row88t['add_user_chat_id'] != '' && 'user_add' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['add_user_chat_id'];
}
elseif($row88t['add_payment_chat_id'] != '' && 'payment_add' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['add_payment_chat_id'];
}
elseif($row88t['webhook_client_payment_chat_id'] != '' && 'webhook_client' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['webhook_client_payment_chat_id'];
}
elseif($row88t['webhook_reseller_recharge_chat_id'] != '' && 'webhook_reseller' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['webhook_reseller_recharge_chat_id'];
}
elseif($row88t['client_status_chat_id'] != '' && 'client_status' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['client_status_chat_id'];
}
elseif($row88t['expense_sts_chat_id'] != '' && 'expense_add' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['expense_sts_chat_id'];
}
elseif($row88t['client_recharge_chat_id'] != '' && 'client_recharge' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['client_recharge_chat_id'];
}
elseif($row88t['instruments_in_chat_id'] != '' && 'instruments_in' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['instruments_in_chat_id'];
}
elseif($row88t['instruments_out_chat_id'] != '' && 'instruments_out' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['instruments_out_chat_id'];
}
elseif($row88t['fund_transfer_chat_id'] != '' && 'fund_transfer' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['fund_transfer_chat_id'];
}
elseif($row88t['network_sts_chat_id'] != '' && 'network_down' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['network_sts_chat_id'];
}
elseif($row88t['onu_ping_check_chat_id'] != '' && 'telete_way' == (isset($telete_way) ? $telete_way : '')){
	$chat_id= $row88t['onu_ping_check_chat_id'];
}
else{
	$chat_id= $row88t['chat_id'];
}

$fileURL2tt = urlencode($msg_body);
$full_linkt= $t_link.$bot_id.'/sendMessage?chat_id='.$chat_id.'&text='.$fileURL2tt;

			$ch3 = curl_init();
			curl_setopt($ch3, CURLOPT_URL,$full_linkt); 
			curl_setopt($ch3, CURLOPT_RETURNTRANSFER,1); // return into a variable 
			curl_setopt($ch3, CURLOPT_TIMEOUT, 10); 
			$result11 = curl_exec($ch3); 
			curl_close($ch3);
?>