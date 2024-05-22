<?php
$titel = "Zone";
$Zone = 'active';
include('include/hader.php');
$type = isset($_GET['id']) ? $_GET['id'] : '';
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Zone' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($company_division_id != '0'){
	$sqlss1 = mysql_query("SELECT id AS dis_id, name AS dis_name, bn_name AS dis_bn_name, lat, lon, url FROM `districts` WHERE `division_id` = '$company_division_id'");  
	
	if($company_district_id != '0'){
		$sqlss2 = mysql_query("SELECT id AS upz_id, name AS upz_name, bn_name AS upz_bn_name, url FROM `upazilas` WHERE `district_id` = '$company_district_id'");
	}
}

$sql2 ="SELECT z_id FROM zone ORDER BY z_id DESC LIMIT 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$idz = $row2['z_id'];
$z_id = $idz + 1;
if($userr_typ == 'mreseller'){
	$sql = mysql_query("SELECT b.box_id, b.b_name, b.onu, b.location, b.b_port, z.z_name, z.z_id FROM box AS b LEFT JOIN zone AS z ON z.z_id = b.z_id WHERE b.sts = '0' AND z.z_id = '$macz_id' ORDER BY b.box_id DESC");
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: #8b00ff'>Showing All Own Zone</i></div> 
			</div>";
}
else{
if($type == 'own'){
	$sql = mysql_query("SELECT z.z_id, z.z_name, z.z_bn_name, e.e_name, z.p_id, e.e_id, z.emp_id, e.billing_type, e.e_cont_per, e.minimum_day FROM zone AS z 
						LEFT JOIN emp_info AS e	ON e.e_id = z.e_id
						WHERE z.status = '0' AND z.e_id = '' ORDER BY z.z_id asc");
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: #044a8e'>Showing All Own Zone</i></div> 
			</div>";
}
elseif($type == 'reseller'){
	$sql = mysql_query("SELECT z.z_id, z.z_name, z.z_bn_name, e.e_name, z.p_id, e.e_id, z.emp_id, e.billing_type, e.e_cont_per, e.minimum_day FROM zone AS z 
						LEFT JOIN emp_info AS e	ON e.e_id = z.e_id
						WHERE z.status = '0' AND z.e_id != '' ORDER BY z.z_id asc");
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: green'>Showing All Reseller Zone</i></div> 
			</div>";
}
elseif($type == 'manager'){
	$sql = mysql_query("SELECT z.z_id, z.z_name, z.z_bn_name, e.e_name, z.p_id, e.e_id, z.emp_id, e.billing_type, e.e_cont_per, e.minimum_day FROM zone AS z 
						LEFT JOIN emp_info AS e	ON e.e_id = z.e_id
						WHERE z.status = '0' AND z.emp_id != '' ORDER BY z.z_id asc");
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: #ff5400'>Showing All Zone With Manager</i></div> 
			</div>";
}
else{
	$sql = mysql_query("SELECT z.z_id, z.z_name, z.z_bn_name, e.e_name, z.p_id, e.e_id, z.emp_id, e.billing_type, e.e_cont_per, e.minimum_day FROM zone AS z 
						LEFT JOIN emp_info AS e	ON e.e_id = z.e_id
						WHERE z.status = '0' ORDER BY z.z_id asc");
	$tit = "<div class='box-header'>
				<div class='hil'><i style='color: #8b00ff'>Showing All Zone</i></div> 
			</div>";
}}

$qaaaa = mysql_query("SELECT client_array AS client_array FROM mk_active_count WHERE sts = '0' AND client_array != '' ORDER BY id DESC LIMIT 1");
$roaa = mysql_fetch_assoc($qaaaa);
$client_array = $roaa['client_array'];
$all_online_client_array = explode(',', $client_array);
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal111">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="BoxAdd" />
	<input type="hidden" name="way" value="reseller" />
	<input type="hidden" class="input-xlarge" name="z_id" value="<?php echo $macz_id;?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Zone</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Zone Name*</div>
						<div class="col-2"><input type="text" name="b_name" id="" placeholder="Ex: Zone Name" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Location*</div>
						<div class="col-2"><input type="text" name="location" id="" placeholder="Ex: Zone Address" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Total Port</div>
						<div class="col-2"><input type="text" name="b_port" id="" placeholder="Ex: like 8" class="input-large"/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Onu</div>
						<div class="col-2"><input type="text" name="onu" id="" placeholder="Onu Details" class="input-large"/></div>
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ZoneAddxyz">
	<input type="hidden" name="zz_id" value="<?php echo $z_id;?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Zone Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;margin-left: 0px;width: 30%;">Zone Name (English)*</div>
						<div class="col-2"><input type="text" name="z_name" id="" placeholder="Zone Name in English" style="width: 250px;" required="" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="margin-left: 0px;width: 30%;">Zone Name (Bangla)</div>
						<div class="col-2"><input type="text" name="z_bn_name" id="" placeholder="Zone Name in Bangla" style="width: 250px;" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="margin-left: 0px;width: 30%;">Branch Manager</div>
						<div class="col-2">
							<select data-placeholder="Multiple Employee" name="emp_id[]" class="chzn-select" style="width: 360px;" multiple="multiple" tabindex="4">
								<?php $e_n_roo=mysql_query("SELECT e.id, e.e_id, e.e_name FROM emp_info AS e LEFT JOIN login AS l ON l.e_id = e.e_id WHERE e.dept_id != '0' AND e.status = '0' AND l.user_type = 'billing' order by e.e_id");
										while ($e_n_rr=mysql_fetch_array($e_n_roo)) { ?>
								<option value="<?php echo $e_n_rr['e_id'];?>"> <?php echo $e_n_rr['e_name'];?> - <?php echo $e_n_rr['e_id'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="margin-left: 0px;width: 30%;">Branch Packages</div>
						<div class="col-2">
							<select data-placeholder="Multiple Packages" name="p_id[]" class="chzn-select" style="width: 360px;" multiple="multiple" tabindex="4">
								<?php $resultds=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' order by id ASC");
										while ($row1=mysql_fetch_array($resultds)) { ?>
								<option value="<?php echo $row1['p_id']?>"> <?php echo $row1['p_name'];?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
								<?php } ?>
							</select>
						</div>
					</div>
										
					<div class="popdiv">
						<div class="col-1" style="margin-left: 0px;width: 30%;">Thana</div>
						<div class="col-2" style="width: 70%;">
							<?php if($company_division_id == '0' && $company_district_id == '0' || $company_division_id != '0' && $company_district_id == '0'){ ?>
								<a style="font-size: 15px;color: red;font-weight: bold;vertical-align: middle;">[Please Setup Your Division & District First]</a><br>
								<a href="AppSettings?wayyy=Basic Informations" style="font-size: 15px;font-weight: bold;vertical-align: middle;">Go to Settings >> Basic.</a><br>
							<?php } else{ ?>
							<select data-placeholder="Multiple Thana" name="thana[]" class="chzn-select" style="width: 360px;" multiple="multiple" tabindex="4">
								<?php 	while ($rdowdst2=mysql_fetch_array($sqlss2)) { ?>
								<option value="<?php echo $rdowdst2['upz_name']?>"> <?php echo $rdowdst2['upz_name'];?> (<?php echo $rdowdst2['upz_bn_name']; ?>)</option>
								<?php } ?>
							</select>
							<?php } ?>
						</div>
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
		<?php if($userr_typ == 'mreseller'){ ?>
			<a class="btn ownbtn2" href="#myModal111" data-toggle="modal">Add Zone</a>
		<?php	} 
		else{ ?>
			<div class="input-append" style="margin-right: 2px;">
				<div class="btn-group">
					<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid <?php if($type == 'own'){echo '#044a8e;color: #044a8e;';} elseif($type == 'reseller'){echo 'green;color: green;';} elseif($type == 'manager'){echo '#ff5400;color: #ff5400;';} else{echo '#8b00ff;color: #8b00ff;';}?>font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"><?php if($type == 'own'){ echo 'Own Zone';} elseif($type == 'reseller'){ echo 'Reseller Zone';} elseif($type == 'manager'){ echo 'With Manager';} else{ echo 'All Zone';}?> <span class="caret" style="border-top: 4px solid <?php if($type == 'own'){echo '#044a8e';} elseif($type == 'reseller'){echo '#028795';} elseif($type == 'manager'){echo '#ff5400';} else{echo '#8b00ff';}?>;"></span></button>
					<ul class="dropdown-menu" style="min-width: 95px;border-radius: 0px 0px 5px 5px;">
						<li <?php if($type == ''){echo 'style="display: none;"';}?>><a href="Zone" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #8b00ff;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Show All Zone">All Zone</a></li>
						<li <?php if($type == 'own'){echo 'style="display: none;"';}?>><a href="Zone?id=own" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Own Zone">Own Zone</a></li>
						<li <?php if($type == 'reseller'){echo 'style="display: none;"';}?>><a href="Zone?id=reseller" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: green;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Reseller Zone">Reseller Zone</a></li>
						<li <?php if($type == 'manager'){echo 'style="display: none;"';}?>><a href="Zone?id=manager" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ff5400;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Zone With Manager">With Manager</a></li>
					</ul>
				</div>
			</div>
			<a class="btn ownbtn3" href="Box">Sub-Zone</a>
			<a class="btn ownbtn2" href="#myModal" data-toggle="modal">Add Zone</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Zone</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				<h5><?php echo $tit;?></h5>
			</div>
			<div class="box-body">
				<table id="dyntable2" class="table table-bordered responsive">
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
						<?php if($userr_typ == 'mreseller') {?>	
							<th class="head0 center">Zone ID</th>
                            <th class="head1">Zone Name</th>
							<th class="head0">Location</th>
							<th class="head1">Onu</th>
							<th class="head0">Port</th>
							<th class="head1 center">Action</th>
						<?php } else{ ?>	
							<th class="head0 center">Zone ID</th>
                            <th class="head1">Zone Info</th>
                            <th class="head0 center">Online/Offline</th>
							<th class="head1">Area Owner (Mac Reseller)</th>
							<th class="head0">Branch Managers/Packages</th>
							<th class="head1 center">Action</th>
						<?php } ?>	
                        </tr>
                    </thead>
                    <tbody>
						<?php if($userr_typ == 'mreseller'){
								while( $row = mysql_fetch_assoc($sql) )
								{
									$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND box_id = '{$row['box_id']}' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$activeclient = $rowaaaa['activeclient'];
									
									$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND box_id = '{$row['box_id']}' AND sts = '0'");
									$rowiii = mysql_fetch_assoc($queryiiiii);

									$inactiveclient = $rowiii['inactiveclient'];
									
									$totalclients = $activeclient + $inactiveclient;
									if($totalclients == '0'){
										$aaa = "<form action='BoxDelete' method='post' style='margin-top: 8px;' onclick='return checkDelete()'><input type='hidden' name='box_id' value='{$row['box_id']}'/><input type='hidden' name='e_id' value='{$e_id}'/><input type='hidden' name='way' value='reseller'/><button class='btn ownbtn4' title='Delete' style='padding: 6px 9px;'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaa = '';
									}
									echo
										"<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;font-size: 18px;font-weight: bold;color: #555;'>{$row['box_id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['b_name']}</b><br><b style='color: #00a65a;font-weight: bold;'>Active:</b> {$activeclient}<br><b style='color: #b94a48;font-weight: bold;'>Inactive:</b> {$inactiveclient}<br><b style='font-weight: bold;'>Total:</b> {$totalclients}</td>
											<td>{$row['location']}</td>
											<td>{$row['onu']}</td>
											<td>{$row['b_port']}</td>
											<td class='center'>
												<ul class='tooltipsample' style='padding: 20px 0;'>
													<li><form action='BoxEdit' method='post' style='margin-top: 8px;'><input type='hidden' name='box_id' value='{$row['box_id']}'/><button class='btn ownbtn2' style='padding: 6px 9px;' title='Edit'><i class='iconfa-edit'></i></button></form></li>
													<li>{$aaa}</li>
												</ul>
											</td>
										</tr>\n ";
								}
							
						}
						else{
						while( $row = mysql_fetch_assoc($sql) )
								{
									$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND z_id = '{$row['z_id']}' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$activeclient = $rowaaaa['activeclient'];
									
									$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND z_id = '{$row['z_id']}' AND sts = '0'");
									$rowiii = mysql_fetch_assoc($queryiiiii);

									$inactiveclient = $rowiii['inactiveclient'];
									
									$totalclients = $activeclient + $inactiveclient;
									
									$querybox = mysql_query("SELECT COUNT(b.box_id) AS totalbox FROM zone AS z LEFT JOIN box AS b ON b.z_id = z.z_id WHERE z.z_id = '{$row['z_id']}'");
									$rowbox = mysql_fetch_assoc($querybox);
									$totalbox = $rowbox['totalbox'];
									
									$qyaaaa = mysql_query("SELECT GROUP_CONCAT(c_id SEPARATOR ',') AS c_id FROM clients WHERE z_id = '{$row['z_id']}'");
									$rohha = mysql_fetch_assoc($qyaaaa);
									$all_client_arrayy = $rohha['c_id'];
									$all_client_array = explode(',', $all_client_arrayy);
									$totalcount = count($all_client_array);

									$commonValues = array_intersect($all_online_client_array, $all_client_array);
									$total_online_count = count($commonValues);
									$total_offline_count = $totalclients - $total_online_count;
									
									if($totalclients == '0' && $row['e_id'] == ''){
										$aaa = "<a href='ZoneDelete?id={$row['z_id']}' class='btn ownbtn4' title='Delete' style='padding: 6px 9px;' onclick='return checkDelete()'><i class='iconfa-trash'></i></a>";
									}
									else{
										$aaa = '';
									}
									if($row['e_id'] != ''){
										$showclients = "<a href='Clients?id=macclient&zid={$row['z_id']}' class='btn ownbtn2' title='Check All Clients' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></a>";
										$subclientsac = "macclient";
										$subclientsin = "macclient";
										$subclientsall = "macclient";
									}
									else{
										$showclients = "<a href='Clients?id=all&zid={$row['z_id']}' class='btn ownbtn2' title='Check All Clients' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></a>";
										$subclientsac = "active";
										$subclientsin = "inactive";
										$subclientsall = "all";
									}
									if($row['z_bn_name'] != ''){
										$zbnname = ' ('.$row['z_bn_name'].')';
									}
									else{
										$zbnname = '';
									}
									
									if($row['e_name'] != ''){
										$rname = ' ('.$row['e_id'].')';
									}
									else{
										$rname = '';
									}
									if($row['billing_type'] == 'Prepaid'){
										$classname = 'label-success';
									}
									else{
										$classname = 'label-important';
									}
									
									$ellemp = array();
									$table_html = '';
									$eid_arry = explode(',', $row['emp_id']);
									foreach($eid_arry as $keyy) { 
										$queerter = mysql_query("SELECT e_id, e_name, e_cont_per FROM emp_info WHERE e_id = '$keyy'");
										$rosgsx = mysql_fetch_assoc($queerter);
										$ellemp[] = "<span title='".$rosgsx['e_name'].' - '.$rosgsx['e_cont_per']."' class='label' style='margin-bottom: 2px;font-size: 14px;font-weight: bold;padding: 2px 4px;border-radius: 3px;background-color: #0866c6ad !important;'>".$rosgsx['e_id'].'</span> ';
									}
									
									foreach ($ellemp as $ellemps) {
									  $table_html .= $ellemps;
									}
									
									$p_idd = array();
									$table_html1 = '';
									$pid_arry = explode(',', $row['p_id']);
									foreach($pid_arry as $keyyy) { 
										$queerterd = mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE p_id = '$keyyy'");
										$rosgsxx = mysql_fetch_assoc($queerterd);
										$p_idd[] = "<span title='".$rosgsxx['p_name'].' ('.$rosgsxx['bandwith'].' - '.$rosgsxx['p_price']."tk)' class='label' style='font-size: 14px;font-weight: bold;padding: 2px 4px;border-radius: 3px;background-color: green !important;'>".$rosgsxx['p_id'].'</span> ';
									}
									
									foreach ($p_idd as $ellempss) {
									  $table_html1 .= $ellempss;
									}
									
									echo
										"<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;font-size: 20px;font-weight: bold;color: #555;width: 45px;'>{$row['z_id']}.</td>
											<td style='vertical-align: middle;line-height: 25px;'><span style='font-weight: bold;font-size: 18px;'>{$row['z_name']}</span> <span style='font-weight: bold;font-size: 15px;'>{$zbnname}</span>
											<br>
											<a href='Clients?id={$subclientsac}&zid={$row['z_id']}' title='Total Active Clients' class='label label-success' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$activeclient}</a> 
											<a href='Clients?id={$subclientsin}&zid={$row['z_id']}' title='Total Inactive Clients' class='label label-important' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$inactiveclient}</a>
											<a href='Clients?id={$subclientsall}&zid={$row['z_id']}' title='Total Clients' class='label' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$totalclients}</a>
											<br>
											<span title='Total Sub-Zone' class='label' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;background-color: #2f6c8ab2 !important;'>Sub-Zone: {$totalbox}</span>
											</td>
											<td class='center' style='vertical-align: middle;'>
											<a href='Clients?id=macclient&zid={$row['z_id']}&RealtimeStatus=Online' title='Total Online Clients' class='label label-success' style='font-size: 22px;font-weight: bold;padding: 6px 6px;border-radius: 3px;'>{$total_online_count}</a>
											<a href='Clients?id=macclient&zid={$row['z_id']}&RealtimeStatus=Offline' title='Total Offline Clients' class='label label-important' style='font-size: 22px;font-weight: bold;padding: 6px 6px;border-radius: 3px;'>{$total_offline_count}</a></td>
											<td style='vertical-align: middle;'><span style='font-weight: bold;font-size: 18px;'>{$row['e_name']}</span> <span style='font-weight: bold;font-size: 15px;'>{$rname}</span>
											<br>
											<a href='tel:{$row['e_cont_per']}' style='font-size: 14px;font-weight: bold;line-height: 25px;'>{$row['e_cont_per']}</a>
											<br>
											<span title='Reseller Type' class='label {$classname}' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$row['billing_type']}</span> <span title='Minimum Recharge Day' class='label label-important' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$row['minimum_day']}</span>
											</td>
											<td style='vertical-align: middle;'>{$table_html}<br>{$table_html1}</td>
											<td class='center' style='vertical-align: middle;'>
												<ul class='tooltipsample'>
													<li>{$showclients}</li>
													<li><form action='ClientsOnMap' method='post' target='_blank' title='Clients On Map'><input type='hidden' name='z_id' value='{$row['z_id']}'/><button class='btn ownbtn1' style='padding: 6px 12px;'><i class='iconfa-map-marker'></i></button></form><li>
													<li><form action='ZoneEdit' method='post' title='Edit'><input type='hidden' name='zid' value='{$row['z_id']}'/><button class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-edit'></i></button></form><li>
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
        jQuery('span[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "span[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'span[rel=popover]', trigger: 'hover'});
        
    });
</script>
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<style>
#dyntable_length{display: none;}
</style>