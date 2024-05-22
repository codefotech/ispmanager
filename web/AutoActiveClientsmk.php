<?php
		include("conn/connection.php");
		include("mk_api.php");	
		$mk_id = $_GET['id'];
		$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk1 = mysql_fetch_assoc($sqlmk1);
		
		$ServerIP1 = $rowmk1['ServerIP'];
		$Username1 = $rowmk1['Username'];
		$Pass1= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
		$Port1 = $rowmk1['Port'];
		$API = new routeros_api();
		$API->debug = false;
						if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)) {
								$arrID = $API->comm('/ppp/active/getall');
								foreach($arrID as $x => $x_value) {
									
									$aaaaa = $x_value['name'];
									$sql44 = mysql_query("SELECT mk_id FROM clients WHERE c_id = '$aaaaa'");
									$rows1 = mysql_fetch_assoc($sql44);
									$old_mk_id = $rows1['mk_id'];

									if($old_mk_id != $mk_id){
										
										$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$old_mk_id'");
										$rowmk = mysql_fetch_assoc($sqlmk);
										
										$ServerIP = $rowmk['ServerIP'];
										$Username = $rowmk['Username'];
										$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
										$Port = $rowmk['Port']; 
										
										if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
										$arrID2 =	$API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $aaaaa,));
													$API->comm("/ppp/secret/remove", array(".id" => $arrID2[0][".id"],));
										}
										
										$querysdfsd ="UPDATE clients SET mk_id = '$mk_id' WHERE c_id = '$aaaaa'";
										$resultsdgsd = mysql_query($querysdfsd) or die("inser_query failed: " . mysql_error() . "<br />");
									}
								}
								$API->disconnect();
						}
						
?>
