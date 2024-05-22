<?php
include("conn/connection.php") ;
extract($_POST);

$query_date = $_POST['payment_date'];
$f_date = date('Y-m-01', strtotime($query_date));
$t_date = date('Y-m-t', strtotime($query_date));

	if(empty($_POST['payment_to']) || empty($_POST['bank']) || empty($_POST['amount']) || empty($_POST['payment_date']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			
			if($pf == 0){
				$query1="insert into emp_salary_payment (payment_to, pf, amount, bank, payment_date, note, ent_by)
					VALUES ('$payment_to', '$pf', '$amount', '$bank', '$payment_date', '$note', '$entry_by')";
			}else{
				$notes = 'For the month of '.$payment_date;
				$query="insert into emp_provident_fund (payment_to, amount, bank, payment_date, note, ent_by)
						VALUES ('$payment_to', '$pf', '121', '$payment_date', '$notes', '$entry_by')";
				$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
				
				$query1="insert into emp_salary_payment (payment_to, pf, amount, bank, payment_date, note, ent_by)
					VALUES ('$payment_to', '$pf', '$amount', '$bank', '$payment_date', '$note', '$entry_by')";
			}		
			
			$results = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");

			if($results)
				{
					header('Location: SalaryPayment');
				}
			else{
					echo 'Error, Please try again'; 
				}
				
		}
		
mysql_close($con);
?>