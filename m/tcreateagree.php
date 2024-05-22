<?php
session_start();
extract($_POST); 

$strJsonFileContents = file_get_contents("js/configt.json");
$array = json_decode($strJsonFileContents, true);

    $createpaybody1=array('mode'=>'0000', 'payerReference'=>$payerReference, 'callbackURL'=>$callbackURL);   
    $url = curl_init($array["createURL"]);

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
	curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    
    $resultdata = curl_exec($url);
    curl_close($url);
	$smsapi = json_decode($resultdata, true);
	$bkashURL = $smsapi['bkashURL'];
	
header("Location:$bkashURL");
?>
