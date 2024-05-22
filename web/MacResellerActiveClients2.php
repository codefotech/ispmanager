<?php
$titel = "Client";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");

$type = isset($_GET['id']) ? $_GET['id'] : '';
$zone_id = isset($_GET['zid']) ? $_GET['zid'] : '';
$RealtimeStatus = isset($_GET['RealtimeStatus']) ? $_GET['RealtimeStatus'] : '';
$loadsts = isset($_POST['loadsts']) ? $_POST['loadsts'] : '';
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());
$current_date_time = date('Y-m-d H:i:s', time());

if($minimize_data_load == '0'){
	$loadval = 'yes';
	$bttn_icon = 'iconfa-resize-small';
	$load_titel = 'Minimize Data Loading';
	$load_class = 'ownbtn8';
}
else{
	$loadval = 'no';
	$bttn_icon = 'iconfa-resize-full';
	$load_titel = 'Maximize Data Loading';
	$load_class = 'ownbtn2';
}

$API = new routeros_api();
$API->debug = false;

if($online_btn_off == '1'){
$items = array();
$itemss = array();

$itemss_uptime[] = array();
$itemss_address[] = array();
$itemss_mac[] = array();
$sql34 = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND online_sts = '0'");
$tot_mk = mysql_num_rows($sql34);
while ($roww = mysql_fetch_assoc($sql34)) {
		$maikro_id = $roww['id'];
		$maikro_Name = $roww['Name'];
		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
				$arrID = $API->comm('/ppp/active/getall');
					foreach($arrID as $xx => $x_value) {
						$items[] = $x_value['name'];
						$itemss_uptime[$x_value['name']] = $x_value['uptime'];
						$itemss_address[$x_value['name']] = $x_value['address'];
						$itemss_mac[$x_value['name']] = $x_value['caller-id'];
					}
				
				if($active_queue == '1'){
				$arrIDD = $API->comm('/ip/arp/getall');
					foreach($arrIDD as $xx => $x_valuee) {
							$clip = $x_valuee['address'];
							$macsearch = mysql_query("SELECT c_id FROM clients WHERE ip = '$clip'");
							$macsearchaa = mysql_fetch_assoc($macsearch);	
							if($macsearchaa['c_id'] != ''){
								$itemss[] = $macsearchaa['c_id'];
								$itemss_uptime[] = array();
								$itemss_address[$macsearchaa['c_id']] = $x_valuee['address'];
								$itemss_mac[$macsearchaa['c_id']] = $x_valuee['mac-address'];
							}
					}
				}
				else{
					$itemss = array();
					$itemss_uptime[] = array();
					$itemss_address[] = array();
					$itemss_mac[] = array();
				}
			
			
			$API->disconnect();
			$errorrrrr_style = '';
			$errorrrrr_msg = '';
			$mk_offlinecounter = 0;
		}
		else{
			$query12312rr ="UPDATE mk_con SET online_sts = '1' WHERE id = '$maikro_id'";
			$resuldfsddt = mysql_query($query12312rr) or die("inser_query failed: " . mysql_error() . "<br />");
			
			$errorrrrr_style = 'style="font-size: 14px;"';
			$errorrrrr_msg = $maikro_Name.' ('.$ServerIP1.') are Disconnected.<br>';
			$mk_offlinecounter = 1;
		}
			$mk_offlinecounterr += $mk_offlinecounter;

}

$itemss1 = array_merge($itemss, $items);
$total_active_connection = key(array_slice($itemss1, -1, 1, true))+1;
$padddding = 'style="padding: 5px 0px;"';

		if($tot_mk == $mk_offlinecounterr){
			$query12312 ="update app_config set onlineclient_sts = '0'";
			$resuldfsdt = mysql_query($query12312) or die("inser_query failed: " . mysql_error() . "<br />");
		}
}
else{
$padddding = 'style="padding: 15px 0px;"';
}

if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'billing' || $user_type == 'support_manager' || $user_type == 'ets'){
	
							$allclients = "SELECT *, m.id as mk_id FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id";
												
											if($minimize_data_load == '0'){
												$allclients .= " LEFT JOIN login AS l ON l.e_id = c.c_id";
											}
												$allclients .= " WHERE c.sts = '0' AND c.mac_user !='1' AND c.breseller != '2'";
											
											if ($user_type == 'billing'){
												$allclients .= " AND z.emp_id = '$e_id'";
											}
											
											$allclients .= " ORDER BY c.id DESC";
							
							if ($user_type == 'billing'){
								$sqls = mysql_query("SELECT c.c_id FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND z.emp_id = '$e_id' AND c.con_sts = 'Active' AND c.mac_user !='1' AND c.breseller != '2'");
								$sqlss = mysql_query("SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.sts = '0' AND z.emp_id = '$e_id' AND l.log_sts = '1' AND mac_user !='1' AND c.breseller != '2'");
							}
							else{
								$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user !='1'");
								$sqlss = mysql_query("SELECT c_id FROM clients AS c	LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1' AND c.mac_user !='1'");
							}

							$sql = mysql_query($allclients);
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$loc = mysql_num_rows($sqlss);
							$inact = $tot - $act;
							
							
					
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
										<div class='hil'> Lock: <i style='color: #f66305'>{$loc}</i></div>
									</div>";
						
							
}

