<?php
include("conn/connection.php");
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

extract($_POST);
if($mk_profile != '' && $p_price != ''){
		$query ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id', '$mk_profile', '$p_name', '$p_price', '$bandwith', '$z_id', '$mk_id')";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<html>
<body>
<form action="Package" method="post" name="ok">
	<input type="hidden" name="sts" value="add">
</form>
<script language="javascript" type="text/javascript">
		document.ok.submit();
</script>
</body>
</html>
<?php } else{echo 'Wrong Data Inserted.';}?>