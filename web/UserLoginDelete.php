<?php
include("conn/connection.php");
include('include/hader.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
date_default_timezone_set('Etc/GMT-6');
$delete_date_time = date('Y-m-d H:i:s', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'UserLoginReport' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

		$query ="UPDATE log_info SET status = '1', delete_date_time = '$delete_date_time', delete_by = '$e_id' WHERE delete_by = ''";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

?>

<html>
<body>
     <form action="UserLoginReport" method="post" name="ok">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>

<?php
}
else{
	echo 'Sorry Dear, You Have not Permission';
}
include('include/footer.php');
?>