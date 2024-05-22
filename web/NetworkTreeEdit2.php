<?php
$titel = "Edit Network Diagram Information";
$NetworkTree = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'NetworkTree' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && $t_id != ''){
//---------- Permission -----------


$query2sas = mysql_query("SELECT * FROM `network_tree_polyline` WHERE `tree_id` = '$t_id'");
$row2ss = mysql_fetch_assoc($query2sas);
$distance_km = $row2ss['distance_km'];
$distance_miles = $row2ss['distance_miles'];

$query2 = mysql_query("SELECT * FROM network_tree WHERE tree_id = '$t_id'");
$row2 = mysql_fetch_assoc($query2);
$tree_id = $row2['tree_id'];
$parent_id = $row2['parent_id'];
$in_port = $row2['in_port'];
$in_color = $row2['in_color'];
$out_port = $row2['out_port'];
$fiber_code = $row2['fiber_code'];
$z_id = $row2['z_id'];
$box_id = $row2['box_id'];
$device_type = $row2['device_type'];
$name = $row2['name'];
$location = $row2['location'];
$g_location = $row2['g_location'];
$note = $row2['note'];
$sts = $row2['sts'];
$device_sts = $row2['device_sts'];
$ip = $row2['ip'];
$ping = $row2['ping'];
$mk_id = $row2['mk_id'];
$latitude = $row2['latitude'];
$longitude = $row2['longitude'];

$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
$result=mysql_query($query);
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21" style="left: 35%;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="googleMap" style="width:170%;height:500px;"></div>
		</div>
	</div>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<?php if($tree_sts_permission == '0'){ ?><a class="btn ownbtn4" href="NetworkTreePloyDelete?id=<?php echo $tree_id;?>" title="Customized Road Will Be Delete" target='_blank'> Clear Road</a><?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-sitemap"></i></div>
        <div class="pagetitle">
            <h1>Edit Device</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Device Information </h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="NetworkTreeEditSave">
				<div class="modal-body">
					<input type="hidden" value="<?php echo $tree_id; ?>" name="tree_id" />
						<p>
							<label style="font-weight: bold;">Device Name*</label>
							<span class="field"><input type="text" name="name" id="" style="width:29.5%;" value="<?php echo $name;?>" required=""/></span>
						</p>
						<p>
							<label style="font-weight: bold;">Device Type*</label>
							<?php if($c_id == '') {?>
							<select class="select-ext-large chzn-select" style="width:10%;" name="device_type" required="" onChange="getRoutePoint1(this.value)">
								<?php 	$emp_n="SELECT id, d_name, d_details FROM device WHERE sts = '0' ORDER BY id ASC";	$e_n_ro=mysql_query($emp_n); ?>
								<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
								<option value="<?php echo $e_n_r['id'];?>" <?php if ($e_n_r['id'] == $device_type) echo 'selected="selected"';?>> <?php echo $e_n_r['d_name'];?></option>
								<?php } ?>
							</select>
							<?php } else{?>
							<select class="select-ext-large chzn-select" style="width:10%;" name="device_type" required="">
								<?php 	$emp_n="SELECT id, d_name, d_details FROM device WHERE sts = '0' AND id = '$device_type' ORDER BY id ASC";	$e_n_ro=mysql_query($emp_n); ?>
								<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
								<option value="<?php echo $e_n_r['id'];?>" <?php if ($e_n_r['id'] == $device_type) echo 'selected="selected"';?>> <?php echo $e_n_r['d_name'];?></option>
								<?php } ?>
							</select>
							<?php } ?>
						</p>
						<?php if($c_id != '') {?>
						<p>
							<label style="font-weight: bold;">Network*</label>
							<select name="mk_id" class="chzn-select" style="width:25%;" required="">		
										<?php 
											$queryd="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' AND id = '$mk_id' ORDER BY id ASC";
											$resultd=mysql_query($queryd);
										while ($rowd=mysql_fetch_array($resultd)) { ?>			
											<option value=<?php echo $rowd['id'];?> <?php if ($rowd['id'] == $mk_id) echo 'selected="selected"';?> ><?php echo $rowd['Name'];?> (<?php echo $rowd['ServerIP'];?>)</option>		
										<?php } ?>
							</select>
						</p>
						<?php } ?>
						<div id="Pointdiv1">
						<?php if($device_type == '4' || $device_type == '6' || $device_type == '8'){ if($c_id == '') {?>
						<p>
							<label style="font-weight: bold;">Network*</label>
							<select name="mk_id" class="chzn-select" style="width:25%;" required="">		
										<?php 
											$queryd="SELECT id, Name, ServerIP FROM mk_con WHERE sts = '0' ORDER BY id ASC";
											$resultd=mysql_query($queryd);
										while ($rowd=mysql_fetch_array($resultd)) { ?>			
											<option value=<?php echo $rowd['id'];?> <?php if ($rowd['id'] == $mk_id) echo 'selected="selected"';?> ><?php echo $rowd['Name'];?> (<?php echo $rowd['ServerIP'];?>)</option>		
										<?php } ?>
							</select>
						</p>
						<?php } ?>
						<p>
							<label>Check Ping?</label>
							<span class="formwrapper">
								<input type="radio" name="ping" value="1" <?php if ('1' == $ping) echo 'checked="checked"';?> onChange="getRoutePoint2(this.value)"> Yes &nbsp;
								<input type="radio" name="ping" value="0" <?php if ('0' == $ping) echo 'checked="checked"';?> onChange="getRoutePoint2(this.value)"> No &nbsp;
							</span>
						</p>
						<div id="Pointdiv2">
						<?php if($ping == '1'){ ?>
						<p>
							<label style="font-weight: bold;">Device Local IP*</label>
							<span class="field"><input type="text" name="ip" id="" value="<?php echo $ip;?>" style="width:15%;" required=""/></span>
						</p>
						<?php } else{ ?>
						<p>
							<label>Device Local IP</label>
							<span class="field"><input type="text" name="ip" id="" value="<?php echo $ip;?>" style="width:15%;"/></span>
						</p>
						<?php } ?>
						</div>
						<?php } ?>
						</div>
						<p>
							<label style="font-weight: bold;">Total Port/Core*</label>
							<?php if($device_type == '4'){ ?>
							<span class="field"><input type="text" name="out_port" id="" style="width:10%;" required="" readonly value="<?php echo $out_port;?>" placeholder="Port like 8, 16 etc" /></span>
							<?php } else{ ?>
							<span class="field"><input type="text" name="out_port" id="" style="width:10%;" required="" value="<?php echo $out_port;?>" placeholder="Port like 8, 16 etc" /></span>
							<?php } ?>
						</p>
						<p>
							<label>Fiber Code</label>
							<span class="field"><input type="text" name="fiber_code" id="" style="width:10%;" value="<?php echo $fiber_code;?>"/></span>
						</p>
						<p>	
							<label style="font-weight: bold;">LineIn Source/Uplink*</label>
							<select class="select-ext-large chzn-select" style="width:25%;" name="parent_id">
								<option value="">Choose Source</option>
								<?php $insorce=mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, n.location, z.z_id, z.z_name FROM network_tree AS n 
												LEFT JOIN device AS d ON d.id = n.device_type
												LEFT JOIN zone AS z ON z.z_id = n.z_id
												WHERE n.sts = '0' AND n.device_sts = '0' ORDER BY n.tree_id ASC");
										while ($enr=mysql_fetch_array($insorce)) { ?>
								<option value="<?php echo $enr['tree_id'];?>"<?php if ($enr['tree_id'] == $parent_id) echo 'selected="selected"';?>> <?php echo $enr['name'];?> ( <?php echo $enr['tree_id'];?> - <?php echo $enr['d_name'];?> - <?php echo $enr['out_port'];?> )</option>
								<?php } ?>
							</select>
						</p>
						<p>
						<label style="font-weight: bold;">Source Core/Fiber Color*</label>
							<select class="select-ext-large chzn-select" style="width:10%;" name="in_color">
								<option value="Black" style="color: black;font-weight: bold;"<?php if ('Black' == $in_color) echo 'selected="selected"';?>>Black</option>
								<option value="Blue" style="color: Blue;font-weight: bold;"<?php if ('Blue' == $in_color) echo 'selected="selected"';?>>Blue</option>
								<option value="Orange" style="color: Orange;font-weight: bold;"<?php if ('Orange' == $in_color) echo 'selected="selected"';?>>Orange</option>
								<option value="Green" style="color: Green;font-weight: bold;"<?php if ('Green' == $in_color) echo 'selected="selected"';?>>Green</option>
								<option value="Brown" style="color: Brown;font-weight: bold;"<?php if ('Brown' == $in_color) echo 'selected="selected"';?>>Brown</option>
								<option value="Gray" style="color: Gray;font-weight: bold;"<?php if ('Gray' == $in_color) echo 'selected="selected"';?>>Slate (Gray)</option>
								<option value="White" style="color: #db9595;font-weight: bold;"<?php if ('White' == $in_color) echo 'selected="selected"';?>>White</option>
								<option value="Red" style="color: Red;font-weight: bold;"<?php if ('Red' == $in_color) echo 'selected="selected"';?>>Red</option>
								<option value="Yellow" style="color: Yellow;font-weight: bold;"<?php if ('Yellow' == $in_color) echo 'selected="selected"';?>>Yellow</option>
								<option value="Violet" style="color: Violet;font-weight: bold;"<?php if ('Violet' == $in_color) echo 'selected="selected"';?>>Violet</option>
								<option value="Pink" style="color: Pink;font-weight: bold;"<?php if ('Pink' == $in_color) echo 'selected="selected"';?>>Rose (Pink)</option>
								<option value="Aqua" style="color: Aqua;font-weight: bold;"<?php if ('Aqua' == $in_color) echo 'selected="selected"';?>>Aqua</option>
							</select>
						</p>
						<p>
							<label style="font-weight: bold;">Source Core/Port No*</label>
							<span class="field"><input type="text" name="in_port" id="" style="width:5%;" required="" value="<?php echo $in_port;?>"/></span>
						</p>
					<?php if($tree_sts_permission == '0'){ ?>
						<p>
							<label></label>
							<span class="field" style="margin-left: 0;">
								<div class="input-append">
									<p id="latitude" style="margin: 2px 0px;"><input type="text" name="latitude" placeholder="Map Latitude" style="border-radius: 5px;" value="<?php echo $latitude;?>" class="span2" readonly ></p>
									<p id="longitude" style="margin: 2px 0px;"><input type="text" name="longitude" placeholder="Map Longitude" style="border-radius: 5px;" value="<?php echo $longitude;?>" class="span2" readonly ></p>
								</div>
								<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 15%;padding: 10px 15px;margin: 10px 10px;"><i class='iconfa-map-marker' style="font-size: 35px;"></i></a>
								<div class="input-append">
									<p id="distance_km" style="margin: 2px 0px;"><input type="text" name="distance_km" placeholder="KM" value="<?php echo $distance_km;?>" style="width: 60px;text-align: left;font-weight: bold;border-radius: 5px;" class="span2" readonly ></p>
									<p id="distance_miles" style="margin: 2px 0px;"><input type="text" name="distance_miles" placeholder="Miles" value="<?php echo $distance_miles;?>" style="width: 60px;text-align: left;font-weight: bold;border-radius: 5px;" class="span2" readonly ></p>
								</div>
							</span>
						</p>
					<?php } else{ ?>
						<input type="hidden" name="latitude" placeholder="Map Latitude" value="<?php echo $latitude;?>" class=""><input type="hidden" name="longitude" placeholder="Map Longitude" value="<?php echo $longitude;?>" class="">
					<?php } ?>
						<p>	
							<label>Zone*</label>
							<select class="select-ext-large chzn-select" style="width:25%;" name="z_id" required="" >
								<option value=""></option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
								<option value="<?php echo $row['z_id']?>"<?php if ($row['z_id'] == $z_id) echo 'selected="selected"';?>><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
									<?php } ?>
							</select>
						</p>
						<p>
							<label>Location</label>
							<span class="field"><textarea type="text" name="location" style="width:30%;" id="" placeholder="Address" class="input-xxlarge" /><?php echo $location;?></textarea></span>
						</p>
						<p>
							<label>Note</label>
							<span class="field"><textarea type="text" name="note" style="width:30%;" id="" placeholder="Device Note (If Any)" class="input-xxlarge" /><?php echo $note;?></textarea></span>
						</p>
						<p id="longitudedd"><input type="hidden" name="polyline_latlon"  style="width:100%;" class="span2"></p>
						<p id="longitudedd1"><input type="hidden" name="polyline_latlon1"  style="width:100%;" class="span2"></p>

					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>	



				
			</div>
		</div>
	</div>
