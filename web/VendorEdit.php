<?php
$titel = "Vendor Edit";
$VendorBill = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'VendorBill' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql2 ="SELECT id, v_name, cell, email, location FROM vendor WHERE id = '$vp_id'";


$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);

$v_id = $row2['id'];
$v_name = $row2['v_name'];
$cell = $row2['cell'];
$email = $row2['email'];
$location = $row2['location'];

?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Edit Vendor</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Vendor Information Edit</h5>
				</div>
				<form id="form" class="stdform" method="post" action="ActionAdd" >
				<input type="hidden" name="typee" value="vendoredit"/>
					<div class="modal-body">
					<p>
						<label>Vendor ID</lab
						<span class="field">
							<div class="controls">	
								<input style="text-align:center;width: 5%;" id="" type="text" class="input-xlarge" readonly name="iddd" value="<?php echo $v_id;?>">
							</div>
						</span>
					</p>
					<p>
						<label>Name*</label>
						<span class="field"><input id="" type="text" name="v_name" class="input-xlarge" value="<?php echo $v_name;?>" required=""></span>
					</p>
					<p>
						<label>Cell*</label>
						<span class="field"><input id="" type="text" name="cell" class="input-xlarge" value="<?php echo $cell;?>" required=""></span>
					</p>
					<p>
						<label>Email</label>
						<span class="field"><input id="" type="text" name="email" class="input-xlarge" value="<?php echo $email;?>"></span>
					</p>
					<p>
						<label>Location</label>
						<span class="field"><textarea type="text" name="location" style="width:30%;" id="" class="input-xlarge" /><?php echo $location;?></textarea></span>
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
}
else{
	include('include/index');
}
include('include/footer.php');
?>