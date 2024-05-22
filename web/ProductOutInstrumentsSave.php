<?php
include("conn/connection.php");
include('include/telegramapi.php');
extract($_POST);

$result1 = mysql_query("SELECT i.id, i.p_id, p.pro_name, i.inqty, IFNULL(o.qty, 0) AS outqty, (i.inqty - (IFNULL(o.qty, 0))) AS remainingqty from
						(SELECT id, SUM(quantity) AS inqty, p_id FROM store_in_instruments GROUP BY p_id) AS i
						LEFT JOIN
						(SELECT p_id, SUM(qty) AS qty  FROM store_out_instruments GROUP BY p_id) AS o
						ON i.p_id = o.p_id
						LEFT JOIN product AS p
						ON p.id = i.p_id
						WHERE i.p_id = '$p_id'
						GROUP BY i.p_id ORDER BY p.pro_name");
						
$row222 = mysql_fetch_assoc($result1);
$remainingqtyy = $row222['remainingqty'];

if($remainingqtyy >= $qty && $qty != '0')
{
	$query1 = "INSERT INTO store_out_instruments (p_id, p_sl_no, qty, out_date, out_by, out_date_time, receive_by, c_id, note) VALUES ('$p_id', '$p_sl_no', '$qty', '$out_date', '$out_by', '$out_date_time', '$receive_by', '$c_id', '$rmk')";
	$sql1 = mysql_query($query1);
	
if($p_sl_no != ''){
	$quersdgsdg="UPDATE store_instruments_sl SET out_sts = '1' WHERE slno = '$p_sl_no'";
	$resultsdsdf = mysql_query($quersdgsdg) or die("inser_query failed: " . mysql_error() . "<br />");
}
	
//TELEGRAM Start....
$sqlsdsgg = mysql_query("SELECT o.id, o.p_id, p.pro_name, o.p_sl_no, c.c_name, c.c_id, c.cell, o.qty, o.out_date, e.e_name AS out_by, k.e_name AS receive_by, o.note, DATE_FORMAT(o.out_date_time, '%D %M %Y %r') AS out_date_time FROM store_out_instruments AS o
													LEFT JOIN product AS p
													ON p.id = o.p_id
													LEFT JOIN emp_info AS e
													ON e.e_id = o.out_by
													LEFT JOIN emp_info AS k
													ON k.e_id = o.receive_by 
													LEFT JOIN clients AS c
													ON c.c_id = o.c_id
													WHERE o.status = '0'
													ORDER BY o.id DESC LIMIT 1");
$sw1ddd = mysql_fetch_assoc($sqlsdsgg);
$pro_name = $sw1ddd['pro_name'];
$qty = $sw1ddd['qty'];
$p_sl_no = $sw1ddd['p_sl_no'];
$note = $sw1ddd['note'];
$out_by = $sw1ddd['out_by'];
$c_name = $sw1ddd['c_name'];
$c_id = $sw1ddd['c_id'];
$cell = $sw1ddd['cell'];

if($tele_sts == '0' && $tele_instruments_out_sts == '0'){
$telete_way = 'instruments_out';
$msg_body='..::[Store Instruments OUT]::..
Product: '.$pro_name.'

Client ID: '.$c_id.'
Name: '.$c_name.' ('.$cell.')
Quantity: '.$qty.' Pis
SL No: '.$p_sl_no.'

Note: '.$note.'

Out By: '.$out_by.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//TELEGRAM END....
?>
<html>
<body>
     <form action="ProductOutInstruments" method="post" name="main">
		<input type="hidden" name="sts" value="Out_Instruments">
     </form>     
	 <script language="javascript" type="text/javascript">
		document.main.submit();     
	 </script>
</body>
</html>
<?php	
}
else{
	echo 'Not enough stock';
}
?>

