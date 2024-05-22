<?php
include("conn/connection.php") ;
extract($_POST);

	$query = "UPDATE bill_signup SET bank = '$bank', bill_type = '$bill_type', amount = '$amount', bill_dsc = '$bill_dsc' WHERE id = '$id';";
	$sql = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	
	if ($sql)
	{
		header("location: SignupBill");
	}
else
	{
		echo 'Error, Please try again';
	}
	
mysql_close($con);
?>

