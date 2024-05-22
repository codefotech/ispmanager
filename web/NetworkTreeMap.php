<?php 
session_start(); // NEVER FORGET TO START THE SESSION!!!
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

$treeid = isset($_POST['tree_id']) ? $_POST['tree_id'] : '';

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'NetworkTree' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$queryff="SELECT n.tree_id, n.parent_id, n.out_port, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, n.location, z.z_id, z.z_name FROM network_tree AS n 
			LEFT JOIN device AS d ON d.id = n.device_type
			LEFT JOIN zone AS z ON z.z_id = n.z_id
			WHERE n.sts = '0' AND n.device_sts = '0' AND n.latitude != '' AND n.latitude != '' ORDER BY n.tree_id ASC";
$resultff=mysql_query($queryff);

if($treeid != ''){
$query22 = mysql_query("SELECT * FROM network_tree WHERE tree_id = '$treeid'");
$row22 = mysql_fetch_assoc($query22);
$latitude = $row22['latitude'];
$longitude = $row22['longitude'];

$zoom = '20';
}
else{
$query22 = mysql_query("SELECT * FROM network_tree WHERE tree_id = '0'");
$row22 = mysql_fetch_assoc($query22);
$latitude = $row22['latitude'];
$longitude = $row22['longitude'];

$zoom = '18';
}
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Network Diagram On Map</title>
	<link rel="icon" type="images/png" href="images/favicon.png"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="css/map-main.css" rel="stylesheet">
	<link href="css/map-menu.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style.default.css" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcG5c_QCuL9PQqbz--UvuqZ_mcn9mN_3o&callback=initMap"></script>
    <script>
      // This example creates a 2-pixel-wide red polyline showing the path of
      // the first trans-Pacific flight between Oakland, CA, and Brisbane,
      // Australia which was made by Charles Kingsford Smith.
      function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: <?php echo $zoom;?>,
          center: { lat: <?php echo $latitude;?>, lng: <?php echo $longitude;?> },
          mapTypeId: "terrain",
        });
		
<?php 
if($treeid != ''){
$sqls = mysql_query("SELECT t.tree_id FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id WHERE t.tree_id != '0' AND t.latitude != '' AND p.latitude != '' AND t.sts = '0' AND t.parent_id = '$treeid'");
}
else{
$sqls = mysql_query("SELECT t.tree_id FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id WHERE t.tree_id != '0' AND t.latitude != '' AND p.latitude != '' AND t.sts = '0'");
}
while( $rowa = mysql_fetch_assoc($sqls) ){
	$queryaaaa = mysql_query("SELECT t.tree_id, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, IFNULL(a.latlng, 0.00) AS latlng, t.in_color FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.tree_id = '{$rowa['tree_id']}'");
	$rowaaaa = mysql_fetch_assoc($queryaaaa);
	$tree_id = $rowaaaa['tree_id'];
	$parent_id = $rowaaaa['parent_id'];
	$p_latitude = $rowaaaa['p_latitude'];
	$p_longitude = $rowaaaa['p_longitude'];
	$t_latitude = $rowaaaa['t_latitude'];
	$t_longitude = $rowaaaa['t_longitude'];
	$latlng1 = $rowaaaa['latlng'];
	if($latlng1 == '0.00'){
		$qqq = "{lat:".$t_latitude.",lng:".$t_longitude."},";
	}
	else{
		$qqq = $latlng1."{lat:".$t_latitude.",lng:".$t_longitude."},";
	}
	$in_color = $rowaaaa['in_color'];
	
	echo "const main$tree_id=[{lat:$p_latitude,lng:$p_longitude},$qqq];new google.maps.Polyline({map,path:main$tree_id,geodesic:true,strokeColor:'$in_color',strokeOpacity:1.0,strokeWeight:2,});\n";
}
if($treeid != ''){
$olt_query2 = mysql_query("SELECT t.tree_id, t.device_type, t.name AS devicename, z.z_name, t.location, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon, a.latlng, a.distance_km, a.distance_miles FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND t.tree_id = '$treeid'");
}
else{	
$olt_query2 = mysql_query("SELECT t.tree_id, t.device_type, t.name AS devicename, z.z_name, t.location, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon, a.latlng, a.distance_km, a.distance_miles FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND t.tree_id = '0'");
}
$olt_row2 = mysql_fetch_assoc($olt_query2);

