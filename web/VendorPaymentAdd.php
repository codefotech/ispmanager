<?php
$titel = "Vendor Payment Add";
$VendorPayment = 'active';
include('include/hader.php');
extract($_POST);


//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'VendorPayment' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$e_id = $_SESSION['SESS_EMP_ID'];

if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}
	$vendorrr = mysql_query("SELECT id, v_name, cell, location FROM vendor WHERE sts = 0 ORDER BY v_name");

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="VendorPayment"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Vendor Payment Add</h1>
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
					<h5>Add Vendor Payment</h5>
				</div>
					<form id="form" class="stdform" method="post" action="VendorPaymentAddSave">
						<input type="hidden" value="<?php echo $e_id; ?>" name="ent_by" />
						<input type="hidden" name="payment_date" value="<?php echo date("Y-m-d");?>" />
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
									<label>Bank*</label>
									<select data-placeholder="Select a Bank" name="bank" class="chzn-select"  style="width:30% !important;" required="">
													<?php while ($row=mysql_fetch_array($Bank)) { ?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['bank_name'];?> <?php echo $row['emp_id']; ?></option>
													<?php } ?>
									</select>
								</p>
								<p>
									<label>Amount*</label>
									<span class="field"><input type="text" name="amount" placeholder="Amount Of TK" required="" style="width: 100px;" /><b><input type="text" readonly value="৳" style="width: 10px;" /></b></span>
								</p>
								<p>
									<label>Mathod*</label>
									<span class="field">
										<select class="chzn-select" name="mathod" style="width:30%;" required="" onChange="getRoutePoint(this.value)"> 
											<option value="Cash">CASH</option>
											<option value="Bank">BANK</option>
											<option value="Online">ONLINE</option>
										</select>
									</span>
								</p>
								<div id="Pointdiv"></div>
								<p>
									<label>Note</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xxlarge" /></textarea></span>
								</p>
							</div>
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
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
		
		var strURL="ex_mathod.php?mathod="+afdId;
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