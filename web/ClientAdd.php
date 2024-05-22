<?php
$titel = "Add Client";
$Clients = 'active';
include('include/hader.php');
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(110, $access_arry)){

if($userr_typ != 'mreseller') {
//---------- Permission -----------

$sql88tt = ("SELECT username FROM sms_setup WHERE status = '0' AND z_id = ''");
		
$querytt = mysql_query($sql88tt);
$rowtt = mysql_fetch_assoc($querytt);
$username= $rowtt['username'];

$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);

$query1t1="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$resulttt11=mysql_query($query1t1);
$r2ff = mysql_fetch_assoc($resulttt11);
$totmk = mysql_num_rows($resulttt11);

if($user_type == 'billing'){
$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' AND FIND_IN_SET('$e_id', emp_id) > 0 order by z_name";
}
else{
$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
}
$result=mysql_query($query);
$query1="SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' order by id ASC";
$result1=mysql_query($query1);

$query1zz="SELECT box_id, b_name, location, b_port FROM box ORDER BY box_id ASC";
$result1zz=mysql_query($query1zz);

$query1zzz="SELECT e_id, e_name, e_des FROM emp_info WHERE mk_id = '' ORDER BY e_id ASC";
$result111=mysql_query($query1zzz);

$query1zzzff="SELECT e_id, e_name, e_des FROM emp_info WHERE mk_id = '' ORDER BY e_id ASC";
$result11122=mysql_query($query1zzzff);

$sql2oo ="SELECT last_id FROM app_config";

$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['last_id'];
$com_id = $idzff + 1;

if($_POST['way'] == 'newsignup'){
$queryrtre = mysql_query("SELECT * FROM clients_signup WHERE sts = '0' AND id ='$signup_id'");
$rowss = mysql_fetch_assoc($queryrtre);
		$c_name= $rowss['c_name'];
		$occupation = $rowss['occupation'];
		$cell= $rowss['cell'];
		$cell1= $rowss['cell1'];
		$cell2= $rowss['cell2'];
		$cell3= $rowss['cell3'];
		$cell4= $rowss['cell4'];
		$email= $rowss['email'];
		$connectivity_type= $rowss['connectivity_type'];
		$address= $rowss['address'];
		$previous_isp= $rowss['previous_isp'];
		$nid= $rowss['nid'];
		$p_id= $rowss['p_id'];
		$signup_fee= $rowss['signup_fee'];
		$note= $rowss['note'];
		$p_m = $rowss['p_m'];
		$image = $rowss['image'];
		$nid_f_image = $rowss['nid_f_image'];
		$nid_b_image = $rowss['nid_b_image'];
}
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21">
	<div id="map" style="height:650px;width: 100%;overflow: hidden;"></div>
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn" onclick="history.back()" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Add Client</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<?php if($limit_accs == 'Yes'){ ?>
					<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 45px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">Basic Information</div>
					<form id="form" class="stdform" method="post" action="ClientAddQuery" enctype="multipart/form-data">
						<input type="hidden" name="way" value="<?php if($_POST['way'] == 'newsignup'){echo 'newsignup';} else{echo 'newclient';}?>" />
						<input type="hidden" name="signup_id" value="<?php echo $signup_id;?>" />
						<input type="hidden" name="ppoe_comment" value="<?php echo $ppoe_comment;?>" />
						<input type="hidden" name="u_type" value="client" />
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date('Y-m-d', time());?>" />
						<input type="hidden" name="entry_time" value="<?php echo date('H:i:s', time());?>" />
						<div class="modal-body" style="overflow: hidden;">
							<div style="float: left;width: 50%;">
								<p>	
									<label style="width: 130px;font-weight: bold;">Zone*</label>
									<select data-placeholder="Choose a Zone..." name="z_id" id="z_id" class="chzn-select" style="width:250px;" required="" onChange="getRoutePoint(this.value)">
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>	
									<label style="width: 130px;">Sub-Zone</label>
									<div id="Pointdiv1">
										<select data-placeholder="Choose a Box" class="chzn-select" style="width:250px;" name="" />
											<option value=""></option>
										</select>
									</div>
								</p>
								<?php if($totmk == '1'){?>
										<input type="hidden" name="mk_id" value="<?php echo $r2ff['id'];?>" />
								<?php } if($totmk > '1'){?>
								<p>	
									<label style="width: 130px;font-weight: bold;">Network*</label>
										<select data-placeholder="Choose a Network..." id="mk_id" name="mk_id" class="chzn-select" style="width:250px;" required="">
											<option value=""></option>
												<?php while ($row11=mysql_fetch_array($result11)) { ?>
											<option value="<?php echo $row11['id']?>"><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
												<?php } ?>
										</select>
									
								</p>
								<?php } if($totmk == '0'){?>
								<p>	
									<label style="width: 130px;font-weight: bold;">Network*</label>
										<a class="btn ownbtn4" href="Network" data-toggle=""> Please Add Mikrotik First</a>
								</p>
								<?php } ?>
								<div id="resultpackage" style="font-weight: bold;"></div>
								<p>
									<label style="width: 130px;">This Month Bill</label>
									<span class="formwrapper" style="margin-left: 0;">
										<input type="radio" name="qcalculation" value="Auto"> Auto &nbsp; &nbsp;
										<input type="radio" name="qcalculation" value="Manual" checked="checked"> Manual &nbsp; &nbsp;
										<input type="radio" name="qcalculation" value="No"> No Bill &nbsp; &nbsp;
										<a id="resultpack" style="font-weight: bold;"></a>
									</span>
								</p>
								<div id="result1"></div>
								<p>
									<label style="width: 130px;">IP Address</label>
									<span class="field" style="margin-left: 0px;"><input type="text" style="width:170px;" id="ip" name="ip" placeholder="Ex: 192.168.XX.XX" class="input-xlarge"/></span>
								</p>
								<?php if($user_type == 'superadmin' || $user_type == 'admin'){ ?>
											<p>
												 <label style="width: 130px;">Permanent Discount</label>
												<span class="field" style="margin-left: 0px;"><input type="text" name="discount" style="width:60px;" value="0.00"/><input type="text" name="" id="" style="width:17px; color:#2e3e4e; font-weight: bold;font-size: 18px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></span>
											</p>
											<p>
												 <label style="width: 130px;">Permanent Extra Bill</label>
												<span class="field" style="margin-left: 0px;"><input type="text" name="extra_bill" style="width:60px;" value="0.00"/><input type="text" name="" id="" style="width:17px; color:#2e3e4e; font-weight: bold;font-size: 18px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></span>
											</p>
											<?php } else{ ?>
											<p>
												 <label style="width: 130px;">Permanent Discount</label>
												<span class="field" style="margin-left: 0px;"><input type="text" name="" style="width:60px;" readonly value="0.00"/><input type="text" name="" id="" style="width:17px; color:#2e3e4e; font-weight: bold;font-size: 18px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></span>
											</p>
											<p>
												 <label style="width: 130px;">Permanent Extra Bill</label>
												<span class="field" style="margin-left: 0px;"><input type="text" name="" style="width:60px;" readonly value="0.00"/><input type="text" name="" id="" style="width:17px; color:#2e3e4e; font-weight: bold;font-size: 18px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></span>
											</p>
								<?php } ?>	
								
											<p>
												 <label style="width: 130px;">National ID No</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="nid" placeholder="Ex: NID Number" id="" class="input-xxlarge" value = "<?php echo $nid;?>" /></span>
											</p>
											<p>
												<label style="width: 130px;">Note</label>
												<span class="field" style="margin-left: 0px;"><textarea type="text" style="width:240px;" name="note" placeholder="Optional" id="" class="input-xxlarge" /><?php echo $note;?></textarea></span>
											</p>
							</div>
							<div style="margin-left: 48%;">
								<p>
									<label style="width: 130px;">Company ID</label>
									<span class="field" style="margin-left: 0px;"><input type="hidden" name="com_id" id="" readonly required="" value="<?php echo $com_id;?>"/><h3 style="font-weight: bold;padding-top: 2px;"><?php echo $com_id;?></h3></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Client Name*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="c_name" id="" required="" style="width:240px;" placeholder="Client Full Name" value="<?php echo $c_name;?>"/></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">PPPoE ID*</label>
									<input type="text" name="c_id" id="name" placeholder="At least 3 characters long" style="width:200px;" class="input-xxlarge" required="" /><span id="result" style="margin-left: 160px; font-weight: bold;"></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;" class="control-label" for="passid">Password*</label>
									<div class="controls"><input type="text" name="passid" class="input-xxlarge" size="12" style="width:200px;" required="" placeholder="PPPoE Password"/></div>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Cell No*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="cell" style="width:200px;" placeholder="Must Use 8801XXXXXXXXX" required="" value = "<?php if($_POST['way'] == 'newsignup'){ echo $cell;} else{echo '88';}?>" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label style="width: 130px;">Send Login SMS</label>
									<?php if($username == ''){ ?>
									<span class="field" style="margin-left: 0px;font-weight: bold;padding-top: 5px;font-size: 13px;color: red;">[SMS Not Active]</span>
									<input type="hidden" name="sentsms" value="No" />
									<?php } else{ ?>
									<span class="formwrapper"  style="margin-left: 0px;">
										<input type="radio" name="sentsms" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
										<input type="radio" name="sentsms" value="No"> No &nbsp; &nbsp;
									</span>
									<?php } ?>
								</p>
								<p>
									<label style="width: 55px;"></label>
									<table class="table" style="width: max-content;">
										<tr>
											<td class="" style="font-weight: bold;border-bottom: 1px solid #ddd;text-align: right;">Payment<br/>Deadline</td>
											<td class="" style="border-right: 2px solid #ddd;width: 90px;border-bottom: 1px solid #ddd;">
												<select class="chzn-select" name="payment_deadline" style="width:70%;" />
													<option value="">NO</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04">04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
													<option value="13">13</option>
													<option value="14">14</option>
													<option value="15">15</option>
													<option value="16">16</option>
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
													<option value="24">24</option>
													<option value="25">25</option>
													<option value="26">26</option>
													<option value="27">27</option>
													<option value="28">28</option>
													<option value="29">29</option>
													<option value="30">30</option>
													<option value="31">31</option>
												</select>
											</td>
											<td class="" style="width: 90px;border-bottom: 1px solid #ddd;text-align: right;">
												<select class="chzn-select" name="b_date" style="width:70%;" />
													<option value="">NO</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04">04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
													<option value="13">13</option>
													<option value="14">14</option>
													<option value="15">15</option>
													<option value="16">16</option>
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
													<option value="24">24</option>
													<option value="25">25</option>
													<option value="26">26</option>
													<option value="27">27</option>
													<option value="28">28</option>
													<option value="29">29</option>
													<option value="30">30</option>
													<option value="31">31</option>
												</select>
											</td>
											<td class="" style="font-weight: bold;text-align: left;border-bottom: 1px solid #ddd;">Billing<br/>Deadline</td>
										</tr>
									</table>
								</p>
								<p>
									<label style="width: 130px;">Flat/House/Road</label>
									<span class="field" style="margin-left: 0px;"><input type="text" style="width:72px;margin-right: 2px;" name="flat_no" placeholder="Flat No" id="" /><input type="text" style="width:72px;margin-right: 2px;" name="house_no" placeholder="House No" id="" /><input type="text" style="width:72px;" name="road_no" placeholder="Road No" id="" /></span>
								</p>
								
								<p>
									 <label style="width: 130px;">Present Address</label>
									<span class="field" style="margin-left: 0px;"><textarea type="text" style="width:240px;" name="address" id="" class="input-xxlarge"/><?php echo $address;?></textarea></span>
								</p>
							</div>
							
							
							<div class="span12" style="width: 100%;margin-left: -21px;">
								<div class="widgetbox">
									<div class="widgettitle" style="margin: 5px -41px 0px 0px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 0px;font-weight: bold;background: none;border-top: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 1px solid rgba(0, 0, 0, 0.2);"> <a class="minimize" style="float: left;margin-left: 20px;font-weight: normal;">+</a>Images & Location</div>
									<div class="widgetcontent" style="margin-right: -41px;border: none;display: none;padding: 0px;">
										<div style="float: left;width: 50%;">
										<?php if($image == ''){?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 150px;font-weight: bold;">Client Photo</label>
												<input type="hidden" name="old_image" value="no" />
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append" style="display: flex;">
														<span class="btn btn-file" style="padding: 0px 0px 25px 0px;background: transparent;border-radius: 5px !important;border: 0;">
															<span class="fileupload-new" style="font-size: 50px;color: #ccc;"><i class="iconfa-camera iconsweets-white"></i></span>
															<span class="btn-file fileupload-exists" style="font-size: 40px;color: #ccc;"><i class="iconfa-undo iconsweets-white"></i></span>
															<input type="file" class="input-small" name="main_image" onchange="readURL(this);" />
														</span>
														<span class="fileupload-exists" style="font-size: 35px;color: #ec444478;padding: 5px 0px 0px 0px;" data-dismiss="fileupload" title="Remove"><i class="iconfa-remove iconsweets-white"></i>
														<img id="blah" src="emp_images/no_img.jpg" alt="" style="width: 60px; height: 40px; margin-left: 30px;float: right;"/></span>
													</div>
												
												</div>
											</p>
											<?php } else{ ?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 150px;font-weight: bold;">Image</label>
												<div class="controls">
													<span class="btn btn-file">
														<img src="<?php echo $image;?>" height="50px" width="50px" />
													</span>
													<input type="hidden" name="old_image" value="<?php echo $image;?>" />
												</div>
											</p>
											<?php } ?>
											<?php if($nid_f_image == ''){?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 150px;font-weight: bold;">NID Front Side</label>
												<input type="hidden" name="old_nid_f_image" value="no" />
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append" style="display: flex;">
														<span class="btn btn-file" style="padding: 0px 0px 25px 0px;background: transparent;border-radius: 5px !important;border: 0;">
															<span class="fileupload-new" style="font-size: 50px;color: #ccc;"><i class="iconfa-picture iconsweets-white"></i></span>
															<span class="btn-file fileupload-exists" style="font-size: 40px;color: #ccc;"><i class="iconfa-undo iconsweets-white"></i></span>
															<input type="file" class="input-small" name="nid_f_image" onchange="readURL1(this);" />
														</span>
														<span class="fileupload-exists" style="font-size: 35px;color: #ec444478;padding: 5px 0px 0px 0px;" data-dismiss="fileupload" title="Remove"><i class="iconfa-remove iconsweets-white"></i>
														<img id="blah1" src="" alt="" style="width: 85px; height: 40px; margin-left: 30px; float: right;"/></span>
														<!--<img id="" src="images/no_nid.png" alt="" style="width: 85px; height: 40px; margin-left: 30px; padding-top: 5px;"/>-->
													</div>
												</div>
											</p>
											<?php } else{ ?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 150px;font-weight: bold;">NID Front Side</label>
												<div class="controls">
													<span class="btn btn-file">
														<img  src="<?php echo $nid_f_image;?>" height="50px" width="90px" />
													</span>
													<input type="hidden" name="old_nid_f_image" value="<?php echo $nid_f_image;?>" />
												</div>
											</p>
											<?php } if($nid_b_image == ''){?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 150px;font-weight: bold;">NID Back Side</label>
												<input type="hidden" name="old_nid_b_image" value="no" />
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append" style="display: flex;">
														<span class="btn btn-file" style="padding: 0px 0px 25px 0px;background: transparent;border-radius: 5px !important;border: 0;">
															<span class="fileupload-new" style="font-size: 50px;color: #ccc;"><i class="iconfa-picture iconsweets-white"></i></span>
															<span class="btn-file fileupload-exists" style="font-size: 40px;color: #ccc;"><i class="iconfa-undo iconsweets-white"></i></span>
															<input type="file" class="input-small" name="nid_b_image" onchange="readURL2(this);" />
														</span>
														<span class="fileupload-exists" style="font-size: 35px;color: #ec444478;padding: 5px 0px 0px 0px;" data-dismiss="fileupload" title="Remove"><i class="iconfa-remove iconsweets-white"></i>
														<img id="blah2" src="" alt="" style="width: 85px; height: 40px; margin-left: 30px; float: right;"/></span>
														<!--<img id="" src="images/no_nid.png" alt="" style="width: 85px; height: 40px; margin-left: 30px; padding-top: 5px;"/>-->
													</div>
												</div>
											</p>
											<?php } else{ ?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 150px;font-weight: bold;">NID Back Side</label>
												<div class="controls">
													<span class="btn btn-file">
														<img  src="<?php echo $nid_b_image;?>" height="50px" width="90px" />
													</span>
													<input type="hidden" name="old_nid_b_image" value="<?php echo $nid_b_image;?>" />
												</div>
											</p>
											<?php } ?>
										</div>
									<?php if($tree_sts_permission == '0'){?>
										<div style="float: left;width: 48%;">
											<p>
												<label style="width: 130px;"></label>
												<span class="field" style="margin-left: 0px;font-weight: bold;font-size: 20px;">Location On Google Map</span>
											</p>
											<a id="latlon"></a>
											<p>
												<label style="width: 130px;"></label>
												<span class="field" style="margin-left: 0px;">
													<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 12%;padding: 1% 5%;width: auto;margin-left: 70px;"><i class='iconfa-map-marker' style="font-size: 65px;"></i></a>
													<input type="hidden" id="latitude" readonly name="latitude" placeholder="Google Map Latitude" class="span2">
													<input type="hidden" id="longitude" readonly name="longitude" placeholder="Google Map Longitude" class="span2">
												</span>
											</p>
											
											
										</div>
									<?php } else{ ?><input type="hidden" id="latitude" name="latitude" placeholder="" class=""><input type="hidden" id="longitude" name="longitude" placeholder="" class=""><?php } ?>
									</div>
								</div>
							</div>
							
							<div class="span12" style="width: 100%;margin-left: -21px;">
								<div class="widgetbox">
									<div class="widgettitle" style="margin: 5px -41px 0px 0px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 0px;font-weight: bold;background: none;border-top: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 1px solid rgba(0, 0, 0, 0.2);"> <a class="minimize" style="float: left;margin-left: 20px;font-weight: normal;">+</a>Diagram & Connectivity</div>
									<div class="widgetcontent" style="margin-right: -41px;border: none;display: none;padding: 0px;">
										<div style="float: left;width: 50%;">
											<p>
												<label style="width: 130px;">Cable Type</label>
												<span class="field" style="margin-left: 0px;">
													<select class="chzn-select" name="cable_type" style="width:250px;" required="" onChange="getRoutePoint1(this.value)">
														<option value="UTP">UTP</option>
														<option value="FIBER">FIBER</option>
													</select>
												</span>
											</p>
											<div id="Pointdiv"></div>
											<p>
												<label style="width: 130px;">Require Cable</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="req_cable" placeholder="Ex: 200ft" id="" class="input-xxlarge" /></span>
											</p>
											<p>
												 <label style="width: 130px;">Connection Mode</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="con_sts" readonly id="" class="input-xlarge" value = "Active" /></span>			
											</p>
										</div>
										<div style="float: left;width: 48%;">
											<p>
												<label style="width: 130px;">MAC Address</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="mac" placeholder="" id="" class="input-xlarge" /></span>
											</p>
											<p>
												 <label style="width: 130px;">Type of Client</label>
													<span class="field" style="margin-left: 0px;">
														<select class="chzn-select" name="con_type" style="width:250px;" required="" >
															<option value="Home">Home</option>
															<option value="Corporate">Corporate</option>
															<option value="Others">Others</option>
														</select>
													</span>					
											</p>
											<p>
												 <label style="width: 130px;">Type of Connectivity</label>
													<span class="field" style="margin-left: 0px;">
														<select class="chzn-select" name="connectivity_type" style="width:250px;" required="" >
															<option value="Shared" <?php if('Shared' == $connectivity_type) echo 'selected="selected"';?>>Shared</option>
															<option value="Dedicated" <?php if('Dedicated' == $connectivity_type) echo 'selected="selected"';?>>Dedicated</option>
														</select>
													</span>					
											</p>
											<p>
												<label style="width: 130px;">Termination Date</label>
												<?php if($client_terminate == '1'){?>
													<span class="field" style="margin-left: 0px;"><input type="text" name="termination_date" style="width:240px;" placeholder="Client Discount Date (Optional)" class="input-xxlarge datepicker"></span>
												<?php } else{ ?>
													<span class="field" style="margin-left: 0px;"><input type="text" name="termination_date" readonly style="width:240px;" placeholder="Client Discount Date (Optional)" class="input-xxlarge"></span>
												<?php } ?>
											</p>
										</div>
									</div>
								</div>
							</div>
							<div class="span12" style="width: 100%;margin-left: -21px;">
								<div class="widgetbox">
									<div class="widgettitle" style="margin: 5px -41px 0px 0px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 0px;font-weight: bold;background: none;border-top: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 1px solid rgba(0, 0, 0, 0.2);"> <a class="minimize" style="float: left;margin-left: 20px;font-weight: normal;">+</a>Advance</div>
									<div class="widgetcontent" style="margin-right: -41px;border: none;display: none;padding: 0px;">
										<div style="float: left;width: 50%;">
											<div id="resultthana" style="font-weight: bold;">
											<p>
												<label style="width: 130px;">Thana</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="thana" placeholder="" id="" class="input-xxlarge" /></span>
											</p>
											</div>
											<p>
												<label style="width: 130px;">Father's Name</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="father_name" id="" class="input-xxlarge" /></span>
											</p>
											<p>
												<label style="width: 130px;">Alternative Cell No</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="cell1" placeholder="Alternative Cell No" id="" class="input-xxlarge" value = "<?php echo $cell1;?>" /></span>
											</p>
											<p>
												 <label style="width: 130px;">Email</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="email" id="" placeholder="Ex: abcd@domain.com" class="input-xxlarge" value = "<?php echo $email;?>" /></span>
											</p>
											<p>
												 <label style="width: 130px;">Occupation</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="occupation" placeholder="Occupation" id="" class="input-xxlarge" value = "<?php echo $occupation;?>" /></span>
											</p>
											<p>
												 <label style="width: 130px;">Permanent Address</label>
												<span class="field" style="margin-left: 0px;"><textarea type="text" style="width:240px;" name="old_address" id="" class="input-xxlarge"/></textarea></span>
											</p>
										</div>
										<div style="float: left;width: 48%;">
											<p>
												<label style="width: 130px;">Agent</label>
												<select name="agent_id" class="chzn-select" style="width:250px;" onChange="getRoutePoint11(this.value)">	
													<option value="0">--None--</option>		
												<?php 
													$queryddd="SELECT * FROM agent WHERE sts = '0' order by e_name ASC";
													$resultdww=mysql_query($queryddd);
													while ($rowdrr=mysql_fetch_array($resultdww)) { ?>
													<option value=<?php echo $rowdrr['e_id'];?>><?php echo $rowdrr['e_name'];?> (<?php echo $rowdrr['com_percent'];?>%)</option>		
												<?php } ?>
												</select>
											</p>
											<div id="Pointdiv100"></div>
											<p>
												 <label style="width: 130px;">Signup Fee</label>
												<span class="field" style="margin-left: 0px;"><input type="text" name="signup_fee" style="width:240px;" placeholder="Ex: 1200" id="" class="input-xxlarge" value = "<?php echo $signup_fee;?>" /></span>
											</p>
											<p>
												<label style="width: 130px;">Payment Method</label>
												<span class="field" style="margin-left: 0px;">
													<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:250px;" required="" >
														<option value="Home Cash" <?php if('Home Cash' == $p_m) echo 'selected="selected"';?>>Cash from Home</option>
														<option value="Cash" <?php if('Cash' == $p_m) echo 'selected="selected"';?>>Cash</option>
														<option value="Office" <?php if('Office' == $p_m) echo 'selected="selected"';?>>Office</option>
														<option value="bKash" <?php if('bKash' == $p_m) echo 'selected="selected"';?>>bKash</option>
														<option value="Rocket" <?php if('Rocket' == $p_m) echo 'selected="selected"';?>>Rocket</option>
														<option value="iPay" <?php if('iPay' == $p_m) echo 'selected="selected"';?>>iPay</option>
														<option value="Card" <?php if('Card' == $p_m) echo 'selected="selected"';?>>Card</option>
														<option value="Bank" <?php if('Bank' == $p_m) echo 'selected="selected"';?>>Bank</option>
														<option value="Corporate" <?php if('Corporate' == $p_m) echo 'selected="selected"';?>>Corporate</option>
													</select>
												</span>
											</p>
											<p>
												<label style="width: 130px;">Bill Man</label>
												<span class="field" style="margin-left: 0px;">
													<select data-placeholder="Choose a Bill Man" name="bill_man" class="chzn-select" style="width:250px;" />
														<option value=""></option>
															<?php while ($row111rr=mysql_fetch_array($result11122)) { ?>
														<option value="<?php echo $row111rr['e_id']?>"><?php echo $row111rr['e_name']; ?> (<?php echo $row111rr['e_des']; ?>)</option>
															<?php } ?>
													</select>
												</span>
											</p>
											<p>
												<label style="width: 130px;">Technician</label>
												<span class="field" style="margin-left: 0px;">
													<select data-placeholder="Choose a Technician" name="technician" class="chzn-select" style="width:250px;"/>
														<option value=""></option>
															<?php while ($row111=mysql_fetch_array($result111)) { ?>
														<option value="<?php echo $row111['e_id']?>"><?php echo $row111['e_name']; ?> (<?php echo $row111['e_des']; ?>)</option>
															<?php } ?>
													</select>
												</span>
											</p>
											<p>
												<label style="width: 130px;font-weight: bold;">Joining Date*</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="join_date" id="" required="" value="<?php echo date("Y-m-d");?>" readonly></span>
											</p>
										</div>
									</div>
								</div>
							</div>
							
							
							
						</div>
						<?php if($totmk != '0'){?>
							<div class="modal-footer">
								<button type="reset" class="btn ownbtn11">Reset</button>
								<button class="btn ownbtn2" type="submit">Submit</button>
							</div>
						<?php } ?>
					</form>	
				<?php } else{ ?>
					<div style='font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;padding: 30px;font-size: 30px;text-align: center;'>[User Limit Exceeded]</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
}
else{ ?>
<html>	
	<body>		
		<form action="index" method="" name="out">					
		</form>		
		<script language="javascript" type="text/javascript">				
			document.out.submit();		
		</script>	
	</body>
</html>
<?php
}
}
else{ ?>
<html>	
	<body>		
		<form action="index" method="" name="out">					
		</form>		
		<script language="javascript" type="text/javascript">				
			document.out.submit();		
		</script>	
	</body>
</html>
<?php
}
include('include/footer.php');
?>
<script type="text/javascript">
jQuery(document).ready(function(){  
    jQuery('#z_id').on('change',function(){ 
        var z_id = jQuery('#z_id').val();
        jQuery.ajax({  
				type: 'GET',
                url: "zone_packages.php",
                data:{z_id:z_id},
                success:function(data){
                    jQuery('#resultpackage').html(data);
                }
        });  
    });

	jQuery('#z_id').on('change',function(){ 
        var z_id = jQuery('#z_id').val();
        jQuery.ajax({  
				type: 'GET',
                url: "zone_thana.php?for=add",
                data:{z_id:z_id},
                success:function(data){
                    jQuery('#resultthana').html(data);
                }
        });  
    });  
});
</script>

