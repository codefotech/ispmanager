<?php
extract($_POST);
include("conn/connection.php");
include('company_info.php');
include('include/smsapi.php');

function bind_to_template($replacements, $sms_msg) {
	return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
		return $replacements[$matches[1]];
	}, $sms_msg);
}

$sqlsdf = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE from_page = 'Bill Payment' AND z_id = '$macz_id'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];

$query233 = mysql_query("SELECT id FROM payment_mac_client ORDER BY id DESC LIMIT 1");
$row233 = mysql_fetch_assoc($query233);
$payment_idz = $row233['id'];

$sqlqqmm = mysql_query("SELECT e_name AS reseller_fullnamee, e_cont_per AS reseller_celll FROM emp_info WHERE z_id = '$macz_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);
$reseller_fullnamee = $row22m['reseller_fullnamee'];
$reseller_celll = $row22m['reseller_celll'];

ini_alter('date.timezone','Asia/Almaty');

$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());

if (empty($_POST['pay_date']) || empty($_POST['c_id']))
{}
else
{
	if($payment_idz == $last_payment_idz){
	$c_id = $_POST['c_id'];
	$cell = $_POST['cell'];
	$con_sts = $_POST['con_sts'];
	$pay_date = $_POST['pay_date'];
	$pay_mode = $_POST['pay_mtd'];
	$payment = $_POST['payment'];
	$bill_disc = $_POST['bill_disc'];
	$pay_desc = $_POST['pay_dsc'];
	$pay_ent_by = $_POST['pay_ent_by'];
	$pay_ent_date = $_POST['pay_ent_date'];
	
		$sql1 = mysql_query("INSERT INTO payment_mac_client (c_id, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, moneyreceiptno, pay_ent_date, pay_ent_by) VALUES ('$c_id', '$pay_date', '$payment', '$pay_mode', '$bill_disc', '$pay_desc', '$moneyreceiptno', '$pay_ent_date', '$pay_ent_by')");
		$sqlmqq = mysql_query("SELECT p.id AS mrno, z.z_name, c.cell, c.z_id, c.c_name, p.bill_discount, e.e_name as pay_ent_byname, p.pay_ent_by, c.c_id FROM payment_mac_client as p
								LEFT JOIN emp_info as e on e.e_id = p.pay_ent_by 
								LEFT JOIN clients as c on c.c_id = p.c_id 
								LEFT JOIN zone as z on z.z_id = c.z_id 
								WHERE p.c_id = '$c_id' ORDER BY p.id DESC LIMIT 1");
		$rowmkqq = mysql_fetch_assoc($sqlmqq);
		$c_idd = $rowmkqq['c_id'];
		$mrno = $rowmkqq['mrno'];
		$pay_ent_byname = $rowmkqq['pay_ent_byname'];
		$pay_ent_by = $rowmkqq['pay_ent_by'];
		$z_name = $rowmkqq['z_name'];
		$celll = $rowmkqq['cell'];
		$z_id = $rowmkqq['z_id'];
		$c_namee = $rowmkqq['c_name'];

if($sentsms=='Yes'){
	
$from_page = 'Bill Payment';
	
$res = mysql_query("SELECT l.amt, t.dic, t.pay FROM
					(
						SELECT c_id, SUM(bill_amount) AS amt FROM billing_mac_client WHERE c_id = '$c_id'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment_mac_client WHERE c_id = '$c_id'
					)t
					ON l.c_id = t.c_id");

$rows = mysql_fetch_array($res);
$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

$replacements = array(
	'c_id' => $c_idd,
	'c_name' => $c_namee,
	'PaymentAmount' => $payment,
	'PaymentDiscount' => $bill_disc,
	'PaymentMethod' => $pay_mtd,
	'TotalDue' => $Dew,
	'MoneyreceiptNo' => $moneyreceiptno,
	'TrxId' => $trxidd,
	'reseller_name' => $reseller_fullnamee,
	'reseller_cell' => $reseller_celll,
	'company_name' => $comp_name,
	'company_cell' => $company_cell
	);

$sms_body = bind_to_template($replacements, $sms_msg);
include('include/smsapicore.php');
}?>
<html>
<body>
     <form action="fpdf/MRPrint" method="post" name="cus_id">
       <input type="hidden" name="mrno" value="<?php echo $mrno; ?>">
       <input type="hidden" name="c_id" value="<?php echo $c_id;?>">
     </form>
     <script language="javascript" type="text/javascript">
		document.cus_id.submit();
     </script>
</body>
</html>
<?php 
} else{ ?>
<html>
<body>
     <form action="Billing?id=all" method="post" name="cus_id">
       <input type="hidden" name="sts" value="error">
     </form>
     <script language="javascript" type="text/javascript">
		document.cus_id.submit();
     </script>
</body>
</html>
<?php }} 
mysql_close($con);
?>