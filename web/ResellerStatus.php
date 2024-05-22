<?php
session_start();
include("conn/connection.php");
$c_id = $_GET['id'];
$e_id = $_SESSION['SESS_EMP_ID'];
$update_time = date('H:i:s', time());

$privs_day = date('Y-m-d', strtotime('-1 day'));
$today = date("Y-m-d");
$this_month = date("m");
$month = date("t", strtotime($today));


$que = mysql_query("SELECT con_sts FROM reseller WHERE c_id = '$c_id'");
$row = mysql_fetch_assoc($que);
$a = $row['con_sts'];

		if($a == 'Active'){
			
			$que1 = mysql_query("SELECT id, total_bandwidth, total_price, start_date FROM billing_reseller WHERE c_id = '$c_id' AND sts = '0'");
				$rows1 = mysql_fetch_assoc($que1);
				$total_price = $rows1['total_price'];
				$totalbandwidth = $rows1['total_bandwidth'];
				
				$perday= $total_price/$month;
				$start_date = $rows1['start_date'];
				$ss_date = date("m", strtotime($start_date));
				
				if($this_month == $ss_date){
				$diff = abs(strtotime($today) - strtotime($start_date));
				$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)+1);

				$days_bill = $days * ($total_price/$month);
				
				if($start_date == $today){
					$query10 = "update billing_reseller set end_date = '$today', total_day = '0', amount = '00.00', sts = '1' WHERE c_id = '$c_id' AND sts = '0'";
						if (!mysql_query($query10)){
							die('Error: ' . mysql_error());
						}
				}
				else{
						$query = "INSERT INTO reseller_price_change (c_id, old_raw_bandwidth, old_youtube_bandwidth, old_total_bandwidth, old_bandwidth_price, old_youtube_price, old_total_price, update_by, note) VALUES ('$c_id', '$old_raw_bandwidth', '$old_youtube_bandwidth', '$old_total_bandwidth', '$old_bandwidth_price', '$old_youtube_price', '$old_total_price', '$update_by', '$note')";
						if (!mysql_query($query)){
							die('Error: ' . mysql_error());
						}
				$query10 = "update billing_reseller set end_date = '$today', total_day = '$days', amount = '$days_bill', sts = '1' WHERE c_id = '$c_id' AND sts = '0'";
						if (!mysql_query($query10)){
							die('Error: ' . mysql_error());
						}
				}
				
			$query7 = "UPDATE reseller SET con_sts = 'Inactive', edit_by  = '$e_id', con_sts_date = '$today', edit_date = '$today', edit_time = '$update_time' WHERE c_id = '$c_id'";
			if (!mysql_query($query7))
					{
					die('Error: ' . mysql_error());
					}
					
			$query1 = "INSERT INTO reseller_con_sts_log (c_id, con_sts, update_date, update_time, update_by) VALUES ('$c_id', 'Inactive', '$today', '$update_time', '$e_id')";
			if (!mysql_query($query1))
					{
					die('Error: ' . mysql_error());
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
		<?php
		}}
		else{ ?>
			<html>
				<body>
				<form action="ResellerInactive" method="post" name="ok">
					<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
				</form>
				<script language="javascript" type="text/javascript">
					document.ok.submit();
				</script>
				</body>
			</html>
		<?php	}
mysql_close($con);
?>