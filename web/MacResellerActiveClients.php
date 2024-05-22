<?php
$titel = "Clients Current Status";
$Clients = 'active';
include('include/hader.php');
include("mk_api.php");

$type = isset($_GET['type']) ? $_GET['type'] : '';
$zone_id = isset($_GET['zid']) ? $_GET['zid'] : '';
$RealtimeStatus = isset($_GET['RealtimeStatus']) ? $_GET['RealtimeStatus'] : '';
$loadsts = isset($_POST['loadsts']) ? $_POST['loadsts'] : '';
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());
$current_date_time = date('Y-m-d H:i:s', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($user_type == 'mreseller'){
	$z_idddd = $macz_id;
}
else{
	$z_idddd = isset($_GET['id']) ? $_GET['id'] : '';
}

$sql1z1 = mysql_query("SELECT e.mk_id, e.e_name AS reseller_name, z.z_name FROM `zone` AS z
						LEFT JOIN emp_info AS e ON e.e_id = z.e_id
						WHERE z.z_id = '$z_idddd' AND z.status = '0' ");
	$rowwz = mysql_fetch_array($sql1z1);

	$mkid = $rowwz['mk_id'];
	$reseller_name = $rowwz['reseller_name'];
	$znamee = $rowwz['z_name'];


$items = array();
$itemss_uptime[] = array();
$itemss_address[] = array();
$itemss_mac[] = array();

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h, Name FROM mk_con WHERE sts = '0' AND id = '$mkid'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$mk_name = $rowmk['Name'];
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
		
$API = new routeros_api();
$API->debug = false;

		if ($API->connect($ServerIP, $Username, $Pass, $Port)){
				$arrID = $API->comm('/ppp/active/getall');
					foreach($arrID as $xx => $x_value) {
						$items[] = $x_value['name'];
						$itemss_uptime[$x_value['name']] = $x_value['uptime'];
						$itemss_address[$x_value['name']] = $x_value['address'];
						$itemss_mac[$x_value['name']] = $x_value['caller-id'];
					}
			
			$API->disconnect();
		}
		
		$total_active_connection = key(array_slice($items, -1, 1, true))+1;


$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, l.pw, c.termination_date, b.b_name AS z_name, p.p_price_reseller, c.mk_id, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												LEFT JOIN login AS l ON l.e_id = c.c_id
												WHERE c.sts = '0' AND z.z_id = '$z_idddd' ORDER BY c.id DESC");
							$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND z_id = '$z_idddd'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal3345s">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Last Loged Out</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
								<div id='Pointdiv3yyyyd'></div>
						</div>
					</div>
				</div>
			</div>
		</div>	
</div><!--#myModal-->

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal3345">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Real Time Bandwith</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
								<div id='Pointdiv3yyyy'></div>
						</div>
					</div>
				</div>
			</div>
		</div>	
</div><!--#myModal-->

	<div class="pageheader">
		<div class="searchbar" style="margin-right: 10px;">
			<?php if($userr_typ == 'mreseller'){ if($aaaa > $over_due_balance && $billing_typee == 'Prepaid' || $billing_typee == 'Postpaid'){ if($limit_accs == 'Yes'){ ?>
				<a class="btn" href="Clients?id=recharge" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #c60a0a;color: #c60a0a;font-size: 14px;" title="Recharge">Recharge</a>
				<a class="btn" href="MACClientAdd1" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 14px;" title="Add New PPPoE Client">Add</a>
			<?php } else{ ?> 
				<a style='font-size: 15px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[Contact Admin]</a>			
			<?php } }?>
			<div class="input-append" style="margin-right: 2px;">
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid <?php if($type == ''){echo '#028795;color: #028795;';} elseif($type == 'all'){echo '#8b00ff;color: #8b00ff;';} elseif($type == 'left'){echo 'red;color: red;';} elseif($type == 'active'){echo 'GREEN;color: GREEN;';} elseif($type == 'inactive'){echo '#ff00a7;color: #ff00a7;';} elseif($type == 'lock'){echo '#716d6d;color: #716d6d;';} elseif($type == 'auto'){echo '#ea11d2;color: #ea11d2;';} elseif($type == 'invoice'){echo '#ff5400;color: #ff5400;';} elseif($type == 'recharge'){echo '#c60a0a;color: #c60a0a;';} else{echo '#097f71;color: #097f71;';}?>font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;"><?php if($type == 'all'){ ?>All Clients<?php } elseif($type == ''){ echo 'Clients';} elseif($type == 'left'){ echo 'All Deleted Clients';} elseif($type == 'active'){ echo 'Active';} elseif($type == 'inactive'){ echo 'Inactive';} elseif($type == 'lock'){ echo 'Locked';} elseif($type == 'auto'){ echo 'Auto Inactive';} elseif($type == 'invoice'){ echo 'Invoice Clients';} elseif($type == 'recharge'){ echo 'Recharge';} else{ echo 'Reseller';}?> <span class="caret" style="border-top: 4px solid <?php if($type == 'all'){echo '#8b00ff';} elseif($type == ''){echo '#028795';} elseif($type == 'active'){echo 'GREEN';} elseif($type == 'left'){echo 'red';} elseif($type == 'inactive'){echo '#ff00a7';} elseif($type == 'lock'){echo '#716d6d';} elseif($type == 'auto'){echo '#ea11d2';} elseif($type == 'invoice'){echo '#ff5400';} elseif($type == 'recharge'){echo '#c60a0a';} else{echo '#097f71';}?>;"></span></button>
						<ul class="dropdown-menu" style="min-width: 95px;border-radius: 0px 0px 5px 5px;">
							<?php if(in_array(114, $access_arry)){ ?>
								<li <?php if($type == 'all'){echo 'style="display: none;"';}?>><a href="Clients?id=all" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #8b00ff;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Show All Clients List">All Clients</a></li>
							<?php } if(in_array(112, $access_arry)){ ?>
								<li <?php if($type == 'active'){echo 'style="display: none;"';}?>><a href="Clients?id=active" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: GREEN;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Active Clients List">Active</a></li>
							<?php } if(in_array(113, $access_arry)){ ?>
								<li <?php if($type == 'inactive'){echo 'style="display: none;"';}?>><a href="Clients?id=inactive" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ff00a7;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Inactive Clients List">Inactive</a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			<?php }	?>
        </div>
		
		
		
        <div class="pageicon" style="padding: 2px;"><i class="iconfa-globe"></i></div>
        <div class="pagetitle">
             <h3 style="font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;">Clients Current Status [<?php echo $znamee.' - '.$reseller_name;?>] </h3>
        </div>
    </div><!--pageheader-->		
		
		<div class="box box-primary">
			<div class="box-header">
				<h5><?php echo $tit;?></h5>
			</div>
			<div class="box-body">
			<table id="dyntable2" class="table table-bordered responsive">
				<colgroup>
                        <col class="con1" style='width: 20px;'/>
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
                        <tr class="newThead">
							<th class="head1 center">ComID</th>
							<th class="head0">Client Info</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Package</th>
							<th class="head1 center" style="width: 10%;">Termination Date</th>
							<th class="head0 center">Remaining</th>
							<th class="head1" style="width: 15%;">Online Info</th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
                        </tr>
                    </thead>
					
                    <tbody>
						<?php
								$onlinecounter = 0;
								while( $row = mysql_fetch_assoc($sql) )
								{
									$yrdata1= strtotime($row['join_date']);
									$join_date = date('jS F Y', $yrdata1);
									
									$clientid = $row['c_id'];
									$mk_idsfsf = $row['mk_id'];
									if(in_array($row['c_id'], $items)){
										$clientactive = "<form href='#myModal3345' data-toggle='modal' title='Status'><button type='submit' value= '{$row['c_id']}&mk_id={$mk_idsfsf}' style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 13px;margin-top: 2px;padding: 3px 9px 3px;' class='btn' onClick='getRoutePointsp(this.value)'>Online</button></form>";
										$activecount = 1;
										$inactivecount = 0;
										$uptime_val = $itemss_uptime[$row['c_id']];
										$address_val = $itemss_address[$row['c_id']];
										$mac_val = $itemss_mac[$row['c_id']];
										
										if($mac_val != '' && $minimize_data_load == '0'){
											$ppp_mac_replace = str_replace(":","-",$mac_val);
											$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
												
											$macsearchaa = mysql_fetch_assoc(mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'"));
											$running_device = $macsearchaa['info'];
										}
										else{
											$running_device = '';
										}
										
										if($RealtimeStatus == 'Online'){
											$showw = "";
										}
										elseif($RealtimeStatus == 'Offline'){
											$showw = "style='display: none;'";
										}
										else{
											$showw = "";
										}
									}
									else{
										$clientactive = "<form href='#myModal3345s' data-toggle='modal' title='Status'><button type='submit' value= '{$row['c_id']}&mk_id={$mk_idsfsf}&sts=offline' style='border-radius: 3px;text-transform: uppercase;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;border: 1px solid red;color: red;font-size: 12px;margin-top: 2px;padding: 3px 8px 3px;' class='btn' onClick='getRoutePointspd(this.value)'>Offline</button></form>";
										$activecount = 0;
										$inactivecount = 1;
										$uptime_val = '';
										$address_val = '';
										$mac_val = '';
										$running_device = '';
										
										if($RealtimeStatus == 'Online'){
											$showw = "style='display: none;'";
										}
										elseif($RealtimeStatus == 'Offline'){
											$showw = "";
										}
										else{
											$showw = "";
										}
									}
									
									$activecountt += $activecount;
									$inactivecountt += $inactivecount;
									
									if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
										$collllr = 'border: 1px solid green;color: green;font-size: 13px;padding: 3px 10px 3px;';
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
										$collllr = 'border: 1px solid red;color: red;font-size: 12px;padding: 3px 5px 3px;';
									}
									
									$hhhh = $row['p_name'].' - '.$row['bandwith'].'<br>['.$row['p_price'].'tk & '.$row['p_price_reseller'].'tk]';
									
									$yrdata1= strtotime($row['termination_date']);
										$enddate = date('d F, Y', $yrdata1);
									
									$diff = abs(strtotime($row['termination_date']) - strtotime($dateTimeee))/86400;
									if($row['termination_date'] < $dateTimeee){ $diff = '0';}
									if($diff <= '7'){
										$colorrrr = 'style="vertical-align: middle;color: red;font-size: 25px;font-weight: bold;"'; 
										$colorrrr1 = 'style="vertical-align: middle;color: red;font-size: 35px;font-weight: bold;padding: 5px 5px;"'; 
										$colorrrraa = 'style="vertical-align: middle;color: red;font-size: 15px;font-weight: bold;padding: 0px;min-width: 150px;"'; 
									}
									else{
										$colorrrr = 'style="vertical-align: middle;font-size: 25px;font-weight: bold;"'; 
										$colorrrr1 = 'style="vertical-align: middle;font-size: 35px;color:#0866c6;font-weight: bold;padding: 5px 5px;"'; 
										$colorrrraa = 'style="vertical-align: middle;color: #0866c6;font-size: 15px;font-weight: bold;padding: 0px;min-width: 150px;"'; 
									}
									
									if($row['onu_mac'] != ''){
										$onumac = '&nbsp;['.$row['onu_mac'].']';
									}
									else{
										$onumac = '';
									}
								
									$onlineinfo = "<td style='width: 15%;'><b>{$address_val}</b><br>{$mac_val}<br><a style='font-size: 10px;line-height: 10px;'>{$running_device}</a><br><b style='color: #008000d9;font-size: 15px;'><div id='defaultCountdown{$xkey}'>{$uptime_val}</div></b></td>";
														
										echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b><br>{$row['pw']}<br>{$row['cell']}</td>
											<td style='width: 15%;'>{$row['z_name']}<br>{$row['address']}<br>{$onumac}</td>
											<td>{$hhhh}<br><b>{$row['join_date']}</b></td>
											<td class='center' $colorrrraa>{$enddate}</td>
											<td class='center' $colorrrr>{$diff}</td>
											{$onlineinfo}\n";
									
								?>
											<td class='center' style="vertical-align: middle;">
												<ul class='popoversample'>
													<li><form href='#myModal345345' data-toggle='modal' title='<?php echo $dd;?>'><button type='submit' value="<?php echo $row['c_id'].'&consts='.$dd;?>" class='btn <?php echo $clss;?>' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;<?php echo $collllr;?>" onClick='getRoutePoint(this.value)'><?php echo $ee;?></button></form><?php echo $clientactive;?></li>
												</ul>
											</td>
											<td class='center' style="vertical-align: middle;">
												<div class="btn-group">
													<?php if($row['note_auto'] != '' || $row['note'] != ''){ ?>
														<ul class='popoversample' style="padding: 2px 0px;">
															<li style="margin-right: 0px;"><form href='#myModal11' data-toggle='modal'><button type='submit' value="<?php echo $row['c_id'];?>" class='btn' style="border-radius: 3px;text-transform: uppercase;border: 1px solid green;font-size: 13px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;padding: 3px 22px 3px;" onClick='getRoutePoint1(this.value)'>Note</button></form></li>
														</ul>
													<?php } ?>
													<button class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid #c60a0a;font-size: 13px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #c60a0a;padding: 3px 7px 3px;font-weight: bold;" data-toggle="dropdown"><span class="caret" style="border-top: 4px solid #c60a0a;margin-left: 0;"></span>&nbsp; Action </button>
													<ul class="dropdown-menu" style="width: 160px;padding: 2px;right: 0;left: unset;">
															<li style="margin-bottom: 2px;"><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #0866c6;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Profile'><i class='iconfa-eye-open'></i>&nbsp;&nbsp;&nbsp;Profile</button></form></li>
															<li style="margin-bottom: 2px;"><form action='<?php if($userr_typ == 'mreseller'){ echo 'ClientEdit';} else{ echo $editaction;}?>' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #a0f;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Edit'><i class='iconfa-edit'></i>&nbsp;&nbsp;&nbsp;Edit</button></form></li>
															<li class="divider"></li>
															<li style="margin-bottom: 2px;"><form action='ClientsRecharge' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #2ab105;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Recharge'><i class='iconfa-globe'></i>&nbsp;&nbsp;&nbsp;Recharge</button></form></li>
															<li class="divider"></li>
															<li style="margin-bottom: 2px;"><form action='ClientDelete' method='post'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" onclick="return checkDelete()" style="border-top: 1px solid #80808040;color: red;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Delete'><i class='iconfa-trash'></i>&nbsp;&nbsp;&nbsp;Delete</button></form></li>
													</ul>
												</div>
											</td>
										</tr>
						<?php $xkey++; } ?>
					</tbody>
				</table>
				<div class='actionBar' style="padding: 10px;border: 1px solid #ddd;margin-top: 2px;">
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: #0866c6;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Online:  <i><?php echo $activecountt;?></i></div> 
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: red;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Offline: <i><?php echo $inactivecountt;?></i></div> 
					<div style="position: absolute;top: 12%;right: 10px;">
						<form id="form2" class="stdform" method="GET" action="<?php echo $PHP_SELF;?>">
							<?php if($type != ''){ ?>
								<input type='hidden' name='typeid' value='<?php echo $type;?>'/> 
							<?php }?>
							<?php if($zone_id != ''){ ?>
								<input type='hidden' name='zid' value='<?php echo $zone_id;?>'/> 
							<?php }?>
							<select name="RealtimeStatus" style="font-weight: bold;font-size: 15px;width:185px;" onchange="submit();">
								<option value="all"<?php if($RealtimeStatus == 'all' || $RealtimeStatus == '') echo 'selected="selected"';?>>All Clients</option>
								<option value="Online"<?php if($RealtimeStatus == 'Online') echo 'selected="selected"';?> style="color: green;">Online Clients</option>
								<option value="Offline"<?php if($RealtimeStatus == 'Offline') echo 'selected="selected"';?> style="color: red;">Offline Clients</option>
							</select>
						</form>        
					</div>
			</div>
			</div>
			</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?><script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[<?php if($minimize_data_load == '0'){echo '6';} else{echo '5';}?>,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
		
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[5,'asc']],
            "sScrollY": "1000px"
        });
    });
	function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
	function getRoutePointspd(afdId) {		
		var strURL="client-offline-out.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv3yyyyd').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
	}
	function getRoutePointsp(afdId) {		
		var strURL="client-online-mb.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv3yyyy').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
	}
</script>
<style>
div.checker{
	margin-right: 0;
}
</style>