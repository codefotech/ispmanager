<?php
$z_id = $_GET['z_id'];

include_once ("conn/connection.php") ;

$qaaaa = mysql_query("SELECT client_array AS client_array FROM mk_active_count WHERE sts = '0' AND client_array != '' ORDER BY id DESC LIMIT 1");
$roaa = mysql_fetch_assoc($qaaaa);
$client_array = $roaa['client_array'];
$all_online_client_array = explode(',', $client_array);

$qyaaaa = mysql_query("SELECT GROUP_CONCAT(c_id SEPARATOR ',') AS c_id FROM clients WHERE z_id = '$z_id' AND sts = '0' AND mac_user = '1'");
$rohha = mysql_fetch_assoc($qyaaaa);
$all_client_arrayy = $rohha['c_id'];
$all_client_array = explode(',', $all_client_arrayy);
$totalcount = count($all_client_array);

$commonValues = array_intersect($all_online_client_array, $all_client_array);
$total_online_count = count($commonValues);


$total_offline_count = $totalcount - $total_online_count;

//echo $total_offline_count.'<br>'.$total_online_count;

?>
<a href="Clients?RealtimeStatus=Online" title='ONLINE' style="color:teal;padding: 0px 5px 0px 0px;"><?php echo $total_online_count;?></a><a href="Clients?RealtimeStatus=Offline" title='OFFLINE' style="color:red;border-left: 1px solid #bbb;padding: 0px 0px 0px 5px;"><?php echo $total_offline_count;?></a>