<?php 
include("conn/connection.php");
//payload
$payload  = (array)json_decode(file_get_contents('php://input'));
writeLog('Payload',$payload);

// headers
$messageType = $_SERVER['HTTP_X_AMZ_SNS_MESSAGE_TYPE'];


//logics



//verify signature
$signingCertURL = $payload['SigningCertURL'];
$certUrlValidation = validateUrl($signingCertURL);
if($certUrlValidation == '1'){
	$pubCert = get_content($signingCertURL); 

	$signature = $payload['Signature'];
	$signatureDecoded = base64_decode($signature);
	
	$content = getStringToSign($payload);
	if($content!=''){
		$verified = openssl_verify($content, $signatureDecoded, $pubCert, OPENSSL_ALGO_SHA1);
		if($verified=='1'){
			if($messageType=="SubscriptionConfirmation"){  
				$subscribeURL = $payload['SubscribeURL'];
				writeLog('Subscribe',$subscribeURL);
				//subscribe
				$url = curl_init($subscribeURL);
				curl_exec($url);
			}
			else if($messageType=="Notification"){
				$notificationData = $payload['Message'];
				writeLog('NotificationData-Message',$notificationData);
				
				$TransactionData = json_decode($notificationData, true);

				$vDateTime = $TransactionData["dateTime"];
				$vDebitMSISDN = $TransactionData["debitMSISDN"];
				$vCreditOrganizationName = $TransactionData["creditOrganizationName"];
				$vCreditShortCode = $TransactionData["creditShortCode"];
				$vTrxID = $TransactionData["trxID"];
				$vTransactionStatus = $TransactionData["transactionStatus"];
				$vTransactionType = $TransactionData["transactionType"];
				$vTranAmount = $TransactionData["amount"];
				$vCurrency = $TransactionData["currency"];
				$vTransactionReference = $TransactionData["transactionReference"];
				
				//radius db > payment table
				$sql = "INSERT INTO webhook (dateTime, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, transactionType, amount, currency, transactionReference)
				VALUES ('$vDateTime', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$vTrxID', '$vTransactionStatus', '$vTransactionType', '$vTranAmount', '$vCurrency', '$vTransactionReference')";


				//$date_time = $vDateTime;
				//$date = substr($date_time, 0, 8);
				//$time = substr($date_time, 8, 14);

				//radius db > bkash_payment table
				//$sql = "INSERT INTO bkash_payment (dateTime, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, transactionType, amount, currency, transactionReference, date, time)
				//VALUES ('$vDateTime', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$vTrxID', '$vTransactionStatus', '$vTransactionType', '$vTranAmount', '$vCurrency', '$vTransactionReference', '$date', '$time')";

				if ($conn->query($sql) === TRUE) {
					$botToken="6424032365:AAFYL-C2YHDmeJXye4y1HmmMPBwZ8UXZwiw";

					$website = "https://api.telegram.org/bot".$botToken;
					$chatId = '-4155861958';
$replay_massage = <<<TEXT
Reference: $vTransactionReference
Amount: $vTranAmount
Mobile: $vDebitMSISDN
TrxID: $vTrxID
TEXT;
					$params = [
					'chat_id'=>$chatId, 
					'text'=>$replay_massage,
					];
					$ch = curl_init($website . '/sendMessage');
					curl_setopt($ch, CURLOPT_HEADER, false);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					$result = curl_exec($ch);
					curl_close($ch);			
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
//				$conn->close();
			}
		}
	}
	
}

function writeLog($logName, $logData){
	file_put_contents('./log-'.$logName.date("j.n.Y").'.log',$logData,FILE_APPEND);
}


function get_content($URL){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $URL);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function getStringToSign($message) {
	$signableKeys = [
		'Message',
		'MessageId',
		'Subject',
		'SubscribeURL',
		'Timestamp',
		'Token',
		'TopicArn',
		'Type'
	];
	
	$stringToSign = '';
	
	if ($message['SignatureVersion'] !== '1') {
		$errorLog =  "The SignatureVersion \"{$message['SignatureVersion']}\" is not supported.";
		writeLog('SignatureVersion-Error', $errorLog);
	}else{
		foreach ($signableKeys as $key) {
			if (isset($message[$key])) {
				$stringToSign .= "{$key}\n{$message[$key]}\n";
			}
		}
		writeLog('StringToSign', $stringToSign."\n");
	}
	return $stringToSign;
}

function validateUrl($url) {
	$defaultHostPattern = '/^sns\.[a-zA-Z0-9\-]{3,}\.amazonaws\.com(\.cn)?$/';
	$parsed = parse_url($url);
	
	if (empty($parsed['scheme']) || empty($parsed['host']) || $parsed['scheme'] !== 'https' || substr($url, -4) !== '.pem' || !preg_match($defaultHostPattern, $parsed['host']) ) {
		return false;
	}
	else{
		return true;
	}
}
?>