<?php
include("conn/connection.php") ;
extract($_POST);

		if(empty($_POST['loan_from']) || empty($_POST['bank']) || empty($_POST['amount']) || empty($_POST['loan_date']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			$query="insert into loan_receive (loan_from, amount, bank, loan_date, note, ent_by)
					VALUES ('$loan_from', '$amount', '$bank', '$loan_date', '$note', '$entry_by')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{
					header('Location: LoanReceiveAdd');
				}
			else{
					echo 'Error, Please try again';
				}
		}

mysql_close($con);
?>