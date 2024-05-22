<?php 
session_start();
$userr_typ = $_SESSION['SESS_USER_TYPE'];
include("conn/connection.php");
include("company_info.php");
$bksts=$_GET['bksts'];
$bkstst=$_GET['bkstst'];
$rocketsts=$_GET['rocketsts'];
$nagadsts=$_GET['nagadsts'];
$ipaysts=$_GET['ipaysts'];
$sslsts=$_GET['sslsts'];
$sts=$_GET['sts'];

if($bksts == '0'){
$bkkk=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`, `app_key`,`app_secret`,`username`,`password`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '1'");
$rowbk=mysql_fetch_array($bkkk);
$bkid=$rowbk['id'];
$bkgetway_name=$rowbk['getway_name'];
$bkgetway_name_details=$rowbk['getway_name_details'];
$bkmerchant_number=$rowbk['merchant_number'];
$bkapp_key=$rowbk['app_key'];
$bkapp_secret=$rowbk['app_secret'];
$bkusername=$rowbk['username'];
$bkpassword=$rowbk['password'];
$bkbank=$rowbk['bank'];
$bkcharge=$rowbk['charge'];
$bkcharge_sts=$rowbk['charge_sts'];
$bkshow_sts=$rowbk['show_sts'];
$bkwebhook_sts=$rowbk['webhook_sts'];

$bkmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");

 ?>
<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
										<br/>
										
											<p>
												<label style="font-weight: bold;">Merchant Number*</label>
												<span class="field"><input type="text" name="bkmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $bkmerchant_number;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">App Key*</label>
												<span class="field"><input type="text" name="bkapp_key" id="" required="" class="input-large" value="<?php echo $bkapp_key;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">App Secret*</label>
												<span class="field"><input type="text" name="bkapp_secret" id="" required="" class="input-large" value="<?php echo $bkapp_secret;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">Username*</label>
												<span class="field"><input type="text" name="bkusername" id="" required="" class="input-large" value="<?php echo $bkusername;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">Password*</label>
												<span class="field"><input type="password" name="bkpassword" id="" required="" class="input-large" value="<?php echo $bkpassword;?>" placeholder="" /></span>
											</p>
											<p>	
												<label style="font-weight: bold;">Bank*</label>
												<select data-placeholder="Must Choose a Bank" name="bkbank" style="width:220px;" class="chzn-select" required="" />
													<option></option>
													<?php 
													while ($rowmathdddd=mysql_fetch_array($bkmathodsss)) { ?>
														<option value="<?php echo $rowmathdddd['id'];?>"<?php if($rowmathdddd['id'] == $bkbank) {echo 'selected="selected"';}?>><?php echo $rowmathdddd['id'];?>. <?php echo $rowmathdddd['bank_name'];?></option>
													<?php } ?>
												</select>
											</p>
											<p>
												<label>Add Charge?</a></label>
												<span class="formwrapper"  style="margin-left: 0px;">
													<input type="radio" name="bkcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $bkcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
													<input type="radio" name="bkcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $bkcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
												</span>
											</p>
											<p>
												<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
												<span class="field"><input type="text" name="bkcharge" id="" style="width:7%;" value="<?php echo $bkcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
											</p><br>
											<p>
												<label>Webhook</a></label>
												<span class="formwrapper"  style="margin-left: 0px;">
													<input type="radio" name="bkwebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $bkwebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
													<input type="radio" name="bkwebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $bkwebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
												</span>
											</p>
											<br>
											<br>
										</div>

<?php } if($bkstst == '0'){
$bkkkt=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`, `app_key`,`app_secret`,`username`,`password`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '6'");
$rowbkt=mysql_fetch_array($bkkkt);
$bkidt=$rowbkt['id'];
$bkgetway_namet=$rowbkt['getway_name'];
$bkgetway_name_detailst=$rowbkt['getway_name_details'];
$bkmerchant_numbert=$rowbkt['merchant_number'];
$bkapp_keyt=$rowbkt['app_key'];
$bkapp_secrett=$rowbkt['app_secret'];
$bkusernamet=$rowbkt['username'];
$bkpasswordt=$rowbkt['password'];
$bkbankt=$rowbkt['bank'];
$bkcharget=$rowbkt['charge'];
$bkcharge_stst=$rowbkt['charge_sts'];
$bkshow_stst=$rowbkt['show_sts'];
$bkwebhook_stst=$rowbkt['webhook_sts'];

$bkmathodssst = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");
?>
<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
										<br/>
										
											<p>
												<label style="font-weight: bold;">Merchant Number*</label>
												<span class="field"><input type="text" name="bkmerchant_numbert" id="" required="" style="width: 110px;" value="<?php echo $bkmerchant_numbert;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">App Key*</label>
												<span class="field"><input type="text" name="bkapp_keyt" id="" required="" class="input-large" value="<?php echo $bkapp_keyt;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">App Secret*</label>
												<span class="field"><input type="text" name="bkapp_secrett" id="" required="" class="input-large" value="<?php echo $bkapp_secrett;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">Username*</label>
												<span class="field"><input type="text" name="bkusernamet" id="" required="" class="input-large" value="<?php echo $bkusernamet;?>" placeholder="" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">Password*</label>
												<span class="field"><input type="password" name="bkpasswordt" id="" required="" class="input-large" value="<?php echo $bkpasswordt;?>" placeholder="" /></span>
											</p>
											<p>	
												<label style="font-weight: bold;">Bank*</label>
												<select data-placeholder="Must Choose a Bank" name="bkbankt" style="width:220px;" class="chzn-select" required="" />
													<option></option>
													<?php 
													while ($rowmathddddt=mysql_fetch_array($bkmathodssst)) { ?>
														<option value="<?php echo $rowmathddddt['id'];?>"<?php if($rowmathddddt['id'] == $bkbankt) {echo 'selected="selected"';}?>><?php echo $rowmathddddt['id'];?>. <?php echo $rowmathddddt['bank_name'];?></option>
													<?php } ?>
												</select>
											</p>
											<p>
												<label>Add Charge?</a></label>
												<span class="formwrapper"  style="margin-left: 0px;">
													<input type="radio" name="bkcharge_stst" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $bkcharge_stst) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
													<input type="radio" name="bkcharge_stst" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $bkcharge_stst) echo 'checked="checked"';?>> No &nbsp; &nbsp;
												</span>
											</p>
											<p>
												<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
												<span class="field"><input type="text" name="bkcharget" id="" style="width:7%;" value="<?php echo $bkcharget;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
											</p>
											<br>
											<br>
										</div>

