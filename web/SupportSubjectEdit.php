<?php
$titel = "Support Subject";
$Support = 'active';
include('include/hader.php');
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$sid = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Support' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql2 ="SELECT * FROM complain_subject WHERE id = '$sid'";

$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$subject = $row2['subject'];

?>
	<div class="pageheader">
        <div class="pageicon"><i class="iconfa-comments-alt"></i></div>
        <div class="pagetitle">
            <h1>Edit Subject</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Support Subject Edit</h5>
				</div>
				<form id="form" class="stdform" method="post" action="SupportSubjectEditQuery" >
				<input type="hidden" name="sid" class="input-xxlarge" value="<?php echo $sid;?>">
					<div class="modal-body">
					<p>
						<label>Subject</label>
						<span class="field"><input id="" type="text" name="subject" class="input-xxlarge" value="<?php echo $subject;?>"></span>
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