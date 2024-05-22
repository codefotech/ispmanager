<?php

session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
	else{
include("conn/connection.php");
extract($_POST);

if($polyline_latlon != ''){
$query2 = mysql_query("SELECT id FROM network_tree_polyline WHERE tree_id = '$tree_id'");
$row2ss = mysql_num_rows($query2);
if($row2ss > 0){
	$query11 ="UPDATE network_tree_polyline SET latlng = '$polyline_latlon', distance_km = '$distance_km', distance_miles = '$distance_miles' WHERE tree_id = '$tree_id'";
	$result11 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
}
else{
	$queryqq="INSERT INTO network_tree_polyline (tree_id, latlng, distance_km, distance_miles) VALUES ('$tree_id', '$polyline_latlon', '$distance_km', '$distance_miles')";
	$resultqq = mysql_query($queryqq) or die("inser_query failed: " . mysql_error() . "<br />");
}}

		$query ="UPDATE network_tree SET parent_id = '$parent_id', in_port='$in_port', in_color = '$in_color', out_port = '$out_port', fiber_code ='$fiber_code', z_id ='$z_id', box_id = '$box_id', device_type = '$device_type', name = '$name', ip = '$ip', ping = '$ping', mk_id = '$mk_id', latitude = '$latitude', longitude = '$longitude', location = '$location', g_location = '$g_location', note ='$note' WHERE tree_id = '$tree_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		

mysql_close($con);
?>
<html>
	<body> 
		<form action="NetworkTreeList" method="post" name="ok">
			<input type="hidden" name="sts" value="edit">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
<?php } ?>