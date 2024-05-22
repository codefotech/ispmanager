<?php
include("../web/conn/connection.php");
include('../web/company_info.php');
include('../web/include/telegramapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$gateway=$_GET['gateway'];
extract($_POST);

date_default_timezone_set('Etc/GMT-6');
$pay_date = date('Y-m-d', time());
$pay_time = date('H:i:s', time());
$date_time = date('Y-m-d H:i:s', time());

	$sqlsdfw = mysql_query("SELECT COUNT(id) AS findtrx FROM `payment_macreseller` WHERE `trxid` = '$trxID'");
	$rowsmw = mysql_fetch_assoc($sqlsdfw);
	$findtrx= $rowsmw['findtrx'];
	
if($findtrx > '0'){  ?>
<html>
<body>
    <form action="Welcome" method="post" name="ok">
		<input type="hidden" name="sts" value="faild_add">
		<input type="hidden" name="amount" value="<?php echo $pay_amount;?>">
    </form>
    <script language="javascript" type="text/javascript">
		document.ok.submit();
    </script>
</body>
</html>
<?php } else{
	$z_id = $_POST['z_id'];
	$e_id = $_POST['e_id'];
	$pay_amount = $_POST['pay_amount'];

if($pay_amount > '0' && $z_id != '' && $e_id != ''){
	
	$entry_by = $_POST['pay_ent_by'];
	$parts=explode(",",$pay_amount);
	$parts=array_filter($parts);
	$dgdgdfg = implode("",$parts);
	
	$discount = '0.00';
	$agent_id = $_POST['agent_id'];
	$commission_sts = $_POST['commission_sts'];
	$com_percent = $_POST['com_percent'];
	$commission_amount = $_POST['commission_amount'];
	$e_name = $_POST['e_name'];
	$trxidd = $trxID;

		
$sql111 = mysql_query("SELECT SUM(b.bill_amount) AS totbill FROM billing_mac AS b WHERE b.z_id = '$z_id'");
$rowww = mysql_fetch_array($sql111);

$sql1z1 = mysql_query("SELECT p.id, z.z_name, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p LEFT JOIN zone AS z ON z.z_id = p.z_id WHERE p.z_id = '$z_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);
$z_name = $rowwz['z_name'];
$opening_balance = $rowwz['retotalpayments']-$rowww['totbill'];
$closing_balance =  $opening_balance + ($dgdgdfg + $discount);


if($gateway == 'bKash' && in_array(1, $online_getway)){
	$bkkk=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '1'");
	$rowbk=mysql_fetch_array($bkkk);
	$bkbank=$rowbk['bank'];

	$querydfghdgh = "INSERT INTO payment_online (reseller_id, pay_mode, date_time, paymentID, createTime, updateTime, trxID, transactionStatus, amount, pay_amount, currency, intent, merchantInvoiceNumber, refundAmount)
					  VALUES ('$e_id', '$gateway', '$date_time', '$paymentID', '$createTime', '$updateTime', '$trxidd', '$transactionStatus', '$amount', '$dgdgdfg', '$currency', '$intent', '$merchantInvoiceNumber', '$refundAmount')";
	$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
	

$sql1 = mysql_query("INSERT INTO payment_macreseller (e_id, z_id, bank, pay_date, pay_time, pay_mode, discount, pay_amount, opening_balance, closing_balance, entry_by, date_time, note, trxid, agent_id, commission_sts, com_percent, commission_amount, payment_type) 
VALUES ('$e_id', '$z_id', '$bkbank', '$pay_date', '$pay_time', '$gateway', '$discount', '$dgdgdfg', '$opening_balance', '$closing_balance', '$entry_by', '$date_time', 'Online Payment', '$trxidd', '$agent_id', '$commission_sts', '$com_percent', '$commission_amount', '1')");
}

if($gateway == 'bKashT' && in_array(6, $online_getway)){
	$bkkk=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '6'");
	$rowbk=mysql_fetch_array($bkkk);
	$bkbank=$rowbk['bank'];

	$querydfghdgh = "INSERT INTO payment_online (reseller_id, sender_no, pay_mode, date_time, paymentID, paymentExecuteTime, trxID, transactionStatus, amount, pay_amount, currency, intent, merchantInvoiceNumber, agreementID, customerMsisdn, payerReference)
					  VALUES ('$e_id', '$customerMsisdn', '$gateway', '$date_time', '$paymentID', '$paymentExecuteTime', '$trxidd', '$transactionStatus', '$amount', '$dgdgdfg', '$currency', '$intent', '$merchantInvoiceNumber', '$agreementID', '$customerMsisdn', '$payerReference')";
	$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
	
$sql1 = mysql_query("INSERT INTO payment_macreseller (e_id, z_id, bank, pay_date, pay_time, pay_mode, discount, pay_amount, opening_balance, closing_balance, entry_by, date_time, note, trxid, agent_id, commission_sts, com_percent, commission_amount, payment_type) 
VALUES ('$e_id', '$z_id', '$bkbank', '$pay_date', '$pay_time', '$gateway', '$discount', '$dgdgdfg', '$opening_balance', '$closing_balance', '$entry_by', '$date_time', 'Online Payment', '$trxidd', '$agent_id', '$commission_sts', '$com_percent', '$commission_amount', '6')");
}

if($gateway == 'SSLCommerz' && in_array(3, $online_getway)){
	$sslkk=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '3'");
	$rowssl=mysql_fetch_array($sslkk);
	$sslbank=$rowssl['bank'];
	
	$querydfghdgh = "INSERT INTO payment_online (c_id, pay_mode, date_time, paymentID, createTime, updateTime, trxID, transactionStatus, amount, pay_amount, currency, intent, merchantInvoiceNumber, refundAmount, card_type, bank_gw, card_no, card_issuer, card_brand, ssl_amount, alldata)
					  VALUES ('$e_id', '$gateway', '$date_time', '$paymentID', '$createTime', '$updateTime', '$trxidd', '$transactionStatus', '$amount', '$dgdgdfg', '$currency', '$intent', '$merchantInvoiceNumber', '$refundAmount', '$card_type', '$bank_gw', '$card_no', '$card_issuer', '$card_brand', '$ssl_amount', '$alldata')";
	$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
	
$sql1 = mysql_query("INSERT INTO payment_macreseller (e_id, z_id, bank, pay_date, pay_time, pay_mode, discount, pay_amount, opening_balance, closing_balance, entry_by, date_time, note, trxid, agent_id, commission_sts, com_percent, commission_amount, payment_type) 
VALUES ('$e_id', '$z_id', '$sslbank', '$pay_date', '$pay_time', '$gateway', '$discount', '$dgdgdfg', '$opening_balance', '$closing_balance', '$entry_by', '$date_time', 'Online Payment', '$trxidd', '$agent_id', '$commission_sts', '$com_percent', '$commission_amount', '1')");
}


if($commission_sts == '1'){
$sqlmqq = mysql_query("SELECT id AS mrno, e_id, z_id FROM payment_macreseller WHERE e_id = '$e_id' ORDER BY id DESC LIMIT 1");
		$rowmkqq = mysql_fetch_assoc($sqlmqq);
		$mrno = $rowmkqq['mrno'];
	$sql1com = mysql_query("INSERT INTO agent_commission (payment_id, reseller_id, agent_id, z_id, com_percent, payment_amount, amount, bill_date, bill_time, entry_by) VALUES ('$mrno', '$e_id', '$agent_id', '$z_id', '$com_percent', '$pay_amount', '$commission_amount', '$pay_date', '$pay_time', '$entry_by')");
}

//TELEGRAM Start....
if($tele_sts == '0' && $tele_add_payment_sts == '0'){
$telete_way = 'payment_add';
$msg_body='..::[Reseller Online Recharge]::..
'.$e_name.' ['.$e_id.'] ['.$z_name.']

Amount: '.$dgdgdfg.' TK
Discount: '.$discount.' TK
Balance: 0.00 TK

Gateway: '.$gateway.'

By: '.$e_name.'';

include('../web/include/telegramapicore.php');
}
//TELEGRAM END....	
if($sentsms=='Yes'){
$sqlsdf = mysql_query("SELECT sms_msg FROM sms_msg WHERE id= '10'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$sql88 = ("SELECT id, link, username, password, status FROM sms_setup WHERE status = '0' AND z_id = ''");

$query88 = mysql_query($sql88);
$row88 = mysql_fetch_assoc($query88);
		$link= $row88['link'];
		$username= $row88['username'];
		$password= $row88['password'];
		$status= $row88['status'];
		
$from_page = 'Reseller Online Recharge';
$c_idd = $e_id;
$send_by = $entry_by;

$replacements = array(
	'ResellerName' => $e_name,
	'PaymentAmount' => $pay_amount,
	'PaymentDiscount' => $discount,
	'PaymentMethod' => $gateway,
	'OpeningBalance' => $opening_balance,
	'ClosingBalance' => $closing_balance,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);
include('../web/include/smsapicore.php');
}

	?>
<html>
<body>
    <form action="Welcome" method="post" name="ok">
		<input type="hidden" name="sts" value="Recharge_add">
		<input type="hidden" name="amount" value="<?php echo $pay_amount;?>">
		<input type="hidden" name="mode" value="<?php echo $gateway;?>" />
    </form>
    <script language="javascript" type="text/javascript">
		document.ok.submit();
    </script>
</body>
</html>

<?php
}
else{ ?>
<html>
<body>
    <form action="Welcome" method="post" name="ok">
		<input type="hidden" name="sts" value="faild_add">
		<input type="hidden" name="amount" value="<?php echo $pay_amount;?>">
		<input type="hidden" name="mode" value="<?php echo $gateway;?>" />
    </form>
    <script language="javascript" type="text/javascript">
		document.ok.submit();
    </script>
</body>
</html>
<?php }

mysql_close($con);
}
?>