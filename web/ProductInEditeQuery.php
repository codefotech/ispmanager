<?php
include("conn/connection.php");
extract($_POST);
$table1 = 'store_in';

		$query ="update $table1 set voucher_no = '$voucher_no', purchase_by = '$purchase_by', vendor= '$vendor', p_sts = '$p_sts', p_sl_no = '$p_sl_no', p_id = '$p_id', brand = '$brand', fiber_id = '$fiber_id', fiberstart = '$fiberstart', fiberend = '$fiberend', fibertotal = '$fibertotal', price = '$price', rimarks= '$rimarks' WHERE id = '$id'";							
		if (!mysql_query($query))					
		{					
			die('Error: ' . mysql_error());					
		}
		
		$query3 = "insert into edite_detail (table_name, table_id, edite_by, edite_time) VALUES ('$table1', '$id', '$edite_by', '$edite_time')";
		if (!mysql_query($query3))
			{
				die('Error: ' . mysql_error());
			}
?>

<html>
<body>
     <form action="StoreInDetails" method="post" name="main">
       <input type="hidden" name="sts" value="main">
     </form>

     <script language="javascript" type="text/javascript">
		document.main.submit();
     </script>
</body>
</html>
