<?php
include("conn/connection.php") ;
extract($_POST);
	if(empty($_POST['name']) || empty($_POST['device_type']) || empty($_POST['in_color']) || empty($_POST['in_port']) || empty($_POST['out_port']) || empty($_POST['z_id'])) 
		{
			echo 'Please Complete All Filed';
		}
		else

		{
			$query="INSERT INTO network_tree (tree_id, parent_id, in_port, in_color, out_port, fiber_code, z_id, latitude, longitude, device_type, name, ip, ping, mk_id, location, note, entry_by, entry_time)
					VALUES ('$tree_id', '$parent_id', '$in_port', '$in_color', '$out_port', '$fiber_code', '$z_id', '$latitude', '$longitude', '$device_type', '$name', '$ip', '$ping', '$mk_id', '$location', '$note', '$entry_by', '$enty_date')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{
					?>
<html>
<body>
     <form action="NetworkTree" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php
				}
			else{
					echo 'Error, Please try again';
				}
		}



mysql_close($con);

?>