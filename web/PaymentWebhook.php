<?php 
include('company_info.php');



$gateway=$_GET['gateway'];

ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$date_time = date('Y-m-d H:i:s', time());

//bKash Start
if($gateway == 'bKash' && in_array(1, $online_webhook_getway)){

//payload
$payload  = (array)json_decode(file_get_contents('php://input'));
writeLog('Payload',$payload);

// headers
$messageType = $_SERVER['HTTP_X_AMZ_SNS_MESSAGE_TYPE'];

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
				
				include('include/telegramapi.php');
				
				if($vTransactionReference != ''){
					$bkkk=mysql_query("SELECT e_id, user_type FROM login WHERE e_id = '$vTransactionReference'");
					$rowbk=mysql_fetch_array($bkkk);
					
					$c_idd = $rowbk['e_id'];
					$user_type = $rowbk['user_type'];
					$payment = $vTranAmount;
					$bill_disc = '0.00';
					$pay_desc = 'Webhook Payment';
					$trxidd = $vTrxID;
					
					$bkkkaa=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '1'");
					$rowbkss=mysql_fetch_array($bkkkaa);
					$bkbank=$rowbkss['bank'];
					
					if($user_type == 'client' && $c_idd != ''){
						include('include/smsapi.php');
						
						function bind_to_template($replacements, $sms_msg) {
							return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
								return $replacements[$matches[1]];
							}, $sms_msg);
						}
						
						$sqlsdf = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE id= '14'");
						$rowsm = mysql_fetch_assoc($sqlsdf);
						$sms_msg= $rowsm['sms_msg'];
						$from_page= $rowsm['from_page'];
						
						$query222 =mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, mk_id, breseller, agent_id, count_commission, com_percent FROM clients WHERE c_id = '$c_idd' ");
						$row22 = mysql_fetch_assoc($query222);
						$agentt_id = $row22['agent_id'];
						$count_commission = $row22['count_commission'];
						$client_com_percent = $row22['com_percent'];	
						$con_sts = $row22['con_sts'];	
						$mk_id = $row22['mk_id'];	
						$breseller = $row22['breseller'];	

							if($agentt_id != '0'){
								$sqlf = mysql_query("SELECT e_id, e_name, com_percent FROM agent WHERE sts = '0' AND e_id = '$agentt_id'");
								$rowaa = mysql_fetch_assoc($sqlf);
								$agent_id= $rowaa['e_id'];
								$agent_name= $rowaa['e_name'];
								$com_percent= $rowaa['com_percent'];
									if($count_commission == '1'){
										if($client_com_percent != '0.00'){
											$comission = ($vTranAmount/100)*$client_com_percent;
											$percent_count = $client_com_percent;
										}
										else{
											$comission = ($vTranAmount/100)*$com_percent;
											$percent_count = $com_percent;
										}
									}
									else{
										$comission = '0.00';
									}
							 }
							 else{
								 $agent_id = '0';
								 $percent_count = '0.00';
							 }
							 
							$sql1 = "INSERT INTO payment (c_id, bank, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, sender_no, trxid, pay_ent_date, pay_ent_by, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$c_idd', '$bkbank', '$update_date', '$payment', '$gateway', '$bill_disc', '$pay_desc', '$vDebitMSISDN', '$trxidd', '$update_date', '$c_idd', '$agent_id', '$count_commission', '$percent_count', '$comission', '2')";
							$resultsql1 = mysql_query($sql1) or die("inser_query failed: " . mysql_error() . "<br />");
							if($resultsql1){
								$querydfghdgh = "INSERT INTO payment_online (c_id, pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, pay_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$c_idd', '$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$trxidd', '$vTransactionStatus', '$payment', '$payment', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
								$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
									if($resultsdfgs){
											$sqlmqq = mysql_query("SELECT p.id AS mrno, z.z_name, c.cell, x.mk_profile, c.z_id, c.c_name, c.com_id, p.bill_discount, p.pay_ent_by FROM payment as p
																		LEFT JOIN clients as c on c.c_id = p.c_id 
																		LEFT JOIN zone as z on z.z_id = c.z_id 
																		LEFT JOIN package AS x ON x.p_id = c.p_id
																		WHERE p.c_id = '$c_idd' ORDER BY p.id DESC LIMIT 1");
												$rowmkqq = mysql_fetch_assoc($sqlmqq);
												$mrno = $rowmkqq['mrno'];
												$z_name = $rowmkqq['z_name'];
												$cell = $rowmkqq['cell'];
												$z_id = $rowmkqq['z_id'];
												$c_namee = $rowmkqq['c_name'];
												$com_id = $rowmkqq['com_id'];
												$mk_profile = $rowmkqq['mk_profile'];
												
												if($count_commission == '1'){
													$sql1com = mysql_query("INSERT INTO agent_commission (payment_id, c_id, agent_id, z_id, com_percent, payment_amount, amount, bill_date, bill_time, entry_by, note) VALUES ('$mrno', '$c_idd', '$agent_id', '$z_id', '$percent_count', '$payment', '$comission', '$update_date', '$update_time', '$c_idd', '$pay_desc')");
												}
												
												$sql2 = mysql_query("SELECT c.c_id, (b.bill-p.paid) AS due FROM clients AS c
																	LEFT JOIN
																	(SELECT c_id, SUM(bill_amount) AS bill FROM billing GROUP BY c_id)b
																	ON b.c_id = c.c_id
																	LEFT JOIN
																	(SELECT c_id, (SUM(pay_amount) + SUM(bill_discount)) AS paid FROM payment GROUP BY c_id)p
																	ON p.c_id = c.c_id

																	WHERE c.c_id = '$c_idd'");
												$rows = mysql_fetch_array($sql2);
												$Dewamount = $rows['due'];

//TELEGRAM Start....
if($tele_sts == '0' && $webhook_client_payment == '0'){
$telete_way = 'webhook_client';
$msg_body='..::[Client Payment on '.$gateway.']::..
'.$c_namee.' ['.$c_idd.'] ['.$z_name.']

Gateway: '.$gateway.'

Sender No: '.$vDebitMSISDN.'
TrxID: '.$trxidd.'
Reference: '.$vTransactionReference.'

Amount: '.$vTranAmount.' TK
Balance: '.$Dewamount.' TK

By: '.$c_namee.'
'.$tele_footer.'
[..::webhook::..]';

include('include/telegramapicore.php');
}
//TELEGRAM END....

											if($con_sts == 'Inactive' && $Dewamount <= '1'){
												include("mk_api.php");
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

													}
													else{
														$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_idd,));

														$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "no", "profile" => $mk_profile));
														$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_idd,));
														$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
													}
												$API->disconnect();
												
												$autoactivesms = '& Re-activated';
												}

												$queryq ="UPDATE clients SET con_sts = 'Active', con_sts_date = '$update_date' WHERE c_id = '$c_idd'";
												if (!mysql_query($queryq)){die('Error: ' . mysql_error());}
												
												$query1q ="INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by, note) VALUES ('$c_idd', 'Active', '$update_date', '$update_time', '$c_idd', '$pay_desc')";
												if (!mysql_query($query1q)){die('Error: ' . mysql_error());}
											}
											else{
												$autoactivesms = '';
											}

											//SMS Start....
											$replacements = array(
												'c_id' => $c_idd,
												'com_id' => $com_id,
												'c_name' => $c_namee,
												'PaymentAmount' => $vTranAmount,
												'PaymentDiscount' => $bill_disc,
												'PaymentMethod' => $gateway,
												'TotalDue' => $Dewamount,
												'SenderNo' => $vDebitMSISDN,
												'Reference' => $vTransactionReference,
												'TrxId' => $trxidd,
												'AutoActiveMsg' => $autoactivesms,
												'company_name' => $comp_name,
												'company_cell' => $company_cell
												);

											$sms_body = bind_to_template($replacements, $sms_msg);
											$send_by = '';
											include('include/smsapicore.php');
											//SMS END....
										}
									}
}
elseif($user_type == 'mreseller' && $c_idd != ''){
include('include/smsapi.php');
	function bind_to_template($replacements, $sms_msg) {
		return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) {
			return $replacements[$matches[1]];
		}, $sms_msg);
	}

