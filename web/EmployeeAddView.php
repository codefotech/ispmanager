<?php
$titel = "Check Employee";
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Employee' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
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
			<a class="btn btn-primary" href="Employee"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user-md"></i></div>
        <div class="pagetitle">
            <h1>Add Employee</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New Employee</h5>
				</div>			
				<form class="stdform" method="post" action="EmployeeAddquery" name="form" enctype="multipart/form-data">
					<div class="modal-body">
						<p>
							<label>Employee ID</label>
							<span class="field">
							<input type="text" name="e_id" class="input-xxlarge" readonly value="<?php echo $e_id; ?>" />
							</span>
						</p>
						<p>
							<label>Designation Name</label>
							<span class="field">
							<input type="text" name="e_des" id="" value="<?php echo $e_des; ?>" class="input-xxlarge" required=""/>
							</span>
						</p>
						<p>
							<label>Department Name</label>
							<select class="select-ext-large chzn-select" style="width:540px;" name="e_dept" required="">
								<option value="">Choose Departmen Name </option>
								<?php 	$emp_n="SELECT * FROM department_info order by dept_name asc";	$e_n_ro=mysql_query($emp_n); ?>
								<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
								<option value=" <?php echo $e_n_r['dept_id'];?>" <?php if( $e_n_r['dept_id'] == $e_dept) {echo 'selected';} ?>> <?php echo $e_n_r['dept_name']?></option>
								<?php } ?>
							</select>
						</p>
						<p>
							<label>Employee Name</label>
							<span class="field">
							<input type="text" name="e_name" id="" value="<?php echo $e_name; ?>" class="input-xxlarge" required=""/>
							</span>
						</p>
						<p>
							<label>Father's Name </label>
							<span class="field">
							<input type="text" name="e_f_name" id="" value="<?php echo $e_f_name; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>Mother's Name </label>
							<span class="field">
							<input type="text" name="e_m_name" id="" value="<?php echo $e_m_name; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>Date of Birth </label>
							<span class="field">
							<input type="text" name="e_b_date" id="" value="<?php echo $e_b_date; ?>" class="input-xxlarge datepicker"/>
							</span>
						</p>
						<p>
							<label>Joining Date </label>
							<span class="field">
							<input type="text" name="e_j_date" id="" class="input-xxlarge datepicker" value="<?php echo $e_j_date; ?>" />
							</span>
						</p>
						<p>
							<label>Gender </label>
							<span class="field">
							<input type="radio" id="male" value="Male" name="e_gender" <?php if( $e_gender == 'Male') {echo 'checked';} ?> />
							Male &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; 
							<input type="radio" id="female" value="Female" name="e_gender" <?php if( $e_gender == 'Female') {echo 'checked';} ?> />
							Female </span>
						</p>
						<p>
							<label>Marital Status </label>
							<span class="field">
							<input type="radio" id="Unmarried" value="Unmarried" name="married_stu" <?php if( $married_stu == 'Unmarried') {echo 'checked';} ?> />
							Unmarried &nbsp; &nbsp; &nbsp; &nbsp; 
							<input type="radio" id="Married" value="Married" name="married_stu" <?php if( $married_stu == 'Married') {echo 'checked';} ?> />
							Married </span>
						</p>
						<p>
							<label>Blood Group</label>
							<span class="field">
							<input type="text" name="bgroup" id="" class="input-xxlarge" value="<?php echo $bgroup; ?>" />
							</span>
						</p>
						<p>
							<label>National ID</label>
							<span class="field">
							<input type="text" name="n_id" id="" class="input-xxlarge" value="<?php echo $n_id; ?>" />
							</span>
						</p>
						<h4 class="h44">Employee Educational Information </h4>
						<center>
							<table>
								<tr class="btn-primary">
									<th>
										Education Filed
									</th>
									<th>
										Institution Name
									</th>
									<th>
										Group of Study
									</th>
									<th>
										Result
									</th>
								</tr>
								<tr>
									<td>
										<input type="text" name="a" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a; ?>" />
									</td>
									<td>
										<input type="text" name="b" id="" class="input-x-large" onchange="updateinto()" value="<?php echo $b; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c" id="cgpa" onblur="click_cgpa()" value="<?php echo $c; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d" value="<?php echo $d; ?>" />
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" name="a1" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a1; ?>" />
									</td>
									<td>
										<input name="b1" class="input-x-large" onchange="updateinto2()" value="<?php echo $b1; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c1" id="cgpa2" onblur="click_cgpa2()" value="<?php echo $c1; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d1" value="<?php echo $d1; ?>" />
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" name="a2" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a2; ?>" />
									</td>
									<td>
										<input name="b2" class="input-x-large" onchange="updateinto3()" value="<?php echo $b2; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c2" id="cgpa3" onblur="click_cgpa3()" value="<?php echo $c2; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d2" value="<?php echo $d2; ?>" />
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<input type="text" name="a3" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a3; ?>" />
									</td>
									<td>
										<input name="b3" onchange="updateinto4()" class="input-x-large" value="<?php echo $b3; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c3" id="cgpa4" onchange="updateinto4()" value="<?php echo $c3; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d3" value="<?php echo $d3; ?>" />
									</td>
									<td id="AddMore">
										<input type="button" value="+" onclick="add_extra_field()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add">
									<td>
										<input type="text" name="a4" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a4; ?>" />
									</td>
									<td>
										<input style="text-align: center;" name="b4" onchange="updateinto5()" class="input-x-large" value="<?php echo $b4; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c4" id="cgpa5" onchange="updateinto5()" value="<?php echo $c4; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d4" value="<?php echo $d4; ?>" />
									</td>
									<td id="add1">
										<input type="button" value="+" onclick="add_extra_field1()">
										<input type="button" value="-" onclick="remove_extra_field1()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add21">
									<td>
										<input type="text" name="a5" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a5; ?>" />
									</td>
									<td>
										<input style="text-align: center;" name="b5" class="input-x-large" onchange="updateinto6()" value="<?php echo $b5; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c5" id="cgpa6" onblur="click_cgpa6()" value="<?php echo $c5; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d5" value="<?php echo $d5; ?>" />
									</td>
									<td id="add22">
										<input type="button" value="+" onclick="add_extra_field2()">
										<input type="button" value="-" onclick="remove_extra_field2()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add31">
									<td>
										<input type="text" name="a6" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a6; ?>" />
									</td>
									<td>
										<input style="text-align: center;" name="b6" onchange="updateinto7()" class="input-x-large" value="<?php echo $b6; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c6" id="cgpa7" onchange="updateinto7()" value="<?php echo $c6; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d6" value="<?php echo $d6; ?>" />
									</td>
									<td id="add32">
										<input type="button" value="+" onclick="add_extra_field3()"><input type="button" value="-" onclick="remove_extra_field3()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add41">
									<td>
										<input type="text" name="a7" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a7; ?>" />
									</td>
									<td>
										<input style="text-align: center;" name="b7" onchange="updateinto8()" class="input-x-large" value="<?php echo $b7; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c7" id="cgpa8" onchange="updateinto8()" value="<?php echo $c7; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d7" value="<?php echo $d7; ?>" />
									</td>
									<td id="add42">
										<input type="button" value="+" onclick="add_extra_field4()"><input type="button" value="-" onclick="remove_extra_field4()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add51">
									<td>
										<input type="text" name="a8" id="" class="select-x-large" onchange="updateinto()" value="<?php echo $a8; ?>" />
									</td>
									<td>
										<input style="text-align: center;" name="b8" onchange="updateinto9()" class="input-x-large" value="<?php echo $b8; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="c8" id="cgpa9" onchange="updateinto9()" value="<?php echo $c8; ?>" />
									</td>
									<td>
										<input class="input-medium" type="text" name="d8" value="<?php echo $d8; ?>" />
									</td>
									<td id="add52">
										<input type="button" value="-" onclick="remove_extra_field5()">
									</td>
								</tr>
							</table>
						</center>
						<p>
							<label>First Experience </label>
							<span class="field">
								<textarea cols="150" rows="1" name="exp1" id="" class="input-xxlarge"><?php echo $exp1; ?></textarea>
							</span>
						</p>
						<p>
							<label>Second Experience </label>
							<span class="field">
								<textarea cols="150" rows="1" name="exp2" id="" class="input-xxlarge"><?php echo $exp2; ?></textarea>
							</span>
						</p>
						<p>
							<label>Third Experience </label>
							<span class="field">
								<textarea cols="150" rows="1" name="exp3" id="" class="input-xxlarge"><?php echo $exp3; ?></textarea>
							</span>
						</p>
						<h4 class="h44">Employee Contact Information </h4>
						<p>
							<label>Present Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="pre_address" id="" class="input-xxlarge"><?php echo $pre_address; ?></textarea>
							</span>
						</p>
						<p>
							<label>Permanent Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="per_address" id="" class="input-xxlarge"><?php echo $per_address; ?></textarea>
							</span>
						</p>
						<p> Contact Info </p>
						<p>
							<label>
							Personal Contact No</label>
							<span class="field">
								<input type="text" name="e_cont_per" id="" class="input-xxlarge" value="<?php echo $e_cont_per; ?>" />
							</span>
						</p>
						<p>
							<label>Office Contact No</label>
							<span class="field">
								<input type="text" name="e_cont_office" id="" class="input-xxlarge" value="<?php echo $e_cont_office; ?>" />
							</span>
						</p>
						<p>
							<label>Family Contact No</label>
							<span class="field">
								<input type="text" name="e_cont_family" id="" class="input-xxlarge" value="<?php echo $e_cont_family; ?>" />
							</span>
						</p>
						<p>
							<label>First Reference No</label>
							<span class="field">
								<input type="text" name="ref_contact1" id="" class="input-xxlarge" value="<?php echo $ref_contact1; ?>" />
							</span>
						</p>
						<p>
							<label>Second Reference No</label>
							<span class="field">
								<input type="text" name="ref_contact2" id="" class="input-xxlarge" value="<?php echo $ref_contact2; ?>" />
							</span>
						</p>
						<p>
							<label>Email</label>
							<span class="field">
								<input type="text" name="email" id="" class="input-xxlarge" value="<?php echo $email; ?>" />
							</span>
						</p>
						<p>
							<label>Skype</label>
							<span class="field">
								<input type="text" name="skype" id="" class="input-xxlarge" value="<?php echo $skype; ?>" />
							</span>
						</p>
						<p>
							<label class="control-label"  for="com_logo">Employee Image</label>
							<div class="controls">
								<span class="btn btn-file">
									<span class="fileupload-new">Choose Image</span>
									<input type='file' name="image" onchange="readURL(this);" />
								</span>
									<img id="blah" src="#" alt="" />
							</div>
						</p>
					</div>
					<!--#wiz1step3-->
					<div class="modal-footer">
						<button type="reset" class="btn"> Reset </button>&nbsp; 
						<button type="submit" class="btn btn-primary"> Submit </button>
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