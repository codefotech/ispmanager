<?php
$titel = "Product In Edite";
$Store = 'active';
include('include/hader.php');
$storeid = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql10 = ("SELECT i.id, i.purchase_date, i.voucher_no, i.purchase_by, i.vendor, i.p_sts, i.p_sl_no, i.p_id, i.brand, i.fiber_id, i.fiberstart, i.fiberend, i.fibertotal, i.price, i.rimarks, a.e_name AS entry_by, i.entry_time FROM store_in AS i
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by
													WHERE i.id = '$storeid' AND i.sts = '0'");
		
$query10 = mysql_query($sql10);
$row10 = mysql_fetch_assoc($query10);
		$id= $row10['id'];
		$purchase_date= $row10['purchase_date'];
		$voucher_no= $row10['voucher_no'];
		$purchase_by= $row10['purchase_by'];
		$vendor= $row10['vendor'];
		$p_sts= $row10['p_sts'];
		$p_sl_no= $row10['p_sl_no'];
		$p_id= $row10['p_id'];
		$brand= $row10['brand'];
		$fiber_id= $row10['fiber_id'];
		$fiberstart= $row10['fiberstart'];
		$fiberend= $row10['fiberend'];
		$fibertotal= $row10['fibertotal'];
		$price= $row10['price'];
		$rimarks= $row10['rimarks'];
		$entry_by= $row10['entry_by'];
		$entry_time= $row10['entry_time'];

$query="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e
			LEFT JOIN department_info AS d
			ON d.dept_id = e.dept_id
			WHERE e.sts = '0' ORDER BY e.e_name ASC";
$result=mysql_query($query);

$query13="SELECT id, v_name FROM vendor WHERE sts='0' ORDER BY id ASC";
$result13=mysql_query($query13);

$query2="SELECT id, pro_name, pro_details FROM product WHERE sts='0' ORDER BY pro_name ASC";
$result2=mysql_query($query2);

?>
<script type="text/javascript"><!--
function updatesum() {
document.form.fibertotal.value = (document.form.fiberend.value -0) - (document.form.fiberstart.value -0);
}
//--></script>

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
				<button type="reset" class="btn">Reset</button>
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->


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
				<button type="reset" class="btn">Reset</button>
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal2-->

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Store"><i class="iconfa-arrow-left"></i> Back</a>
			<div class="btn-group">
                <button data-toggle="dropdown" class="btn dropdown-toggle"> ADD<span class="caret"></span></button>
                <ul class="dropdown-menu">
					<li><a class="btn" href="#myModal" data-toggle="modal">Vendor</a></li>
                    <li><a class="btn" href="#myModal2" data-toggle="modal">Product</a></li>
                 </ul>
            </div>
			<a class="btn" href="StoreInDetails">Purchase Details</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Product In (Purchase)</h1>
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
			<strong>Success!!</strong> New Product Successfully Inserted.
		</div><!--alert-->
	<?php }?>
	
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Purchase Product</h5>
				</div>
					<form id="form" class="stdform"  name="form" method="post" action="ProductInEditeQuery" enctype="multipart/form-data">
						<input type="hidden" name="edite_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="edite_time" value="<?php echo date("Y-m-d h:i:s");?>" />
						<input type="hidden" name="id" value="<?php echo $id; ?>" />
							<div class="modal-body">
								<p>
									<label>Purchase Date*</label>
									<span class="field"><input type="text" name="" readonly id="" class="input-xxlarge" value="<?php echo $purchase_date;?>"></span>
								</p>
								<p>
									<label>Voucher No*</label>
									<span class="field"><input type="text" name="voucher_no" required="" id="" class="input-xxlarge" value="<?php echo $voucher_no;?>"></span>
								</p>
								<p>	
									<label>Purchaser*</label>
									<select data-placeholder="" name="purchase_by" class="chzn-select" required="" style="width:540px;" >
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row['e_id']?>" <?php if ($row['e_id'] == $purchase_by) echo 'selected="selected"';?>><?php echo $row['e_id']; ?> - <?php echo $row['e_name']; ?> (<?php echo $row['dept_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>	
									<label>Vendor*</label>
									<span class="field">
										<select data-placeholder="Choose a Vendor" name="vendor" class="chzn-select"  style="width:540px;" >
											<option value=""></option>
												<?php while ($row13=mysql_fetch_array($result13)) { ?>
											<option value="<?php echo $row13['id']?>" <?php if ($row13['id'] == $vendor) echo 'selected="selected"';?>><?php echo $row13['v_name']; ?></option>
												<?php } ?>
										</select>
									</span>	
								</p>
								<p>
									<label>Product Status*</label>
										<span class="field">
											<select class="chzn-select" name="p_sts" style="width:540px;" >
												<option value="Brand New" <?php if ('Brand New' == $p_sts) echo 'selected="selected"';?>>Brand New</option>
												<option value="Replaced" <?php if ('Replaced' == $p_sts) echo 'selected="selected"';?>>Replaced</option>
												<option value="Old" <?php if ('Old' == $p_sts) echo 'selected="selected"';?>>Old</option>
												<option value="Repaird" <?php if ('Repaird' == $p_sts) echo 'selected="selected"';?>>Repaird</option>
											</select>
										</span>
								</p>
								<p>
									<label>Product Serial No*</label>
									<span class="field"><input type="text" name="p_sl_no" id="" class="input-xxlarge" value="<?php echo $p_sl_no;?>"></span>
								</p>
								<p>	
									<label>Product Name*</label>
									<span class="field">
										<select data-placeholder="Choose a Product" name="p_id" class="chzn-select"  style="width:540px;" />
											<option value=""></option>
												<?php while ($row1=mysql_fetch_array($result2)) { ?>
											<option value="<?php echo $row1['id']?>" <?php if ($row1['id'] == $p_id) echo 'selected="selected"';?>><?php echo $row1['pro_name']; ?></option>
												<?php } ?>
										</select>
									</span>	
								</p>
								
								<p>
									<label>Brand Name*</label>
									<span class="field"><input type="text" name="brand" id="" class="input-xxlarge" value="<?php echo $brand;?>"/></span>
								</p>
								<p>
									<label>Fiber ID</label>
									<span class="field"><input type="text" name="fiber_id" id="" class="input-xxlarge" value="<?php echo $fiber_id;?>"/></span>
								</p>
								<p>
									<label>Fiber Start Meter</label>
									<span class="field"><input type="text" name="fiberstart" id="" class="input-xxlarge" value="<?php echo $fiberstart;?>"/></span>
								</p>
								<p>
									<label>Fiber End Meter</label>
									<span class="field"><input type="text" name="fiberend" id="" class="input-xxlarge" value="<?php echo $fiberend;?>" onChange="updatesum()" /></span>
								</p>
								<p>
									<label>Total Meter</label>
									<span class="field"><input type="text" name="fibertotal" id="" readonly class="input-xxlarge" value="<?php echo $fibertotal;?>" onChange="updatesum()"  /></span>
								</p>
								<p>
									<label>Quantity*</label>
									<span class="field"><input type="text" name="quantity" id="" required="" readonly value="1" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Price*</label>
									<span class="field"><input type="text" name="price" placeholder="500" required="" id="" class="input-xxlarge" value="<?php echo $price;?>" /></span>
								</p>
								<p>
									<label>Remarks</label>
									<span class="field"><textarea type="text" name="rimarks" id="" class="input-xxlarge" /><?php echo $rimarks;?></textarea></span>
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