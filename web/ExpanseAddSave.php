<?php
session_start();
include("conn/connection.php") ;
include('include/telegramapi.php');
date_default_timezone_set('Etc/GMT-6');
$datetime = date('Y-m-d H:i:s', time());
$update_time = date('H:i:s', time());
$user_type = $_SESSION['SESS_USER_TYPE'];
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

$sql2 ="SELECT id FROM expanse ORDER BY id DESC LIMIT 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$idz = $row2['id'];

if($old_voucher == $idz){
	if(empty($_POST['type']) || empty($_POST['amount']) || empty($_POST['ex_date'])) 
		{
			echo 'Please Complete All Filed';
		}
		else

		{
			if($user_type == 'superadmin' || $user_type == 'admin'){
			$query="insert into expanse (voucher, bank, ex_date, entry_by, type, amount, ex_by, enty_date, note, mathod, ck_trx_no, category, v_id, agent_id, status, check_by, check_date)
					VALUES ('$voucher', '$bank', '$ex_date', '$entry_by', '$type', '$amount', '$exp_by', '$enty_date', '$note', '$mathod', '$ck_trx_no', '$category', '$v_id', '$agent_id', '2', '$entry_by', '$datetime')";
			
			$telestssss = 'Approved';
			}
			else{
			$query="insert into expanse (voucher, bank, ex_date, entry_by, type, amount, ex_by, enty_date, note, mathod, ck_trx_no, category, v_id, agent_id)
					VALUES ('$voucher', '$bank', '$ex_date', '$entry_by', '$type', '$amount', '$exp_by', '$enty_date', '$note', '$mathod', '$ck_trx_no', '$category', '$v_id', '$agent_id')";
					
			$telestssss = 'Pending';
			}
			$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

			if ($result)
				{

//-----------------Telegram-------------------------------
$sqlmqq = mysql_query("SELECT e.id, b.sort_name, e.category, x.e_name AS agent_name, x.e_cont_per AS agent_cell, v.v_name, v.cell, e.mathod, j.e_name AS entrybyname, e.entry_by, b.id AS bank_id, e.check_by, z.dept_name AS ckdept_name, q.e_name AS checkby, DATE_FORMAT(e.check_date, '%D %M %Y %h:%i%p') AS check_date, e.check_note, b.bank_name, e.voucher, e.ex_date, a.e_name, a.e_id, e.ex_by, t.ex_type, d.dept_name, a.e_cont_per, e.amount, DATE_FORMAT(e.enty_date, '%D %b-%y %h:%i%p') AS enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN emp_info AS a	ON a.e_id = e.ex_by
													LEFT JOIN bank AS b	ON b.id = e.bank
													LEFT JOIN department_info AS d ON d.dept_id = a.dept_id 
													LEFT JOIN emp_info AS q	ON q.e_id = e.check_by
													LEFT JOIN emp_info AS j	ON j.e_id = e.entry_by
													LEFT JOIN department_info AS z ON z.dept_id = q.dept_id 
													LEFT JOIN vendor AS v ON v.id = e.v_id
													LEFT JOIN agent AS x ON x.e_id = e.agent_id
													ORDER BY e.id DESC LIMIT 1");
						
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
		$v_name = $rowmkqq['v_name'];
		$v_cell = $rowmkqq['cell'];
		$agent_name = $rowmkqq['agent_name'];
		$agent_cell = $rowmkqq['agent_cell'];
		
		if($rowmkqq['category'] == '0'){
			$excategory = 'Office Expanse';
			$vendor = '';
		}
		if($rowmkqq['category'] =='1'){
			$excategory = 'Vendor Bill Pay';
			$vendor = 'Vendor: '.$v_name.' ('.$v_cell.')';
		}
		if($rowmkqq['category'] == '2'){
			$excategory = 'Agent Commission Pay';
			$vendor = 'Vendor: '.$agent_name.' ('.$agent_cell.')';
		}
		if($rowmkqq['category'] == '3'){
			$excategory = 'Investment Expense';
			$vendor = '';
		}

if($tele_sts == '0' && $tele_expense_sts == '0'){
$telete_way = 'expense_add';
$msg_body='..::[Expense Added]::..

'.$excategory.'
'.$vendor.'
Expense By: '.$exbyname.' ('.$exbyid.')
Purpose: '.$purposee.'
Bank: '.$bankname.' ('.$bankid.')
Amount: '.$examount.' TK
Mathod: '.$mathodddd.'
Note: '.$noteeee.'
Entry By: '.$entrybyname.' ('.$entrybyid.')

Status: '.$telestssss.'

At '.$entydatetime.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}

$action_details = 'Expense Add: '.$examount.' tk, Purpose: '.$purposee.', Mathod: '.$mathodddd.', Bank: '.$bankid.' For '.$excategory.'-'.$vendor.' ['.$telestssss.']';
$query222 = "INSERT INTO emp_log (e_id, module_name, titel, date, time, action, action_details) VALUES ('$entry_by', 'Expense', 'Expense Add', '$enty_date', '$update_time', 'Add Expense', '$action_details')";
					if (!mysql_query($query222))
							{
							die('Error: ' . mysql_error());
							}
//-----------------Telegram-------------------------------
					?>
<html>
<body>
     <form action="Expanse" method="post" name="ok">
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
		}


}
else{ ?>
<html>
<body>
     <form action="Expanse" method="post" name="ok">
       <input type="hidden" name="sts" value="error">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php }
mysql_close($con);

?>