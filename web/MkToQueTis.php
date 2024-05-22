<?php
$titel = "Add Queue Clients";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
	$rowmk = mysql_fetch_array($sqlmk);
	$ServerIP = $rowmk['ServerIP'];
	$Username = $rowmk['Username'];
	$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
	$Port = $rowmk['Port'];
								
	$API = new routeros_api();
	$API->debug = false;
		if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

		$API->write('/ip/arp/print', false);
		$API->write('?address='.$ip);
		$res=$API->read(true);

		$mac = $res[0]['mac-address']; 

	$API->disconnect();
	}

$sql2oo ="SELECT last_id FROM app_config";

$query2oo = mysql_query($sql2oo);
$row2ff = mysql_fetch_assoc($query2oo);
$idzff = $row2ff['last_id'];
$com_id = $idzff + 1;
?>
<script type="text/javascript">
function updatesum() {
document.form.bill_amount.value = (document.form.bandwidth_price.value -0) + (document.form.youtube_price.value -0);
}
</script>
	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="fa iconfa-dashboard"></i></div>
        <div class="pagetitle">
            <h1>Queues Client</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Client Informations</h5>
				</div>
				<form class="stdform" method="post" action="ClientAddQuery" name="form">
					<input type="hidden" name="breseller" value="1" />
					<input type="hidden" name="com_id" value="<?php echo $com_id;?>"/>
					<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>" />
					<input type="hidden" name="entry_by" value="<?php echo $e_id;?>" />
					<input type="hidden" name="entry_date" value="<?php echo date('Y-m-d', time());?>" />
						<input type="hidden" name="entry_time" value="<?php echo date('H:i:s', time());?>" />
					<div class="modal-body">
								<p>
									<label>Client ID</label>
									<span class="field"><input type="text" name="c_id" readonly class="input-xxlarge" value="<?php echo $c_id;?>" /></span>
								</p>
								<p>
									<label class="control-label" for="passid">Login Password*</label>
									<div class="controls"><input type="text" name="passid" class="input-xxlarge" size="12" value="123456" required="" /></div>
								</p>
								<p>
									<label>Zone Name*</label>
									<select name="z_id" class="chzn-select"  style="width:540px;" required="" onChange="getRoutePoint(this.value)">		
										<?php 
											$queryd="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
											$resultd=mysql_query($queryd);
										while ($rowd=mysql_fetch_array($resultd)) { ?>			
											<option value=<?php echo $rowd['z_id'];?> <?php if ($rowd['z_id'] == $z_id) echo 'selected="selected"';?> ><?php echo $rowd['z_name'];?> (<?php echo $rowd['z_bn_name'];?>)</option>		
										<?php } ?>
									</select>
								</p>
								<p>
									<label>Box*</label>
									<div id="Pointdiv1">
									<select name="box_id" class="chzn-select"  style="width:540px;" required="">								
										<?php 
											$querydd="SELECT * FROM box WHERE z_id = '$z_id'";
											$resultdd=mysql_query($querydd);
										while ($rowdd=mysql_fetch_array($resultdd)) { ?>			
											<option value=<?php echo $rowdd['box_id'];?> <?php if ($rowdd['box_id'] == $box_id) echo 'selected="selected"';?> ><?php echo $rowdd['b_name'];?> (<?php echo $rowdd['location'];?> - <?php echo $rowdd['b_port'];?>)</option>		
										<?php } ?>
									</select>
									</div>
								</p>
								<p>
									<label>Client Name*</label>
									<span class="field"><input type="text" name="c_name" id="" class="input-xxlarge" value="<?php echo $c_name;?>" /></span>
								</p>
								<p>
									<label>Bandwidth D/U*</label>
									<span class="field"><input type="text" name="raw_download" readonly style="width: 135px;" placeholder="Download" class="input-large" value="<?php echo $raw_download;?>" />&nbsp;&nbsp;<input type="text" name="raw_upload" readonly style="width: 135px;" placeholder="Upload" class="input-large" value="<?php echo $raw_upload;?>"/>&nbsp;&nbsp;<input type="text" name="youtube_bandwidth" style="width: 135px;" readonly placeholder="" class="input-large" value="0" />&nbsp;<input type="text" name="total_bandwidth" readonly placeholder="Total" style="width: 60px;" value="<?php echo $raw_download+$raw_upload;?>" /> <b>mb</b></span>
								</p>
								<p>
									<label>Price*</label>
									<span class="field"><input type="text" required="" name="bandwidth_price" placeholder="Raw Price" id="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="youtube_price" required="" value='0' placeholder="YouTube Price" id="" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="bill_amount" readonly placeholder="Total" id="" style="width: 60px;" onChange="updatesum()" /> <b>TK</b></span>
								</p>
								<p>
									<label>IP Address</label>
									<span class="field"><input type="text" readonly class="input-xxlarge" name="ip" value="<?php echo $ip;?>" /></span>
								</p>
								<p>
									<label>MAC Address</label>
									<span class="field"><input type="text" readonly class="input-xxlarge" name="mac" value="<?php echo $mac;?>" /></span>
								</p>
								<p>
									<label>This Month Bill Calculation*</label>
										<span class="formwrapper">
										<input type="radio" name="calculation" value="Auto"> Auto &nbsp; &nbsp;
										<input type="radio" name="calculation" value="Manual" checked="checked"> Manual &nbsp; &nbsp;
									</span>
								</p>
								<p>
									<label>Payment Deadline</label>
									<span class="field"><input type="text" name="payment_deadline" placeholder="Date in every month like: 07" id="" class="input-xxlarge" value="<?php echo $payment_deadline;?>"></span>
								</p>
								<p>
									<label>Billing Date</label>
									<span class="field">
										<select data-placeholder="Choose Bill Date" name="b_date" class="chzn-select" style="width:540px;"/>
											<option value="">Choose Bill Date</option>
											<option value="01">01</option>
											<option value="10">10</option>
											<option value="20">20</option>
										</select>
									</span>
								</p>
								<p>
									<label>Payment Method*</label>
									<span class="field">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:540px;" required=""/>
											<option value="Cash">Cash</option>
											<option value="Home Cash">Cash from Home</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
										</select>
									</span>
								</p>
								<p>
									<label>Signup Fee</label>
									<span class="field"><input type="text" name="signup_fee" placeholder="Ex: 1200" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Permanent Discount</label>
									<span class="field"><input type="text" name="discount" placeholder="Ex: 1200" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Contact No</label>
									<span class="field"><input type="text" name="cell" placeholder="Cell No" id="" value="88" class="input-xxlarge" required=""/></span>
								</p>
								<p>
									<label>Alternative No 1</label>
									<span class="field"><input type="text" name="cell1" placeholder="Cell No" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Send Login Info by SMS</label>
										<span class="formwrapper">
										<input type="radio" name="sentsms" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
										<input type="radio" name="sentsms" value="No"> No &nbsp; &nbsp;
									</span>
								</p>
								<p>
									<label>Address</label>
									<span class="field"><textarea type="text" name="address" id="" class="input-xxlarge"/></textarea></span>
								</p>
								<p>
									<label>Thana</label>
										<span class="field"><input type="text" name="thana" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Start Date</label>
									<span class="field"><input type="text" name="join_date" id="" class="input-xxlarge datepicker" value="<?php echo date("Y-m-d");?>" /></span>
								</p>
								<p>
									<label>Occupation</label>
									<span class="field"><input type="text" name="occupation" placeholder="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Email</label>
									<span class="field"><input type="text" name="email" id="" placeholder="Ex: abcd@domain.com" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>National ID</label>
									<span class="field"><input type="text" name="nid" placeholder="Ex: 123456789" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Previous ISP</label>
									<span class="field"><input type="text" name="previous_isp" id="" placeholder="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Type of Client</label>
										<span class="field">
											<select class="chzn-select" name="con_type" style="width:540px;">
												<option  value="Home" <?php if ('Home' == $con_type) echo 'selected="selected"';?>>Home</option>
												<option  value="Corporate" <?php if ('Corporate' == $con_type) echo 'selected="selected"';?>>Corporate</option>
												<option  value="Others" <?php if ('Others' == $con_type) echo 'selected="selected"';?>>Others</option>
											</select>
										</span>	
										
								</p>
								<p>
									<label>Type of Connectivity</label>
										<span class="field">
											<select class="chzn-select" name="connectivity_type" style="width:540px;">
												<option  value="Shared" <?php if ('Shared' == $connectivity_type) echo 'selected="selected"';?>>Shared</option>
												<option  value="Dedicated" <?php if ('Dedicated' == $connectivity_type) echo 'selected="selected"';?>>Dedicated</option>
											</select>
										</span>	
								</p>
								
								<p>
									<label>Connection Mode</label>
									<span class="field"><input type="text" class="input-xxlarge" name="con_sts" readonly value="<?php echo $con_sts;?>" /></span>
								</p>
								<p>
									<label>Cable Type</label>
									<span class="field">
										<select class="chzn-select" name="cable_type" style="width:540px;">
											<option>Choose Cable Type</option>
											<option  value="UTP">UTP</option>
											<option  value="FIBER">FIBER</option>
										</select>
									</span>
								</p>
								<p>
									<label>Require Cable</label>
									<span class="field"><input type="text" name="req_cable" placeholder="Ex: 200ft" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Note</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xxlarge"/></textarea></span>
								</p>
					</div>             
						<div class="modal-footer">
							<button type="reset" class="btn">Reset</button>
							<button class="btn btn-primary" type="submit">Submit</button>
						</div>

				</form> <!-- END OF DEFAULT WIZARD -->
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