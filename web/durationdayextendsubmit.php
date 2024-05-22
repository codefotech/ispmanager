<?php
session_start();
$entry_by = $_SESSION['SESS_EMP_ID'];
include("conn/connection.php") ;
include("mk_api.php");
include('include/telegramapi.php');
$clientid = $_GET['c_id'];
$duration = $_GET['dura'];

ini_alter('date.timezone','Asia/Almaty');
$todayy = date('Y-m-d', time());
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());

$quesww = mysql_query("SELECT b.id, b.c_id, b.z_id, c.mk_id, c.termination_date, c.con_sts, b.days, b.start_date, b.start_time, b.end_date, p.p_price, p.p_id, p.mk_profile FROM billing_mac AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$clientid' ORDER BY b.id DESC LIMIT 1");
$rowwww = mysql_fetch_assoc($quesww);
$idq = $rowwww['id'];
$z_id = $rowwww['z_id'];
$start_date = $rowwww['start_date'];
$start_time = $rowwww['start_time'];
$enddate = $rowwww['end_date'];
$p_price = $rowwww['p_price'];
$termination_date = $rowwww['termination_date'];
$con_sts = $rowwww['con_sts'];
$p_id = $rowwww['p_id'];
$mk_profile = $rowwww['mk_profile'];
$mk_id = $rowwww['mk_id'];
$yrdata1= strtotime($termination_date);
$enddatefff = date('d-M, y', $yrdata1);

if($enddate < $todayy){
	$aaaaw = $todayy;
}
else{
	$aaaaw = $enddate;
}

$durations = strip_tags($duration);
$Date2 = date('Y-m-d', strtotime($aaaaw . " + ".$durations." day"));
$yrdata= strtotime($Date2);
$dateee = date('d-M, y', $yrdata);

$sqlqqrrm = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$clientid' AND start_date = '$dateee'");

$packageoneday = $p_price/30;
$daycost = $durations*$packageoneday;

$sql1q = mysql_query("SELECT c_id, SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$z_id'");
$rowq = mysql_fetch_array($sql1q);

$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p
						WHERE p.z_id = '$z_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

$aaaa = $rowwz['retotalpayments']-$rowq['totbill'];
$checkbalance = $aaaa-$daycost;

$diff = abs(strtotime($termination_date) - strtotime($todayy))/86400;
if($termination_date < $todayy){ $diff = '0';}
if($diff <= '7'){
	$colorrrr = 'style="color: red;font-size: 10px;font-weight: bold;"'; 
}
else{
	$colorrrr = 'style="font-size: 10px;font-weight: bold;"'; 
}

$sqlqqmm = mysql_query("SELECT minimum_day, minimum_days, minimum_sts, terminate, billing_type, over_due FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);


$minimum_days = $row22m['minimum_days'];
$minimum_sts = $row22m['minimum_sts'];
$billing_type = $row22m['billing_type'];
$over_due_bal = '-'.$row22m['over_due'];

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

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
								
$ServerIP = $rowmk['ServerIP'];
$Username = $rowmk['Username'];
$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
$Port = $rowmk['Port'];

$API = new routeros_api();
$API->debug = false;

if($checkbalance > $over_due_bal && $billing_type == 'Prepaid' || $billing_type == 'Postpaid'){
	if(mysql_num_rows($sqlqqrrm)<=0){
		if($durations >= $minimum_day){
			if($daycost != '' || $dateee != ''){
				if($con_sts == 'Inactive'){
					if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
							$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $clientid,));
									 $API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"disabled"  => "no", "profile" => $mk_profile));
											
							$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $clientid,));
									 $API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
					$API->disconnect();
					$query1q ="INSERT INTO con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$clientid', 'Active', '$update_date', '$update_time', '$entry_by')";
							if (!mysql_query($query1q))
							{
							die('Error: ' . mysql_error());
							}
					$queryq ="UPDATE clients SET con_sts = 'Active', p_id = '$p_id', termination_date = '$Date2', con_sts_date = '$update_date' WHERE c_id = '$clientid'";
							if (!mysql_query($queryq))
							{
							die('Error: ' . mysql_error());
							}
							
					$query2bb = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time) VALUES ('$clientid', '$z_id', '$p_id', '$aaaaw', '$update_time', '$Date2', '$duration', '$p_price', '$daycost', '$entry_by', '$update_date', '$update_time')";
							if (!mysql_query($query2bb))
							{
							die('Error: ' . mysql_error());
							} ?>
				<table style='width: 100%;'>
					<tr>
						<td style='border-left: none;border-right: none;vertical-align: middle;width: 100%;' rowspan='2'>
							<div style='color: red;font-size: 10px;font-weight: bold;line-height: 15px;' title='Old Date'>OLD: <?php echo $enddatefff;?></div>
							<div style='color: red;font-size: 10px;font-weight: bold;line-height: 15px;' title='Cost & Days'>COST: <?php echo number_format($daycost,2);?>৳ </div>
							<div style='color: #337ab7;font-size: 10px;font-weight: bold;line-height: 15px;'>DAYS: <?php echo $durations;?></div>
							<div style='color: green;font-size: 10px;font-weight: bold;' title='New Date'>NEW: <?php echo $dateee;?></div>
						</td>
					</tr>
					<tr>
						<td style='border-left: 1px solid #ddd;border-right: none;border-top: none;vertical-align: middle;' rowspan='2'>
							<div style="text-align: center;color: #0866c6;">Recharge DONE [Activated]</div>
						</td>
					</tr>
				</table>
<?php	
					}else{echo 'Microtik Disconnected.';}
				}
				else{
					$queryq ="UPDATE clients SET termination_date = '$Date2', con_sts_date = '$update_date' WHERE c_id = '$clientid'";
							if (!mysql_query($queryq))
							{
							die('Error: ' . mysql_error());
							}
							
					$query2bb = "insert into billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time) VALUES ('$clientid', '$z_id', '$p_id', '$aaaaw', '$update_time', '$Date2', '$duration', '$p_price', '$daycost', '$entry_by', '$update_date', '$update_time')";
							if (!mysql_query($query2bb))
							{
							die('Error: ' . mysql_error());
							} ?>
						<table style='width: 100%;'>
							<tr>
								<td style='border-left: none;border-right: none;vertical-align: middle;width: 100%;' rowspan='2'>
									<div style='color: red;font-size: 10px;font-weight: bold;line-height: 15px;' title='Old Date'>OLD: <?php echo $enddatefff;?></div>
									<div style='color: red;font-size: 10px;font-weight: bold;line-height: 15px;' title='Cost & Days'>COST: <?php echo number_format($daycost,2);?>৳ </div>
									<div style='color: #337ab7;font-size: 10px;font-weight: bold;line-height: 15px;'>DAYS: <?php echo $durations;?></div>
									<div style='color: green;font-size: 10px;font-weight: bold;' title='New Date'>NEW: <?php echo $dateee;?></div>
								</td>
							</tr>
							<tr>
								<td style='border-left: 1px solid #ddd;border-right: none;border-top: none;vertical-align: middle;' rowspan='2'>
									<div style="text-align: center;color: #0866c6;">Recharge DONE</div>
								</td>
							</tr>
						</table>
<?php				}
			}
		}
	}
}else{echo 'Have not sufficient balance.';}

?>