<?php
$titel = "User Access";
$UserAccessPage = 'active';
include('include/hader.php');
extract($_POST);

$e_id = $_SESSION['SESS_EMP_ID'];
//---------- Permission start-----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'UserAccessPage' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission end-----------

$UserType = mysql_query("SELECT * FROM user_typ WHERE u_type != '$user_type' ORDER BY u_des")
?>

		<div class="pageheader">
			<div class="searchbar">
				<a class="btn ownbtn9" href="UserType">User Type</a>
				<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;border: 1px solid green;font-size: 14px;" href="AppSettings">Application Settings</a>
				<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;border: 1px solid red;font-size: 14px;" href="UserAccess">Menu Access</a>
			</div>
			<div class="pageicon"><i class="iconfa-group"></i></div>
			<div class="pagetitle">
				<h1>User Group Advance Access</h1>
			</div>
		</div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="box box-primary" style=" margin: 0px;">
				<div class="box-header">
					<form id="" name="form" class="stdform" method="POST" action="<?php echo $PHP_SELF;?>">	
						<select data-placeholder="Choose User Type" class="chzn-select" style="width:35%;" name="type" onchange="submit();" required="" >
							<option value=""></option>
							<?php while ($row = mysql_fetch_array($UserType)) { ?>
								<option value = "<?php echo $row['u_type']; ?>" <?php if($row['u_type'] == $type){ echo 'selected'; }?> ><?php echo $row['u_des']; ?></option>
							<?php } ?>
						</select>
					</form>
				</div>
				<form class="stdform" method="POST" action="UserAccessPageSave" name="form" enctype="multipart/form-data">
				<input type="hidden" name="type" value="<?php echo $type;?>" required="" />
				<div class="box-body">
					<div class="row-fluid">
                        <div class="span12">
							<div class="accordion">
								
							<?php
								$sqlss = mysql_query("SELECT * FROM module WHERE sts = '0' AND id != '34' AND id != '36' AND id != '57' AND $type IN ('1','2') order by position");
								$i = 1;
								while( $rowssa = mysql_fetch_assoc($sqlss)){
								$x = 1;
								$parent_id = $rowssa['id'];
								$sqlyy = mysql_query("SELECT * FROM module_page WHERE parent_id = '$parent_id' AND sts = '0' order by position");
								?>
									<h2><a href="#" style="color: #ed5565 !important;font-size: 16px;font-weight: bold;padding: 12px 0px 8px 20px;"><b style="color: dimgray;"><?php echo $i.'. ';?></b>&nbsp;&nbsp;<?php echo $rowssa['desc'];?><input type='text' name='pos<?php echo $rowssa['id'];?>' style="width: 10%;text-align: center;font-size: 20px;float: right;margin: -8px 4px 0px 0px;" readonly value='<?php echo $rowssa['position'];?>'/></a>
									</h2>
									<ul class="sidebarlist">
									<?php while( $rowyy = mysql_fetch_assoc($sqlyy)){ ?>
										<li><?php if($rowyy[$type] == '1' || $rowyy[$type] == '0'){ ?><i class="iconfa-angle-right" style="padding: 0px 0 0 35px;font-weight: bold;font-size: medium;"></i><?php } elseif($rowyy[$type] == '2'){ ?><i class="iconfa-angle-right" style="padding: 0px 0 0 35px;font-weight: bold;font-size: medium;"></i><?php } elseif($rowyy[$type] == '-1'){ ?> <i class="iconfa-remove" style="color: red;padding: 0px 0 0 35px;font-weight: bold;font-size: medium;"></i><?php } ?>
										<a style="font-size: 13px;font-weight: bold;padding-left: 5px;"><input type='checkbox' name='module<?php echo $rowyy['id'];?>' value='1' style="padding: 10px 4px 4px 4px !important;" <?php if($rowyy[$type] == 1){echo 'checked="checked"';}elseif($rowyy[$type] == -1){echo 'disabled="disabled"';}elseif($rowyy[$type] == 2){echo 'disabled="disabled" checked="checked"';}?>/> <?php echo $rowyy['module_name'];?>
										<input type='hidden' name='oldper<?php echo $rowyy['id'];?>' value='<?php echo $rowyy[$type];?>' /><input type='hidden' name='per_id<?php echo $rowyy['id'];?>' value='<?php echo $rowyy['id'];?>' /><span><?php echo $rowyy['position'];?></span></a><br>
									<?php $x++;}?> 
									</ul>
								<?php $i++;} ?>
                            </div>
                        </div><!--span6-->
                    </div>
				</div>
				<div class="modal-footer" style="text-align: center;">
				<?php if($type != ''){ ?>
					<button type="submit" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 16px;" style="margin-right: 5%;" onclick="return checkSure()"/>I'm Sure & Submit</button>
				<?php } ?>
				</div>
				</form>
			</div>
		</div>
<?php
}
else{
	echo '<div class="er_msg">You dont have to permetion to access this page</div>';
}
include('include/footer.php');
?>
<style>
ul
{
list-style-type: none;
}
.ui-accordion-content
{
	padding: 2px 60px 5px 30px;
}
</style>
<script language="JavaScript" type="text/javascript">
function checkSure(){
    return confirm('Change Access!!  Are you sure?');
}
</script>