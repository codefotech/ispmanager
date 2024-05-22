<?php 
include("conn/connection.php");
$parent_id=$_GET['parent_id'];
$sql2 ="SELECT * FROM network_tree WHERE tree_id = '$parent_id'";

$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$t_id = $row2['tree_id'];
$latitude = $row2['latitude'];
$longitude = $row2['longitude'];

if($parent_id != ''){
?>

<span class="field">
	<div class="input-append" style="margin-right: 5px;">
		<p id="latitude"><input type="text" id="" name="latitude" placeholder="Google Map Latitude" class="span2"></p>
		<p id="longitude"><input type="text" id="" name="longitude" placeholder="Google Map Longitude" class="span2"></p>
	</div>
<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 15%;padding: 10px;width: 3%;"><i class='iconfa-map-marker' style="font-size: 35px;"></i></a>
</span>
<?php } else {}?>

<script type="text/javascript">
function my_map_add() {
var myMapCenter = new google.maps.LatLng(22.76534857824139, 89.60386197950233);
var myMapProp = {center:myMapCenter, zoom:15, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("googleMap"),myMapProp);
var marker = new google.maps.Marker;
marker.setMap(map);

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
     console.log(event.latLng);   // Get latlong info as object.
     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
	 latitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map Latitude' readonly name='latitude' value='" + event.latLng.lat() + "'/>";
	 longitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map longitude' readonly name='longitude' value='" + event.latLng.lng() + "'/>";
 });
 <?php 
$sql = mysql_query("SELECT t.tree_id FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id WHERE t.tree_id != '0' AND t.latitude != '' AND p.latitude != '' AND t.sts = '0'");
while( $row = mysql_fetch_assoc($sql) ){
	$queryaaaa = mysql_query("SELECT t.tree_id, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id WHERE t.tree_id = '{$row['tree_id']}'");
	$rowaaaa = mysql_fetch_assoc($queryaaaa);
	$tree_id = $rowaaaa['tree_id'];
	$parent_id1 = $rowaaaa['parent_id'];
	$p_latitude = $rowaaaa['p_latitude'];
	$p_longitude = $rowaaaa['p_longitude'];
	$t_latitude = $rowaaaa['t_latitude'];
	$t_longitude = $rowaaaa['t_longitude'];
	$in_color = $rowaaaa['in_color'];
	
	echo "const main$tree_id=[{lat:$p_latitude,lng:$p_longitude},{lat:$t_latitude,lng:$t_longitude},];new google.maps.Polyline({map,path:main$tree_id,geodesic:true,strokeColor:'$in_color',strokeOpacity:1.0,strokeWeight:2,});\n";
}

$olt_query2 = mysql_query("SELECT t.tree_id, t.device_type, t.name, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND t.tree_id = '0'");
$olt_row2 = mysql_fetch_assoc($olt_query2);
$olt_name = $olt_row2['name'].' ('.$olt_row2['d_name'].')';
$olt_device_type = $olt_row2['device_type'];
$olt_icon = $olt_row2['icon'];
$olt_lat = $olt_row2['t_latitude'];
$olt_lon = $olt_row2['t_longitude'];

	echo "appendMarker$olt_device_type(map, $olt_lat, $olt_lon, '$olt_name');
	function appendMarker$olt_device_type(map, latitude, longitude, text) {
		var pos = {lat: latitude, lng: longitude};
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  animation: google.maps.Animation.DROP,
		  icon: '$olt_icon',
          title: text || 'No Name'
        };
        return new google.maps.Marker(markerOption);}";

$queryaa = mysql_query("SELECT t.tree_id, t.device_type, t.name, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND p.latitude != '' AND p.longitude != '' AND t.tree_id != '0'")or die(mysql_error());
while($rowmap = mysql_fetch_array($queryaa))
{		  
      $name = $rowmap['name'].' ('.$rowmap['d_name'].')';
      $device_type = $rowmap['device_type'];
      $icon = $rowmap['icon'];
      $lat = $rowmap['t_latitude'];
      $lon = $rowmap['t_longitude'];

	echo "appendMarker$device_type(map, $lat, $lon, '$name');
	function appendMarker$device_type(map, latitude, longitude, text) {
		var pos = {lat: latitude, lng: longitude};
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  animation: google.maps.Animation.DROP,
		  icon: '$icon',
          title: text || 'No Name'
        };
        return new google.maps.Marker(markerOption);}\n";
 }

?>
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkwr5rmzY9btU08sQlU9N0qfmo8YmE91Y&libraries&callback=my_map_add"></script>