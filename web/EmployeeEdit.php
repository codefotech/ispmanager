<?php
$titel = "Update Employee";
$Employee = 'active';
include('include/hader.php');

$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Employee' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


$sql = mysql_query("SELECT * FROM emp_info WHERE e_id = '$id'");
$row = mysql_fetch_assoc($sql);

$sql1 = mysql_query("SELECT * FROM emp_edu_info WHERE e_id = '$id'");

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

function updatesum() {
document.form.gross_total.value = ((document.form.basic_salary.value -0) + (document.form.mobile_bill.value -0) + (document.form.house_rent.value -0) + (document.form.medical.value -0) + (document.form.food.value -0) + (document.form.others.value -0)) - ((document.form.provident_fund.value -0) + (document.form.professional_tax.value -0) + (document.form.income_tax.value -0));
}
</script>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
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
				<form class="stdform" method="post" action="EmployeeEditquery" name="form" enctype="multipart/form-data">
					<div class="modal-body">
						<p>
							<label>Employee ID </label>
							<span class="field">
							<input type="text" name="e_id" class="input-xxlarge" readonly value="<?php echo $row['e_id']; ?>" />
							</span>
						</p>
						<p>
							<label>
							Designation Name </label>
							<span class="field">
							<input type="text" name="e_des" id="" value="<?php echo $row['e_des']; ?>" class="input-xxlarge" required=""/>
							</span>
						</p>
						<p>
							<label>Department Name </label>
							<select class="select-ext-large chzn-select" style="width:540px;" name="e_dept" required="">
								<option value="">Choose Departmen Name </option>
								<?php 	$emp_n="SELECT * FROM department_info WHERE status = '0' order by dept_name asc";	$e_n_ro=mysql_query($emp_n); ?>
								<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
								<option value=" <?php echo $e_n_r['dept_id'];?>" <?php if( $e_n_r['dept_id'] == $row['dept_id']) {echo 'selected';} ?>> <?php echo $e_n_r['dept_name']?></option>
								<?php } ?>
							</select>
						</p>
						<p>
							<label>Employee Name </label>
							<span class="field">
							<input type="text" name="e_name" id="" value="<?php echo $row['e_name']; ?>" class="input-xxlarge" required=""/>
							</span>
						</p>
						<p>
							<label>Father's Name </label>
							<span class="field">
							<input type="text" name="e_f_name" id="" value="<?php echo $row['e_f_name']; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>Mother's Name </label>
							<span class="field">
							<input type="text" name="e_m_name" id="" value="<?php echo $row['e_m_name']; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>
							Date of Birth </label>
							<span class="field">
							<input type="text" name="e_b_date" id="" value="<?php echo $row['e_b_date']; ?>" class="input-xxlarge datepicker"/>
							</span>
						</p>
						<p>
							<label>
							Joining Date </label>
							<span class="field">
							<input type="text" name="e_j_date" id="" class="input-xxlarge datepicker" value="<?php echo $row['e_j_date']; ?>" />
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
							<select class="select-ext-large chzn-select" style="width:540px;" name="bgroup">
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
							<input type="text" name="n_id" id="" value="<?php echo $row['n_id']; ?>" class="input-xxlarge"/>
							</span>
						</p>
						<h4 class="h44">Employee Educational Information </h4>
						<center>
							<table style="margin-left: 70px;">										
								<tr class="btn-primary"> 											
									<th>Education Filed</th>											
									<th>Institution Name</th>											
									<th>Group of Study</th>											
									<th>Result</th>										
								</tr>										
								<?php										
								for($i=0; $i<6; $i++){											
									while($row2 = mysql_fetch_assoc($sql1)){	$i = $i+1;													
											echo														
											"<tr class='gradeX'>											
											<td>												
											<input type='text' name='a$i' id='' class='select-x-large' value='{$row2['edu_fild']}' />											
											</td>											
											<td>												
											<input type='text' name='b$i' id='' class='input-x-large' value='{$row2['edu_inst']}' />											
											</td>								  											
											<td>												
											<input class='input-medium' type='text' name='c$i' id='cgpa'  value='{$row2['edu_group']}' />											
											</td>											
											<td>												
											<input class='input-medium' type='text' name='d$i' value='{$row2['edu_result']}' />											
											</td>											
											<td><input class='input-medium' type='hidden' name='id$i' value='{$row2['id']}' /></td>	
											</tr>\n";											
									}  
								}											
								echo														
									"<tr class='gradeX'>											
									<td>												
									<input type='text' name='a6' id='' class='select-x-large' value='{$row2['edu_fild']}' />											
									</td>											
									<td>												
									<input type='text' name='b6' id='' class='input-x-large' value='{$row2['edu_inst']}' />											
									</td>								  											
									<td>												
									<input class='input-medium' type='text' name='c6' id='cgpa' value='{$row2['edu_group']}' />											
									</td>											
									<td>												
									<input class='input-medium' type='text' name='d6' value='{$row2['edu_result']}' />											
									</td>											
									<td></td>																						
									</tr>\n";											
								echo														
									"<tr class='gradeX'>											
									<td>												
									<input type='text' name='a7' id='' class='select-x-large' value='{$row2['edu_fild']}' />											
									</td>											
									<td>												
									<input type='text' name='b7' id='' class='input-x-large' value='{$row2['edu_inst']}' />											
									</td>								  											
									<td>												
									<input class='input-medium' type='text' name='c7' id='cgpa' value='{$row2['edu_group']}' />											
									</td>											
									<td>												
									<input class='input-medium' type='text' name='d7' value='{$row2['edu_result']}' />											
									</td>											
									<td></td>																						
									</tr>\n";											
								echo														
									"<tr class='gradeX'>											
									<td>												
									<input type='text' name='a8' id='' class='select-x-large' value='{$row2['edu_fild']}' />											
									</td>											
									<td>												
									<input type='text' name='b8' id='' class='input-x-large' value='{$row2['edu_inst']}' />											
									</td>								  											
									<td>												
									<input class='input-medium' type='text' name='c8' id='cgpa' value='{$row2['edu_group']}' />											
									</td>											
									<td>												
									<input class='input-medium' type='text' name='d8' value='{$row2['edu_result']}' />											
									</td>											
									<td></td>																						
									</tr>\n";										
								?>								
							</table> 
						</center>
						<p>
							<label>
							First Experience </label>
							<span class="field">
								<textarea cols="150" rows="1" name="exp1" id="" class="input-xxlarge"><?php echo $row['exp1']; ?></textarea>
							</span>
						</p>
						<p>
							<label>Second Experience </label>
							<span class="field">
								<textarea cols="150" rows="1" name="exp2" id="" class="input-xxlarge"><?php echo $row['exp2']; ?></textarea>
							</span>
						</p>
						<p>
							<label>Third Experience </label>
							<span class="field">
								<textarea cols="150" rows="1" name="exp3" id="" class="input-xxlarge"><?php echo $row['exp3']; ?></textarea>
							</span>
						</p>
						<h4 class="h44">Employee Salary & Deductions</h4>
						<p> <h4>Salary & Allowances</h4> </p> 
						<p>
							<label style="font-weight: bold;">	Basic Salary* </label>
							<span class="field">
								<input type="text" name="basic_salary" id="" style="font-weight: bold;width:10%;" onChange="updatesum()" required="" value="<?php echo $row['basic_salary']; ?>" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Mobile Bill </label>
							<span class="field">
								<input type="text" name="mobile_bill" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['mobile_bill']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	House Rent </label>
							<span class="field">
								<input type="text" name="house_rent" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['house_rent']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Medical </label>
							<span class="field">
								<input type="text" name="medical" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['medical']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Food </label>
							<span class="field">
								<input type="text" name="food" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['food']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Others </label>
							<span class="field">
								<input type="text" name="others" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['others']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Net Gross Salary </label>
							<span class="field">
								<input type="text" name="gross_total" id="" readonly style="font-size: 20px;color: red;font-weight: bold;width:10%;" onChange="updatesum()" value="<?php echo $row['gross_total']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p> <h4>Deductions</h4> </p> 
						<p>
							<label>	Provident Fund </label>
							<span class="field">
								<input type="text" name="provident_fund" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['provident_fund']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Professional Tax </label>
							<span class="field">
								<input type="text" name="professional_tax" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['professional_tax']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Income Tax </label>
							<span class="field">
								<input type="text" name="income_tax" id="" style="width:10%;" onChange="updatesum()" value="<?php echo $row['income_tax']; ?>"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<h4 class="h44">Employee Contact Information </h4>
						<p>
							<label>Present Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="pre_address" id="" class="input-xxlarge"><?php echo $row['pre_address']; ?></textarea>
							</span>
						</p>
						<p>
							<label>Permanent Address</label>
							<span class="field">
								<textarea cols="150" rows="1" name="per_address" id="" class="input-xxlarge"><?php echo $row['per_address']; ?></textarea>
							</span>
						</p>
						<p> Contact Info </p>
						<p>
							<label>Personal Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_per" id="" class="input-xxlarge" value="<?php echo $row['e_cont_per']; ?>" />
							</span>
						</p>
						<p>
							<label>Office Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_office" id="" class="input-xxlarge" value="<?php echo $row['e_cont_office']; ?>" />
							</span>
						</p>
						<p>
							<label>Family Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_family" id="" class="input-xxlarge" value="<?php echo $row['e_cont_family']; ?>" />
							</span>
						</p>
						<p>
							<label>First Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact1" id="" class="input-xxlarge" value="<?php echo $row['ref_contact1']; ?>" />
							</span>
						</p>
						<p>
							<label>Second Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact2" id="" class="input-xxlarge" value="<?php echo $row['ref_contact2']; ?>" />
							</span>
						</p>
						<p>
							<label>Email </label>
							<span class="field">
							<input type="text" name="email" id="" class="input-xxlarge" value="<?php echo $row['email']; ?>" />
							</span>
						</p>
						<p>
							<label>Skype </label>
							<span class="field">
								<input type="text" name="skype" id="" class="input-xxlarge" value="<?php echo $row['skype']; ?>" />
							</span>
						</p>
						<p>
                            <label>Present Image</label>
                            <span class="field"><img src="<?php echo $row['e_image']; ?>" height="70" width="70" border=0></span>
                        </p>
					</div>
					
					<!--#wiz1step3-->
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