<?php 
session_start();
extract($_POST);
include("conn/connection.php");
include('include/telegramapi.php');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());
$current_time = date('H:i:s', time());
$current_date_time = date('Y-m-d H:i:s', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$eee_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

$auto_voucher_no  = $_POST['auto_voucher_no'];
$voucher_no  = $_POST['voucher_no'];
$itemNooo  = $_POST['itemNo'];
$productNameArray = $_POST['productName'];
$brandArray = $_POST['brand'];
$unitArray = $_POST['unit'];
$qtystsArray = $_POST['qtysts'];
$unitepriceArray = $_POST['uniteprice'];
$vatArray = $_POST['vat'];
$pstsArray = $_POST['psts'];
$quantityArray = $_POST['quantity'];
$priceArray = $_POST['price'];

$sqlqqmm = mysql_query("SELECT id FROM store_in_instruments WHERE slno = '$auto_voucher_no'");
$row22m = mysql_fetch_assoc($sqlqqmm);
$old_auto_voucher_no = $row22m['id'];

	if($old_auto_voucher_no == '' && $eee_id != ''){
		foreach( $itemNooo as $key => $productNo ){
			if($productNo != '' && $total_price > '0'){
					$itemNameValu = $productNameArray[$key];
					$brandValu = $brandArray[$key];
					$quantityValu = $quantityArray[$key];
					$qtystsValu = $qtystsArray[$key];
					$unitepriceArrayValu = $unitepriceArray[$key];
					$pstsValu = $pstsArray[$key];
					$priceValu = $priceArray[$key];
					$vatValu = $vatArray[$key];
					
				if($qtystsValu != '0'){
					foreach( $_POST['slno'][$productNo] as $slnofull){
						
							$query="insert into store_instruments_sl (p_id, slno, in_id) VALUES ('$productNo', '$slnofull', '$auto_voucher_no')";
							$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
						
					}
				}
			
			$resultdfg = mysql_query("SELECT GROUP_CONCAT(slno SEPARATOR ',') AS slno_all FROM store_instruments_sl WHERE in_id = '$auto_voucher_no' AND `p_id` = '$productNo'");
			$rowspy = mysql_fetch_array($resultdfg);
			$slno_all = $rowspy['slno_all'];
			
			$querymain="insert into store_in_instruments 
				(purchase_date, 
					voucher_no, 
						in_id, 
							purchase_by, 
								vendor, 
									p_sts, 
										p_id,
										p_sl_no,
											brand, 
												quantity,
													unite_price,
														vat,
														price, 
															entry_by, 
																entry_time, rimarks, v_sts, v_purpose, v_bill_type, v_amount, v_note, e_sts, e_type, e_bank, e_amount, e_status, e_note) 
																	VALUES ('$dateTimeee',
					'$voucher_no',
						'$auto_voucher_no',
							'$purchase_by',
								'$vendor',
									'$pstsValu',
										'$productNo',
										'$slno_all',
											'$brandValu',
												'$quantityValu',
													'$unitepriceArrayValu',
													'$vatValu',
														'$priceValu',
															'$eee_id',
																'$current_date_time', '$rimarks', '$v_sts', '$v_purpose', '$v_bill_type', '$v_amount', '$v_note', '$e_sts', '$e_type', '$e_bank', '$e_amount', '$e_status', '$e_note')";
																	
			$resultdd = mysql_query($querymain) or die("inser_query failed: " . mysql_error() . "<br />");
			}
		}
		
		
//Store In TELEGRAM Start....
if($tele_sts == '0' && $tele_instruments_in_sts == '0'){
$telete_way = 'instruments_in';
$sqlsdsgg = mysql_query("SELECT i.id, i.purchase_date, i.voucher_no, i.purchase_by, e.e_name AS purchaseby, i.vendor, v.v_name, i.p_sts, i.p_sl_no, i.p_id, p.pro_name, i.brand, i.quantity, i.price, i.rimarks, i.entry_by, a.e_name AS entryby, i.entry_time, i.sts FROM store_in_instruments AS i
													LEFT JOIN emp_info AS e
													ON e.e_id = i.purchase_by
													LEFT JOIN vendor AS v
													ON v.id = i.vendor
													LEFT JOIN product AS p
													ON p.id = i.p_id
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by
													WHERE i.in_id = '$auto_voucher_no' ORDER BY i.id DESC");
while( $sw1ddd = mysql_fetch_assoc($sqlsdsgg) )
{
$pro_name = $sw1ddd['pro_name'];
$brand11 = $sw1ddd['brand'];
$quantity = $sw1ddd['quantity'];
$priceee = $sw1ddd['price'];
$entryby = $sw1ddd['entryby'];
$v_namee = $sw1ddd['v_name'];
$voucher_no = $sw1ddd['voucher_no'];
$purchaseby = $sw1ddd['purchaseby'];
$p_sl_nooo = 'SL No: '.$sw1ddd['p_sl_no'];
$rimarkdds = $sw1ddd['rimarks'];
$purchase_byyy = $sw1ddd['purchase_by'];

$msg_body='..::[Store Instruments IN]::..
Voucher No: '.$voucher_no.'
Vendor: '.$v_namee.'

'.$pro_name.' ['.$brand11.']
Quantity: '.$quantity.' Pis
Price: '.$priceee.' TK
'.$p_sl_nooo.'


Purchaser: '.$purchaseby.' ('.$purchase_byyy.')
Note: '.$rimarkdds.'

By: '.$entryby.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
}
//TELEGRAM END....	

if($v_sts == 'Yes' && $v_amount > '0'){
$queryfbfsdg="INSERT INTO vendor_bill (bill_date, bill_time, v_id, purpose, amount, bill_type, note, ent_by) VALUES ('$dateTimeee', '$current_time', '$vendor', '$v_purpose', '$v_amount', '$v_bill_type', '$v_note', '$eee_id')";
$resultdd = mysql_query($queryfbfsdg) or die("inser_query failed: " . mysql_error() . "<br />");
}

if($e_sts == 'Yes' && $e_amount > '0' && $e_bank != ''){
if($user_type == 'superadmin' || $user_type == 'admin'){
	$querydhdh="insert into expanse (voucher, bank, ex_date, entry_by, type, amount, ex_by, enty_date, note, mathod, ck_trx_no, category, v_id, status, check_by, check_date)
			VALUES ('$voucher_no', '$e_bank', '$dateTimeee', '$eee_id', '$e_type', '$e_amount', '$purchase_by', '$current_date_time', '$e_note', '$e_mathod', '$ck_trx_no', '1', '$vendor', '2', '$eee_id', '$current_date_time')";
	
	$telestssss = 'Approved';
}
else{
	$querydhdh="insert into expanse (voucher, bank, ex_date, entry_by, type, amount, ex_by, enty_date, note, mathod, ck_trx_no, category, v_id)
		VALUES ('$voucher_no', '$e_bank', '$dateTimeee', '$eee_id', '$e_type', '$e_amount', '$purchase_by', '$current_date_time', '$e_note', '$e_mathod', '$ck_trx_no', '1', '$vendor')";
		
	$telestssss = 'Pending';
}
$resultsdd = mysql_query($querydhdh) or die("inser_query failed: " . mysql_error() . "<br />");

if($tele_sts == '0' && $tele_expense_sts == '0'){
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
		
$telete_way = 'expense_add';
$msg_body='..::[Expense Added]::..

Vendor Bill Pay
'.$v_name.'
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
} ?>
<html>
	<body>
		<form action="ProductInInstruments" method="post" name="ok">
			<input type="hidden" name="sts" value="product">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
<?php	}
	else{
		echo 'Something Wrong. Go back and try again.';
	}
}
else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php } ?>