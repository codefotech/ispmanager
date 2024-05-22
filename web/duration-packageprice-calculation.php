<?php $pid=$_GET['p_id'];
include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$todayyyy = date('Y-m-d', time());

$durations = strip_tags($_POST['duration']);
$Date2 = date('Y-m-d', strtotime($todayyyy . " + ".$durations." day"));
$yrdata= strtotime($Date2);
$dateee = date('F d, Y', $yrdata);

$resultwww = mysql_query("SELECT p_id, p_price, z_id FROM package WHERE p_id = '$pid' AND status = '0'");
$rowprice = mysql_fetch_assoc($resultwww);
$p_price= $rowprice['p_price'];
$z_id= $rowprice['z_id'];

$packageoneday = $p_price/30;
$daycost = $durations*$packageoneday;

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

if($durations >= $minimum_day){
?>
<a style="color: #f95a5a;font-size: 15px;">Cost: <?php echo number_format($daycost,2); ?>৳</a> <a style="color: green;font-size: 15px;">  Till: <?php echo $dateee; ?></a>
<?php } else{ echo '<a style="color: #f95a5a;font-size: 15px;">[You have to choose minimum '.$minimum_day.' days]</a>';}?>
