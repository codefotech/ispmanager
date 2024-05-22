<?php
$titel = "Confirm User";
$Users = 'active';
include('include/hader.php');
include("conn/connection.php");
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Users' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


$query="SELECT * FROM user_typ WHERE u_type != 'mreseller' AND u_type != 'breseller' AND u_type != 'client' AND u_type != 'agent' ORDER BY u_des";
$result=mysql_query($query);

$sql = mysql_query("SELECT e.id, e.e_id, e.e_name, d.dept_name FROM login AS l
					RIGHT JOIN emp_info AS e
					ON e.e_id = l.e_id
					LEFT JOIN department_info AS d
					ON d.dept_id = e.dept_id

					WHERE ISNULL(l.e_id) AND e.`status` = '0' ORDER BY e.e_id ASC");

$sql1 = mysql_query("SELECT * FROM emp_info WHERE id = '$e_id' ");
$rows = mysql_fetch_array($sql1);

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
	<script type="text/javascript">

function checkname()
{
 var name=document.getElementById( "UserName" ).value;
	
 if(name)
 {
  $.ajax({
  type: 'post',
  url: 'checkdata.php',
  data: {
   user_name:name,
  },
  success: function (response) {
   $( '#name_status' ).html(response);
   if(response=="OK")	
   {
    return true;	
   }
   else
   {
    return false;	
   }
  }
  });
 }
 else
 {
  $( '#name_status' ).html("");
  return false;
 }
}

function checkall()
{
 var namehtml=document.getElementById("name_status").innerHTML;
 var emailhtml=document.getElementById("email_status").innerHTML;

 if((namehtml && emailhtml)=="OK")
 {
  return true;
 }
 else
 {
  return false;
 }
}

</script>
	
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Add New User</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>New User Information</h5>
				</div>
				
					<form id="" name="form" class="stdform" method="POST" action="<?php echo $PHP_SELF;?>">
						<div class="modal-body">
							<p>
								<label> Employee Name </label>
								<select data-placeholder="Choose one..." class="chzn-select" id="ddlPassport" style="width:280px;" name="e_id" required="" onchange="submit();">
									<option value="">Choose one</option>
										<?php while ($row = mysql_fetch_array($sql)) { ?>
											<option value ="<?php echo $row['id']; ?>" <?php if($row['id'] == $e_id){echo 'selected';}?> ><?php echo $row['e_name']; ?> (<?php echo $row['dept_name']; ?>)</option>
										<?php } ?>
								</select>
							</p>
					</form>
					<form class="stdform" method="post" action="UserAddQuery" name="form" enctype="multipart/form-data" onsubmit="return checkall();">
						<input type="hidden" value="<?php echo $rows['e_name']; ?>" name="emp_name" />
							<p>
                                <label>Employee Id</label>
                                <span class="field"><input type="text" readonly name="e_id" id="" class="input-xlarge" value="<?php echo $rows['e_id']; ?>"/></span>
                            </p>
							<p>
                                <label>Email</label>
                                <span class="field"><input type="text" readonly name="email" class="input-xlarge" value="<?php echo $rows['email']; ?>" /></span>
                            </p>
							<p>
                                <label>User Name</label>
                                <span class="field"><input type="text" name="username" id="UserName" class="input-xlarge" onkeyup="checkname();">  <a style="color: red;" id="name_status"></a></span>
                            </p>
							<p>
								<label>Password</label>
								<span class="field"><input type="text" name="passid" id="" class="input-xlarge" value="<?php echo $passid; ?>" /></span>
							</p>
							<p>
                                <label>User Type</label>
                                <span class="field">
									<select name="u_type" class="chzn-select"  style="width:280px;" required="" />
										<option value="">Choose User Type</option>
											<?php while ($row=mysql_fetch_array($result)) { ?>
										<option value=<?php echo $row['u_type']?>><?php echo $row['u_des']?></option>
											<?php } ?>
									</select>
								</span>
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