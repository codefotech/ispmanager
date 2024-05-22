<?php
$titel = "Client";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php");
include("mk_api.php");

$type = isset($_GET['id']) ? $_GET['id'] : '';
$zone_id = isset($_GET['zid']) ? $_GET['zid'] : '';
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());


$API = new routeros_api();
$API->debug = false;

if($client_onlineclient_sts == '1'){
$items = array();
$sql34 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0'");
while ($roww = mysql_fetch_assoc($sql34)) {

		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
				$arrID = $API->comm('/ppp/active/getall');
				foreach($arrID as $x => $x_value) {
						$items[] = $x_value['name'];
				}
		 $API->disconnect();
		}
    $items = array_merge($items, $roww);
}
$total_active_connection = key(array_slice($items, -1, 1, true))+1;
$padddding = 'style="padding: 5px 0px;"';
}
else{
$padddding = 'style="padding: 15px 0px;"';
}

if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets' || $user_type == 'support_manager'){
							if($type == 'macclient' && in_array(115, $access_arry)){
								
							$resultsdfg=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername, e.e_id AS resellerid FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by e.e_name");
							$sqldfg = "SELECT c.c_name, c.com_id, c.termination_date, c.onu_mac, e.e_name AS technician, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												WHERE c.sts = '0' AND c.mac_user ='1'";
									if ($zone_id != ''){
										$sqldfg .= " AND c.z_id = '{$zone_id}'";
									}
										$sqldfg .= " ORDER BY c.id DESC";
							
							$sql = mysql_query($sqldfg);
							$sgthj = "SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND mac_user ='1'";
									if ($zone_id != ''){
										$sgthj .= " AND z_id = '{$zone_id}'";
									}
							$sqls = mysql_query($sgthj);
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
}
if($userr_typ == 'mreseller'){
							if($type == '' || $type == 'all'){
							$sql = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, c.termination_date, e.e_name AS technician, b.b_name, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												WHERE c.sts = '0' AND z.z_id = '$macz_id' ORDER BY c.id DESC");
							$sqls = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND con_sts = 'Active' AND z_id = '$macz_id'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
}
$result=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
$result1=mysql_query("SELECT z.z_id, z.z_name, e.e_name AS resellername FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
?>
	<div class="pageheader">
		<div class="searchbar" style="margin-right: 10px;">
		<?php if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $userr_typ == 'mreseller' || $user_type == 'accounts' || $user_type == 'billing' || $user_type == 'billing_manager' || $user_type == 'support_manager' || $user_type == 'ets'){ ?>
			<?php if($userr_typ == 'mreseller'){ if($aaaa > 0 && $billing_typee == 'Prepaid' || $billing_typee == 'Postpaid'){ if($limit_accs == 'Yes'){?>
				<a class="btn" href="MACClientAdd1" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 14px;" title="Add New PPPoE Client">Add</a>
			<?php } else{ ?> 
				<a style='font-size: 15px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[Contact Admin]</a>			
			<?php } }?>
				<a class="btn" href="MacResellerActiveClients" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #666;color: #666;font-size: 14px;" title="Realtime Active Connections">Status</a>
			<?php }	else{  if($limit_accs == 'Yes'){ ?>
				<div class="input-append">
					<div class="btn-group">
						<?php if(in_array(110, $access_arry) || in_array(111, $access_arry)){?>
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border: 1px solid #0866c6;color: #0866c6;font-size: 14px;" title="Add New PPPoE or Static or Reseller Client">Add <span class="caret" style="border-top: 4px solid #0866c6;"></span></button>
						<ul class="dropdown-menu" style="min-width: 115px;border-radius: 0px 0px 5px 5px;">
						<?php if(in_array(110, $access_arry)){?>
							<li><a href="ClientAdd" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Add New PPPoE Client">PPPoE</a></li>
							<li><a href="BResellerAdd" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ac3131c4;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Queue Client">Static IP</a></li>
						<?php } if(in_array(111, $access_arry)){ ?>
							<li><a href="#myModal" data-toggle="modal" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: green;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Add New Mac Reseller Client">Reseller MAC</a></li>
						<?php } ?> 
						</ul>
						<?php } ?> 
					</div>
				</div>
			<?php } else{ ?> 
				<a style='font-size: 15px;font-weight: bold;color: red;font-family: Monaco,Menlo,Consolas,"Courier New",monospace;'>[User Limit Exceeded]</a>
			<?php }} ?>
				<div class="input-append">
					<div class="btn-group">
						<button data-toggle="dropdown" class="btn dropdown-toggle" style="border-radius: 3px;text-transform: uppercase;border: 1px solid green;color: green;font-size: 14px;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;">Clients <span class="caret" style="border-top: 4px solid green;"></span></button>
						<ul class="dropdown-menu" style="min-width: 95px;border-radius: 0px 0px 5px 5px;">
							<?php if(in_array(114, $access_arry)){ ?>
								<li><a href="Clients?id=all" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #3A8EE1;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;" title="Show All Clients List">All Clients</a></li>
							<?php } if(in_array(112, $access_arry)){ ?>
								<li><a href="Clients?id=active" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: GREEN;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Active Clients List">Active</a></li>
							<?php } if(in_array(113, $access_arry)){ ?>
								<li><a href="Clients?id=inactive" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: red;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Inactive Clients List">Inactive</a></li>
							<?php } if(in_array(117, $access_arry)){?>
								<li><a href="Clients?id=lock" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #716d6d;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Locked Clients List">Locked </a></li>
							<?php } if(in_array(116, $access_arry)){ ?>
								<li><a href="Clients?id=auto" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #ea11d2;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="Deadline Wise Off Clients">Auto Inactive </a></li>
							<?php } if(in_array(115, $access_arry) && $type != 'macclient'){ ?>
								<li><a href="Clients?id=macclient" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #097f71;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;" title="All Mac Reseller Clients">Reseller Clients </a></li>
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
				<a href="Clients?id=left" class="btn btn-danger btn-circle" style="border: 1px solid red;font-size: 16px;" title="Recycle Bin"><i class="iconfa-trash" style="color: red;"></i></a>
		<?php }} ?>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Clients Multi Recharge</h1>
        </div>
    </div><!--pageheader-->
		<?php if('delete' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
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
		<?php } ?>
	
	<div class="box box-primary">
		<div class="box-header">
			<h5><?php echo $tit;?></h5>
		</div>
			<div class="box-body">
			<form action='ClientsMultiRecharge' method='post'>
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
						<col class="con0" />
						<col class="con1" />	
                    </colgroup>
                   <thead>
                        <tr  class="newThead">
						<?php if($userr_typ == 'mreseller'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Pass/Cell</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Package/Joining Date</th>
							<th class="head0 center">Remaining_Days</th>
							<th class="head1 center">Termination</th>
							<th class="head1 center">Recharging Till</th>
							<th class="head0 center">Recharging Days</th>
							<th class="head1 center">Cost (৳)</th>
						<?php } else{ if($type == 'macclient'){?>
							<th class="head1 center">ComID</th>
							<th class="head0">ID/Name/Pass/Cell</th>
							<th class="head1">Zone/Address</th>
							<th class="head0">Package/Joining Date</th>
							<th class="head1 center">Termination Date</th>
							<th class="head0 center">Remaining_Days</th>
							<th class="head0 center">Cost & New Date</th>
							<th class="head0 center">Recharge Days</th>
							<th class="head1 center">Status</th>
                            <th class="head0 center">Action</th>
						<?php }} ?>
                        </tr>
                    </thead>
                    <tbody>
					
						<?php
								$x = 0;				
								for($i = 0; $i < count($c_id); $i++) {
	
	$cc_id = $c_id[$i];
	$durations = $durationss[$i];
	$durationn = floor($durations);

	$quesww = mysql_query("SELECT b.id, b.c_id, c.cell, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, c.termination_date, b.days, b.start_date, b.start_time, b.end_date, b.p_id, p.p_name, p.bandwith, p.p_price, b.bill_amount FROM billing_mac AS b
						LEFT JOIN package AS p ON p.p_id = b.p_id
						LEFT JOIN clients AS c ON c.c_id = b.c_id
						WHERE c.c_id = '$cc_id' ORDER BY b.id DESC LIMIT 1");
$rowwww = mysql_fetch_assoc($quesww);
$idq = $rowwww['id'];
$c_name = $rowwww['c_name'];
$cell = $rowwww['cell'];
$start_date = strtotime($rowwww['start_date']);
$startdate = $rowwww['start_date'];
$end_date = strtotime($rowwww['end_date']);
$enddate = $rowwww['end_date'];
$p_price = $rowwww['p_price'];

$packageoneday = $p_price/30;
$daycost = $durationn*$packageoneday;
$todayssss = strtotime(date('Y-m-d', time()));

if($todayssss > $start_date && $todayssss < $end_date || $todayssss <= $start_date && $todayssss <= $end_date) {
$enddatee = $enddate;
}
else{
$enddatee = $dateTimeee;
}
$new_end_date = date('Y-m-d', strtotime($enddatee . " + ".$durationn." day"));
$new_start_date = date('Y-m-d', strtotime($enddatee . " + 1 day"));



//echo $cc_id.'-'.$c_name.'-'.$cell.'-'.$durationn.'-'.$p_price.'-'.$daycost.'-'.$end_date.'<br>';

									$sql44 = mysql_query("SELECT c.c_name, c.com_id, c.onu_mac, c.termination_date, e.e_name AS technician, b.b_name, c.b_date, c.c_id, c.payment_deadline, c.raw_download, c.breseller, c.mac_user, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, m.Name, c.breseller, c.p_id, p.p_name, p.p_price, p.bandwith, c.address, z.z_name, c.cell, c.note, c.note_auto, c.con_sts, DATE_FORMAT(c.join_date, '%D %M %Y') AS join_date, c.p_id, l.log_sts, l.pw FROM clients AS c
												LEFT JOIN package AS p ON p.p_id = c.p_id
												LEFT JOIN zone AS z ON z.z_id = c.z_id 
												LEFT JOIN mk_con AS m ON m.id = c.mk_id 
												LEFT JOIN emp_info AS e ON e.e_id = c.technician
												LEFT JOIN login AS l ON l.e_id = c.c_id 
												LEFT JOIN box AS b ON b.box_id = c.box_id
												WHERE c.sts = '0' AND c.c_id = '$cc_id' ORDER BY c.id DESC");
									$rows1 = mysql_fetch_assoc($sql44);
									$yrdata1= strtotime($rows1['termination_date']);
									$enddate2 = date('d F, Y', $yrdata1);
									
									if($durationn > '0' && $durationn < '100'){
										$yrdata11= strtotime($new_end_date);
										$enddate1 = date('d F, Y', $yrdata11);
										}
										else{
											$durationn = 'X';
											$daycost = 'X';
											$enddate1 = '';
										}
									$diff = abs(strtotime($rows1['termination_date']) - strtotime($dateTimeee))/86400;
									if($rows1['termination_date'] < $dateTimeee){ $diff = '0';}
									if($diff <= '7'){
										$colorrrr = 'style="color: red;font-size: 20px;font-weight: bold;"'; 
									}
									else{
										$colorrrr = 'style="font-size: 20px;font-weight: bold;"'; 
									}
									
									
									echo "<tr class='gradeX'>
											<td class='center'>" . $rows1['com_id'] ."</td>
											<td><b>" . $cc_id . "</b><br>". $rows1['c_name'] ."<br> ". $rows1['pw'] ."<br> ". $rows1['cell'] ."</td>
											<td>" . $rows1['z_name'] ." <br> ". $rows1['address'] ."</td>
											<td>" . $rows1['p_name'] ." <br> ". $rows1['p_price'] ."৳<br><br>". $rows1['join_date'] ."</td>
											<td class='center' $colorrrr>" . $diff ."</td>
											<td class='center'>" . $enddate2 ."</td>
											<td class='center'>" . $enddate1 ."</td>
											<td class='center' style='color: Green;font-size: 20px;font-weight: bold;'>" . $durationn . "</td>
											<td class='center' style='color: red;font-size: 20px;font-weight: bold;'>" . $daycost . "</td>
										</tr>";
								} ?>
					</tbody>
				</table>
				<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</form>
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
<style>
#dyntable_length{display: none;}
</style>

