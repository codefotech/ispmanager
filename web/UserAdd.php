<?php
$titel = "User";
$UserAdd = 'active';
include('include/hader.php');
include("conn/connection.php") ;

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Users' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$query="SELECT * FROM user_typ ORDER BY u_des";
$result=mysql_query($query);
?>
<div class="pageheader" style="min-height: auto !important; padding: 10px !important;">
	<ul class="mediamgr_menu">
		<li class="manuli"><a style=" color: #0866C6 !important;" href = "UserAdd" class="btn selectall"><span class="icon-plus"></span> Add Users</a></li>
		<li class="manuli"><a style=" color: #000 !important;" href = "EditUesr" class="btn selectall"><span class="icon-edit"></span> Edit Users</a></li>
		<li class="manuli"><a style=" color: #000 !important;" href = "ViewUser" class="btn selectall"><span class="icon-eye-open"></span> View Users </a></li>
    </ul>
</div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>User Registration Info</h5>
				</div>
				<form id="form2" class="stdform" method="post" action="DepartmentAddquery">
					<div class="modal-body">
						<p>
							<label class="control-label" for="f_name">Name:</label>
							<div class="controls"><input type="text" name="f_name" placeholder="User Full Name" size="50" required="" /></div>
						</p>
						<p>
							<label class="control-label" for="e_id">Employee Id:</label>
							<div class="controls"><input type="text" name="e_id" size="50" placeholder="Ex:12345" required="" /></div>
						</p>
						<p>
							<label class="control-label" for="username">User Name:</label>
							<div class="controls"><input type="text" name="username" size="12" placeholder="" id="username" maxlength="15" required="" /></div>
						</p>
						<p>
							<label class="control-label" for="passid">Password:</label>
							<div class="controls"><input type="password" name="passid" size="12" required="" /></div>
						</p>
						<p>
							<label class="control-label" for="u_type">User Type:</label>
							<div class="controls"><select name="u_type" class="select-lttl" required="" />
								<option value="">Choose User Type</option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
								<option value=<?php echo $row['u_type']?>><?php echo $row['u_des']?></option>
									<?php } ?>
							</select>
							</div>
						</p>
						<p>
							<label class="control-label" for="f_name">Email:</label>
							<div class="controls"><input type="text" name="email" size="50" placeholder="abcd@domain.com" required=""/></div>
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