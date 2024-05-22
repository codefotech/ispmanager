<?php
include("conn/connection.php") ;
extract($_POST);

	if(empty($_POST['payment_date']) || empty($_POST['v_id']) || empty($_POST['bank']) || empty($_POST['amount']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
		if($amount > '0'){
			$query="insert into vendor_payment (payment_date, v_id, bank, amount, mathod, ck_trx_no, note, ent_by)
					VALUES ('$payment_date', '$v_id', '$bank', '$amount', '$mathod', '$ck_trx_no', '$note', '$ent_by')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{
?>
<html>	
	<body>		
		<form action="VendorPayment" method="post" name="ok">			
			<input type="hidden" name="sts" value="add">		
		</form>		
		<script language="javascript" type="text/javascript">				
			document.ok.submit();		
		</script>	
	</body>
</html>
<?php
				}
			else{
					echo 'Error, Please try again';
				}
		}
		else{
			echo 'Error!!, Not Possible to submit minus amount.';
		}
		}
mysql_close($con);
?>
