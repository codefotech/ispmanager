<?php 
include('company_info.php');
$sql88t = ("SELECT * FROM telegram_setup WHERE sts = '0'");
		
$query88t = mysql_query($sql88t);
$row88t = mysql_fetch_assoc($query88t);
		$tele_sts= $row88t['sts'];
		$tele_add_user_sts= $row88t['add_user'];
		$tele_add_payment_sts= $row88t['add_payment'];
		$webhook_client_payment= $row88t['webhook_client_payment'];
		$webhook_reseller_recharge= $row88t['webhook_reseller_recharge'];
		$tele_client_status_sts= $row88t['client_status'];
		$tele_expense_sts= $row88t['expense_sts'];
		$tele_client_recharge_sts= $row88t['client_recharge'];
		$tele_instruments_in_sts= $row88t['instruments_in_sts'];
		$tele_instruments_out_sts= $row88t['instruments_out_sts'];
		$tele_fund_transfer_sts= $row88t['fund_transfer_sts'];
		$tele_network_sts= $row88t['network_sts'];
		$tele_onu_ping_check= $row88t['onu_ping_check'];

$tele_footer = '[..::TIS Auto::..]';
?>
