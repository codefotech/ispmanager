
<?php
include("conn/connection.php");
include("mk_api.php");	
$API = new routeros_api();
$API->debug = false;

$items = array();
$sql34 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0'");
while ($roww = mysql_fetch_assoc($sql34)) {

		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
				$arrID = $API->comm('/ppp/active/getall');
				foreach($arrID as $x => $x_value) {
//						$items[] = $x_value['name'];
//						$ppp_mac[] = $x_value['caller-id'];
//						    echo "[ID => ".$x.", name => ".$x_value['name'].", MAC => ".$x_value['caller-id']."],\n";
					$items[$x] = $x_value['name'];
					$items[$x] = $x_value['caller-id'];
				}
//				$array = array_column($arrID, 'name', 'caller-id', 'uptime');
		 $API->disconnect();
		}
    $itemss = array_merge($items, $roww);
    $ppp_macc = array_merge($ppp_mac, $roww);
}

print_r($items).'<br>';
//print_r($ppp_macc).'<br>';
//echo $items;
//$lastKey = key(array_slice($items, -1, 1, true))+1;
//echo $array[];
//print_r($array).'<br>';

?>
