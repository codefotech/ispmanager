<?php
$titel = "Agent";
$Agent = 'active';
include('include/hader.php');
include("conn/connection.php") ;

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Agent' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" href="Agent"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user-md"></i></div>
        <div class="pagetitle">
            <h1>Add Agent</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add New Agent</h5>
				</div>			
				<form class="stdform" method="post" action="AgentAddquery" name="form" enctype="multipart/form-data">
					<div class="modal-body">
						<p>
							<label>Agent Name* </label>
							<span class="field">
								<input type="text" name="e_name" id="" class="input-xlarge" required="" placeholder="Agent Name" />
							</span>
						</p>
						<p>
						<label>Login Username*</label>
							<input type="text" name="username" id="name" placeholder="User id must be at least 3 characters long" class="input-xlarge" required="" /><span id="result" style="margin-left: 10px; font-weight: bold;"></span>
						</p>
						<p>
							<label class="control-label" for="passid">Login Password*</label>
							<div class="controls"><input type="password" name="passid" class="input-xlarge" size="12" required="" /></div>
						</p>
						<p>
							<label>Send Login Info by SMS</label>
								<span class="formwrapper">
									<input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;
									<input type="radio" name="sentsms" value="No" checked="checked"> No &nbsp; &nbsp;
								</span>
							</p>
						<p>
							<label>Commission in Percent*</label>
							<span class="field"><input type="text" name="com_percent" id="" style="width:10%;" required="" placeholder="Percent Like 10" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='%' readonly /></span>
						</p>
						<p>
							<label>
							Father's Name </label>
							<span class="field">
							<input type="text" name="e_f_name" id="" class="input-xlarge" placeholder="Father's Name" />
							</span>
						</p>
						<p>
							<label>
							Mother's Name </label>
							<span class="field">
							<input type="text" name="e_m_name" id="" class="input-xlarge" placeholder="Mother's Name" />
							</span>
						</p>
						<p>
							<label>
							Date of Birth </label>
							<span class="field">
							<input type="text" name="e_b_date" id="" class="input-xlarge datepicker" placeholder="YYYY-MM-DD"/>
							</span>
						</p>
						<p>
							<label>
							Joining Date </label>
							<span class="field">
							<input type="text" name="e_j_date" id="" class="input-xlarge datepicker" value="<?php echo date('Y-m-d', time());?>" />
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
								<select style="width:240px;" class="select-large chzn-select" name="bgroup"/>
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
							<input type="text" name="n_id" id="" class="input-xlarge" placeholder=""/>
							</span>
						</p>
						<p>
							<label>Present Address</label>
							<span class="field">
								<textarea type="text" name="pre_address" id="" class="input-xlarge"></textarea>
							</span>
						</p>
						<p>
							<label>Permanent Address</label>
							<span class="field">
								<textarea type="text" name="per_address" id="" class="input-xlarge"></textarea>
							</span>
						</p>
						<p>
							<label>
							Personal Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_per" id="" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>
							Office Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_office" id="" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>
							Family Contact No </label>
							<span class="field">
							<input type="text" name="e_cont_family" id="" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>
							First Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact1" id="" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>
							Second Reference No </label>
							<span class="field">
							<input type="text" name="ref_contact2" id="" class="input-xlarge"/>
							</span>
						</p>
						<p>
							<label>
							Email </label>
							<span class="field">
							<input type="text" name="email" id="" class="input-xlarge" placeholder="abcd@example.com"/>
							</span>
						</p>
						<p>
							<label>
							Skype </label>
							<span class="field">
							<input type="text" name="skype" id="" class="input-xlarge" placeholder="skype username"/>
							</span>
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
$(document).ready(function()
{    
 $("#name").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 3)
  {  
   $("#result").html('checking...');
   
   /*$.post("username-check.php", $("#reg-form").serialize())
    .done(function(data){
    $("#result").html(data);
   });*/
   
   $.ajax({
    
    type : 'POST',
    url  : 'username-check.php',
    data : $(this).serialize(),
    success : function(data)
        {
              $("#result").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#result").html('');
  }
 });
 
});
</script>
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