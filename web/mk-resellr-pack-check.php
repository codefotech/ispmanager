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

    if ($API->connect($ServerIP, $Username, $Pass, $Port)) {?>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />

<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/elements.js"></script>						
			<p>
							<label style="font-weight: bold;">Packages* </label>
								<table class="table table-bordered responsive" style="text-align: center;width: 70%;">
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
										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">1.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile1" required="" onChange="getRoutePoint1(this.value)"/>
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
													<input type="text" class="input-small" style="width: 90%;font-weight: bold;" placeholder="Package Name"/>
												</div>
											</td>	
											<td class="center">
												<input type="text" class="input-small" name="bandwith1" required="" placeholder="2.5 mbps" style="font-weight: bold;"/>
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" required="" name="p_price1" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>
										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">2.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile2" onChange="getRoutePoint2(this.value)"/>
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
													<input class="input-small" style="width: 90%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
												</div>
											</td>
											<td class="center">
												<input type="text" class="input-small" style="font-weight: bold;" name="bandwith2" placeholder="2.5 mbps" style="font-weight: bold;"/>
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" name="p_price2" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>
										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">3.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile3" onChange="getRoutePoint3(this.value)"/>
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
													<input class="input-small" style="width: 90%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
												</div>
											</td>
											<td class="center">
												<input type="text" class="input-small" style="font-weight: bold;" name="bandwith3" placeholder="2.5 mbps" />
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" name="p_price3" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>

										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">4.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile4" onChange="getRoutePoint4(this.value)"/>
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
													<input class="input-small" style="width: 90%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
												</div>
											</td>
											<td class="center">
												<input type="text" class="input-small" style="font-weight: bold;" name="bandwith4" placeholder="2.5 mbps" />
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" name="p_price4" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>
										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">5.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile5" onChange="getRoutePoint5(this.value)"/>
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
													<input class="input-small" style="width: 90%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
												</div>
											</td>
											<td class="center">
												<input type="text" class="input-small" style="font-weight: bold;" name="bandwith5" placeholder="2.5 mbps" />
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" name="p_price5" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>
										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">6.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile6" onChange="getRoutePoint6(this.value)"/>
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
													<input class="input-small" style="width: 90%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
												</div>
											</td>
											<td class="center">
												<input type="text" class="input-small" style="font-weight: bold;" name="bandwith6" placeholder="2.5 mbps" />
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" name="p_price6" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>
										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">7.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile7" onChange="getRoutePoint7(this.value)"/>
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
													<input class="input-small" style="width: 90%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
												</div>
											</td>
											<td class="center">
												<input type="text" class="input-small" style="font-weight: bold;" name="bandwith7" placeholder="2.5 mbps" />
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" name="p_price7" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>
										<tr>
											<td class="center" style="font-size: 15px;font-weight: bold;padding-top: 12px;">8.</td>
											<td class="center">
												<select style="width:100%;padding: 5px 10px;" class="select-large chzn-select" name="mk_profile8" onChange="getRoutePoint8(this.value)"/>
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
													<input class="input-small" style="width: 90%;font-weight: bold;" type="text" name="" placeholder="Package Name"/>
												</div>
											</td>
											<td class="center">
												<input type="text" class="input-small" style="font-weight: bold;" name="bandwith8" placeholder="2.5 mbps" />
											</td>
											<td class="center">
												<input type="text" style="width: 45%;font-weight: bold;" name="p_price8" placeholder="260" onkeypress="return isNumberKey(event)"/><input type="text" name="" id="" style="width:15%; color:#2e3e4e; font-weight: bold;font-size: 15px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;" value='৳' readonly />
											</td>
										</tr>
									</tbody>
								</table>
						</p>
<?php } else{echo 'Selected Network are not Connected.';} ?>