<?php
include('include/footer.php');
}
else{
	header("location: index");
}

?>
<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	
	function getRoutePoint1(afdId1) {		
		var strURL="networktree_device_type.php?type="+afdId1+"&tree_id="+'<?php echo $tree_id;?>';
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
	function getRoutePoint2(afdId2) {		
		var strURL="networktree_device_ping_check.php?tree_id="+'<?php echo $tree_id;?>'+"&check_type="+afdId2;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv2').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
<?php if($latitude == '' && $longitude == ''){?>
<script>
var latitude = document.getElementById("latitude");
var longitude = document.getElementById("longitude");
function myMap() {
var mapProp= {
    center:new google.maps.LatLng(<?php echo $copmaly_latitude;?>, <?php echo $copmaly_longitude;?>),
    zoom:14,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
//     console.log(event.latLng);   // Get latlong info as object.
//     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
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
	
	echo "const main$tree_id=[{lat:$p_latitude,lng:$p_longitude},{lat:$t_latitude,lng:$t_longitude},];new google.maps.Polyline({map,path:main$tree_id,geodesic:true,strokeColor:'$in_color',strokeOpacity:1.0,strokeWeight:2,editable:false,draggable: false,});\n";
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

	echo "appendMarker$device_type(map, $lat$device_type, $lon$device_type, '$name$device_type');
	function appendMarker$device_type(map, latitude, longitude, text) {
		var pos = {lat: latitude, lng: longitude};
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  editable: false,
		  animation: google.maps.Animation.DROP,
		  icon: '$icon',
          title: text || 'No Name'
        };
        return new google.maps.Marker(markerOption);}\n";
 }

?>
google.maps.event.addListener(map, 'click', function(event) {
//alert(event.latLng.lat() + ", " + event.latLng.lng());
latitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map Latitude' readonly name='latitude' value='" + event.latLng.lat() + "'/>";
longitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map longitude' readonly name='longitude' value='" + event.latLng.lng() + "'/>";
});

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&callback=myMap&libraries=geometry&v=weekly"></script>
<?php } else{ ?>
<script type="text/javascript">
var flightPath = null;
function my_map_add() {
var myMapCenter = new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>);
var myMapProp = {center:myMapCenter, zoom:16, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("googleMap"),myMapProp);
var marker = new google.maps.Marker({position:myMapCenter});
marker.setMap(map);

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
//     console.log(event.latLng);   // Get latlong info as object.
//     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
	 latitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map Latitude' readonly name='latitude' value='" + event.latLng.lat() + "'/>";
	 longitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map longitude' readonly name='longitude' value='" + event.latLng.lng() + "'/>";
 });
 <?php 
$sqls = mysql_query("SELECT t.tree_id FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id WHERE t.tree_id != '0' AND t.latitude != '' AND p.latitude != '' AND t.sts = '0' AND t.parent_id = '$parent_id' AND t.tree_id != '$t_id'");

while( $rowa = mysql_fetch_assoc($sqls) ){
	$queryaaaa = mysql_query("SELECT t.tree_id, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, IFNULL(a.latlng, 0.00) AS latlng, t.in_color FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.tree_id = '{$rowa['tree_id']}' AND t.longitude != ''");
	$rowaaaa = mysql_fetch_assoc($queryaaaa);
	$tree_id = $rowaaaa['tree_id'];
	$parent_id1 = $rowaaaa['parent_id'];
	$p_latitude = $rowaaaa['p_latitude'];
	$p_longitude = $rowaaaa['p_longitude'];
	$t_latitude = $rowaaaa['t_latitude'];
	$t_longitude = $rowaaaa['t_longitude'];
	$latlng1 = $rowaaaa['latlng'];
	if($latlng1 == '0.00'){
		$qqq = "{lat:".$t_latitude.",lng:".$t_longitude."},";
	}
	else{
		$qqq = $latlng1;
	}
	$in_color = $rowaaaa['in_color'];
	
	echo "var main$tree_id=[{lat:$p_latitude,lng:$p_longitude},$qqq]; flightPath = new google.maps.Polyline({map,path:main$tree_id,geodesic:true,editable:false,strokeColor:'$in_color',strokeOpacity:1.0,strokeWeight:2,});\n";
}

$edit_query2 = mysql_query("SELECT t.tree_id, t.parent_id, p.latitude AS p_latitude, a.distance_miles, a.distance_km, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, IFNULL(a.latlng, 0.00) AS latlng, t.in_color FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN network_tree_polyline AS a ON a.tree_id = t.tree_id WHERE t.longitude != '' AND t.tree_id = '$t_id'");
$edit_row2 = mysql_fetch_assoc($edit_query2);
	$edit_tree_id = $edit_row2['tree_id'];
	$edit_parent_id1 = $edit_row2['parent_id'];
	$edit_p_latitude = $edit_row2['p_latitude'];
	$edit_p_longitude = $edit_row2['p_longitude'];
	$edit_t_latitude = $edit_row2['t_latitude'];
	$edit_t_longitude = $edit_row2['t_longitude'];
	$edit_latlng = $edit_row2['latlng'];
	$distance_kmm = $edit_row2['distance_km'];
	$distance_miless = $edit_row2['distance_miles'];
	if($edit_latlng == '0.00'){
		$edit_qqq = "{lat:".$edit_t_latitude.",lng:".$edit_t_longitude."},";
	}
	else{
		$edit_qqq = $edit_latlng."{lat:".$edit_t_latitude.",lng:".$edit_t_longitude."},";
	}
	$edit_in_color = $edit_row2['in_color'];

echo "var main$edit_tree_id=[{lat:$edit_p_latitude,lng:$edit_p_longitude},$edit_qqq]; flightPath = new google.maps.Polyline({map,path:main$edit_tree_id,geodesic:true,editable:true,strokeColor:'$edit_in_color',strokeOpacity:1.0,strokeWeight:2,});";

$olt_query2 = mysql_query("SELECT t.tree_id, t.device_type, t.name, t.parent_id, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon FROM network_tree AS t
							LEFT JOIN device AS d ON d.id = t.device_type
							WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND t.tree_id = '$parent_id'");
$olt_row2 = mysql_fetch_assoc($olt_query2);
$olt_device_type = $olt_row2['device_type'];
$olt_icon = $olt_row2['icon'];
$olt_lat = $olt_row2['t_latitude'];
$olt_lon = $olt_row2['t_longitude'];

$olt_name1 = $olt_row2['name'].' ('.$olt_row2['d_name'].')\n'.$distance_kmm;
$olt_name = '<b>'.$olt_row2['name'].' ('.$olt_row2['d_name'].')</b><br>'.$distance_kmm.' | '.$distance_miless;
	echo "appendMarker$olt_device_type(map, $olt_lat, $olt_lon, '$olt_name', '$olt_name1');
	function appendMarker$olt_device_type(map, latitude, longitude, texttt, texttt1) {
		var pos = {lat: latitude, lng: longitude};
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  animation: google.maps.Animation.BOUNCE,
		  icon: '$olt_icon',
          title: texttt1 || 'No Name'
        };
        var marker=new google.maps.Marker(markerOption);
		var infoWindow=new google.maps.InfoWindow({ content: texttt, position: pos}); 
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

$queryaa = mysql_query("SELECT t.tree_id, t.device_type, t.name, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND t.tree_id != '$t_id' AND t.parent_id = '$parent_id' AND p.latitude != '' AND p.longitude != ''")or die(mysql_error());
while($rowmap = mysql_fetch_array($queryaa))
{		  
      $name = $rowmap['name'].' ('.$rowmap['d_name'].')';
      $device_type = $rowmap['device_type'];
      $icon = $rowmap['icon'];
      $lat = $rowmap['t_latitude'];
      $lon = $rowmap['t_longitude'];

	echo "appendMarker$device_type(map, $lat$device_type, $lon$device_type, '$name');
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

google.maps.event.addListener(flightPath, "dragend", getPath);
google.maps.event.addListener(flightPath.getPath(), "insert_at", getPath);
google.maps.event.addListener(flightPath.getPath(), "remove_at", getPath);
google.maps.event.addListener(flightPath.getPath(), "set_at", getPath);
flightPath.setMap(map);
}
//  document.getElementById('info').innerHTML = (polylineLength / 1000).toFixed(2) + " km (" + (polylineLength / 1609).toFixed(2) + " miles)";
//  console.log((polylineLength / 1000).toFixed(2) + " km (" + (polylineLength / 1609).toFixed(2) + " miles)");

function getPath() {
	var polylineLength = google.maps.geometry.spherical.computeLength(flightPath.getPath());
	var path1 = flightPath.getPath();
	var len = path1.getLength();
	var coordStr = "";
	var coordStr1 = "";
  for (var i = 0; i < len; i++) {
	  var xy = path1.getAt(i);
    coordStr +=  "{lat:"+xy.lat() + ",lng:" + xy.lng()+"},";
    coordStr1 +=  "{"+xy.lat() + "," + xy.lng()+"},";
  }
//  document.getElementById('path1').innerHTML = coordStr;
longitudedd.innerHTML = "<input type='hidden' class='span2' name='polyline_latlon'  style='width:100%;' readonly value='" + coordStr + "'/>";
document.getElementById('distance_km').innerHTML = "<input type='text' class='span2' name='distance_km' style='width: 60px;text-align: left;font-weight: bold;border-radius: 5px;' readonly value='" + (polylineLength / 1000).toFixed(2) + " KM '/>";
document.getElementById('distance_miles').innerHTML = "<input type='text' class='span2' name='distance_miles' style='width: 60px;text-align: left;font-weight: bold;border-radius: 5px;' readonly value='" + (polylineLength / 1609).toFixed(2) + " Miles'/>";
}

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&callback=my_map_add&libraries=geometry&v=weekly"></script>
<?php } ?>