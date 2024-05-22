<?php
include("conn/connection.php");
include('include/hader.php');

mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
date_default_timezone_set('Etc/GMT-6');
$delete_date_time = date('Y-m-d H:i:s', time());
$id = $_GET['id'];
extract($_POST); 

$que = mysql_query("SELECT log_sts FROM login WHERE e_id = '$id'");
$row = mysql_fetch_assoc($que);
$a = $row['log_sts'];
		if($a == '0')
		{	
			$query ="UPDATE login SET log_sts = '1' WHERE e_id = '$id'";		
		}
		else
		{
			$query ="UPDATE login SET log_sts = '0' WHERE e_id = '$id'";		
		}
$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<html>
	<body>
		<form action="Clients?id=all" method="post" name="ok">
			<input type="hidden" name="sts" value="Lock<?php echo $a; ?>">
		</form>
		<script language="javascript" type="text/javascript">
				document.ok.submit();
		</script>
	</body>
</html>