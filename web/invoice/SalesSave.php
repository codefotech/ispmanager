<?php
include("../conn/connection.php") ;
extract($_POST);
$tbl_name="sales_master";
$tbl_name1="sales_details";

$itemNo  = $_POST['itemNo'];
$itemNameArray = $_POST['itemName'];
$item_Model = $_POST['itemModel'];
$priceArray = $_POST['price'];
$quantityArray = $_POST['quantity'];
$totalArray = $_POST['total'];

$ques="SELECT * FROM sales_number WHERE sts = 0 ORDER BY id LIMIT 1";
$sqlds = mysql_query($ques);
$rowds = mysql_fetch_assoc($sqlds);

$inv_no = $rowds['id'];

$que="SELECT * FROM $tbl_name WHERE invoiceNo = '$inv_no' ";
$sqld = mysql_query($que);
$rowd = mysql_fetch_assoc($sqld);



if($rowd == 0){
	
	if($inv_no != ''){
	
		$query = ("INSERT INTO sales_master (clientId, invoiceNo, invoiceDate, invoiceTime, invoiceNote, discount, paidAmount, EntBy, EntDate) VALUES ('$clientId', '$inv_no', '$invoiceDate', '$invoiceTime', '$invoiceNote', '$discount', '$paidAmount', '$EntBy', '$EntDate')");
		
		foreach( $itemNo as $key => $productNo ){
			$productModel =$item_Model[$key];
			$PriceValu =$priceArray[$key];
			$QuantityValu =$quantityArray[$key];
			$TotalValu =$totalArray[$key];
			
			$Sqls = ("INSERT INTO sales_details (invoiceNo, productCode, productModel, unitPrice, quantity, total) 
			VALUES ('$inv_no', '$productNo', '$productModel', '$PriceValu', '$QuantityValu', '$TotalValu')");
			
			$resuls = mysql_query($Sqls) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		
		$sqlupdate = mysql_query("UPDATE sales_number SET sts = '1' WHERE id = '$inv_no'"); 
		
		$query_dm="insert into sales_number (useBy, sts) VALUES ('$clientId', '0')"; 

		$result_dm = mysql_query($query_dm) or die("inser_query failed: " . mysql_error() . "<br />");
		
		
		$sql = mysql_query($query);
		if ($sql)
			{
				//header("location: Sales");  
			}
		else
			{ 
				die('Error: ' . mysql_error());
			}
			
	}
	else{
		echo 'Error! Order Id Empty';
	}
}
else{
		echo 'Error! Duplicate Entry';
	}	

mysql_close($con);
?>

<html>
<title> Sales Print </title>
<body>
     <form action="../invoicer/Invoice" method="POST" target="_blank" name="Print">
       <input type="hidden" name="inv_no" value="<?php echo $inv_no; ?>">
	   <input type="hidden" name="d_id" value="<?php echo $d_id; ?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.Print.submit();
     </script>
	 
</body>
</html>

<html>
<title> Sales </title>
<body>	 
	 <form action="Sales" method="POST" name="Sales">
	 
     </form>

     <script language="javascript" type="text/javascript">
		document.Sales.submit();
     </script>
</body>
</html>