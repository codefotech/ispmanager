<?php
include("conn/connection.php") ;
extract($_POST);

	if(empty($_POST['ids']) || empty($_POST['working_day']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			
			$query="UPDATE employee_payroll SET advance = '$advance', working_day = '$working_day', other_tips = '$other_tips', salary_date = '$salary_date', note = '$note' WHERE id = '$ids'";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{
					header('Location: EmployeePayroll');
				}
			else{
					echo 'Error, Please try again';
				}
		}
		
mysql_close($con);
?>