<?php
$titel = "PPP All Clients";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
$mk_id = $_GET['id'];
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
$entry_date = date('Y-m-d', time());
$entry_time = date('H:i:s', time());;

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;
if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/ppp/profile/getall');
								$ssss = count($arrID);
}

$queryaaaa = mysql_query("SELECT COUNT(id) AS totlclients FROM package WHERE sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);
									$totlclients = $rowaaaa['totlclients'];

?>
	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>PPP All Clients</h1>
        </div>
    </div><!--pageheader-->					
	<?php if($sts == 'inactive') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Inactive from Your Mikrotik.			
	</div><!--alert-->
	<?php } if($sts == 'Active') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Activated in Your Mikrotik.			
	</div><!--alert-->
	<?php } if($sts == 'add') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Added in Your Application.			
	</div><!--alert-->
	<?php } if($sts == 'UpdatePack') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! [<?php echo $ccc_id;?>]</strong> Successfully Changed Packeg in Your Mikrotik.			
	</div><!--alert-->
	<?php } ?>
		<div class="box box-primary">
			<div class="box-header" style="font-size: 20px;padding: 15px 0px 2px 15px;">
				[ Mikrotik:  <i style='color: #317EAC'><?php echo "$ssss"; ?></i> ]    
				[ Application:  <i style='color: #317EAC'><?php echo "$totlclients"; ?></i> ]
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
                        <tr  class="newThead">
							<th class="head0">Profile Name</th>
							<th class="head1">Local Address</th>
							<th class="head0">Remote Address</th>
							<th class="head0 center">MissMatch</th>
							<th class="head1 center">Status</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/ppp/profile/getall');
								foreach($arrID as $x => $x_value) {
									
									$aaaaa = $x_value['name'];
									$sql44 = mysql_query("SELECT * FROM package WHERE mk_profile = '$aaaaa' ORDER BY mk_profile DESC");
									$rows1 = mysql_fetch_assoc($sql44);
									
									$sqlcon = mysql_query("SELECT s.c_id, s.con_sts, DATE_FORMAT(s.update_date, '%D %M %Y') AS update_date, s.update_time, s.update_by, e.e_name FROM con_sts_log AS s 
									LEFT JOIN emp_info AS e ON e.e_id = s.update_by
									WHERE s.c_id = '$aaaaa' AND s.con_sts = 'inactive' ORDER BY s.id DESC LIMIT 1");
									$rowcon = mysql_fetch_assoc($sqlcon);
									
									if($rows1['c_name'] == ''){
										$colorrrr = 'style="color: red;"'; 
										$rrrrr = '';
										$qqqqq = "
										<li>
										<form action='MkToTis' method='post' target='_blank' enctype='multipart/form-data'>
											<input type='hidden' name='mk_id' value='{$mk_id}'/> 
											<input type='hidden' name='c_id' value='{$aaaaa}'/> 
											<input type='hidden' name='c_name' value='{$aaaaa}'/> 
											<input type='hidden' name='passid' value='{$x_value['password']}'/>
											<input type='hidden' name='mk_profile' value='{$x_value['profile']}'/>
											<input type='hidden' name='b_date' value='01'/>
											<input type='hidden' name='p_m' value='Cash'/>
											<input type='hidden' name='join_date' value='{$entry_date}'/>
											<input type='hidden' name='con_type' value='Home'/>
											<input type='hidden' name='u_type' value='client'/>
											<input type='hidden' name='connectivity_type' value='Shared'/>
											<input type='hidden' name='con_sts' value='Active'/>
											<input type='hidden' name='cable_type' value='UTP'/>
											<input type='hidden' name='z_id' value='1'/>
											<input type='hidden' name='entry_date' value='{$entry_date}'/>
											<input type='hidden' name='entry_time' value='{$entry_time}'/>
											<button class='btn col3'><i class='iconfa-plus'></i></button>
										</form></li>"; 
										$adssss = 'Not found in application databse';
										$bbbbb = 'User not found';
										$dddd = "";
										}
										else{
 
											$qqqqq = "<a data-placement='top' data-rel='tooltip' href='ClientView?id=".$rows1['c_id']."' data-original-title='View Client' target='_blank' class='btn col1'><i class='fa iconfa-eye-open'></i></a>";
											$fghgdh = $rows1['c_id'];
											
											$sqlc1 = mysql_query("SELECT e_id FROM login WHERE e_id = '$fghgdh'");
											$rowc1 = mysql_fetch_assoc($sqlc1);
											$log_id = $rowc1['e_id'];
											if($log_id == ''){
												$rrrrr = "
												<li><form action='MkToTislog' method='post' target='_blank' enctype='multipart/form-data'>
													<input type='hidden' name='c_id' value='{$aaaaa}'/> 
													<input type='hidden' name='c_name' value='{$aaaaa}'/> 
													<input type='hidden' name='passid' value='{$x_value['password']}'/>
													<input type='hidden' name='z_id' value='{$rows1['z_id']}'/>
													<button class='btn col3'><i class='fa iconfa-check'></i></button>
												</form></li>"; 
											}
											else{
												$rrrrr = '';
											}

											if($x_value['disabled'] == 'false' && $rows1['con_sts'] == 'Active'){
													$clss = 'act';
													$ee = 'Active';
													$wwww = '';
													$colorrrr = '';
													$bbbbb = "<a data-placement='top' data-rel='tooltip' class='btn {$clss}'>{$ee}</a>";
													$dddd = "";
												}
												if($x_value['disabled'] == 'true' && $rows1['con_sts'] == 'Inactive'){
													$clss = 'inact';
													$ee = 'Inactive';
													$colorrrr = 'style="color: red;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = $ee.' in application and Mikrotik Since '.$rowcon['update_date'].' by '.$empname.'.';
													$bbbbb = '';
													$dddd = "<a data-placement='top' data-rel='tooltip' style='color: red;' class='btn {$clss}' onclick='return checksts()'>Inactive</a>";
												}
												if($x_value['disabled'] == 'false' && $rows1['con_sts'] == 'Inactive'){
													$clss = 'inact';
													$ee = 'Inactive';
													$colorrrrq = 'style="color: red;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = $ee.' in application (Since '.$rowcon['update_date'].' by '.$empname.') but Active in Mikrotik.';
													$bbbbb = "<a data-placement='top' data-rel='tooltip' href='NetworkActiveTOInactive?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Inactive him in Mikrotik</a>";
													$dddd = "OR<br><a data-placement='top' data-rel='tooltip' style='color: green;' href='ClientStatus?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Active him in Application</a>";
												}
												
												if($x_value['disabled'] == 'true' && $rows1['con_sts'] == 'Active'){
													$clss = 'inact';
													$ee = 'Active';
													$colorrrr = 'style="color: red;"'; 
													if($rowcon['update_by'] == 'Auto'){$empname = 'Auto';} else{$empname = $rowcon['e_name'];}
													$wwww = 'Inactive in Mikrotik but Active in application';
													$bbbbb = "<a data-placement='top' data-rel='tooltip' style='color: green;' href='NetworkInactiveTOActive?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Active him in Mikrotik</a>";
													$dddd = "OR<br><a data-placement='top' data-rel='tooltip' href='ClientStatus?id=".$aaaaa."' class='btn {$clss}' onclick='return checksts()'>Inactive him in Application</a>";
												}
												
												if($x_value['profile'] != $rows1['mk_profile']){
													$colorrrr = 'style="color: red;"'; 
													$pppp = 'Application Package ('.$rows1['mk_profile'].') and Mikrotik Profile ('.$x_value['profile'].') are not same.';
													$packchng = "
															<li>
															<form action='MkToTisPack' method='post' target='_blank' enctype='multipart/form-data'>
																<input type='hidden' name='mk_id' value='{$mk_id}'/> 
																<input type='hidden' name='c_id' value='{$aaaaa}'/> 
																<input type='hidden' name='mk_profile' value='{$rows1['mk_profile']}'/>
																<button class='btn col3'><i class='iconfa-signout'></i></button>
															</form>
															</li>";
												}
												if($x_value['profile'] == $rows1['mk_profile']){
													$colorrrr = ''; 
													$pppp = '';
													$packchng = '';
												}
												if($wwww == '' && $pppp !=''){
													$adssss = $pppp;
												}
												else
												{
													$adssss = $wwww.'<br>'.$pppp;
												}
												
												if($x_value['remote-address'] != $rows1['ip']){
													$colorrrrip = 'style="color: red;"'; 
													$ppppip = 'Application IP ('.$rows1['ip'].') and Mikrotik IP ('.$x_value['remote-address'].') are not same.';
													$ipchng = "
															<li>
															<form action='MkToTisIp' method='post' target='_blank' enctype='multipart/form-data'>
																<input type='hidden' name='c_id' value='{$aaaaa}'/> 
																<input type='hidden' name='ip' value='{$x_value['remote-address']}'/>
																<button class='btn col2'><i class='fa iconfa-retweet'></i></button>
															</form>
															</li>";
												}
												else{
													$colorrrrip = ''; 
													$ipchng = '';
													$ppppip = '';
												}
											}
											
									
									echo "<tr class='gradeX'>
											<td $colorrrr><b>" . $aaaaa ."</b></td>
											<td>" . $x_value['local-address'] ."</td>
											<td>" . $x_value['remote-address'] ."</td>
										
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr $colorrrrq><b>".$adssss."".$ppppip."</b></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$bbbbb."".$dddd."</b></li>
												</ul>
											</td>
											<td class='center' style='width: 140px;'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$qqqqq.$rrrrr."".$packchng."".$ipchng."</b></li>
												</ul>
											</td>
										</tr>";
									
								}
						}
						else{echo 'Selected Network are not Connected.';}
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
</script><script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>