<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
include("conn/connection.php");
include('include/telegramapi.php');
$typ = isset($_GET['typ']) ? $_GET['typ'] : '';
$search_way = isset($_GET['way']) ? $_GET['way'] : '';
$eeeeid = isset($_GET['eid']) ? $_GET['eid'] : '';
extract($_POST);

if ($typ == 'vendor'){
		$query="insert into vendor (v_name, cell, email, location, join_date, entry_by, enty_time) VALUES ('$v_name', '$cell', '$email', '$location', '$join_date', '$entry_by', '$enty_time')";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>


<html>
<body>
     <form action="ProductInInstruments" method="post" name="vendor">
       <input type="hidden" name="sts" value="vendor">
     </form>

     <script language="javascript" type="text/javascript">
		document.vendor.submit();
     </script>
</body>
</html>

<?php } if($typee == 'load_mini'){
if($loadsts == 'yes'){
	$query55 ="update app_config set minimize_load = '1' WHERE tis_id = '$tis_id'";
	$result55 = mysql_query($query55) or die("inser_query failed: " . mysql_error() . "<br />");
}
else{
	$query55 ="update app_config set minimize_load = '0' WHERE tis_id = '$tis_id'";
	$result55 = mysql_query($query55) or die("inser_query failed: " . mysql_error() . "<br />");
}
?>


<html>
<body>
     <form action="Clients?id=all" method="post" name="loadmin">
       <input type="hidden" name="sts" value="<?php echo $loadsts;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.loadmin.submit();
     </script>
</body>
</html>

<?php } if($typee == 'vendor'){
		$query="insert into vendor (v_name, cell, email, location, join_date, entry_by, enty_time) VALUES ('$v_name', '$cell', '$email', '$location', '$join_date', '$entry_by', '$enty_time')";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>


<html>
<body>
     <form action="VendorBill" method="post" name="vendor">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.vendor.submit();
     </script>
</body>
</html>

<?php } if($typee == 'vendoredit'){
		$query="UPDATE vendor SET v_name = '$v_name', cell = '$cell', email = '$email', location = '$location' WHERE id = '$iddd' ";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>


<html>
<body>
     <form action="VendorBill?VendorsInfo=all" method="post" name="vendor">
       <input type="hidden" name="sts" value="editinfo">
     </form>

     <script language="javascript" type="text/javascript">
		document.vendor.submit();
     </script>
</body>
</html>

<?php } if($typ == 'changenetwork'){
	
	$query="UPDATE clients SET mk_id = '$mk_id' WHERE z_id = '$z_id'";
	$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
	
	$queryggg="UPDATE emp_info SET mk_id = '$mk_id' WHERE z_id = '$z_id'";
	$resultsgs = mysql_query($queryggg) or die("inser_query failed: " . mysql_error() . "<br />");
	
	$querygggp="UPDATE package SET mk_id = '$mk_id' WHERE z_id = '$z_id'";
	$resultsgsp = mysql_query($querygggp) or die("inser_query failed: " . mysql_error() . "<br />");
?>


<html>
<body>
     <form action="MacReseller" method="post" name="vendor">
       <input type="hidden" name="sts" value="changenetwork">
     </form>

     <script language="javascript" type="text/javascript">
		document.vendor.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'product'){
		$query="insert into product (pro_name, pro_details, unit, vat, sl_sts) VALUES ('$pro_name', '$pro_details', '$unit', '$vat', '$sl_sts')";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="<?php if($backto == 'products'){?>Products<?php } else{ ?>ProductInInstruments<?php } ?>" method="post" name="product">
       <input type="hidden" name="sts" value="product">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'UserType' && $u_type != 'superadmin'){
$utype = str_replace(" ", "_", $u_type);
$sqlmk = mysql_query("SELECT type_id FROM user_typ WHERE sts = '0' ORDER BY type_id DESC LIMIT 1");
$rowmk = mysql_fetch_assoc($sqlmk);
								
$type_iddd = $rowmk['type_id']+1;
	
		$queryfsds="insert into user_typ (type_id, u_type, u_des) VALUES ('$type_iddd', '$utype', '$utype')";
		$resulthfgjh = mysql_query($queryfsds) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$queryfsds1="ALTER TABLE module ADD $utype int(2) NOT NULL AFTER agent";
		$resulthfgjh1 = mysql_query($queryfsds1) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$queryfsds2="ALTER TABLE module_page ADD $utype int(2) NOT NULL AFTER agent";
		$resulthfgjh2 = mysql_query($queryfsds2) or die("inser_query failed: " . mysql_error() . "<br />");

?>

<html>
<body>
     <form action="<?php if($backto == 'UserType'){?>UserType<?php } else{ ?>UserType<?php } ?>" method="post" name="UserType">
       <input type="hidden" name="sts" value="UserType">
     </form>

     <script language="javascript" type="text/javascript">
		document.UserType.submit();
     </script>
</body>
</html>

<?php } if($typ == 'UserTypeEdit' && $u_type != 'superadmin'){
		$utype = str_replace(" ", "_", $u_type);
		$queryaaa="UPDATE user_typ SET u_type = '$u_type', u_des = '$utype' WHERE id = '$idaa'";
		$resultss = mysql_query($queryaaa) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$queryfsds2f="ALTER TABLE module_page CHANGE $old_u_type $utype INT(11) NOT NULL";
		$resulthfgjh2f = mysql_query($queryfsds2f) or die("inser_query failed: " . mysql_error() . "<br />");
		
		$queryfsds2s="ALTER TABLE module CHANGE $old_u_type $utype INT(11) NOT NULL";
		$resulthfgjh2s = mysql_query($queryfsds2s) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="UserType" method="post" name="UserType">
       <input type="hidden" name="sts" value="edit">
     </form>

     <script language="javascript" type="text/javascript">
		document.UserType.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'productedit'){
		$query="UPDATE product SET pro_name = '$pro_name', pro_details = '$pro_details', unit = '$unit', vat = '$vat', sl_sts = '$sl_sts' WHERE id = '$p_id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="Products" method="post" name="product">
       <input type="hidden" name="sts" value="edit">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'prodectdelete'){
		$query="UPDATE product SET sts = '1', delete_by = '$e_id' WHERE id = '$p_id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="Products" method="post" name="product">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'fiber'){
		$query="insert into fiber (pro_name, pro_details) VALUES ('$pro_name', '$pro_details')";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="<?php if($backto == 'fibers'){?>Fibers<?php } else{ ?>ProductInFiber<?php } ?>" method="post" name="product">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'fiberedit'){
		$query="UPDATE fiber SET pro_name = '$pro_name', pro_details = '$pro_details' WHERE id = '$p_id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="Fibers" method="post" name="product">
       <input type="hidden" name="sts" value="edit">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'fiberdelete'){
		$query="UPDATE fiber SET sts = '1', delete_by = '$e_id' WHERE id = '$p_id'";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="Fibers" method="post" name="product">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if($typ == 'tab'){
		$query11="INSERT INTO app_search (e_id, active_tab) VALUES ('$eeeeid', '$search_way')";
		$result22 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
		header("location: welcome");
		exit();
 } if($typ == 'search'){
		$query11="INSERT INTO app_search (e_id, last_search) VALUES ('$eeeeid', '$search_way')";
		$result22 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
		header("location: welcome");
		exit();
 } if ($typ == 'SupportSubject'){
		$query="insert into complain_subject (subject) VALUES ('$subject')";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<html>
<body>
     <form action="SupportSubject" method="post" name="dfgdfg">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.dfgdfg.submit();
     </script>
</body>
</html>
<?php } if ($typ == 'BoxAdd'){
		$query="insert into box (b_name, location, b_port, onu, z_id) VALUES ('$b_name', '$location', '$b_port', '$onu', '$z_id')";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<html>
<body>
     <form action="<?php if($way == 'reseller'){ echo 'Zone';} else{ echo 'Box';}?>" method="post" name="product">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>
<?php } if($typ == 'InvoiceAdd'){
		$query="INSERT INTO invoice_item (i_name, i_des, i_unit, vat, use_sts) VALUES ('$i_name', '$i_des', '$i_unit', '$vat', '$use_sts')";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
<html>
<body>
     <form action="InvoiceItem" method="post" name="product">
       <input type="hidden" name="sts" value="add">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if($typ == 'InvoiceEdit'){
		$query="UPDATE invoice_item SET i_name = '$i_name', i_des = '$i_des', i_unit = '$i_unit', use_sts = '$use_sts' WHERE id = '$invoice_id' AND sts = '0'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="InvoiceItem" method="post" name="product">
       <input type="hidden" name="sts" value="edit">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if($typ == 'InvoiceDelete'){
		$query="UPDATE invoice_item SET sts = '1' WHERE id = '$invoice_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>

<html>
<body>
     <form action="InvoiceItem" method="post" name="product">
       <input type="hidden" name="sts" value="delete">
     </form>

     <script language="javascript" type="text/javascript">
		document.product.submit();
     </script>
</body>
</html>

<?php } if ($typ == 'fiberin'){
	
	if(empty($_POST['voucher_no'])) { } else	{
		$query="insert into store_in_out_fiber 
		(purchase_date, 
			voucher_no, 
				purchase_by, 
					vendor, 
						p_sts, 
							p_sl_no, 
								p_id, 
									brand, 
										fiber_id, 
											fiberstart, 
												fiberend, 
													fibertotal, 
														quantity, 
															unite_price,
																price, 
																	rimarks, 
																		entry_by, 
																			entry_time) 
																				VALUES ('$purchase_date',
																		'$voucher_no',
																	'$purchase_by',
																'$vendor',
															'$p_sts',
														'$p_sl_no',
													'$p_id',
												'$brand',
											'$fiber_id',
										'$fiberstart',
									'$fiberend',
								'$fibertotal',
							'$quantity',
						'$prc',
					'$price',
				'$rimarks',
			'$entry_by',
		'$entry_time')";
		$sql = mysql_query($query);	
	?>

<html>
<body>
     <form action="ProductInFiber" method="post" name="main">
       <input type="hidden" name="sts" value="ProductInFiber">
     </form>

     <script language="javascript" type="text/javascript">
		document.main.submit();
     </script>
</body>
</html>

<?php }} if ($typ == 'InstrumentsIn'){
		if(empty($_POST['voucher_no'])) { } else{
		$query="insert into store_in_instruments 
		(purchase_date, 
			voucher_no, 
				purchase_by, 
					vendor, 
						p_sts, 
							p_sl_no, 
								p_id, 
									brand, 
										quantity,
											unite_price,
												price, 
													rimarks, 
														entry_by, 
															entry_time) 
																VALUES ('$purchase_date',
			'$voucher_no',
				'$purchase_by',
					'$vendor',
						'$p_sts',
							'$p_sl_no',
								'$p_id',
									'$brand',
										'$quantity',
											'$prc',
												'$price',
													'$rimarks',
														'$entry_by',
															'$entry_time')";
		$sql = mysql_query($query);	
		
//TELEGRAM Start....
$sqlsdsgg = mysql_query("SELECT i.id, i.purchase_date, i.voucher_no, i.purchase_by, e.e_name AS purchaseby, i.vendor, v.v_name, i.p_sts, i.p_sl_no, i.p_id, p.pro_name, i.brand, i.quantity, i.price, i.rimarks, i.entry_by, a.e_name AS entryby, i.entry_time, i.sts FROM store_in_instruments AS i
													LEFT JOIN emp_info AS e
													ON e.e_id = i.purchase_by
													LEFT JOIN vendor AS v
													ON v.id = i.vendor
													LEFT JOIN product AS p
													ON p.id = i.p_id
													LEFT JOIN emp_info AS a
													ON a.e_id = i.entry_by
													ORDER BY i.id DESC LIMIT 1");
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


if($tele_sts == '0' && $tele_instruments_in_sts == '0'){
$telete_way = 'instruments_in';
$msg_body='..::[Store Instruments IN]::..
'.$pro_name.' ['.$brand11.']

Voucher No: '.$voucher_no.'
Quantity: '.$quantity.' Pis
Price: '.$priceee.' TK
SL No: '.$p_sl_nooo.'
Vendor: '.$v_namee.'

Purchaser: '.$purchaseby.' ('.$purchase_byyy.')
Note: '.$rimarkdds.'

By: '.$entryby.'
'.$tele_footer.'';

include('include/telegramapicore.php');
}
//TELEGRAM END....	
	?>

<html>
<body>
     <form action="ProductInInstruments" method="post" name="main">
       <input type="hidden" name="sts" value="InstrumentsIn">
     </form>

     <script language="javascript" type="text/javascript">
		document.main.submit();
     </script>
</body>
</html>
<?php
}}
	?>
<?php if ($typ == 'InstrumentsIn1'){
								$itemNooo  = $_POST['itemNo'];
								$productNameArray = $_POST['productName'];
								$brandArray = $_POST['brand'];
								$pstsArray = $_POST['psts'];
								$quantityArray = $_POST['quantity'];
								$qtystsArray = $_POST['qtysts'];
								
								
								
								foreach( $itemNooo as $key => $productNo ){											
											$itemNameValu = $productNameArray[$key];
											$brandValu = $brandArray[$key];
											$quantityValu = $quantityArray[$key];
											$qtystsValu = $qtystsArray[$key];
											
											if($qtystsValu != '0'){
											foreach( $_POST['slno'.$productNo] as $keyy => $productNoe ){	
											
//											echo $itemNameValu.'-'.$productNoe.'<br>';
											$query="insert into store_instruments_sl (p_id, slno) VALUES ('$productNo', '$productNoe')";

											$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
											}
											}

								}

}
	?>

