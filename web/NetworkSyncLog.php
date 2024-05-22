<?php
$titel = "Network Synchronization Log";
$Network = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$mk_id = isset($_GET['id']) ? $_GET['id']  : '';
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($job_id != ''){
	$sql = mysql_query("SELECT n.id, n.job_id, n.mk_id, m.Name AS mkname, n.c_id, c.c_name, c.cell, z.z_name, n.mk_con_sts, n.ap_con_sts, n.mk_package, n.ap_package, n.mk_mac, n.ap_mac, n.mk_ip, n.ap_ip, n.password, n.action, DATE_FORMAT(n.sync_date, '%D %M, %Y') AS sync_date, DATE_FORMAT(n.sync_time, '%r') AS sync_time, DATE_FORMAT(n.date_time, '%D %M, %Y %r') AS date_time, e.e_name AS empname, e.e_id AS empid, n.sync_by, n.sync_name FROM network_sync_log AS n
												LEFT JOIN mk_con AS m ON m.id = n.mk_id
												LEFT JOIN clients AS c ON c.c_id = n.c_id 
												LEFT JOIN zone AS z ON c.z_id = z.z_id 
												LEFT JOIN emp_info AS e ON e.e_id = n.sync_by 
												WHERE n.sts = '0' AND n.job_id = '$job_id' ORDER BY n.id DESC");
												
	$sqlsconsts = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'con_sts' AND job_id = '$job_id'");
	$sqlspackage = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'package' AND job_id = '$job_id'");
	$sqlsip = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'ip' AND job_id = '$job_id'");
	$sqlsmac = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'mac' AND job_id = '$job_id'");
	$sqlspassword = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'password' AND job_id = '$job_id'");
	$sqlsrestor = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'restor_clients' AND job_id = '$job_id'");
	
	$totalsync = mysql_num_rows($sql);
	$constssync = mysql_num_rows($sqlsconsts);
	$packagesync = mysql_num_rows($sqlspackage);
	$ipsync = mysql_num_rows($sqlsip);
	$macsync = mysql_num_rows($sqlsmac);
	$passwordsync = mysql_num_rows($sqlspassword);
	$restorsync = mysql_num_rows($sqlsrestor);
	
	$tit = "<div class='box-header'>
				<div class='hil'> Total Sync:  <i style='color: #317EAC'>{$totalsync}</i></div> 
				<div class='hil'> Restored:  <i style='color: blue'>{$restorsync}</i></div> 
				<div class='hil'> Status:  <i style='color: #30ad23'>{$constssync}</i></div> 
				<div class='hil'> Package: <i style='color: #e3052e'>{$packagesync}</i></div> 
				<div class='hil'> IP: <i style='color: #f66305'>{$ipsync}</i></div>
				<div class='hil'> MAC: <i style='color: #f66305'>{$macsync}</i></div>
				<div class='hil'> Password: <i style='color: #f66305'>{$passwordsync}</i></div>
			</div>";
}
else{
	if($mk_id != ''){
		$sql = mysql_query("SELECT n.id, n.job_id, n.mk_id, m.Name AS mkname, n.c_id, c.c_name, z.z_name, c.cell, n.mk_con_sts, n.ap_con_sts, n.mk_package, n.ap_package, n.mk_mac, n.ap_mac, n.mk_ip, n.ap_ip, n.password, n.action, DATE_FORMAT(n.sync_date, '%D %M, %Y') AS sync_date, DATE_FORMAT(n.sync_time, '%r') AS sync_time, DATE_FORMAT(n.date_time, '%D %M, %Y %r') AS date_time, e.e_name AS empname, e.e_id AS empid, n.sync_by, n.sync_name FROM network_sync_log AS n
													LEFT JOIN mk_con AS m ON m.id = n.mk_id
													LEFT JOIN clients AS c ON c.c_id = n.c_id 
													LEFT JOIN emp_info AS e ON e.e_id = n.sync_by 
													LEFT JOIN zone AS z ON c.z_id = z.z_id 
													WHERE n.sts = '0' AND n.mk_id = '$mk_id' ORDER BY n.id DESC");
													
		$sqlsconsts = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'con_sts' AND mk_id = '$mk_id'");
		$sqlspackage = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'package' AND mk_id = '$mk_id'");
		$sqlsip = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'ip' AND mk_id = '$mk_id'");
		$sqlsmac = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'mac' AND mk_id = '$mk_id'");
		$sqlspassword = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'password' AND mk_id = '$mk_id'");
		$sqlsrestor = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'restor_clients' AND mk_id = '$mk_id'");
	}
	else{
		$sql = mysql_query("SELECT n.id, n.job_id, n.mk_id, m.Name AS mkname, n.c_id, c.c_name, c.cell, z.z_name, n.mk_con_sts, n.ap_con_sts, n.mk_package, n.ap_package, n.mk_mac, n.ap_mac, n.mk_ip, n.ap_ip, n.password, n.action, DATE_FORMAT(n.sync_date, '%D %M, %Y') AS sync_date, DATE_FORMAT(n.sync_time, '%r') AS sync_time, DATE_FORMAT(n.date_time, '%D %M, %Y %r') AS date_time, e.e_name AS empname, e.e_id AS empid, n.sync_by, n.sync_name FROM network_sync_log AS n
													LEFT JOIN mk_con AS m ON m.id = n.mk_id
													LEFT JOIN clients AS c ON c.c_id = n.c_id 
													LEFT JOIN emp_info AS e ON e.e_id = n.sync_by 
													LEFT JOIN zone AS z ON c.z_id = z.z_id 
													WHERE n.sts = '0' ORDER BY n.id DESC");
													
		$sqlsconsts = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'con_sts'");
		$sqlspackage = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'package'");
		$sqlsip = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'ip'");
		$sqlsmac = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'mac'");
		$sqlspassword = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'password'");
		$sqlsrestor = mysql_query("SELECT id FROM network_sync_log WHERE sync_name = 'restor_clients'");
	}
	
	$totalsync = mysql_num_rows($sql);
	$constssync = mysql_num_rows($sqlsconsts);
	$packagesync = mysql_num_rows($sqlspackage);
	$ipsync = mysql_num_rows($sqlsip);
	$macsync = mysql_num_rows($sqlsmac);
	$passwordsync = mysql_num_rows($sqlspassword);
	$restorsync = mysql_num_rows($sqlsrestor);
	
	$tit = "<div class='box-header'>
				<div class='hil'> Total Sync:  <i style='color: #317EAC'>{$totalsync}</i></div> 
				<div class='hil'> Restored:  <i style='color: blue'>{$restorsync}</i></div> 
				<div class='hil'> Status:  <i style='color: #30ad23'>{$constssync}</i></div> 
				<div class='hil'> Package: <i style='color: #e3052e'>{$packagesync}</i></div> 
				<div class='hil'> IP: <i style='color: #f66305'>{$ipsync}</i></div>
				<div class='hil'> MAC: <i style='color: #f66305'>{$macsync}</i></div>
				<div class='hil'> Password: <i style='color: #f66305'>{$passwordsync}</i></div>
			</div>";
}
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" href="Network"><i class="iconfa-arrow-left"></i> Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-rss"></i></div>
        <div class="pagetitle">
            <h1>Network Sync History</h1>
        </div>
    </div><!--pageheader-->		<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>			
	<div class="box box-primary">
		<div class="box-header">
			<h5><?php echo $tit;?></h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">ID</th>
                            <th class="head0">Date</th>
							<th class="head1 center">Mikrotik</th>
							<th class="head0">Client/Zone</th>
							<th class="head1 center">Sync By</th>
							<th class="head1 center">Sync Type</th>
							<th class="head0">Sync Details</th>
                            <th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['sync_name'] == 'package'){
										$syncname = 'Package Changed';
										$colorrr = "style='color: #e3052e;font-weight: bold;font-size: 15px;text-align: center;vertical-align: middle;'";
									}
									elseif($row['sync_name'] == 'con_sts'){
										$syncname = 'Status Changed';
										$colorrr = "style='color: #30ad23;font-weight: bold;font-size: 15px;text-align: center;vertical-align: middle;'";
									}
									elseif($row['sync_name'] == 'ip'){
										$syncname = 'IP Stored';
										$colorrr = "style='color: #f66305;font-weight: bold;font-size: 15px;text-align: center;vertical-align: middle;'";
									}
									elseif($row['sync_name'] == 'mac'){
										$syncname = 'MAC Stored';
										$colorrr = "style='color: #f66305;font-weight: bold;font-size: 15px;text-align: center;vertical-align: middle;'";
									}
									elseif($row['sync_name'] == 'restor_clients'){
										$syncname = 'Restor Client';
										$colorrr = "style='color: blue;font-weight: bold;font-size: 15px;text-align: center;vertical-align: middle;'";
									}
									else{
										$syncname = 'Password Stored';
										$colorrr = "style='color: #f66305;font-weight: bold;font-size: 15px;text-align: center;vertical-align: middle;'";
									}
									
									if($row['sync_by'] == 'Auto'){
										$syncby = '<b style="color: red;text-transform: uppercase;">['.$row['sync_by'].' Sync]</b>';
									}
									else{
										$syncby = '<b>'.$row['empname'].'</b><br>'.$row['empid'];
									}
									
									echo
										"<tr class='gradeX'>
											<td {$colorrr}' class='center'>{$row['id']}</td>
											<td style='font-weight: bold;vertical-align: middle;'>{$row['sync_date']}<br>{$row['sync_time']}</td>
											<td class='center' style='vertical-align: middle;'>{$row['mkname']}</td>
											<td><b style='font-weight: bold;font-size: 13px;vertical-align: middle;'>{$row['c_id']} ({$row['c_name']})</b><br>{$row['z_name']}</td>
											<td class='center' style='vertical-align: middle;'>{$syncby}</td>
											<td {$colorrr}>{$syncname}</td>
											<td style='font-weight: bold;padding: 15px 10px;'>{$row['action']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='#' data-original-title='Delete' class='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()'><i class='iconfa-trash'></i></a></li>
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
            "aaSortingFixed": [[0,'desc']],
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
</script><script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>