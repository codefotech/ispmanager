<?php
extract($_POST);
include("conn/connection.php");
include("mk_api.php");

$sqlcl = mysql_query("SELECT mk_id FROM clients WHERE c_id = '$c_id'");
$sqlclll = mysql_fetch_assoc($sqlcl);
$mkkkk_id = $sqlclll['mk_id'];

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mkkkk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
		
$ServerIP = $rowmk['ServerIP'];
$Username = $rowmk['Username'];
$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
$Port = $rowmk['Port']; 
		
$API = new routeros_api();
$API->debug = false;

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$new_package = $p_id;

$todayy = date('d', time());

if($todayy == '1'){
	$todayyy = '0';
}
else{
	$todayyy = $todayy - 1;
}
$lastdayofthismonth = date('t');

if($macuser == '1'){
$sqlqqmm = mysql_query("SELECT billing_type, over_due FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);
$billing_type = $row22m['billing_type'];
$over_due_bal = '-'.$row22m['over_due'];

$sql1q = mysql_query("SELECT SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$z_id'");
$rowq = mysql_fetch_array($sql1q);

$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p
						WHERE p.z_id = '$z_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

$reseller_balance = $rowwz['retotalpayments'] - $rowq['totbill'];

$diff = abs(strtotime($termination_date) - strtotime($dateTimeee))/86400;
$onedayprice = $old_price/30;
$alreadypaid = $diff * $onedayprice;

$queee=mysql_query("SELECT p_id, p_name, p_price, bandwith, mk_profile FROM package WHERE p_id ='$new_package'");
$rowsueee = mysql_fetch_assoc($queee);
$pprice = $rowsueee['p_price'];
$mk_profile = $rowsueee['mk_profile'];

$onedaypriceee = $pprice/30;
$newpacgcost = $diff * $onedaypriceee;
$newcost = $newpacgcost;

$dayyss = $old_days - $diff;
$oldbill_amount = $old_bill_amount - $alreadypaid;

$checkbalance = $reseller_balance-$newcost;
if($checkbalance > $over_due_bal && $billing_type == 'Prepaid' || $billing_type == 'Postpaid'){

			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
				$sqlqqrrm = mysql_query("SELECT id FROM billing_mac WHERE c_id = '$c_id' AND start_date = '$end_date'");
					if(mysql_num_rows($sqlqqrrm)<=4){
						$query1uuw = "update billing_mac set end_date = '$dateTimeee', days = '$dayyss', bill_amount = '$oldbill_amount' WHERE id = '$id_mbill'";
							if (!mysql_query($query1uuw)){
								die('Error: ' . mysql_error());
							}
							
						$query1 = "update clients set p_id = '$new_package', ip = '$ip' WHERE c_id = '$c_id'";
							if (!mysql_query($query1)){
								die('Error: ' . mysql_error());
							}
							
						$query2bb = "INSERT INTO billing_mac (c_id, z_id, p_id, start_date, start_time, end_date, days, p_price, bill_amount, entry_by, entry_date, entry_time) 
												VALUES ('$c_id', '$z_id', '$new_package', '$dateTimeee', '$update_time', '$termination_date', '$diff', '$pprice', '$newcost', '$ent_by', '$dateTimeee', '$update_time')";
							if (!mysql_query($query2bb)){
								die('Error: ' . mysql_error());
							}
						$query = "INSERT INTO package_change (ent_by, ent_date, c_id, c_package, used_day, used_day_price, new_package, remaining_day, remaining_day_price, up_date, note)
									VALUES ('$ent_by', '$dateTimeee', '$c_id', '$olp_package', '$dayyss', '$oldbill_amount', '$new_package', '$diff', '$newcost', '$dateTimeee', '$note')";
							if (!mysql_query($query)){
								die('Error: ' . mysql_error());
							}
					
					$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));
							$API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => $mk_profile)); 
							
					$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
							$API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
					 
							}?>
