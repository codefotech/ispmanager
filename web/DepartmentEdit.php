<?php
$titel = "Edit Department";
$Employee = 'active';
include('include/hader.php');
include("conn/connection.php");
$id = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Employee' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql = mysql_query("SELECT * FROM department_info WHERE id = '$id'");
$row = mysql_fetch_array($sql);
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-large"></i></div>
        <div class="pagetitle">
            <h1>Edit Department</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Department</h5>
				</div>
				<form id="form" class="stdform" method="post" action="DepartmentEditSave" >
					<div class="modal-body">
						<p>
							<label>Department ID</label>
							<span class="field">
								<div class="controls">	
									<input id="" type="text" readonly name="d_id" class="input-xxlarge" value="<?php echo $row['dept_id'];?>">
								</div>
							</span>
						</p>
						<p>
							<label>Department Name</label>
							<span class="field"><input type="text" name="d_name" id="" placeholder="Write Name in English" class="input-xxlarge" value="<?php echo $row['dept_name']; ?>" /></span>
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