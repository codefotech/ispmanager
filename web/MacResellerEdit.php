<?php
$titel = "MacReseller"; 
$MacReseller = 'active';
include('include/hader.php');
include("conn/connection.php") ;

$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'MacReseller' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


$sql = mysql_query("SELECT * FROM emp_info WHERE id = '$id'");
$row = mysql_fetch_assoc($sql);
$eee_id = $row['e_id'];
$reseller_mk_id = $row['mk_id'];
$minimum_days = $row['minimum_days'];
if($minimum_days == ''){
	$minimum_array =  $minimum_days;
}
else{
	$minimum_array = explode(',', $minimum_days);
}
$sql1qqq = mysql_query("SELECT * FROM zone WHERE e_id = '$eee_id'");
$rowwww = mysql_fetch_assoc($sql1qqq);
$zid = $rowwww['z_id'];

$ret11=mysql_query("SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' AND id = '$reseller_mk_id'");
$rottw = mysql_fetch_assoc($ret11);
$mk_name = $rottw['Name'];
$mk_ip = $rottw['ServerIP'];
$mkkkk_id = $rottw['id'];

$sqluuu = mysql_query("SELECT COUNT(id) AS z_clients FROM clients WHERE sts = '0' AND z_id = '$zid'");
$rowuuu = mysql_fetch_assoc($sqluuu);
$z_clients = $rowuuu['z_clients'];

$sql1 = mysql_query("SELECT * FROM package WHERE z_id = '$zid' AND status = '0'");