$sqlsdf = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE id= '15'");
$rowsm = mysql_fetch_assoc($sqlsdf);
$sms_msg= $rowsm['sms_msg'];
$from_page= $rowsm['from_page'];

$query222 =mysql_query("SELECT e.agent_id, e.count_commission, e.com_percent, e.e_cont_per, e.z_id, e.e_name, z.z_name FROM emp_info AS e LEFT JOIN zone AS z ON z.z_id = e.z_id WHERE e.e_id = '$c_idd'");
$row22 = mysql_fetch_assoc($query222);

$agentt_id = $row22['agent_id'];
$count_commission = $row22['count_commission'];
$client_com_percent = $row22['com_percent'];
$z_id = $row22['z_id'];
$z_name = $row22['z_name'];
$cell = $row22['e_cont_per'];
$reseller_name = $row22['e_name'];

$sql111 = mysql_query("SELECT SUM(b.bill_amount) AS totbill FROM billing_mac AS b WHERE b.z_id = '$z_id'");
$rowww = mysql_fetch_array($sql111);

$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p	WHERE p.z_id = '$z_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

$opening_balance = $rowwz['retotalpayments']-$rowww['totbill'];
$closing_balance =  $opening_balance + ($dgdgdfg + $discount);

if($agentt_id != '0'){
$sqlf = mysql_query("SELECT e_id, e_name, com_percent FROM agent WHERE sts = '0' AND e_id = '$agentt_id'");
$rowaa = mysql_fetch_assoc($sqlf);
$agent_id= $rowaa['e_id'];
$agent_name= $rowaa['e_name'];
$com_percent= $rowaa['com_percent'];

		if($count_commission == '1'){
			if($client_com_percent != '0.00'){
				$comission = ($vTranAmount/100)*$client_com_percent;
				$percent_count = $client_com_percent;
			}
			else{
				$comission = ($vTranAmount/100)*$com_percent;
				$percent_count = $com_percent;
			}
		}
		else{
			$comission = '0.00';
		}
 }
 else{
	$agent_id = '0';
	$percent_count = '0.00';
}

