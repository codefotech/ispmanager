<?php 
include("conn/connection.php");
ini_alter('date.timezone','Asia/Almaty');
$month = date('F, Y', strtotime('-1 month')); 
$lastmonth = date('Y-m-d', strtotime('-1 month'));
$e_id=$_GET['e_id'];

$vendorrr = mysql_query("SELECT SUM(amount) AS salary_advance FROM `expanse` WHERE `type` = '2' AND `status` = '2' AND ex_by = '$e_id' AND MONTH(`check_date`) = MONTH('$lastmonth') AND YEAR(`check_date`) = YEAR('$lastmonth') GROUP BY `ex_by`");
$rowtt = mysql_fetch_assoc($vendorrr);
$salary_advance= $rowtt['salary_advance'];

$empppp = mysql_query("SELECT gross_total AS gross_total FROM emp_info WHERE `e_id` = '$e_id' AND `status` = '0'");
$rowttdd = mysql_fetch_assoc($empppp);
$gross_total= $rowttdd['gross_total'];

if($salary_advance != ''){
?>
<p>
	<label>Gross Salary</label>
	<span class="field"><input type="text" value="<?php echo number_format($gross_total,2);?>" readonly id="" style="width:10%;" required="" placeholder=" Amount Of TK" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
</p>
<p>
	<label><?php echo $month;?> Salary Advance</label>
	<input type="hidden" name="advance" value="<?php echo $salary_advance;?>" id="" style="width:10%;" required="" placeholder=" Amount Of TK" />
	<span class="field"><input type="text" name="" value="<?php echo number_format($salary_advance,2);?>" readonly id="" style="width:10%;" required="" placeholder=" Amount Of TK" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
</p>
<?php } else{?>
<p>
	<label>Gross Salary</label>
	<span class="field"><input type="text" value="<?php echo number_format($gross_total,2);?>" readonly id="" style="width:10%;" required="" placeholder=" Amount Of TK" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
</p>
<p>
	<label><?php echo $month;?> Salary Advance</label>
	<span class="field"><input type="text" name="advance" value="0.00" id="" style="width:10%;" required="" readonly placeholder=" Amount Of TK" /><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 18px;" value='৳' readonly /></span>
</p>
<?php } ?>