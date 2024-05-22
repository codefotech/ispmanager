<?php
include("conn/connection.php");
include('include/telegramapi.php');
extract($_POST);
$daterrr = date('Y-m-d', time());
$timeee = date('H:i:s', time());
	if(empty($_POST['ids']))
		{
			echo 'Error';
		}
		else
		{
			$query="UPDATE fund_transfer SET fund_send = '$fund_send', fund_received = '$fund_received', transfer_amount = '$transfer_amount', transfer_date = '$transfer_date', note = '$note' WHERE id = '$ids'";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");


$sqlmqq = mysql_query("SELECT id, bank_name AS fundsendr from bank WHERE id = '$fund_send'");					
$rowmkqq = mysql_fetch_assoc($sqlmqq);
$fundsendr = $rowmkqq['fundsendr'].' ('.$rowmkqq['id'].')';

$sqlmqqss = mysql_query("SELECT id, bank_name AS fundreceivr from bank WHERE id = '$fund_received'");					
$rowmkqqss = mysql_fetch_assoc($sqlmqqss);
$fundreceivr = $rowmkqqss['fundreceivr'].' ('.$rowmkqqss['id'].')';

$sqlmqqdd = mysql_query("SELECT id, bank_name AS fundsendr from bank WHERE id = '$old_fund_send'");					
$rowmkqddq = mysql_fetch_assoc($sqlmqqdd);
$oldfundsendr = $rowmkqddq['fundsendr'].' ('.$rowmkqddq['id'].')';

$sqlmqqssss = mysql_query("SELECT id, bank_name AS fundreceivr from bank WHERE id = '$old_fund_received'");					
$rowmkqqssss = mysql_fetch_assoc($sqlmqqssss);
$oldfundreceivr = $rowmkqqssss['fundreceivr'].' ('.$rowmkqqssss['id'].')';

$sqlmqqssrr = mysql_query("SELECT e_id, e_name AS entyby from emp_info WHERE e_id = '$entry_by'");					
$rowmkqqssdd = mysql_fetch_assoc($sqlmqqssrr);
$entybyyy = $rowmkqqssdd['entyby'].' ('.$rowmkqqssdd['e_id'].')';

if($tele_sts == '0' && $tele_fund_transfer_sts == '0'){
$telete_way = 'fund_transfer';
$msg_body='..::[Edit Fund Transfer]::..

Old from Bank: '.$oldfundsendr.'
Old to Bank: '.$oldfundreceivr.'
Old Amount: '.$old_transfer_amount.' TK.

New from Bank: '.$fundsendr.'
New to Bank: '.$fundreceivr.'
New Amount: '.$transfer_amount.' TK.

By: '.$entybyyy.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}

$action_details = 'Edit Fund Transfer. Old From Bank '.$oldfundsendr.' Old To Bank: '.$oldfundreceivr.', Old Amount: '.$old_transfer_amount.' tk. <br/> New From Bank '.$fundsendr.' New To Bank: '.$fundreceivr.', New Amount: '.$transfer_amount.' tk. <br/>';
$query222 = "INSERT INTO emp_log (e_id, module_name, titel, date, time, action, action_details) VALUES ('$entry_by', 'Fund Transfer', 'Edit Transfer Fund', '$daterrr', '$timeee', 'Edit Transfer Fund', '$action_details')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}

			if ($result)
				{
					header('Location: FundTransfer');
				}
			else{
					echo 'Error, Please try again';
				}
		}

mysql_close($con);
?>