<?php } 
if($rocketsts == '0'){
$rocketll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '4'");
$rowrocket=mysql_fetch_array($rocketll);
$rocketid=$rowrocket['id'];
$rocketgetway_name=$rowrocket['getway_name'];
$rocketgetway_name_details=$rowrocket['getway_name_details'];
$rocketmerchant_number=$rowrocket['merchant_number'];
$rocketstore_id=$rowrocket['store_id'];
$rocketpassword=$rowrocket['password'];
$rocketbank=$rowrocket['bank'];
$rocketcharge=$rowrocket['charge'];
$rocketcharge_sts=$rowrocket['charge_sts'];
$rocketshow_sts=$rowrocket['show_sts'];
$rockewebhook_sts=$rowrocket['webhook_sts'];

$rocketmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");

 ?>
 <div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
											<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="rocketmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $rocketmerchant_number;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="rocketbank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodfss=mysql_fetch_array($rocketmathodsss)) { ?>
															<option value="<?php echo $rodfss['id'];?>"<?php if($rodfss['id'] == $rocketbank) {echo 'selected="selected"';}?>><?php echo $rodfss['id'];?>. <?php echo $rodfss['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="rocketcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $rocketcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="rocketcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $rocketcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="rocketcharge" id="" style="width:7%;" value="<?php echo $rocketcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="rockewebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $rockewebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="rockewebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $rockewebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br>
												<br>
											</div>
<?php } if($nagadsts == '0'){
$nagadll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '5'");
$rownagad=mysql_fetch_array($nagadll);
$nagadid=$rownagad['id'];
$nagadgetway_name=$rownagad['getway_name'];
$nagadgetway_name_details=$rownagad['getway_name_details'];
$nagadmerchant_number=$rownagad['merchant_number'];
$nagadstore_id=$rownagad['store_id'];
$nagadpassword=$rownagad['password'];
$nagadbank=$rownagad['bank'];
$nagadcharge=$rownagad['charge'];
$nagadcharge_sts=$rownagad['charge_sts'];
$nagadshow_sts=$rownagad['show_sts'];
$nagadwebhook_sts=$rownagad['webhook_sts'];

$nagadmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");

?>
<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
												<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="nagadmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $nagadmerchant_number;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="nagadbank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodfssdd=mysql_fetch_array($nagadmathodsss)) { ?>
															<option value="<?php echo $rodfssdd['id'];?>"<?php if($rodfssdd['id'] == $nagadbank) {echo 'selected="selected"';}?>><?php echo $rodfssdd['id'];?>. <?php echo $rodfssdd['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="nagadcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $nagadcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="nagadcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $nagadcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="nagadcharge" id="" style="width:7%;" value="<?php echo $nagadcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="nagadwebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $nagadwebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="nagadwebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $nagadwebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br>
												<br>
											</div>
<?php } if($ipaysts == '0'){
$ipayyy=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`app_key`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '2'");
$rowipay=mysql_fetch_array($ipayyy);
$ipayid=$rowipay['id'];
$ipaygetway_name=$rowipay['getway_name'];
$ipaygetway_getway_name_details=$rowipay['getway_name_details'];
$ipaymerchant_number=$rowipay['merchant_number'];
$ipayapp_key=$rowipay['app_key'];
$ipaybank=$rowipay['bank'];
$ipaycharge=$rowipay['charge'];
$ipaycharge_sts=$rowipay['charge_sts'];
$ipayshow_sts=$rowipay['show_sts'];
$ipaywebhook_sts=$rowipay['webhook_sts'];

$ipaymathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");

?>
<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
												<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="ipaymerchant_number" id="" required="" style="width: 110px;" value="<?php echo $ipaymerchant_number;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">App Key*</label>
													<span class="field"><input type="password" name="ipayapp_key" id="" required="" class="input-large" value="<?php echo $ipayapp_key;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="ipaybank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodddd=mysql_fetch_array($ipaymathodsss)) { ?>
															<option value="<?php echo $rodddd['id'];?>"<?php if($rodddd['id'] == $ipaybank) {echo 'selected="selected"';}?>><?php echo $rodddd['id'];?>. <?php echo $rodddd['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="ipaycharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $ipaycharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="ipaycharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $ipaycharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="ipaycharge" id="" style="width:7%;" value="<?php echo $ipaycharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="ipaywebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $ipaywebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="ipaywebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $ipaywebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br><br>
											</div>
<?php } if($sslsts == '0'){
	
$sslll=mysql_query("SELECT `id`,`getway_name`,`getway_name_details`, `merchant_number`,`password`,`store_id`,`bank`,`charge`,`charge_sts`,`show_sts`,`sts`,`webhook_sts` FROM payment_online_setup WHERE id = '3'");
$rowssl=mysql_fetch_array($sslll);
$sslid=$rowssl['id'];
$sslgetway_name=$rowssl['getway_name'];
$sslgetway_name_details=$rowssl['getway_name_details'];
$sslmerchant_number=$rowssl['merchant_number'];
$sslstore_id=$rowssl['store_id'];
$sslpassword=$rowssl['password'];
$sslbank=$rowssl['bank'];
$sslcharge=$rowssl['charge'];
$sslcharge_sts=$rowssl['charge_sts'];
$sslshow_sts=$rowssl['show_sts'];
$sslwebhook_sts=$rowssl['webhook_sts'];

$sslmathodsss = mysql_query("SELECT * FROM `bank` WHERE `emp_id` = '' AND `sts` = '0'");

?>
<div class="" style="border: 1px solid rgba(0, 0, 0, 0.2);">
												<br/>
												<p>
													<label style="font-weight: bold;">Merchant Number*</label>
													<span class="field"><input type="text" name="sslmerchant_number" id="" required="" style="width: 110px;" value="<?php echo $sslmerchant_number;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Store id*</label>
													<span class="field"><input type="text" name="sslstore_id" id="" required="" class="input-large" value="<?php echo $sslstore_id;?>" placeholder="" /></span>
												</p>
												<p>
													<label style="font-weight: bold;">Store Password*</label>
													<span class="field"><input type="password" name="sslpassword" id="" required="" class="input-large" value="<?php echo $sslpassword;?>" placeholder="" /></span>
												</p>
												<p>	
													<label style="font-weight: bold;">Bank*</label>
													<select data-placeholder="Must Choose a Bank" name="sslbank" style="width:220px;" class="chzn-select" required="" />
														<option></option>
														<?php 
														while ($rodf=mysql_fetch_array($sslmathodsss)) { ?>
															<option value="<?php echo $rodf['id'];?>"<?php if($rodf['id'] == $sslbank) {echo 'selected="selected"';}?>><?php echo $rodf['id'];?>. <?php echo $rodf['bank_name'];?></option>
														<?php } ?>
													</select>
												</p>
												<p>
													<label>Active Charge?</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="sslcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $sslcharge_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
														<input type="radio" name="sslcharge_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $sslcharge_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
													</span>
												</p>
												
												<p>
													<label>Charge Amount<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Charge with payment amount</i></a></label>
													<span class="field"><input type="text" name="sslcharge" id="" style="width:7%;" value="<?php echo $sslcharge;?>" /><input type="text" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
												</p><br>
												<p>
													<label>Webhook</a></label>
													<span class="formwrapper"  style="margin-left: 0px;">
														<input type="radio" name="sslwebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="0" <?php if('0' == $sslwebhook_sts) echo 'checked="checked"';?>> Active &nbsp; &nbsp;
														<input type="radio" name="sslwebhook_sts" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="1" <?php if('1' == $sslwebhook_sts) echo 'checked="checked"';?>> Inactive &nbsp; &nbsp;
													</span>
												</p>
												<br><br>
											</div>
<?php } if($sts == '0'){
	
$teleset=mysql_query("SELECT id, t_link, bot_id, chat_id, sts, add_user, add_user_chat_id, add_payment, fund_transfer_sts, fund_transfer_chat_id, add_payment_chat_id, webhook_client_payment, webhook_client_payment_chat_id, webhook_reseller_recharge, webhook_reseller_recharge_chat_id, client_status, client_status_chat_id, expense_sts, expense_sts_chat_id, client_recharge, client_recharge_chat_id, instruments_in_sts, instruments_in_chat_id, instruments_out_sts, instruments_out_chat_id, onu_ping_check, onu_ping_check_chat_id FROM telegram_setup");
$rowtele=mysql_fetch_array($teleset);
$teleid=$rowtele['id'];
$t_link=$rowtele['t_link'];
$bot_id=$rowtele['bot_id'];
$chat_id=$rowtele['chat_id'];
$add_user=$rowtele['add_user'];
$add_user_chat_id=$rowtele['add_user_chat_id'];
$add_payment=$rowtele['add_payment'];
$add_payment_chat_id=$rowtele['add_payment_chat_id'];
$webhook_client_payment=$rowtele['webhook_client_payment'];
$webhook_client_payment_chat_id=$rowtele['webhook_client_payment_chat_id'];
$webhook_reseller_recharge=$rowtele['webhook_reseller_recharge'];
$webhook_reseller_recharge_chat_id=$rowtele['webhook_reseller_recharge_chat_id'];
$client_status=$rowtele['client_status'];
$client_status_chat_id=$rowtele['client_status_chat_id'];
$expense_sts=$rowtele['expense_sts'];
$expense_sts_chat_id=$rowtele['expense_sts_chat_id'];
$client_recharge=$rowtele['client_recharge'];
$client_recharge_chat_id=$rowtele['client_recharge_chat_id'];
$instruments_in_sts=$rowtele['instruments_in_sts'];
$instruments_in_chat_id=$rowtele['instruments_in_chat_id'];
$instruments_out_sts=$rowtele['instruments_out_sts'];
$instruments_out_chat_id=$rowtele['instruments_out_chat_id'];
$onu_ping_check=$rowtele['onu_ping_check'];
$onu_ping_check_chat_id=$rowtele['onu_ping_check_chat_id'];
$fund_transfer_sts=$rowtele['fund_transfer_sts'];
$fund_transfer_chat_id=$rowtele['fund_transfer_chat_id'];
?>
<br>									<?php if($userr_typ == 'superadmin'){ ?>
										<p>
											<label style="font-weight: bold;">API Link</label>
											<span class="field"><input type="text" name="t_link" required="" id="" readonly class="input-large" value="https://api.telegram.org/bot" placeholder="" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Bot ID<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Telegram bot id</i></a></label>
											<span class="field"><input type="text" name="bot_id" id="" required="" class="input-xxlarge" value="<?php echo $bot_id ;?>" placeholder="" /></span>
										</p>
										<br>
										<?php } else{ ?>
											<input type="hidden" name="t_link" value="https://api.telegram.org/bot"/>
											<input type="hidden" name="bot_id" value="<?php echo $bot_id ;?>"/>
										<?php } ?>
										<p>
											<label style="font-weight: bold;">Default Chat ID<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Chat/Group chat id</i></a></label>
											<span class="field"><input type="text" name="chat_id" id="" required="" class="input-large" value="<?php echo $chat_id ;?>" placeholder="" /></span>
										</p>
										<br>
										
										<p>
											<label style="font-weight: bold;">Client Creation<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when Add Client?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="add_user" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $add_user) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="add_user" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $add_user) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											</span>
											<span class="field"><input type="text" name="add_user_chat_id" id="" style="width: 10%;" value="<?php echo $add_user_chat_id ;?>" placeholder="Chat ID" /></span>
										</p>
										<p>
											<label style="font-weight: bold;">Make Payment<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when Add Payment?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="add_payment" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $add_payment) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="add_payment" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $add_payment) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="add_payment_chat_id" id="" style="width: 10%;" value="<?php echo $add_payment_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Webhook Client Payment<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when client paid by Webhook?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="webhook_client_payment" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $webhook_client_payment) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="webhook_client_payment" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $webhook_client_payment) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="webhook_client_payment_chat_id" id="" style="width: 10%;" value="<?php echo $webhook_client_payment_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Webhook Reseller Recharge<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when reseller recharge by Webhook?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="webhook_reseller_recharge" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $webhook_reseller_recharge) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="webhook_reseller_recharge" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $webhook_reseller_recharge) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="webhook_reseller_recharge_chat_id" id="" style="width: 10%;" value="<?php echo $webhook_reseller_recharge_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Client Status<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when Active/Inactive?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="client_status" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $client_status) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="client_status" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $client_status) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="client_status_chat_id" id="" style="width: 10%;" value="<?php echo $client_status_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Expense<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when expense add/approved/rejected?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="expense_sts" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $expense_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="expense_sts" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $expense_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="expense_sts_chat_id" id="" style="width: 10%;" value="<?php echo $expense_sts_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Reseller Client Recharge<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when reseller recharge days?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="client_recharge" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $client_recharge) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="client_recharge" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $client_recharge) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="client_recharge_chat_id" id="" style="width: 10%;" value="<?php echo $client_recharge_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Store Instruments In<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when instruments in or Delete?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="instruments_in_sts" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $instruments_in_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="instruments_in_sts" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $instruments_in_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="instruments_in_chat_id" id="" style="width: 10%;" value="<?php echo $instruments_in_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Store Instruments Out<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when instruments out or Delete?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="instruments_out_sts" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $instruments_out_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="instruments_out_sts" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $instruments_out_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="instruments_out_chat_id" id="" style="width: 10%;" value="<?php echo $instruments_out_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">Fund Transfer<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification when anyone transfer fund?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="fund_transfer_sts" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $fund_transfer_sts) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="fund_transfer_sts" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $fund_transfer_sts) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="fund_transfer_chat_id" id="" style="width: 10%;" value="<?php echo $fund_transfer_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
										<p>
											<label style="font-weight: bold;">ONU Ping Check<br><a style="font-size: 10px;color: #f04a4a;margin-right: 5px;"><i>Notification When Diagram ONU Ping Loss/Down?</i></a></label>
											<span class="formwrapper"  style="margin-left: 0px;">
												<input type="radio" name="onu_ping_check" value="0" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('0' == $onu_ping_check) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
												<input type="radio" name="onu_ping_check" value="1" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" <?php if('1' == $onu_ping_check) echo 'checked="checked"';?>> No &nbsp; &nbsp;
											<span class="field"><input type="text" name="onu_ping_check_chat_id" id="" style="width: 10%;" value="<?php echo $onu_ping_check_chat_id ;?>" placeholder="Chat ID" /></span>
											</span>
										</p>
<?php } ?>