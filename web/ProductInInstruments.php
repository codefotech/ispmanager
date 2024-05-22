<?php
$titel = "Product In";
$Store = 'active';
include('include/hader.php');
extract($_POST);
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------
ini_alter('date.timezone','Asia/Almaty');
$y = date("y");
$m = date("m");
$dss = date("ymj");
$datdd = date('yn', time());
$datccd = rand(0,99);

$respy = mysql_query("SELECT `id` FROM `store_in_instruments` ORDER BY id DESC LIMIT 1");
$rowspy = mysql_fetch_array($respy);
	if($rowspy['id'] == ''){
			$dat = $datdd.'110';
		}
		else{
			$new = $rowspy['id'] + 110;
			$dat = $datdd.$new;
		}
		
$query="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e
			LEFT JOIN department_info AS d
			ON d.dept_id = e.dept_id
			WHERE e.sts = '0' ORDER BY e.e_name ASC";
$result=mysql_query($query);

if($user_type == 'admin' || $user_type == 'superadmin'){
$querypp="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e
			LEFT JOIN department_info AS d
			ON d.dept_id = e.dept_id
			WHERE e.sts = '0' ORDER BY e.e_name ASC";
}
else{
$querypp="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e
			LEFT JOIN department_info AS d
			ON d.dept_id = e.dept_id
			WHERE e.sts = '0' AND e.e_id = '$e_id' ORDER BY e.e_name ASC";
}
$resultpp=mysql_query($querypp);

$query1="SELECT id, v_name, location FROM vendor WHERE sts='0' ORDER BY v_name ASC";
$result1=mysql_query($query1);

$query2="SELECT id, pro_name, pro_details FROM product WHERE sts='0' ORDER BY pro_name ASC";
$result2=mysql_query($query2);

if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}


?>

