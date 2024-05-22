<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

extract($_POST);
if(isset($_POST['voucher']) || isset($_POST['exp_by']) || isset($_POST['type']) || isset($_POST['bank']) || isset($_POST['amount'])){
		$query ="update expanse set voucher = '$voucher', ex_by = '$exp_by', v_id = '$v_id', mathod = '$mathod', ck_trx_no = '$ck_trx_no', type = '$type', bank = '$bank', amount = '$amount', note = '$note', edit_time = '$edit_time', edit_by = '$edit_by' WHERE id = '$exid'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
mysql_close($con);
?>
<html>
	<body> 
		<form action="Expanse" method="post" name="ok">
			<input type="hidden" name="sts" value="edit">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
<?php } else{ echo 'Wrong Entry!!!';} ?>