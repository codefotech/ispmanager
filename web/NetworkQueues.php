<?php
$titel = "Queues All Clients";
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
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
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
								$arrID = $API->comm('/queue/simple/getall');
								$ssss = count($arrID);
}

$queryaaaa = mysql_query("SELECT COUNT(id) AS totlclients FROM clients WHERE mk_id = '$mk_id'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$totlclients = $rowaaaa['totlclients'];

?>
	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="fa iconfa-dashboard"></i></div>
        <div class="pagetitle">
            <h1>Queues Clients</h1>
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
							<th class="head0">ID/Name/Cell</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Bandwidth</th>
							<th class="head1">Deadline</th>
                            <th class="head0">IP</th>
							<th class="head1">Rx/Tx</th>
							<th class="head0 center">MissMatch</th>
							<th class="head1 center">Status</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
								$arrID = $API->comm('/queue/simple/getall');
								foreach($arrID as $x => $x_value) {
									
									$target=$x_value['target'];
									$targetip=strtok("$target", '/');
									
									//$API->write('/ip/arp/print', false);
									//$API->write('?address='.$targetip);
									//$res=$API->read(true);

									//$mac = $res[0]['mac-address']; 
									
									$queue = array();
									$queue['queueUp'] = explode('/',$x_value['max-limit'])[0];
									$queue['queueDown'] = explode('/',$x_value['max-limit'])[1];
									
									$mk_upload = $queue['queueUp'] / 1000000;
									$mk_download = $queue['queueDown'] / 1000000;
									$mkdownloadupload = $mk_upload.'M/'.$mk_download.'M';
									
									$queue['realupload'] = explode('/',$x_value['bytes'])[0];
									$queue['realdownload'] = explode('/',$x_value['bytes'])[1];
									
									$mk_real_upload = $queue['realupload'] / 1000000;
									$mk_real_download = $queue['realdownload'] / 1000000;
									$mkrealdownloadupload = $mk_real_upload.'M/'.$mk_real_download.'M';
									
									$aaaaa = $x_value['name'];
									$sql44 = mysql_query("SELECT c.c_name, c.c_id, c.payment_deadline, m.Name, p.mk_profile, c.raw_download, c.raw_upload, c.p_id, p.p_name, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, c.ip, c.mac FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												WHERE c.c_id = '$aaaaa' ORDER BY c.ip ASC");
									$rows1 = mysql_fetch_assoc($sql44);
									
									$app_download = $rows1['raw_download'];
									$app_upload = $rows1['raw_upload'];
									$bothdownloadupload = $app_upload.'M/'.$app_download.'M';
									
									$download = $rows1['raw_download'] * 1000000;
									$upload = $rows1['raw_upload'] * 1000000;
									$downloadupload = $upload.'/'.$download;
									
									$sqlcon = mysql_query("SELECT s.c_id, s.con_sts, DATE_FORMAT(s.update_date, '%D %M %Y') AS update_date, s.update_time, s.update_by, e.e_name FROM con_sts_log AS s 
									LEFT JOIN emp_info AS e ON e.e_id = s.update_by
									WHERE s.c_id = '$aaaaa' AND s.con_sts = 'inactive' ORDER BY s.id DESC LIMIT 1");
									$rowcon = mysql_fetch_assoc($sqlcon);
									
									if($rows1['c_name'] == ''){
										$colorrrr = 'style="color: red;"'; 
										$qqqqq = "
										<li>
										<form action='MkToQueTis' method='post' target='_blank' enctype='multipart/form-data'>
											<input type='hidden' name='mk_id' value='{$mk_id}'/> 
											<input type='hidden' name='breseller' value='1'/> 
											<input type='hidden' name='c_id' value='{$aaaaa}'/> 
											<input type='hidden' name='c_name' value='{$aaaaa}'/> 
											<input type='hidden' name='ip' value='{$targetip}'/>
											<input type='hidden' name='raw_upload' value='{$mk_upload}'/>
											<input type='hidden' name='raw_download' value='{$mk_download}'/>
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
											<input type='hidden' name='entry_by' value='{$e_id}'/>
											<input type='hidden' name='calculation' value='Manual'/>
											<button class='btn col3'><i class='iconfa-plus'></i></button>
										</form></li>"; 
										$adssss = 'Not found in application databse';
										$bbbbb = 'User not found';
										$dddd = "";
										}
										else{
 
											$qqqqq = "<a data-placement='top' data-rel='tooltip' href='ClientView?id=".$rows1['c_id']."' data-original-title='View Client' target='_blank' class='btn col1'><i class='fa iconfa-eye-open'></i></a>";
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
												
												if($x_value['max-limit'] != $downloadupload){
													$colorrrr = 'style="color: red;"'; 
													$pppp = 'Application Bandwidth ('.$bothdownloadupload.') and Mikrotik Bandwidth ('.$mkdownloadupload.') are not same.';
													$packchng = "
															<li>
															<form action='MkToTisBandwidth' method='post' target='_blank' enctype='multipart/form-data'>
																<input type='hidden' name='mk_id' value='{$mk_id}'/> 
																<input type='hidden' name='c_id' value='{$aaaaa}'/> 
																<input type='hidden' name='mk_profile' value='{$bothdownloadupload}'/>
																<button class='btn col3'><i class='iconfa-signout'></i></button>
															</form>
															</li>";
												}
												if($x_value['max-limit'] == $downloadupload){
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
											}
											
									
									echo "<tr class='gradeX'>
											<td $colorrrr><b>" . $aaaaa . "</b><br> ". $rows1['c_name'] ."<br> ". $rows1['cell'] ."</td>
											<td>" . $rows1['z_name'] ." <br> ". $rows1['address'] ."</td>
											<td $colorrrr>" . $bothdownloadupload ." <br> ". $mk_upload .'M/'.$mk_download."M</td>
											<td>" . $rows1['payment_deadline'] ."</td>
											<td $colorrrr><b>" . $targetip ." <br> ". $rows1['mac'] ."</b></td>
											<td $colorrrr><b>" . $x_value['bytes'] ."</b></td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr $colorrrrq><b>".$adssss."</b></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$bbbbb."".$dddd."</b></li>
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li $colorrrr><b>".$qqqqq."".$packchng."</b></li>
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
            "aaSortingFixed": [[4,'asc']],
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