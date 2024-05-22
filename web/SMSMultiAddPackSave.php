<?php
session_start();
include("conn/connection.php");
include('include/smsapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

//** Zone Wise SMS to All Clients START **//
if($way == 'ZoneWiseSMS'){
	$sql = "SELECT id, c_id, c_name, cell FROM clients WHERE sts = '0'";  							
		if ($p_id != 'all'){
			$sql .= " AND p_id = '{$p_id}'";
		}
		if ($con_sts != 'all'){
			$sql .= " AND con_sts = '{$con_sts}'";
		}
	
	$result11 = mysql_query($sql);

	while( $row11 = mysql_fetch_assoc($result11) ){
	$from_page = 'Zone All Clients';
	$c_idd = $row11['c_id'];
	$cell = $row11['cell'];

	include('include/smsapicore.php');
	}
}
//** Zone Wise SMS to All Clients END **//
?>

<html>
<body>
     <form action="SMS" method="post" name="done">
       <input type="hidden" name="sts" value="smssent">
     </form>
     <script language="javascript" type="text/javascript">
		document.done.submit();
     </script>
     <noscript><input type="submit" value="done"></noscript>
</body>
</html>