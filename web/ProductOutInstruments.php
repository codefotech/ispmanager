<?php
$titel = "Instruments Out";
$Store = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------
	ini_alter('date.timezone','Asia/Almaty');
$result1 = mysql_query("SELECT i.id, i.p_id, p.pro_name, i.inqty, IFNULL(SUM(o.qty), 0) AS outqty, (i.inqty - (IFNULL(o.qty, 0))) AS remainingqty from
						(SELECT id, SUM(quantity) AS inqty, p_id FROM store_in_instruments GROUP BY p_id) AS i
						LEFT JOIN
						(SELECT p_id, SUM(qty) AS qty FROM store_out_instruments GROUP BY p_id) AS o
						ON i.p_id = o.p_id
						LEFT JOIN product AS p
						ON p.id = i.p_id 
						GROUP BY i.p_id ORDER BY p.pro_name");
						
$query2="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e LEFT JOIN department_info AS d ON d.dept_id = e.dept_id WHERE e.sts = '0' ORDER BY e.e_name ASC";
$result2=mysql_query($query2);

$query20="SELECT com_id, c_id, c_name, cell FROM clients WHERE sts = '0' AND mac_user = '0' ORDER BY id ASC";
$result20=mysql_query($query20);
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		<?php if(in_array(190, $access_arry)){?>
			<a class="btn ownbtn6" href="InstrumentsStoreOutDetails">Store Out Details</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Instruments Out</h1>
        </div>
    </div>
		<?php if($sts == 'vendor') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Vendor Successfully Inserted.
		</div><!--alert-->
	<?php } if($sts == 'product') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Instruments Successfully Inserted.
		</div><!--alert-->
	<?php } if($sts == 'Out_Instruments') {?>
			<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> Instrument Successfully Out from Store.
		</div><!--alert-->
	<?php } if(in_array(184, $access_arry)){?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Instruments Out from Store</h5>
				</div>
					<form id="form" class="stdform"  name="form" method="post" action="ProductOutInstrumentsSave" enctype="multipart/form-data">
						<input type="hidden" name="typ" value="main" />
						<input type="hidden" name="out_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="out_date_time" value="<?php echo date("Y-m-d h:i:s");?>" />
							<div class="modal-body">
								<p>
									<label>Out Date</label>
									<span class="field"><input type="text" name="out_date" readonly id="" style="width:70px;" value="<?php echo date("Y-m-d");?>"></span>
								</p>
								<p>	
									<label>Instruments</label>
									<span class="field">
										<select data-placeholder="Choose a Product" name="p_id" class="chzn-select"  style="width: 250px;" required="" onChange="getproductmac(this.value)">
											<option value=""></option>
												<?php while ($row = mysql_fetch_array($result1)) {
													$pro_name = $row['pro_name'];
												if($row['remainingqty'] == '0'){}
												else{
													?>
											<option value="<?php echo $row['p_id']?>"><?php echo $row['pro_name'].' - '.number_format($row['remainingqty'],0); ?></option>
												<?php }} ?>
										</select>
									</span>	
								</p>
								<div id="Pointdiv11"></div>
								<p>	
									<label style="font-weight: bold;">Receiver*</label>
									<select data-placeholder="" name="receive_by" class="chzn-select" required="" style="width:400px;" >
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result2)) { ?>
										<option value="<?php echo $row['e_id']?>"><?php echo $row['e_id']; ?> - <?php echo $row['e_name']; ?> (<?php echo $row['dept_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>	
									<label>Client</label>
									<select data-placeholder="" name="c_id" class="chzn-select" style="width:400px;" >
										<option value=""></option>
										<?php while ($roww=mysql_fetch_array($result20)) { ?>
										<option value="<?php echo $roww['c_id']?>"><?php echo $roww['c_id']; ?> - <?php echo $roww['c_name']; ?> (<?php echo $roww['cell']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>
									<label>Remarks (Optional)</label>
									<span class="field"><textarea type="text" name="rmk" id="" style="width:400px;" placeholder="Write a note......." class="input-xxlarge"/></textarea></span>
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
<?php }} else{ ?>
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
		
		var strURL="ex_mathod_storein.php?mathod="+afdId;
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
	
	function getproductmac(afdId) {		
		
		var strURL="product-out-slno.php?p_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv11').innerHTML=req.responseText;						
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