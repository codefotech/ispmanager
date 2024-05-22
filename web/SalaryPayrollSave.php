<?php
include("conn/connection.php") ;
ini_alter('date.timezone','Asia/Almaty');
$ent_date = date('Y-m-d', time());
$ent_time = date('H:i:s', time());
extract($_POST);

$sql = mysql_query("SELECT id FROM emp_payroll WHERE e_id = '$e_id' AND MONTH(salary_date) = MONTH('$salary_date') AND YEAR(salary_date) = YEAR('$salary_date') AND sts = '0'");
			$check = mysql_num_rows($sql);
if($check > '0'){
	echo 'Payroll Already Created';
}
else{
	if(empty($_POST['e_id']) || empty($_POST['working_day']) || empty($_POST['salary_date']))
		{
			echo 'Please Complete All Filed';
		}
		else
		{
			$sql = mysql_query("SELECT basic_salary, mobile_bill, house_rent, medical, food, others, provident_fund, professional_tax, income_tax, gross_total FROM emp_info WHERE e_id = '$e_id'");
			$row = mysql_fetch_array($sql);
			$basic_salary = $row['basic_salary'];
			$mobile_bill = $row['mobile_bill'];
			$house_rent = $row['house_rent'];
			$medical = $row['medical'];
			$food = $row['food'];
			$others = $row['others'];
			$provident_fund = $row['provident_fund'];
			$professional_tax = $row['professional_tax'];
			$income_tax = $row['income_tax'];
			$gross_total = $row['gross_total'];
			if($gross_total <= '0'){
				echo 'You forget to setup employee salary. Please do it and try again.';
			}
		else{
			$query="insert into emp_payroll (e_id, basic_salary, mobile_bill, house_rent, medical, food, others, provident_fund, professional_tax, income_tax, gross_total, advance, cut_amount, working_day, other_bonus, salary_date, note, ent_date, ent_time, ent_by)
					VALUES ('$e_id', '$basic_salary', '$mobile_bill', '$house_rent', '$medical', '$food', '$others', '$provident_fund', '$professional_tax', '$income_tax', '$gross_total', '$advance', '$cut_amount', '$working_day', '$other_bonus', '$salary_date', '$note', '$ent_date', '$ent_time', '$ent_by')";

			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{?>
<html>
<body>
    <form action="SalaryPayroll" method="post" name="ok">
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
		}}
}
mysql_close($con);
?>