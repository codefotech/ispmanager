<?php
include("conn/connection.php") ;
include("mk_api.php");
$mk_id = $_GET['id'];

function create_progress() {
  echo "
<style>
#text {
  position: absolute;
  font-size: 18px;
  text-align: center;
  width: 10%;
}
  #barbox_a {
  position: absolute;
  width: 10%;
  height: 15px;
}
.per {
  /*! position: absolute; */
  margin: -3px 5px 0px 15px;
  font-size: 12px;
  background-color: #FFFFFF;
  font-weight: bold;
}

.bar {
  position: absolute;
  width: 0px;
  height: 15px;
 /*! background-color: #FF00003D; */
}

.blank {
  background-color: white;
  width: 10%;
}
</style>
";

echo "<div class='bar'></div>";
}

function update_progress($percent) {
 // echo "<div class='per' style='float: right;'>{$percent}%</div>";
if($percent <= '10'){
  echo "<div class='bar' style='border-radius: 3px;border: 1px solid darkgray;background-color: #00FF103D;width: ", $percent * 10, "px'><div class='per' style='float: right;background: transparent;'>{$percent}%</div></div>";
 }
elseif($percent <= '15'){
  echo "<div class='bar' style='border-radius: 3px;border: 1px solid darkgray;background-color: #00ABFF3D;width: ", $percent * 10, "px'><div class='per' style='float: right;background: transparent;'>{$percent}%</div></div>";
}
elseif($percent <= '20'){
  echo "<div class='bar' style='border-radius: 3px;border: 1px solid darkgray;background-color: #C7FF003D;width: ", $percent * 10, "px'><div class='per' style='float: right;background: transparent;'>{$percent}%</div></div>";
}
elseif($percent <='25'){
  echo "<div class='bar' style='border-radius: 3px;border: 1px solid darkgray;background-color: #FF00003D;width: ", $percent * 10, "px'><div class='per' style='float: right;background: transparent;'>{$percent}%</div></div>";
}
elseif($percent <='30'){
  echo "<div class='bar' style='border-radius: 3px;border: 1px solid darkgray;background-color: #FF000061;width: ", $percent * 10, "px'><div class='per' style='float: right;background: transparent;'>{$percent}%</div></div>";
}
else{
  echo "<div class='bar' style='border-radius: 3px;border: 1px solid darkgray;background-color: #FF0000A3;width: ", $percent * 10, "px'><div class='per' style='float: right;background: transparent;'>{$percent}%</div></div>";
 }
}

create_progress();

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
		
		$API = new routeros_api();
		$API->debug = false;
		
    if($API->connect($ServerIP, $Username, $Pass, $Port)) {
		$ARRAY = $API->comm("/system/resource/print");
		$first = $ARRAY['0'];
		$fghfgj = $first['cpu-load'];
		
		update_progress($fghfgj);
} else{
	echo 'Mikrotik Not Connected. Please check.';
}
?>
