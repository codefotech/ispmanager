<?php
$titel = "Add Package";
$Package = 'active';
include('include/hader.php');
include("mk_api.php");
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Package' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($userr_typ == 'superadmin' || $userr_typ == 'admin'){
	
if($wayyy == 'resellerpackage'){
	$query2 = mysql_query("SELECT mk_id FROM emp_info WHERE z_id = '$z_id' ORDER BY id DESC LIMIT 1");
	$row2 = mysql_fetch_assoc($query2);
	$mk_id = $row2['mk_id'];
}
if($wayyy == 'own'){
	$mk_id = $mk_id;
}

if($_GET['wayyy'] == 'own'){
	$mk_id = $_GET['mk_id'];
}


$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-tasks"></i></div>
        <div class="pagetitle">
            <h1>Add Packages</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New Packages</h5>
				</div>
					<form id="form" class="stdform" method="post" action="PackageAddQuery">
						<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>"/>
							<div class="modal-body">
						 <?php if($API->connect($ServerIP, $Username, $Pass, $Port)) {?>
											<table class="table table-bordered responsive" style="text-align: center;width: 90%;margin-left: 5%;">
												 <thead>
													<tr>	
														<th style="width: 2%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">S/L</th>
														<th style="width: 43%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">MIKROTIK PROFILE</th>
														<th style="width: 30%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">PACKAGE NAME</th>
														<th style="width: 10%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">BANDWITH</th>
														<th style="width: 15%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">PRICE</th>
													</tr>
												 </thead>
												 <tbody>
												 <?php	if($wayyy == 'resellerpackage'){
														echo "<input type='hidden' class='input-small' name='z_id' readonly style='width: 90%;font-weight: bold;' value='$z_id' />";
															$sql1 = mysql_query("SELECT * FROM package WHERE z_id = '$z_id' AND status = '0'");
															for($i=0; $i<20; $i++){											
																while($row2 = mysql_fetch_assoc($sql1)){	$i = $i+1;													
																		echo														
																		"<tr>											
																			<td class='center' style='font-size: 15px;font-weight: bold;padding: 10px 0;color: #3c8dbc;'>{$row2['p_id']}</td>											
																			<td class='center'>													
																				<input type='text' class='input-small' readonly style='width: 98%;font-weight: bold;' value='{$row2['mk_profile']}' />
																			</td>
																			<td class='center'>													
																				<input type='text' class='input-small' readonly style='width: 98%;font-weight: bold;' value='{$row2['p_name']}' />
																			</td>												
																			<td class='center'>												
																				<input type='text' class='input-small' readonly style='font-weight: bold;width: 80%;' value='{$row2['bandwith']}'/>
																			</td>											
																			<td class='center'>												
																				<input type='text' style='width: 50%;font-weight: bold;' readonly  value='{$row2['p_price']}'/><input type='text' style='width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-left: 0px solid #bbb;' value='৳' readonly />
																			</td>											
																			</tr>\n";
															}}} else{echo "<input type='hidden' class='input-small' name='z_id' readonly value='' />";}
												?>
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">1</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile1" required="" onChange="getRoutePoint1(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv1">
																<input type="text" class="input-small" style="width: 98%;font-weight: bold;" placeholder="Package Name"/>
															</div>
														</td>	
														<td class="center">
															<input type="text" class="input-small" name="bandwith1" required="" placeholder="2.5 mbps" style="width: 80%;font-weight: bold;"/>
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" required="" name="p_price1" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">2</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile2" onChange="getRoutePoint2(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv2">
																<input type="text" class="input-small" style="width: 98%;font-weight: bold;" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" name="bandwith2" placeholder="2.5 mbps" style="width: 80%;font-weight: bold;"/>
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price2" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">3</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile3" onChange="getRoutePoint3(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv3">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith3" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price3" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>

													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">4</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile4" onChange="getRoutePoint4(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv4">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith4" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price4" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">5</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile5" onChange="getRoutePoint5(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv5">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith5" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price5" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">6</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile6" onChange="getRoutePoint6(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv6">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith6" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price6" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">7</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile7" onChange="getRoutePoint7(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv7">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith7" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price7" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">8</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile8" onChange="getRoutePoint8(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv8">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith8" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price8" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">9</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile9" onChange="getRoutePoint9(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv9">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith9" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price9" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
													
													<tr>
														<td class="center" style="font-size: 15px;font-weight: bold;padding: 10px 0;color: red;">10</td>
														<td class="center">
															<select style="width:100%;" class="" name="mk_profile10" onChange="getRoutePoint10(this.value)"/>
																<option value="">Choose Package Profile</option>
																<?php if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
																			$arrID = $API->comm('/ppp/profile/getall');
																			foreach($arrID as $x => $x_value){
																			$profile_name = $x_value['name'];
																			$localaddress = $x_value['local-address'];
																			$remoteaddress = $x_value['remote-address'];
																echo '<option value="'.$profile_name.'">'.$profile_name.' - '.$localaddress.' - '.$remoteaddress.'</option>';}
																}
																else{echo 'Selected Network are not Connected.';}
																?>
															</select> 
														</td>
														<td class="center">
															<div id="Pointdiv10">
																<input class="input-small" style="width: 98%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
															</div>
														</td>
														<td class="center">
															<input type="text" class="input-small" style="font-weight: bold;width: 80%;" name="bandwith10" placeholder="2.5 mbps" />
														</td>
														<td class="center">
															<input type="text" style="width: 50%;font-weight: bold;" name="p_price10" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 14px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
														</td>
													</tr>
												</tbody>
											</table>
							<?php } else{echo 'Selected Network are not Connected.';}?>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn ownbtn11">Reset</button>
								<button class="btn ownbtn2" type="submit">Submit</button>
							</div>
					</form>			
			</div>
		</div>
	</div>
<?php
}
else{echo "Sorry to say, You are not authorized. Don't try again.";}
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }

		function getRoutePoint1(afdId) {		
		
		var strURL="mk-reseller-packagename1.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
			function getRoutePoint2(afdId) {		
		
		var strURL="mk-reseller-packagename2.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv2').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
			function getRoutePoint3(afdId) {		
		
		var strURL="mk-reseller-packagename3.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv3').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
			function getRoutePoint4(afdId) {		
		
		var strURL="mk-reseller-packagename4.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv4').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
			function getRoutePoint5(afdId) {		
		
		var strURL="mk-reseller-packagename5.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv5').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
				function getRoutePoint6(afdId) {		
		
		var strURL="mk-reseller-packagename6.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv6').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
				function getRoutePoint7(afdId) {		
		
		var strURL="mk-reseller-packagename7.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv7').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint8(afdId) {		
		
		var strURL="mk-reseller-packagename8.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv8').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint9(afdId) {		
		
		var strURL="mk-reseller-packagename9.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv9').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint10(afdId) {		
		
		var strURL="mk-reseller-packagename10.php?mk_profile="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv10').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
    </script>