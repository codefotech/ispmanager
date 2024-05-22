<?php
$titel = "Add Client";
$Clients = 'active';
include('include/hader.php');
ini_alter('date.timezone','Asia/Almaty');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql88tt = ("SELECT username FROM sms_setup WHERE status = '0' AND z_id = '$macz_id'");
		
$querytt = mysql_query($sql88tt);
$rowtt = mysql_fetch_assoc($querytt);
$username= $rowtt['username'];

$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);

if($userr_typ == 'mreseller') {
$result=mysql_query("SELECT z.z_id, z.z_name, z.thana, e.mk_id, e.e_name AS resellername, e.e_id AS resellerid, e.minimum_day, e.minimum_days, e.minimum_sts, e.prefix FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id = '$e_id'");
}
else{
$result=mysql_query("SELECT z.z_id, z.z_name, z.thana, e.mk_id, e.e_name AS resellername, e.e_id AS resellerid, e.minimum_day, e.minimum_days, e.minimum_sts, e.prefix FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' AND z.z_id = '$z_id'");
}
 $row = mysql_fetch_assoc($result);
 $mkkk_id = $row['mk_id'];
 $zthana = $row['thana'];
 $thana_arry = explode(',', $row['thana']);

$minimum_days = $row['minimum_days'];
$minimum_sts = $row['minimum_sts'];

if($minimum_sts != '1' && $minimum_days != ''){
	$minimum_days_array = explode(',',$minimum_days);
	$trimSpaces = array_map('trim',$minimum_days_array);
	asort($trimSpaces);
	$minimum_days_arrays = implode(',',$trimSpaces);
	$minimum_arraydd =  explode(',', $minimum_days_arrays);
	$minimum_day = min(explode(',', $minimum_days_arrays));
}
else{
	$minimum_day = $row['minimum_day'];
}

if($user_type == 'mreseller'){
$query1="SELECT p_id, p_name, p_price, bandwith, mk_profile FROM package WHERE z_id = '$macz_id' AND p_price != '0.00' AND status = '0' order by id ASC";
$sss1m = mysql_query("SELECT reseller_logo, billing_type FROM emp_info WHERE z_id ='$macz_id'");
$sssw1m = mysql_fetch_assoc($sss1m);
}
else{
$query1="SELECT p_id, p_name, p_price, bandwith, mk_profile FROM package WHERE z_id = '$z_id' AND status = '0' order by id ASC";
$sss1m = mysql_query("SELECT reseller_logo, billing_type FROM emp_info WHERE z_id ='$z_id'");
$sssw1m = mysql_fetch_assoc($sss1m);
}
$result1=mysql_query($query1);

if($wayyyyyy == 'mktomac'){
$query1er="SELECT p_id, p_name, p_price, bandwith, mk_profile FROM package WHERE mk_profile = '$mk_profile' AND z_id = '$z_id'";
$result1345=mysql_query($query1er);
$row2ffdf = mysql_fetch_assoc($result1345);
$mac_pack_id = $row2ffdf['p_id'];
$mac_pack_name = $row2ffdf['p_name'];
$mac_pack_price = $row2ffdf['p_price'];
$mac_pack_bandwith = $row2ffdf['bandwith'];
}

if($user_type == 'mreseller'){
$sql2oo ="SELECT last_id, terminate, e_name FROM emp_info WHERE z_id = '$macz_id'";
}
else{
$sql2oo ="SELECT last_id, terminate, e_name FROM emp_info WHERE z_id = '$z_id'";
}
$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['last_id'];
$reseller_terminate = $row2ff['terminate'];
$eeename = $row2ff['e_name'];
$com_id = $idzff + 1;

