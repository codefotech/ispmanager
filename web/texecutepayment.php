<?php
session_start(); 
$paymentID = $_GET['paymentID'];

$strJsonFileContents = file_get_contents("js/configt.json");
$array = json_decode($strJsonFileContents, true);

$url = curl_init($array["executeURL"]);

$createpaybody=array('paymentID'=>$paymentID);
$createpaybodyx = json_encode($createpaybody);

$header=array(
    'Content-Type:application/json',
    'authorization:'.$array["token"],
    'x-app-key:'.$array["app_key"]
);	

curl_setopt($url,CURLOPT_HTTPHEADER, $header);
curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
curl_setopt($url,CURLOPT_POSTFIELDS, $createpaybodyx);
curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
$resultdatax=curl_exec($url);
curl_close($url);

$smsapi = json_decode($resultdatax, true);
if($smsapi['statusCode'] == '0000'){
?>
<html>
	<body>
		<form action="PaymentOnlineQuery" method="post" name="okss">
			<input type="hidden" name="statusCode" value="<?php echo $smsapi['statusCode'];?>">
			<input type="hidden" name="statusMessage" value="<?php echo $smsapi['statusMessage'];?>">
			<input type="hidden" name="paymentID" value="<?php echo $smsapi['paymentID'];?>">
			<input type="hidden" name="agreementID" value="<?php echo $smsapi['agreementID'];?>">
			<input type="hidden" name="payerReferenceee" value="<?php echo $smsapi['payerReference'];?>">
			<input type="hidden" name="customerMsisdn" value="<?php echo $smsapi['customerMsisdn'];?>">
			<input type="hidden" name="trxID" value="<?php echo $smsapi['trxID'];?>">
			<input type="hidden" name="amount" value="<?php echo $smsapi['amount'];?>">
			<input type="hidden" name="transactionStatus" value="<?php echo $smsapi['transactionStatus'];?>">
			<input type="hidden" name="paymentExecuteTime" value="<?php echo $smsapi['paymentExecuteTime'];?>">
			<input type="hidden" name="merchantInvoiceNumber" value="<?php echo $smsapi['merchantInvoiceNumber'];?>">
			<input type="hidden" name="currency" value="<?php echo $smsapi['currency'];?>">
			<input type="hidden" name="intent" value="<?php echo $smsapi['intent'];?>">
			<input type="hidden" name="gateway" value="<?php echo $_SESSION['gateway'];?>">
			<input type="hidden" name="wayyy" value="<?php echo $_SESSION['wayyy'];?>">
			<input type="hidden" name="payfrom" value="<?php echo $_SESSION['payfrom'];?>">
			<input type="hidden" name="dewamount" value="<?php echo $_SESSION['dewamount'];?>">
		</form>
		<script language="javascript" type="text/javascript">
			document.okss.submit();
		</script>
	</body>
</html>
<?php } else{
if($_SESSION['wayyy'] == 'reseller'){
	$dfgdfgh = 'PaymentOnline?gateway='.$_SESSION['gateway'].'&wayyy=reseller&dewamount='.$_SESSION['dewamount'].'&sts=faild';
}
else{
	if($_SESSION['payfrom'] == ''){
		$dfgdfgh = 'PaymentOnline?gateway='.$_SESSION['gateway'].'&sts=faild';
	}
	else{
		$dfgdfgh = 'PaymentOnlineExternal?gateway='.$_SESSION['gateway'].'&sts=faild&clientid='.$_SESSION['external_clientid'];
	}
}
header("Location:$dfgdfgh");
} ?>
