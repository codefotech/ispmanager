<?php
include("conn/connection.php") ;
include("mk_api.php");
$mk_id = $_GET['mk_id'];
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;



  if($_POST) 
  {
	   $ip     = strip_tags($_POST['ip']);
    if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

		$API->write('/queue/simple/getall', false);
		$API->write('?target='.$ip.'/32');
		$res=$API->read(true);

		$ppp_name = $res[0]['name']; 
		if($ppp_name == ''){?>
		
		<p>
			<label></label>
			<span class="field" style="margin-left: 0px;">
				<a style="font-weight: bold;color: green;">THIS IP IS FREE</a>
			</span>
		</p>
		<?php }else{ ?> 
		<p>
			<label></label>
			<span class="field" style="margin-left: 0px;">
				<select name="" class="chzn-select" style="width:250px;color: red;height: 27px;" required="">
					<option value="">[<?php echo $ppp_name; ?>] ARE USING THIS IP</option>
				</select>
			</span>
		</p>
	<?php }}else{echo 'Selected Network are not Connected.';}
  }
?>