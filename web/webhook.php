<?php 
include('company_info.php');
include('include/telegramapi.php');
$gateway='bKash';
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$date_time = date('Y-m-d H:i:s', time());

//bKash Start

//payload
$payload  = (array)json_decode(file_get_contents('php://input'));
//writeLog('Payload',$payload);

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
//				writeLog('Subscribe',$subscribeURL);
				//subscribe
				$url = curl_init($subscribeURL);
				curl_exec($url);
			}
			else if($messageType=="Notification"){
				$notificationData = $payload['Message'];
				$UnsubscribeURL = $payload['UnsubscribeURL'];
//				writeLog('NotificationData-Message',$notificationData);
				
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
				
				
				$bkkkaass=mysql_query("SELECT COUNT(id) AS oldpaymenttx FROM `payment` WHERE `trxid` = '$vTrxID'");
				$rowbksssa=mysql_fetch_array($bkkkaass);
				$oldpaymenttx=$rowbksssa['oldpaymenttx'];
					
				$bkkkaarr=mysql_query("SELECT COUNT(id) AS resellerpaymenttx FROM `payment_macreseller` WHERE `trxid` = '$vTrxID'");
				$rowbkssrr=mysql_fetch_array($bkkkaarr);
				$resellerpaymenttx=$rowbkssrr['resellerpaymenttx'];
				
				if($oldpaymenttx == '0' && $resellerpaymenttx == '0'){
				if($vTransactionReference != ''){
					$bkkk=mysql_query("SELECT l.e_id, l.user_id, l.user_type FROM login AS l LEFT JOIN clients AS c ON c.c_id = l.user_id WHERE l.e_id = '$vTransactionReference' AND c.mac_user = '0'");
					$rowbk=mysql_fetch_array($bkkk);
					
					$e_idd = $rowbk['e_id'];
					$c_idd = $rowbk['user_id'];
					$user_type = $rowbk['user_type'];
					$payment = $vTranAmount;
					$bill_disc = '0.00';
					$pay_desc = 'bKash Webhook';
					$trxidd = $vTrxID;
					
					$bkkkaa=mysql_query("SELECT bank FROM payment_online_setup WHERE id = '1'");
					$rowbkss=mysql_fetch_array($bkkkaa);
					$bkbank=$rowbkss['bank'];
					
					if($user_type == 'client' || $user_type == 'breseller' && $c_idd != ''){
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
						
						$query222 =mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, mk_id, ip, queue_type, breseller, agent_id, count_commission, com_percent FROM clients WHERE c_id = '$c_idd' ");
						$row22 = mysql_fetch_assoc($query222);
						$agentt_id = $row22['agent_id'];
						$count_commission = $row22['count_commission'];
						$client_com_percent = $row22['com_percent'];	
						$con_sts = $row22['con_sts'];	
						$ip = $row22['ip'];	
						$queue_type = $row22['queue_type'];	
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
							 
							$sql1 = "INSERT INTO payment (c_id, bank, pay_date, pay_amount, pay_mode, bill_discount, pay_desc, sender_no, trxid, pay_ent_date, pay_ent_by, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$c_idd', '$bkbank', '$update_date', '$vTranAmount', '$gateway', '$bill_disc', '$pay_desc', '$vDebitMSISDN', '$trxidd', '$update_date', '$c_idd', '$agent_id', '$count_commission', '$percent_count', '$comission', '2')";
							$resultsql1 = mysql_query($sql1) or die("inser_query failed: " . mysql_error() . "<br />");
							if($resultsql1){
								$querydfghdgh = "INSERT INTO payment_online (c_id, pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, pay_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$c_idd', '$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$trxidd', '$vTransactionStatus', '$vTranAmount', '$vTranAmount', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
								$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
								if($resultsdfgs){
									$sqlmqq = mysql_query("SELECT p.id AS mrno, z.z_name, c.cell, x.mk_profile, c.z_id, c.c_name, p.bill_discount, p.pay_ent_by FROM payment as p
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
										$mk_profile = $rowmkqq['mk_profile'];
										
										if($count_commission == '1'){
											$sql1com = mysql_query("INSERT INTO agent_commission (payment_id, c_id, agent_id, z_id, com_percent, payment_amount, amount, bill_date, bill_time, entry_by, note) VALUES ('$mrno', '$c_idd', '$agent_id', '$z_id', '$percent_count', '$vTranAmount', '$comission', '$update_date', '$update_time', '$c_idd', '$pay_desc')");
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

									Sender No: '.$vDebitMSISDN.'
									TrxID: '.$trxidd.'
									Reference: '.$vTransactionReference.'

									Amount: '.$vTranAmount.' TK
									New Balance: '.$Dewamount.' TK

									By: '.$c_namee.'
									'.$tele_footer.'[..::webhook::..]';

									include('include/telegramapicore.php');
								}
								//TELEGRAM END....

									$sql233 = mysql_query("SELECT p_price, bill_amount FROM billing WHERE c_id = '$c_idd' ORDER BY id DESC LIMIT 1");
									$rows33 = mysql_fetch_array($sql233);
									$billamount = $rows33['bill_amount'];
									if($con_sts == 'Inactive' && $Dewamount <= '1' && $billamount != '0'){
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
												$arrID = $API->comm("/ip/firewall/address-list/getall", array(".proplist"=> ".id","?address" => $ip,));
														 $API->comm("/ip/firewall/address-list/set", array(".id" => $arrID[0][".id"],"list" => $queue_type,));
											}
											else{
												$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_idd,));

												$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "no", "profile" => $mk_profile));
												$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_idd,));
												$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
											}
									//												$API->disconnect();
										
										$autoactivesms = ' & Account Re-activated';
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

								$c_idd = $e_idd;
								$sqlsdf = mysql_query("SELECT sms_msg, from_page FROM sms_msg WHERE id= '15'");
								$rowsm = mysql_fetch_assoc($sqlsdf);
								$sms_msg= $rowsm['sms_msg'];
								$from_page= $rowsm['from_page'];

								$query222 =mysql_query("SELECT e.agent_id, e.count_commission, e.com_percent, e.e_cont_per, e.z_id, e.e_name, z.z_name FROM emp_info AS e LEFT JOIN zone AS z ON z.z_id = e.z_id WHERE e.e_id = '$e_idd'");
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
								$closing_balance =  $opening_balance + $vTranAmount;

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

							$sql1 = "INSERT INTO payment_macreseller (e_id, z_id, bank, pay_date, pay_time, pay_mode, discount, pay_amount, opening_balance, closing_balance, entry_by, date_time, note, trxid, agent_id, commission_sts, com_percent, commission_amount, payment_type) VALUES ('$e_idd', '$z_id', '$bkbank', '$update_date', '$update_time', '$gateway', '$bill_disc', '$vTranAmount', '$opening_balance', '$closing_balance', '$e_idd', '$date_time', '$pay_desc', '$trxidd', '$agent_id', '$count_commission', '$percent_count', '$comission', '2')";
							$resultsql1 = mysql_query($sql1) or die("inser_query failed: " . mysql_error() . "<br />");
							if($resultsql1){
								$querydfghdgh = "INSERT INTO payment_online (reseller_id, pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, pay_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$e_idd', '$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$trxidd', '$vTransactionStatus', '$vTranAmount', '$vTranAmount', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
								$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
								if($resultsql1){
									if($count_commission == '1'){
										$sqlmqq = mysql_query("SELECT id AS mrno, e_id FROM payment_macreseller WHERE e_id = '$e_idd' ORDER BY id DESC LIMIT 1");
										$rowmkqq = mysql_fetch_assoc($sqlmqq);
										$mrno = $rowmkqq['mrno'];
										
										$sql1com = mysql_query("INSERT INTO agent_commission (payment_id, reseller_id, agent_id, z_id, com_percent, payment_amount, amount, bill_date, bill_time, entry_by) VALUES ('$mrno', '$e_idd', '$agent_id', '$z_id', '$percent_count', '$vTranAmount', '$comission', '$update_date', '$update_time', '$e_idd')");
									}
											
								if($tele_sts == '0' && $webhook_reseller_recharge == '0'){
									$telete_way = 'webhook_reseller';
									$msg_body='..::[Reseller Payment on bKash Webhook]::..
									'.$reseller_name.' ['.$e_idd.'] ['.$z_name.']

									Sender No: '.$vDebitMSISDN.'
									TrxID: '.$trxidd.'
									Reference: '.$vTransactionReference.'

									Amount: '.$vTranAmount.' TK
									Balance: '.$closing_balance.' TK

									By: '.$reseller_name.'
									'.$tele_footer.'[..::webhook::..]';

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
							$querydfghdgh = "INSERT INTO payment_online (pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, pay_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$vTrxID', '$vTransactionStatus', '$vTranAmount', '$vTranAmount', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
							$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");

							if($resultsdfgs){
								if($tele_sts == '0'){
								$telete_way = 'webhook_reseller';
								$msg_body='..::[Payment Receive on bKash Webhook]::..

								Sender No: '.$vDebitMSISDN.'
								TrxID: '.$vTrxID.'
								Reference: '.$vTransactionReference.'
								[Reference Not Matched]

								Amount: '.$vTranAmount.' TK

								'.$tele_footer.'[..::webhook::..]';

								include('include/telegramapicore.php');
								}
							}
						}
					}
					else{
						$querydfghdgh = "INSERT INTO payment_online (pay_mode, date_time, dateTime, sender_no, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, amount, pay_amount, currency, transactionType, transactionReference, webhook_all, webhook) VALUES ('$gateway', '$date_time', '$vDateTime', '$vDebitMSISDN', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$vTrxID', '$vTransactionStatus', '$vTranAmount', '$vTranAmount', '$vCurrency', '$vTransactionType', '$vTransactionReference', '$notificationData', '1')";
						$resultsdfgs = mysql_query($querydfghdgh) or die("inser_query failed: " . mysql_error() . "<br />");
						if($resultsdfgs){
							if($tele_sts == '0'){
							$telete_way = 'webhook_reseller';
							$msg_body='..::[Payment Receive on bKash Webhook]::..

							Sender No: '.$vDebitMSISDN.'
							TrxID: '.$vTrxID.'
							[No Reference]

							Amount: '.$vTranAmount.' TK

							'.$tele_footer.'[..::webhook::..]';

							include('include/telegramapicore.php');
							}
						}
					}
				}
								$sqldfgedh = "INSERT INTO webhook (dateTime, debitMSISDN, creditOrganizationName, creditShortCode, trxID, transactionStatus, transactionType, amount, currency, transactionReference, UnsubscribeURL) VALUES ('$vDateTime', '$vDebitMSISDN', '$vCreditOrganizationName', '$vCreditShortCode', '$vTrxID', '$vTransactionStatus', '$vTransactionType', '$vTranAmount', '$vCurrency', '$vTransactionReference', '$UnsubscribeURL')";
								$resultsdfgsdhfgedh = mysql_query($sqldfgedh) or die("inser_query failed: " . mysql_error() . "<br />");
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
//		writeLog('SignatureVersion-Error', $errorLog);
	}else{
		foreach ($signableKeys as $key) {
			if (isset($message[$key])) {
				$stringToSign .= "{$key}\n{$message[$key]}\n";
			}
		}
//		writeLog('StringToSign', $stringToSign."\n");
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



//bKash End
?>