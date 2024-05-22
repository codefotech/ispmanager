<?php
session_start();
include("conn/connection.php");
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
extract($_POST);

$queryff="SELECT * FROM zone WHERE status = '0' order by z_name";
$resultff=mysql_query($queryff);

$query2 = mysql_query("SELECT latitude, longitude FROM app_config");
$row2 = mysql_fetch_assoc($query2);

$zoneee = mysql_fetch_assoc(mysql_query("SELECT latitude, longitude FROM zone WHERE z_id = '$z_id'"));
$z_latitude = $zoneee['latitude'];
$z_longitude = $zoneee['longitude'];

if($z_id != '' && $z_id != 'all' && $z_latitude != ''){
$copmaly_latitude = $z_latitude;
$copmaly_longitude = $z_longitude;
}
else{
$copmaly_latitude = $row2['latitude'];
$copmaly_longitude = $row2['longitude'];
}

$API = new routeros_api();
$API->debug = false;

$items = array();
//$itemss = array();
$sql34 = mysql_query("SELECT id, Name, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND online_sts = '0'");
$tot_mk = mysql_num_rows($sql34);
while ($roww = mysql_fetch_assoc($sql34)) {
		$maikro_id = $roww['id'];
		$maikro_Name = $roww['Name'];
		$ServerIP1 = $roww['ServerIP'];
		$Username1 = $roww['Username'];
		$Pass1= openssl_decrypt($roww['Pass'], $roww['e_Md'], $roww['secret_h']);
		$Port1 = $roww['Port'];
		if ($API->connect($ServerIP1, $Username1, $Pass1, $Port1)){
				$arrID = $API->comm('/ppp/active/getall');
					foreach($arrID as $x => $x_value) {
						$items[] = $x_value['name'];
						$itemss_uptime[$x_value['name']] = $x_value['uptime'];
						$itemss_address[$x_value['name']] = $x_value['address'];
						$itemss_mac[$x_value['name']] = $x_value['caller-id'];
					}
			$API->disconnect();
		}
}

//$itemss1 = array_merge($itemss, $items);
?>
<!DOCTYPE html>
<html>
<head>
<title>Clients On Map</title>
<link rel="icon" type="images/png" href="images/favicon.png"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="css/map-main.css" rel="stylesheet">
	<link href="css/map-menu.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style.default.css" rel="stylesheet">
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcG5c_QCuL9PQqbz--UvuqZ_mcn9mN_3o&libraries&callback=initMap"></script>

