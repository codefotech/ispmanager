<?php
include("conn/connection.php") ;
extract($_POST);

	if(empty($_POST['bill_date']) || empty($_POST['v_id']) || empty($_POST['amount']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
		if($amount > '0'){
			$query="INSERT INTO vendor_bill (bill_date, bill_time, v_id, purpose, amount, bill_type, note, ent_by)
					VALUES ('$bill_date', '$bill_time', '$v_id', '$purpose', '$amount', '$bill_type', '$note', '$ent_by')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{
?>
<html>	
	<body>		
		<form action="VendorBill" method="post" name="ok">			
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
