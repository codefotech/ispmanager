<?php
$titel = "Re-connect";
$Clients = 'active';
include("../web/conn/connection.php");
include('../web/include/telegramapi.php');
include("mk_api.php");
include('include/hader.php');
extract($_POST);
$user_type = $_SESSION['SESS_USER_TYPE'];

$e_id = $_SESSION['SESS_EMP_ID'];
ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());

$que = mysql_query("SELECT id, con_sts, breseller, mac_user FROM clients WHERE c_id = '$c_id'");
$rowuuu = mysql_fetch_assoc($que);
$con_sts = $rowuuu['con_sts'];		
$breseller = $rowuuu['breseller'];		
$macuserrr = $rowuuu['mac_user'];		
$clientid = $rowuuu['id'];		

if($breseller == '1'){
$ques = mysql_query("SELECT b.id, b.c_id, c.mac_user, c.bandwidth, c.ip, c.mac, c.mk_id, c.c_name, c.payment_deadline, c.termination_date, b.day, c.discount as cdis, b.bill_date, b.p_price as bp_price, c.extra_bill, b.bill_amount, c.total_bandwidth, c.total_price FROM billing AS b
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$c_id' ORDER BY b.bill_date DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$idq = $roww['id'];
$cl_id = $roww['c_id'];
$c_name = $roww['c_name'];
$bill_date = $roww['bill_date'];
$p_name = $roww['total_bandwidth'].' mb';
$bandwith = $roww['total_price'].' tk';
$p_price = $roww['total_price'];
$discount = $roww['discount'];
$extra_bill = $roww['extra_bill'];
$bill_amount = $roww['bill_amount'];
$c_dis = $roww['cdis'];
$payment_deadline = $roww['payment_deadline'];
$macuser = $roww['mac_user'];
$bp_price = $roww['bp_price'];
$day = $roww['day'];
$mk_id = $roww['mk_id'];
$bandwidth = $roww['bandwidth'];
$termination_date = $roww['termination_date'];
$ip = $roww['ip'];
$mac = $roww['mac'];

$quesee = mysql_query("SELECT * FROM billing WHERE c_id = '$c_id' ORDER BY id DESC LIMIT 1");
$rowwee = mysql_fetch_assoc($quesee);

$priceinavtive = $rowwee['p_price'];
$billamount = $rowwee['bill_amount'];

if($priceinavtive == '0.00' && $billamount == '0.00'){
$todayy = date('d', time());
$lastdayofthismonth = date('t');
$aa = $lastdayofthismonth - $todayy;

$onedaynewprice = $p_price / $lastdayofthismonth;
$unusedday = $aa * $onedaynewprice;
}
else{
//	$unusedday =$p_price - $c_dis;
	$unusedday =$billamount;
}
}
else{
if($macuserrr == '1'){
$todayssss = strtotime(date('Y-m-d', time()));
	$ques = mysql_query("SELECT b.id, b.c_id, c.cell, c.address, c.z_id, c.con_sts, p.mk_profile, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, c.termination_date, b.days, b.start_date, c.extra_bill, c.discount, b.start_time, b.end_date, b.p_id, p.p_name, p.bandwith, p.p_price, b.bill_amount FROM billing_mac AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$idq = $roww['id'];
$cl_idsss = $roww['c_id'];
$c_name = $roww['c_name'];
$cell = $roww['cell'];
$start_date = strtotime($roww['start_date']);
$startdate = $roww['start_date'];
$start_time = strtotime($roww['start_time']);
$starttime = $roww['start_time'];
$end_date = strtotime($roww['end_date']);
$enddate = $roww['end_date'];
$p_id = $roww['p_id'];
$p_name = $roww['p_name'];
$bandwith = $roww['bandwith'];
$p_price = $roww['p_price'];
$bill_amount = $roww['bill_amount'];
$macuser = $roww['mac_user'];
$day = $roww['days'];
$mk_id = $roww['mk_id'];
$termination_date = $roww['termination_date'];
$z_id = $roww['z_id'];
$con_sts = $roww['con_sts'];
$address = $roww['address'];
$extra_bill = $roww['extra_bill'];
$discount = $roww['discount'];
$mk_profile = $roww['mk_profile'];

if($user_type == 'mreseller'){
$query1="SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '$macz_id' AND p_price != '0.00' AND status = '0' order by id ASC";
}
else{
$query1="SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '$z_id' order by id ASC";
}
$result1=mysql_query($query1);

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
$ServerIP = $rowmk['ServerIP'];
$Username = $rowmk['Username'];
$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
$Port = $rowmk['Port'];

$sqlqqmm = mysql_query("SELECT minimum_day, minimum_days, minimum_sts, terminate FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);

$minimum_days = $row22m['minimum_days'];
$minimum_sts = $row22m['minimum_sts'];
$terminate = $row22m['terminate'];

if($minimum_sts != '1' && $minimum_days != ''){
	$minimum_days_array = explode(',',$minimum_days);
	$trimSpaces = array_map('trim',$minimum_days_array);
	asort($trimSpaces);
	$minimum_days_arrays = implode(',',$trimSpaces);
	$minimum_arraydd =  explode(',', $minimum_days_arrays);
	$minimum_day = min(explode(',', $minimum_days_arrays));
}
else{
	$minimum_day = $row22m['minimum_day'];
}
}
else{
$ques = mysql_query("SELECT b.id, b.c_id, c.mac_user, c.mk_id, c.address, c.c_name, p.mk_profile, c.payment_deadline, c.termination_date, b.day, c.extra_bill, c.discount as cdis, b.bill_date, b.p_price as bp_price, b.p_id, p.p_name, p.bandwith, p.p_price, c.discount, b.bill_amount FROM billing AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$c_id' ORDER BY b.bill_date DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$idq = $roww['id'];
$cl_id = $roww['c_id'];
$cl_idsss = $roww['c_id'];
$c_name = $roww['c_name'];
$bill_date = $roww['bill_date'];
$p_id = $roww['p_id'];
$p_name = $roww['p_name'];
$bandwith = $roww['bandwith'];
$p_price = $roww['p_price'];
$discount = $roww['discount'];
$extra_bill = $roww['extra_bill'];
$bill_amount = $roww['bill_amount'];
$c_dis = $roww['cdis'];
$payment_deadline = $roww['payment_deadline'];
$macuser = $roww['mac_user'];
$bp_price = $roww['bp_price'];
$day = $roww['day'];
$mk_id = $roww['mk_id'];
$termination_date = $roww['termination_date'];
$address = $roww['address'];
$mk_profile = $roww['mk_profile'];

$quesee = mysql_query("SELECT * FROM billing WHERE c_id = '$c_id' ORDER BY id DESC LIMIT 1");
$rowwee = mysql_fetch_assoc($quesee);
$priceinavtive = $rowwee['p_price'];
$billamount = $rowwee['bill_amount'];

if($priceinavtive == '0.00' && $billamount == '0.00'){
$todayy = date('d', time());
$lastdayofthismonth = date('t');
$aa = $lastdayofthismonth - $todayy;

$onedaynewprice = (($p_price + $extra_bill) - $c_dis) / $lastdayofthismonth;
	$unusedday = $aa * $onedaynewprice;
	$ddddyes = $aa.' Days';
}
else{
	$unusedday = $billamount;
	$ddddyes = 'Full Month';
}
}
}

$todayyyy = date('Y-m-d', time());

$Date2 = date('Y-m-d', strtotime($todayyyy . " + ".$minimum_day." day"));
$yrdata= strtotime($Date2);
$dateee = date('F d, Y', $yrdata);

$resultwww = mysql_query("SELECT p_id, p_price FROM package WHERE p_id = '$p_id' AND status = '0'");
$rowprice = mysql_fetch_assoc($resultwww);
$old_p_price= $rowprice['p_price'];

$packageoneday = $old_p_price/30;
$daycost = $minimum_day*$packageoneday;

if($idq != ''){
?>
	<?php  if($macuserrr != '1'){ ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Adjastment</h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="ClientInactiveAdjastmentQuery" onsubmit='disableButton()'>>
				<input type ="hidden" name="id" value="<?php echo $idq; ?>">
				<input type ="hidden" name="c_id" value="<?php echo $cl_idsss; ?>">
				<input type ="hidden" name="ee_id" value="<?php echo $e_id; ?>">
				<input type ="hidden" name="p_id" value="<?php echo $p_id; ?>">
				<input type ="hidden" name="discount" value="<?php echo $c_dis; ?>">
				<input type ="hidden" name="extra_bill" value="<?php echo $extra_bill; ?>">
				<input type="hidden" name="bill_date" value="<?php echo $update_date;?>" />
				<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>" />
				<input type="hidden" name="breseller" value="<?php echo $breseller;?>" />
				<?php if($breseller == '1'){?>
					<input type ="hidden" name="bp_price" value="<?php echo $p_price; ?>">
					<input type="hidden" name="bandwidth" value="<?php echo $bandwidth;?>" />
					<input type="hidden" name="ip" value="<?php echo $ip;?>" />
				<?php }else{ ?>
					<input type ="hidden" name="p_price" value="<?php echo $p_price; ?>">
				<?php } ?>
				<input type="hidden" name="macz_id" value="<?php echo $macz_id;?>" />
				<input type="hidden" name="old_bill_amount" value="<?php echo $bill_amount;?>" />
				<input type="hidden" name="old_payment_deadline" value="<?php echo $payment_deadline;?>" />
				<input type="hidden" name="old_termination_date" value="<?php echo $termination_date;?>" />
					<div class="modal-body">
						<p>	
							<label>Client Info</label>
							<span class="field" style="font-size: 20px;line-height: 30px;">
								<b><?php echo $cl_idsss;?> |</b> <b><?php echo $p_name;?> |</b><b> <?php echo $p_price.' ৳';?></b>
							</span>
						</p>
						<p>
							<label>Generated Bill Date</label>
							<span class="field" style="font-size: 16px;line-height: 30px;"><b><?php echo date('jS M, Y');?></b></span>
						</p>
						<?php if(in_array(122, $access_arry)){?>
						<p>
							<label>Last Bill Adjastment</label>
							<span class="field"><input type="text" name="bill_amount" id="" style="width:100px;font-size: 20px;font-weight: bold;color: brown;" value="<?php echo $unusedday;?>" required="" /><a style="width:90px;font-size: 20px;font-weight: bold;margin-left: 5px;color: red;">[ <?php echo $ddddyes;?> ]</a></span>
						</p>
						<?php } else{?>
						<p>
							<label>Last Bill Adjastment</label>
							<span class="field"><input type="text" name="bill_amount" id="" readonly style="width:100px;font-size: 20px;font-weight: bold;color: brown;" value="<?php echo $unusedday;?>" required="" /><a style="width:90px;font-size: 20px;font-weight: bold;margin-left: 5px;color: red;">[ <?php echo $ddddyes;?> ]</a></span>
						</p>
						<?php } if(in_array(120, $access_arry)){?>
						<p>
							<label>Payment Deadline</label>
							<span class="field">
								<select class="chzn-select" name="payment_deadline" style="width: 5%;" />
									<option value="" <?php if('' == $payment_deadline) echo 'selected="selected"';?>>NO</option>
									<option value="01" <?php if('01' == $payment_deadline) echo 'selected="selected"';?>>01</option>
									<option value="02" <?php if('02' == $payment_deadline) echo 'selected="selected"';?>>02</option>
									<option value="03" <?php if('03' == $payment_deadline) echo 'selected="selected"';?>>03</option>
									<option value="04" <?php if('04' == $payment_deadline) echo 'selected="selected"';?>>04</option>
									<option value="05" <?php if('05' == $payment_deadline) echo 'selected="selected"';?>>05</option>
									<option value="06" <?php if('06' == $payment_deadline) echo 'selected="selected"';?>>06</option>
									<option value="07" <?php if('07' == $payment_deadline) echo 'selected="selected"';?>>07</option>
									<option value="08" <?php if('08' == $payment_deadline) echo 'selected="selected"';?>>08</option>
									<option value="09" <?php if('09' == $payment_deadline) echo 'selected="selected"';?>>09</option>
									<option value="10" <?php if('10' == $payment_deadline) echo 'selected="selected"';?>>10</option>
									<option value="11" <?php if('11' == $payment_deadline) echo 'selected="selected"';?>>11</option>
									<option value="12" <?php if('12' == $payment_deadline) echo 'selected="selected"';?>>12</option>
									<option value="13" <?php if('13' == $payment_deadline) echo 'selected="selected"';?>>13</option>
									<option value="14" <?php if('14' == $payment_deadline) echo 'selected="selected"';?>>14</option>
									<option value="15" <?php if('15' == $payment_deadline) echo 'selected="selected"';?>>15</option>
									<option value="16" <?php if('16' == $payment_deadline) echo 'selected="selected"';?>>16</option>
									<option value="17" <?php if('17' == $payment_deadline) echo 'selected="selected"';?>>17</option>
									<option value="18" <?php if('18' == $payment_deadline) echo 'selected="selected"';?>>18</option>
									<option value="19" <?php if('19' == $payment_deadline) echo 'selected="selected"';?>>19</option>
									<option value="20" <?php if('20' == $payment_deadline) echo 'selected="selected"';?>>20</option>
									<option value="21" <?php if('21' == $payment_deadline) echo 'selected="selected"';?>>21</option>
									<option value="22" <?php if('22' == $payment_deadline) echo 'selected="selected"';?>>22</option>
									<option value="23" <?php if('23' == $payment_deadline) echo 'selected="selected"';?>>23</option>
									<option value="24" <?php if('24' == $payment_deadline) echo 'selected="selected"';?>>24</option>
									<option value="25" <?php if('25' == $payment_deadline) echo 'selected="selected"';?>>25</option>
									<option value="26" <?php if('26' == $payment_deadline) echo 'selected="selected"';?>>26</option>
									<option value="27" <?php if('27' == $payment_deadline) echo 'selected="selected"';?>>27</option>
									<option value="28" <?php if('28' == $payment_deadline) echo 'selected="selected"';?>>28</option>
									<option value="29" <?php if('29' == $payment_deadline) echo 'selected="selected"';?>>29</option>
									<option value="30" <?php if('30' == $payment_deadline) echo 'selected="selected"';?>>30</option>
									<option value="31" <?php if('31' == $payment_deadline) echo 'selected="selected"';?>>31</option>
								</select>
							</span>
						</p>
						<?php } else{?>
						<p>
							<label>Payment Deadline</label>
							<span class="field"><input type="text" name="payment_deadline" placeholder="Date in every month like: 07" readonly id="" style="width: 10%;"  value="<?php echo $payment_deadline;?>"></span>
						</p>
						<?php } if(in_array(121, $access_arry)){ if($client_terminate == '1'){?>
						<p>
							<label>Termination Date</label>
							<span class="field"><input type="text" name="termination_date" placeholder="Client Discount Date (Optional)" id="" class="datepicker" style="width: 10%;" value="<?php echo $termination_date;?>">
							<br><a style="color: red;"><?php if($termination_note != '') {echo 'Last '.$termination_note;}?></a></span>
						</p>
						<?php } else{?>
						<p>
							<label>Termination Date</label>
							<span class="field"><input type="text" name="termination_date" placeholder="Client Discount Date (Optional)" readonly id="" style="width: 10%;" value="<?php echo $termination_date;?>">
							<br><a style="color: red;"><?php if($termination_note != '') {echo 'Last '.$termination_note;}?></a></span>
						</p>
						<?php }} else{ ?>
						<p>
							<label>Termination Date</label>
							<span class="field"><input type="text" name="termination_date" placeholder="Client Discount Date (Optional)" readonly id="" style="width: 10%;" value="<?php echo $termination_date;?>">
							<br><a style="color: red;"><?php if($termination_note != '') {echo 'Last '.$termination_note;}?></a></span>
						</p>
						<?php } ?>
						<p>	
							<label>Note</label>
							<span class="field">
								<textarea type="text" class="input-xxlarge" name="note" placeholder="Write Note..." /></textarea>
							</span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit" id="submitdisabl">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php } else{ if($terminate == '0'){ if($todayssss >= $start_date && $todayssss < $end_date || $todayssss <= $start_date && $todayssss < $end_date) {
	
								$API = new routeros_api();
								$API->debug = false;
								if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
									
								$arrID =	$API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));
											$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "no", "profile" => $mk_profile));

								$arrID = 	$API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
											$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
											
											$API->disconnect();
								
					$queryq ="UPDATE clients SET con_sts = 'Active', con_sts_date = '$update_date' WHERE c_id = '$c_id'";
							if (!mysql_query($queryq))
							{
							die('Error: ' . mysql_error());
							}
					$query1q ="INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by, note) VALUES ('$c_id', 'Active', '$update_date', '$update_time', '$ee_id', '$note')";
							if (!mysql_query($query1q))
							{
							die('Error: ' . mysql_error());
							}
					$query222 = "INSERT INTO emp_log (e_id, c_id, module_name, titel, date, time, action, action_details) VALUES ('$ee_id', '$c_id', 'Clients', 'Change_Client_Status', '$update_date', '$update_time', 'Active_Client', 'Active_a_Client')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}
		$API->disconnect();
		
$sqlmqq = mysql_query("SELECT c.c_name, c.cell, e.`con_sts`, e.`update_date`, e.`update_time`, q.e_name AS updatebyy, e.`update_date_time`, e.note FROM con_sts_log AS e 
						LEFT JOIN emp_info AS q ON q.e_id = e.update_by
						LEFT JOIN clients AS c ON c.c_id = e.c_id
						WHERE e.c_id = '$c_id' ORDER BY e.id DESC LIMIT 1");
										
$rowmkqq = mysql_fetch_assoc($sqlmqq);
$cname = $rowmkqq['c_name'];
$ccell = $rowmkqq['cell'];
$update_datetime = $rowmkqq['update_date_time'];
$updatebyy = $rowmkqq['updatebyy'];
$noteeee = $rowmkqq['note'];

if($tele_sts == '0' && $tele_client_status_sts == '0'){
$telete_way = 'client_status';
$msg_body='..::[Reseller Client Activated]::..
'.$cname.' ['.$c_id.'] ['.$ccell.']

Cost & Days: Already Recharged
Note: '.$noteeee.'

By: '.$updatebyy.' at '.$update_datetime.'
'.$tele_footer.'';

include('../web/include/telegramapicore.php');
}
//----Telegream---------------------		
		
		
		?>
<html>
	<body>
	<form action="Clients" method="post" name="ok">
		<input type="hidden" name="sts" value="StatusInactive">
	</form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
	</body>
</html>
		
<?php	}else{
	echo 'Not Pssible to Reactive.';
} } else{ ?>
<!---
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header" style="padding: 0 0 0 10px;">
					<h5>New Recharge/Extend</h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="ClientInactiveAdjastmentQuery" onsubmit='disableButton()'>>
				<input type ="hidden" name="id" value="<?php echo $idq; ?>">
				<input type ="hidden" name="c_id" value="<?php echo $c_id; ?>">
				<input type ="hidden" name="z_id" value="<?php echo $z_id; ?>">
				<input type ="hidden" name="start_date" value="<?php echo $startdate; ?>">
				<input type ="hidden" name="end_date" value="<?php echo $update_date; ?>">
				<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>" />
				<input type="hidden" name="breseller" value="<?php echo $breseller;?>" />
				<input type="hidden" name="ee_id" value="<?php echo $e_id;?>" />
				<input type="hidden" name="macuser" value="1" />
				<?php if($user_type == 'mreseller') {?>
					<input type="hidden" name="macz_id" value="<?php echo $macz_id;?>" />
				<?php } else {?>
					<input type="hidden" name="macz_id" value="<?php echo $z_id;?>" />
				<?php } ?>
					<div class="modal-body" style="min-height: 180px;padding: 1px;">
						<div class="span6">
							<table class="table table-bordered table-invoice">
								<tr>
									<td colspan="2" style="font-size: 12px;font-weight: bold;text-align: center;"><?php echo $c_id;?></td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 12px;text-align: center;"><?php echo $c_name;?> - <?php echo $cell;?><br><?php echo $address;?></td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 12px;font-weight: bold;text-align: center;"><?php echo $p_name; ?> || <?php echo $bandwith; ?> || <?php echo $p_price; ?>৳</td>
								</tr>
								<tr>
									<td colspan="2" style="font-weight: bold;">
									<select data-placeholder="Choose a Package" class="chzn-select" style="width:100%;text-align: center;" name="p_id" id="p_id" required="" onchange="myFunctionnn(event)"/>
												<option value=""></option>
													<?php while ($row1=mysql_fetch_array($result1)) { ?>
												<option value="<?php echo $row1['p_id']?>"<?php if($p_id == $row1['p_id']) echo 'selected="selected"';?>><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
													<?php } ?>
									</select>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 12px;font-weight: bold;text-align: center;bold;color: maroon;">Old Termination Date: <?php $yrdata= strtotime($termination_date); $dateee = date('d-F, Y', $yrdata); echo $dateee; ?></td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 13px;font-weight: bold;text-align: center;"><div id="dayprice1" style="font-weight: bold;margin-left: 0px;" class="field"><div id="dayprice" style="font-weight: bold;margin-left: 0px;" class="field"><a style="color: #f95a5a;font-size: 13px;">Cost: <?php echo number_format($daycost,2); ?>৳</a> <a style="color: green;font-size: 13px;">  Till <?php echo $dateee; ?></a></div></div></td>
								</tr>
								<?php if($minimum_sts == '2' && $minimum_days_arrays != ''){?>
								<tr>
									<td class="width40" style="font-weight: bold;font-size: 14px;text-align: right;padding: 10px 10px 0 0;">Recharge Days</td>
									<td class="width40" style="font-weight: bold;">
									<select name="duration" id="duration" style="width:80px;font-weight: bold;font-size: 20px;height: 35px;margin-bottom: 5px;text-align: center;" placeholder="<?php echo $minimum_day;?>" required="">
										<?php foreach ($minimum_arraydd as $item) { 
												echo "<option value='$item'>$item</option>";
											}?>
									</select>
									</td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 13px;font-weight: bold;text-align: center;"><a class="field" style="color: red;font-size: 10px;font-weight: bold;">[Minimum <?php echo $minimum_days_arrays;?> Days]</a></td>
								</tr>
								<?php } else{?>
								<tr>
									<td class="width40" style="font-weight: bold;font-size: 14px;text-align: right;padding: 10px 10px 0 0;width: 50%;">Recharge Days</td>
									<td class="width40" style="font-weight: bold;"><input type="text" name="duration" id="duration" value="<?php echo $minimum_day;?>" style="width:34%;font-weight: bold;height: 40px;font-size: 30px;color: brown;" placeholder="<?php echo $minimum_day;?>" required=""></td>
								</tr>
								<tr>
									<td colspan="2" style="font-size: 13px;font-weight: bold;text-align: center;"><a class="field" style="color: red;font-size: 10px;font-weight: bold;">[Minimum <?php echo $minimum_day;?> Days]</a></td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit" id="submitdisabl">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>-->
<html>
	<body>
	<form action="ClientsRecharge" method="post" name="ok">
		<input type="hidden" name="c_id" value="<?php echo $c_id;?>">
	</form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
	</body>
</html>
<?php }
}
else{
	echo '<br><h3 style="margin-left: 20px;color: red;">Your Account Has Been Terminated. Not Possible to Active This Client.</h3><br>';
}
}}
else{
	echo 'You must Generate Bill fast then try again';
	
//$query ="UPDATE clients SET con_sts = 'Active' WHERE c_id = '$c_id'";
//$query1 ="insert into con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$c_id', 'Active', '$update_date', '$update_time', '$e_id')";
//$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
//$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<!--
<html>
	<body>
	<form action="Clients" method="post" name="ok">
		<input type="hidden" name="sts" value="Status<?php echo $a; ?>">
	</form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
	</body>
</html>
-->
<?php 
	}