$sql1 = "INSERT INTO payment_macreseller (e_id, z_id, bank, pay_date, pay_time, pay_mode, discount, pay_amount, opening_balance, closing_balance, entry_by, date_time, note, trxid, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$c_idd', '$z_id', '$bkbank', '$update_date', '$update_time', '$gateway', '$bill_disc', '$payment', '$opening_balance', '$closing_balance', '$c_idd', '$date_time', '$pay_desc', '$trxidd', '$agent_id', '$count_commission', '$percent_count', '$comission', '2')";
$resultsql1 = mysql_query($sql1) or die("inser_query failed: " . mysql_error() . "<br />");
if($resultsql1){
	$querydfghdgh = "INSERT INTO payment_online (reseller_id, pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, pay_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$c_idd', '$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$trxidd', '$vTransactionStatus', '$payment', '$payment', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
	$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
		if($resultsql1){
			if($count_commission == '1'){
				$sqlmqq = mysql_query("SELECT id AS mrno, e_id FROM payment_macreseller WHERE e_id = '$c_idd' ORDER BY id DESC LIMIT 1");
				$rowmkqq = mysql_fetch_assoc($sqlmqq);
				$mrno = $rowmkqq['mrno'];
				
				$sql1com = mysql_query("INSERT INTO agent_commission (payment_id, reseller_id, agent_id, z_id, com_percent, payment_amount, amount, bill_date, bill_time, entry_by) VALUES ('$mrno', '$c_idd', '$agent_id', '$z_id', '$percent_count', '$payment', '$comission', '$update_date', '$update_time', '$c_idd')");
			}
			
if($tele_sts == '0' && $webhook_reseller_recharge == '0'){
$telete_way = 'webhook_reseller';
$msg_body='..::[Reseller Payment on '.$gateway.']::..
'.$reseller_name.' ['.$c_idd.'] ['.$z_name.']

Gateway: '.$gateway.'

Sender No: '.$vDebitMSISDN.'
TrxID: '.$trxidd.'
Reference: '.$vTransactionReference.'

Amount: '.$vTranAmount.' TK
Balance: '.$closing_balance.' TK

By: '.$reseller_name.'
'.$tele_footer.'
[..::webhook::..]';

include('include/telegramapicore.php');
}
				//SMS Start....
				$replacements = array(
					'ResellerName' => $reseller_name,
					'PaymentAmount' => $vTranAmount,
					'PaymentDiscount' => $bill_disc,
					'PaymentMethod' => $gateway,
					'OpeningBalance' => $opening_balance,
					'ClosingBalance' => $closing_balance,
					'SenderNo' => $vDebitMSISDN,
					'Reference' => $vTransactionReference,
					'TrxId' => $trxidd,
					'company_name' => $comp_name,
					'company_cell' => $company_cell
					);

				$sms_body = bind_to_template($replacements, $sms_msg);
				$send_by = '';
				include('include/smsapicore.php');
				//SMS END....
		}
}
}
else{
$querydfghdgh = "INSERT INTO payment_online (pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, payment_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$trxidd', '$vTransactionStatus', '$payment', '$payment', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");

if($resultsdfgs){
if($tele_sts == '0'){
$msg_body='..::[Payment Receive on '.$gateway.']::..

Gateway: '.$gateway.'

Sender No: '.$vDebitMSISDN.'
TrxID: '.$trxidd.'
Reference: '.$vTransactionReference.'
Amount: '.$vTranAmount.' TK

'.$tele_footer.'
[..::webhook::..]';

include('include/telegramapicore.php');
}
}
}
}
else{
$querydfghdgh = "INSERT INTO payment_online (pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, payment_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$trxidd', '$vTransactionStatus', '$payment', '$payment', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");

if($resultsdfgs){
if($tele_sts == '0'){
$msg_body='..::[Payment Receive on '.$gateway.']::..

Gateway: '.$gateway.'

Sender No: '.$vDebitMSISDN.'
TrxID: '.$trxidd.'
Amount: '.$vTranAmount.' TK

'.$tele_footer.'
[..::webhook::..]';

include('include/telegramapicore.php');
}
}
}

				//$sql = "INSERT INTO payment (dateTime, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, transactionType, amount, currency, transactionReference)
				//VALUES ('$vDateTime', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$vTrxID', '$vTransactionStatus', '$vTransactionType', '$vTranAmount', '$vCurrency', '$vTransactionReference')";
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
}

//bKash End
?>