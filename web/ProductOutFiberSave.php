<?php
include("conn/connection.php") ;
extract($_POST);

	$result = mysql_query("SELECT fibertotal, fibertotal_out FROM store_in_out_fiber WHERE id = '$f_id'");
	$row = mysql_fetch_array($result);
	$fibertotal = $row['fibertotal'];
	$fibertotal_out = $row['fibertotal_out'];
	$rem_st = $fibertotal - $fibertotal_out;

	if($rem_st >= $qty){

		$stt = $fibertotal_out + $qty;

			if($stt >= $fibertotal){

				$sts = 1;

			}else{

				$sts = 0;

			}

		$query = "UPDATE store_in_out_fiber SET fibertotal_out = '$stt', sts = '$sts', out_date = '$out_date', out_date_time = '$out_date_time', receive_by = '$receive_by', note = '$note', out_by = '$out_by' WHERE id = '$f_id'";
		$sql = mysql_query($query);
		

		if ($sql){
			{
		$queryq="insert into store_out_fiber 
				(out_date, 
				st_id , 
				qty, 
				receive_by, 
				out_by,
				c_id,
				note)
		VALUES ('$out_date',
				'$f_id',
				'$qty',
				'$receive_by',
				'$out_by',
				'$c_id',
				'$rmk')";
		$sql4 = mysql_query($queryq);}
			
			?>

<html>
<body>
     <form action="ProductOutFiber" method="post" name="main">
       <input type="hidden" name="sts" value="fiberout">
     </form>
     <script language="javascript" type="text/javascript">
		document.main.submit();
     </script>
</body>
</html>

		<?php }else{

			echo 'Error, Please try again';

		}

	}else{

		echo 'Quentity out of stock';

	}
?>