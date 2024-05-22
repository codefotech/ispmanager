<?php
session_start();

$request_token=bkash_Get_Token();
$idtoken=$request_token['id_token'];
$expires_in=$request_token['expires_in'];
$refresh_token=$request_token['refresh_token'];
	
$_SESSION['token']=$idtoken;
$strJsonFileContents = file_get_contents("js/configt.json");
$array = json_decode($strJsonFileContents, true);

$array['token']=$idtoken;

$newJsonString = json_encode($array);
file_put_contents('js/configt.json',$newJsonString);
	
function bkash_Get_Token(){

	$strJsonFileContents = file_get_contents("js/configt.json");
	$array = json_decode($strJsonFileContents, true);
	
	$post_token=array(
        'app_key'=>$array["app_key"],                                              
		'app_secret'=>$array["app_secret"]                  
	);	
    
    $url=curl_init($array["tokenURL"]);
	$proxy = $array["proxy"];
	$posttoken=json_encode($post_token);
	$header=array(
		'Content-Type:application/json',
		'password:'.$array["password"],                                                               
        'username:'.$array["username"]                                                           
    );				
    
    curl_setopt($url,CURLOPT_HTTPHEADER, $header);
	curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($url,CURLOPT_POSTFIELDS, $posttoken);
	curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
	$resultdata=curl_exec($url);
	curl_close($url);
	
	return json_decode($resultdata, true);
}
function writeLog($logName, $logData){
	file_put_contents($logName.'.log',$logData,FILE_APPEND);
}
?>
