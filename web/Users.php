<?php
$titel = "Users";
$Users = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$type = isset($_GET['type']) ? $_GET['type'] : '';
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Users' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$query="SELECT * FROM user_typ ORDER BY u_des";
$result=mysql_query($query);

if($type == '' || $type == 'all'){
	$sql = mysql_query("SELECT l.id, l.user_name, l.password, l.e_id, l.user_id, l.email, l.user_type, l.log_sts, l.image, u.u_des FROM login AS l LEFT JOIN user_typ AS u ON u.u_type = l.user_type WHERE l.status = '0' AND l.id != '10' AND l.e_id != '$e_id'");
	$tabletitel = 'All Users';
}
elseif($type == 'employee'){
	$sql = mysql_query("SELECT l.id, l.user_name, l.password, l.e_id, l.user_id, l.email, l.user_type, l.log_sts, l.image, u.u_des FROM login AS l LEFT JOIN user_typ AS u ON u.u_type = l.user_type WHERE l.user_type != 'superadmin' AND l.user_type != 'client' AND l.user_type != 'mreseller' AND l.user_type != 'breseller' AND l.user_type != 'agent' AND l.status = '0' AND l.id != 10");
	$tabletitel = 'Employee';
}
elseif($type == 'client'){
	$sql = mysql_query("SELECT l.id, l.user_name, l.password, l.e_id, l.user_id, l.email, l.user_type, l.log_sts, l.image, u.u_des FROM login AS l LEFT JOIN user_typ AS u ON u.u_type = l.user_type LEFT JOIN clients AS c ON c.c_id = l.user_id WHERE l.user_type = '$type' AND l.status = '0' AND l.id != '10' AND c.mac_user != '1'");
	$tabletitel = 'Client';
}
else{
	$sql = mysql_query("SELECT l.id, l.user_name, l.password, l.e_id, l.user_id, l.email, l.user_type, l.log_sts, l.image, u.u_des FROM login AS l LEFT JOIN user_typ AS u ON u.u_type = l.user_type WHERE l.user_type = '$type' AND l.status = '0' AND l.id != '10'");
	if($type == 'mreseller'){
		$tabletitel = 'Mac Reseller';
	}
	elseif($type == 'breseller'){
		$tabletitel = 'Bandwidth Reseller';
	}
	else{
		$tabletitel = 'Client';
	}
}

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="UserNameChangeQuery">
	<input type="hidden" name="change_by" value="<?php echo $e_id;?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Change Client/Reseller User Name</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Client</div>
							<select class="select-ext-large chzn-select" style="width:280px;" name="old_c_id" required="">
								<option value="">Choose Client/Reseller</option>
								<?php 	$emp_n="SELECT c.com_id, c.c_id, c.c_name, z.z_name FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' ORDER BY com_id ASC";	$e_n_ro=mysql_query($emp_n); ?>
								<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
								<option value="<?php echo $e_n_r['c_id'];?>"> <?php echo $e_n_r['com_id'];?> - <?php echo $e_n_r['c_id'];?> - <?php echo $e_n_r['c_name'];?></option>
								<?php } ?>
								<?php 	$emp_nnn="SELECT l.user_name, l.e_id, l.user_id, z.z_name FROM login AS l LEFT JOIN zone AS z ON z.e_id = l.e_id WHERE l.user_type = 'mreseller' AND l.log_sts = '0' AND l.status = '0' ";
										$e_n_rodd=mysql_query($emp_nnn); ?>
								<?php while ($e_n_rww=mysql_fetch_array($e_n_rodd)) { ?>
								<option value="<?php echo $e_n_rww['user_id'];?>"> <?php echo $e_n_rww['e_id'];?> - <?php echo $e_n_rww['user_id'];?> - <?php echo $e_n_rww['user_name'];?></option>
								<?php } ?>
							</select>
					</div>
					<div class="popdiv">
						<div class="col-1">New User Name</div>
						<div class="col-2"><input type="text" name="c_id" id="name" placeholder="User id must be at least 3 characters long" class="input-xlarge" required="" /><br><span id="result" style="font-weight: bold;"></span></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Note</div>
						<div class="col-2"><input type="text" name="note" id="" placeholder="" class="input-xlarge"/></div>
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
        <div class="searchbar">
				<div class="input-append">
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid <?php if($type == '' || $type == 'all'){echo '#8b00ff;color: #8b00ff;';} elseif($type == 'employee'){echo 'GREEN;color: GREEN;';} elseif($type == 'client'){echo '#ea11d2;color: #ea11d2;';} elseif($type == 'mreseller'){echo '#028795;color: #028795;';} else{echo '#716d6d;color: #716d6d;';}?>font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"><?php if($type == '' || $type == 'all'){ ?>All Users<?php } else{ echo $tabletitel;}?> <span class="caret" style="border-top: 4px solid #8b00ff;"></span></button>
						<ul class="dropdown-menu" style="min-width: 95px;border-radius: 0px 0px 5px 5px;">
								<li <?php if($type == '' || $type == 'all'){echo 'style="display: none;"';}?>><a href="Users?type=all" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #8b00ff;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Show All Users List">All Users</a></li>
								<li <?php if($type == 'employee'){echo 'style="display: none;"';}?>><a href="Users?type=employee" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: GREEN;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Employees Users List">Employee</a></li>
								<li <?php if($type == 'client'){echo 'style="display: none;"';}?>><a href="Users?type=client" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ea11d2;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Users List">Clients</a></li>
								<li <?php if($type == 'mreseller'){echo 'style="display: none;"';}?>><a href="Users?type=mreseller" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #028795;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Mac Reseller List">Mac Reseller</a></li>
								<li <?php if($type == 'breseller'){echo 'style="display: none;"';}?>><a href="Users?type=breseller" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #716d6d;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Bandwidth Reseller List">Bandwidth Reseller</a></li>
						</ul>
					</div>
				</div>
			<a class="btn ownbtn4" href="#myModal" data-toggle="modal"> Change UserName</a>
			<a class="btn ownbtn2" href="UserAddView"><i class="iconfa-plus"></i> Add User </a>
        </div>
        <div class="pageicon"><i class="iconfa-group"></i></div>
        <div class="pagetitle">
            <h1>Users</h1>
        </div>
    </div><!--pageheader-->
	
		<?php if($sts == 'delete') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.
			</div><!--alert-->
		<?php } if($sts == 'add') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
			</div><!--alert-->
		<?php } if($sts == 'change') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> User Name Successfully Change from <strong><?php echo $old_c_idd;?></strong> to <strong><?php echo $new_c_id;?></strong> in Your System.
			</div><!--alert-->
		<?php } if($sts == 'Lock0') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Locked in Your System.
			</div><!--alert-->
		<?php } if($sts == 'Lock1') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Unlocked in Your System.
			</div><!--alert-->
		<?php } if($sts == 'edit') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.
			</div><!--alert-->
		<?php } ?>
		
		<div class="box box-primary">
			<div class="box-header">
				<?php echo $tabletitel;?>
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1">Employee/Client ID</th>
                            <th class="head0">User Name</th>
							<th class="head1">Employee/Client Name</th>
							<th class="head0">User Type</th>
							<th class="head1">Email</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['log_sts'] == '0'){
										$aa = 'btn';
										$bb = "<i class='iconfa-unlock'></i>";
										$cc = 'Lock';
									}
									if($row['log_sts'] == '1'){
										$aa = 'btn';
										$bb = "<i class='iconfa-lock pad4'></i>";
										$cc = 'Unlock';
									}
									if($user_type == 'admin' || $user_type == 'superadmin' && $row['log_sts'] == '0') {
										$loginas = "<li><form action='login_exec' method='post'><input type='hidden' name='location_service' value='0'/><input type='hidden' name='username' value='{$row['user_id']}' /><input type='hidden' name='wayy' value='loginasuser' /><input type='hidden' name='passwordd' value='{$row['password']}' /><button class='btn' style='border-radius: 3px;border: 1px solid green;color: green;padding: 6px 9px;' title='Login as {$row['user_name']}'><i class='iconfa-signin'></i></button></form></li>";
									}
									else{
										$loginas = "";
									}
									echo
										"<tr class='gradeX'>
											<td>{$row['e_id']}</td>
											<td>{$row['user_id']}</td>
											<td>{$row['user_name']}</td>
											<td>{$row['u_des']}</td>
											<td>{$row['email']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' style='border-radius: 3px;border: 1px solid #0866c6;color: #0866c6;padding: 6px 9px;' href='UserLock?id={$row['id']}' data-original-title='{$cc}' class='{$aa}'>{$bb}</a></li>
													<li><form action='UserEdit' method='post' title='Edit'><input type='hidden' name='id' value='{$row['id']}' /><button class='btn' style='border-radius: 3px;border: 1px solid #a0f;color: #a0f;padding: 6px 9px;' title='Edit'><i class='iconfa-edit'></i></button></form></li>
													{$loginas}
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
			</div>			
		</div>

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#name").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 3)
  {  
   $("#result").html('checking...');
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