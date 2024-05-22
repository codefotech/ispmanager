<?php
$titel = "MacReseller"; 
$MacReseller = 'active';
include('include/hader.php');
include("conn/connection.php") ;
ini_alter('date.timezone','Asia/Almaty');
$current_date_time = date('Y-m-d H:i:s', time());

$terminated_reseller = isset($_GET['way']) ? $_GET['way'] : '';
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'MacReseller' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '39' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$bill_month = isset($_POST['bill_month']) ? $_POST['bill_month'] : '';

if($bill_month == ''){
	$bill_month = date("Y-m-01");
	$thismonthsearch = date('F-Y', time());
}
else{
	$bill_month = $bill_month;
	$thismonthsearch = date('F-Y', strtotime($bill_month));
}


$queryddgaddad = mysql_query("SELECT CONCAT(z.z_name,' - ',e.e_name) AS itemm, SUM(p.p_price) AS tottt FROM `clients` AS c
							LEFT JOIN zone AS z ON z.z_id = c.z_id
							LEFT JOIN package AS p ON p.p_id = c.p_id
							LEFT JOIN emp_info AS e ON e.e_id = z.e_id
							WHERE c.mac_user = '1' AND c.con_sts = 'Active' AND e.terminate = '0' GROUP BY c.z_id ORDER BY SUM(p.p_price) DESC");
		$tnameeee = 'Monthly Estimate Revenue';
		
$myurl133[]="['Reseller','Expense']";
while($qqqq1=mysql_fetch_assoc($queryddgaddad)){
	
	$Itemm = $qqqq1['itemm'];
	$Totall = $qqqq1['tottt'];
	$myurl133[]="['".$Itemm."',".$Totall."]";
}

$queryddgaddd = mysql_query("SELECT b.z_id, z.z_name,CONCAT(z.z_name,' - ',e.e_name) AS itemm, e.e_name, sum(b.bill_amount) AS tottt FROM billing_mac AS b
					LEFT JOIN zone AS z ON z.z_id = b.z_id
					LEFT JOIN emp_info AS e ON e.e_id = z.e_id
					WHERE MONTH(b.entry_date) = MONTH('$bill_month') AND YEAR(b.entry_date) = YEAR('$bill_month') AND b.bill_amount != '0.00' AND b.sts = '0' GROUP BY b.z_id ORDER BY sum(b.bill_amount) DESC");
		$tnameeee1 = 'Mac Reseller Expense';
		
$myurl1331[]="['Reseller','Expense']";
while($qqqq=mysql_fetch_assoc($queryddgaddd)){
	
	$Itemm = $qqqq['itemm'];
	$Totall = $qqqq['tottt'];
	$myurl1331[]="['".$Itemm."',".$Totall."]";
}
if($terminated_reseller == 'terminated'){
$sql = mysql_query("SELECT e.id, e.e_id, e.e_name, e.billing_type, e.minimum_day, m.Name AS mkname, m.ServerIP, e.pre_address, e.e_cont_per, e.over_due, e.e_j_date, z.z_id, z.z_name, z.z_bn_name, COUNT(c.c_id) AS totalclient, l.totalbill AS totalbills, t.totalpayments AS totalpay, t.totaldiscount AS totaldiscounts, (IFNULL(t.totalpayment,0) - l.totalbill) AS totaldue, e.auto_recharge, e.terminate, e.clear FROM emp_info AS e
													LEFT JOIN clients AS c ON e.z_id = c.z_id
													LEFT JOIN
													(SELECT z_id, IFNULL(SUM(bill_amount),0) AS totalbill FROM billing_mac GROUP BY z_id)l
													ON e.z_id = l.z_id
													LEFT JOIN
													(SELECT e_id, z_id, SUM(discount) AS totaldiscount, SUM(pay_amount) AS totalpayments, (SUM(discount)+SUM(pay_amount)) AS totalpayment FROM payment_macreseller GROUP BY e_id)t
													ON e.z_id = t.z_id
													LEFT JOIN zone AS z	ON z.z_id = e.z_id
													LEFT JOIN mk_con AS m ON m.id = e.mk_id
													WHERE e.terminate = '1' AND e.dept_id = '0' AND e.`status` = '0' AND e.z_id != '' GROUP BY e.z_id ORDER BY totalclient ASC");
}
else{
$sql = mysql_query("SELECT e.id, e.e_id, e.e_name, e.billing_type, e.minimum_day, m.Name AS mkname, m.ServerIP, e.pre_address, e.e_cont_per, e.over_due, e.e_j_date, z.z_id, z.z_name, z.z_bn_name, COUNT(c.c_id) AS totalclient, l.totalbill AS totalbills, t.totalpayments AS totalpay, t.totaldiscount AS totaldiscounts, (IFNULL(t.totalpayment,0) - l.totalbill) AS totaldue, e.auto_recharge, e.terminate, e.clear FROM emp_info AS e
													LEFT JOIN clients AS c ON e.z_id = c.z_id
													LEFT JOIN
													(SELECT z_id, IFNULL(SUM(bill_amount),0) AS totalbill FROM billing_mac GROUP BY z_id)l
													ON e.z_id = l.z_id
													LEFT JOIN
													(SELECT e_id, z_id, SUM(discount) AS totaldiscount, SUM(pay_amount) AS totalpayments, (SUM(discount)+SUM(pay_amount)) AS totalpayment FROM payment_macreseller GROUP BY e_id)t
													ON e.z_id = t.z_id
													LEFT JOIN zone AS z	ON z.z_id = e.z_id
													LEFT JOIN mk_con AS m ON m.id = e.mk_id
													WHERE e.terminate = '0' AND e.dept_id = '0' AND e.`status` = '0' AND e.z_id != '' GROUP BY e.z_id ORDER BY totalclient ASC");
}
							$total_reseller = mysql_num_rows($sql);
							
							$sqlssss = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND mac_user = '1'");
							$total_reseller_client = mysql_num_rows($sqlssss);
							
							$sqlssssff = mysql_query("SELECT c_id FROM clients WHERE sts = '0' AND mac_user = '1' AND con_sts = 'Active'");
							$total_reseller_active_client = mysql_num_rows($sqlssssff);
							
							$total_reseller_inactive_client = $total_reseller_client - $total_reseller_active_client;
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total Reseller:  <i style='color: #317EAC'>{$total_reseller}</i></div> 
										<div class='hil'> Total Clients:  <i style='color: #317EAC'>{$total_reseller_client}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$total_reseller_active_client}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$total_reseller_inactive_client}</i></div> 
									</div>";

$resulterer=mysql_query("SELECT z.z_id, z.z_name, e.z_id, e.e_name AS resellername, e.e_id AS resellerid, m.Name AS mkname FROM zone AS z LEFT JOIN emp_info AS e ON e.e_id = z.e_id LEFT JOIN mk_con AS m ON m.id = e.mk_id WHERE z.status = '0' AND z.e_id != '' order by z.z_name");
$query11="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
$result11=mysql_query($query11);

$qaaaa = mysql_query("SELECT client_array AS client_array FROM mk_active_count WHERE sts = '0' AND client_array != '' ORDER BY id DESC LIMIT 1");
$roaa = mysql_fetch_assoc($qaaaa);
$client_array = $roaa['client_array'];
$all_online_client_array = explode(',', $client_array);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		  google.load('visualization', '1.0', {'packages':['corechart']});
		  google.setOnLoadCallback(drawChart);
		  
		  function drawChart() {
			var data = new google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl133));?>
		]);

			// Set chart options
			var options = {'title':'',
							chartArea:{left:'2%',top:'2%',width:'99%',height:'99%'},
							is3D:true,
							pieHole: 0.4,
							fontSize: 12,
							'allowHtml': true};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div1333'));
			chart.draw(data, options);
		  }
    </script>
	<script type="text/javascript">
		  google.load('visualization', '1.0', {'packages':['corechart']});
		  google.setOnLoadCallback(drawChart);
		  
		  function drawChart() {
			var data = new google.visualization.arrayToDataTable([
			<?php echo(implode(",",$myurl1331));?>
		]);

			// Set chart options
			var options = {'title':'',
							chartArea:{left:'2%',top:'2%',width:'99%',height:'99%'},
							is3D:true,
							pieHole: 0.4,
							fontSize: 12,
							'allowHtml': true};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div13331'));
			chart.draw(data, options);
		  }
    </script>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="changenetwork" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Change Reseller Clients Network</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Reseller</div>
						<div class="col-2">
							<select data-placeholder="Choose Reseller" name="z_id" class="chzn-select" style="width:300px;">
									<option value=""></option>
									<?php while ($rowfsdfs=mysql_fetch_array($resulterer)) { ?>
											<option value="<?php echo $rowfsdfs['z_id']?>"><?php echo $rowfsdfs['resellerid']; ?> - <?php echo $rowfsdfs['resellername']; ?> (<?php echo $rowfsdfs['z_name']; ?>) - (<?php echo $rowfsdfs['mkname']; ?>)</option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Transfer Client to </div>
						<div class="col-2">
							<select data-placeholder="Choose Mikrotik" name="mk_id" class="chzn-select" style="width:300px;">
									<option value=""></option>
											<?php while ($row11=mysql_fetch_array($result11)) { ?>
									<option value="<?php echo $row11['id']?>"><?php echo $row11['id']?> - <?php echo $row11['Name']; ?> (<?php echo $row11['ServerIP']; ?>)</option>
											<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="" style="color: red;font-weight: bold;">This change will effect only in application. To transfer users from old mikrotik to new mikrotik follow below instructions. . . . .<br>Network > PPPoE Secret > Click Sync Button > [Check] Restore Clients > [SUBMIT]</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
		<?php if(in_array(146, $access_arry)){?>
			<button class="btn ownbtn3" href="#myModal" data-toggle="modal" title="Change Reseller Mikrotik" />Change Mikrotik</button>
		<?php } if(in_array(147, $access_arry)){?>
			<a class="btn ownbtn2" href="MacResellerAdd" title="Add New Reseller"/>Add Reseller</a>
		<?php } if($terminated_reseller != 'terminated'){?>
			<a class='btn ownbtn4' style='padding: 7px 8px 7px;'  href="MacReseller?way=terminated" title="Terminated Reseller" /><i class="iconfa-thumbs-down" style="font-size: 13px;"></i></a>
		<?php } else{ ?>
			<a class='btn ownbtn9' style='padding: 7px 8px 7px;'  href="MacReseller" title="Active Reseller" /><i class="iconfa-thumbs-up" style="font-size: 13px;"></i></a>
		<?php } if(in_array(148, $access_arry)){?>
			<a class='btn ownbtn4' style='padding: 7px 8px 7px;' href="cron_auto_inactive_termination" title="Sync Reseller Clients" /><i class="iconfa-stop" style="font-size: 13px;"></i></a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Mac Reseller</h1>
        </div>
    </div><!--pageheader-->		
	<?php if($sts == 'delete') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			
	</div><!--alert-->
	<?php } if($sts == 'changenetwork') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> All Clients are Successfully Transfered to New Mikrotik.			
	</div><!--alert-->	
	<?php } if($sts == 'add') {?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">&times;</button>
		<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			
	</div><!--alert-->		
	<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>			
	<div class="box box-primary">
		<div class="box-header">
			<h5><?php echo $tit; ?></h5>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">Reseller ID</th>
                            <th class="head0">Name/Cell/Mikrotik</th>
							<th class="head1">Zone Info</th>
							<th class="head0 center">ONLINE/OFFLINE</th>
							<th class="head1 center">M.Day/Auto Recharge</th>
							<th class="head0 center">Due Limit</th>
							<th class="head1 center">Current Balance</th>
                            <th class="head0 center">Action</th>
						<?php if($reseller_per_delete == '1' || $user_type == 'admin' || $delete_reseller_till_time > $current_date_time || $reseller_per_delete == '1' && $user_type == 'superadmin' && $delete_reseller_till_time > $current_date_time){?>
                            <th class="head1 center">Delete</th>
						<?php } ?>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						$x = 1;	
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['totaldue'] == ''){
									$billz=$row['totalbills'];								
								}
								else{
									$billz=$row['totaldue'];
								}
								if($row['auto_recharge'] == '1'){
									$autoooo = "<span class='label' title='Auto Recharge On for {$row['minimum_day']} Day' style='background-color:#0866c6d6;font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>ON</span>";								
								}
								else{
									$autoooo = "<span class='label' title='Auto Recharge Off' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;background-color:#953b39;'>OFF</span>";								
								}
								if($row['billing_type'] == 'Postpaid'){
									$colorsdf = ' label-important';
									$over_due_limit = '';
									$corrr2 = '#555555';
									$corrrts = 'font-size: 15px;';
								}
								else{
									$colorsdf = ' label-success';
									$over_due_limit = $row['over_due'];
									$corrr2 = 'red';
									$corrrts = 'font-size: 18px;';
								}
								if($row['terminate'] == '1'){
									$colorrrr = 'style="vertical-align: middle;line-height: 25px;"';
									$colorrrr2 = '';
									$msgg = "<br><br>[Terminated]";
								}
								else{
									$colorrrr = 'style="vertical-align: middle;line-height: 25px;"';
									$colorrrr2 = '';
									$msgg = "";
								}
								if($row['z_bn_name'] != ''){
									$zbnname = ' ('.$row['z_bn_name'].')';
								}
								else{
									$zbnname = '';
								}
									$qyaaaa = mysql_query("SELECT GROUP_CONCAT(c_id SEPARATOR ',') AS c_id FROM clients WHERE z_id = '{$row['z_id']}' AND sts = '0' AND mac_user = '1'");
									$rohha = mysql_fetch_assoc($qyaaaa);
									$all_client_arrayy = $rohha['c_id'];
									$all_client_array = explode(',', $all_client_arrayy);
									$totalcount = count($all_client_array);

									$commonValues = array_intersect($all_online_client_array, $all_client_array);
									$total_online_count = count($commonValues);


									$total_offline_count = $totalcount - $total_online_count;

									$queaaaa = mysql_query("SELECT COUNT(id) AS totalpack FROM package WHERE status = '0' AND z_id = '{$row['z_id']}'");
									$roaaa = mysql_fetch_assoc($queaaaa);
									$totalpack = $roaaa['totalpack'];
									
									$queryaaaa = mysql_query("SELECT COUNT(id) AS activeclient FROM clients WHERE con_sts = 'Active' AND z_id = '{$row['z_id']}' AND sts = '0'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);
									$activeclient = $rowaaaa['activeclient'];
									
									$queryiiiii = mysql_query("SELECT COUNT(id) AS inactiveclient FROM clients WHERE con_sts = 'Inactive' AND z_id = '{$row['z_id']}' AND sts = '0'");
									$rowiii = mysql_fetch_assoc($queryiiiii);

									$inactiveclient = $rowiii['inactiveclient'];
									
									$totalclients = $activeclient + $inactiveclient;
									
									$qryrr1=mysql_query("SELECT user_id, password FROM login WHERE e_id = '{$row['e_id']}'");
									$rdga1=mysql_fetch_assoc($qryrr1);
								
									echo
										"<tr class='gradeX'>
											<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 16px;width: 80px;'>{$row['e_id']}<b style='font-size: 15px;font-weight: bold;color: red;'>{$msgg}</b></td>
											<td $colorrrr><a href='Clients?id=macclient&zid={$row['z_id']}' style='font-weight: bold;font-size: 16px;color: #555555;'>{$row['e_name']}</a><br><a style='font-weight: bold;' href='tel:{$row['e_cont_per']}'>{$row['e_cont_per']}</a><br><b>[{$row['mkname']} - {$row['ServerIP']}]</b></td>
											<td $colorrrr><span style='font-weight: bold;font-size: 16px;'>{$row['z_name']}</span> <span style='font-weight: bold;font-size: 14px;'>{$zbnname}</span>
											<br>
											<a href='Clients?id=macclient&zid={$row['z_id']}' title='Total Active Clients' class='label label-success' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$activeclient}</a> 
											<a href='Clients?id=macclient&zid={$row['z_id']}' title='Total Inactive Clients' class='label label-important' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$inactiveclient}</a>
											<a href='Clients?id=macclient&zid={$row['z_id']}' title='Total Clients' class='label' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;'>{$totalclients}</a>
											<br>
											<span title='Total Package' class='label' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;background-color: #00404f99 !important;'>Packages: {$totalpack}</span>
											</td>
											<td class='center' style='vertical-align: middle;'>
											<a href='Clients?id=macclient&zid={$row['z_id']}&RealtimeStatus=Online' title='Total Online Clients' class='label label-success' style='font-size: 18px;font-weight: bold;padding: 4px 4px;border-radius: 3px;'>{$total_online_count}</a>
											<a href='Clients?id=macclient&zid={$row['z_id']}&RealtimeStatus=Offline' title='Total Offline Clients' class='label label-important' style='font-size: 18px;font-weight: bold;padding: 4px 4px;border-radius: 3px;'>{$total_offline_count}</a></td>
											<td class='center' style='vertical-align: middle;line-height: 25px;width: 150px;'><span class='label{$colorsdf}' title='Billing Type: {$row['billing_type']}' style='font-weight: bold;padding: 6px 10px;border-radius: 3px;margin-bottom: 3px;{$corrrts}'>{$row['billing_type']}</span>
											<br><span class='label' title='Minimum Recharge Day: {$row['minimum_day']}' style='font-size: 14px;font-weight: bold;padding: 3px 6px;border-radius: 3px;margin-right: 3px;background-color:#00404f99;'>{$row['minimum_day']} Day</span>{$autoooo}</td>
											<td style='vertical-align: middle;font-size: 18px;font-weight: bold;text-align: center;color: $corrr2;'>{$over_due_limit}</td>
											<td style='vertical-align: middle;font-size: 20px;font-weight: bold;text-align: center;color: purple;'>{$billz}</td>\n";
									$x++;?>
							
											<td class='center' style='width: 100px !important;padding: 6px 0px; <?php echo $colorrrr2;?>'>
												<table style="width: 100%;">
													<tbody>
													<tr>
														<td class='center' style="border-right: none;border-left: none;">
															<ul class='tooltipsample'>
																<?php if(in_array(143, $access_arry)){?>
																	<li><a href='MacResellerBillHistory?id=<?php echo $row['z_id'];?>' title='View Reseller' class='btn ownbtn2' style='padding: 6px 9px;'><i class='fa iconfa-eye-open'></i></a></li>
																<?php } if(in_array(144, $access_arry)){?>
																	<li><a href='MacResellerPayment?id=<?php echo $row['z_id'];?>' title='Full History & Payment' class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-money'></i></a></li>
																<?php } ?>
															</ul>
														</td>
													</tr>
													<tr>
														<td class='center' style="border-right: none;border-left: none;">
															<ul class='tooltipsample' style="">
																<?php if(in_array(145, $access_arry)){?>
																	<li><a href='MacResellerEdit?id=<?php echo $row['id'];?>' title='Edit Reseller' class='btn ownbtn5' style='padding: 6px 9px;'><i class='iconfa-edit'></i></a></li>
																<?php } if($user_type == 'admin' || $user_type == 'superadmin') {?>
																	<li><form action='login_exec' method='post'><input type="hidden" name="location_service" value="0"/><input type='hidden' name='username' value='<?php echo $rdga1['user_id'];?>' /><input type='hidden' name='wayy' value='loginasuser' /><input type='hidden' name='passwordd' value='<?php echo $rdga1['password'];?>' /><button class='btn' style="border-radius: 3px;border: 1px solid red;color: red;padding: 6px 9px;" title='Login As Reseller'><i class='iconfa-signin'></i></button></form></li>
																<?php } ?>
															</ul>
														</td>
													</tr>
													</tbody>
												</table>
											</td>
											<?php if($reseller_per_delete == '1' || $user_type == 'admin' || $delete_reseller_till_time > $current_date_time || $reseller_per_delete == '1' && $user_type == 'superadmin' && $delete_reseller_till_time > $current_date_time){?>
												<td class='center' style='width: 30px;'>
													<ul class='tooltipsample' style="padding: 22px 0px;">
														<?php if($row['clear'] == '0'){?>
															<li><form action='MacResellerClear' onclick='return checkClear()' method='post'><input type='hidden' name='z_id' value='<?php echo $row['z_id'];?>' /><button class='btn ownbtn4' title='Clear All Payments and bills'><i class='iconfa-remove'></i></button></form></li>
														<?php } if($row['clear'] == '1'){?>
															<li><form action='ResellerDelete' onclick='return checkDelete()' method='post'><input type='hidden' name='e_id' value='<?php echo $row['e_id'];?>' /><input type='hidden' name='z_id' value='<?php echo $row['z_id'];?>' /><button class='btn ownbtn4' title='Permanent Delete'><i class='iconfa-trash'></i></button></form></li>
														<?php } ?>
													</ul>
												</td>
											<?php } ?>
										</tr>
							<?php } ?>
					</tbody>
				</table><br>
			<div class="row-fluid">
				<div id="dashboard-left" class="span6">
					<div class="modal-content" style="border: 2px solid #0866c6;margin: 5px 0px 0px 0px;">
						<div class="" style="overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
							<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 10px;font-weight: bold;background: none;float: left;"><?php echo $tnameeee;?></div>
						</div>
						<div class="" style="overflow: hidden;">
							<div id="chart_div1333" style="height: 400px;"></div>
						</div><!--widgetcontent-->
					</div>	
					</div>	
					<div id="dashboard-left" class="span6">
					<div class="modal-content" style="border: 2px solid #0866c6;">
						<div class="" style="overflow: hidden;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">
							<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 10px;font-weight: bold;background: none;float: left;"><?php echo $tnameeee1;?> [<?php echo $thismonthsearch;?>]</div>
							<form id="form2" class="stdform" style="width: 20%;float: right;" method="post" action="<?php echo $PHP_SELF;?>">
								<select name="bill_month" class="" style="height: 30px;" onchange="submit();">
									<option value="<?php echo date("Y-m-01") ?>"><?php echo date("M-Y") ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-1 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-1 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-2 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-2 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-3 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-3 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-4 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-4 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-5 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-5 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-6 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-6 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-7 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-7 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-8 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-8 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-9 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-9 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-10 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-10 Months",strtotime(date('Y-m-01')))) ?></option>
									<option value="<?php echo date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?>"<?php if ($bill_month == date("Y-m-01",strtotime("-11 Months",strtotime(date('Y-m-01'))))) echo 'selected="selected"';?>><?php echo date("M-Y",strtotime("-11 Months",strtotime(date('Y-m-01')))) ?></option>
								</select>
							</form>
						</div>
						<div class="" style="overflow: hidden;">
							<div id="chart_div13331" style="height: 400px;"></div>
						</div>
					</div>
				</div>	
			</div>	
			</div>			
	</div

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				

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
			"iDisplayLength": 50,
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
<script language="JavaScript" type="text/javascript">
function checkClear(){
    return confirm('Permanently Deleting!! Are you sure?');
}
function checkDelete(){
    return confirm('Permanently Deleting!! Are you sure?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>