$view_btnn_downlinkk = '<form action="'.$PHP_SELF.'" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="tree_id" value="'.$olt_row2['tree_id'].'" /><button class="btn ownbtn2" style="padding: 0px;border: none;background: transparent;" title="Downlink"><i class="iconfa-download-alt"></i></button></form>';
if($olt_row2['tree_id'] != '0'){
$view_btnn_uplinkk = '<form action="'.$PHP_SELF.'" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="tree_id" value="'.$olt_row2['parent_id'].'" /><button class="btn ownbtn6" style="padding: 0px;border: none;background: transparent;" title="Uplink"><i class="iconfa-upload-alt"></i></button></form>';
$edit_device = '<form action="NetworkTreeEdit" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="t_id" value="'.$olt_row2['tree_id'].'" /><button class="btn ownbtn1" style="padding: 0px;border: none;background: transparent;" title="Edit Device"><i class="iconfa-edit"></i></button></form>';
}
else{
$view_btnn_uplinkk = '';
$edit_device = '';
}

$add_device = '<form action="NetworkTreeAdd" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="parent_id" value="'.$olt_row2['tree_id'].'" /><button class="btn ownbtn4" style="padding: 0px;border: none;background: transparent;" title="Add New Device"><i class="iconfa-plus"></i></button></form>';

		if($olt_row2['distance_km'] != ''){
			$rote_distencee = '<br><b>'.$olt_row2['distance_km'].' | '.$olt_row2['distance_miles'].'</b>';
		}
		else{
			$rote_distencee = '';
		}

$olt_name = '<b>'.$olt_row2['devicename'].'</b><br>'.$olt_row2['d_name'].'<br>'.$olt_row2['z_name'].$rote_distencee.'<br>'.$add_device.$edit_device.$view_btnn_uplinkk;
$olt_name1 = $olt_row2['devicename'].'\n'.$olt_row2['d_name'].'\n'.$olt_row2['z_name'].'\n';

$olt_device_type = $olt_row2['device_type'];
$olt_icon = $olt_row2['icon'];
$olt_lat = $olt_row2['t_latitude'];
$olt_lon = $olt_row2['t_longitude'];

	echo "appendMarkera$olt_device_type(map, $olt_lat, $olt_lon, '$olt_name', '$olt_name1');
	function appendMarkera$olt_device_type(map, latitude, longitude, textt, text11) {
		var pos = {lat: latitude, lng: longitude};
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  animation: google.maps.Animation.BOUNCE,
		  icon: '$olt_icon',
          title: text11 || 'No Name'
        };
        var marker=new google.maps.Marker(markerOption);
		var infoWindow=new google.maps.InfoWindow({ content: textt, position: pos}); 
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
		});}";


