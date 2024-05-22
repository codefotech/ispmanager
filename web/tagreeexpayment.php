<?php
session_start();
extract($_POST); 
$zsfgg = "https://".$_SERVER['SERVER_NAME']."/texecutepayment.php";
$strJsonFileContents = file_get_contents("js/configt.json");
$array = json_decode($strJsonFileContents, true);

    $createpaybody1=array('paymentID'=>$_GET['paymentID']);   
    $url = curl_init($array["executeURL"]);

    $createpaybodyx1 = json_encode($createpaybody1);

    $header=array(
        'Content-Type:application/json',
        'authorization:'.$array["token"],
        'x-app-key:'.$array["app_key"]
    );

    curl_setopt($url,CURLOPT_HTTPHEADER, $header);
	curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($url,CURLOPT_POSTFIELDS, $createpaybodyx1);
    curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($url,CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    
    $resultdata = curl_exec($url);
    curl_close($url);
//	echo $resultdata;
$smsapi = json_decode($resultdata, true);
$agreementID = $smsapi['agreementID'];
$payerReference = $smsapi['payerReference'];
$paymentID = $smsapi['paymentID'];
$customerMsisdn = $smsapi['customerMsisdn'];
$statusCode = $smsapi['statusCode'];

if($statusCode == '0000'){
include("conn/connection.php");
$eiddd = $_SESSION['SESS_EMP_ID'];
$external_clientid = $_SESSION['external_clientid'];
if($_SESSION['wayyy'] == 'client'){
	if($_SESSION['payfrom'] == ''){
		$sql1comss = mysql_query("UPDATE clients SET agreementID='$agreementID', customerMsisdn='$customerMsisdn' WHERE c_id = '$eiddd'");
	}
	else{
		$sql1comss = mysql_query("UPDATE clients SET agreementID='$agreementID', customerMsisdn='$customerMsisdn' WHERE c_id = '$external_clientid'");
	}
}
else{
	$sql1comss = mysql_query("UPDATE emp_info SET agreementID='$agreementID', customerMsisdn='$customerMsisdn' WHERE e_id = '$eiddd'");}
?>
<html>
	<body>
		<form action="tcreatepayment.php" method="post" name="ok">
			<input type="hidden" name="payment_amount" value="<?php echo number_format($_SESSION['payment_amount'],2, '.', '');?>">
			<input type="hidden" name="invo_no" value="<?php echo $_SESSION['invo_no'];?>">
			<input type="hidden" name="payerReference" value="<?php echo $payerReference;?>">
			<input type="hidden" name="callbackURL" value="<?php echo $zsfgg;?>">
			<input type="hidden" name="agreementID" value="<?php echo $agreementID;?>">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
<?php } else{ 
if($_SESSION['wayyy'] == 'reseller'){
	$dfgdfgh = 'PaymentOnline?gateway='.$_SESSION['gateway'].'&wayyy=reseller&dewamount='.$_SESSION['dewamount'].'&sts=canceled';
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