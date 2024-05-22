<?php
include("conn/connection.php") ;
extract($_POST);

		if(empty($_POST['loan_payment_to']) || empty($_POST['bank']) || empty($_POST['amount']) || empty($_POST['payment_date']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			$query="insert into loan_payment (loan_payment_to, amount, bank, payment_date, note, ent_by)
					VALUES ('$loan_payment_to', '$amount', '$bank', '$payment_date', '$note', '$entry_by')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{
					header('Location: LoanPaymentAdd');
				}
			else{
					echo 'Error, Please try again';
				}
		}

mysql_close($con);
?>