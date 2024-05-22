     <form action="live_location_save.php" method="post" name="ok">
       <p id="location"></p>
     </form>
	 
<?php
include("conn/connection.php");
extract($_POST);

$aaa = '{lat:'.$latitude.',lng:'.$longitude.'}';
$query2q ="insert into live_location (location) VALUES ('$aaa')";
					if (!mysql_query($query2q))
					{
					die('Error: ' . mysql_error());
					}
mysql_close($con);

echo "Done";
?>


<script language="javascript" type="text/javascript">
		document.ok.submit();

var x = document.getElementById("location");

function getLocation() {
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
} else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
}
}

function showPosition(position) {
x.innerHTML = "<?php $aaa = {lat:" + position.coords.latitude + ",lng:" + position.coords.longitude + "};?>";
}
window.onload=getLocation();
</script>