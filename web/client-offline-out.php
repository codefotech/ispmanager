<?php
include("conn/connection.php") ;
include("mk_api.php");
$mk_id = $_GET['mk_id'];
$c_id = $_GET['c_id'];
$sts = $_GET['sts'];

if($sts == 'offline'){
$API = new routeros_api();
$API->debug = false;

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h, online_sts FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
		$online_stsss = $rowmk['online_sts'];

if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
		$API->write('/ppp/secret/print', false);
		$API->write('?name='.$c_id);
		$ress=$API->read(true);
		$API->disconnect();
		
		$ppp_lastloggedout = $ress[0]['last-logged-out'];

   $API->disconnect();
	?>
									<table class="table table-bordered" style="width: 100%;border-top: 1px solid #ddd;">
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;background: #eee;">Last Logout At</td>
											<td class="width70" style="padding: 6px;background: white;"><a style="color: red;font-weight: bold;"><?php echo $ppp_lastloggedout;?></a></td>
										</tr>
									</table>
<?php } else{echo 'Network are not Connected.';}}?>