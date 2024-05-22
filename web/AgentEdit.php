<?php
$titel = "Update agent";
$Agent = 'active';
include('include/hader.php');

$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Agent' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


$sql = mysql_query("SELECT * FROM agent WHERE e_id = '$id'");
$row = mysql_fetch_assoc($sql);

$sql1 = mysql_query("SELECT * FROM login WHERE e_id = '$id'");
$row11 = mysql_fetch_assoc($sql1);

?>
<!-- Image upload Script Start -->
 <script type="text/javascript">
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(50)
                        .height(50);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" href="Agent"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user-md"></i></div>
        <div class="pagetitle">
            <h1>Edit Agent</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Agent</h5>
				</div>			
				<form class="stdform" method="post" action="AgentEditquery" name="form" enctype="multipart/form-data">
					<div class="modal-body">
						<p>
							<label>Agent ID </label>
							<span class="field">
							<input type="text" name="e_id" style="width:10%;"  readonly value="<?php echo $row['e_id']; ?>" />
							</span>
						</p>
						<p>
							<label>Agent Name* </label>
							<span class="field">
							<input type="text" name="e_name" id="" value="<?php echo $row['e_name']; ?>" class="input-xlarge" required=""/>
							</span>
						</p>
						<p>
							<label>Username</label>
							<span class="field">
								<input type="text" readonly id="" value="<?php echo $row11['user_id']; ?>" class="input-xlarge" required=""/>
							</span>
						</p>
						<p>
							<label>Password</label>
							<span class="field">
								<input type="text" readonly id="" value="<?php echo $row11['pw']; ?>" class="input-large" required=""/><a href="UserEdit?id=<?php echo $row11['id'];?>" class='btn col1' style="margin-left: 2px;"><i class='iconfa-edit'></i></a>
							</span>
						</p>
						<p>
							<label>Commission in Percent*</label>
							<span class="field"><input type="text" name="com_percent" id="" style="width:10%;" required="" placeholder="Percent Like 10" value="<?php echo $row['com_percent']; ?>" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='%' readonly /></span>
						</p>
						<p>
							<label>Father's Name </label>
							<span class="field">
							<input type="text" name="e_f_name" id="" value="<?php echo $row['e_f_name']; ?>" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>Mother's Name </label>
							<span class="field">
							<input type="text" name="e_m_name" id="" value="<?php echo $row['e_m_name']; ?>" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>
							Date of Birth </label>
							<span class="field">
							<input type="text" name="e_b_date" id="" value="<?php echo $row['e_b_date']; ?>" class="input-xlarge datepicker"/>
							</span>
						</p>
						<p>
							<label>
							Joining Date </label>
							<span class="field">
							<input type="text" name="e_j_date" id="" class="input-xlarge datepicker" value="<?php echo $row['e_j_date']; ?>" />
							</span>
						</p>
						<p>
							<label>
							Gender </label>
							<span class="field">
							<input type="radio" id="male" value="Male" name="e_gender" <?php if( $row['e_gender'] == 'Male') {echo 'checked';} ?> />
							Male &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; 
							<input type="radio" id="female" value="Female" name="e_gender" <?php if( $row['e_gender'] == 'Female') {echo 'checked';} ?> />
							Female </span>
						</p>
						<p>
							<label>
							Marital Status </label>
							<span class="field">
							<input type="radio" id="Unmarried" value="Unmarried" name="married_stu" <?php if( $row['married_stu'] == 'Unmarried') {echo 'checked';} ?> />
							Unmarried &nbsp; &nbsp; &nbsp; &nbsp; <input type="radio" id="Married" value="Married" name="married_stu" <?php if( $row['married_stu'] == 'Married') {echo 'checked';} ?> />
							Married </span>
						</p>
						<p>
							<label>Blood Group</label>
							<select class="select-ext-large chzn-select" style="width:240px;" name="bgroup">
								<option value="">Choose Blood Group</option>
								<option value="AB+" <?php if( $row['bgroup'] == 'AB+') {echo 'selected';} ?>>AB+</option>
								<option value="AB-" <?php if( $row['bgroup'] == 'AB-') {echo 'selected';} ?>>AB-</option>
								<option value="A+" <?php if( $row['bgroup'] == 'A+') {echo 'selected';} ?>>A+</option>
								<option value="A-" <?php if( $row['bgroup'] == 'A-') {echo 'selected';} ?>>A-</option>
								<option value="B+" <?php if( $row['bgroup'] == 'B+') {echo 'selected';} ?>>B+</option>
								<option value="B-" <?php if( $row['bgroup'] == 'B-') {echo 'selected';} ?>>B-</option>
								<option value="O+" <?php if( $row['bgroup'] == 'O+') {echo 'selected';} ?>>O+</option>
								<option value="O-" <?php if( $row['bgroup'] == 'O-') {echo 'selected';} ?>>O-</option>
							</select>
						</p>
						<p>
							<label>National ID</label>
							<span class="field">
							<input type="text" name="n_id" id="" value="<?php echo $row['n_id']; ?>" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>Present Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="pre_address" id="" class="input-xlarge"><?php echo $row['pre_address']; ?></textarea>
							</span>
						</p>
						<p>
							<label>Permanent Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="per_address" id="" class="input-xlarge"><?php echo $row['per_address']; ?></textarea>
							</span>
						</p>
						<p>
							<label>Personal Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_per" id="" class="input-xlarge" value="<?php echo $row['e_cont_per']; ?>" />
							</span>
						</p>
						<p>
							<label>Office Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_office" id="" class="input-xlarge" value="<?php echo $row['e_cont_office']; ?>" />
							</span>
						</p>
						<p>
							<label>Family Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_family" id="" class="input-xlarge" value="<?php echo $row['e_cont_family']; ?>" />
							</span>
						</p>
						<p>
							<label>First Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact1" id="" class="input-xlarge" value="<?php echo $row['ref_contact1']; ?>" />
							</span>
						</p>
						<p>
							<label>Second Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact2" id="" class="input-xlarge" value="<?php echo $row['ref_contact2']; ?>" />
							</span>
						</p>
						<p>
							<label>Email </label>
							<span class="field">
							<input type="text" name="email" id="" class="input-xlarge" value="<?php echo $row['email']; ?>" />
							</span>
						</p>
						<p>
							<label>Skype </label>
							<span class="field">
							<input type="text" name="skype" id="" class="input-xlarge" value="<?php echo $row['skype']; ?>" />
							</span>
						</p>
						<p>
                            <label>Present Image</label>
                            <span class="field"><img id="blah" src="<?php if($row['e_image'] == ''){echo 'emp_images/no_img.jpg';} else{ echo $row['e_image'];} ?>" height="70" width="70" border=0></span>
                        </p>
					</div>
					
					<!--#wiz1step3-->
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11"> Reset </button>&nbsp; 
						<button type="submit" class="btn ownbtn2"> Submit </button>
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
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(70)
                        .height(70);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
 </script>