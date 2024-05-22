<?php
include("../web/conn/connection.php");
include('../web/include/telegramapi.php');
extract($_POST);
date_default_timezone_set('Etc/GMT-6');
$daterrr = date('Y-m-d', time());
$timeee = date('H:i:s', time());
extract($_POST);

	if(empty($_POST['fund_send']) || empty($_POST['fund_received']) || empty($_POST['transfer_amount']) || empty($_POST['transfer_date']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			$query="insert into fund_transfer (fund_send, fund_received, transfer_amount, transfer_date, note, ent_date, ent_by)
					VALUES ('$fund_send', '$fund_received', '$transfer_amount', '$transfer_date', '$note', '$enty_date', '$entry_by')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

$sqlmqq = mysql_query("SELECT id, bank_name AS fundsendr from bank WHERE id = '$fund_send'");					
$rowmkqq = mysql_fetch_assoc($sqlmqq);
$fundsendr = $rowmkqq['fundsendr'].' ('.$rowmkqq['id'].')';

$sqlmqqss = mysql_query("SELECT id, bank_name AS fundreceivr from bank WHERE id = '$fund_received'");					
$rowmkqqss = mysql_fetch_assoc($sqlmqqss);
$fundreceivr = $rowmkqqss['fundreceivr'].' ('.$rowmkqqss['id'].')';

$sqlmqqssrr = mysql_query("SELECT e_id, e_name AS entyby from emp_info WHERE e_id = '$entry_by'");					
$rowmkqqssdd = mysql_fetch_assoc($sqlmqqssrr);
$entybyyy = $rowmkqqssdd['entyby'].' ('.$rowmkqqssdd['e_id'].')';

if($tele_sts == '0' && $tele_fund_transfer_sts == '0'){
$telete_way = 'fund_transfer';
$msg_body='..::[Fund Transferred]::..

From Bank: '.$fundsendr.'
To Bank: '.$fundreceivr.'
Amount: '.$transfer_amount.' TK.

By: '.$entybyyy.'
'.$tele_footer.'';

include('../web/include/telegramapicore.php');
}

$action_details = 'Transfer Fund From Bank '.$fundsendr.' To Bank: '.$fundreceivr.', Amount: '.$transfer_amount.' tk';
$query222 = "INSERT INTO emp_log (e_id, module_name, titel, date, time, action, action_details) VALUES ('$entry_by', 'Fund Transfer', 'Transfer Fund', '$daterrr', '$timeee', 'Transfer Fund', '$action_details')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}

			if ($result)
				{ ?>
					<html>
						<body>
							<form action="FundTransfer" method="post" name="ok">
								<input type="hidden" name="sts" value="add">
								<input type="hidden" name="fundreceived" value="<?php echo $fund_received;?>">
							</form>
							<script language="javascript" type="text/javascript">
									document.ok.submit();
							</script>
						</body>
					</html>		
				<?php }
			else{
					echo 'Error, Please try again';
				}
		}

mysql_close($con);
?>
