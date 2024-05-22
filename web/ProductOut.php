<?php
$titel = "Product Out";
$Store = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$result = mysql_query("SELECT s.id, p.pro_name, s.fiber_id, s.fibertotal, s.fibertotal_out FROM store_in AS s
						LEFT JOIN product AS p ON p.id = s.p_id
						WHERE s.p_id = '4' AND s.sts = 0 ORDER BY s.fiber_id");

$result1 = mysql_query("SELECT s.id, p.pro_name, s.p_sl_no FROM store_in AS s
						LEFT JOIN product AS p ON p.id = s.p_id
						WHERE s.p_id != '4' AND s.sts = 0 ORDER BY p.pro_name");
						
$query2="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e
			LEFT JOIN department_info AS d
			ON d.dept_id = e.dept_id
			WHERE e.sts = '0' ORDER BY e.e_name ASC";
$result2=mysql_query($query2);
?>
<script type="text/javascript"><!--
function updatesum() {
document.form.fibertotal.value = (document.form.fiberend.value -0) - (document.form.fiberstart.value -0);
}
//--></script>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Store"><i class="iconfa-arrow-left"></i>  Back</a>
			<a class="btn" href="StoreOutDetails">Store Out Details</a>
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Product Out (Use)</h1>
        </div>
    </div>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Product Out from Store</h5>
				</div>
					<form id="form" class="stdform"  name="form" method="post" action="ProductOutSave" enctype="multipart/form-data">
						<input type="hidden" name="typ" value="main" />
						<input type="hidden" name="out_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="out_date_time" value="<?php echo date("Y-m-d h:i:s");?>" />
							<div class="modal-body">
								<p>
									<label>Purchase Date*</label>
									<span class="field"><input type="text" name="out_date" readonly id="" class="input-xxlarge" value="<?php echo date("Y-m-d");?>"></span>
								</p>
								<p>	
									<label>Product</label>
									<span class="field">
										<select data-placeholder="Choose a Product" name="p_id" class="chzn-select"  style="width: 540px;">
											<option value=""></option>
												<?php while ($row = mysql_fetch_array($result1)) {
													$pro_name = $row['pro_name'];
													$p_sl_no = $row['p_sl_no'];
													?>
											<option value="<?php echo $row['id']?>"><?php echo $p_sl_no.' - '.$pro_name; ?></option>
												<?php } ?>
										</select>
									</span>	
								</p>
								<p>	
									<label>Fiber</label>
									<span class="field">
										<select data-placeholder="Choose a fiber" name="f_id" class="chzn-select"  style="width:447.5px;">
											<option value=""></option>
												<?php while ($row = mysql_fetch_array($result)) { 
													$pro_name = $row['pro_name'];
													$fiber_id = $row['fiber_id'];
													$fibertotal = $row['fibertotal'];
													$fibertotal_out = $row['fibertotal_out'];
													$rem = $fibertotal - $fibertotal_out;
												?>
											<option value="<?php echo $row['id']?>"><?php echo $fiber_id.' - '.$pro_name.' ('.$rem.')'; ?></option>
												<?php } ?>
										</select>
										<input type="text" name="qty" style="height: 24px; margin-top: -27px; width: 80px;" id="" placeholder="Total in metter" value="">
									</span>	
								</p>
								<p>	
									<label>Receiver*</label>
									<select data-placeholder="" name="receive_by" class="chzn-select" required="" style="width:540px;" >
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result2)) { ?>
										<option value="<?php echo $row['e_id']?>"><?php echo $row['e_id']; ?> - <?php echo $row['e_name']; ?> (<?php echo $row['dept_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>
									<label>Remarks (Optional)</label>
									<span class="field"><textarea type="text" name="rmk" id="" placeholder="Write a note......." class="input-xxlarge"/></textarea></span>
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