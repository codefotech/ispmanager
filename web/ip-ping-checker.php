<?php
include("conn/connection.php") ;
include("mk_api.php");
$ip = $_GET['ip'];
$mk_id = $_GET['mk_id'];
//echo $ip;
$sql = mysql_query("SELECT id, ip, name, mk_id, down_count FROM ip_checker");
while( $row = mysql_fetch_assoc($sql) )
								{
									
	$id=$row['id'];
	$ipss=$row['ip'];
	$name=$row['name'];
	$mk_id=$row['mk_id'];
	$down_count=$row['down_count'];
	$ip= strip_tags($ipss);
	
$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
$API = new routeros_api();
$API->debug = false;

    if ($API->connect($ServerIP, $Username, $Pass, $Port)) {

$arrID = $API->comm("/ping", array(
            "address" => $ip,
            "arp-ping" => "no",
            "count" => "3",
            "interval" => "300ms"
        ));

		$x = 0;	
		$ss = 0;	
		$okcountt = 0;	
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
			}
			else{
				$statuss = 'OK';
				$count = '0';
				$okcount = '1';
			}
			$x++;
			$ss += $count;
			$okcountt += $okcount;
		}
		
		$dfheh = $ss*100/$x;
		$fghfghf = number_format($dfheh,2);
		if($dfheh >= '99'){
$hdfghh = $down_count+1;
$msg_body='..::[Down]::..
IP: '.$ip.'
Name: '.$name.'
MK: '.$mk_id.'
count: '.$hdfghh.'';

$fileURL22 = urlencode($msg_body);
$full_link1= 'https://api.telegram.org/bot927133059:AAHQuG8fZWeEgxY2Wovc6hoPsyrG8OacMto/sendMessage?chat_id=-327102754&text='.$fileURL22;

			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_URL,$full_link1); 
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1); // return into a variable 
			curl_setopt($ch1, CURLOPT_TIMEOUT, 10); 
			$result11 = curl_exec($ch1); 
			curl_close($ch1);

$queryee = "UPDATE ip_checker SET down_count = '$hdfghh' WHERE id = '$id'";
$sqlss = mysql_query($queryee);
		}
				?>
			<tr style='line-height: 0px;border-bottom: 1px solid #ccc;'>
				<td colspan="6">
				<?php echo 'Ping: '.$x.', ';?>
				<?php echo 'Ok: '.$okcountt.', ';?>
				<?php echo 'Timeout: '.$ss.', ';?>
				<?php echo 'Loss: '.number_format($dfheh,2).'%';?>
				</td>
			</tr><br>
			</tbody>
		</table>
		
	<?php
	}else{echo 'Selected Network are not Connected.';}
								}
?>