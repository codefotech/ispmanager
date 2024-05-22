<?php
$titel = "Vendor Bill Add";
$VendorBill = 'active';
include('include/hader.php');
extract($_POST);


//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'VendorBill' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '49' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(206, $access_arry)){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];
$vendorrr = mysql_query("SELECT id, v_name, cell, location FROM vendor WHERE sts = 0 ORDER BY v_name");
$queryww="SELECT id, ex_type FROM expanse_type WHERE status = '0' ORDER BY ex_type ASC";
$resultww=mysql_query($queryww);
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Vendor Bill Add</h1>
        </div>
    </div><!--pageheader-->
	<?php if ($stat == 'done'){?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			 <strong>Successfully!!</strong> Your data successfully Inserted In Your Database.
		</div>
	<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Vendor Bill</h5>
				</div>
					<form id="form" class="stdform" method="post" action="VendorBillAddSave">
						<input type="hidden" value="<?php echo $e_id; ?>" name="ent_by" />
						<input type="hidden" name="bill_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="bill_time" value="<?php echo date("H:i:s");?>" />
							<div class="modal-body">
								<p>	
									<label>Vendor*</label>
									<select data-placeholder="Choose Send By" name="v_id" class="chzn-select"  style="width:30% !important;" required="">
												<option value=""></option>
													<?php while ($row1=mysql_fetch_array($vendorrr)) {?>
												<option value="<?php echo $row1['id']; ?>"><?php echo $row1['v_name'];?> (<?php echo $row1['cell']; ?>) <?php echo $row1['location']; ?></option>
													<?php } ?>
													
									</select>
								</p>
								<p>	
									<label>Purpose*</label>
									<select data-placeholder="Choose a Head" name="purpose" class="chzn-select"  style="width:30%;" required="">
										<option value=""></option>
											<?php while ($rowee=mysql_fetch_array($resultww)) { ?>
										<option value="<?php echo $rowee['id'] ?>"><?php echo $rowee['ex_type']?></option>
											<?php } ?>
									</select>
								</p>
								<p>
									<label>Bill Type*</label>
									<span class="field">
										<select class="chzn-select" name="bill_type" style="width:20%;" required="" onChange="getRoutePoint(this.value)"> 
											<option value="">Choose Bill Type</option>
											<option value="OneTime">One Time</option>
											<option value="Monthly">Monthly</option>
											<option value="Yearly">Yearly</option>
										</select>
									</span>
								</p>
								<div id="Pointdiv"></div>
								<p>
									<label>Amount*</label>
									<span class="field"><input type="text" name="amount" placeholder="Amount Of TK" required="" style="width: 100px;" /><b><input type="text" readonly value="৳" style="width: 10px;" /></b></span>
								</p>
								<p>
									<label>Note</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xlarge" /></textarea></span>
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
<?php } else{?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php
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
	

	function getRoutePoint(afdId) {		
		
		var strURL="Vendor_Bill_type.php?type="+afdId;
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