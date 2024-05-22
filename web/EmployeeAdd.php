<?php
$titel = "Employee";
$Employee = 'active';
include('include/hader.php');
include("conn/connection.php") ;

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Employee' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$y = date("Y");
$m = date("m");
$dat = $y.$m;

$sql = ("SELECT id FROM emp_info ORDER BY id DESC LIMIT 1");
		$query2 = mysql_query($sql);
		$row = mysql_fetch_assoc($query2);
		$old_id = $row['id'];
		if($old_id == ''){
			$emp_id = $dat.'1';
		}
		else{
			$new = $old_id + 1;
			$emp_id = $dat.$new;
		}
?>
<script type="text/javascript">
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
				<form class="stdform" method="post" id="form" action="EmployeeAddquery" name="form" enctype="multipart/form-data">
					<div class="modal-body">
						<p>
							<label>Employee ID </label>
							<span class="field">
								<input type="text" name="e_id" class="input-large" readonly required="" value="<?php echo $emp_id;?>" placeholder="Employee ID" />
							</span>
						</p>
						<p>
							<label>
							Employee Name </label>
							<span class="field">
								<input type="text" name="e_name" id="" class="input-xlarge" required="" placeholder="Employee Name" />
							</span>
						</p>
						<p>
							<label>
							Designation </label>
							<span class="field">
								<input type="text" name="e_des" id="" class="input-xlarge" required="" placeholder="Designation"/>
							</span>
						</p>
						<p>
							<label>Department </label>
							<select class="select-ext-large chzn-select" style="width:540px;" name="e_dept" required="">
								<option value="">Choose Departmen Name </option>
								<?php 	$emp_n="SELECT * FROM department_info WHERE status = '0' order by dept_name asc";	$e_n_ro=mysql_query($emp_n); ?>
								<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
								<option value=" <?php echo $e_n_r['dept_id']?>"> <?php echo $e_n_r['dept_name']?></option>
								<?php } ?>
							</select>
						</p>
						
						<p>
							<label>
							Father's Name </label>
							<span class="field">
							<input type="text" name="e_f_name" id="" class="input-xxlarge" placeholder="Father's Name" />
							</span>
						</p>
						<p>
							<label>
							Mother's Name </label>
							<span class="field">
							<input type="text" name="e_m_name" id="" class="input-xxlarge" placeholder="Mother's Name" />
							</span>
						</p>
						<p>
							<label>
							Date of Birth </label>
							<span class="field">
							<input type="text" name="e_b_date" id="" class="input-xxlarge datepicker" placeholder="YYYY-MM-DD"/>
							</span>
						</p>
						<p>
							<label>
							Joining Date </label>
							<span class="field">
							<input type="text" name="e_j_date" id="" class="input-xxlarge datepicker" placeholder="YYYY-MM-DD"/>
							</span>
						</p>
						<p>
							<label>Gender </label>
							<span class="field">
								<input type="radio" id="male" value="Male" name="e_gender"/>
								Male &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; 
								<input type="radio" id="female" value="Female" name="e_gender"/>
								Female 
							</span>
						</p>
						<p>
							<label>
							Marital Status </label>
							<span class="field">
							<input type="radio" id="Unmarried" value="Unmarried" name="married_stu"/>
							Unmarried &nbsp; &nbsp; &nbsp; &nbsp; <input type="radio" id="Married" value="Married" name="married_stu"/>
							Married </span>
						</p>
						<p>
							<label>Blood Group </label>
							<span class="field">
								<select style="width:540px;" class="select-ext-large chzn-select" name="bgroup"/>
									<option value="">Choose Blood Group</option>
									<option value="AB+">AB+</option>
									<option value="AB-">AB-</option>
									<option value="A+">A+</option>
									<option value="A-">A-</option>
									<option value="B+">B+</option>
									<option value="B-">B-</option>
									<option value="O+">O+</option>
									<option value="O-">O-</option>
								</select> 
							</span>
						</p>
						<p>
							<label>National ID</label>
							<span class="field">
							<input type="text" name="n_id" id="" class="input-xxlarge" placeholder=""/>
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
										<select style="text-align: center;" class="select-x-large" name="a"/>
											<option value="">Choose a Degree </option>
											<option value="SSC">Secondary School Certificate (S.S.C) </option>
											<option value="HSC">Higher Secondary Certificate (H.S.C) </option>
											<option value="Graduation">Graduation </option>
											<option value="Masters">Masters </option>
											<option value="">Other's </option>
										</select>
									</td>
									<td>
										<input type="text" name="b" id="" class="input-x-large"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="c" id="cgpa"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d"/>
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<select style="text-align: center;" class="select-x-large" name="a1">
											<option value=""> Choose a Degree </option>
											<option value="SSC"> Secondary School Certificate (S.S.C) </option>
											<option value="HSC"> Higher Secondary Certificate (H.S.C) </option>
											<option value="Graduation"> Graduation </option>
											<option value="Masters"> Masters </option>
											<option value=""> Other's </option>
										</select>
									</td>
									<td>
										<input type="text" name="b1" id="" class="input-x-large"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="c1" id="cgpa2" onblur="click_cgpa2()"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d1">
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<select style="text-align: center;" class="select-x-large" name="a2"/>
											<option value=""> Choose a Degree </option>
											<option value="SSC"> Secondary School Certificate (S.S.C) </option>
											<option value="HSC"> Higher Secondary Certificate (H.S.C) </option>
											<option value="Graduation"> Graduation </option>
											<option value="Masters"> Masters </option>
											<option value=""> Other's </option>
										</select>
									</td>
									<td>
										<input type="text" name="b2" id="" class="input-x-large"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="c2" id="cgpa3"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d2">
									</td>
									<td>
									</td>
								</tr>
								<tr>
									<td>
										<select style="text-align: center;" class="select-x-large" name="a3">
											<option value=""> Choose a Degree </option>
											<option value="SSC"> Secondary School Certificate (S.S.C) </option>
											<option value="HSC"> Higher Secondary Certificate (H.S.C) </option>
											<option value="Graduation"> Graduation </option>
											<option value="Masters"> Masters </option>
											<option value=""> Other's </option>
										</select>
									</td>
									<td>
										<input type="text" name="b3" onchange="updateinto4()" class="input-x-large">
									</td>
									<td>
										<input class="input-medium" type="text" name="c3" id="cgpa4"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d3">
									</td>
									<td id="AddMore">
										<input type="button" class="btn-primary" value="+" onclick="add_extra_field()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add">
									<td>
										<input type="text" style="text-align: center;" class="select-x-large" name="a4">
									</td>
									<td>
										<input type="text" name="b4" onchange="updateinto5()" class="input-x-large">
									</td>
									<td>
										<input class="input-medium" type="text" name="c4" id="cgpa5"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d4">
									</td>
									<td id="add1">
										<input type="button" class="btn-primary" value="+" onclick="add_extra_field1()">
										<input type="button" class="btn-primary" value="-" onclick="remove_extra_field1()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add21">
									<td>
										<input type="text" style="text-align: center;" class="select-x-large" name="a5">
									</td>
									<td>
										<input type="text" name="b5" class="input-x-large">
									</td>
									<td>
										<input class="input-medium" type="text" name="c5" id="cgpa6"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d5">
									</td>
									<td id="add22">
										<input type="button" class="btn-primary" value="+" onclick="add_extra_field2()">
										<input type="button" class="btn-primary" value="-" onclick="remove_extra_field2()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add31">
									<td>
										<input type="text" style="text-align: center;" class="select-x-large" name="a6">
									</td>
									<td>
										<input type="text" name="b6" onchange="updateinto7()" class="input-x-large">
									</td>
									<td>
										<input class="input-medium" type="text" name="c6" id="cgpa7"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d6">
									</td>
									<td id="add32">
										<input type="button" class="btn-primary" value="+" onclick="add_extra_field3()">
										<input type="button" class="btn-primary" value="-" onclick="remove_extra_field3()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add41">
									<td>
										<input type="text" style="text-align: center;" class="select-x-large" name="a7">
									</td>
									<td>
										<input type="text" name="b7" class="input-x-large">
									</td>
									<td>
										<input class="input-medium" type="text" name="c7" id="cgpa8"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d7">
									</td>
									<td id="add42">
										<input type="button" class="btn-primary" value="+" onclick="add_extra_field4()">
										<input type="button" class="btn-primary" value="-" onclick="remove_extra_field4()">
									</td>
								</tr>
								<tr style="display:none;inline-block;" id="add51">
									<td>
										<input type="text" style="text-align: center;" class="select-x-large" name="a8">
									</td>
									<td>
										<input type="text" name="b8" class="input-x-large">
									</td>
									<td>
										<input class="input-medium" type="text" name="c8" id="cgpa9"/>
									</td>
									<td>
										<input class="input-medium" type="text" name="d8">
									</td>
									<td id="add52">
										<input type="button" class="btn-primary" value="-" onclick="remove_extra_field5()">
									</td>
								</tr>
							</table>
						</center>
						<p>
							<label>First Experience </label>
							<span class="field">
								<textarea type="text" name="exp1" id="" class="input-xxlarge"/></textarea>
							</span>
						</p>
						<p>
							<label>Second Experience </label>
							<span class="field">
								<textarea type="text" name="exp2" id="" class="input-xxlarge"/></textarea>
							</span>
						</p>
						<p>
							<label>Third Experience </label>
							<span class="field">
								<textarea type="text" name="exp3" id="" class="input-xxlarge"/></textarea>
							</span>
						</p>
						<h4 class="h44">Employee Salary & Deductions</h4>
						<p> <h4>Salary & Allowances</h4> </p> 
						<p>
							<label style="font-weight: bold;">	Basic Salary* </label>
							<span class="field">
								<input type="text" name="basic_salary" id="" style="font-weight: bold;width:10%;" onChange="updatesum()" required=""/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Mobile Bill </label>
							<span class="field">
								<input type="text" name="mobile_bill" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	House Rent </label>
							<span class="field">
								<input type="text" name="house_rent" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Medical </label>
							<span class="field">
								<input type="text" name="medical" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Food </label>
							<span class="field">
								<input type="text" name="food" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Others </label>
							<span class="field">
								<input type="text" name="others" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Net Gross Salary </label>
							<span class="field">
								<input type="text" name="gross_total" id="" readonly style="font-size: 20px;color: red;font-weight: bold;width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p> <h4>Deductions</h4> </p> 
						<p>
							<label>	Provident Fund </label>
							<span class="field">
								<input type="text" name="provident_fund" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Professional Tax </label>
							<span class="field">
								<input type="text" name="professional_tax" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						<p>
							<label>	Income Tax </label>
							<span class="field">
								<input type="text" name="income_tax" id="" style="width:10%;" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly />
							</span>
						</p>
						
						<h4 class="h44">Employee Contact Information </h4>
						<p>
							<label>Present Address</label>
							<span class="field">
								<textarea type="text" name="pre_address" id="" class="input-xxlarge"></textarea>
							</span>
						</p>
						<p>
							<label>Permanent Address</label>
							<span class="field">
								<textarea type="text" name="per_address" id="" class="input-xxlarge"></textarea>
							</span>
						</p>
						<p> Contact Info </p>
						<p>
							<label>
							Personal Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_per" id="" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>
							Office Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_office" id="" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>
							Family Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_family" id="" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>
							First Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact1" id="" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>
							Second Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact2" id="" class="input-xxlarge"/>
							</span>
						</p>
						<p>
							<label>
							Email </label>
							<span class="field">
							<input type="text" name="email" id="" class="input-xxlarge" placeholder="abcd@example.com"/>
							</span>
						</p>
						<p>
							<label>
							Skype </label>
							<span class="field">
							<input type="text" name="skype" id="" class="input-xxlarge" placeholder="skype username"/>
							</span>
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