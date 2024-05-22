<?php
$titel = "Network Device List";
$NetworkTree = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'NetworkTree' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
			<?php if($tree_sts_permission == '0'){ ?><a class="btn ownbtn3" href="NetworkTreeMap">Map View</a><?php } ?>
			<a class="btn ownbtn2" href="ClientsOnMap" target='_blank'>Clients On Map</a>
			<a class="btn ownbtn3" href="NetworkDeviceOnMap" target='_blank'>Device On Map</a>
			<a class="btn ownbtn1" href="NetworkTree">Diagram View</a>
			<a class="btn ownbtn2" href="NetworkTreeAdd">Add Device</a>
        </div>
        <div class="pageicon"><i class="iconfa-sitemap"></i></div>
        <div class="pagetitle">
            <h1>Device List</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
					<h5>All Device List</h5>
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
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr class="newThead">
							<th class="head1">Device ID</th>
                            <th class="head0">Name/Type</th>
							<th class="head0">Total Port/Core</th>
                            <th class="head0">ID-Source/Uplink(Port)</th>							
							<th class="head1">Fiber Code</th>
							<th class="head1">Zone</th>
                            <th class="head0">Location</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
					if($user_type == 'admin' || $user_type == 'superadmin'){
						$sql = mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.in_port, n.latitude, n.longitude, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, t.name AS sourcename, n.location, z.z_id, z.z_name, c.onu_mac, c.c_name, n.c_id, a.distance_km, a.distance_miles FROM network_tree AS n 
												LEFT JOIN device AS d ON d.id = n.device_type
												LEFT JOIN zone AS z ON z.z_id = n.z_id
												LEFT JOIN network_tree AS t ON t.tree_id = n.parent_id
												LEFT JOIN clients AS c ON c.c_id = n.c_id
                                                LEFT JOIN network_tree_polyline AS a ON a.tree_id = n.tree_id
												WHERE n.sts = '0' AND n.device_sts = '0' AND n.tree_id != '0' ORDER BY n.tree_id DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									$queryaaaa = mysql_query("SELECT COUNT(tree_id) AS activeclient FROM network_tree WHERE parent_id = '{$row['tree_id']}'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$sfdsfs = $rowaaaa['activeclient'];
									
									if($sfdsfs == '0' && $row['c_id'] == ''){
										$aaa = "<form action='NetworkTreeDelete' method='post'><input type='hidden' name='tree_id' value='{$row['tree_id']}' /><button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaa = '';
									}
									if($row['c_id'] == ''){
										$bbb = "<form action='NetworkTreeEdit' method='post'><input type='hidden' name='c_id' value='' /><input type='hidden' name='t_id' value='{$row['tree_id']}' /><button class='btn ownbtn1' style='padding: 6px 9px;'><i class='iconfa-edit'></i></button></form>";
										$ccc = "<b style='font-weight: bold;font-size: 18px;'>{$row['name']}</b><br>{$row['d_name']}";
									}
									else{
										$bbb = "<form action='NetworkTreeEdit' method='post'><input type='hidden' name='c_id' value='{$row['c_id']}' /><input type='hidden' name='t_id' value='{$row['tree_id']}' /><button class='btn ownbtn1' style='padding: 6px 9px;'><i class='iconfa-edit'></i></button></form>";
										$ccc = "<b style='font-weight: bold;font-size: 18px;'>{$row['name']}</b><br>{$row['d_name']} - {$row['onu_mac']}<br>{$row['c_name']}";
									}
									if($row['location'] == '' && $row['latitude'] != '' && $row['longitude'] != ''){
										$ddd = "{$row['latitude']}, {$row['longitude']}";
										$view_btn = "<form action='NetworkTreeMap' method='post'><input type='hidden' name='tree_id' value='{$row['tree_id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></button></form>";
									}
									elseif($row['location'] != '' && $row['latitude'] == '' && $row['longitude'] == ''){
										$ddd = "{$row['location']}";
										$view_btn = "";
									}
									elseif($row['location'] != '' && $row['latitude'] != '' && $row['longitude'] != ''){
										$ddd = "{$row['location']} <br> {$row['latitude']}, {$row['longitude']}";
										$view_btn = "<form action='NetworkTreeMap' method='post'><input type='hidden' name='tree_id' value='{$row['tree_id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></button></form>";
									}
									else{
										$ddd = "";
										$view_btn = "";
									}
									
									if($row['distance_km'] != ''){
										$rote_distence = '<br><b>'.$row['distance_km'].' | '.$row['distance_miles'].'</b>';
									}
									else{
										$rote_distence = '';
									}
										echo
											"<tr class='gradeX'>
												<td style='font-size: 18px;font-weight: bold;color: #555;vertical-align: middle;text-align: center;'>{$row['tree_id']}</td>
												<td>{$ccc}</td>
												<td>{$row['out_port']}</td>
												<td>{$row['parent_id']} - <b>{$row['sourcename']}</b> ({$row['in_port']})</td>												
												<td>{$row['fiber_code']}</td>
												<td>{$row['z_name']}</td>
												<td>{$ddd}{$rote_distence}</td>
												<td class='center'>
												<ul class='tooltipsample' style='padding: 10px 0;'>
													<li>{$view_btn}</li>
													<li>{$bbb}</li>
													<li>{$aaa}</li>
												</ul>
											</td>
											</tr>\n ";
								}
						
						}
							?>
					</tbody>
				</table>
			</div>			

		</div>
<?php
}
else{
	header("Location:/index");
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