if($treeid != ''){
$queryaa = mysql_query("SELECT t.tree_id, t.device_type, t.name AS devicename, t.parent_id, z.z_name, t.location, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon, a.latlng, a.distance_km, a.distance_miles FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND p.latitude != '' AND p.longitude != '' AND t.parent_id = '$treeid'")or die(mysql_error());
}
else{
$queryaa = mysql_query("SELECT t.tree_id, t.device_type, t.name AS devicename, t.parent_id, z.z_name, t.location, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon, a.latlng, a.distance_km, a.distance_miles FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND p.latitude != '' AND p.longitude != '' AND t.tree_id != '0'")or die(mysql_error());
}
while($rowmap = mysql_fetch_array($queryaa))
{
		$view_btnn_downlink = '<form action="'.$PHP_SELF.'" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="tree_id" value="'.$rowmap['tree_id'].'" /><button class="btn ownbtn2" style="padding: 0px;border: none;background: transparent;" title="Downlink"><i class="iconfa-download-alt"></i></button></form>';
		$view_btnn_uplink = '<form action="'.$PHP_SELF.'" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="tree_id" value="'.$rowmap['parent_id'].'" /><button class="btn ownbtn6" style="padding: 0px;border: none;background: transparent;" title="Uplink"><i class="iconfa-upload-alt"></i></button></form>';
		$add_devicee = '<form action="NetworkTreeAdd" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="parent_id" value="'.$rowmap['tree_id'].'" /><button class="btn ownbtn4" style="padding: 0px;border: none;background: transparent;" title="Add New Device"><i class="iconfa-plus"></i></button></form>';
		$edit_devicee = '<form action="NetworkTreeEdit" method="post" style="float: left;margin-right: 5px;"><input type="hidden" name="t_id" value="'.$rowmap['tree_id'].'" /><button class="btn ownbtn1" style="padding: 0px;border: none;background: transparent;" title="Edit Device"><i class="iconfa-edit"></i></button></form>';
		
		if($rowmap['distance_km'] != ''){
			$rote_distence = '<br><b>'.$rowmap['distance_km'].' | '.$rowmap['distance_miles'].'</b>';
		}
		else{
			$rote_distence = '';
		}
		
		$z_name = preg_replace("/\r\n|\r|\n/", ' ', $rowmap['z_name']);
		$c_name = preg_replace("/\r\n|\r|\n/", ' ', $rowmap['c_name']);
		
		$name = '<b>'.$rowmap['devicename'].'</b><br>'.$rowmap['d_name'].'<br>'.$z_name.$rote_distence.'<br><br>'.$add_devicee.$edit_devicee.$view_btnn_uplink.$view_btnn_downlink;
		$name1 = $rowmap['devicename'].'\n'.$rowmap['d_name'].'\n'.$z_name.'\n';
	  
      $device_type = $rowmap['device_type'];
      $iconn = $rowmap['icon'];
      $lat = $rowmap['t_latitude'];
      $lon = $rowmap['t_longitude'];

	echo "appendMarker$device_type(map, $lat, $lon, '$name', '$name1');
	function appendMarker$device_type(map, latitude, longitude, text, text1) {
		var pos = {lat: latitude, lng: longitude};
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  animation: google.maps.Animation.DROP,
		  icon: '$iconn',
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
 }
?>
		 }
    </script>
  
<body class="" onload="initMap()" style="margin:0px; padding:0px; border-top: 0; border-left: 10px solid #000; border-right: 10px solid #000; border-bottom: 10px solid #000;">
<div class="container-fluid no-padding no-margin mapBlock">
			<!-- Map card block -->
			<div class="lena-card card preferenceCard" style="min-width: 300px;">

					<div class="row">
						<form id="" name="form" class="stdform" style="width: 100%;" method="POST" action="<?php echo $PHP_SELF;?>">	
							<div class="col-12">
								<div class="card card-cta no-border">
									<select data-placeholder="Select a Device Type" name="tree_id" style="width: 100%;" class="form-control select2"  onchange="submit();">
										<option value="">ALL Device</option>
										<?php while ($rowz=mysql_fetch_array($resultff)) { ?>
										<option style="text-align: Left;" value="<?php echo $rowz['tree_id']?>"<?php if($rowz['tree_id'] == $treeid){ echo 'selected'; }?>><?php echo $rowz['name'];?> - <?php echo $rowz['d_name'];?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</form>
					</div>
			</div>
		</div>
		<div id="map"></div>
</body>
</html>
    <style type="text/css">
#map {
  height: 96%;
}
    </style>
	
	<?php  
include('include/footer.php');
}
else{
	header("location: /index");
}

?>