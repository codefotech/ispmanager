<?php
include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$delete_date_time = date('Y-m-d H:i:s', time());
extract($_POST);

	if($exid != ''){
		$query ="UPDATE expanse SET status = '5', delete_date_time = '$delete_date_time', delete_by = '$delete_by' WHERE id = '$exid'";
		
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	}
		else{
				echo 'Error, Please try again';
			}
?>

<html>
<body>
     <form action="Expanse" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>