$result=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
$result1=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
?>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="MACClientAdd1">
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
									<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['resellername']; ?>)</option>
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

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal11">
	<div id='Pointdiv2'></div>
</div>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal345345">
	<div id='Pointdiv1'></div>
</div><!--#myModal-->

	<div class="pageheader">
		<div class="searchbar" style="margin-right: 10px;">
		<?php if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets'){ ?>
			<?php if($limit_accs == 'Yes'){ ?>
				<div class="input-append">
					<div class="btn-group">
						<?php if(in_array(110, $access_arry) || in_array(111, $access_arry)){?>
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 14px;" title="Add New PPPoE or Static or Reseller Client">Add <span class="caret" style="border-top: 4px solid #0866c6;"></span></button>
						<ul class="dropdown-menu" style="min-width: 115px;border-radius: 0px 0px 5px 5px;">
						<?php if(in_array(110, $access_arry)){?>
							<li><a href="ClientAdd" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Add New PPPoE Client">PPPoE</a></li>
							<li><a href="BResellerAdd" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ac3131c4;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Queue Client">Static IP</a></li>
						<?php } if(in_array(247, $access_arry)){ ?>
							<li><a href="ClientAddInvoice" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Invoice Client">Invoice Client</a></li>
						<?php } if(in_array(111, $access_arry)){ ?>
							<li><a href="#myModal" data-toggle="modal" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: green;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Mac Reseller Client">Reseller MAC</a></li>
						<?php } ?> 
						</ul>
						<?php } ?> 
					</div>
				</div>
			<?php } else{ ?> 
				<a style='font-size: 15px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[User Limit Exceeded]</a>
			<?php } ?>
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
							<?php } if(in_array(117, $access_arry)){?>
								<li <?php if($type == 'lock'){echo 'style="display: none;"';}?>><a href="Clients?id=lock" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #716d6d;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Locked Clients List">Locked </a></li>
							<?php } if(in_array(116, $access_arry)){ ?>
								<li <?php if($type == 'auto'){echo 'style="display: none;"';}?>><a href="Clients?id=auto" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ea11d2;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Deadline Wise Off Clients">Auto Inactive </a></li>
							<?php } if(in_array(249, $access_arry)){ ?>
								<li <?php if($type == 'invoice'){echo 'style="display: none;"';}?>><a href="Clients?id=invoice" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ff5400;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Invoice Clients">Invoice Clients </a></li>
							<?php } if(in_array(115, $access_arry) && $type != 'macclient'){ ?>
								<li <?php if($type == 'macclient'){echo 'style="display: none;"';}?>><a href="Clients?id=macclient" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #097f71;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Mac Reseller Clients">Reseller Clients </a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			<?php if(in_array(115, $access_arry) && ($type == 'macclient')){?>
						<form method="GET" action="Clients" style="float: left;margin-right: 4px;">
							<input type='hidden' name='id' value='<?php echo $_GET['id'];?>'/> 
							<select name="zid" style="border: 1px solid #317eac;color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;border-radius: 3px;" onchange="submit();">
									<option value="" style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;">All Reseller</option>
									<?php while ($row345=mysql_fetch_array($resultsdfg)) { ?>
											<option style="color: #317eac;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-align: center;font-size: 14px;font-weight: bolder;" value="<?php echo $row345['z_id']?>"<?php if ($row345['z_id'] == $zone_id) echo 'selected="selected"';?>><?php echo $row345['resellername']; ?> - <?php echo $row345['z_name'];?></option>
									<?php } ?>
							</select>
						</form>
			<?php } if(in_array(118, $access_arry)){?>
				<a href="Clients?id=left" class="btn btn-danger btn-circle" style="border: 1px solid red;float: right;padding: 5px 5px;font-size: 17px;" title="Recycle Bin"><i class="iconfa-trash" style="color: red;"></i></a>
			<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
				<form action='ActionAdd' method='post' data-placement='top' data-rel='tooltip' title='<?php echo $load_titel;?>' style="float: right;padding-right: 2px;"><input type='hidden' name='typee' value='load_mini' /><input type='hidden' name='tis_id' value='<?php echo $tis_id;?>' /><input type='hidden' name='loadsts' value='<?php echo $loadval;?>' /><button class='btn <?php echo $load_class;?>' style='padding: 5px 8px;font-size: 17px;' onclick="return checkLoad()"><i class='<?php echo $bttn_icon;?>'></i></button></form>
			<?php } ?>
		<?php }} ?>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Clients</h1>
        </div>
    </div><!--pageheader-->
		<?php if($errorrrrr_msg != ''){?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong <?php echo $errorrrrr_style;?>><?php echo $maikro_Name .' ('. $ServerIP1.') are Disconnected';?></strong>
			</div><!--alert-->
		<?php } if('delete' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.
			</div><!--alert-->
		<?php } if('add' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
			</div><!--alert-->
		<?php } if('Lock0' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Locked in Your System.
			</div><!--alert-->
		<?php } if('Lock1' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Unlocked in Your System.
			</div><!--alert-->
		<?php } if('StatusActive' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Inactive in Your System.
			</div><!--alert-->
		<?php } if('StatusInactive' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Active in Your System.
			</div><!--alert-->
		<?php } if('StatusRechargeDone' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Recharged.
			</div><!--alert-->
		<?php } if('smssent' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Send The SMS.
			</div><!--alert-->
		<?php } if('trnsferdone' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Transfer [<?php echo $new_id;?>] To Reseller Account.
			</div><!--alert-->
		<?php } if('owntrnsferdone' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Transfer [<?php echo $new_id;?>] as Own Client.
			</div><!--alert-->
		<?php } if('edit' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.
			</div><!--alert-->
		<?php } if('return' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Client Successfully return in Your System.
			</div><!--alert-->
		<?php } if('yes' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Your Clients Data Has Been Minimized.
			</div><!--alert-->
		<?php } if('no' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Your Clients Data Has Been Maximized.
			</div><!--alert-->
		<?php } ?>
	
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
						<col class="con0" />
						<col class="con1" />	
                    </colgroup>
                   <thead>
                        <tr  class="newThead">
						<?php if($minimize_data_load == '0'){ ?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Pass/Cell</th>
							<th class="head1 center">Image</th>
							<th class="head0">Zone/Box/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0">Deadline</th>
							<?php if($online_btn_off == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
						<?php } else{ ?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Cell</th>
							<th class="head0">Zone/Box/Address/Onu</th>
							<th class="head1">Package/Joining Date</th>
							<th class="head0">Deadline</th>
							<?php if($online_btn_off == '1'){ ?><th class="head1" style="width: 15%;">IP/MAC/Device/Uptime<?php } ?></th>
							<th class="head0 center">Status</th>
                            <th class="head1 center"></th>
						<?php } ?>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$xkey = 100;
								$onlinecounter = 0;
								while( $row = mysql_fetch_assoc($sql) )
								{
									$yrdata1= strtotime($row['join_date']);
									$join_date = date('jS F Y', $yrdata1);
									
									$clientid = $row['c_id'];
									$mk_idsfsf = $row['mk_id'];
									if($online_btn_off == '1'){
									if(in_array($row['c_id'], $itemss1)){
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
									}
									else{
										$showw = "";
									}
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
									if($minimize_data_load == '0'){
									if($row['log_sts'] == '0'){
										$aa = 'btn';
										$bb = "<i class='iconfa-unlock'></i>";
										$cc = 'Lock';
										$www = 'style="border-radius: 3px;border: 1px solid #236db3;color: #236db3;padding: 6px 9px;"';
										$www1 = "color: #236db3;";
									}
									else{
										$aa = 'btn';
										$bb = "<i class='iconfa-lock'></i>";
										$cc = 'Unlock';
										$www = 'style="border-radius: 3px;border: 1px solid #236db3;color: #f66305;padding: 6px 9px;"';
										$www1 = "color: #f66305;";
									}
									}
									if($row['mac_user'] == '1'){
										$hhhh = $row['p_name'].' - '.$row['bandwith'].'<br>['.$row['p_price'].'tk & '.$row['p_price_reseller'].'tk]';
									}
									else{
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['raw_download'] .' + U: '.$row['raw_upload'].' + Y: '.$row['youtube_bandwidth'].' = '.$row['total_bandwidth'].'mb <br> Rate: '.$row['total_price'];
										$editaction = "ClientEdit";
										$monthlyinv = "<form action='PackageChange' method='post' target='_blank'><input type='hidden' name='cid' value='{$row['c_id']}' /><button style='border-top: 1px solid #80808040;color: #bb9605;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;' title='Change Bandwith'><i class='iconfa-signout'></i>&nbsp;&nbsp;&nbsp;Change Bandwith</button></form>";
									}
									elseif($row['breseller'] == '2'){
										$hhhh ="";
										$editaction = "ClientEditInvoice";
										$monthlyinv = "<form action='ClientEditMonthlyInvoice' method='post' target='_blank'><input type='hidden' name='c_id' value='{$row['c_id']}' /><button style='border-top: 1px solid #80808040;color: #bb9605;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;' title='Edit Monthly Invoice'><i class='iconfa-signout'></i>&nbsp;&nbsp;&nbsp;Edit Invoice</button></form>";
									}
									else{
										$hhhh = $row['p_name'].'<br>'.$row['bandwith'].' - '.$row['p_price'].'tk';
										$editaction = "ClientEdit";
										$monthlyinv = "<form action='PackageChange' method='post' target='_blank'><input type='hidden' name='cid' value='{$row['c_id']}' /><button style='border-top: 1px solid #80808040;color: #bb9605;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;' title='Change Package'><i class='iconfa-signout'></i>&nbsp;&nbsp;&nbsp;Change Package</button></form>";
									}
									}
									
								if($minimize_data_load == '0'){
									if($row['nid_back'] != ''){
										$nid_back = "<a href='{$row['nid_back']}' target='_blank' /><img src='/{$row['nid_back']}' width='33%' height='15' alt='{$row['c_id']}_nid_back' style='border: 1px solid gray;'/></a>";
									}
									else{
										$nid_back = "";
									}
									if($row['nid_fond'] != ''){
										$nid_fond = "<a href='{$row['nid_fond']}' target='_blank' /><img src='/{$row['nid_fond']}' width='33%' height='15' alt='{$row['c_id']}_nid_fond' style='border: 1px solid gray;margin-right: 1px;'/></a>";
									}
									else{
										$nid_fond = "";
									}
									if($row['image'] != ''){
										$imgeeeee = "<a href='{$row['image']}' target='_blank' /><img src='/{$row['image']}' width='50' height='50' alt='{$row['c_id']}_main_image' style='border: 1px solid gray;margin-bottom: 3px;'/></a>";
									}
									else{
										$imgeeeee = "";
									}
									
									$passload = '<br>'.$row['pw'];
									$allimg = "<td class='center'>{$imgeeeee}<br>{$nid_fond}{$nid_back}</td>";
								}
								else{
									$passload= '';
									$allimg = "";
								}
									
									if($row['onu_mac'] != ''){
										$onumac = '&nbsp;['.$row['onu_mac'].']';
									}
									else{
										$onumac = '';
									}
								
								if($online_btn_off == '1'){
									$onlineinfo = "<td style='width: 15%;'><b>{$address_val}</b><br>{$mac_val}<br><a style='font-size: 10px;line-height: 10px;'>{$running_device}</a><br><b style='color: #008000d9;font-size: 15px;'><div id='defaultCountdown{$xkey}'>{$uptime_val}</div></b></td>";
								}
								else{
									$onlineinfo = "";
								}
								if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets'){
								
									echo
										"<tr class='gradeX' {$showw}>
											<td class='center' style='vertical-align: middle;font-size: 15px;font-weight: bold;'>{$row['com_id']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}</b>{$passload}<br>{$row['cell']}</td>
											{$allimg}
											<td style='width: 15%;'>{$row['z_name']}<br>{$row['b_name']}<br>{$row['address']}<br><b>[{$row['Name']}]</b>{$onumac}</td>
											<td>{$hhhh}<br><br><b>{$join_date}</b></td>
											<td style='padding: 16px 0px;'>
												<table style='width: 100%;'>
													<tbody>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>PD: {$row['payment_deadline']}</b>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='' style='border-right: none;border-left: none;'>
															<ul class='tooltipsample' style='padding-left: 3px;'>
																<b>BD: {$row['b_date']}</b>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
											{$onlineinfo}\n";
											
								
								} ?>
											<td class='center' style="vertical-align: middle;">
												<ul class='popoversample'>
												<?php if(in_array(103, $access_arry)){?>
													<li><form href='#myModal345345' data-toggle='modal' title='<?php echo $dd;?>'><button type='submit' value="<?php echo $row['c_id'].'&consts='.$dd;?>" class='btn <?php echo $clss;?>' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;<?php echo $collllr;?>" onClick='getRoutePoint(this.value)'><?php echo $ee;?></button></form><?php if($online_btn_off == '1'){echo $clientactive;}?></li>
												<?php } else{?>
													<li><button class='btn <?php echo $clss;?>' style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;<?php echo $collllr;?>"><?php echo $ee;?></button></li>
												<?php } ?>
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
														<?php if(in_array(104, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientView' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #0866c6;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Profile'><i class='iconfa-eye-open'></i>&nbsp;&nbsp;&nbsp;Profile</button></form></li>
														<?php } if(in_array(101, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='<?php echo $editaction;?>' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #a0f;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Edit'><i class='iconfa-edit'></i>&nbsp;&nbsp;&nbsp;Edit</button></form></li>
														<?php } if(in_array(105, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientSMS' method='post' target='_blank'><input type='hidden' name='ids' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: green;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Send SMS'><i class='iconfa-envelope'></i>&nbsp;&nbsp;&nbsp;Send SMS</button></form></li>
														<?php } if($row['con_sts'] == 'Active'){ ?>
															<li style="margin-bottom: 2px;"><?php echo $monthlyinv;?></li>
														<?php } ?>
															<li class="divider"></li>
														<?php if(in_array(128, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='PaymentAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: #044a8e;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Cash Payment'><i class='iconfa-money'></i>&nbsp;&nbsp;&nbsp;Cash Payment</button></form></li>
														<?php } if(in_array(129, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='PaymentOnlineAdd' method='post' target='_blank'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" style="border-top: 1px solid #80808040;color: green;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Online Payment'><i class='iconfa-shopping-cart'></i>&nbsp;&nbsp;&nbsp;Online Payment</button></form></li>
														<?php } ?>
															<li class="divider"></li>
														<?php if(in_array(106, $access_arry) && $minimize_data_load == '0'){?>
															<li style="margin-bottom: 2px;"><form action='ClientLock' method='post' target='_blank'><input type='hidden' name='id' value='<?php echo $row['c_id'];?>' /><button class="" onclick="return checkLock()" style="border-top: 1px solid #80808040;<?php echo $www1;?>border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;"><?php echo $bb;?>&nbsp;&nbsp;&nbsp;<?php echo $cc;?></button></form></li>
														<?php } if(in_array(102, $access_arry)){?>
															<li style="margin-bottom: 2px;"><form action='ClientDelete' method='post'><input type='hidden' name='c_id' value='<?php echo $row['c_id'];?>' /><button class="" onclick="return checkDelete()" style="border-top: 1px solid #80808040;color: red;border-bottom: 1px solid #80808040;width: 160px;border-left: 1px solid #80808040;border-right: 1px solid #80808040;text-align: left;padding: 3px 0 3px 15px;font-size: 14px;" title='Delete'><i class='iconfa-trash'></i>&nbsp;&nbsp;&nbsp;Delete</button></form></li>
														<?php } ?>
													</ul>
												</div>
											</td>
											
										</tr>
						<?php $xkey++; } ?>
					</tbody>
				</table>
		<?php if($online_btn_off == '1'){?>
			<div class='actionBar' style="padding: 10px;border: 1px solid #ddd;margin-top: 2px;">
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: #0866c6;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Online:  <i><?php echo $activecountt;?></i></div> 
					<div style="float: left;font-size: 18px;padding: 6px 30px 0px 20px;margin-top: -5px;color: red;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;">Offline: <i><?php echo $inactivecountt;?></i></div> 
					<div style="position: absolute;top: 12%;right: 10px;">
						<form id="form2" class="stdform" method="GET" action="<?php echo $PHP_SELF;?>">
							<?php if($type != ''){ ?>
								<input type='hidden' name='id' value='<?php echo $type;?>'/> 
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
		<?php } ?>
			</div>
		</div>
<?php  

}
else{
	header("Location:/index");
}
include('include/footer.php'); ?>

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
		jQuery('#dyntable2').dataTable( {
            "bScrollInfinite": true,
            "bScrollCollapse": true,
			"iDisplayLength": 50,
			"aaSorting": [[0,'desc']],
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
function checkPreDelete(){
    return confirm('Permanent Delete!!  No way to undo. Are you sure?');
}
function checksts(){
    return confirm('Change connection status!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}

function checkLoad(){
    return confirm('Are you sure?  Do You Want To <?php echo $load_titel;?>?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>
<script language="javascript" type="text/javascript">
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
	
	function getRoutePoint(afdId) {		
		
		var strURL="client-status-change-note.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	
	function getRoutePoint1(afdId) {		
		var strURL="client-note.php?c_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv2').innerHTML=req.responseText;						
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
	
</script>