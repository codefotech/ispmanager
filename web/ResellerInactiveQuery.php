<?php
include("conn/connection.php");
extract($_POST);

$update_date = date('y-m-d');
$update_time = date('H:i:s', time());

	
$day = date('d');
$month = date("t", strtotime($update_date));

$totalday = $month-$day+1;
$thismonth = ($total_price/$month)*$totalday;

if($c_id != ''){
					$queryq ="UPDATE reseller SET con_sts = 'Active', con_sts_date = '$update_date' WHERE c_id = '$c_id'";
					if (!mysql_query($queryq))
					{
					die('Error: ' . mysql_error());
					}
					$query2q ="INSERT INTO billing_reseller (c_id, raw_bandwidth, youtube_bandwidth, total_bandwidth, bandwidth_price, youtube_price, total_price, total_day, amount, start_date) VALUES ('$c_id', '$raw_bandwidth', '$youtube_bandwidth', '$total_bandwidth', '$bandwidth_price', '$youtube_price', '$total_price', '$totalday', '$thismonth', '$update_date')";
					if (!mysql_query($query2q))
					{
					die('Error: ' . mysql_error());
					}
					$query1q ="INSERT INTO reseller_con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$c_id', 'Active', '$update_date', '$update_time', '$e_id')";
					if (!mysql_query($query1q))
					{
					die('Error: ' . mysql_error());
					}

mysql_close($con);
}

?>
<html>
	<body>
	<form action="Reseller" method="post" name="ok">
		<input type="hidden" name="sts" value="Status<?php echo $a; ?>">
	</form>
	<script language="javascript" type="text/javascript">
		document.ok.submit();
	</script>
	</body>
</html>