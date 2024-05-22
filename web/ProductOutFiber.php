<?php
$titel = "Cable Out";
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
$result = mysql_query("SELECT s.id, p.pro_name, s.fiber_id, s.fibertotal, s.fibertotal_out FROM store_in_out_fiber AS s
						LEFT JOIN fiber AS p ON p.id = s.p_id
						WHERE s.sts = 0 AND s.status = '0' ORDER BY s.fiber_id");

$query2="SELECT e.id, e.e_id, d.dept_name, e.e_name FROM emp_info AS e
			LEFT JOIN department_info AS d
			ON d.dept_id = e.dept_id
			WHERE e.sts = '0' ORDER BY e.e_name ASC";
$result3=mysql_query($query2);

$query20="SELECT com_id, c_id, c_name, cell FROM clients WHERE sts = '0' AND mac_user = '0' ORDER BY id ASC";
$result20=mysql_query($query20);
?>
<script type="text/javascript"><!--
function updatesum() {
document.form.fibertotal.value = (document.form.fiberend.value -0) - (document.form.fiberstart.value -0);
}
//--></script>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		<?php if(in_array(192, $access_arry)){?>
			<a class="btn ownbtn6" href="FiberStoreOutDetails">Store Out Details</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Cable Out</h1>
        </div>
    </div>
	<?php if($sts == 'vendor') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Vendor Successfully Inserted.
		</div><!--alert-->
	<?php } if($sts == 'fiberout') {?>
			<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> Cable Successfully Out From Store.
		</div><!--alert-->
	<?php } if(in_array(186, $access_arry)){?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Cable Out from Store</h5>
				</div>
                       <form id="form" class="stdform"  name="form" method="post" action="ProductOutFiberSave" enctype="multipart/form-data">
						<input type="hidden" name="typ" value="main" />
						<input type="hidden" name="out_by" value="<?php echo $e_id; ?>" />
						<input type="hidden" name="out_date_time" value="<?php echo date("Y-m-d h:i:s");?>" />
							<div class="modal-body">
								<p>
									<label>Out Date*</label>
									<span class="field"><input type="text" name="out_date" readonly id="" class="input-xxlarge" value="<?php echo date("Y-m-d");?>"></span>
								</p>
								<p>	
									<label>Cable</label>
										<select data-placeholder="Choose a Cable" name="f_id" class="chzn-select"  style="width:447.5px;">
											<option value=""></option>
												<?php while ($row1 = mysql_fetch_array($result)) { 
													$pro_name1 = $row1['pro_name'];
													$fiber_id = $row1['fiber_id'];
													$fibertotal = $row1['fibertotal'];
													$fibertotal_out = $row1['fibertotal_out'];
													$rem = $fibertotal - $fibertotal_out;
												?>
											<option value="<?php echo $row1['id']?>"><?php echo $fiber_id.' - '.$pro_name1.' ('.$rem.')'; ?></option>
												<?php } ?>
										</select>
										<input type="text" name="qty" style="height: 24px; margin-top: -27px; width: 80px;" id="" placeholder="Total in metter" required="">
								</p>
								<p>	
									<label>Receiver*</label>
									<select data-placeholder="" name="receive_by" class="chzn-select" required="" style="width:540px;" >
										<option value=""></option>
											<?php while ($row=mysql_fetch_array($result3)) { ?>
										<option value="<?php echo $row['e_id']?>"><?php echo $row['e_id']; ?> - <?php echo $row['e_name']; ?> (<?php echo $row['dept_name']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>	
									<label>Client</label>
									<select data-placeholder="" name="c_id" class="chzn-select" style="width:540px;" >
										<option value=""></option>
										<?php while ($roww=mysql_fetch_array($result20)) { ?>
										<option value="<?php echo $roww['c_id']?>"><?php echo $roww['c_id']; ?> - <?php echo $roww['c_name']; ?> (<?php echo $roww['cell']; ?>)</option>
											<?php } ?>
									</select>
								</p>
								<p>
									<label>Remarks (Optional)</label>
									<span class="field"><textarea type="text" name="rmk" id="" placeholder="Write a note......." class="input-xxlarge"/></textarea></span>
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
else{
	include('include/index');
}
include('include/footer.php');
?>