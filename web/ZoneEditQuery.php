<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index?way=logout");
		exit();
	}
extract($_POST);
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

	$emp_idd = implode(',', $_POST['emp_id']);
	$p_idd = implode(',', $_POST['p_id']);
	$thanaa = implode(',', $_POST['thana']);
		$query ="update zone set z_name = '$z_name', z_bn_name = '$z_bn_name', emp_id = '$emp_idd', p_id = '$p_idd', thana = '$thanaa', latitude = '$latitude', longitude = '$longitude' WHERE z_id = '$zone_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
mysql_close($con);
?>

<html>
	<body> 
		<form action="Zone" method="post" name="ok">
			<input type="hidden" name="sts" value="edit">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>