<?php if(in_array(188, $access_arry)){ ?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="vendor" />
	<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
	<input type="hidden" name="enty_time" value="<?php echo date("Y-m-d h:i:s");?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Vendor Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Name:</div>
						<div class="col-2"><input type="text" name="v_name" id="" placeholder="Ex: Full Name" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Location:</div>
						<div class="col-2"><input type="text" name="location" id="" placeholder="Ex: Vendor Address" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Cell:</div>
						<div class="col-2"><input type="text" name="cell" id="" placeholder="Ex: 01712345678" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Email:</div>
						<div class="col-2"><input type="text" name="email" id="" placeholder="Ex: Email Address" class="input-large"/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Join Date:</div>
						<div class="col-2"><input type="text" name="join_date" id="" placeholder="" class="input-large datepicker" value="<?php echo date("Y-m-d");?>"/></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->

<?php } if(in_array(187, $access_arry)){?>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="product" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Product Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Product Name:</div>
						<div class="col-2"><input type="text" name="pro_name" id="" placeholder="Ex: Switch, Router etc" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Product Details:</div>
						<div class="col-2"><input type="text" name="pro_details" id="" placeholder="" class="input-large" required=""/></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal2-->
<?php } ?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<?php if(in_array(187, $access_arry) || in_array(188, $access_arry)){?>
			<div class="btn-group">
                <button data-toggle="dropdown" class="btn dropdown-toggle ownbtn5"> ADD<span class="caret"></span></button>
                <ul class="dropdown-menu">
				<?php if(in_array(188, $access_arry)){?>
					<li><a class="btn" href="#myModal" data-toggle="modal">Vendor</a></li>
				<?php } if(in_array(187, $access_arry)){?>
                    <li><a class="btn" href="#myModal2" data-toggle="modal">Product</a></li>
				<?php } ?>
                 </ul>
            </div>
			<?php } if(in_array(189, $access_arry)){?>
			<a class="btn ownbtn8" href="InstrumentsStoreInDetails">Purchase Details</a>
			<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Instruments In</h1>
        </div>
    </div><!--pageheader-->
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
	<?php } if($sts == 'InstrumentsIn') {?>
			<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Data Successfully Inserted In Store.
		</div><!--alert-->
	<?php } if(in_array(183, $access_arry)){?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Purchase Instruments</h5>
				</div>
					<form id="form" class="stdform"  name="form" method="post" action="ProductInInstrumentsQuery" enctype="multipart/form-data">
						<input type="hidden" name="typ" value="InstrumentsIn" />
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("Y-m-d h:i:s");?>" />
						<input type="hidden" name="auto_voucher_no" value="<?php echo $dat;?>" />
							<div class="modal-body" style="min-height: 350px;">
							<div class="row">
								<div style="padding-left: 15px; width: 100%;">
									<div style="float: left;width: 45%;">
										<table class="table table-bordered table-invoice">
											<tr>
												<td class="width30" style="text-align: right;font-weight: bold;">Vendor*</td>
												<td class="width70">
													<select data-placeholder="Choose a Vendor" class="chzn-select" name="vendor" style="font-weight: bold;" required="">
														<option value=""></option>
															<?php while ($row1=mysql_fetch_array($result1)) { ?>
														<option value="<?php echo $row1['id']?>"><?php echo $row1['v_name']; if($row1['location'] != ''){echo ' - '.$row1['location'];}?></option>
															<?php } ?>
													</select>
												</td>
											</tr>
											<tr>
												<td style="text-align: right;font-weight: bold;">Add To Vendor Bill?</td>
												<td>
													<select class="chzn-select" name="v_sts" style="width:50%;float: left;text-align: center;font-size: 16px;font-weight: bold;" required="" onChange="getRoutePointVen(this.value)"> 
														<option value="Yes">Yes</option>
														<option value="No" selected="selected">No</option>
													</select>
												</td>
											</tr>									
										</table>
										<div id="Pointdiv11" style="margin-top: 2px;"></div>
									</div>
									
									<div style="float: right;width: 45%;margin-right: 2%;">
										<table class="table table-bordered table-invoice">
											<tr>
												<td class="width30" style="text-align: right;font-weight: bold;">Purchaser*</td>
												<td class="width70">
													<select placeholder="" name="purchase_by" style="font-weight: bold;" required="">
														<option value=""></option>
															<?php while ($rowss=mysql_fetch_array($resultpp)) { ?>
														<option value="<?php echo $rowss['e_id'];?>"<?php if ($rowss['e_id'] == $e_id) echo 'selected="selected"';?>><?php echo $rowss['e_name'];?> - <?php echo $rowss['e_id'];?> (<?php echo $rowss['dept_name'];?>)</option>
															<?php } ?>
													</select>
												</td>
											</tr>
											<tr>
												<td style="text-align: right;font-weight: bold;">Add To Expense?</td>
												<td>
													<select class="chzn-select" name="e_sts" style="width:50%;float: left;text-align: center;font-size: 16px;font-weight: bold;" required="" onChange="getRoutePointExp(this.value)"> 
														<option value="Yes">Yes</option>
														<option value="No" selected="selected">No</option>
													</select>
												</td>
											</tr>
										</table>
										<div id="Pointdiv111" style="margin-top: 2px;"></div>
									</div>
								</div>
							</div>
							
							<br/><br/>
										<table style="width:180px;font-size: 17px;height: 30px;margin-bottom: 3px;border-bottom: 5px solid #ff000021;float: left;">
											<tr>
												<td style="width: 55px;"><input type="text" class="" name="voucher_no" id="voucher_no" required="" placeholder="VOUCHER NO" style="font-weight: bold;width: 135px;font-size: 20px;border-bottom: 3px solid #ff0a0ac4;border-top: 0px solid transparent;border-right: 0px solid transparent;border-left: 0px solid transparent;border-radius: 10px;margin-bottom: 5px;padding: 5px 5px 5px 10px;color: #00000087;" /></td>
												<td style="width: 10px;"><a class="btn ownbtn11" title="Set Auto Voucher No" onclick="showValue(<?php echo $dat;?>)" style="border: 0px;font-size: 20px;padding: 0px;margin: 0px;color: #0866c6b0;background: transparent;"><i class="iconfa-retweet"></i></a></td>
											</tr>										
										</table>
										<table style="width:150px;font-size: 17px;height: 30px;margin-bottom: 3px;border-bottom: 5px solid #0866c63b;float: right;">
											<tr>
												<td><input type="text" class="" name="auto_voucher_no" readonly required="" placeholder="#" title="Voucher No (Auto)" style="font-weight: bold;width: 95%;font-size: 20px;border-bottom: 3px solid #0866c68c;border-top: 0px solid transparent;border-right: 0px solid transparent;border-left: 0px solid transparent;border-radius: 10px;margin-bottom: 5px;padding: 5px 5px 5px 5px;color: #0000004f;text-align: center;" value="<?php echo $dat;?>" /></td>
											</tr>										
										</table>
										<table class="table table-bordered responsive nnew200">
												 <thead>
													<tr>	
														<th style="width: 2%;padding:5px 3px 5px 4px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;"><input id="check_all2" class="formcontrol" type="checkbox"/></th>
														<th style="width: 1%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">S/L</th>
														<th style="width: 15%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">PRODUCT</th>
														<th style="width: 10%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">BRAND</th>
														<th style="width: 12%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">STATUS</th>
														<th style="width: 4%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">UNIT</th>
														<th style="width: 4%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">QUANTITY</th>
														<th style="width: 10%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">S/L Number</th>
														<th style="width: 4%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">PRICE</th>
														<th style="width: 4%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">VAT(%)</th>
														<th style="width: 10%;padding:5px; border-top: 2px solid #ddd;background: transparent; font-size: 14px;font-weight: normal;color: #0a6bce;border-left: 0px solid;border-bottom: 3px solid #ddd;text-align: center;">SUB-TOTAL</th>
													</tr>
												 </thead>
												<tbody>
												<tr class='gradeX'>
													<td class="center"><input class="case2" style="text-align: center;" type="checkbox"/></td>
													<td class="center" style="font-size: 17px;font-weight: bold;padding: 10px 0;color: red;">1.</td>
																		<input type="hidden" data-type="productCode" name="itemNo[]" required="" id="itemNo_1" class="changesNo form-control autocomplete_txt" autocomplete="off">
													<td class="center" ><input type="text" style="width: 92%;" data-type="productName" name="productName[]" required="" placeholder="Like: Router, Onu" id="itemName_1" class="changesNo form-control autocomplete_txt" autocomplete="off"></td>
													<td class="center" ><input type="text" style="width: 88%;" name="brand[]" placeholder="Brand Name" required="" id="brand_1" class="changesNo form-control" autocomplete="off"></td>
													<td class="center" >
														<select class="" style="width: 92%;text-align: center;" name="psts[]" id="psts_1" required="" >
															<option value="Brand New">Brand New</option>
															<option value="Replaced">Replaced</option>
															<option value="Old">Old</option>
															<option value="Repaird">Repaird</option>
														</select>
													</td>
													<td class="center"><input type="text" style="width: 70%;font-weight: bold;text-align: center;" data-type="productUnit" class="" name="unit[]" id="unit_1" class="changesNo form-control" autocomplete="off" readonly /></td>
													<td class="center"><input type="text" style="width: 80%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="quantity[]" class="changesNo form-control autocomplete_txt qqqq" id="quantity_1" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>
													<td class="center" id="slno1" style="padding: 0.2% 0% 0.1% 0%;font-size: 13px;vertical-align: middle;font-weight: bold;color: #ff00008a;">SELECT PRODUCT</td>
															<input type="hidden" data-type="qtystsss" name="qtysts[]" id="qtysts_1" required="" class="changesNo form-control autocomplete_txt" autocomplete="off"/>
													<td class="center"><input type="text" style="width: 80%;font-size: 14px;font-weight: 700;text-align: center;" required="" name="uniteprice[]" class="changesNo form-control autocomplete_txt" id="uniteprice_1" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>
													<td class="center"><input type="text" style="width: 70%;font-size: 14px;font-weight: 700;text-align: center;" data-type="productVat" required="" name="vat[]" class="changesNo form-control" id="vat_1" placeholder="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/></td>
													<td class="center"><input type="text" style="width: 92%;font-size: 16px;font-weight: 700;text-align: center;" name="price[]" id="price_1" readonly class="totalLinePrice" required="" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>
												</tr>
											</tbody>
										</table>
										<table class="table responsive" style="border: 0;">
											<tr>
												<td style="width: 15%;border-bottom: 1px solid #ddd;">
													<button class="btn-danger delete2" style="font-size: 30px;" type="button"> - </button>
													<button class="btn-success addmorenew" style="font-size: 25px;border-radius: 3px;border-color: #86d628;" type="button"> + </button>
												</td>
												<td style="width: 55%;border-bottom: 1px solid #ddd;"><textarea type="text" name="rimarks" style="width: 60%; height: 25px;" id="" placeholder="Remarks (If Any)" class="input-xxlarge" /></textarea></td>
												<td style="width: 10%;border-bottom: 1px solid #ddd;text-align: right;vertical-align: middle;font-size: 20px;font-weight: bold;color: #58666e;font-family: 'Noto Serif',serif;">TOTAL</td>
												<td style="width: 20%;border-bottom: 1px solid #ddd;padding: 8px 0px 8px 30px;text-align: right;"><input type="text" style="width: 25px;font-weight: bold;font-size: 20px;border-radius: 5px 0 0 6px;border-right: 0;color: #58666e;height: 30px;text-align: center;" readonly value="৳"/><input type="text" style="width: 50%;font-weight: bold;font-size: 22px;border-radius: 0 5px 5px 0px;height: 30px;color: #d0430cc2;padding: 4px 4px 4px 10px;" name="total_price" required="" readonly id="totalAftertax" value="0.00" placeholder="" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/></td>
											</tr>
											<input type="hidden" style="width: 50%;font-weight: bold;font-size: 18px;color: #58666e;border-radius: 0 5px 5px 0px;" required="" readonly id="subTotal" name="subtotal" placeholder="Subtotal" onkeypress="return IsNumeric(event);" readonly ondrop="return false;" onpaste="return false;"/>
											<input type="hidden" style="width: 50%;font-weight: bold;font-size: 16px;color: #58666e;border-radius: 0 5px 5px 0px;" id="tax" name="discount" placeholder="Discount" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"/>
										</table>
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
<script src="invoice/js/jquery.min.js"></script>
<script src="invoice/js/jquery-ui.min.js"></script>
<script src="invoice/js/auto_ProductInInstruments.js"></script>
<link href="invoice/css/jquery-ui.min.css" rel="stylesheet">
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
  .table-invoice tr td:first-child{
	  font-size: 14px;
  }
</style>
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
	
	function getRoutePointVen(afdId) {		
		
		var strURL="product-in.php?v_billadd="+afdId;
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
	function getRoutePointExp(afdId) {		
		var strURL="product-in.php?exp_add="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv111').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
var showValue = function(val){
    document.getElementById('voucher_no').value = parseInt(val);
}
</script>