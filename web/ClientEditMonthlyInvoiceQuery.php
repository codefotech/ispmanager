<?php
session_start();
$update_by = $_SESSION['SESS_EMP_ID'];
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);

if($c_id != '' && $update_by != ''){
$query2dd = "UPDATE vlan SET sts = '1' WHERE c_id = '$c_id'";
$resultff = mysql_query($query2dd) or die("inser_query failed: " . mysql_error() . "<br />");
foreach($_POST['vlanId'] as $count => $vlanNo){
	$Sqls = "INSERT INTO vlan (c_id, vlan_id, vlan_name) VALUES ('$c_id', '$vlanNo', '$vlanName[$count]')";
    $result = mysql_query($Sqls) or die("inser_query failed: " . mysql_error() . "<br />");
}

$query2ip = "UPDATE ip_address SET sts = '1' WHERE c_id = '$c_id'";
$resultf = mysql_query($query2ip) or die("inser_query failed: " . mysql_error() . "<br />");
foreach($_POST['ipaddress'] as $ipcount => $ipNo){
	$Sqlsip = "INSERT INTO ip_address (c_id, ip_address) VALUES ('$c_id', '$ipaddress[$ipcount]')";
    $resultss = mysql_query($Sqlsip) or die("inser_query failed: " . mysql_error() . "<br />");
}


$itemNooo  = $_POST['itemNo'];
$itemNameArray = $_POST['itemName'];
$itemDesArray = $_POST['itemDes'];
$quantityArray = $_POST['quantity'];
$unitArray = $_POST['unit'];
$unitepriceArray = $_POST['uniteprice'];
$vatArray = $_POST['vat'];
$priceArray = $_POST['price'];
$totalprice = $_POST['total_price'];
$subtotal = $_POST['subtotal'];
$nttn = $_POST['nttn'];
$link_id = $_POST['link_id'];
$invoice_date = $_POST['invoice_date'];
$due_deadline = $_POST['due_deadline'];

if($totalprice >= '1'){
	
$query2in = "UPDATE monthly_invoice SET sts = '1', delete_by = '$update_by' WHERE c_id = '$c_id'";
$resultin = mysql_query($query2in) or die("inser_query failed: " . mysql_error() . "<br />");
	
	foreach( $itemNooo as $key => $productNo ){
				$itemNameValu =$itemNameArray[$key];
				$itemDesValu =$itemDesArray[$key];
				$quantityValu =$quantityArray[$key];
				$unitValu =$unitArray[$key];
				$unitepriceValu =$unitepriceArray[$key];
				$vatValu =$vatArray[$key];
				$priceValu =$priceArray[$key];
				
				if ($productNo != '' && $itemNameValu != '' && $quantityValu >= '1' && $unitValu != '' && $unitepriceValu >= '1' && $priceValu >= '1'){
					$Sqlsin = ("INSERT INTO monthly_invoice (c_id, item_id, item_name, description, quantity, unit, uniteprice, vat, days, total_price, update_by) 
					VALUES ('$c_id', '$productNo', '$itemNameValu', '$itemDesValu', '$quantityValu', '$unitValu', '$unitepriceValu', '$vatValu', '30', '$priceValu', '$update_by')");
					
					$resulsff = mysql_query($Sqlsin) or die("inser_query failed: " . mysql_error() . "<br />");
				}
				else{
					echo 'Wrong Entry. Try Again.';
				}
	}
	
$quy2in = "UPDATE clients SET total_price = '$totalprice', subtotal = '$subtotal' WHERE c_id = '$c_id'";
$reltin = mysql_query($quy2in) or die("inser_query failed: " . mysql_error() . "<br />");
}

$quy2in = "UPDATE clients SET nttn = '$nttn', link_id = '$link_id', invoice_date = '$invoice_date', due_deadline = '$due_deadline' WHERE c_id = '$c_id'";
$reltin = mysql_query($quy2in) or die("inser_query failed: " . mysql_error() . "<br />");

?>
<html>
	<body>
		<form action="ClientEditInvoice" method="post" name="ok">
			<input type="hidden" name="sts" value="invoicechange">
			<input type="hidden" name="message" value="<?php echo $message;?>">
			<input type="hidden" name="c_id" value="<?php echo $c_id;?>">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>
<?php
}
?>
