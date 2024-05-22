<?php
include("conn/connection.php") ;
extract($_POST);

	if(empty($_POST['loan_name']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			$query="insert into loan_from (name, address, cell) VALUES ('$loan_name','$address','$cell')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result){
					header('Location: LoanReceiveAdd');
				}
			else{
					echo 'Error, Please try again';
				}
		}

mysql_close($con);
?>
