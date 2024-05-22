<?php
include("conn/connection.php");
include('include/telegramapi.php');
date_default_timezone_set('Etc/GMT-6');
$date_time = date('Y-m-d H:i:s', time());
$dateww = date('Y-m-d', time());
$checked_time = date('H:i:s', time());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

$exp_status = isset($_POST['approve']).isset($_POST['reject']);

if(isset($_POST['approve'])) {
	$queryyy = mysql_query("SELECT mathod FROM expanse WHERE id ='$ex_id'");
	$rowwe = mysql_fetch_assoc($queryyy);
	$mathod = $rowwe['mathod'];
	
	if($mathod == 'Bank'){
		$query1www = "update expanse set status = '2', check_note = '$check_note', check_by = '$check_by', check_date = '$date_time', ex_date = '$dateww' WHERE id = '$ex_id'";
			if (!mysql_query($query1www)){
				die('Error: ' . mysql_error());
			}
	}else{
		$query1www = "update expanse set status = '2', check_note = '$check_note', check_by = '$check_by', check_date = '$date_time' WHERE id = '$ex_id'";
			if (!mysql_query($query1www)){
				die('Error: ' . mysql_error());
			}
	}

//-----------------Telegram-------------------------------
$sqlmqq = mysql_query("SELECT e.id, b.sort_name, e.category, v_name, v.cell, g.e_name AS agent_name, g.e_cont_per AS agent_cell, e.mathod, j.e_name AS entrybyname, e.entry_by, b.id AS bank_id, e.check_by, z.dept_name AS ckdept_name, q.e_name AS checkby, DATE_FORMAT(e.check_date, '%D %M %Y %h:%i%p') AS check_date, e.check_note, b.bank_name, e.voucher, e.ex_date, a.e_name, a.e_id, e.ex_by, t.ex_type, d.dept_name, a.e_cont_per, e.amount, DATE_FORMAT(e.enty_date, '%D %b-%y %h:%i%p') AS enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN emp_info AS a	ON a.e_id = e.ex_by
													LEFT JOIN bank AS b	ON b.id = e.bank
													LEFT JOIN department_info AS d ON d.dept_id = a.dept_id 
													LEFT JOIN emp_info AS q	ON q.e_id = e.check_by
													LEFT JOIN emp_info AS j	ON j.e_id = e.entry_by
													LEFT JOIN department_info AS z ON z.dept_id = q.dept_id 
													LEFT JOIN vendor AS v ON v.id = e.v_id
													LEFT JOIN agent AS g ON g.e_id = e.agent_id
                                                    WHERE e.id = '$ex_id'");
						
		$rowmkqq = mysql_fetch_assoc($sqlmqq);
		$exbyname = $rowmkqq['e_name'];
		$exbyid = $rowmkqq['ex_by'];
		$purposee = $rowmkqq['ex_type'];
		$entydatetime = $rowmkqq['enty_date'];
		$examount = $rowmkqq['amount'];
		$mathodddd = $rowmkqq['mathod'];
		$noteeee = $rowmkqq['note'];
		$bankname = $rowmkqq['bank_name'];
		$bankid = $rowmkqq['bank_id'];
		$entrybyname = $rowmkqq['entrybyname'];
		$entrybyid = $rowmkqq['entry_by'];
		$checkbyname = $rowmkqq['checkby'];
		$checkbyid = $rowmkqq['check_by'];
		$checkdate = $rowmkqq['check_date'];
		$checknote = $rowmkqq['check_note'];
		$v_name = $rowmkqq['v_name'];
		$v_cell = $rowmkqq['cell'];
		$agent_name = $rowmkqq['agent_name'];
		$agent_cell = $rowmkqq['agent_cell'];
		$category = $rowmkqq['category'];
		
		if($category == '0'){
			$excategory = 'Office Expanse';
			$vendor = '';
		}
		elseif($category == '1'){
			$excategory = 'Vendor Bill Pay';
			$vendor = 'Vendor: '.$v_name.' ('.$v_cell.')';
		}
		if($category == '2'){
			$excategory = 'Agent Commission Pay';
			$vendor = 'Agent: '.$agent_name.' ('.$agent_cell.')';
		}
		if($category == '3'){
			$excategory = 'Investment Expense';
			$vendor = '';
		}

if($tele_sts == '0' && $tele_expense_sts == '0'){
$telete_way = 'expense_add';
$msg_body='..::[Expense Approved]::..

'.$excategory.'
'.$vendor.'
Expense Date: '.$entydatetime.'
Expense By: '.$exbyname.' ('.$exbyid.')
Purpose: '.$purposee.'
Bank: '.$bankname.' ('.$bankid.')
Amount: '.$examount.' TK
Mathod: '.$mathodddd.'
Entry By: '.$entrybyname.' ('.$entrybyid.')
Note: '.$noteeee.'

Status: Approved 
Approved By: '.$checkbyname.' ('.$checkbyid.')
Remarks: '.$checknote.'

At '.$checkdate.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//-----------------Telegram-------------------------------
?>
<html>
<body>
     <form action="Expanse" method="post" name="ok">
       <input type="hidden" name="sts" value="approve">
       <input type="hidden" name="ex_id" value="<?php echo $ex_id; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php 
$action_details = 'Expense Approved. Amount: '.$examount.' tk, Purpose: '.$purposee.', Mathod: '.$mathodddd.', Bank: '.$bankid.' For '.$excategory.'-'.$vendor;
$query222 = "INSERT INTO emp_log (e_id, module_name, titel, date, time, action, action_details) VALUES ('$check_by', 'Expense', 'Expense Checked', '$dateww', '$checked_time', 'Expense Checked', '$action_details')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}

}
if(isset($_POST['reject'])) {
	$query1wwwrrr = "update expanse set status = '1', check_note = '$check_note', check_by = '$check_by', check_date = '$date_time' WHERE id = '$ex_id '";
			if (!mysql_query($query1wwwrrr)){
				die('Error: ' . mysql_error());

				}
//-----------------Telegram-------------------------------
$sqlmqq = mysql_query("SELECT e.id, b.sort_name, e.category, v_name, v.cell, g.e_name AS agent_name, e.mathod, j.e_name AS entrybyname, e.entry_by, b.id AS bank_id, e.check_by, z.dept_name AS ckdept_name, q.e_name AS checkby, DATE_FORMAT(e.check_date, '%D %M %Y %h:%i%p') AS check_date, e.check_note, b.bank_name, e.voucher, e.ex_date, a.e_name, a.e_id, e.ex_by, t.ex_type, d.dept_name, a.e_cont_per, e.amount, DATE_FORMAT(e.enty_date, '%D %b-%y %h:%i%p') AS enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN emp_info AS a	ON a.e_id = e.ex_by
													LEFT JOIN bank AS b	ON b.id = e.bank
													LEFT JOIN department_info AS d ON d.dept_id = a.dept_id 
													LEFT JOIN emp_info AS q	ON q.e_id = e.check_by
													LEFT JOIN emp_info AS j	ON j.e_id = e.entry_by
													LEFT JOIN department_info AS z ON z.dept_id = q.dept_id 
													LEFT JOIN vendor AS v ON v.id = e.v_id
													LEFT JOIN agent AS g ON g.e_id = e.agent_id
                                                    WHERE e.id = '$ex_id'");
						
		$rowmkqq = mysql_fetch_assoc($sqlmqq);
		$exbyname = $rowmkqq['e_name'];
		$exbyid = $rowmkqq['ex_by'];
		$purposee = $rowmkqq['ex_type'];
		$entydatetime = $rowmkqq['enty_date'];
		$examount = $rowmkqq['amount'];
		$mathodddd = $rowmkqq['mathod'];
		$noteeee = $rowmkqq['note'];
		$bankname = $rowmkqq['bank_name'];
		$bankid = $rowmkqq['bank_id'];
		$entrybyname = $rowmkqq['entrybyname'];
		$entrybyid = $rowmkqq['entry_by'];
		$checkbyname = $rowmkqq['checkby'];
		$checkbyid = $rowmkqq['check_by'];
		$checkdate = $rowmkqq['check_date'];
		$checknote = $rowmkqq['check_note'];
		$v_name = $rowmkqq['v_name'];
		$v_cell = $rowmkqq['cell'];
		$agent_name = $rowmkqq['agent_name'];
		$agent_cell = $rowmkqq['agent_cell'];
		$category = $rowmkqq['category'];
		
		if($category == '0'){
			$excategory = 'Office Expanse';
			$vendor = '';
		}
		elseif($category == '1'){
			$excategory = 'Vendor Bill Pay';
			$vendor = 'Vendor: '.$v_name.' ('.$v_cell.')';
		}
		if($category == '2'){
			$excategory = 'Agent Commission Pay';
			$vendor = 'Agent: '.$agent_name.' ('.$agent_cell.')';
		}
		if($category == '3'){
			$excategory = 'Investment Expense';
			$vendor = '';
		}

if($tele_sts == '0' && $tele_expense_sts == '0'){
$telete_way = 'expense_add';
$msg_body='..::[Expense Rejected]::..

'.$excategory.'
'.$vendor.'
Expense Date: '.$entydatetime.'
Expense By: '.$exbyname.' ('.$exbyid.')
Purpose: '.$purposee.'
Bank: '.$bankname.' ('.$bankid.')
Amount: '.$examount.' TK
Mathod: '.$mathodddd.'
Entry By: '.$entrybyname.' ('.$entrybyid.')
Note: '.$noteeee.'

Status: Rejected 
Rejected By: '.$checkbyname.' ('.$checkbyid.')
Remarks: '.$checknote.'

At '.$checkdate.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//-----------------Telegram-------------------------------
?>
<html>
<body>
     <form action="Expanse" method="post" name="ok">
       <input type="hidden" name="sts" value="reject">
       <input type="hidden" name="ex_id" value="<?php echo $ex_id; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php 
$action_details = 'Expense Rejected. Amount: '.$examount.' tk, Purpose: '.$purposee.', Mathod: '.$mathodddd.', Bank: '.$bankid.' For '.$excategory.'-'.$vendor;
$query222 = "INSERT INTO emp_log (e_id, module_name, titel, date, time, action, action_details) VALUES ('$check_by', 'Expense', 'Expense Checked', '$dateww', '$checked_time', 'Expense Checked', '$action_details')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}

} ?>