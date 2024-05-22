<?php
include("conn/connection.php") ;
extract($_POST);
$addr = mysql_real_escape_string($address);

$rcv_date_time = date("Y-m-d h:i:s");

		$sql = ("SELECT schedule_id FROM Upcoming ORDER BY schedule_id DESC LIMIT 1");
		$query2 = mysql_query($sql);
		$row = mysql_fetch_assoc($query2);
			$old_id = $row['schedule_id'];
			$new_id = $old_id + 1;


		if($new_id != ''){
			$query = "insert into upcoming (schedule_id, rcv_by, rcv_date_time, z_id, c_name, address, cell, p_id, otc, setup_date, previous_isp, note )
					  VALUES ('$new_id', '$rcv_by', '$rcv_date_time', '$z_id', '$c_name', '$addr', '$cell', '$p_id', '$otc', '$setup_date', '$previous_isp', '$note')";
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		else{
			echo 'Invilade Id';
		}	

?>

<html>
<body>
     <form action="UpcomingAdd" method="post" name="done">
       <input type="hidden" name="stat" value="done">
     </form>

     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>
