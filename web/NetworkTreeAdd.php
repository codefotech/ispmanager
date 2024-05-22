<?php
$titel = "Network Diagram Add";
$NetworkTree = 'active';
include('include/hader.php');
include("conn/connection.php");
$parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : '';
extract($_POST);

$eid = $_SESSION['SESS_EMP_ID'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'NetworkTree' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($parent_id != ''){
$sql22 ="SELECT * FROM network_tree WHERE tree_id = '$parent_id'";

$query22 = mysql_query($sql22);
$row22 = mysql_fetch_assoc($query22);
$latitude = $row22['latitude'];
$longitude = $row22['longitude'];
$parent_z_id = $row22['z_id'];

$query="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
$result=mysql_query($query);
}
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21" style="left: 35%;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="googleMap" style="width:170%;height:500px;"></div>
		</div>
	</div>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form class="stdform" method="post" action="" name="form" enctype="multipart/form-data">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5"> New Device Type </h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">Device Type</div>
							<div class="col-2"><input type="text" name="d_type" required="" id="" class="input-xlarge" placeholder="Ex: OLT, Onu" /></div>
						</div>
						<div class="popdiv">
							<div class="col-1">Type Discription</div>
							<div class="col-2"><input type="text" name="d_des" id="" class="input-xlarge" placeholder="Discription" /></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn ownbtn11">Reset</button>
					<button class="btn ownbtn2" type="submit">Submit</button>
				</div>
			</div>
		</div>	
	</form>	
	</div><!--#myModal-->
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		<?php if($user_type == 'admin' || $user_type == 'superadmin'){?>
			<button class="btn ownbtn5" href="#myModal" data-toggle="modal">Add Device Type</button>
		<?php }?>
		</div>
        <div class="pageicon"><i class="iconfa-sitemap"></i></div>
        <div class="pagetitle">
            <h1>Network Diagram</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
					<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 20px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">Source / Uplink Information</div>
					<br/>
						<form id="" name="form1" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
								<p>	
									<label style="font-weight: bold;">LineIn Source/Uplink*</label>
									<select class="select-ext-large chzn-select" style="width:25%;" name="parent_id" onchange="submit();">
										<option value="">Choose Source</option>
										<?php $insorce=mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, n.location, z.z_id, z.z_name FROM network_tree AS n 
														LEFT JOIN device AS d ON d.id = n.device_type
														LEFT JOIN zone AS z ON z.z_id = n.z_id
														WHERE n.sts = '0' AND n.device_sts = '0' ORDER BY n.tree_id ASC");
												while ($enr=mysql_fetch_array($insorce)) { ?>
										<option value="<?php echo $enr['tree_id'];?>"<?php if ($enr['tree_id'] == $parent_id) echo 'selected="selected"';?>><?php echo $enr['tree_id'];?> - <?php echo $enr['name'];?> ( <?php echo $enr['d_name'];?> - <?php echo $enr['out_port'];?> )</option>
										<?php } ?>
									</select>
								</p>
								<?php if($parent_id == ''){ ?><br/><?php } ?>
						</form>
				<?php if($parent_id != ''){ ?>
				<form id="" name="form1" class="stdform" method="post" action="NetworkTreeAddSave">
					<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID'];?>" name="entry_by" />
					<input type="hidden" value="<?php echo date('Y-m-d H:i:s');?>" name="enty_date" />
					<input type="hidden" value="<?php echo $parent_id;?>" name="parent_id" />								
					<p>
						<label style="font-weight: bold;">Source Core/Fiber Color*</label>
						<select class="select-ext-large chzn-select" style="width:10%;" name="in_color">
							<option value="Black" style="color: black;font-weight: bold;">Black</option>
							<option value="Blue" style="color: Blue;font-weight: bold;">Blue</option>
							<option value="Orange" style="color: Orange;font-weight: bold;">Orange</option>
							<option value="Green" style="color: Green;font-weight: bold;">Green</option>
							<option value="Brown" style="color: Brown;font-weight: bold;">Brown</option>
							<option value="Gray" style="color: Gray;font-weight: bold;">Slate (Gray)</option>
							<option value="White" style="color: #db9595;font-weight: bold;">White</option>
							<option value="Red" style="color: Red;font-weight: bold;">Red</option>
							<option value="Yellow" style="color: Yellow;font-weight: bold;">Yellow</option>
							<option value="Violet" style="color: Violet;font-weight: bold;">Violet</option>
							<option value="Pink" style="color: Pink;font-weight: bold;">Rose (Pink)</option>
							<option value="Aqua" style="color: Aqua;font-weight: bold;">Aqua</option>
						</select>
					</p>
					<p>
						<label style="font-weight: bold;">Source Core/Port No*</label>
						<span class="field"><input type="text" name="in_port" id="" style="width:5%;" required=""/></span>
					</p>
					<br/>
					<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 20px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);border-top: 1px solid rgba(0, 0, 0, 0.2);">Device Information</div>
					<br/>
						<p>
							<label style="font-weight: bold;">Device Name*</label>
							<span class="field"><input type="text" name="name" id="" style="width:29.5%;" placeholder="Name of the device" required=""/></span>
						</p>
						<p>
							<label style="font-weight: bold;">Device Type*</label>
							<select class="select-ext-large chzn-select" style="width:10%;" name="device_type" onChange="getRoutePoint1(this.value)">
								<option value="">Choose Type</option>
								<?php 	$emp_n="SELECT id, d_name, d_details FROM device WHERE sts = '0' ORDER BY id ASC";	$e_n_ro=mysql_query($emp_n); ?>
								<?php while ($e_n_r=mysql_fetch_array($e_n_ro)) { ?>
								<option value="<?php echo $e_n_r['id'];?>"> <?php echo $e_n_r['d_name'];?></option>
								<?php } ?>
							</select>
						</p>
						<p>
							<label style="font-weight: bold;">Total Port/Core*</label>
							<span class="field"><input type="text" name="out_port" id="" style="width:10%;" required="" placeholder="Port like 8, 16 etc" /></span>
						</p>
						<div id="Pointdiv1"></div>
						<p>
							<label>Fiber Code</label>
							<span class="field"><input type="text" name="fiber_code" id="" style="width:10%;"/></span>
						</p>
						<br/>
						<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #0866c6e0;font-size: 13px;padding: 5px 0px 4px 20px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);border-top: 1px solid rgba(0, 0, 0, 0.2);">Device Location</div>
					<br/>
					<?php if($tree_sts_permission == '0'){ ?>
						<p>
							<label></label>
							<span class="field" style="margin-left: 0;">
								<div class="input-append">
									<p id="latitude" style="margin: 1px 0;"></p>
									<p id="longitude" style="margin: 1px 0;"></p>
								</div>
								<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 15%;padding: 10px 15px;" title="Device Location"><i class='iconfa-map-marker' style="font-size: 35px;"></i></a>
							</span>
						</p>
					<?php } ?>
						<p>	
							<label style="font-weight: bold;">Zone*</label>
							<span class="field"><select class="select-ext-large chzn-select" style="width:25%;" name="z_id" required="" >
								<option value=""></option>
									<?php while ($roweee=mysql_fetch_array($result)) { ?>
								<option value="<?php echo $roweee['z_id'];?>"<?php if ($roweee['z_id'] == $parent_z_id) echo 'selected="selected"';?>><?php echo $roweee['z_name']; if($roweee['z_bn_name'] != ''){echo '('.$roweee['z_bn_name'].')';}?></option>
									<?php } ?>
							</select></span>
						</p>
						<p>
							<label>Location</label>
							<span class="field"><textarea type="text" name="location" style="width:30%;" id="" placeholder="Address" class="input-xxlarge" /></textarea></span>
						</p>
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="note" style="width:30%;" id="" placeholder="Device Note (If Any)" class="input-xxlarge" /></textarea></span>
						</p>
						<br/>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>	
			<?php } ?>
			</div>
		</div>
		<div class="box-body">
			<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con1" /> 
						<col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head1">Device ID</th>
                            <th class="head0">Name</th>
                            <th class="head1">Device Type</th>
                            <th class="head1">Source</th>
							<th class="head0">Input Port</th>
							<th class="head1">Total Port</th>
							<th class="head0">Zone</th>
                            <th class="head0">Location</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								if($parent_id != ''){
								$sql = mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.in_port, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, n.location, n.latitude, n.longitude, z.z_id, z.z_name FROM network_tree AS n 
												LEFT JOIN device AS d ON d.id = n.device_type
												LEFT JOIN zone AS z ON z.z_id = n.z_id
												WHERE n.sts = '0' AND n.device_sts = '0' AND n.parent_id = '$parent_id' ORDER BY n.tree_id DESC LIMIT 10");
								}
								else{
								$sql = mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.in_port, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, n.location, n.latitude, n.longitude, z.z_id, z.z_name FROM network_tree AS n 
												LEFT JOIN device AS d ON d.id = n.device_type
												LEFT JOIN zone AS z ON z.z_id = n.z_id
												WHERE n.sts = '0' AND n.device_sts = '0' ORDER BY n.tree_id DESC LIMIT 10");
								}
									while( $row = mysql_fetch_assoc($sql) )
									{
									if($row['latitude'] != '' && $row['longitude'] != ''){
									$glocation = $row['latitude'].','.$row['longitude'];
									}
									else{
										$glocation = '';
									}
										
									$queryiiiii = mysql_query("SELECT name AS sourcename FROM network_tree WHERE parent_id = '{$row['parent_id']}'");
									$rowiii = mysql_fetch_assoc($queryiiiii);
									$sourcename = $rowiii['sourcename'];
										echo
											"<tr class='gradeX'>
												<td>{$row['tree_id']}</td>
												<td>{$row['name']}</td>
												<td>{$row['d_name']}</td>
												<td>{$sourcename}</td>
												<td>{$row['in_port']}</td>
												<td>{$row['out_port']}</td>
												<td>{$row['z_name']}</td>
												<td>{$glocation}</td>
											</tr>\n ";
									}  
							?>
                    </tbody>
            </table>
		</div>
	</div>
	<?php
}
else{
	header("Location:/index");
}
include('include/footer.php');
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });

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
		var strURL="networktree_device_type.php?type="+afdId1;
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
		var strURL="networktree_device_ping_check.php?check_type="+afdId2;
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
<style>
#dyntable_length{display: none;}
#dyntable_filter{display: none;}
</style>
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
     console.log(event.latLng);   // Get latlong info as object.
     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
	 latitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map Latitude' readonly style='font-weight: bold;border-radius: 5px;' name='latitude' value='" + event.latLng.lat() + "'/>";
	 longitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map longitude' readonly style='font-weight: bold;border-radius: 5px;' name='longitude' value='" + event.latLng.lng() + "'/>";
 });
