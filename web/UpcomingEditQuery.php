<?php
include("conn/connection.php") ;
extract($_POST);
$addr = mysql_real_escape_string($address);
if ($current_status == 'Done'){
	$st = '1';
}
else{
	$st = '0';
	
}
if($id != ''){
		$query="UPDATE upcoming SET
		z_id = '$z_id',
		address = '$addr',
		cell = '$cell',
		p_id = '$p_id',
		otc = '$otc',
		setup_date = '$setup_date',
		previous_isp = '$previous_isp',
		note = '$note',
		current_status = '$current_status',
		line_up_date = '$line_up_date',
		sts = '$st',
		update_by = '$update_by'
		WHERE id = '$id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
}
		else{
				echo 'Error, Please try again';
			}
?>

<html>
<body>
     <form action="Upcoming" method="post" name="done">
       <input type="hidden" name="stat" value="done">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>