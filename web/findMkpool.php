<?php 
include("conn/connection.php") ;
include("mk_api.php");
$p_id = $_GET['p_id'];

$result1zz=mysql_query("SELECT p_id, mk_profile FROM package WHERE status = '0' AND z_id = '' AND p_id = '$p_id'");
$rows1 = mysql_fetch_assoc($result1zz);
$mk_profile = $rows1['mk_profile'];

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '1'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;

 if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

		$API->write('/ppp/profile/print', false);
		$API->write('?name='.$mk_profile);
		$res=$API->read(true);

		$remoteaddress = $res[0]['local-address']; 
$API->disconnect();
?>
		<p>
			<label style="width: 130px;font-weight: bold;">IP Address*</label>
			<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" id="ip" name="ip" placeholder="Ex: 192.168.XX.XX" value=<?php echo $remoteaddress; ?> class="input-xlarge" required=""/></span>
		</p>
<?php
}else{echo 'Selected Network are not Connected.';}
?>

