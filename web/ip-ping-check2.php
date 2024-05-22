<?php
include("conn/connection.php") ;
include("mk_api.php");
$ip = $_GET['ip'];
$mk_id = $_GET['mk_id'];
//$mk_id = $_GET['mk_id'];
//echo $ip;
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;

	   $ips     = strip_tags($ip);
//	   $ip     = strip_tags('172.10.10.23');
    if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

$arrID = $API->comm("/ping", array(
            "address" => $ips,
            "arp-ping" => "no",
            "count" => "5",
            "interval" => "200ms"
        ));

		?>
		
		<table id='' class='table table-bordered responsive' style="width: 100%; float: left;font-size: 10px;">
				<thead style="line-height: 0px;">
					<tr>
						<th class='center'>S/L</th>
						<th>IP Address</th>
						<th class='center'>Time</th>
						<th class='center'>Size</th>
						<th class='center'>TTL</th>
						<th class='center'>Status</th>
					</tr>
                </thead>
        <tbody>
<?php
		$x = 1;	
		foreach($arrID as $x => $x_value) {
			$received = $x_value['received'];
			$host = $x_value['host'];
//			$avg = $x_value['avg-rtt'];
			$size = $x_value['size'];
			$ttl = $x_value['ttl'];
			$time = $x_value['time'];
//			$loss = $x_value['packet-loss'];
			$status = $x_value['status'];
			if($status == 'timeout'){
				$statuss = 'request timed out';
				$count = '1';
				$okcount = '0';
				$colooor = "style='color: red;'";
			}
			else{
				$statuss = 'OK';
				$count = '0';
				$okcount = '1';
				$colooor = "";
			}
			$x++;
			$ss += $count;
			$okcountt += $okcount;
			echo 
				"<tr style='line-height: 0px;border-bottom: 1px solid #ccc;'>
					<td class='center' style='width: 5%;'><b $colooor>" . $x . "</b></td>
					<td $colooor><b>" . $host . "</b></td>
					<td class='center' $colooor><b>" . $time . "</b></td>
					<td class='center' $colooor><b>" . $size ."</b></td>
					<td class='center' $colooor><b>" . $ttl ."</b></td>
					<td class='center' $colooor><b>" . $statuss . "</b></td>
				</tr>";
		}
		$dfheh = $ss*100/$x;
		$fghfghf = number_format($dfheh,2);
				?>
			<tr style='line-height: 0px;border-bottom: 1px solid #ccc;'>
				<td colspan="5" style="font-weight: bold;font-size: 13px;">
				<?php echo 'Pinged: '.$x.' || ';?>
				<a style="color: green;"><?php echo 'OK: '.$okcountt.' || ';?></a>
				<?php echo 'Timeout: '.$ss.' || ';?>
				<a style="color: red;"><?php echo 'LOSS: '.number_format($dfheh,2).'%';?></a>
				</td>
				<td style="padding: 3px 7px 0px 0px;"><button type='submit' value='<?php echo $ip.'&mk_id='.$mk_id;?>' class='btn col1' onClick='getRoutePoint(this.value)' style="float: right;" data-placement='top' data-rel='tooltip' title='Ping again'><i class="iconfa-refresh" style="font-weight: bold;"></i></button>
				</td>
			</tr>
			</tbody>
		</table>
		
	<?php
	}else{echo $mk_id.'-Selected Network are not Connected.-'.$ip;}

?>
