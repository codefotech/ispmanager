<?php
$titel = "Package/Bandwith Change";
$PackageChange = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'PackageChange' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());

if($user_type == 'mreseller'){
$queryr = mysql_query("SELECT c.c_id, c.com_id, c.c_name, c.cell, p.p_name, p.p_price, p.bandwith FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.con_sts = 'Active' AND c.sts = '0' AND c.z_id = '$macz_id' ORDER BY c.c_name");
}
else{
	if($user_type == 'billing'){
		$queryr = mysql_query("SELECT c.c_id, c.com_id, c.c_name, c.cell, p.p_name, p.p_price, p.bandwith FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE c.con_sts = 'Active' AND c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 AND c.breseller != '2' ORDER BY c.com_id ASC");
	}
	else{
		$queryr = mysql_query("SELECT c.c_id, c.com_id, c.c_name, c.cell, p.p_name, p.p_price, p.bandwith FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.con_sts = 'Active' AND c.sts = '0' AND c.breseller != '2' ORDER BY c.com_id ASC");
	}
}

if($cid != ''){
$que = mysql_query("SELECT c.c_id, c.com_id, c.c_name, c.con_sts, c.termination_date, c.ip, p.bandwith, c.mac, c.breseller, c.cell, c.mac_user, c.mk_id, c.raw_download, c.raw_upload , c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.discount, c.total_price, c.address, c.p_id, p.p_name, p.p_price FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.c_id = '$cid'");
$rows = mysql_fetch_assoc($que);

$ppp_id = $rows['p_id'];
$mkkkid = $rows['mk_id'];
$ppricee = $rows['p_price'];
$bpricee = $rows['total_price'];

$que1 = mysql_query("SELECT id, c_id, bill_amount, day, pack_chng FROM billing WHERE c_id = '$cid' ORDER BY id DESC LIMIT 1");
$rows1 = mysql_fetch_assoc($que1);

$sql2 = mysql_query("SELECT z.z_id, z.e_id, z.p_id, c.mac_user, p.p_price FROM clients AS c
						LEFT JOIN zone AS z	ON z.z_id = c.z_id
						LEFT JOIN package AS p ON p.p_id = c.p_id
						WHERE c.c_id = '$cid'");
$rowss = mysql_fetch_array($sql2);
$ee_idd = $rowss['e_id'];
$zz_idd = $rowss['z_id'];
$zz_p_id = $rowss['p_id'];
$mac_userrrr = $rowss['mac_user'];
$pppprice = $rowss['p_price'];
}

if($user_type == 'mreseller'){
if($ee_idd != ''){
	if($reseller_downgrade == '1'){
		$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '$zz_idd' AND `status` = '0' AND p_id !='$ppp_id' order by id ASC");
	}
	else{
		$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '$zz_idd' AND `status` = '0' AND p_id !='$ppp_id' AND p_price > '$pppprice' order by id ASC");
	}
}
else{
	$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '' AND `status` = '0' AND p_id !='$ppp_id' order by id ASC");
}
}
else{
if($ee_idd != ''){
		$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '$zz_idd' AND `status` = '0' AND p_id !='$ppp_id' order by id ASC");
}
else{
	if($zz_p_id == ''){
		$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '' AND `status` = '0' AND p_id !='$ppp_id' order by id ASC");
	}
	else{
		$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '' AND `status` = '0' AND p_id !='$ppp_id' AND p_id IN ($zz_p_id) order by id ASC");
	}
}
}

if($user_type == 'mreseller'){
$sql = mysql_query("SELECT p.id, e.e_name, p.ent_by, c.com_id, DATE_FORMAT(p.date_time, '%D %M %Y %h:%i%p') AS date_time, DATE_FORMAT(p.ent_date, '%D %b %y') AS ent_date, pc.p_price AS pcprice, pc.bandwith, pcc.bandwith AS pccbandwith, pcc.p_price AS pccprice, p.c_id, p.old_raw_download, p.old_raw_upload, p.old_youtube_bandwidth, p.old_total_bandwidth, p.old_bandwidth_price, p.old_youtube_price, p.old_total_price, p.new_raw_download, p.new_raw_upload, p.new_youtube_bandwidth, p.new_total_bandwidth, p.new_bandwidth_price, p.new_youtube_price, p.new_total_price, p.used_day, p.used_day_price, p.remaining_day, p.remaining_day_price, (p.used_day_price + p.remaining_day_price) AS totalbill, c.address, c.cell, c.c_name, pc.p_name AS a, pcc.p_name AS b, p.up_date, p.note, c.breseller, p.bill_calculation FROM package_change AS p 
					LEFT JOIN package AS pc ON p.c_package = pc.p_id
					LEFT JOIN package AS pcc ON pcc.p_id = p.new_package
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN emp_info AS e ON e.e_id = p.ent_by WHERE c.z_id = '$macz_id' ORDER BY p.id DESC");

$ques = mysql_query("SELECT b.id, b.c_id, c.cell, c.address, c.z_id, c.con_sts, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, c.termination_date, b.days, b.start_date, b.start_time, b.end_date, b.p_id, p.p_name, p.bandwith, p.p_price, b.bill_amount FROM billing_mac AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$cid' ORDER BY b.id DESC LIMIT 1");
$rowwgg = mysql_fetch_assoc($ques);
$idq = $rowwgg['id'];
$mk_id = $rowwgg['mk_id'];
$olp_package = $rowwgg['p_id'];
$old_price = $rowwgg['p_price'];
$old_days = $rowwgg['days'];
$old_bill_amount = $rowwgg['bill_amount'];
}
else{
	if($user_type == 'billing'){
	$sql = mysql_query("SELECT p.id, c.com_id, e.e_name, p.ent_by, DATE_FORMAT(p.date_time, '%D %M %Y %h:%i%p') AS date_time, DATE_FORMAT(p.ent_date, '%D %b %y') AS ent_date, pc.p_price AS pcprice, pc.bandwith, pcc.bandwith AS pccbandwith, pcc.p_price AS pccprice, p.c_id, p.old_raw_download, p.old_raw_upload, p.old_youtube_bandwidth, p.old_total_bandwidth, p.old_bandwidth_price, p.old_youtube_price, p.old_total_price, p.new_raw_download, p.new_raw_upload, p.new_youtube_bandwidth, p.new_total_bandwidth, p.new_bandwidth_price, p.new_youtube_price, p.new_total_price, p.used_day, p.used_day_price, p.remaining_day, p.remaining_day_price, (p.used_day_price + p.remaining_day_price) AS totalbill, c.address, c.cell, c.c_name, pc.p_name AS a, pcc.p_name AS b, p.up_date, p.note, c.breseller, p.bill_calculation FROM package_change AS p 
					LEFT JOIN package AS pc ON p.c_package = pc.p_id
					LEFT JOIN package AS pcc ON pcc.p_id = p.new_package
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN zone AS z ON z.z_id = c.z_id
					LEFT JOIN emp_info AS e ON e.e_id = p.ent_by 
					WHERE FIND_IN_SET('$e_id', z.emp_id) > 0 ORDER BY p.id DESC");
	}
	else{
	$sql = mysql_query("SELECT p.id, c.com_id, e.e_name, p.ent_by, DATE_FORMAT(p.date_time, '%D %M %Y %h:%i%p') AS date_time, DATE_FORMAT(p.ent_date, '%D %b %y') AS ent_date, pc.p_price AS pcprice, pc.bandwith, pcc.bandwith AS pccbandwith, pcc.p_price AS pccprice, p.c_id, p.old_raw_download, p.old_raw_upload, p.old_youtube_bandwidth, p.old_total_bandwidth, p.old_bandwidth_price, p.old_youtube_price, p.old_total_price, p.new_raw_download, p.new_raw_upload, p.new_youtube_bandwidth, p.new_total_bandwidth, p.new_bandwidth_price, p.new_youtube_price, p.new_total_price, p.used_day, p.used_day_price, p.remaining_day, p.remaining_day_price, (p.used_day_price + p.remaining_day_price) AS totalbill, c.address, c.cell, c.c_name, pc.p_name AS a, pcc.p_name AS b, p.up_date, p.note, c.breseller, p.bill_calculation FROM package_change AS p 
					LEFT JOIN package AS pc ON p.c_package = pc.p_id
					LEFT JOIN package AS pcc ON pcc.p_id = p.new_package
					LEFT JOIN clients AS c ON c.c_id = p.c_id
					LEFT JOIN emp_info AS e ON e.e_id = p.ent_by ORDER BY p.id DESC");
	}
	
$ques = mysql_query("SELECT b.id, b.c_id, c.cell, c.address, c.z_id, c.con_sts, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, c.termination_date, b.days, b.start_date, b.start_time, b.end_date, b.p_id, p.p_name, p.bandwith, p.p_price, b.bill_amount FROM billing_mac AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$cid' ORDER BY b.id DESC LIMIT 1");
$rowwgg = mysql_fetch_assoc($ques);
$idq = $rowwgg['id'];
$mk_id = $rowwgg['mk_id'];
$olp_package = $rowwgg['p_id'];
$old_price = $rowwgg['p_price'];
$old_days = $rowwgg['days'];
$old_bill_amount = $rowwgg['bill_amount'];
}

$yrdata= strtotime($rows['termination_date']);
$terminationdate = date('F d, Y', $yrdata);

$diff = abs(strtotime($rows['termination_date']) - strtotime($dateTimeee))/86400;
?>
<script type="text/javascript">
function updatesum() {
document.form.new_total_bandwidth.value = (document.form.new_raw_download.value -0) + (document.form.new_raw_upload.value -0) + (document.form.new_youtube_bandwidth.value -0);
document.form.new_price.value = (document.form.new_bandwidth_price.value -0) + (document.form.new_youtube_price.value -0);
}
</script>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Choose Client for Change Package/Bandwith</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<select data-placeholder="Choose a Client" name="cid" class="chzn-select"  style="width:510px;" onchange="submit();">
								<option value=""></option>
							<?php while ($row2=mysql_fetch_array($queryr)) { ?>
							<option value="<?php echo $row2['c_id'];?>" style="font-weight: bold;"><?php echo $row2['com_id'];?> | <?php echo $row2['c_id'];?> | <?php echo $row2['c_name'];?> | <?php echo $row2['p_name'].' ('.$row2['bandwith'].' - '.$row2['p_price'].' TK)';?></option>
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
		<?php if($cid == ''){?>
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6;border: 1px solid #0866c6;font-size: 14px;" href="#myModal" data-toggle="modal">Change Package/Bandwith </a>
        <?php } else{ ?>
			<a class="btn ownbtn2" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		<?php } ?>
		</div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Package Change</h1>
        </div>
    </div><!--pageheader-->
<?php if($sts == 'done') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Changed in Your System.
			</div><!--alert-->
<?php } ?>
	<div class="box box-primary">
	<?php if($cid == ''){?>
		<div class="box-header">
			<h5>All Package/Bandwith Change Details</h5>
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
							<th class="head1 center">S/L</th>
                            <th class="head0">Change By</th>
							<th class="head0">Client ID/Name/Cell</th>
							<th class="head1">Old_Package</th>
							<th class="head1 center">Price</th>
							<th class="head0">New_Package</th>
							<th class="head0 center">Price</th>
							<th class="head0 center">Calculation</th>
							<th class="head1 center">New Bill</th>
                            <th class="head0">Note</th>
							
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['breseller'] == '1'){
										$hhhh = 'D: '.$row['old_raw_download'] .' + U: '.$row['old_raw_upload'].' + Y: '.$row['old_youtube_bandwidth'].' = '.$row['old_total_bandwidth'].'mb <br> Price: '.$row['old_total_price'].' tk';
										$qqqq = 'D: '.$row['new_raw_download'] .' + U: '.$row['new_raw_upload'].' + Y: '.$row['new_youtube_bandwidth'].' = '.$row['new_total_bandwidth'].'mb <br> Price: '.$row['new_total_price'].' tk';
									}
									else{
										$hhhh = $row['a'].' ('.$row['bandwith'].') <br> Price: '.$row['pcprice'].' tk';
										$qqqq = $row['b'].' ('.$row['pccbandwith'].') <br> Price: '.$row['pccprice'].' tk';
									}
									
									if($row['bill_calculation'] == 'Auto'){
										$calculation = 'Day Calculation';
									}
									elseif($row['bill_calculation'] == 'Manual'){
										$calculation = 'New Package Price';
									}
									else{
										$calculation = 'No Change';
									}
									
									echo
										"<tr class='gradeX'>
											<td class='center' style='padding: 20px 10px;font-weight: bold;'>{$row['id']}</td>
											<td><b>{$row['e_name']}</b><br><br>{$row['date_time']}</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}</td>
											<td>{$hhhh}<br><b style='color: purple;'>Total Used: {$row['used_day']} Days</b></td>
											<td class='center' style='padding: 20px 10px;font-weight: bold;'>{$row['used_day_price']}/=</td>
											<td>{$qqqq}<br><b style='color: purple;'>Total Remaining: {$row['remaining_day']} Days</b></td>
											<td class='center' style='padding: 20px 10px;font-weight: bold;'>{$row['remaining_day_price']}/=</td>
											<td class='center' style='padding: 20px 10px;font-weight: bold;'>{$calculation}</td>
											<td class='center' style='padding: 20px 10px;font-weight: bold;font-size: 14px;'>{$row['totalbill']}/=</td>
											<td>{$row['note']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>	
		<?php }else{ if($mac_userrrr == '1'){ ?>
		
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Package/Bandwith Change</h5>
				</div>
				<form id="form" class="stdform" method="POST" name="form" action="PackageChangeSave" enctype="multipart/form-data">
				<input type ="hidden" name="id_mbill" value="<?php echo $idq;?>">
				<input type ="hidden" name="olp_package" value="<?php echo $olp_package;?>">
				<input type ="hidden" name="old_price" value="<?php echo $old_price;?>">
				<input type ="hidden" name="old_days" value="<?php echo $old_days;?>">
				<input type ="hidden" name="old_bill_amount" value="<?php echo $old_bill_amount;?>">
				<input type ="hidden" name="c_id" value="<?php echo $cid;?>">
				<input type ="hidden" name="z_id" value="<?php echo $zz_idd;?>">
				<input type ="hidden" name="termination_date" value="<?php echo $rows['termination_date'];?>">
				<input type ="hidden" name="end_date" value="<?php echo $dateTimeee;?>">
				<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>" />
				<input type="hidden" name="ent_by" value="<?php echo $e_id;?>" />
				<input type="hidden" name="macuser" value="1" />
				<input type="hidden" name="macz_id" value="<?php echo $zz_idd;?>" />
					<div class="modal-body" style="min-height: 180px;">
                        <table class="table table-bordered table-invoice" style="width:100%">
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Current Package</td>
                                <td style="font-size: 18px;font-weight: bold;width: 51%;"><?php echo $rows['p_name'];?> || <?php echo $rows['bandwith']; ?> || <?php echo $rows['p_price'];?>৳</td>
                                <td rowspan="5">
								<strong>
									<a style="font-size: 18px;font-weight: bold;color: darkgreen;"><?php echo $rows['c_id'];?></a>
								</strong> <br />
									<a style="font-size: 15px;font-weight: bold;color: darkmagenta;"><?php echo $rows['c_name'];?></a> <br />
                                    <a style="font-size: 13px;color: black;"><?php echo $rows['cell'];?></a><br />
                                    <a style="font-size: 13px;color: black;"><?php echo $rows['address'];?></a> <br />
                                    <a style="font-weight: bold;font-size: 15px;color: green;">[<?php echo $rows['con_sts'];?>]</a></td>
						   </tr>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Termination Date</td>
                                <td style="font-size: 17px;font-weight: bold;color: darkmagenta;width: 51%;"><?php echo $terminationdate;?> </td>
                            </tr>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Remaining Days</td>
                                <td style="font-size: 18px;font-weight: bold;color: green;width: 51%;"><?php echo $diff;?> Days <span id="Pointdiv1" style="font-weight: bold;color: red;"></td>
                            </tr>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Choose New Package</td>
                                <td style="font-size: 20px;font-weight: bold;color: maroon;width: 51%;">
									<select data-placeholder="Choose a Package" class="chzn-select" name="p_id" id="p_id" style="width:65%" required="" onChange="getRoutePoint(this.value)">
												<option value=""></option>
													<?php while ($row1w=mysql_fetch_array($result1)) { ?>
												<option value="<?php echo $row1w['p_id']?>"><?php echo $row1w['p_name']; ?> (<?php echo $row1w['bandwith'];?> - <?php echo $row1w['p_price'].' TK';?>)</option>
													<?php } ?>
									</select>
								</td>
                            </tr>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Note</td>
                                <td style="font-size: 18px;font-weight: bold;color: green;width: 51%;"><textarea type="text" name="note" style="width: 60%;" placeholder="Note........" id="" class="input-xxlarge" /></textarea></td>
                            </tr>
                        </table>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>			
			</div>
		</div>
		
		<?php }else{ ?>
					<div class="box-header">
						<div class="modal-content">
							<div class="modal-header">
								<h5>Client Package Change</h5>
							</div>
								<form id="form" class="stdform" method="POST" name="form" action="PackageChangeSave" enctype="multipart/form-data">
									<?php if($rows['breseller'] == '0'){?>
									<input type="hidden" name="c_package" value="<?php echo $rows['p_id']; ?>" />
									<input type="hidden" name="oldprice" value="<?php echo $rows['p_price'];?>" />
									<?php } else{ ?>
									<input type="hidden" name="oldprice" value="<?php echo $bpricee;?>" />
									<?php } ?>
									<input type="hidden" name="mac_user" value="<?php echo $rows['mac_user']; ?>" />
									<input type="hidden" name="mk_id" value="<?php echo $rows['mk_id'];?>" />
									<input type="hidden" name="breseller" value="<?php echo $rows['breseller'];?>" />
									<input type="hidden" name="ent_by" value="<?php echo $e_id; ?>" />
									<input type="hidden" name="c_id" value="<?php echo $cid; ?>" />
									<input type="hidden" name="bill_id" value="<?php echo $rows1['id']; ?>" />
									<input type="hidden" name="ent_date" value="<?php echo date("Y-m-d");?>" />
									<input type="hidden" name="adjustment" value="<?php echo $rows1['bill_amount'];?>" />
									<input type="hidden" name="day" value="<?php echo $rows1['day'];?>" />
									<input type="hidden" name="pack_chng" value="<?php echo $rows1['pack_chng'];?>" />
									<input type="hidden" name="macuser" value="0" />
										<div class="modal-body">
											<p>
												<label style="font-weight: bold;">Client ID/Name</label>
												<h4 style="padding-top: 5px;"><?php echo $rows['com_id'].' || '.$rows['c_id'].' || '.$rows['cell'];?></h4>
											</p>
											<?php if($rows['address'] != ''){ ?>
											<p>
												<label style="font-weight: bold;">Address</label>
												<h4 style="padding-top: 5px;"><?php echo $rows['address'];?></h4>
											</p>
											<?php } if($rows['ip'] != ''){ ?>
											<p>
												<label>Old IP Address</label>
												<h4 style="padding-top: 5px;"><?php echo $rows['ip'];?></h4>
											</p>
											<?php } if($rows['breseller'] == '0'){?>
											<p>
												<label style="font-weight: bold;">Current Package</label>
												<span class="field"><input type="text" name="package" id="" required="" style="width:330px;" readonly value="<?php echo $rows['p_name'];?> ( <?php echo $rows['bandwith'];?> - <?php echo $rows['p_price'];?> TK) <?php echo $rows['ip'];?>" /></span>
											</p>
											<p>
												<label style="font-weight: bold;">New Package*</label>
												<span class="field">
													<select data-placeholder="Choose a Package" class="chzn-select" name="p_id" id="p_id" style="width:340px;" required="" >
														<option value=""></option>
															<?php while ($row1=mysql_fetch_array($result1)) { ?>
														<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['bandwith'];?> - <?php echo $row1['p_price'].' TK';?>)</option>
															<?php } ?>
													</select>
													<br /><span id="resultpack" style="font-weight: bold;"></span>
												</span>	
											</p>
											<p>
												<label>IP Address</label>
												<span class="field"><input type="text" style="width:240px;" id="ip" name="ip" placeholder="Ex: 192.168.XX.XX" class="input-xlarge"/><br>
												<span id="result1" style="font-weight: bold;"></span>
												</span>
											</p>
											
											<p>
												<label style="font-weight: bold;">This Month Bill*</label>
												<span class="formwrapper" style="margin-left: 0;">
													<input type="radio" name="qcalculation" value="Auto" checked="checked"> Day Calculation &nbsp; &nbsp;
													<input type="radio" name="qcalculation" value="Manual"> Set New Package Price &nbsp; &nbsp;
													<input type="radio" name="qcalculation" value="No"> No Change &nbsp; &nbsp;
												</span>
											</p>
											
											<?php } else{?>
											<p>
												<label>IP Address</label>
												<span class="field"><input type="text" name="" id="" required="" style="width:240px;" readonly value="<?php echo $rows['ip'];?>" /></span>
											</p>
											<p>
												<label>MAC Address</label>
												<span class="field"><input type="text" name="" id="" required="" style="width:240px;" readonly value="<?php echo $rows['mac'];?>" /></span>
											</p>
											<p>
												<label>Current Bandwidth</label>
												<span class="field"><input type="text" readonly name="old_raw_download" style="width: 135px;" placeholder="Download" class="input-large" value="<?php echo $rows['raw_download'];?>" />&nbsp;&nbsp;<input type="text" readonly name="old_raw_upload" style="width: 135px;" placeholder="Upload" class="input-large" value="<?php echo $rows['raw_upload'];?>"/>&nbsp;&nbsp;<input type="text" name="old_youtube_bandwidth" style="width: 135px;" readonly placeholder="" class="input-large" value="<?php echo $rows['youtube_bandwidth'];?>" />&nbsp;<input type="text" name="old_total_bandwidth" readonly placeholder="Total" style="width: 60px;" value="<?php echo $rows['total_bandwidth'];?>" /> <b>mb</b></span>
											</p>
											<p>
												<label>Current Price</label>
												<span class="field"><input type="text" readonly name="old_bandwidth_price" placeholder="Raw Price" id="" class="input-large" value="<?php echo $rows['bandwidth_price'];?>" />&nbsp;&nbsp;<input type="text" name="old_youtube_price" readonly id="" class="input-large" value="<?php echo $rows['youtube_price'];?>" />&nbsp;<input type="text" name="oldprice" readonly placeholder="Total" id="" style="width: 60px;" value="<?php echo $rows['total_price'];?>"> <b>TK</b></span>
											</p>
											<p>
												<label>New Bandwidth</label>
												<span class="field"><input type="text" name="new_raw_download" style="width: 135px;" placeholder="Download" required="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="new_raw_upload" style="width: 135px;" required="" placeholder="Upload" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="new_youtube_bandwidth" style="width: 135px;" required="" placeholder="YouTube Bandwidth" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="new_total_bandwidth" readonly placeholder="Total" style="width: 60px;" onChange="updatesum()" /> <b>mb</b></span>
											</p>
											<p>
												<label>New Price</label>
												<span class="field"><input type="text" required="" name="new_bandwidth_price" placeholder="Raw Price" id="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="new_youtube_price" required="" placeholder="YouTube Price" id="" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="new_price" readonly placeholder="Total" id="" style="width: 60px;" onChange="updatesum()" /> <b>TK</b></span>
											</p>
											<?php }?>
											
											<input type="hidden" name="up_date" id="" required="" class="input-xxlarge" readonly value="<?php echo date("Y-m-d");?>" /></span>
											
											<p>
												<label>Note</label>
												<span class="field"><textarea type="text" name="note" placeholder="Note........" id="" class="input-xxlarge" /></textarea>
												<br /><br /><a style= "color:red;font-weight: bold;"> >> Day Calculation: New price will automatic calculate (Day wise) with this month bill.</a>
												<br /><a style= "color:red;font-weight: bold;"> >> Set New Package Price: New package price will set on this month bill.</a>
												</span>
											</p>
										</div>
										<div class="modal-footer">
											<button type="reset" class="btn ownbtn11">Reset</button>
											<button class="btn ownbtn2" type="submit">Submit</button>
										</div>
								</form>			
						</div>
					</div>
		<?php }} ?>
	</div>
	

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
				
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
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
				$(document).ready(function()
				{    
				 $("#ip").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 7)
				  {  
				   $("#result1").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "ip-mac-check.php?mk_id="+<?php echo $mkkkid;?>,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#result1").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#result1").html('');
				  }
				 });
				});

});
</script>
<style>
#dyntable_length{display: none;}
</style>
<?php if($mac_userrrr == '1'){ ?>
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
		
		var strURL="PackageChangeCost.php?p_id="+afdId+"&c_id=<?php echo $cid;?>";
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
</script>
<?php }else{ ?>
<script type="text/javascript">
jQuery(document).ready(function ()
{
				$(document).ready(function()
				{    
				 jQuery('select[name="p_id"]').on('change',function(){
				  var p_id = jQuery(this).val(); 
				   $.ajax({
					type : 'POST',
					url  : "mk-pack-check.php?mk_id="+<?php echo $mkkkid;?>,
					data : jQuery(this),
					success : function(data)
						{
							  $("#resultpack").html(data);
						   }
					});
					return false;
				 });
				});
});
</script>
<?php } ?>
