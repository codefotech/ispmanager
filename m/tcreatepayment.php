<?php
session_start();
extract($_POST); 

$strJsonFileContents = file_get_contents("js/configt.json");
$array = json_decode($strJsonFileContents, true);

$intent = "sale";
    $createpaybody=array('mode'=>'0001', 'agreementID'=>$agreementID, 'callbackURL'=>$callbackURL, 'amount'=>$payment_amount, 'currency'=>'BDT', 'intent'=>$intent, 'merchantInvoiceNumber'=>$invo_no);   
    $url = curl_init($array["createURL"]);

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
    //curl_setopt($url, CURLOPT_PROXY, $proxy);
    
    $resultdata = curl_exec($url);
    curl_close($url);

$smsapi = json_decode($resultdata, true);
$bkashURL = $smsapi['bkashURL'];

header("Location:$bkashURL");
?>