include('include/footer.php');
if($minimum_sts == '2' && $minimum_days_arrays != ''){
?>
<script type="text/javascript">
$(document).ready(function()
{    
 $('select[name="duration"]').on('change',function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#dayprice").html('checking...');
   $.ajax({
    
    type : 'POST',
	url  : "durationdayextend.php?clientid="+<?php echo $clientid;?>,
    data : $(this).serialize(),
    success : function(data)
        {
              $("#dayprice").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#dayprice").html('');
  }
 });
 
});
</script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="p_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#duration").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 0)
				  {  
				   $("#dayprice1").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "duration-packageprice-calculation.php?p_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#dayprice1").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#dayprice1").html('');
				  }
				 });
				});
			}
        });
});

function myFunctionnn() {
    document.getElementById("duration").value = ''
}
</script>

<?php } else{?>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#duration").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#dayprice").html('checking...');
   $.ajax({
    
    type : 'POST',
	url  : "durationdayextend.php?clientid="+<?php echo $clientid;?>,
    data : $(this).serialize(),
    success : function(data)
        {
              $("#dayprice").html(data);
           }
    });
    return false;
   
  }
  else
  {
   $("#dayprice").html('');
  }
 });
 
});
</script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="p_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#duration").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 0)
				  {  
				   $("#dayprice1").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "duration-packageprice-calculation.php?p_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#dayprice1").html(data);
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#dayprice1").html('');
				  }
				 });
				});
			}
        });
});

function myFunctionnn() {
    document.getElementById("duration").value = ''
}
</script>
<?php }?>
<style>
.chzn-container{width: 100% !important;}
</style>
<script type="text/javascript">
function disableButton() {
        var btn = document.getElementById('submitdisabl');
        btn.disabled = true;
        btn.innerText = 'Posting...'
}
</script>