<html>
	<body>
		<form action="PackageChange2ndSave" method="post" name="ok">
			<input type="hidden" name="ServerIP" value="<?php echo $ServerIP;?>">
			<input type="hidden" name="Username" value="<?php echo $Username;?>">
			<input type="hidden" name="Pass" value="<?php echo $Pass;?>">
			<input type="hidden" name="Port" value="<?php echo $Port;?>">
			<input type="hidden" name="mk_profile" value="<?php echo $mk_profile;?>">
			<input type="hidden" name="c_id" value="<?php echo $c_id;?>">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
	<?php		}
		else{ echo "Error!! No Connected Network Found.";}
		
	}else{echo 'Have not sufficient balance.';}
}
	else{
	if($breseller == '0'){
		$que1 = mysql_query("SELECT id, p_price, mk_profile FROM package WHERE p_id = '$new_package'");
		$rows1 = mysql_fetch_assoc($que1);
		$new_price = $rows1['p_price'];
		$mk_profile = $rows1['mk_profile'];
		
		$aa = $lastdayofthismonth - $todayyy;
		$onedayoldprice = $oldprice / $lastdayofthismonth;
		$usedday = $todayyy * $onedayoldprice;
		$onedaynewprice = $new_price / $lastdayofthismonth;
		$unusedday = $aa * $onedaynewprice;
		$newprice = $usedday + $unusedday;
		
		
		if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
			$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));
					 $API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => $mk_profile));
					 
			$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
					 $API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
					 
					$API->disconnect();
		
		if($qcalculation == 'Auto'){
		$query = "INSERT INTO package_change (ent_by, ent_date, c_id, c_package, used_day, used_day_price, new_package, remaining_day, remaining_day_price, up_date, note, bill_calculation)
				VALUES ('$ent_by', '$ent_date', '$c_id', '$c_package', '$todayyy', '$usedday', '$new_package', '$aa', '$unusedday', '$up_date', '$note', '$qcalculation')";
						if (!mysql_query($query)){
							die('Error: ' . mysql_error());
						}	
		
		$query2 = "update billing set bill_amount = '$newprice', p_id = '$new_package', p_price = '$new_price', pack_chng = '0' WHERE id = '$bill_id'";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}
		}
		
		elseif($qcalculation == 'Manual'){
		$query = "INSERT INTO package_change (ent_by, ent_date, c_id, c_package, used_day, used_day_price, new_package, remaining_day, remaining_day_price, up_date, note, bill_calculation)
									VALUES ('$ent_by', '$ent_date', '$c_id', '$c_package', '$todayyy', '0.00', '$new_package', '$aa', '$new_price', '$up_date', '$note', '$qcalculation')";
						if (!mysql_query($query)){
							die('Error: ' . mysql_error());
						}	
		
		$query2 = "update billing set bill_amount = '$new_price', p_id = '$new_package', p_price = '$new_price', pack_chng = '0' WHERE id = '$bill_id'";
				if (!mysql_query($query2)){
					die('Error: ' . mysql_error());
				}
		}
		
		else{
		$query = "INSERT INTO package_change (ent_by, ent_date, c_id, c_package, used_day, used_day_price, new_package, remaining_day, remaining_day_price, up_date, note, bill_calculation)
									VALUES ('$ent_by', '$ent_date', '$c_id', '$c_package', '$todayyy', '0.00', '$new_package', '$aa', '0.00', '$up_date', '$note', '$qcalculation')";
						if (!mysql_query($query)){
							die('Error: ' . mysql_error());
						}
		}
		
		$query1 = "update clients set p_id = '$new_package', ip = '$ip' WHERE c_id = '$c_id'";
				if (!mysql_query($query1)){
					die('Error: ' . mysql_error());
				}

		header("location: PackageChange");
		}
			else{ echo "Error!! No Connected Network Found.";}
	}
	else{
		
			$aa = $lastdayofthismonth - $todayyy;
			$onedayoldprice = $oldprice / $lastdayofthismonth;
			$usedday = $todayyy * $onedayoldprice;
			$onedaynewprice = $new_price / $lastdayofthismonth;
			$unusedday = $aa * $onedaynewprice;
			$newprice = $usedday + $unusedday;
			
			
			$query = "INSERT INTO package_change (ent_by, ent_date, c_id, old_raw_download, old_raw_upload, old_youtube_bandwidth, old_total_bandwidth, old_bandwidth_price, old_youtube_price, old_total_price, used_day, used_day_price, new_raw_download, new_raw_upload, new_youtube_bandwidth, new_total_bandwidth, new_bandwidth_price, new_youtube_price, new_total_price, remaining_day, remaining_day_price, up_date, note)
									VALUES ('$ent_by', '$ent_date', '$c_id', '$old_raw_download', '$old_raw_upload', '$old_youtube_bandwidth', '$old_total_bandwidth', '$old_bandwidth_price', '$old_youtube_price', '$oldprice', '$todayyy', '$usedday', '$new_raw_download', '$new_raw_upload', '$new_youtube_bandwidth', '$new_total_bandwidth', '$new_bandwidth_price', '$new_youtube_price', '$new_price', '$aa', '$unusedday', '$up_date', '$note')";
					if (!mysql_query($query)){
						die('Error: ' . mysql_error());
					}	

			$maxlimit = $new_raw_upload.''.'M/'.''.$new_raw_download.''.'M';

			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
			   $arrID =	$API->comm("/queue/simple/getall", 
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/queue/simple/set",
						array(".id" => $arrID[0][".id"],"max-limit" => $maxlimit));
				$API->disconnect();
				
	$query111 = "update clients set raw_download = '$new_raw_download', raw_upload = '$new_raw_upload', youtube_bandwidth = '$new_youtube_bandwidth', total_bandwidth = '$new_total_bandwidth', bandwidth_price = '$new_bandwidth_price', youtube_price = '$new_youtube_price', total_price = '$new_price' WHERE c_id = '$c_id'";
			if (!mysql_query($query111)){
				die('Error: ' . mysql_error());
			}
			
	$query2 = "update billing set bill_amount = '$newprice', p_price = '$new_price', pack_chng = '1' WHERE id = '$bill_id'";
			if (!mysql_query($query2)){
				die('Error: ' . mysql_error());
			}
			
	header("location: PackageChange");	
	}
		else{ echo "Error!! No Connected Network Found.";}
		
	}
}


//mysql_close($con);
?>