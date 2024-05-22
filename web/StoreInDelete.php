<?php
include("conn/connection.php");
include('include/telegramapi.php');
extract($_POST);

if($store_type == 'fiber'){
$query1 = "DELETE FROM store_in_out_fiber WHERE id = '$id'";

	if (!mysql_query($query1))
		{
			die('Error: ' . mysql_error());
		}
	else{ ?>
		<html>
			<body>
			<form action="FiberStoreInDetails" method="post" name="ok">
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

$result1 = mysql_query("SELECT i.id, i.p_id, p.pro_name, i.inqty, IFNULL(o.qty, 0) AS outqty, (i.inqty - (IFNULL(o.qty, 0))) AS remainingqty from
						(SELECT id, SUM(quantity) AS inqty, p_id FROM store_in_instruments GROUP BY p_id) AS i
						LEFT JOIN
						(SELECT p_id, SUM(qty) AS qty  FROM store_out_instruments GROUP BY p_id) AS o
						ON i.p_id = o.p_id
						LEFT JOIN product AS p
						ON p.id = i.p_id
						WHERE i.p_id = '$p_id' GROUP BY i.p_id");
						
$row222 = mysql_fetch_assoc($result1);
$remainingqtyy = $row222['remainingqty'];

	if($wayyyy == 'withsl'){
		$query1h = "DELETE FROM store_instruments_sl WHERE in_id = '$in_id' AND p_id = '$p_id' AND sts = '0' AND out_sts = '0'";
		if (!mysql_query($query1h))
		{
			die('Error: ' . mysql_error());
		}
	}

if($quantity > $remainingqtyy){
	echo 'Sorry to say that you have only '.$remainingqtyy.' piece left. So not possible to delete '.$quantity.' pieces.';
}
else{
$resultret1 = mysql_query("SELECT e_name from emp_info WHERE e_id = '$e_id'");
						
$row222dd = mysql_fetch_assoc($resultret1);
$delete_e_name = $row222dd['e_name'];
	
	$sqlsdsgg = mysql_query("SELECT i.id, i.purchase_date, i.voucher_no, i.purchase_by, e.e_name AS purchaseby, i.vendor, v.v_name, i.p_sts, i.p_sl_no, i.p_id, p.pro_name, i.brand, i.quantity, i.price, i.rimarks, i.entry_by, a.e_name AS entryby, i.entry_time, i.sts FROM store_in_instruments AS i
													LEFT JOIN emp_info AS e
													ON e.e_id = i.purchase_by
													LEFT JOIN vendor AS v
													ON v.id = i.vendor
													LEFT JOIN product AS p
													ON p.id = i.p_id
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by
													WHERE i.id = '$id'");
$sw1ddd = mysql_fetch_assoc($sqlsdsgg);
$pro_name = $sw1ddd['pro_name'];
$brand11 = $sw1ddd['brand'];
$quantity = $sw1ddd['quantity'];
$priceee = $sw1ddd['price'];
$entryby = $sw1ddd['entryby'];
$v_namee = $sw1ddd['v_name'];
$voucher_no = $sw1ddd['voucher_no'];
$purchaseby = $sw1ddd['purchaseby'];
$p_sl_nooo = $sw1ddd['p_sl_no'];
$rimarkdds = $sw1ddd['rimarks'];
$purchase_byyy = $sw1ddd['purchase_by'];
	
		$query1 = "DELETE FROM store_in_instruments WHERE id = '$id'";

	if (!mysql_query($query1))
		{
			die('Error: ' . mysql_error());
		}
	else{ 
	
//TELEGRAM Start....
if($tele_sts == '0' && $tele_instruments_in_sts == '0'){
$telete_way = 'instruments_in';
$msg_body='..::[Instruments IN Delete]::..
'.$pro_name.' ['.$brand11.']

Voucher No: '.$voucher_no.'
Quantity: '.$quantity.' Pis
Price: '.$priceee.' TK
SL No: '.$p_sl_nooo.'
Vendor: '.$v_namee.'

Purchaser: '.$purchaseby.' ('.$purchase_byyy.')
Note: '.$rimarkdds.'

Delete By: '.$delete_e_name.' ('.$e_id.')
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//TELEGRAM END....	
	
	?>
		<html>
			<body>
			<form action="InstrumentsStoreInDetails" method="post" name="ok">
				<input type="hidden" name="sts" value="delete">
			</form>
			<script language="javascript" type="text/javascript">
				document.ok.submit();
			</script>
			</body>
		</html>
	<?php 
	}
//	}
//	else{
//		echo 'Sorry to say that, only ['.$entryby.'] can delete this product. Not possible by you.';
//	}
}
}
mysql_close($con);
?>