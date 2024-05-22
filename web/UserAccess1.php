<?php
$titel = "User Access";
$UserAccess = 'active';
include('include/hader.php');
extract($_POST);

$e_id = $_SESSION['SESS_EMP_ID'];
//---------- Permission start-----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'UserAccess' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission end-----------

$UserType = mysql_query("SELECT * FROM user_typ ORDER BY u_des")
?>

		<div class="pageheader">
			<div class="searchbar">
				<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;border: 1px solid green;font-size: 14px;" href="AppSettings">Application Settings</a>
				<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;border: 1px solid red;font-size: 14px;" href="UserAccessPage">Advance Access</a>
			</div>
			<div class="pageicon"><i class="iconfa-group"></i></div>
			<div class="pagetitle">
				<h1>User Group Menu Access</h1>
			</div>
		</div><!--pageheader-->
		<div class="box-header row-fluid" style="width: 98% !important;">
			<div class="box box-primary" style=" margin: 0px;">
				<div class="box-header">
					<form id="" name="form" class="stdform" method="POST" action="<?php echo $PHP_SELF;?>">	
						<select data-placeholder="Choose one" class="chzn-select" style="width:35%;" name="type" onchange="submit();">
							<option value=""></option>
							<?php while ($row = mysql_fetch_array($UserType)) { ?>
								<option value = "<?php echo $row['u_type']; ?>" <?php if($row['u_type'] == $type){ echo 'selected'; }?> ><?php echo $row['u_des']; ?></option>
							<?php } ?>
						</select>
					</form>
				</div>
				<div class="box-body">
					<form class="stdform" method="POST" action="UserAccessSave" name="form" enctype="multipart/form-data">
						<input type="hidden" name="type" value="<?php echo $type; ?>"/>
						<table id="dyntable" class="table table-bordered responsive">
							<colgroup>
								<col class="con1" />
								<col class="con0" />
								<col class="con1" />
							</colgroup>
							<thead>
								<tr style="font-size: 14px;">
									<th class="head1 center"> SL </th>
									<th class="head0"> Module Name </th>
									<th class="head1"> Page Name </th>
								</tr>
							</thead>
							<tbody class="abcd123">
							
								<?php
							
								$sql = mysql_query("SELECT * FROM module WHERE sts = '0' AND id != '34' order by position");
								$i = 1;
								while( $row = mysql_fetch_assoc($sql)){ ?>
									<tr class='gradeX'>
										<td class='center' style="width: 5%;">
										<input type='hidden' name='posid<?php echo $row['id'];?>' value='<?php echo $row['id'];?>' />
										<input type='text' name='pos<?php echo $row['id'];?>' style="width: 80%;text-align: center;font-size: 17px;" value='<?php echo $row['position'];?>' /></td>
										<td style="width: 200px !important;color: #ed5565;font-size: 14px;text-align: right;font-weight: bold;padding-top: 12px;"><?php echo $row['desc']; ?></td>
										<td style="padding-top: 14px;">
											<input type='hidden' name='id<?php echo $row['id']; ?>' value='<?php echo $row['id']; ?>' />
											<input type='checkbox' style="padding: 10px 4px 4px 4px !important;" name='module<?php echo $row['id']; ?>' value='1' <?php if($row[$type] == 1){echo 'checked="checked"';} ?> />&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
								<?php $i++; } ?>
							</tbody>    
						</table>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
<?php
}
else{
	echo '<div class="er_msg">You dont have to permission to access this page</div>';
}
include('include/footer.php');
?>
