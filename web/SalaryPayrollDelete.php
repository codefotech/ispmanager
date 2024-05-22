<?php
include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$delete_date = date('Y-m-d', time());
$delete_time = date('H:i:s', time());
extract($_POST); 


if($delete_by != ''){
$query = "UPDATE emp_payroll SET sts = '1', delete_by = '$delete_by', delete_date = '$delete_date', delete_time = '$delete_time' WHERE id = '$payrollid'";
if(!mysql_query($query)){die('Error: ' . mysql_error());}
?>

<html>
<body>
<form action="SalaryPayroll" method="post" name="ok">
	<input type="hidden" name="sts" value="delete">
	<input type="hidden" name="salary_date" value="<?php echo $salary_date;?>">
</form>
<script language="javascript" type="text/javascript">
		document.ok.submit();
</script>
</body>
</html>

<?php } else{echo 'Sorry!! Not possible to delete.';}?>