<script type="text/javascript">
      var map;
      function initMap() {
        var myLatLng = {lat: <?php echo $copmaly_latitude;?>, lng: <?php echo $copmaly_longitude;?>};
        map = new google.maps.Map(document.getElementById('googleMap'), {
          center: myLatLng,
          zoom: 15
        });

<?php
	if($z_id == '' || $z_id == 'all'){
     $queryaa = mysql_query("SELECT c_id, com_id, address, cell, c_name, mk_id, latitude, longitude, thana, con_sts FROM clients WHERE latitude != '' AND longitude != ''") or die(mysql_error());
	}
	else{
     $queryaa = mysql_query("SELECT c_id, com_id, address, cell, c_name, mk_id, latitude, longitude, thana, con_sts FROM clients WHERE latitude != '' AND longitude != '' AND z_id = '$z_id'")or die(mysql_error());
	}
	
	$tot_all = mysql_num_rows($queryaa);
	$activecountt = 0;
	$inactivecountt = 0;
    while($rowmap = mysql_fetch_array($queryaa))
    {
		$com_id = $rowmap['com_id'];
		$mk_id = $rowmap['mk_id'];
		if(in_array($rowmap['c_id'], $items)){
			$uptime_val = '\nUptime: '.$itemss_uptime[$rowmap['c_id']];
			$address_val = '\nIP: '.$itemss_address[$rowmap['c_id']];
			$mac_val = '\nMAC: '.$itemss_mac[$rowmap['c_id']];
			
			$uptime_val1 = '<br><b style="color: green;font-size: 15px;font-weight: bold;">Uptime: '.$itemss_uptime[$rowmap['c_id']].'</b><br><form action="ClientView" method="post" target="_blank"><input type="hidden" name="ids" value="'.$rowmap['c_id'].'" /><button class="btn ownbtn2" style="padding: 1px 5px 0px 5px;"><i class="iconfa-eye-open"></i></button></form>';
			$address_val1 = '<br>IP: '.$itemss_address[$rowmap['c_id']];
			$mac_val1 = '<br>MAC: '.$itemss_mac[$rowmap['c_id']];
			
			if($itemss_mac[$rowmap['c_id']] != '' && $tot_all < '200'){
				$ppp_mac_replace = str_replace(":","-",$itemss_mac[$rowmap['c_id']]);
				$ppp_mac_replace_8 = substr($ppp_mac_replace, 0, 8);
					
				$macsearchaa = mysql_fetch_assoc(mysql_query("SELECT mac, info FROM mac_device WHERE mac = '$ppp_mac_replace_8'"));
				$running_device = '\nDevice: '.$macsearchaa['info'];
				$running_device1 = '<br><b style="color: #bf1f1f;"> Device: '.$macsearchaa['info'].'</b>';
			}
			else{
				$running_device = '';
				$running_device1 = '';
			}
			$img_marker = 'images/map_icon_active.png';
			
			$activecount = 1;
			$inactivecount = 0;
		}
		else{
			$address_val = '';
			$mac_val = '';
			$address_val1 = '';
			$mac_val1 = '';
			$running_device = '';
			$running_device1 = '';
			$img_marker = 'images/map_icon_inactive.png';
			
			$activecount = 0;
			$inactivecount = 1;
			
			$sqlmk1 = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, online_sts, secret_h, graph, web_port FROM mk_con WHERE sts = '0' AND id = '$mk_id' AND online_sts = '0'");
			$rowmk1 = mysql_fetch_assoc($sqlmk1);
			
			if($rowmk1['ServerIP'] != ''){
			$ServerIP = $rowmk1['ServerIP'];
			$Username = $rowmk1['Username'];
			$Pass= openssl_decrypt($rowmk1['Pass'], $rowmk1['e_Md'], $rowmk1['secret_h']);
			$Port = $rowmk1['Port'];
			
				if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
					$API->write('/ppp/secret/print', false);
					$API->write('?name='.$rowmap['c_id']);
					$ress=$API->read(true);
					$API->disconnect();
					
					$uptime_val = '\nLast Logged Out: '.$ress[0]['last-logged-out'];
					$uptime_val1 = '<br><b style="color: red;font-size: 15px;font-weight: bold;">Last Logged Out: '.$ress[0]['last-logged-out'].'</b><br><form action="ClientView" method="post" target="_blank"><input type="hidden" name="ids" value="'.$rowmap['c_id'].'" /><button class="btn ownbtn2" style="padding: 1px 5px 0px 5px;"><i class="iconfa-eye-open"></i></button></form>';
				}
			}
			else{
				$uptime_val = '';
				$uptime_val1 = '<br><form action="ClientView" method="post" target="_blank"><input type="hidden" name="ids" value="'.$rowmap['c_id'].'" /><button class="btn ownbtn2" style="padding: 1px 5px 0px 5px;"><i class="iconfa-eye-open"></i></button></form>';
			}
		}
		$activecountt += $activecount;
		$inactivecountt += $inactivecount;
		
		$address = preg_replace("/\r\n|\r|\n/", ' ', $rowmap['address']);
		$cell = preg_replace("/\r\n|\r|\n/", ' ', $rowmap['cell']);
		$c_name = preg_replace("/\r\n|\r|\n/", ' ', $rowmap['c_name']);
		
		
		$name = "<b>".$rowmap['c_id']." (".$c_name.")</b><br>".$address."<br>".$cell.$address_val1.$mac_val1.$running_device1.$uptime_val1;
		$name1 = $rowmap['c_id'].' ('.$c_name.')\n'.$address.'\n'.$cell.$address_val.$mac_val.$running_device.$uptime_val;
      
      
      $thana = $rowmap['thana'];
      $lat = $rowmap['latitude'];
      $lon = $rowmap['longitude'];

	echo "appendMarker$com_id(map, $lat$com_id, $lon$com_id, '$name', '$name1');
	    function appendMarker$com_id(map, latitude, longitude, text, text1) {
        var pos = {lat: latitude, lng: longitude};
		var iconBase = 'images/';
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  animation: google.maps.Animation.DROP,
		  icon: '$img_marker',
          title: text1 || 'No Name'
        };
		
		var marker=new google.maps.Marker(markerOption);
		var infoWindow=new google.maps.InfoWindow({ content: text, position: pos}); 
		google.maps.event.addListener(marker, 'click', function() {
			if(!marker.open){
				infoWindow.open(map,marker);
				marker.open = true;
			}
			else{
				infoWindow.close();
				marker.open = false;
			}
			google.maps.event.addListener(map, 'click', function() {
				infoWindow.close();
				marker.open = false;
			});
		});}\n";
 } ?>
		
      }
</script>
<body class="" onload="initMap()" style="margin:0px; padding:0px; border-top: 0; border-left: 10px solid #000; border-right: 10px solid #000; border-bottom: 10px solid #000;">
<div class="container-fluid no-padding no-margin mapBlock">
			<!-- Map card block -->
			<div class="lena-card card preferenceCard" style="min-width: 450px;">

					<div class="row">
						<form id="" name="form" class="stdform" method="POST" action="<?php echo $PHP_SELF;?>">	
							<div class="col-12">
								<div class="card card-cta no-border">
									<select data-placeholder="Select a Zone" name="z_id" style="width: 425px;text-align: center;" class="form-control select2"  onchange="submit();">
										<option value="all">ALL Zone</option>
										<?php while ($rowz=mysql_fetch_array($resultff)) { ?>
										<option style="text-align: Left;" value="<?php echo $rowz['z_id']?>"<?php if($rowz['z_id'] == $z_id){ echo 'selected'; }?>><?php echo $rowz['z_name'];?> <?php if($rowz['z_bn_name'] != ''){echo '('.$rowz['z_bn_name'].')';}?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</form>
						<br>
						<div style="float: left;padding: 0px 20px 0px 25px;color: #0866c6;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;font-size: 16px;"><img src='images/map_icon_active.png' width='30' height='30' style="inline-size: auto;"/> Online:  <i><?php echo $activecountt;?></i></div> 
						<div style="float: left;padding: 0px 0px 0px 25px;color: red;font-family: RobotoLight, Helvetica Neue, Helvetica, sans-serif;font-weight: bold;font-size: 16px;"><img src='images/map_icon_inactive.png' width='30' height='30' style="inline-size: auto;"/>Offline: <i><?php echo $inactivecountt;?></i></div>
				</div>
			</div>
		</div>
		<div id="googleMap"></div>
</body>
</html>
    <style type="text/css">
#googleMap {
  height: 100%;
}
    </style>
	
	<?php  
include('include/footer.php');
}
else{
	header("location: /index");
}

?>