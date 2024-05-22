<?php
$titel = "Edit User";
$Users = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$id = $_GET['id'];
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Users' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql = ("SELECT * FROM login WHERE id = '$id'");
$query = mysql_query($sql);
$row = mysql_fetch_assoc($query);
		$id= $row['id'];
		$user_name= $row['user_name'];
		$e_id = $row['e_id'];
		$user_id = $row['user_id'];
		$password = sha1($row['password']);
		$email= $row['email'];
		$user_types= $row['user_type'];
		$image= $row['image'];
		if($image==''){
			$image = 'emp_images/no_img.jpg';
		}
		
?>
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
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-group"></i></div>
        <div class="pagetitle">
            <h1>Edit User</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit User Informations</h5>
				</div>
				<form class="stdform" method="post" action="UserEditQuery" name="form" enctype="multipart/form-data">
				<input type="hidden" name="id" id="" class="input-xxlarge" value="<?php echo $id; ?>"/>
					<div class="modal-body">
							<p>
                                <label style="font-weight: bold;">Name*</label>
                                <span class="field">
									<input type="text" name="user_name" id="" class="input-xlarge" value="<?php echo $user_name; ?>"/>
								</span>
                            </p>
							<p>
                                <label>User ID</label>
								<span class="field">
									<input type="text" name="e_id" id="" class="input-xlarge" readonly value="<?php echo $e_id; ?>"/>
								</span>
                            </p>
                            <p>
                                <label>User Name</label>
                                <span class="field"><input type="text" name="" readonly id="" class="input-xlarge" value="<?php echo $user_id; ?>"/></span>
                            </p>
							<p>
                                <label style="font-weight: bold;">User Type*</label>
                                <span class="field">
								<?php if($user_types == 'mreseller' || $user_types == 'breseller' || $user_types == 'client' || $user_types == 'agent') {?>
								<input type="text" name="user_type" readonly id="" class="input-xlarge" value="<?php echo $user_types; ?>"/>
								<?php } else{?>
								<select name="user_type" style="width:280px"  class="chzn-select">
									<?php 
									$resultq = mysql_query("SELECT * FROM user_typ WHERE u_type != 'mreseller' AND u_type != 'breseller' AND u_type != 'client' AND u_type != 'agent' ORDER BY u_des ASC");
									while ($rowq=mysql_fetch_array($resultq)) { ?>
									<option value="<?php echo $rowq['u_type']?>" <?php if ($rowq['u_type'] == $user_types) echo 'selected="selected"';?>><?php echo $rowq['u_des']?></option>
									<?php } ?>
								</select>
								<?php } ?>
								</span>
                            </p>
							<p>
                                <label>New Password</label>
                                <span class="field"><input type="password" name="pass1" placeholder="(Optional) New Password" class="input-xlarge" size="50" /></span>
                            </p>
							<p>
                                <label>Retype Password</label>
                                <span class="field"><input type="password" name="pass2" placeholder="(Optional) New Password Again" class="input-xlarge" size="50" /></span>
                            </p>
							<p>
                                <label>Present Image</label>
                                <span class="field"><img src="<?php echo $image; ?>" height="70" width="70" border=0></span>
                            </p>
					</div> 
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>

				</form> <!-- END OF DEFAULT WIZARD -->
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