if($user_type == 'admin' || $user_type == 'superadmin'){
$sql1q = mysql_query("SELECT c_id, SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$z_id'");
$rowq = mysql_fetch_array($sql1q);


$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p
						WHERE p.z_id = '$z_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

$aaaa = $rowwz['retotalpayments']-$rowq['totbill'];
}
$billing_typee = $sssw1m['billing_type'];

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21" style="left: 35%;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="map" style="width:170%;height:500px;"></div>
		</div>
	</div>	
</div><!--#myModal-->
	<?php if($aaaa > $over_due_balance && $billing_typee == 'Prepaid' || $billing_typee == 'Postpaid'){ ?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
			<?php if($aaaa > $over_due_balance && $billing_typee == 'Prepaid' || $billing_typee == 'Postpaid'){?>
				<h1>Add MAC Client</h1>
			<?php  } else{ ?>
				 <h3>You have not sufficient balance to add new client.</h3>
			<?php  } ?>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
			<?php if($reseller_terminate == '1'){ ?> <br><h3 style="margin-left: 20px;color: red;">[<?php echo $eeename; ?>] Account Has Been Terminated. Not Possible to Add Client. Contact Administrator.</h3><br><?php } else{ ?>
				<div class="modal-header">
					<h5>Add New MAC Client</h5>
				</div>
				<?php if($limit_accs == 'Yes'){ ?>
					<form id="form" class="stdform" method="post" action="MACClientAddQuery1" enctype="multipart/form-data">
						<input type="hidden" name="u_type" value="client" />
						<input type="hidden" name="mac_user" value="1" />
						<!--<input type="hidden" name="sentsms" value="Yes" />-->
						<input type="hidden" name="line_typ" value="1" />
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
							<div class="modal-body">
							<div style="float: left;width: 50%;min-height: 950px;">
								<p>
									<label style="width: 130px;">Company ID</label>
									<span class="field" style="margin-left: 0px;"><input type="text" style="width:140px;" name="com_id" id="" readonly class="input-xlarge" value = "<?php echo $com_id; ?>" /></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">MAC Area*</label>
									<span class="field" style="margin-left: 0px;"><h4 style="margin-top: 15px;"><b><?php echo $row['z_name']; ?> - <?php echo $row['resellername']; ?> (<?php echo $row['resellerid']; ?>)</b></h4>
									<?php if($userr_typ == 'mreseller') { ?>
										<input type="hidden" name="z_id" value="<?php echo $macz_id; ?>" />
									<?php } else{ ?>
										<input type="hidden" name="z_id" value="<?php echo $row['z_id']; ?>" />
									<?php } ?>
									</span>
								</p>
								<?php if($userr_typ == 'mreseller') { ?>
								<p>	
									<label style="width: 130px;">Zone</label>
									<select data-placeholder="Choose Zone..." name="box_id" class="chzn-select" style="width:250px;">
										<option value=""></option>
											<?php $resultsd=mysql_query("SELECT * FROM box WHERE z_id = '$macz_id' AND sts = '0'");
											while ($rowssss=mysql_fetch_array($resultsd)) { ?>
										<option value="<?php echo $rowssss['box_id']?>"><?php echo $rowssss['b_name'];?></option>
											<?php } ?>
									</select>
								</p>
								<?php } else{ ?>
								<p>	
									<label style="width: 130px;">Box</label>
									<select data-placeholder="Choose Box..." name="box_id" class="chzn-select" style="width:250px;">
										<option value=""></option>
											<?php $resultsd=mysql_query("SELECT * FROM box WHERE z_id = '$z_id' AND sts = '0'");
											while ($rowssss=mysql_fetch_array($resultsd)) { ?>
										<option value="<?php echo $rowssss['box_id']?>"><?php echo $rowssss['b_name'];?></option>
											<?php } ?>
									</select>
								</p>
								<?php } ?>
								<p>
									<label style="width: 130px;font-weight: bold;">Package*</label>
									<span class="field" style="margin-left: 0px;">
										<?php if($wayyyyyy == 'mktomac') { ?>
											<h4 style="margin-top: 15px;"><b><?php echo $mac_pack_name; ?> - <?php echo $mac_pack_price.'TK'; ?> (<?php echo $mac_pack_bandwith; ?>)</b></h4>
											<input type="hidden" name="p_id" value="<?php echo $mac_pack_id; ?>" />
											<?php } else{ ?>
												<select data-placeholder="Choose a Package" class="chzn-select" style="width:250px;" name="p_id" id="p_id" required="" onchange="myFunctionnn(event)">
													<option value=""></option>
														<?php while ($row1=mysql_fetch_array($result1)) { ?>
													<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
														<?php } ?>
												</select>
										<?php } ?><br>
									</span>
									<label style="width: 130px;"></label>
									<span id="dayprice" style="font-weight: bold;"></span>
								</p>
								<?php if($minimum_sts == '2' && $minimum_days_arrays != ''){?>
								<p>
									<label style="width: 130px;font-weight: bold;">Activation Days*</label>
									<span class="field" style="margin-left: 0px;font-weight: bold;">
										<select name="duration" id="duration" style="width:80px;font-weight: bold;font-size: 20px;height: 35px;margin-bottom: 5px;text-align: center;" placeholder="<?php echo $minimum_day;?>" required="">
											<option value=''></option>
											<?php foreach ($minimum_arraydd as $item) { 
												echo "<option value='$item'>$item</option>";
											}?>
										</select>
									</span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;"></label>
									<span class="field" style="margin-left: 0px;color: red;font-weight: bold;">[Minimum <?php echo $minimum_days_arrays;?> Days]</span>
								</p>
								<?php } else{?>
								<p>
									<label style="width: 130px;font-weight: bold;">Activation Days*</label>
									<span class="field" style="margin-left: 0px;font-weight: bold;"><input type="text" name="duration" id="duration" style="width:80px;font-weight: bold;font-size: 20px;height: 20px;" placeholder="30" required=""></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;"></label>
									<span class="field" style="margin-left: 0px;color: red;font-weight: bold;">[Minimum <?php echo $minimum_day;?> Days]</span>
								</p>
								<?php } ?>
								
								<p>
									<label style="width: 130px;">Bill Calculation</label>
										<span class="formwrapper" style="margin-left: 0;">
										<input type="radio" name="qcalculation" value="Auto"> Auto &nbsp; &nbsp;
										<input type="radio" name="qcalculation" value="Manual" checked="checked"> Manual &nbsp; &nbsp;
										<input type="radio" name="qcalculation" value="No"> No Bill &nbsp; &nbsp;<a id="resultpack"></a>
									</span>
								</p>
								<p>
									<label style="width: 130px;">Permanent Discount</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="discount" style="width:15%;" value="0.00"/><input type="text" name="" id="" style="width:3%; color:#2e3e4e; font-weight: bold;font-size: 15px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></span>
								</p>
								<p>
									<label style="width: 130px;">Permanent Extra Bill</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="extra_bill" style="width:15%;" value="0.00"/><input type="text" name="" id="" style="width:3%; color:#2e3e4e; font-weight: bold;font-size: 15px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly /></span>
								</p>
								<p>
									<label style="width: 130px;">Payment Method</label>
									<span class="field" style="margin-left: 0px;">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:250px;" required=""/>
											<option value="Home Cash"<?php if ('Home Cash' == $p_m) echo 'selected="selected"';?>>Cash from Home</option>
											<option value="Cash"<?php if ('Cash' == $p_m) echo 'selected="selected"';?>>Cash</option>
											<option value="Officeh"<?php if ('Office' == $p_m) echo 'selected="selected"';?>>Office</option>
											<option value="bKash"<?php if ('bKash' == $p_m) echo 'selected="selected"';?>>bKash</option>
											<option value="Rocket"<?php if ('Rocket' == $p_m) echo 'selected="selected"';?>>Rocket</option>
											<option value="iPay"<?php if ('iPay' == $p_m) echo 'selected="selected"';?>>iPay</option>
											<option value="Card"<?php if ('Card' == $p_m) echo 'selected="selected"';?>>Card</option>
											<option value="Bank"<?php if ('Bank' == $p_m) echo 'selected="selected"';?>>Bank</option>
											<option value="Corporate"<?php if ('Corporate' == $p_m) echo 'selected="selected"';?>>Corporate</option>
										</select>
									</span>
								</p>
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
												<option value="Shared">Shared</option>
												<option value="Dedicated">Dedicated</option>
											</select>
										<div id="result133" style="margin-left: 150px; font-weight: bold;"></div>
										</span>					
								</p>
								<p>
									<label style="width: 130px;">IP Address</label>
									<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="ip" id="ip" placeholder="Ex: 192.168.XX.XX" id="" class="input-xlarge" /></span>
								</p>
								
								<p>
									<label style="width: 130px;">Require Cable</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="req_cable" placeholder="Ex: 200ft" id="" style="width:240px;" /></span>
								</p>
								<p>
									<label style="width: 130px;">MAC Address</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="mac" style="width:240px;" placeholder="" id="" class="input-xlarge" /></span>
								</p>
								<p>
									<label style="width: 130px;">Connection Mode</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="con_sts" style="width:240px;" placeholder="" id="" value="Active" class="input-xlarge" readonly /></span>					
								</p>
								<p>
									<label style="padding: 7px 20px 0px 0px;width: 130px;">Image</label>
									<input type="hidden" name="old_image" value="no" />
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-append">
											<div class="uneditable-input span1">
												<i class="iconfa-file fileupload-exists"></i>
												<span class="fileupload-preview"></span>
											</div>
											<span class="btn btn-file" style="padding: 5px 10px 4px 10px;">
												<span class="fileupload-new">Choose</span>
												<span class="fileupload-exists">Change</span>
												<input type="file" class="input-small" name="main_image" onchange="readURL(this);" />
											</span>
											<a href="#" class="btn fileupload-exists" style="padding: 5px 10px 4px 10px;" data-dismiss="fileupload">Remove</a>
										</div>
									<img id="blah" src="emp_images/no_img.jpg" alt="" style="width: 50px;height: 50px;margin-left: 7px;"/>
									</div>
								</p>
								<p>
									<label style="padding: 7px 20px 0px 0px;width: 130px;">NID Front Side</label>
									<input type="hidden" name="old_nid_f_image" value="no" />
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-append">
											<div class="uneditable-input span1">
												<i class="iconfa-file fileupload-exists"></i>
												<span class="fileupload-preview"></span>
											</div>
											<span class="btn btn-file" style="padding: 5px 10px 4px 10px;">
												<span class="fileupload-new">Choose</span>
												<span class="fileupload-exists">Change</span>
												<input type="file" class="input-small" name="nid_f_image" onchange="readURL1(this);" />
											</span>
											<a href="#" class="btn fileupload-exists" style="padding: 5px 10px 4px 10px;" data-dismiss="fileupload">Remove</a>
										</div>
									<img id="blah1" src="images/no_nid.png" alt="" style="width: 90px;height: 50px;margin-left: 7px;"/>
									</div>
								</p>
								<p>
									<label style="padding: 7px 20px 0px 0px;width: 130px;">NID Back Side</label>
									<input type="hidden" name="old_nid_b_image" value="no" />
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-append">
											<div class="uneditable-input span1">
												<i class="iconfa-file fileupload-exists"></i>
												<span class="fileupload-preview"></span>
											</div>
											<span class="btn btn-file" style="padding: 5px 10px 4px 10px;">
												<span class="fileupload-new">Choose</span>
												<span class="fileupload-exists">Change</span>
												<input type="file" class="input-small" name="nid_b_image" onchange="readURL2(this);" />
											</span>
											<a href="#" class="btn fileupload-exists" style="padding: 5px 10px 4px 10px;" data-dismiss="fileupload">Remove</a>
										</div>
									<img id="blah2" src="images/no_nid.png" alt="" style="width: 90px;height: 50px;margin-left: 7px;"/>
									</div>
								</p>
							</div>
								
								
							<div style="margin-left: 48%;">
								<?php if($wayyyyyy == 'mktomac') { ?>
								
								<p>
									<label style="width: 130px;font-weight: bold;">Client Name*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="c_name" value="<?php echo $c_id;?>" id="" readonly required="" style="width:240px;" /></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">PPPoE ID*</label>
									<input type="text" name="c_id" id="name" placeholder="User id must be at least 3 characters long" value="<?php echo $c_id;?>" readonly style="width:240px;" required="" /><br><span id="result" style="margin-left: 220px; font-weight: bold;"></span>
								</p>
								<p>
									<label class="control-label" for="passid" style="width: 130px;font-weight: bold;">Login Password*</label>
									<div class="controls"><input type="text" name="passid" style="width:240px;" style="width:240px;" size="12" value="<?php echo $passid;?>" readonly required="" /></div>
								</p>
								<?php } else{?>
								<p>
									<label style="width: 130px;font-weight: bold;">Client Name*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="c_name" id="" required="" style="width:240px;" /></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">PPPoE ID*</label>
									<input type="text" name="c_id" id="name" placeholder="User id must be at least 3 characters long" value="<?php echo $row['prefix'];?>" style="width:240px;" required="" /><br><span id="result"></span>
								</p>
								<p>
									<label class="control-label" for="passid" style="width: 130px;font-weight: bold;">Login Password*</label>
									<div class="controls"><input type="password" name="passid" style="width:240px;" style="width:240px;" size="12" required="" /></div>
								</p>
								<?php } ?>
								<p>
									<label style="width: 130px;">Cell No</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="cell" placeholder="Must Use 8801XXXXXXXXX" id="" style="width:240px;" /></span>
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
									<label style="width: 130px;">Alternative Cell No</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="cell1" placeholder="Alternative Cell No:1" id="" style="width:240px;" /></span>
								</p>
								<p>
									<label style="width: 130px;">Father's Name</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="father_name" placeholder="Father's Name" id="" style="width:240px;" /></span>
								</p>
								<?php if($zthana != ''){ ?>
									<p>
										<label style="width: 130px;">Thana</label>
										<span class="field" style="margin-left: 0px;">
											<select data-placeholder="Choose a Package" name="thana" class="chzn-select" style="width:250px;">
												<?php foreach ($thana_arry as $option) {
													echo '<option value="' . $option . '">' . $option . '</option>';
													}?>
											</select>
										</span>
									</p>
								<?php } else{ ?>
									<p>
										<label style="width: 130px;">Thana</label>
										<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="thana" placeholder="" id="" class="input-xxlarge" /></span>
									</p>
								<?php } ?>
								<p>
									<label style="width: 130px;">Present Address</label>
									<span class="field" style="margin-left: 0px;"><textarea type="text" name="address" style="width:240px;" id="" /></textarea></span>
								</p>
								<p>
									<label style="width: 130px;">Permanent Address</label>
									<span class="field" style="margin-left: 0px;"><textarea type="text" name="old_address" style="width:240px;" id="" /></textarea></span>
								</p>
								<p>
									<label style="width: 130px;">Joining Date</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="join_date" style="width:240px;" placeholder="" id="" value="<?php echo date("Y-m-d");?>" class="input-xlarge" readonly /></span>					
								</p>
								<p>
									<label style="width: 130px;">National ID</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="nid" placeholder="Ex: 123456789" id="" style="width:240px;" class="input-xlarge" /></span>
								</p>
								<p>
									<label style="width: 130px;">Occupation</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="occupation" placeholder="Occupation" id="" style="width:240px;" class="input-xlarge" /></span>
								</p>
								<p>
									<label style="width: 130px;">Email</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="email" id="" placeholder="Ex: abcd@domain.com" style="width:240px;" class="input-xlarge" /></span>
								</p>
								
								<p>
									<label style="width: 130px;">Note</label>
									<span class="field" style="margin-left: 0px;"><textarea type="text" name="note" placeholder="Optional" id="" style="width:240px;" /></textarea></span>
								</p>
								<?php if($tree_sts_permission == '0'){?>
											<p>
												 <label style="width: 130px;"></label>
												<span class="field" style="margin-left: 0px;font-weight: bold;"><h3>Location On Google Map</h3></span>
											</p>
											<p>
												<label style="width: 130px;"></label>
												<span class="field" style="margin-left: 0px;">
													<div class="input-append">
														<p id="latitude"><input type="text" id="" readonly name="latitude" placeholder="Google Map Latitude" class="span2"></p>
														<p id="longitude"><input type="text" id="" readonly name="longitude" placeholder="Google Map Longitude" class="span2"></p>
													</div>
												<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 15%;padding: 10px;width: 6%;"><i class='iconfa-map-marker' style="font-size: 35px;"></i></a>
												</span>
											</p>
									<?php } else{ ?><input type="hidden" id="" name="latitude" placeholder="" class=""><input type="hidden" id="" name="longitude" placeholder="" class=""><?php } ?>
								
							</div><br><br><br>
		</div>
							<div class="modal-footer">
								<button type="reset" class="btn ownbtn11">Reset</button>
								<button class="btn ownbtn2" type="submit">Submit</button>
							</div>
					</form>	
					<?php } else{ ?>
					<div style='font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;padding: 30px;font-size: 30px;text-align: center;'>[User Limit Exceeded]</div>
					<?php }} ?>					
			</div>
		</div>
	</div>
	<?php } else{?>	
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Clients"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
				 <h3>Have not sufficient balance to add new client.</h3>
        </div>
    </div><!--pageheader-->
	<?php }
}
else{
	include('include/index');
}
include('include/footer.php');
?>

