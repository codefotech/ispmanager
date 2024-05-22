<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

extract($_POST);

		$query ="update complain_subject set subject = '$subject' WHERE id = '$sid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
mysql_close($con);
?>

<html>
	<body> 
		<form action="SupportSubject" method="post" name="ok">
			<input type="hidden" name="sts" value="edit">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>