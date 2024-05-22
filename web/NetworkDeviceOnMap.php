<?php
session_start();
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'NetworkTree' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
extract($_POST);

$queryff="SELECT d.id, d.d_name AS devicename, COUNT(n.device_type) AS devi, d.icon FROM network_tree AS n 
			LEFT JOIN device AS d ON d.id = n.device_type
			LEFT JOIN zone AS z ON z.z_id = n.z_id
			WHERE n.sts = '0' AND n.device_sts = '0' GROUP BY n.device_type ORDER BY COUNT(n.device_type) DESC";
$resultff=mysql_query($queryff);

$query2 = mysql_query("SELECT latitude, longitude FROM app_config");
$row2 = mysql_fetch_assoc($query2);

$copmaly_latitude = $row2['latitude'];
$copmaly_longitude = $row2['longitude'];

?>
<!DOCTYPE html>
<html>
<head>
<title>Device On Map</title>
<link rel="icon" type="images/png" href="images/favicon.png"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="css/map-main.css" rel="stylesheet">
	<link href="css/map-menu.css" rel="stylesheet">
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
	if($d_type == '' || $d_type == 'all'){
     $queryaa = mysql_query("SELECT t.tree_id, t.name AS devicename, t.parent_id, d.d_name, d.icon, t.latitude, t.longitude, z.z_name, t.location FROM `network_tree` AS t LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id WHERE t.latitude != '' AND t.sts = '0'") or die(mysql_error());
	}
	else{
     $queryaa = mysql_query("SELECT t.tree_id, t.name AS devicename, t.parent_id, d.d_name, d.icon, t.latitude, t.longitude, z.z_name, t.location FROM `network_tree` AS t LEFT JOIN device AS d ON d.id = t.device_type LEFT JOIN zone AS z ON z.z_id = t.z_id WHERE t.latitude != '' AND t.sts = '0' AND t.device_type = '$d_type'")or die(mysql_error());
	}
	
	$activecountt = 0;
	$inactivecountt = 0;
    while($rowmap = mysql_fetch_array($queryaa))
    {
		$img_marker = $rowmap['icon'];
		$name = '<b>'.$rowmap['devicename'].'</b><br>'.$rowmap['d_name'].'<br>'.$rowmap['z_name'];
		$name1 = $rowmap['devicename'].'\n'.$rowmap['d_name'].'\n'.$rowmap['z_name'].'\n';
      
      $tree_id = $rowmap['tree_id'];
      $lat = $rowmap['latitude'];
      $lon = $rowmap['longitude'];

	echo "appendMarker$tree_id(map, $lat$tree_id, $lon$tree_id, '$name', '$name1');
	    function appendMarker$tree_id(map, latitude, longitude, text, text1) {
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
			<div class="lena-card card preferenceCard" style="min-width: 300px;">

					<div class="row">
						<form id="" name="form" class="stdform" style="width: 100%;" method="POST" action="<?php echo $PHP_SELF;?>">	
							<div class="col-12">
								<div class="card card-cta no-border">
									<select data-placeholder="Select a Device Type" name="d_type" style="width: 100%;" class="form-control select2"  onchange="submit();">
										<option value="all">ALL Device</option>
										<?php while ($rowz=mysql_fetch_array($resultff)) { ?>
										<option style="text-align: Left;" value="<?php echo $rowz['id']?>"<?php if($rowz['id'] == $d_type){ echo 'selected'; }?>><?php echo $rowz['devicename'];?> <img src='<?php echo $rowz['icon'];?>' width='30' height='30' style="inline-size: auto;"/></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</form>
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