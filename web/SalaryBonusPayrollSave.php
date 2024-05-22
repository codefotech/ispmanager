<?php
include("conn/connection.php") ;
extract($_POST);

	if(empty($_POST['e_id']) || empty($_POST['bonus_type']) || empty($_POST['bonus_date']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			$sql = mysql_query("SELECT salary, provident_fund FROM emp_info WHERE e_id = '$e_id'");
			$row = mysql_fetch_array($sql);
			$salary = $row['salary'];
			$provident_fund = $row['provident_fund'];
			
			$query="insert into employee_bonus (e_id, salary, bonus_type, bonus_date, note, ent_date, ent_by)
					VALUES ('$e_id', '$salary', '$bonus_type', '$bonus_date', '$note', '$ent_date', '$ent_by')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{
					header('Location: BonusPayroll');
				}
			else{
					echo 'Error, Please try again';
				}
		}
		
mysql_close($con);
?>