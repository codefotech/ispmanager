<?php
$titel = "Others Bill";
$SignupBill = 'active';
include('include/hader.php');
include("conn/connection.php");
$way = isset($_GET['way']) ? $_GET['way'] : '';
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');
$e_id = $_SESSION['SESS_EMP_ID'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SignupBill' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '25' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

if($user_type == 'billing') {
$queryr = mysql_query("SELECT c.c_id, c.com_id, c.c_name, c.cell FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE z.emp_id = '$e_id' ORDER BY c_name");
}
else{
$queryr = mysql_query("SELECT c_id, c.com_id, c_name, cell FROM clients ORDER BY c_name");
}

if($way == 'client' && in_array(213, $access_arry)){
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		</div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Others Bill From Clients</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New Bill</h5>
				</div>
				<form id="form2" class="stdform" method="post" action="SignupBillSave">
				<input type="hidden" name="way" value="<?php echo $way;?>" />
				<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
				<input type="hidden" name="pay_date" value="<?php echo date("Y-m-d");?>" />
					<div class="modal-body">
						<p>
							<label>Client ID*</label>
							<span class="field">
								<select data-placeholder="Choose Client" name="c_id" class="chzn-select" style="width:30%;" required="">
									<option value=""></option>
									<?php while ($row2=mysql_fetch_array($queryr)) { ?>
									<option value="<?php echo $row2['c_id']?>"><?php echo $row2['com_id']; ?> | <?php echo $row2['c_name']; ?> | <?php echo $row2['c_id']; ?> | <?php echo $row2['cell']; ?></option>
									<?php } ?>
								</select>
							</span>
						</p>
						<p>
							<label>Bill Type*</label>
							<span class="field">
								<select data-placeholder="Bill Type" name="bill_type" style="width:30%;" class="chzn-select" required="">
									<option value=""></option>
									<?php 
									$query11="SELECT bill_type, type FROM bills_type ORDER BY bill_type ASC";
									$result11 = mysql_query($query11);
									while ($row11=mysql_fetch_array($result11)) { ?>
									<option value="<?php echo $row11['bill_type']?>"><?php echo $row11['type']; ?></option>
									<?php } ?>
								</select>
							</span>
						</p>
						<p>
							<label>Amount*</label>
							<span class="field">
								<input type="text" name="" id="" style="width:15px; color:#2e3e4e; font-weight: bold;font-size: 18px;text-align: right;border-right: 0px;" value='৳' readonly /><input type="text" name="amount" id="" style="width: 10%;font-size: 17px;font-weight: bold;color: #00000085;" required="" placeholder="Amount" />
								<select data-placeholder="Status" name="bill_sts" style="width:10%;font-size: 14px;font-weight: bold;color: red;" required="" onChange="getRoutePoint(this.value)"> 
									<option value="Unpaid">UNPAID</option>
									<option value="Paid">PAID</option>
								</select>
							</span>
						</p>
						<div id="Pointdiv"></div>
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="bill_dsc" style="width:40%;" id="" placeholder="Write Your Bill Note" class="input-xlarge" /></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php } 

if($way == 'extra' && in_array(214, $access_arry)){
?>
<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		</div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Others Collection From Outside</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Extra Income</h5>
				</div>
				<form id="form2" class="stdform" method="post" action="SignupBillSave">
					<input type="hidden" name="way" value="<?php echo $way;?>" />
					<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
					<input type="hidden" name="pay_date" value="<?php echo date("Y-m-d");?>" />
					<div class="modal-body">
						<p>
							<label>Name*</label>
							<span class="field"><input type="text" placeholder="Write the name" name="be_name" style="width:19.2%;" required=""/></span>
						</p>
						<p>
							<label>Cell No</label>
							<span class="field"><input type="text" placeholder="Mobile No" name="cell" style="width:19.2%;"/></span>
						</p>
						<p>
							<label>Bill Type*</label>
							<span class="field">
								<select data-placeholder="Bill Type" name="bill_type" style="width:20%;" class="chzn-select" required="">
									<option value=""></option>
									<?php 
									$query11="SELECT bill_type, type FROM bills_type ORDER BY bill_type ASC";
									$result11 = mysql_query($query11);
									while ($row11=mysql_fetch_array($result11)) { ?>
									<option value="<?php echo $row11['bill_type']?>"><?php echo $row11['type']; ?></option>
									<?php } ?>
								</select>
							</span>
						</p>
						<p>
							<label>Bank*</label>
								<span class="field">
									<select placeholder="Type Of bank" name="bank" style="width:20%;" required="">
										<option value=""></option>
										<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
										<option value="<?php echo $rowBank['id'] ?>"><?php echo $rowBank['bank_name'];?> (<?php echo $rowBank['emp_id']; ?>)</option>
										<?php } ?>
									</select>
								</span>
						</p>
						<p>
							<label>Amount*</label>
							<span class="field">
								<input type="text" name="" id="" style="width:15px; color:#2e3e4e; font-weight: bold;font-size: 18px;text-align: right;border-right: 0px;" value='৳' readonly /><input type="text" name="amount" id="" style="width: 9%;font-size: 17px;font-weight: bold;color: #00000085;" required="" placeholder="Amount" />
								<select data-placeholder="Status" name="bill_sts" style="width:8%;font-size: 14px;font-weight: bold;color: red;" required=""> 
									<option value="Paid">PAID</option>
								</select>
							</span>
						</p>
						<p>
							<label>Method*</label>
							<span class="field">
								<select class="chzn-select" name="method" style="width:20%;" required="" onChange="getRoutePoint22(this.value)"> 
									<option value="Cash">CASH</option>
									<option value="Bank">BANK</option>
									<option value="Online">ONLINE</option>
								</select>
							</span>
						</p>
						<div id="Pointdiv1"></div>
						<p>
							<label style="padding-top: 0;">Send Receipt SMS?</label>
							<span class="field">
								<input type="radio" name="sentsms" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
								<input type="radio" name="sentsms" style="position: relative;margin-right: 3px;width: 18px;height: 18px;display: inline-block;vertical-align: middle;padding: 0px;margin: -2px 0px 0px 0px;min-height: 20px;" value="No"> No
							</span>
						</p>
						<div id="Pointdiv"></div>
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="bill_dsc" style="width:30%;" id="" placeholder="Write Your Bill Note" class="input-large" /></textarea></span>
						</p>
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
}}
else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php }
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
	

	function getRoutePoint(afdId) {		
		
		var strURL="others-bill-sts.php?bill_sts="+afdId;
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
		function getRoutePoint22(afdId1) {
		var strURL="others-bill-method.php?mathod="+afdId1;
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