<?php
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

extract($_POST);

 if($way == 'macreseller'){

		$query222 ="update package set p_name = '$p_name', p_price_reseller = '$p_price_reseller' WHERE p_id = '$p_id'";
		$result55 = mysql_query($query222) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<html>	
	<body>		
		<form action="Package" method="post" name="ok">			
			<input type="hidden" name="sts" value="edit">		
		</form>		
		<script language="javascript" type="text/javascript">				
			document.ok.submit();		
		</script>	
	</body>
</html>
<?php } else{ if($p_price > '0'){

		$query ="update package set p_name = '$p_name', p_price = '$p_price', bandwith = '$bandwith', mk_profile = '$mk_profile', signup_sts = '$signup_sts', change_sts = '$change_sts', p_price_reseller = '$p_price_reseller', mk_id = '$mk_id' WHERE p_id = '$p_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<html>	
	<body>		
		<form action="Package" method="post" name="ok">			
			<input type="hidden" name="sts" value="edit">		
		</form>		
		<script language="javascript" type="text/javascript">				
			document.ok.submit();		
		</script>	
	</body>
</html>
<?php }
else{
	echo 'You are not able to set price 0.00 TK';
}

} ?>