<?php 
$sql = mysql_query("SELECT * FROM network_tree WHERE tree_id != '0' AND latitude != '' AND sts = '0'");
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
$queryaa = mysql_query("SELECT t.tree_id, t.device_type, t.name, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0'")or die(mysql_error());
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&libraries&callback=myMap"></script>
<?php } else{ ?>
<script type="text/javascript">
function my_map_add() {
var myMapCenter = new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>);
var myMapProp = {center:myMapCenter, zoom:15, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("googleMap"),myMapProp);
var marker = new google.maps.Marker;
marker.setMap(map);

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
     console.log(event.latLng);   // Get latlong info as object.
     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
	 latitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map Latitude' readonly style='font-weight: bold;border-radius: 5px;' name='latitude' value='" + event.latLng.lat() + "'/>";
	 longitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map longitude' readonly style='font-weight: bold;border-radius: 5px;' name='longitude' value='" + event.latLng.lng() + "'/>";
 });
 <?php 
$sqls = mysql_query("SELECT t.tree_id FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id WHERE t.tree_id != '0' AND t.latitude != '' AND p.latitude != '' AND t.sts = '0' AND t.parent_id = '$parent_id'");

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

$olt_query2 = mysql_query("SELECT t.tree_id, t.device_type, t.name, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND t.tree_id = '$parent_id'");
$olt_row2 = mysql_fetch_assoc($olt_query2);
$olt_name = $olt_row2['name'].' ('.$olt_row2['d_name'].')';
$olt_device_type = $olt_row2['device_type'];
$olt_icon = $olt_row2['icon'];
$olt_lat = $olt_row2['t_latitude'];
$olt_lon = $olt_row2['t_longitude'];

	echo "appendMarkeree$olt_device_type(map, $olt_lat, $olt_lon, '$olt_name');
	function appendMarkeree$olt_device_type(map, latitude, longitude, text) {
		var pos = {lat: latitude, lng: longitude};
        var markerOption = {
          position: pos,
          map: map,
		  draggable: false,
		  animation: google.maps.Animation.BOUNCE,
		  icon: '$olt_icon',
          title: text || 'No Name'
        };
        return new google.maps.Marker(markerOption);}";

$queryaa = mysql_query("SELECT t.tree_id, t.device_type, t.name, t.parent_id, p.latitude AS p_latitude, p.longitude AS p_longitude, t.latitude AS t_latitude, t.longitude AS t_longitude, t.in_color, d.d_name, d.icon FROM network_tree AS t LEFT JOIN network_tree AS p ON p.tree_id = t.parent_id LEFT JOIN device AS d ON d.id = t.device_type WHERE t.latitude != '' AND t.longitude != '' AND t.sts = '0' AND p.latitude != '' AND p.longitude != '' AND t.parent_id = '$parent_id'")or die(mysql_error());
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&libraries&callback=my_map_add"></script>
<?php } ?>