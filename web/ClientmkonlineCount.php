<?php
include("conn/connection.php");
include("mk_api.php");	

$mk_id = $_GET['mk_id'];

$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk1 = mysql_fetch_assoc($sqlmk1);

$ServerIP1 = $rowmk1['ServerIP'];
$Username1 = $rowmk1['Username'];
$Pass1= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
$Port1 = $rowmk1['Port'];
$API = new routeros_api();
$API->debug = false;
				if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
						$arrID = $API->comm('/ppp/active/getall');
						$mk_online = count($arrID);

						echo $mk_online;
						$API->disconnect();
				}
?>
