<?php
$titel = "Cable In";
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
$query="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e
			LEFT JOIN department_info AS d
			ON d.dept_id = e.dept_id
			WHERE e.sts = '0' ORDER BY e.e_name ASC";
$result=mysql_query($query);

$query1="SELECT id, v_name FROM vendor WHERE sts='0' ORDER BY id ASC";
$result1=mysql_query($query1);

$query2="SELECT id, pro_name, pro_details FROM fiber WHERE sts='0' ORDER BY pro_name ASC";
$result2=mysql_query($query2);

?>
<script type="text/javascript"><!--
function updatesum() {
document.form.fibertotal.value = (document.form.fiberend.value -0) - (document.form.fiberstart.value -0);
document.form.price.value = (document.form.fibertotal.value -0) * (document.form.prc.value -0);
}
//--></script>
<?php if(in_array(188, $access_arry)){?>
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
<?php } if(in_array(197, $access_arry)){?>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="fiber" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Cable Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Cable Name:</div>
						<div class="col-2"><input type="text" name="pro_name" id="" placeholder="Ex: 4 Core, CAT-5 etc" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Cable Details:</div>
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
		<?php if(in_array(197, $access_arry) || in_array(188, $access_arry)){?>
			<div class="btn-group">
                <button data-toggle="dropdown" class="btn dropdown-toggle ownbtn5"> ADD<span class="caret"></span></button>
                <ul class="dropdown-menu">
				<?php if(in_array(188, $access_arry)){?>
					<li><a class="btn" href="#myModal" data-toggle="modal">Vendor</a></li>
				<?php } if(in_array(197, $access_arry)){?>
                    <li><a class="btn" href="#myModal2" data-toggle="modal">Cable</a></li>
				<?php } ?>
                 </ul>
            </div>
		<?php } if(in_array(191, $access_arry)){?>
			<a class="btn ownbtn8" href="FiberStoreInDetails">Purchase Details</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Fiber In</h1>
        </div>
    </div><!--pageheader-->
	<?php if($sts == 'vendor') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Vendor Successfully Inserted.
		</div><!--alert-->
	<?php } if($sts == 'fiber') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Cable Name Successfully Inserted.
		</div><!--alert-->
	<?php } if($sts == 'ProductInFiber') {?>
			<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Cable Successfully Inserted In Store.
		</div><!--alert-->
	<?php } if(in_array(185, $access_arry)){?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Purchase Cable</h5>
				</div>
					<form id="form" class="stdform"  name="form" method="post" action="ActionAdd" enctype="multipart/form-data">
						<input type="hidden" name="typ" value="fiberin" />
						<input type="hidden" name="entry_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("Y-m-d h:i:s");?>" />
							<div class="modal-body">
								<p>
									<label>Purchase Date*</label>
									<span class="field"><input type="text" name="purchase_date" readonly id="" class="input-xlarge" value="<?php echo date("Y-m-d");?>" required=""></span>
								</p>
								<p>
									<label>Voucher No*</label>
									<span class="field"><input type="text" name="voucher_no" required="" id="" class="input-xlarge"></span>
								</p>
								<p>	
									<label>Purchaser*</label>
									<select data-placeholder="" name="purchase_by" class="chzn-select" required="" style="width:540px;" >
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value="<?php echo $row['e_id']?>"><?php echo $row['e_id']; ?> - <?php echo $row['e_name']; ?> (<?php echo $row['dept_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>	
									<label>Vendor*</label>
									<span class="field">
									<select data-placeholder="Choose a Vendor" name="vendor" class="chzn-select"  style="width:487.5px;" required="">
										<option value=""></option>
											<?php while ($row1=mysql_fetch_array($result1)) { ?>
										<option value="<?php echo $row1['id']?>"><?php echo $row1['v_name']; ?></option>
											<?php } ?>
									</select>
										<?php if(in_array(188, $access_arry)){?><button class="btn ownbtn11" title="Add New Vendor" style="height: 34px; margin-top: -27px;" href="#myModal" data-toggle="modal"> Add</button><?php } ?>
									</span>	
								</p>
								<p>
									<label>Status*</label>
										<span class="field">
											<select class="chzn-select" name="p_sts" style="width:40%" required="" >
												<option value="Brand New">Brand New</option>
												<option value="Replaced">Replaced</option>
												<option value="Old">Old</option>
												<option value="Repaird">Repaird</option>
											</select>
										</span>					
								</p>
								<p>
									<label>Serial No*</label>
									<span class="field"><input type="text" name="p_sl_no" id="" class="input-xxlarge" required=""></span>
								</p>
								<p>	
									<label>Fiber Name*</label>
									<span class="field">
									<select data-placeholder="Choose a Fiber" name="p_id" class="chzn-select"  style="width:487.5px;" required="" />
										<option value=""></option>
											<?php while ($row1=mysql_fetch_array($result2)) { ?>
										<option value="<?php echo $row1['id']?>"><?php echo $row1['pro_name']; ?></option>
											<?php } ?>
									</select>
										<?php if(in_array(197, $access_arry)){?><button class="btn ownbtn11" title="Add New Fiber Name" style="height: 34px; margin-top: -27px;" href="#myModal2" data-toggle="modal"> Add</button>	<?php } ?>
									</span>	
								</p>
								
								<p>
									<label>Brand Name*</label>
									<span class="field"><input type="text" name="brand" id="" class="input-xxlarge" required="" /></span>
								</p>
								<p>
									<label>Fiber ID</label>
									<span class="field"><input type="text" name="fiber_id" id="" class="input-xlarge" /></span>
								</p>
								<p>
									<label>Fiber Start Meter*</label>
									<span class="field"><input type="text" name="fiberstart" id=""  style="width: 100px;" required="" class="input-large" /></span>
								</p>
								<p>
									<label>Fiber End Meter*</label>
									<span class="field"><input type="text" name="fiberend" id=""  style="width: 100px;" required="" class="input-large" onChange="updatesum()" /></span>
								</p>
								<p>
									<label>Total Meter</label>
									<span class="field"><input type="text" name="fibertotal" id="" style="width: 100px;" required="" readonly class="input-xlarge" onChange="updatesum()"  /></span>
								</p>
								<p>
									<span class="field"><input type="hidden" name="quantity" id="" required="" readonly value="1" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Meter Price*</label>
									<span class="field"><input type="text" name="prc" required="" id="" style="width: 50px;" class="input-xlarge" onChange="updatesum()"/> ৳</span>
								</p>
								<p>
									<label>Total Price</label>
									<span class="field"><input type="text" name="price" id="" readonly required="" style="width: 100px;" class="input-xlarge" onChange="updatesum()"/> ৳</span>
								</p>
								<p>
									<label>Remarks</label>
									<span class="field"><textarea type="text" name="rimarks" id="" class="input-xxlarge"/></textarea></span>
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