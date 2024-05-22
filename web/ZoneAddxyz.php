<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index?way=logout");
		exit();
	}
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

		$emp_idd = implode(',', $_POST['emp_id']);
		$p_idd = implode(',', $_POST['p_id']);
		$thanaa = implode(',', $_POST['thana']);
		if ($z_name != ''){
				$query2q ="insert into zone (z_name, z_bn_name, emp_id, p_id, thana) VALUES ('$z_name', '$z_bn_name', '$emp_idd', '$p_idd', '$thanaa')";
					if (!mysql_query($query2q))
					{
					die('Error: ' . mysql_error());
					}
			}
mysql_close($con);
?>

<html>
<body>
     <form action="Zone" method="post" name="ok">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>