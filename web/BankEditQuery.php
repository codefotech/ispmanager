<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

extract($_POST);

		$query ="update bank set bank_name = '$bank_name', sort_name = '$sort_name' WHERE id = '$b_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
//		$queryd ="update payment_mathod set name = '$name', online = '$online' WHERE bank = '$b_id'";
//		$resultd = mysql_query($queryd) or die("inser_query failed: " . mysql_error() . "<br />");
		
$query2dd = "UPDATE payment_mathod SET sts = '1' WHERE bank = '$b_id'";
$resultff = mysql_query($query2dd) or die("inser_query failed: " . mysql_error() . "<br />");
foreach($_POST['mid'] as $count => $vlanNo){
	if($online[$count] == '1'){$dfhdfh = '1';} else{$dfhdfh = '0';}
	$Sqls = "INSERT INTO payment_mathod (name, bank, online) VALUES ('$methodname[$count]', '$b_id', '$dfhdfh')";
    $result = mysql_query($Sqls) or die("inser_query failed: " . mysql_error() . "<br />");
}
mysql_close($con);
?>
<html>
	<body> 
		<form action="Bank" method="post" name="ok">
			<input type="hidden" name="sts" value="edit">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>