?>
<!-- Image upload Script Start -->
<script type="text/javascript">			
function readURL(input) {			
if (input.files && input.files[0]) {			
var reader = new FileReader();			
reader.onload = function (e) {			
$('#img_prev')			
.attr('src', e.target.result)			
.width(210)			
.height(250);			
};			
reader.readAsDataURL(input.files[0]);			
}			
}
</script>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Edit Mac Reseller</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Mac Reseller Info</h5>
				</div>			
				<form class="stdform" method="post" action="MacResellerEditQuery" name="form" enctype="multipart/form-data">
				<input type="hidden" name="id" class="input-xxlarge" readonly value="<?php echo $row['id']; ?>" />
					<div class="modal-body">
						<p>
							<label>Reseller ID</label>
							<span class="field">
								<input type="text" name="e_id" class="input-xlarge" readonly value="<?php echo $row['e_id']; ?>" />
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Network/Mikrotik*</label>
							<span class="field">
								<input type="text" name="" class="input-xlarge" readonly value="<?php echo $mkkkk_id.' - '.$mk_name.' ('.$mk_ip.')';?>" />
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Packages* </label>
								<table class="table table-bordered responsive" style="text-align: center;width: 70%;">
									 <thead>
										<tr>	
											<th style="width: 2%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #ff7800;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">ID</th>
											<th style="width: 43%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #ff7800;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">MIKROTIK PROFILE</th>
											<th style="width: 30%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #ff7800;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">PACKAGE NAME</th>
											<th style="width: 10%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #ff7800;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">BANDWITH</th>
											<th style="width: 15%;padding:5px 0px 5px 5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #ff7800;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">PRICE</th>
										</tr>
									 </thead>
									 <tbody>
										<?php										
												for($i=0; $i<20; $i++){											
													while($row2 = mysql_fetch_assoc($sql1)){	$i = $i+1;													
															echo														
															"<tr>											
																<td class='center' style='font-size: 15px;font-weight: bold;padding-top: 12px;'>{$row2['p_id']}</td>											
																<td class='center'>													
																	<input type='text' class='input-small' readonly style='width: 90%;font-weight: bold;' value='{$row2['mk_profile']}' />
																</td>
																<td class='center'>													
																	<input type='text' class='input-small' readonly style='width: 90%;font-weight: bold;' value='{$row2['p_name']}' />
																</td>												
																<td class='center'>												
																	<input type='text' class='input-small' readonly style='font-weight: bold;' value='{$row2['bandwith']}'/>
																</td>											
																<td class='center'>												
																	<input type='text' style='width: 55%;font-weight: bold;' readonly  value='{$row2['p_price']}'/><input type='text' style='width:13%; color:#2e3e4e; font-weight: bold;font-size: 13px;border-right: 1px solid #bbb;border-top: 1px solid #bbb;border-bottom: 1px solid #bbb;border-left: 0px solid #bbb;' value='৳' readonly />
																</td>											
																</tr>\n";											
													}  
												}	
										?>
										<tr> 
											<td colspan="5"><a style="float: right;font-weight: bold;font-size: 22px;color: #ff7800;" href="Package"><i class="iconfa-edit"></i></a></td>
										</tr>
									</tbody>
									
								</table>
														
						</p>

						<p>
							<label>MAC Area/Zone </label>
							<span class="field">
								<input type="text" class="input-large" readonly value="<?php echo $rowwww['z_name']; ?>" />
								<input type="text" class="input-large" readonly value="<?php echo $rowwww['z_bn_name']; ?>" />
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Prefix </label>
							<span class="field">
								<input type="text" name="prefix" id="" class="input-large" style="width: 10%;" placeholder="like: ABCD" value="<?php echo $row['prefix']; ?>"/>
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Billing Type*</label>
							<span class="formwrapper" style="margin-left: 0;">
								<input type="radio" id="male" value="Postpaid" name="billing_type" <?php if($row['billing_type'] == 'Postpaid') {echo 'checked';}?>/>Postpaid &nbsp; &nbsp;
								<input type="radio" value="Prepaid" name="billing_type" <?php if($row['billing_type'] == 'Prepaid') {echo 'checked';}?>/>Prepaid &nbsp; &nbsp;
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Over Due Amount*</label>
							<span class="field">
								<input type="text" name="over_due" value="<?php echo $row['over_due'];?>" style="width:80px;height: 25px;font-size: 20px;font-weight: bold;color: brown;"/><input type="text" name="" id="" style="width:17px;height: 25px; color:brown; font-weight: bold;font-size: 20px;border-left: none;" value="৳" readonly="">
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Minimum Recharge Day* </label>
							<span class="field">
								<div class="input-prepend">
								<input type="text" name="minimum_day" id="" class="input-large" placeholder="Single Day" required="" value="<?php echo $row['minimum_day'];?>"/>
									<span class="add-on" style="border-radius: 0 5px 5px 0;font-weight: bold;font-size: 13px;border-left: 0px solid transparent;height: 20px;">
										<input type="radio" name="minimum_sts" id="prependedInput" class="span2" value="1" <?php if($row['minimum_sts'] == '1') {echo 'checked';}?>/>&nbsp; Active &nbsp;
									</span>
								</div>
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Minimum Recharge Days* </label>
							<span class="field">
							<div class="input-prepend">
								<select data-placeholder="Multi Days" name="minimum_days[]" class="chzn-select" multiple="multiple" style="width:220px;" tabindex="4">
									<option value="1">1</option> 
									<option value="2">2</option> 
									<option value="3">3</option> 
									<option value="4">4</option> 
									<option value="5">5</option> 
									<option value="6">6</option> 
									<option value="7">7</option> 
									<option value="8">8</option> 
									<option value="9">9</option> 
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
									<?php foreach ($minimum_array as $item) { 
												echo "<option selected='selected'>$item</option>";
											}?>
								</select>
								<span class="add-on" style="border-radius: 0 5px 5px 0;font-weight: bold;font-size: 13px;height: 23px;border-left: 0px solid transparent;"><input type="radio" name="minimum_sts" id="prependedInput" class="span2" value="2" <?php if($row['minimum_sts'] == '2') {echo 'checked';}?>/>&nbsp; Active &nbsp; </span>
                            </div>
							</span>
						</p>

						<p>
							<label style="font-weight: bold;">Auto Recharge?*</label>
							<span class="formwrapper" style="margin-left: 0;">
								<input type="radio" value="1" name="auto_recharge" <?php if($row['auto_recharge'] == '1') {echo 'checked';}?>/>Enable &nbsp; &nbsp;
								<input type="radio" value="0" name="auto_recharge" <?php if($row['auto_recharge'] == '0') {echo 'checked';}?>/>Disable &nbsp; &nbsp;
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Serial Start From* </label>
							<span class="field">
								<input type="text" name="last_id" id="" class="input-large" required="" value="<?php echo $row['last_id']; ?>"/>
							</span>
						</p>
						
						<p>
							<label style="font-weight: bold;">Position* </label>
							<span class="field">
							<input type="text" name="e_des" id="" value="<?php echo $row['e_des']; ?>" class="input-xxlarge" required=""/>
							</span>
						</p>
						<p>
							<label style="font-weight: bold;">Reseller Name* </label>
							<span class="field">
							<input type="text" name="e_name" id="" value="<?php echo $row['e_name']; ?>" class="input-xxlarge" required=""/>
							</span>
						</p>
						<p>
							<label>Father's Name </label>
							<span class="field">
							<input type="text" name="e_f_name" id="" value="<?php echo $row['e_f_name']; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>Mother's Name </label>
							<span class="field">
							<input type="text" name="e_m_name" id="" value="<?php echo $row['e_m_name']; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>
							Date of Birth </label>
							<span class="field">
							<input type="text" name="e_b_date" id="" value="<?php echo $row['e_b_date']; ?>" class="input-xxlarge datepicker"/>
							</span>
						</p>
						<p>
							<label>
							Joining Date </label>
							<span class="field">
							<input type="text" name="e_j_date" id="" class="input-xxlarge datepicker" value="<?php echo $row['e_j_date']; ?>" />
							</span>
						</p>
						<p>
							<label>
							Gender </label>
							<span class="field">
							<input type="radio" id="male" value="Male" name="e_gender" <?php if( $row['e_gender'] == 'Male') {echo 'checked';} ?> />
							Male &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; 
							<input type="radio" id="female" value="Female" name="e_gender" <?php if( $row['e_gender'] == 'Female') {echo 'checked';} ?> />
							Female </span>
						</p>
						<p>
							<label>
							Marital Status </label>
							<span class="field">
							<input type="radio" id="Unmarried" value="Unmarried" name="married_stu" <?php if( $row['married_stu'] == 'Unmarried') {echo 'checked';} ?> />
							Unmarried &nbsp; &nbsp; &nbsp; &nbsp; <input type="radio" id="Married" value="Married" name="married_stu" <?php if( $row['married_stu'] == 'Married') {echo 'checked';} ?> />
							Married </span>
						</p>
						<p>
							<label>Blood Group</label>
							<select class="select-ext-large chzn-select" style="width:540px;" name="bgroup">
								<option value="">Choose Blood Group</option>
								<option value="AB+" <?php if( $row['bgroup'] == 'AB+') {echo 'selected';} ?>>AB+</option>
								<option value="AB-" <?php if( $row['bgroup'] == 'AB-') {echo 'selected';} ?>>AB-</option>
								<option value="A+" <?php if( $row['bgroup'] == 'A+') {echo 'selected';} ?>>A+</option>
								<option value="A-" <?php if( $row['bgroup'] == 'A-') {echo 'selected';} ?>>A-</option>
								<option value="B+" <?php if( $row['bgroup'] == 'B+') {echo 'selected';} ?>>B+</option>
								<option value="B-" <?php if( $row['bgroup'] == 'B-') {echo 'selected';} ?>>B-</option>
								<option value="O+" <?php if( $row['bgroup'] == 'O+') {echo 'selected';} ?>>O+</option>
								<option value="O-" <?php if( $row['bgroup'] == 'O-') {echo 'selected';} ?>>O-</option>
							</select>
						</p>
						<p>
							<label>National ID</label>
							<span class="field">
							<input type="text" name="n_id" id="" value="<?php echo $row['n_id']; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<h4 class="h44">Employee Contact Information </h4>
						<p>
							<label>Present Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="pre_address" id="" class="input-xxlarge"><?php echo $row['pre_address']; ?></textarea>
							</span>
						</p>
						<p>
							<label>Permanent Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="per_address" id="" class="input-xxlarge"><?php echo $row['per_address']; ?></textarea>
							</span>
						</p>
						<p> Contact Info </p>
						<p>
							<label style="font-weight: bold;">Personal Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_per" id="" class="input-xxlarge" value="<?php echo $row['e_cont_per']; ?>" required="" />
							</span>
						</p>
						<p>
							<label>Office Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_office" id="" class="input-xxlarge" value="<?php echo $row['e_cont_office']; ?>" />
							</span>
						</p>
						<p>
							<label>Family Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_family" id="" class="input-xxlarge" value="<?php echo $row['e_cont_family']; ?>" />
							</span>
						</p>
						<p>
							<label>First Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact1" id="" class="input-xxlarge" value="<?php echo $row['ref_contact1']; ?>" />
							</span>
						</p>
						<p>
							<label>Second Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact2" id="" class="input-xxlarge" value="<?php echo $row['ref_contact2']; ?>" />
							</span>
						</p>
						<p>
							<label>Email </label>
							<span class="field">
							<input type="text" name="email" id="" class="input-xxlarge" value="<?php echo $row['email']; ?>" />
							</span>
						</p>
						<p>
							<label>Skype </label>
							<span class="field">
							<input type="text" name="skype" id="" class="input-xxlarge" value="<?php echo $row['skype']; ?>" />
							</span>
						</p>
						<p>
						<label>Agent</label>
							<select name="agent_id" class="chzn-select" style="width:240px;" onChange="getRoutePoint11(this.value)">	
								<option value="0">--None--</option>		
							<?php 
								$queryd="SELECT * FROM agent WHERE sts = '0' order by e_name ASC";
								$resultd=mysql_query($queryd);
								while ($rowd=mysql_fetch_array($resultd)) { ?>
											
								<option value=<?php echo $rowd['e_id'];?> <?php if($rowd['e_id'] == $row['agent_id']) echo 'selected="selected"';?> ><?php echo $rowd['e_name'];?> (<?php echo $rowd['com_percent'];?>%)</option>		
							<?php } ?>
							</select>
						</p>
						<div id="Pointdiv100">
								
								<?php if($row['agent_id'] != '0'){?>
									<p>
										<label>Manual Commission</label>
										<span class="field"><input type="text" name="com_percent" style="width:5%;" required="" value="<?php echo $row['com_percent'];?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 15px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
									</p>
									<p>
										<label>Count Commission?</label>
										<span class="formwrapper">
											<input type="radio" name="count_commission" value="1" <?php if ('1' == $row['count_commission']) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
											<input type="radio" name="count_commission" value="0" <?php if ('0' == $row['count_commission']) echo 'checked="checked"';?>> No &nbsp; &nbsp;
										</span>
									</p>
								<?php } ?>
								
						</div>
						<p>
							<label class="control-label" for="com_logo">Reseller Image</label>
							<div class="controls">
								<span class="btn btn-file">
									<span class="fileupload-new">Choose Image</span>
									<input type='file' name="image" onchange="readURL(this);" />
								</span>
								<img id="blah" src="<?php if($row['e_image'] == 'emp_images/' || $row['e_image'] == ''){echo 'images/user.png';} else{echo $row['e_image'];}?>" height="50" width="50"  alt="" />
							</div>
						</p>
						<p>
                            <label>Set Default Logo</label>
                            <span class="field"><input type='checkbox' <?php if($row['default_logo'] == '0'){echo 'checked';}?> name='default_logo' value='0' /> <img src="<?php echo 'images/logo.png';?>" height="25" width="125" alt="" />
							</span>
                        </p>
						<p>
                            <span class="field" style="font-weight: bold;font-size: 16px;color: #317eac;">&nbsp; &nbsp;Or&nbsp; &nbsp;</span>
                        </p>
						<p>
                            <label class="control-label" for="com_logo">Set New Logo</label>
							<div class="controls">
								<span class="btn btn-file">
										<span class="fileupload-new">Choose Logo</span>
										<input type='file' name="reseller_logo" onchange="readURL1(this);" />
								</span>
								<img id="blah1" src="<?php if($row['reseller_logo'] != ''){echo $row['reseller_logo'];} else{echo 'images/logo.png';}?>" height="25" width="125"  alt="" />
							</div>
						</p>
						<p>
							<span class="field">
								<a style="color: red;font-weight: bold;">[Logo size must be 175X40]</a>
							</span>
						</p>
					</div>
					<!--#wiz1step3-->
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
else{
	include('include/index');
}
include('include/footer.php');
?>
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
    </script>
	 <script type="text/javascript">
     function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah1')
                        .attr('src', e.target.result)
                        .width(125)
                        .height(25);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

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
	

	function getRoutePoint11(afdId) {		
		
		var strURL="agent_commission.php?agent_id="+afdId;
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