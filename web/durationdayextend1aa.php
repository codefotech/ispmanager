<?php 
$clientid=$_GET['clientid'];
$key=$_GET['key'];
include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$todayy = date('Y-m-d', time());

$quesww = mysql_query("SELECT b.id, b.c_id, c.cell, c.z_id, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, c.termination_date, b.days, b.start_date, b.start_time, b.end_date, b.p_id, p.p_name, p.bandwith, p.p_price, b.bill_amount FROM billing_mac AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$clientid' ORDER BY b.id DESC LIMIT 1");
$rowwww = mysql_fetch_assoc($quesww);
$idq = $rowwww['id'];
$start_date = $rowwww['start_date'];
$start_time = $rowwww['start_time'];
$enddate = $rowwww['end_date'];
$p_price = $rowwww['p_price'];
$z_id = $rowwww['z_id'];

if($enddate < $todayy){
	$aaaa = $todayy;
}
else{
	$aaaa = $enddate;
}
$durationn = floor($_POST['duration']);
$durations = strip_tags($_POST['duration']);
$Date2 = date('Y-m-d', strtotime($aaaa . " + ".$durations." day"));
$yrdata= strtotime($Date2);
$dateee = date('d-F,Y', $yrdata);

$packageoneday = $p_price/30;
$daycost = $durations*$packageoneday;

$sqlqqmm = mysql_query("SELECT minimum_day, billing_type, e_name AS reseller_fullnamee, e_cont_per AS reseller_celll FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);
$minimum_day = $row22m['minimum_day'];
$billing_type = $row22m['billing_type'];
$reseller_fullnamee = $row22m['reseller_fullnamee'];
$reseller_celll = $row22m['reseller_celll'];

if($daycost != ''){
?>


<?php if($durationn < $minimum_day){ ?>
<li><a style="color: red;font-size: 12px;font-weight: bold;">Minimum <?php echo $minimum_day;?> Days</a></li>
<?php } else{ ?>
<li><a style="color: #f95a5a;font-size: 12px;font-weight: bold;">[Cost: <?php echo number_format($daycost,2);?>৳]</a><br><a style="color: green;font-size: 12px;font-weight: bold;">[Till: <?php echo $dateee; ?>]</a></li>
<br>
<form href='#' data-toggle='modal'>
<li><button type='submit' class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;border: 1px solid red;padding: 0px 10px 2px 10px;" value='<?php echo $clientid.'&dura='.$_POST['duration'];?>' onClick='getRoutePoint<?php echo $key;?>(this.value);'>Confirm</button></li>
</form>
<?php }} ?>