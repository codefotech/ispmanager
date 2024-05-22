<?php
$titel = "User Login Info";
$user_login_report = 'active';
include('include/hader.php');
include("conn/connection.php");

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Users' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
		<div class="searchbar">
		<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
			<a class="btn" onclick='return checkDelete()' href="UserLoginDelete"> Clear All Log </a>
		<?php } else {?>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-laptop"></i></div>
        <div class="pagetitle">
            <h1>User Login History</h1>
        </div>
    </div><!--pageheader-->
		<?php if($sts == 'delete') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
			</div><!--alert-->
		<?php }?>
	<div class="box box-primary">
		<div class="box-header">
			<h5>User Login History</h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive" style="">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
						<col class="con1" />
                        <col class="con0" />
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr style="font-size: 11px;">
                            <th class="head1">ID</th>
                            <th class="head0">User Id</th>
                            <th class="head1">User Name</th>
							<th class="head0">User Type</th>
							<th class="head0">Device</th>
                            <th class="head1">Date</th>
                            <th class="head0">IP</th>
                            <th class="head1">Browser</th>
                            <th class="head0">Latitude</th>
                            <th class="head1">Longitude</th>
                        </tr>
                    </thead>
					<tbody class="abcd123">
						<?php
							$sql = mysql_query("SELECT id, u_id, u_name, u_type, d_type, log_date, u_ip, u_browser, latitude, longitude FROM log_info WHERE status = '0' ORDER BY id DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['id']}</td>
											<td>{$row['u_id']}</td>
											<td>{$row['u_name']}</td>
											<td>{$row['u_type']}</td>
											<td>{$row['d_type']}</td>
											<td>{$row['log_date']}</td>
											<td>{$row['u_ip']}</td>
											<td>{$row['u_browser']}</td>
											<td>{$row['latitude']}</td>
											<td>{$row['longitude']}</td>
										</tr>\n ";
								}  
						?>
					</tbody>    
                </table>
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
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Clear Log!!  Are you sure?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>