<script type="text/javascript">

function myFunctionnn() {
    document.getElementById("duration").value = '';
	 document.getElementById("dayprice").value = '';
}

$(document).ready(function()
{    
 $("#name").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 3)
  {  
   $("#result").html('checking...');
   
   /*$.post("username-check.php", $("#reg-form").serialize())
    .done(function(data){
    $("#result").html(data);
   });*/
   
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
</script>
<?php if($wayyyyyy == 'mktomac'){?>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#duration").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#dayprice").html('checking...');
   $.ajax({
    
    type : 'POST',
	url  : "duration-packageprice-calculation.php?p_id="+<?php echo $mac_pack_id;?>,
    data : $(this).serialize(),
    success : function(data)
        {
              $("#dayprice").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#dayprice").html('');
  }
 });
 
});
</script>
<?php } else{ if($minimum_sts == '2' && $minimum_days_arrays != ''){ ?>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="p_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $('select[name="duration"]').on('change',function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 0)
				  {  
				   $("#dayprice").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "duration-packageprice-calculation.php?p_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#dayprice").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#dayprice").html('');
				  }
				 });
				});
			}
        });
});
</script>
<?php } else{ ?>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="p_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#duration").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 0)
				  {  
				   $("#dayprice").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "duration-packageprice-calculation.php?p_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#dayprice").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#dayprice").html('');
				  }
				 });
				});
			}
        });
});
</script>
<?php } ?>
<script type="text/javascript">
				$(document).ready(function()
				{    
				 jQuery('select[name="p_id"]').on('change',function(){
				  var p_id = jQuery(this).val(); 
				   $.ajax({
					type : 'POST',
					url  : "mk-pack-check.php?mk_id="+<?php echo $mkkk_id;?>,
					data : jQuery(this),
					success : function(data)
						{
							  $("#resultpack").html(data);
						   }
					});
					return false;
				 });
				});
			
