<?php
include("conn/connection.php") ;
include("mk_api.php");
$mk_id = $_POST['mk_id'];
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;



  if($_POST) 
  { ?>
<p>
						<label style="font-weight: bold;">Profile Name*</label>
						<span class="field">
						<select style="font-weight: bold;width: 280px;" name="mk_profile" onChange="getRoutePoint1(this.value)" required="">
							<option value="">Choose Package Profile</option>
							<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
										$arrID = $API->comm('/ppp/profile/getall');
										foreach($arrID as $x => $x_value){
										$profile_name = $x_value['name'];
										$localaddress = $x_value['local-address'];
										$remoteaddress = $x_value['remote-address'];
							echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.'</option>';}
							}
							else{echo 'Selected Network are not Connected.';}
							?>
						</select>
						</span>
					</p>



 <?php }
?>