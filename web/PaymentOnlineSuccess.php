<?php
include("conn/connection.php");
include('include/smsapi.php');
include('include/telegramapi.php');
include('company_info.php');
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$gateway=$_GET['gateway'];
extract($_POST);

if($mac_user == '0'){
	$sqlsdfw = mysql_query("SELECT COUNT(id) AS findtrx FROM `payment` WHERE `trxid` = '$trxID'");
}
else{
	$sqlsdfw = mysql_query("SELECT COUNT(id) AS findtrx FROM `payment_macreseller` WHERE `trxid` = '$trxID'");
}
$rowsmw = mysql_fetch_assoc($sqlsdfw);
$findtrx= $rowsmw['findtrx'];
	
if($findtrx > '0'){
	$dfgdfgh = 'PaymentOnline?gateway='.$gateway.'&sts=faild';
    header("Location:$dfgdfgh");
}
else{
function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$sqlsdf = mysql_query("SELECT sms_msg FROM sms_msg WHERE id= '5'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];

$paymentam = (int) filter_var($payment, FILTER_SANITIZE_NUMBER_INT);
ini_alter('date.timezone','Asia/Almaty');

$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());

if ( empty($_POST['c_id']))
{}
else
{
if($gateway == 'bKash' && in_array(1, $online_getway)){

$bkkk=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '1'");
$rowbk=mysql_fetch_array($bkkk);
$bkbank=$rowbk['bank'];

	$c_idd = $_POST['c_id'];
	$gateway = $gateway;
	$payment = $_POST['pay_amount'];
	$bill_disc = '0.00';
	$pay_desc = 'Online Payment';
	$bank = $bkbank;
	$parts=explode(",",$payment);
	$parts=array_filter($parts);
	$dgdgdfg = implode("",$parts);
	$trxidd = $trxID;
	
		$sql1 = mysql_query("INSERT INTO payment (c_id, bank, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, trxid, pay_ent_date, pay_ent_by, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$c_id', '$bank', '$update_date', '$dgdgdfg', '$gateway', '$bill_disc', '$pay_desc', '$trxidd', '$pay_ent_date', '$pay_ent_by', '$agent_id', '$commission_sts', '$com_percent', '$commission_amount', '1')");
		$querydfghdgh = "INSERT INTO payment_online (c_id, pay_mode, date_time, paymentID, createTime, updateTime, trxID, transactionStatus, amount, pay_amount, currency, intent, merchantInvoiceNumber, refundAmount)
					  VALUES ('$c_id', '$gateway', '$date_time', '$paymentID', '$createTime', '$updateTime', '$trxidd', '$transactionStatus', '$amount', '$dgdgdfg', '$currency', '$intent', '$merchantInvoiceNumber', '$refundAmount')";
		$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
}

if($gateway == 'bKashT' && in_array(6, $online_getway)){

$bkkk=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '6'");
$rowbk=mysql_fetch_array($bkkk);
$bkbank=$rowbk['bank'];

	$c_idd = $_POST['c_id'];
	$gateway = $gateway;
	$payment = $_POST['pay_amount'];
	$agreementID = $_POST['agreementID'];
	$payerReference = $_POST['payerReference'];
	$customerMsisdn = $_POST['customerMsisdn'];
	$bill_disc = '0.00';
	$pay_desc = 'Online Payment';
	$bank = $bkbank;
	$parts=explode(",",$payment);
	$parts=array_filter($parts);
	$dgdgdfg = implode("",$parts);
	$trxidd = $trxID;

		$sql1 = mysql_query("INSERT INTO payment (c_id, bank, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, sender_no, trxid, pay_ent_date, pay_ent_by, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$c_id', '$bank', '$update_date', '$dgdgdfg', '$gateway', '$bill_disc', '$pay_desc', '$customerMsisdn', '$trxidd', '$pay_ent_date', '$pay_ent_by', '$agent_id', '$commission_sts', '$com_percent', '$commission_amount', '6')");
		$querydfghdgh = "INSERT INTO payment_online (c_id, sender_no, pay_mode, date_time, paymentID, paymentExecuteTime, trxID, transactionStatus, amount, pay_amount, currency, intent, merchantInvoiceNumber, agreementID, customerMsisdn, payerReference)
					  VALUES ('$c_id', '$customerMsisdn', '$gateway', '$date_time', '$paymentID', '$paymentExecuteTime', '$trxidd', '$transactionStatus', '$amount', '$dgdgdfg', '$currency', '$intent', '$merchantInvoiceNumber', '$agreementID', '$customerMsisdn', '$payerReference')";
		$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
}

if($gateway == 'iPay' && in_array(2, $online_getway)){
$bkkk=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '2'");
$rowbk=mysql_fetch_array($bkkk);
$bkbank=$rowbk['bank'];

	$c_idd = $_POST['c_id'];
	$gateway = $gateway;
	$payment = $_POST['pay_amount'];
	$bill_disc = '0.00';
	$pay_desc = 'Online Payment';
	$bank = $bkbank;
	$parts=explode(",",$payment);
	$parts=array_filter($parts);
	$dgdgdfg = implode("",$parts);
	$trxidd = $trxID;
	
		$sql1 = mysql_query("INSERT INTO payment (c_id, bank, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, trxid, pay_ent_date, pay_ent_by, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$c_id', '$bank', '$update_date', '$dgdgdfg', '$gateway', '$bill_disc', '$pay_desc', '$trxidd', '$pay_ent_date', '$pay_ent_by', '$agent_id', '$commission_sts', '$com_percent', '$commission_amount', '1')");
		$querydfghdgh = "INSERT INTO payment_online (c_id, pay_mode, date_time, paymentID, createTime, updateTime, trxID, transactionStatus, amount, pay_amount, currency, intent, merchantInvoiceNumber, refundAmount)
					  VALUES ('$c_id', '$gateway', '$date_time', '$paymentID', '$createTime', '$updateTime', '$trxidd', '$transactionStatus', '$amount', '$dgdgdfg', '$currency', '$intent', '$merchantInvoiceNumber', '$refundAmount')";
		$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
}

if($gateway == 'SSLCommerz' && in_array(3, $online_getway)){
$bkkk=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '3'");
$rowbk=mysql_fetch_array($bkkk);
$bkbank=$rowbk['bank'];

	$c_idd = $_POST['c_id'];
	$c_id = $_POST['c_id'];
	$gateway = $gateway;
	$payment = $_POST['pay_amount'];
	$bill_disc = '0.00';
	$pay_desc = 'Online Payment';
	$bank = $bkbank;
	$parts=explode(",",$payment);
	$parts=array_filter($parts);
	$dgdgdfg = implode("",$parts);
	$trxidd = $trxID;
	
		$sql1 = mysql_query("INSERT INTO payment (c_id, bank, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, trxid, pay_ent_date, pay_ent_by, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$c_id', '$bank', '$update_date', '$dgdgdfg', '$gateway', '$bill_disc', '$pay_desc', '$trxidd', '$pay_ent_date', '$pay_ent_by', '$agent_id', '$commission_sts', '$com_percent', '$commission_amount', '1')");
		$querydfghdgh = "INSERT INTO payment_online (c_id, pay_mode, date_time, paymentID, createTime, updateTime, trxID, transactionStatus, amount, pay_amount, currency, intent, merchantInvoiceNumber, refundAmount, card_type, bank_gw, card_no, card_issuer, card_brand, ssl_amount, alldata)
					  VALUES ('$c_id', '$pay_mode', '$date_time', '$paymentID', '$createTime', '$updateTime', '$trxidd', '$transactionStatus', '$amount', '$dgdgdfg', '$currency', '$intent', '$merchantInvoiceNumber', '$refundAmount', '$card_type', '$bank_gw', '$card_no', '$card_issuer', '$card_brand', '$ssl_amount', '$alldata')";
		$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
}
	if($breseller == '2'){
		$sqlmqq = mysql_query("SELECT p.id AS mrno, z.z_name, c.cell, c.z_id, c.c_name, p.bill_discount, e.e_name as pay_ent_byname, p.pay_ent_by, c.c_id, c.com_id FROM payment as p
								LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by 
								LEFT JOIN clients as c on c.c_id = p.c_id 
								LEFT JOIN zone as z on z.z_id = c.z_id 
								WHERE p.c_id = '$c_id' ORDER BY p.id DESC LIMIT 1");
		$rowmkqq = mysql_fetch_assoc($sqlmqq);
		$c_idd = $rowmkqq['c_id'];
		$com_id = $rowmkqq['com_id'];
		$mrno = $rowmkqq['mrno'];
		$pay_ent_byname = $rowmkqq['pay_ent_byname'];
		$pay_ent_by = $rowmkqq['pay_ent_by'];
		$z_name = $rowmkqq['z_name'];
		$celll = $rowmkqq['cell'];
		$z_id = $rowmkqq['z_id'];
		$c_namee = $rowmkqq['c_name'];
		$billdiscount = $rowmkqq['bill_discount'];
	}
	else{
	$sqlmqq = mysql_query("SELECT p.id AS mrno, z.z_name, c.cell, c.bandwidth, x.mk_profile, c.ip, c.mac, c.z_id, c.c_name, p.bill_discount, p.pay_ent_by, c.c_id, c.com_id FROM payment as p
								LEFT JOIN clients as c on c.c_id = p.c_id 
								LEFT JOIN zone as z on z.z_id = c.z_id 
								LEFT JOIN package AS x ON x.p_id = c.p_id
								WHERE p.c_id = '$c_id' ORDER BY p.id DESC LIMIT 1");
		$rowmkqq = mysql_fetch_assoc($sqlmqq);
		$c_idd = $rowmkqq['c_id'];
		$com_id = $rowmkqq['com_id'];
		$mrno = $rowmkqq['mrno'];
		$z_name = $rowmkqq['z_name'];
		$cell = $rowmkqq['cell'];
		$z_id = $rowmkqq['z_id'];
		$c_namee = $rowmkqq['c_name'];
		$billdiscount = $rowmkqq['bill_discount'];
		$moneyreceiptno = '';
		$bandwidth = $rowmkqq['bandwidth'];
		$ip = $rowmkqq['ip'];
		$mac = $rowmkqq['mac'];
		$mk_profile = $rowmkqq['mk_profile'];
	}
	
if($commission_sts == '1'){
	$sql1com = mysql_query("INSERT INTO agent_commission (payment_id, c_id, agent_id, z_id, com_percent, payment_amount, amount, bill_date, bill_time, entry_by) VALUES ('$mrno', '$c_id', '$agent_id', '$z_id', '$com_percent', '$payment', '$commission_amount', '$pay_ent_date', '$update_time', '$pay_ent_by')");
}


//TELEGRAM Start....
if($tele_sts == '0' && $tele_add_payment_sts == '0'){
$telete_way = 'payment_add';
$msg_body='..::[Online Payment]::..
'.$c_namee.' ['.$c_id.'] ['.$z_name.']

Amount: '.$amount.' TK
Discount: '.$billdiscount.' TK
Balance: 0.00 TK

Gateway: '.$gateway.'

By: '.$c_namee.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//TELEGRAM END....	

if($con_sts == 'Inactive' && $auto_bill_check == 'Yes' && $breseller != '2'){
	$sql2 = mysql_query("SELECT c.c_id, (b.bill-p.paid) AS due, c.mk_id FROM clients AS c
						LEFT JOIN
						(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
						ON b.c_id = c.c_id
						LEFT JOIN
						(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
						ON p.c_id = c.c_id

						WHERE c.c_id = '$c_id'");
$rows = mysql_fetch_array($sql2);
$mk_id = $rows['mk_id'];
$Deww = $rows['due'];

$sql233 = mysql_query("SELECT p_price, bill_amount FROM billing WHERE c_id = '$c_id' ORDER BY id DESC LIMIT 1");
$rows33 = mysql_fetch_array($sql233);
$billamount = $rows33['bill_amount'];
$pppprice = $rows33['p_price'];
			
			
if($Deww <= '1' && $billamount != '0'){
	$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
	$rowmk = mysql_fetch_array($sqlmk);
	$ServerIP = $rowmk['ServerIP'];
	$Username = $rowmk['Username'];
	$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
	$Port = $rowmk['Port'];
								
	$API = new routeros_api();
	$API->debug = false;
		if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
		if($breseller == '1'){
				$arrID = $API->comm("/queue/simple/getall", 
				array(".proplist"=> ".id","?name" => $c_id,));

				$API->comm("/queue/simple/set",
				array(".id" => $arrID[0][".id"],"max-limit" => $bandwidth));
		}
		else{
				$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));

				$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "no", "profile" => $mk_profile));
				$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
				$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
		}
	$API->disconnect();
	}

	$queryq ="UPDATE clients SET con_sts = 'Active', con_sts_date = '$update_date' WHERE c_id = '$c_id'";
					if (!mysql_query($queryq))
					{
					die('Error: ' . mysql_error());
					}
	$query1q ="INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$c_id', 'Active', '$update_date', '$update_time', '$pay_ent_by')";
					if (!mysql_query($query1q))
					{
					die('Error: ' . mysql_error());
					}
					
if($sentsms=='Yes'){
$from_page = 'Bill Payment';
$res = mysql_query("SELECT l.amt, t.dic, t.pay FROM
					(
						SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$c_id'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment WHERE c_id = '$c_id'
					)t
					ON l.c_id = t.c_id");

$rows = mysql_fetch_array($res);
$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_namee,
	'PaymentAmount' => $amount,
	'PaymentDiscount' => $bill_disc,
	'PaymentMethod' => $gateway,
	'TotalDue' => $Dew,
	'MoneyreceiptNo' => $moneyreceiptno,
	'TrxId' => $trxidd,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}
}
else{
if($sentsms=='Yes'){
	
$from_page = 'Bill Payment';
	
$res = mysql_query("SELECT l.amt, t.dic, t.pay FROM
					(
						SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$c_id'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment WHERE c_id = '$c_id'
					)t
					ON l.c_id = t.c_id");

$rows = mysql_fetch_array($res);
$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_namee,
	'PaymentAmount' => $amount,
	'PaymentDiscount' => $bill_disc,
	'PaymentMethod' => $gateway,
	'TotalDue' => $Dew,
	'MoneyreceiptNo' => $moneyreceiptno,
	'TrxId' => $trxidd,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}
}
}
else{
if($sentsms=='Yes'){
$from_page = 'Bill Payment';
if($breseller == '2'){
			$res = mysql_query("SELECT IFNULL((b.bill - p.paid), '0.00') AS total_due FROM clients AS c 
							LEFT JOIN
							(SELECT IFNULL(c_id, '$c_id') AS c_id, IFNULL(SUM(total_price), '0.00') AS bill FROM billing_invoice WHERE sts = '0' AND c_id = '$c_id')b
							ON b.c_id = c.c_id
							LEFT JOIN
							(SELECT IFNULL(c_id, '$c_id') AS c_id, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS paid FROM payment WHERE sts = '0' AND c_id = '$c_id')p
							ON p.c_id = c.c_id
							WHERE c.breseller = '2' AND c.c_id = '$c_id'");

			$rows = mysql_fetch_array($res);
			$Dew = 	$rows['total_due'];
		}
		else{
			$res = mysql_query("SELECT l.amt, t.dic, t.pay FROM
								(
									SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$c_id'
								)l
								LEFT JOIN
								(
									SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment WHERE c_id = '$c_id'
								)t
								ON l.c_id = t.c_id");

			$rows = mysql_fetch_array($res);
			$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);
		}
$replacements = array(
	'c_id' => $c_idd,
	'com_id' => $com_id,
	'c_name' => $c_namee,
	'PaymentAmount' => $amount,
	'PaymentDiscount' => $bill_disc,
	'PaymentMethod' => $gateway,
	'TotalDue' => $Dew,
	'MoneyreceiptNo' => $moneyreceiptno,
	'TrxId' => $trxidd,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}?>
<html>
<body>
     <form action="<?php if($payfrom == 'external'){echo 'PaymentOnlineExternal?clientid='.$c_id.'&gateway='.$gateway;} else{echo 'ClientsBill';}?>" method="post" name="ok">
		<input type="hidden" value="<?php echo $amount;?>" name="payment" />
		<input type="hidden" name="mode" value="<?php echo $gateway;?>" />
		<input type="hidden" name="sts" value="done" />
     </form>
     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php } ?>
<html>
<body>
     <form action="<?php if($payfrom == 'external'){echo 'PaymentOnlineExternal?clientid='.$c_id.'&gateway='.$gateway;} else{echo 'ClientsBill';}?>" method="post" name="ok">
	 <input type="hidden" value="<?php echo $amount;?>" name="payment" />
		<input type="hidden" name="mode" value="<?php echo $gateway;?>" />
		<input type="hidden" name="sts" value="done" />
     </form>
     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php }}
mysql_close($con);
?>