</script>
<script type="text/javascript">
				$(document).ready(function()
				{    
				 $("#ip").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 7)
				  {  
				   $("#result133").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "ip-mac-check.php?mk_id="+<?php echo $mkkk_id;?>,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#result133").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#result133").html('');
				  }
				 });
				});
</script>
<?php } ?>
<style>
.ui-spinner-buttons{display: none;}
</style>
  <script type="text/javascript">
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(50)
                        .height(50);
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
                        .width(90)
                        .height(50);
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
                        .width(90)
                        .height(50);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
<script>
var latitude = document.getElementById("latitude");
var longitude = document.getElementById("longitude");
var map;
var faisalabad = {lat:<?php echo $copmaly_latitude;?>, lng:<?php echo $copmaly_longitude;?>};

function addYourLocationButton(map, marker) 
{
    var controlDiv = document.createElement('div');

    var firstChild = document.createElement('button');
    firstChild.style.backgroundColor = '#fff';
    firstChild.style.border = 'none';
    firstChild.style.outline = 'none';
    firstChild.style.width = '40px';
    firstChild.style.height = '40px';
    firstChild.style.borderRadius = '8px';
    firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
    firstChild.style.cursor = 'pointer';
    firstChild.style.marginRight = '10px';
    firstChild.style.padding = '0px';
    firstChild.title = 'Your Location';
    controlDiv.appendChild(firstChild);

    var secondChild = document.createElement('div');
    secondChild.style.margin = '11px';
    secondChild.style.width = '18px';
    secondChild.style.height = '18px';
    secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
    secondChild.style.backgroundSize = '180px 18px';
    secondChild.style.backgroundPosition = '0px 0px';
    secondChild.style.backgroundRepeat = 'no-repeat';
    secondChild.id = 'you_location_img';
    firstChild.appendChild(secondChild);

    google.maps.event.addListener(map, 'dragend', function() {
        $('#you_location_img').css('background-position', '0px 0px');
    });

    firstChild.addEventListener('click', function() {
        var imgX = '0';
        var animationInterval = setInterval(function(){
            if(imgX == '-18') imgX = '0';
            else imgX = '-18';
            $('#you_location_img').css('background-position', imgX+'px 0px');
        }, 500);
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
				latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' value='" + position.coords.latitude + "'/>";
				longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' value='" + position.coords.longitude + "'/>";
                marker.setPosition(latlng);
                map.setCenter(latlng);
                clearInterval(animationInterval);
                $('#you_location_img').css('background-position', '-144px 0px');
            });
        }
        else{
            clearInterval(animationInterval);
            $('#you_location_img').css('background-position', '0px 0px');
        }
    });

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
     console.log(event.latLng);   // Get latlong info as object.
     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
 });
 google.maps.event.addListener(map, 'click', function(event) {
	latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' value='" + event.latLng.lat() + "'/>";
	longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' value='" + event.latLng.lng() + "'/>";
});

    controlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
}

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: faisalabad
    });
    var myMarker = new google.maps.Marker({
        map: map,
        animation: google.maps.Animation.DROP,
        position: faisalabad
    });
    addYourLocationButton(map, myMarker);
	<?php if($location_service == '1'){?>
function getLocation() {
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
} else { 
latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' />";
longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' />";
}
}

function showPosition(position) {
latitude.innerHTML = "<input type='text' class='span2' placeholder='Map Latitude' readonly name='latitude' value='" + position.coords.latitude + "'/>";
longitude.innerHTML = "<input type='text' class='span2' placeholder='Map longitude' readonly name='longitude' value='" + position.coords.longitude + "'/>";
}

window.onClick=getLocation();
<?php } ?>
}

$(document).ready(function(e) {
    initMap();
}); 
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkwr5rmzY9btU08sQlU9N0qfmo8YmE91Y&callback=initMap"></script>
