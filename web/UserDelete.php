<?php
include("conn/connection.php");
include('include/hader.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
date_default_timezone_set('Etc/GMT-6');
$delete_date_time = date('Y-m-d H:i:s', time());
$id = $_GET['id'];

	if($id != ''){
		$query ="UPDATE login SET status = '1', log_sts = '1', delete_date_time = '$delete_date_time', delete_by = '$e_id' WHERE id = '$id'";
		
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
		else{
				echo 'Error, Please try again';
			}
?>

<html>
<body>
     <form action="Users" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>