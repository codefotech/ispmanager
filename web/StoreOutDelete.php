<?php
include("conn/connection.php");
include('include/telegramapi.php');
extract($_POST);

if($store_type == 'fiber'){
	
	$result1 = mysql_query("SELECT s.id, p.pro_name, s.fiber_id, s.fibertotal, s.fibertotal_out, s.sts FROM store_in_out_fiber AS s
						LEFT JOIN fiber AS p ON p.id = s.p_id
						WHERE s.status = '0' AND s.id = '$st_id'");
	$row222 = mysql_fetch_assoc($result1);
	$ddd = $row222['fibertotal_out'] - $qty;
	
	if($row222['sts'] == '1'){
		$querydd="UPDATE store_in_out_fiber SET fibertotal_out = '$ddd', sts = '0' WHERE id = '$st_id'";
	}
	else{
		$querydd="UPDATE store_in_out_fiber SET fibertotal_out = '$ddd' WHERE id = '$st_id'";
	}
	$resultdd = mysql_query($querydd) or die("inser_query failed: " . mysql_error() . "<br />");
	
	
	$query1 = "DELETE FROM store_out_fiber WHERE id = '$id'";
	if (!mysql_query($query1))
		{
			die('Error: ' . mysql_error());
		}
	else{ ?>
		<html>
			<body>
			<form action="FiberStoreOutDetails" method="post" name="ok">
				<input type="hidden" name="sts" value="delete">
			</form>
			<script language="javascript" type="text/javascript">
				document.ok.submit();
			</script>
			</body>
		</html>
	<?php 
	}
}
if($store_type == 'instruments'){
	
$resultret1 = mysql_query("SELECT e_name from emp_info WHERE e_id = '$e_id'");
$row222dd = mysql_fetch_assoc($resultret1);
$delete_e_name = $row222dd['e_name'];

$sqlsdsgg = mysql_query("SELECT o.id, o.p_id, p.pro_name, o.p_sl_no, c.c_name, c.c_id, c.cell, o.qty, o.out_date, e.e_name AS out_by, k.e_name AS receive_by, o.note, DATE_FORMAT(o.out_date_time, '%D %M %Y %r') AS out_date_time FROM store_out_instruments AS o
													LEFT JOIN product AS p
													ON p.id = o.p_id
													LEFT JOIN emp_info AS e
													ON e.e_id = o.out_by
													LEFT JOIN emp_info AS k
													ON k.e_id = o.receive_by 
													LEFT JOIN clients AS c
													ON c.c_id = o.c_id
													WHERE o.id = '$id'");
$sw1ddd = mysql_fetch_assoc($sqlsdsgg);
$pro_name = $sw1ddd['pro_name'];
$qty = $sw1ddd['qty'];
$p_sl_no = $sw1ddd['p_sl_no'];
$note = $sw1ddd['note'];
$out_by = $sw1ddd['out_by'];
$c_name = $sw1ddd['c_name'];
$c_id = $sw1ddd['c_id'];
$cell = $sw1ddd['cell'];

if($p_sl_no != ''){
	$quersdgsdg="UPDATE store_instruments_sl SET out_sts = 'o' WHERE slno = '$p_sl_no'";
	$resultsdsdf = mysql_query($quersdgsdg) or die("inser_query failed: " . mysql_error() . "<br />");
}

$query1 = "DELETE FROM store_out_instruments WHERE id = '$id'";
	if (!mysql_query($query1))
		{
			die('Error: ' . mysql_error());
		}
	else{ 
	
//TELEGRAM Start....
if($tele_sts == '0' && $tele_instruments_out_sts == '0'){
$telete_way = 'instruments_out';
$msg_body='..::[Instruments OUT Delete]::..
Product: '.$pro_name.'

Client ID: '.$c_id.'
Name: '.$c_name.' ('.$cell.')
Quantity: '.$qty.' Pis
SL No: '.$p_sl_no.'

Note: '.$note.'

Delete By: '.$delete_e_name.' ('.$e_id.')
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//TELEGRAM END....

	?>
		<html>
			<body>
			<form action="InstrumentsStoreOutDetails" method="post" name="ok">
				<input type="hidden" name="sts" value="delete">
			</form>
			<script language="javascript" type="text/javascript">
				document.ok.submit();
			</script>
			</body>
		</html>
	<?php 
	}
}
mysql_close($con);
?>