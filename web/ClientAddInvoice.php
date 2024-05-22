<?php
$titel = "Add Invoice Client";
$Clients = 'active';
include('include/hader.php');
extract($_POST);

ini_alter('date.timezone','Asia/Almaty');
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type in (1,2)");
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21" style="left: 35%;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="map" style="width:170%;height:500px;"></div>
		</div>
	</div>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
				<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i>&nbsp; Back</a>
			<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
				<a class="btn ownbtn2" href="InvoiceItem">Invoice Particulars</a>
			<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Add Invoice Client</h1>
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
						<input type="hidden" name="breseller" value="2" />
						<input type="hidden" name="u_type" value="client" />
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_date" value="<?php echo date('Y-m-d', time());?>" />
						<input type="hidden" name="entry_time" value="<?php echo date('H:i:s', time());?>" />
						<div class="modal-body" style="overflow: hidden;">
							<div style="float: left;width: 50%;">
								<p>	
									<label style="width: 130px;font-weight: bold;">Zone*</label>
									<select data-placeholder="Choose a Zone..." name="z_id" class="chzn-select" style="width:250px;" required="" onChange="getRoutePoint(this.value)">
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>	
									<label style="width: 130px;">Box</label>
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
								<p>
									<label style="width: 130px;">POP Name</label>
									<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="pop" placeholder="" id="" class="input-xlarge" /></span>
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
									<label style="width: 130px;font-weight: bold;">Login ID*</label>
									<input type="text" name="c_id" id="name" placeholder="At least 3 characters long" style="width:200px;" class="input-xxlarge" required="" /><span id="result" style="margin-left: 160px; font-weight: bold;"></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;" class="control-label" for="passid">Password*</label>
									<div class="controls"><input type="text" name="passid" class="input-xxlarge" size="12" style="width:200px;" required="" placeholder="Login Password"/></div>
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
									<div class="widgettitle" style="margin: 5px -41px 0px 0px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 0px;font-weight: bold;background: none;border-top: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 1px solid rgba(0, 0, 0, 0.2);"> <a class="minimize collapsed" style="float: left;margin-left: 20px;font-weight: normal;">-</a>Monthly Invoice & Transmission</div>
									<div class="widgetcontent" style="margin-right: -41px;background: none;border: none;display: block">
									<div style="float: left;width: 50%;">
									<p>
										<label style="width: 130px;">NTTN Info</label>
										<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="nttn" placeholder="" id="" class="input-xxlarge" /></span>
									</p>
									<p>
										<label style="width: 130px;">VLAN</label>
										<span class="field" style="margin-left: 0px;">
											<table class="table table-bordered responsive nnew" style="max-width: 50%">
												<colgroup>
													<col class="con1" />
													<col class="con0" />
													<col class="con1" />	
													<col class="con0" />
												</colgroup>
											 <tbody>
												<tr class='gradeX'>
													<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input id="check_all" class="" type="checkbox"/></td>
													<td class="center" style="border-top: 1px solid #dddddd;width: 30%;"><input type="text" style="width: 92%;" name="vlanId[]" placeholder="VLAN ID" id="vlanId_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
													<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="vlanName[]" placeholder="VLAN Name" id="vlanName_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
												</tr>
											</tbody>
											</table>
										</span>
									</p>
									<p>
										<label style="width: 130px;"></label>
										<span class="field" style="margin-left: 0px;">
											<button class="btn-danger delete" style="font-size: 25px;" type="button"> - </button>
											<button class="btn-success addmore" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
										</span>
									</p>
									<p>
										 <label style="width: 130px;font-weight: bold;">This Month Bill*</label>
											<span class="field" style="margin-left: 0px;">
												<select class="chzn-select" name="qcalculation" style="width:250px;" required="" >
													<option value="Auto">Auto</option>
													<option value="Manual" selected="selected">Manual</option>
													<option value="No">No Bill</option>
												</select>
											</span>					
									</p>
									<p>
									<label style="width: 130px;"></label>
									<table class="table" style="width: max-content;">
										<tr>
											<td class="" style="font-weight: bold;border-bottom: 1px solid #ddd;text-align: right;">Invoice<br/>Date</td>
											<td class="" style="border-right: 2px solid #ddd;width: 90px;border-bottom: 1px solid #ddd;">
												<select class="chzn-select" name="invoice_date" style="width:70%;" />
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
												<select class="chzn-select" name="due_deadline" style="width:70%;" />
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
													<option value="15" selected="selected">15</option>
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
											<td class="" style="font-weight: bold;text-align: left;border-bottom: 1px solid #ddd;">Due<br/>Deadline</td>
										</tr>
									</table>
									</p>
									</div>
									<div style="margin-left: 48%;">
									<p>
										<label style="width: 130px;">Link Id</label>
										<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="link_id" placeholder="" id="" class="input-xlarge" /></span>
									</p>
									<p>
										<label style="width: 130px;">IP Address</label>
										<span class="field" style="margin-left: 0px;">
											<table class="table table-bordered responsive nnew1" style="max-width: 50%">
												<colgroup>
													<col class="con1" />
													<col class="con0" />
												</colgroup>
											 <tbody>
												<tr class='gradeX'>
													<td class="center" style="width: 5%;border-top: 1px solid #dddddd;"><input id="check_all1" class="" type="checkbox"/></td>
													<td class="center" style="border-top: 1px solid #dddddd;"><input type="text" style="width: 92%;" name="ipaddress[]" placeholder="IP Address 1" id="ipaddress_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
												</tr>
											</tbody>
											</table>
										</span>
									</p>
									<p>
										<label style="width: 130px;"></label>
										<span class="field" style="margin-left: 0px;">
											<button class="btn-danger delete1" style="font-size: 25px;" type="button"> - </button>
											<button class="btn-success addmore1" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
										</span>
									</p>
									
									</div>
										<table class="table table-bordered responsive nnew2" style="max-width: 96%;margin-left: 30px;">
											<colgroup>
												<col class="con1" />
												<col class="con0" />
												<col class="con1" />
												<col class="con0" />
												<col class="con1" />
												<col class="con0" />
												<col class="con1" />
												<col class="con0" />
												<col class="con1" />												
											</colgroup>
											 <thead class="newThead">
												<tr>	
													<th style="width: 2%;text-align: center;"><input id="check_all2" class="formcontrol" type="checkbox"/></th>
													<th style="width: 2%;text-align: center;">S/L</th>
													<th style="width: 10%;text-align: center;">Particulars</th>
													<th style="width: 15%;text-align: center;">Description</th>
													<th style="width: 5%;text-align: center;">Quantity</th>
													<th style="width: 5%;text-align: center;">Unit</th>
													<th style="width: 5%;text-align: center;">Rate</th>
													<th style="width: 5%;text-align: center;">Vat(%)</th>
													<th style="width: 10%;text-align: center;">Total</th>
												</tr>
											 </thead>
											 <tbody>
												<tr class='gradeX'>
													<td class="center"><input class="case2" style="text-align: center;" type="checkbox"/></td>
													<td class="center" style="font-size: 17px;font-weight: bold;padding: 10px 0;color: red;">1</td>
																		<input type="hidden" style="width: 92%;" data-type="productCode" name="itemNo[]" required="" id="itemNo_1" class="changesNoform-control autocomplete_txt" autocomplete="off">
													<td class="center" ><input type="text" style="width: 92%;" data-type="productName" name="itemName[]" required="" placeholder="Like: BDIX, Youtube" id="itemName_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
													<td class="center" ><input type="text" style="width: 92%;" data-type="productDes" name="itemDes[]" placeholder="" id="itemDes_1" class="changesNoform-control autocomplete_txt" autocomplete="off"></td>
													<td class="center">
														<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="quantity[]" class="changesNo" id="quantity_1" style="width: 92%;font-weight: bold;" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
													</td>
													<td class="center" >
														<input type="text" data-type="productUnit" class="" name="unit[]" id="unit_1" class="changesNoform-control autocomplete_txt" autocomplete="off" readonly style="width: 92%;font-weight: bold;text-align: center;"/>
													</td>
													<td class="center">
														<input type="text" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="uniteprice[]" class="changesNo" id="uniteprice_1" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
													</td>
													<td class="center">
														<input type="text" data-type="productVat" style="width: 92%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="vat[]" class="changesNo" id="vat_1" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
													</td>
													<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" name="price[]" id="price_1" readonly class="totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
												</tr>
											</tbody>
										</table>
										<table class="table responsive" style="max-width: 96%;margin-left: 30px;border: 0;">
											<tr>
												<td style="width: 34%;border: 0;">
													<button class="btn-danger delete2" style="font-size: 25px;" type="button"> - </button>
													<button class="btn-success addmore2" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
												</td>
												<td style="width: 15%;border: 0;text-align: right;vertical-align: middle;font-size: 17px;font-weight: bold;color: #58666e;font-family: 'Noto Serif',serif;">Total:</td>
												<td style="width: 15%;border: 0;padding: 8px 0px 8px 30px;text-align: left;"><input type="text" style="width: 15px;font-weight: bold;font-size: 15px;border-radius: 5px 0 0 6px;border-right: 0;color: #58666e;" readonly value="৳"/><input type="text" style="width: 50%;font-weight: bold;font-size: 18px;color: #58666e;border-radius: 0 5px 5px 0px;" name="total_price" required="" readonly id="totalAftertax" placeholder="Total" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/></td>
											</tr>
											<input type="hidden" style="width: 50%;font-weight: bold;font-size: 18px;color: #58666e;border-radius: 0 5px 5px 0px;" required="" readonly id="subTotal" name="subtotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/>
											<input type="hidden" style="width: 50%;font-weight: bold;font-size: 16px;color: #58666e;border-radius: 0 5px 5px 0px;" id="tax" name="discount" placeholder="Discount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
										</table>
									</div>
								</div>
							</div>
							
							<div class="span12" style="width: 100%;margin-left: -21px;">
								<div class="widgetbox">
									<div class="widgettitle" style="margin: 5px -41px 0px 0px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 0px;font-weight: bold;background: none;border-top: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 1px solid rgba(0, 0, 0, 0.2);"> <a class="minimize" style="float: left;margin-left: 20px;font-weight: normal;">-</a>Images & Location</div>
									<div class="widgetcontent" style="margin-right: -41px;background: none;border: none;display: block">
										<div style="float: left;width: 50%;">
										<?php if($image == ''){?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 130px;">Image</label>
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
											<?php } else{ ?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 130px;">Image</label>
												<div class="controls">
													<span class="btn btn-file">
														<img  src="<?php echo $image;?>" height="50px" width="50px" />
													</span>
													<input type="hidden" name="old_image" value="<?php echo $image;?>" />
												</div>
											</p>
											<?php } ?>
											<?php if($nid_f_image == ''){?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 130px;">NID Front Side</label>
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
											<?php } else{ ?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 130px;">NID Front Side</label>
												<div class="controls">
													<span class="btn btn-file">
														<img  src="<?php echo $nid_f_image;?>" height="50px" width="90px" />
													</span>
													<input type="hidden" name="old_nid_f_image" value="<?php echo $nid_f_image;?>" />
												</div>
											</p>
											<?php } if($nid_b_image == ''){?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 130px;">NID Back Side</label>
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
											<?php } else{ ?>
											<p>
												<label style="padding: 14px 20px 0px 0px;width: 130px;">NID Back Side</label>
												<div class="controls">
													<span class="btn btn-file">
														<img  src="<?php echo $nid_b_image;?>" height="50px" width="90px" />
													</span>
													<input type="hidden" name="old_nid_b_image" value="<?php echo $nid_b_image;?>" />
												</div>
											</p>
											<?php } ?>
											<p>
												<label style="width: 130px;">National ID No</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="nid" placeholder="Ex: NID Number" id="" class="input-xxlarge" value = "<?php echo $nid;?>" /></span>
											</p>
										</div>
									<?php if($tree_sts_permission == '0'){?>
										<div style="float: left;width: 48%;">
											<p>
												 <label style="width: 130px;"></label>
												<span class="field" style="margin-left: 0px;font-weight: bold;"><h3>Location On Google Map</h3></span>
											</p>
											<p>
												<label style="width: 130px;"></label>
												<span class="field" style="margin-left: 0px;">
													<div class="input-append">
														<p id="latitude"><input type="text" id="" name="latitude" placeholder="Google Map Latitude" class="span2"></p>
														<p id="longitude"><input type="text" id="" name="longitude" placeholder="Google Map Longitude" class="span2"></p>
													</div>
												<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 15%;padding: 10px;width: 6%;"><i class='iconfa-map-marker' style="font-size: 35px;"></i></a>
												</span>
											</p>
										</div>
									<?php } else{ ?><input type="hidden" id="" name="latitude" placeholder="" class=""><input type="hidden" id="" name="longitude" placeholder="" class=""><?php } ?>
									</div>
								</div>
							</div>
							<div class="span12" style="width: 100%;margin-left: -21px;">
								<div class="widgetbox">
									<div class="widgettitle" style="margin: 5px -41px 0px 0px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 0px;font-weight: bold;background: none;border-top: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 1px solid rgba(0, 0, 0, 0.2);"> <a class="minimize" style="float: left;margin-left: 20px;font-weight: normal;">-</a>Diagram & Connectivity</div>
									<div class="widgetcontent" style="margin-right: -41px;background: none;border: none;display: block">
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
										</div>
									</div>
								</div>
							</div>
							<div class="span12" style="width: 100%;margin-left: -21px;">
								<div class="widgetbox">
									<div class="widgettitle" style="margin: 5px -41px 0px 0px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 0px;font-weight: bold;background: none;border-top: 1px solid rgba(0, 0, 0, 0.2);border-bottom: 1px solid rgba(0, 0, 0, 0.2);"> <a class="minimize" style="float: left;margin-left: 20px;font-weight: normal;">-</a>Advance</div>
									<div class="widgetcontent" style="margin-right: -41px;background: none;border: none;display: block">
										<div style="float: left;width: 50%;">
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
												 <label style="width: 130px;">Thana</label>
												<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" name="thana" placeholder="" id="" class="input-xxlarge" /></span>
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&callback=initMap"></script>
<script src="invoice/js/jquery.min.js"></script>
<script src="invoice/js/jquery-ui.min.js"></script>
<script src="invoice/js/auto_ClientAddinvoice.js"></script>
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

<style>
  #uniform-check_all {
	  margin-top: 5px;
	margin-right: 0px;
  }
</style>
<style>
  #uniform-check_all1 {
	  margin-top: 5px;
	margin-right: 0px;
  }
</style>
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