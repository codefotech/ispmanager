<?php
$titel = "Network";
$Network = 'active';
include('include/hader.php');
include("mk_api.php");
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Network' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$sql2 ="SELECT id FROM mk_con ORDER BY id DESC LIMIT 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$idz = $row2['id'];
$n_id = $idz + 1;

if($inactive_way_sts == '0'){
	$secretsync = "NetworkPPPSecretSync";
}
else{
	$secretsync = "NetworkPPPSecretSyncInactive";
}


$sql3 = mysql_query("SELECT id, MAX(total_active) AS total_active, DATE_FORMAT(date_time, '%d-%b, %H:%i') AS datetime FROM mk_active_count WHERE date_time >= DATE_SUB(NOW(), INTERVAL 3 DAY) GROUP BY YEAR(date_time), MONTH(date_time), DAY(date_time), HOUR(date_time), MINUTE(date_time) DIV 10 ORDER BY datetime ASC");

$myurl3[]="['Date','Total Online']";
while($r3=mysql_fetch_assoc($sql3)){
	
	$datetime = $r3['datetime'];
	$totaactive = $r3['total_active'];
	$myurl3[]="['".$datetime."',".$totaactive."]";
}
?>

<!-- -------------------------------------------------------------------------------------------------- -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl3));?>
        ]);

        var options = {
		title: '..::Total Online Clients Count::..',
		  chartArea:{width:'95%'},
		  height: 200,
		  fontSize: 9,
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));

        chart.draw(data, options);
      }
    </script>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="NetworkAddQuery">
	<input type="hidden" name="add_by" value="<?php echo $e_id; ?>" />
	<input type="hidden" name="add_date_time" value="<?php echo date("Y-m-d H:i:s");?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Mikrotik</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Network Name*</div>
						<div class="col-2"><input type="text" name="Name" id="" placeholder="Mikrotik-1 or Mikrotik-2 etc" class="input-xlarge" required="" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Public IP Address*</div>
						<div class="col-2"><input type="text" name="ServerIP" id="" placeholder="Mikrotik Public IP" class="input-xlarge" required="" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Mikrotik Login*</div>
						<div class="col-2"><input type="text" name="mk_username" placeholder="Login Username" required="" style="width: 180px;"/></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Mikrotik Password*</div>
						<div class="col-2"><input type="password" name="mk_pass" style="width: 180px;" placeholder="Login Password" size="12" required="" /></div>
					</div>
					<div class="popdiv" style="height: 20px;">
						<div class="col-1" style="">Auto MK Sync?</div>
						<div class="col-2">
							<input type="radio" name="auto_client_mk_sts" value="1"> Yes &nbsp; &nbsp;
							<input type="radio" name="auto_client_mk_sts" value="0" checked="checked"> No &nbsp; &nbsp;
						</div>
					</div>
					<div class="popdiv" style="height: 20px;">
						<div class="col-1" style="">Auto Sync?</div>
						<div class="col-2">
							<input type="radio" name="auto_sync_sts" value="1"> Yes &nbsp; &nbsp;
							<input type="radio" name="auto_sync_sts" value="0" checked="checked"> No &nbsp; &nbsp;
						</div>
					</div>
					
					<div class="popdiv" style="height: 20px;">
						<div class="col-1">Active Graph?</div>
						<div class="col-2">
							<input type="radio" name="graph" value="1"> Yes &nbsp; &nbsp;
							<input type="radio" name="graph" value="0" checked="checked"> No &nbsp; &nbsp;
						</div>
					</div>
					<div class="popdiv" style="height: 20px;">
						<div class="col-1">Web Port No</div>
						<div class="col-2"><input type="text" name="web_port" placeholder="IP>Services>www" style="width: 120px;"/></div>
					</div>
					
					<div class="popdiv">
						<div class="col-1">Note</div>
						<div class="col-2"><textarea type="text" name="note" id="" placeholder="Optional" class="input-xlarge"/></textarea></div>
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
			<?php if($userr_typ == 'mreseller'){} 
		else{ ?>
			<a class="btn ownbtn1" href="NetworkSyncLog"><i class="fa iconfa-random"></i> Sync Log</a>
			<a class="btn ownbtn2" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Add Mikrotik</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-rss"></i></div>
        <div class="pagetitle">
            <h1>Network</h1>
        </div>
    </div><!--pageheader-->
	<?php if($sts == 'delete') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong>	<?php echo $titel;?> Successfully Deleted in Your System.
	</div><!--alert-->
	<?php } if($sts == 'sync_done') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!! </strong> Synchronization Done With Application VS Mikrotik.			
	</div><!--alert-->
	<?php } if($sts == 'add') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
	</div><!--alert-->
	<?php } if($sts == 'edit') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.
	</div><!--alert-->
	<?php } ?>		
		
		<div class="box box-primary">
			<div class="box-header">
				Network List
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">Mikrotik ID</th>
							<th class="head1">Name</th>
                            <th class="head0 center">Status</th>
							<th class="head1 center">OWN | Reseller</th>
							<th class="head0 center">Details</th>
							<th class="head1 center">Users</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						$sql = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h, add_date_time, note, graph, online_sts, auto_sync_sts, auto_client_mk_sts, DATE_FORMAT(last_synced, '%D %b-%y %h:%i%p') AS last_synced FROM mk_con WHERE sts = '0' ORDER BY id ASC");
						$tot_mk = mysql_num_rows($sql);
								while( $row = mysql_fetch_assoc($sql) )
								{	
									$maikro_id = $row['id'];
									$online_stss = $row['online_sts'];
									$Pass= openssl_decrypt($row['Pass'], $row['e_Md'], $row['secret_h']);
									$API = new routeros_api();
									$API->debug = false;
									if ($API->connect($row['ServerIP'], $row['Username'], $Pass, $row['Port'])) {
										$ico = "<span class='label label-success' style='font-size: 12px;font-weight: bold;border-radius: 7px;margin: 12px 0;padding: 8px 7px;'>Connected</span>";
										$ARRAY = $API->comm("/system/resource/print");
										$first = $ARRAY['0'];
										if($cpu_load == '0'){
											$details = $first['platform']." ".$first['board-name']." ".$first['version']." ".$first['architecture-name']." <br> " .$first['uptime'];
										}
										else{
											$details = $first['platform']." ".$first['board-name']." ".$first['version']." ".$first['architecture-name']." <br> " .$first['uptime']." <br> ".$first['cpu-load']."%";
										}
										$colorrr = "style='color: #555555;'";
								 if($cpu_load == '0'){ ?>
<script> $(document).ready(function() {$("#responsecontainer<?php echo $row['id'];?>").load("NetworkLoad.php?id=<?php echo $row['id'];?>"); var refreshId = setInterval(function() {$("#responsecontainer<?php echo $row['id'];?>").load("NetworkLoad.php?id=<?php echo $row['id'];?>");}, <?php echo $cpu_interval.'000';?>);$.ajaxSetup({ cache: true });});</script>
<script> $(document).ready(function() {$("#responsecontainera<?php echo $row['id'];?>").load("AutoActiveClientsCount2.php?id=<?php echo $row['id'];?>"); var refreshId = setInterval(function() {$("#responsecontainera<?php echo $row['id'];?>").load("AutoActiveClientsCount2.php?id=<?php echo $row['id'];?>");}, <?php echo $cpu_interval.'000';?>);$.ajaxSetup({ cache: true });});</script>
								<?php 
								}		
									if($active_queue == '1'){
										$mk_con_sts = "<table style='width: 100%;'>
														<tbody>
														<tr>
															<td class='center' style='border-right: none;border-left: none;'>
																<ul class='tooltipsample'>
																	<li><form action='{$secretsync}' method='post' onclick='return checkSync()'><input type='hidden' name='sync_by' value='{$e_id}' /><input type='hidden' name='restor_clients' value='No' /><input type='hidden' name='sts_sync' value='Yes' /><input type='hidden' name='mac_sync' value='Yes' /><input type='hidden' name='ip_sync' value='Yes' /><input type='hidden' name='wayyyyy' value='network' /><input type='hidden' name='pack_sync' value='Yes' /><input type='hidden' name='pass_sync' value='Yes' /><input type='hidden' name='mk_id' value='{$row['id']}' /><button class='btn ownbtn3' title='Sync PPPoE with Application' style='padding: 6px 9px;'><i class='iconfa-refresh'></i></button></form></li>
																	<li><a data-placement='top' data-rel='tooltip' href='NetworkPPPSecret?id={$row['id']}' data-original-title='PPP Clients' class='btn ownbtn6' title='PPPoE Secret' style='padding: 6px 9px;'><i class='fa iconfa-sitemap'></i></a></li>
																	<li><a data-placement='top' data-rel='tooltip' href='NetworkActiveConniction?id={$row['id']}' data-original-title='Active Connictions' class='btn ownbtn5' title='Active Connictions' style='padding: 6px 9px;'><i class='fa iconfa-eye-open'></i></a></li>
																</ul>
															</td>
														</tr>
														<tr>
															<td class='center' style='border-right: none;border-left: none;'>
																<ul class='tooltipsample'>
																	<li><form action='NetworkQueuesSync' method='post' onclick='return checkSync1()'><input type='hidden' name='sync_by' value='{$e_id}' /><input type='hidden' name='restor_clients' value='No' /><input type='hidden' name='sts_sync' value='Yes' /><input type='hidden' name='wayyyyy' value='network' /><input type='hidden' name='pack_sync' value='Yes' /><input type='hidden' name='mk_id' value='{$row['id']}' /><button class='btn ownbtn12' title='Sync Queues with Application' style='padding: 6px 9px;'><i class='iconfa-refresh'></i></button></form></li>
																	<li><a data-placement='top' data-rel='tooltip' href='NetworkQueues?id={$row['id']}' title='Queues Clients' class='btn ownbtn6' style='padding: 6px 9px;'><i class='fa iconfa-dashboard'></i></a></li>
																	<li><a data-placement='top' data-rel='tooltip' href='NetworkArp?id={$row['id']}' title='ARP List' class='btn ownbtn5' style='padding: 6px 9px;'><i class='fa iconfa-screenshot'></i></a></li>
																</ul>
															</td>
														</tr>
														</tbody>
													</table>";
									}
									else{
										$mk_con_sts = "<ul class='tooltipsample'>
														<li><form action='{$secretsync}' method='post' onclick='return checkSync()'><input type='hidden' name='sync_by' value='{$e_id}' /><input type='hidden' name='restor_clients' value='No' /><input type='hidden' name='sts_sync' value='Yes' /><input type='hidden' name='mac_sync' value='Yes' /><input type='hidden' name='ip_sync' value='Yes' /><input type='hidden' name='wayyyyy' value='network' /><input type='hidden' name='pack_sync' value='Yes' /><input type='hidden' name='pass_sync' value='Yes' /><input type='hidden' name='mk_id' value='{$row['id']}' /><button class='btn ownbtn3' title='Sync with Application' style='padding: 6px 9px;'><i class='iconfa-refresh'></i></button></form></li>
														<li><a data-placement='top' data-rel='tooltip' href='NetworkPPPSecret?id={$row['id']}' data-original-title='PPP Clients' class='btn ownbtn6' title='PPPoE Secret' style='padding: 6px 9px;'><i class='fa iconfa-sitemap'></i></a></li>
														<li><a data-placement='top' data-rel='tooltip' href='NetworkActiveConniction?id={$row['id']}' data-original-title='Active Connictions' class='btn ownbtn5' title='Active Connictions' style='padding: 6px 9px;'><i class='fa iconfa-eye-open'></i></a></li>
													</ul>";
									}
									if($online_stss == '1'){
										$query12312rr ="update mk_con set online_sts = '0' WHERE id = '$maikro_id'";
										$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error() . "<br />");
									}
									else{}
									$mk_offlinecounter = 0;
									}
									else{
										$ico = "<span class='label label-important' style='font-size: 12px;font-weight: bold;border-radius: 7px;margin: 12px 0;padding: 8px 7px;'>Disconnected</span>";
										$details = "Mikrotik Not Connected. Please check.";
										$colorrr = "style='color: red;'";
										$mk_con_sts = '';
										
									$mk_offlinecounter = 1;
									if($online_stss == '0'){
										$query12312rr ="update mk_con set online_sts = '1' WHERE id = '$maikro_id'";
										$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error() . "<br />");
									}
									else{}
									}
									$mk_offlinecounterr += $mk_offlinecounter;
									
									if($row['graph'] == '1'){
										$graphh = "<a style='font-weight: bold;text-transform: uppercase;border-radius: 5px;font-size: 12px;' class='label label-success'>On</a>";
									}
									else{
										$graphh = "<a style='font-weight: bold;text-transform: uppercase;border-radius: 5px;font-size: 12px;' class='label label-important'>Off</a>";
									}
									
									if($row['auto_client_mk_sts'] == '1'){
										$autooooc = "<a style='font-weight: bold;text-transform: uppercase;border-radius: 5px;font-size: 12px;' class='label label-success'>ON</a>";
									}
									else{
										$autooooc = "<a style='font-weight: bold;text-transform: uppercase;border-radius: 5px;font-size: 12px;' class='label label-important'>OFF</a>";		
									}
									
									if($row['auto_sync_sts'] == '1'){
										$autoooo = "<a style='font-weight: bold;text-transform: uppercase;border-radius: 5px;font-size: 12px;' class='label label-success'>ON</a>";
										if($row['last_synced'] == ''){
											$lastsync = "<b style='font-size: 11px;line-height: 16px;color: #999;float: right;'>[Will Sync Soon]</b>";
										}
										else{
											$lastsync = "<b style='font-size: 11px;line-height: 16px;color: #999;float: right;'>[Sync at ".$row['last_synced']."]</b>";
										}
									}
									else{
										$autoooo = "<a style='font-weight: bold;text-transform: uppercase;border-radius: 5px;font-size: 12px;' class='label label-important'>OFF</a>";		
										$lastsync = '';											
									}
									
									$queryaaaad = mysql_query("SELECT COUNT(id) AS totalclients FROM clients WHERE mk_id = {$row['id']} AND sts = '0'");
									$rowaaaad = mysql_fetch_assoc($queryaaaad);
									$totalclients_no_del = $rowaaaad['totalclients'];
									
									$queownaad = mysql_query("SELECT COUNT(id) AS totalclients FROM clients WHERE mk_id = {$row['id']} AND sts = '0' AND mac_user = '0'");
									$rowowaad = mysql_fetch_assoc($queownaad);
									$totown_clients = $rowowaad['totalclients'];
									
									$total_reseler_clients = $totalclients_no_del - $totown_clients;
									
									$queownaadssrd = mysql_query("SELECT COUNT(id) AS totalclients FROM clients WHERE mk_id = {$row['id']} AND sts = '0' AND con_sts = 'Active'");
									$rowowaadddrd = mysql_fetch_assoc($queownaadssrd);
									$totr_actived_clients = $rowowaadddrd['totalclients'];
									
									$queownaadssr = mysql_query("SELECT COUNT(id) AS totalclients FROM clients WHERE mk_id = {$row['id']} AND sts = '0' AND mac_user = '1' AND con_sts = 'Active'");
									$rowowaadddr = mysql_fetch_assoc($queownaadssr);
									$totr_active_clients = $rowowaadddr['totalclients'];
									
									$total_reseller_inactive = $total_reseler_clients - $totr_active_clients;
									
									$queownaadss = mysql_query("SELECT COUNT(id) AS totalclients FROM clients WHERE mk_id = {$row['id']} AND sts = '0' AND mac_user = '0' AND con_sts = 'Active'");
									$rowowaaddd = mysql_fetch_assoc($queownaadss);
									$totown_active_clients = $rowowaaddd['totalclients'];
									
									$total_inactive_clients = $totown_clients - $totown_active_clients;
									
									$queryaaaa = mysql_query("SELECT COUNT(id) AS totalclients FROM clients WHERE mk_id = {$row['id']}");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$totalclients = $rowaaaa['totalclients'];
									if($totalclients == '0'){
										$aaa = "<form action='NetworkDelete' method='post' style='margin-top: 8px;' onclick='return checkDelete()'><input type='hidden' name='id' value='{$row['id']}'/><input type='hidden' name='e_id' value='{$e_id}'/><button class='btn ownbtn4' title='Delete' style='padding: 6px 9px;'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaa = '';
									}
										echo
											"<tr class='gradeX' $colorrr>
												<td class='center' style='vertical-align: middle;'><b style='font-size: 20px;'>{$row['id']}</b></td>
												<td><b style='font-size: 17px;'>{$row['Name']}</b><br><b>{$details}</b><br><a id='responsecontainer{$row['id']}'></a><br></td>
												<td class='center' style='vertical-align: middle;'>{$ico}</td>
												<td style='font-family: RobotoRegular, Helvetica Neue, Helvetica, sans-serif;padding: 0px;'>
													<table style='width: 100%;'>
														<tbody>
															<tr>
																<td style='width: 50%;border-left: 0;line-height: 20px;'><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$totown_active_clients}<br><b style='color: red;font-weight: bold;line-height: 16px;'>Inactive:</b> {$total_inactive_clients}<br><b style='font-weight: bold;line-height: 16px;'>Total:</b> {$totown_clients}</td>
																<td style='width: 50%;border-right: 0;line-height: 20px;'><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$totr_active_clients}<br><b style='color: red;font-weight: bold;line-height: 16px;'>Inactive:</b> {$total_reseller_inactive}<br><b style='font-weight: bold;line-height: 16px;'>Total:</b> {$total_reseler_clients}</td>
															</tr>
															<tr>
																<td colspan='2' style='font-weight: bold;border-right: 0;font-size: 15px;text-align: center;vertical-align: middle;'><a style='color:#ec1f27a8;'>{$totr_actived_clients}</a> | <a style='color:#00a65a;' id='responsecontainera{$row['id']}'></a></td>
															</tr>
														</tbody>
													</table>
												</td>
												<td style='font-family: RobotoRegular, Helvetica Neue, Helvetica, sans-serif;'><b>IP: </b>{$row['ServerIP']}@{$row['Username']}<br><b>Graph: </b>{$graphh}<br><b>A.MK Sync: </b>{$autooooc}<br><b>Auto Sync: </b>{$autoooo}{$lastsync}<br></td>											
												<td class='center' style='vertical-align: middle;'>
													{$mk_con_sts}
												</td>
											
												<td class='center' style='vertical-align: middle;'>
													<ul class='tooltipsample'>
														<li><a data-placement='top' data-rel='tooltip' href='NetworkSyncLog?id={$row['id']}' data-original-title='' class='btn ownbtn1' title='Synchronization Log' style='padding: 6px 9px;'><i class='fa iconfa-random'></i></a></li>
														<li><form action='NetworkEdit' method='post'><input type='hidden' name='n_id' value='{$row['id']}'/><button class='btn ownbtn2' title='Edit' style='padding: 6px 9px;'><i class='iconfa-edit'></i></button></form></li>
														<li><form action='NetworkImportClientsOnebyOneOwn' method='post'><input type='hidden' name='mk_id' value='{$row['id']}'/><button class='btn ownbtn4' title='Import Own Clients' style='padding: 6px 9px;'><i class='iconfa-plus'></i></button></form></li>
														<li>{$aaa}</li>
													</ul>
												</td>
											</tr>\n";
									
								}
						
							if($tot_mk == $mk_offlinecounterr){
								$query12312 ="update app_config set onlineclient_sts = '0'";
								$resuldfsdt = mysql_query($query12312) or die("inser_query failed: " . mysql_error() . "<br />");
							}
							else{
								$query12312 ="update app_config set onlineclient_sts = '1'";
								$resuldfsdt = mysql_query($query12312) or die("inser_query failed: " . mysql_error() . "<br />");
							}
							?>
					</tbody>
				</table>
			</div>	
			<br>
			<br>
			<div id="chart_div3" style="text-align: center; height: 510px; width: 100%;border: 0px solid #00A65A;float: left;"><br><br></div>
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
    });
</script>
<style>
#dyntable_length{display: none;}
</style>
<script language="JavaScript" type="text/javascript">
function checkSync(){
    return confirm('Sync Mikrotik Secret with Application!!  Are you sure?');
}

function checkSync1(){
    return confirm('Sync Mikrotik Queues with Application!!  Are you sure?');
}
</script>