<script type="text/javascript">
$(document).ready(function()
{    
 $("#name").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 3)
  {  
   $("#result").html("<p><label style='width: 130px'></label><span class='field' style='margin-left: 0px;'>checking...</span></p>");
   $.ajax({
    
    type : 'POST',
    url  : 'username-check.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
 
});
</script>
<script language="javascript" type="text/javascript">
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
	
	function getRoutePoint(afdId) {		
		
		var strURL="findzonebox.php?z_id="+afdId;
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
</script>
  <script type="text/javascript">
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(55)
                        .height(40);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
	function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah1')
                        .attr('src', e.target.result)
                        .width(85)
                        .height(40);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
	function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah2')
                        .attr('src', e.target.result)
                        .width(85)
                        .height(40);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="mk_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#ip").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 7)
				  {  
				   $("#result1").html("<p><label style='width: 130px'></label><span class='field' style='margin-left: 0px;'>checking...</span></p>");

				   $.ajax({
					
					type : 'POST',
					url  : "ip-mac-check1.php?mk_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#result1").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#result1").html('');
				  }
				 });
				});
			}
        });
});
</script>
<?php if($totmk == '1'){?>
<script type="text/javascript">
				$(document).ready(function()
				{    
				 jQuery('#p_id, #resultpackage').on('change',function(){
				  var p_id = jQuery('#p_id').val(); 
				   $.ajax({
					type : 'POST',
					url  : "mk-pack-check.php?mk_id=<?php echo $r2ff['id'];?>",
					data : {p_id:p_id},
					success : function(data)
						{
							  $("#resultpack").html(data);
						   }
					});
					return false;
				 });
				});
</script>
<?php } if($totmk > '1'){?>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="mk_id"]').on('change',function(){
           var CatID = jQuery(this).val();
           if(CatID)
			{
				$(document).ready(function()
				{    
				 jQuery('select[name="p_id"]').on('change',function(){
				  var p_id = jQuery(this).val(); 
				   $.ajax({
					type : 'POST',
					url  : "mk-pack-check.php?mk_id="+CatID,
					data : jQuery(this),
					success : function(data)
						{
							  $("#resultpack").html(data);
						   }
					});
					return false;
				 });
				});
			}
        });
});
</script>
<?php } ?>
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
		
		var strURL="onu_mac.php?cable_type="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint11(afdId) {		
		
		var strURL="agent_commission_clients.php?agent_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv100').innerHTML=req.responseText;						
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
<script>
function addYourLocationButton(map, marker) {
			var controlDiv = document.createElement('div');
			var button = document.createElement('button');
			var image = document.createElement('div');

			controlDiv.style.margin = '10px';
			button.style.backgroundColor = '#fff';
			button.style.border = 'none';
			button.style.outline = 'none';
			button.style.width = '40px';
			button.style.height = '40px';
			button.style.borderRadius = '8px';
			button.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
			button.style.cursor = 'pointer';
			button.style.padding = '0px';
			button.title = 'Your Location';

			image.style.margin = '11px';
			image.style.width = '18px';
			image.style.height = '18px';
			image.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
			image.style.backgroundSize = '180px 18px';
			image.style.backgroundPosition = '0px 0px';
			image.style.backgroundRepeat = 'no-repeat';

			controlDiv.appendChild(button);
			button.appendChild(image);

			google.maps.event.addListener(map, 'dragend', function() {
				image.style.backgroundPosition = '0px 0px';
			});

			button.addEventListener('click', function() {
				var imgX = '0';
				var animationInterval = setInterval(function() {
					imgX = (imgX === '-18') ? '0' : '-18';
					image.style.backgroundPosition = imgX + 'px 0px';
				}, 500);

				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
						var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
						marker.setPosition(latlng);
						map.setCenter(latlng);
						clearInterval(animationInterval);
						image.style.backgroundPosition = '-144px 0px';
				
						var latitudeInput = document.getElementById('latitude');
						var longitudeInput = document.getElementById('longitude');
						latitudeInput.value = position.coords.latitude;
						longitudeInput.value = position.coords.longitude;
						latlon.innerHTML = "<p><label style='width: 130px;'></label><span class='field' style='margin-left: 0px;color: currentColor;'>[Lat: " + latitudeInput.value + "] [Lon: " + longitudeInput.value + "]</span></p>";
					});
				} else {
					clearInterval(animationInterval);
					image.style.backgroundPosition = '0px 0px';
				}
			});

			controlDiv.index = 1;
			map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
		}

function initMap() {
    var faisalabad = { lat: <?php echo $copmaly_latitude; ?>, lng: <?php echo $copmaly_longitude; ?> };
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: faisalabad
    });
    var marker = new google.maps.Marker({
        map: map,
        animation: google.maps.Animation.DROP,
        position: faisalabad
    });
    addYourLocationButton(map, marker);

    google.maps.event.addListener(map, 'click', function(event) {
        marker.setPosition(event.latLng);
        var latitudeInput = document.getElementById('latitude');
        var longitudeInput = document.getElementById('longitude');
        latitudeInput.value = event.latLng.lat();
        longitudeInput.value = event.latLng.lng();
		latlon.innerHTML = "<p><label style='width: 130px;'></label><span class='field' style='margin-left: 0px;color: currentColor;'>[Lat: " + latitudeInput.value + "] [Lon: " + longitudeInput.value + "]</span></p>";
    });
}
	</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&callback=initMap"></script>
