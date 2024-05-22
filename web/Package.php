<?php
$titel = "Package";
$Package = 'active';
include('include/hader.php');
include("mk_api.php");
$type = isset($_GET['id']) ? $_GET['id'] : '';
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Package' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$API = new routeros_api();
$API->debug = false;

$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);
$totmk = mysql_num_rows($result11);

$query11e="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11e=mysql_query($query11e);

$result100=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");

if($user_type == 'mreseller'){
	$sql = mysql_query("SELECT p.id, p.p_id, p.p_name, p.mk_profile, p.p_price, p.bandwith, z.z_name, p.p_price_reseller, p.problematic, p.p_name_reseller FROM package AS p LEFT JOIN zone AS z ON z.z_id = p.z_id WHERE p.status = '0' AND p.z_id = '$macz_id' ORDER BY p.p_id ASC");
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: #8b00ff'>Showing All Own Packages | Profiles</i></div> 
			</div>";
}
else{
if($type == 'own'){
	$sql = mysql_query("SELECT p.id, p.p_id, p.p_name, e.mk_id, p.z_id AS resellerzid, p.mk_profile, p.problematic, p.signup_sts, p.p_price, p.mk_id, p.bandwith, z.z_name, e.e_name, p.p_price_reseller, p.p_name_reseller FROM package AS p LEFT JOIN zone AS z ON z.z_id = p.z_id LEFT JOIN emp_info AS e ON e.e_id = z.e_id 
						WHERE p.status = '0' AND p.z_id = '0' ORDER BY p.p_id ASC");
						
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: #044a8e'>Showing All Own Packages | Profiles</i></div> 
			</div>";
}
elseif($type == 'reseller'){
	$sql = mysql_query("SELECT p.id, p.p_id, p.p_name, e.mk_id, p.z_id AS resellerzid, p.mk_profile, p.problematic, p.signup_sts, p.p_price, p.mk_id, p.bandwith, z.z_name, e.e_name, p.p_price_reseller, p.p_name_reseller FROM package AS p LEFT JOIN zone AS z ON z.z_id = p.z_id LEFT JOIN emp_info AS e ON e.e_id = z.e_id 
						WHERE p.status = '0' AND p.z_id != '0' ORDER BY p.p_id ASC");
						
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: green'>Showing All Reseller Packages | Profiles</i></div> 
			</div>";
}
elseif($type == 'problematic'){
	$sql = mysql_query("SELECT p.id, p.p_id, p.p_name, e.mk_id, p.z_id AS resellerzid, p.mk_profile, p.problematic, p.signup_sts, p.p_price, p.mk_id, p.bandwith, z.z_name, e.e_name, p.p_price_reseller, p.p_name_reseller FROM package AS p LEFT JOIN zone AS z ON z.z_id = p.z_id LEFT JOIN emp_info AS e ON e.e_id = z.e_id 
						WHERE p.status = '0' AND p.problematic = '1' ORDER BY p.p_id ASC");
						
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: red'>Showing All Problematic Packages | Profiles</i></div> 
			</div>";
}
else{
	$sql = mysql_query("SELECT p.id, p.p_id, p.p_name, e.mk_id, p.z_id AS resellerzid, p.mk_profile, p.problematic, p.signup_sts, p.p_price, p.mk_id, p.bandwith, z.z_name, e.e_name, p.p_price_reseller, p.p_name_reseller FROM package AS p LEFT JOIN zone AS z ON z.z_id = p.z_id LEFT JOIN emp_info AS e ON e.e_id = z.e_id 
						WHERE p.status = '0' ORDER BY p.p_id ASC");
						
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: #8b00ff'>Showing All Packages | Profiles</i></div> 
			</div>";
}}

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="PackageAdd">
	<input type="hidden" value="resellerpackage" name="wayyy" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">MacReseller Area</h5>
				</div>
				<div class="modal-body">
					<div class="row" style="height: 300px;">
						<div class="popdiv">
							<div class="col-1">Mac Area </div>
							<div class="col-2"> 
								<select data-placeholder="Choose Area" name="z_id" class="chzn-select"  style="width:280px;" onchange="submit();">
									<option value=""></option>
									<?php while ($row00=mysql_fetch_array($result100)) { ?>
											<option value="<?php echo $row00['z_id']?>"><?php echo $row00['z_name']; ?> (<?php echo $row00['resellername']; ?>)</option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal10">
	<form id="form2" class="stdform" method="post" action="PackageAdd">
	<input type="hidden" value="own" name="wayyy" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Network</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Choose Network</div>
							<select data-placeholder="Choose a Network..." id="mk_id" name="mk_id" class="chzn-select" style="width:250px;" required="" onchange="submit();">
								<option value=""></option>
									<?php while ($row11=mysql_fetch_array($result11)) { ?>
								<option value="<?php echo $row11['id']?>"><?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
									<?php } ?>
							</select>
					</div>
				</div>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
		<?php if($userr_typ == 'mreseller'){} 
		else{ ?>
			<div class="input-append" style="margin-right: 2px;">
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid <?php if($type == 'own'){echo '#044a8e;color: #044a8e;';} elseif($type == 'reseller'){echo 'green;color: green;';} elseif($type == 'problematic'){echo 'red;color: red;';} else{echo '#8b00ff;color: #8b00ff;';}?>font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"><?php if($type == 'own'){ echo 'Own Packages';} elseif($type == 'reseller'){ echo 'Reseller Packages';} elseif($type == 'problematic'){ echo 'Problematic Packages';} else{ echo 'All Packages';}?> <span class="caret" style="border-top: 4px solid <?php if($type == 'own'){echo '#044a8e';} elseif($type == 'reseller'){echo '#028795';} elseif($type == 'problematic'){echo 'red';} else{echo '#8b00ff';}?>;"></span></button>
					<ul class="dropdown-menu" style="min-width: 95px;border-radius: 0px 0px 5px 5px;">
						<li <?php if($type == ''){echo 'style="display: none;"';}?>><a href="Package" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #8b00ff;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Show All Packages">All</a></li>
						<li <?php if($type == 'own'){echo 'style="display: none;"';}?>><a href="Package?id=own" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Own Packages">Own</a></li>
						<li <?php if($type == 'reseller'){echo 'style="display: none;"';}?>><a href="Package?id=reseller" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: green;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Reseller Packages">Reseller</a></li>
						<li <?php if($type == 'problematic'){echo 'style="display: none;"';}?>><a href="Package?id=problematic" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: red;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Problematic Packages">Problematic</a></li>
					</ul>
				</div>
			</div>
			<a class="btn ownbtn3" href="#myModal" data-toggle="modal"> Add Reseller Packages</a>
		<?php } if($userr_typ == 'superadmin' || $userr_typ == 'admin'){ if($totmk == '1'){?>
			<a class="btn ownbtn2" href="PackageAdd?mk_id=<?php $row11e=mysql_fetch_assoc($result11e); echo $row11e['id'];?>&wayyy=own" data-toggle="modal">Add Packages</a>
		<?php } if($totmk > '1'){?>
			<a class="btn ownbtn2" href="#myModal10" data-toggle="modal"><i class="iconfa-plus"></i> Add Packages</a>
		<?php } if($totmk == '0'){?>
			<a class="btn ownbtn4" href="Network" data-toggle=""> Please Add Mikrotik First</a>
		<?php }} ?>
        </div>
        <div class="pageicon"><i class="iconfa-tasks"></i></div>
        <div class="pagetitle">
            <h1>Packages | Profiles</h1>
        </div>
    </div><!--pageheader-->				<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				<h5><?php echo $tit;?></h5>
			</div>
			<div class="box-body">
				<table id="dyntable2" class="table table-bordered responsive">
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
                            <th class="head0">Package Name</th>
							<?php if($userr_typ != 'mreseller'){?>
							<th class="head1 center">Profile Name</th>
							<?php }?>
							<th class="head0 center">Company Price</th>
							<th class="head1 center">Company Bandwith</th>
							<th class="head0 center">Reseller Price</th>
							<?php if($userr_typ != 'mreseller'){?>
							<th class="head1 center">Reseller Area</th>
							<th class="head0 center">On Signup?</th>
							<?php }?>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php if($userr_typ == 'mreseller'){
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['p_name_reseller'] == ''){
										$aaa = $row['p_name'];
									}
									else{
										$aaa = $row['p_name_reseller'];
									}
									$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND p_id = '{$row['p_id']}' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$activeclient = $rowaaaa['activeclient'];
									
									$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND p_id = '{$row['p_id']}' AND sts = '0'");
									$rowiii = mysql_fetch_assoc($queryiiiii);

									$inactiveclient = $rowiii['inactiveclient'];
									
									$totalclients = $activeclient + $inactiveclient;
									echo
										"<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;font-size: 18px;font-weight: bold;color: #555;'>{$row['p_id']}</td>
											<td style='vertical-align: middle;'><b style='font-weight: bold;font-size: 18px;'>{$row['p_name']}</b><b style='font-weight: bold;font-size: 14px;'>{$row['p_name_reseller']}</b><br><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$activeclient}<br><b style='color: #b94a48;font-weight: bold;'>Inactive:</b> {$inactiveclient}<br><b style='font-weight: bold;'>Total:</b> {$totalclients}</td>
											<td class='center' style='vertical-align: middle;'><a style='font-size: 18px;font-weight: bold;'>{$row['p_price']} ৳</a></td>
											<td class='center' style='vertical-align: middle;'><b>{$row['bandwith']}</b></td>
											<td class='center' style='vertical-align: middle;'><a style='font-size: 18px;font-weight: bold;'>{$row['p_price_reseller']} ৳</a></td>
											<td class='center'>
												<ul class='tooltipsample' style='padding: 20px 0;'>
													<li><form action='PackageEdit' method='post' method='post' title='Edit'><input type='hidden' name='p_id' value='{$row['p_id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;' title='Edit Package'><i class='iconfa-edit'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
								}  
						}
						else{
								while( $row = mysql_fetch_assoc($sql) )
								{
									$mk_ppro_namee = $row['mk_profile'];
									$problematic_sts = $row['problematic'];
									$packkk_id = $row['id'];
								$sql34 = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND online_sts = '0' AND id = '{$row['mk_id']}'");
									while ($roww = mysql_fetch_assoc($sql34)) {
											$maikro_id = $roww['id'];
											$maikro_Name = $roww['Name'];
											$ServerIP1 = $roww['ServerIP'];
											$Username1 = $roww['Username'];
											$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
											$Port1 = $roww['Port'];
											if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
												$API->write('/ppp/profile/print', false);
												$API->write('?name='.$mk_ppro_namee);
												$res=$API->read(true);
												
												$mk_ppro_name = $res[0]['name'];
											}
									}
									if($mk_ppro_name == $mk_ppro_namee){
										$clientactive = "OK";
										$colorrr = "style='font-size: 15px;'";
										$colorrrrre = "";
										
										if($problematic_sts != '0'){
											$querysdfsd ="UPDATE package SET problematic = '0' WHERE id = '$packkk_id'";
											$resultsdgsd = mysql_query($querysdfsd) or die("inser_query failed: " . mysql_error() . "<br />");
										}
									}
									else{
										$clientactive = "No";
										$colorrr = "style='color: red;font-size: 15px;'";
										$colorrrrre = "style='color: red;'";
										
										if($problematic_sts != '1'){
											$querysdfsd ="UPDATE package SET problematic = '1' WHERE id = '$packkk_id'";
											$resultsdgsd = mysql_query($querysdfsd) or die("inser_query failed: " . mysql_error() . "<br />");
										}
									}
									
									
									$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND p_id = '{$row['p_id']}' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$activeclient = $rowaaaa['activeclient'];
									
									$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND p_id = '{$row['p_id']}' AND sts = '0'");
									$rowiii = mysql_fetch_assoc($queryiiiii);

									$inactiveclient = $rowiii['inactiveclient'];
									
									$totalclients = $activeclient + $inactiveclient;
									
									if($totalclients == '0'){
										$aaa = "<li><form action='PackageDelete' method='post' method='post' title='Delete' onclick='return checkDelete()'><input type='hidden' name='id' value='{$row['p_id']}' /><button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete Package'><i class='iconfa-trash'></i></button></form></li>";
									}
									else{
										$aaa = '';
									}
									if($row['signup_sts'] == '0'){
										$show = 'No';
									}
									else{
										$show = 'Yes';
									}
									if($row['z_name'] != '' && $row['resellerzid'] != '0'){
										$resellermk_id = $row['mk_id'];
										$resellerzid = $row['resellerzid'];
										$querygggp="UPDATE package SET mk_id = '$resellermk_id' WHERE z_id = '$resellerzid'";
										$resultsgsp = mysql_query($querygggp) or die("inser_query failed: " . mysql_error() . "<br />");
									}
									echo
										"<tr class='gradeX' $colorrrrre>
											<td class='center' style='vertical-align: middle;font-size: 18px;font-weight: bold;color: #555;'>{$row['p_id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['p_name']}</b><b style='font-weight: bold;font-size: 14px;'>{$row['p_name_reseller']}</b><br><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$activeclient}<br><b style='color: #b94a48;font-weight: bold;'>Inactive:</b> {$inactiveclient}<br><b style='font-weight: bold;'>Total:</b> {$totalclients}</td>
											<td class='center' style='vertical-align: middle;'><b>{$row['mk_profile']}</b><br><br><b {$colorrr}>[{$clientactive}]</b></td>
											<td class='center' style='vertical-align: middle;'><a style='font-size: 18px;font-weight: bold;'>{$row['p_price']} ৳</a></td>
											<td class='center' style='vertical-align: middle;'><b>{$row['bandwith']}</b></td>
											<td class='center' style='vertical-align: middle;font-size: 16px;'><b>{$row['p_price_reseller']} ৳</b></td>
											<td class='center' style='vertical-align: middle;'><a style='font-size: 15px;font-weight: bold;'>{$row['z_name']} - {$row['e_name']}</a></td>
											<td class='center' style='padding: 30px 30px;'><b style='font-weight: bold;font-size: 17px;'>{$show}</b></td>
											<td class='center' style='vertical-align: middle;width: 80px;'>
												<ul class='tooltipsample'>
													<li><form action='PackageEdit' target='_blank' method='post' method='post' title='Edit'><input type='hidden' name='p_id' value='{$row['p_id']}' /><button class='btn ownbtn2' style='padding: 6px 9px;' title='Edit Package'><i class='iconfa-edit'></i></button></form></li>
													{$aaa}
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
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 20,
			"aaSorting": [[0,'asc']],
            "sScrollY": "1100px"
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