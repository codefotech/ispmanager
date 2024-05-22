<?php
include("conn/connection.php") ;
extract($_POST);

if($f_id == ''){
	
	$query = "UPDATE store_in SET sts = 1 WHERE id = '$p_id'";
	$sql = mysql_query($query);
	$query1 = "INSERT INTO store_out (st_id, qty, out_date, out_by, out_date_time, receive_by, note) VALUES ('$p_id', '1', '$out_date', '$out_by', '$out_date_time', '$receive_by', '$rmk')";
	$sql1 = mysql_query($query1);
	if ($sql && $sql1){
		header("location: ProductOut");
	}else{
		echo 'Error, Please try again';
	}
}elseif ($p_id == ''){
	$result = mysql_query("SELECT fibertotal, fibertotal_out FROM store_in WHERE id = '$f_id'");
	$row = mysql_fetch_array($result);
	$fibertotal = $row['fibertotal'];
	$fibertotal_out = $row['fibertotal_out'];
	$rem_st = $fibertotal - $fibertotal_out;
	//echo $qty;
	
	if($rem_st >= $qty){
		$stt = $fibertotal_out + $qty;
			if($stt >= $fibertotal){
				$sts = 1;
			}else{
				$sts = 0;
			}
		$query = "UPDATE store_in SET fibertotal_out = '$stt', sts = '$sts' WHERE id = '$f_id'";
		$sql = mysql_query($query);
		$query1 = "INSERT INTO store_out (st_id, qty, out_date, out_by, out_date_time, receive_by, note) VALUES ('$f_id', '$qty', '$out_date', '$out_by', '$out_date_time', '$receive_by', '$rmk')"; 
		$sql1 = mysql_query($query1);
		
		if ($sql && $sql1){
			header("location: ProductOut");
		}else{
			echo 'Error, Please try again';
		}
	}else{
		echo 'Out of stock Quentity';
	}

}else{
	
	$result = mysql_query("SELECT fibertotal, fibertotal_out FROM store_in WHERE id = '$f_id'");
	$row = mysql_fetch_array($result);
	$fibertotal = $row['fibertotal'];
	$fibertotal_out = $row['fibertotal_out'];
	$rem_st = $fibertotal - $fibertotal_out;
	//echo $qty;
	
	if($rem_st >= $qty){
		$stt = $fibertotal_out + $qty;
			if($stt >= $fibertotal){
				$sts = 1;
			}else{
				$sts = 0;
			}
		$query = "UPDATE store_in SET fibertotal_out = '$stt', sts = '$sts' WHERE id = '$f_id'";
		$sql = mysql_query($query);
		$query1 = "INSERT INTO store_out (st_id, qty, out_date, out_by, out_date_time, receive_by, note) VALUES ('$f_id', '$qty', '$out_date', '$out_by', '$out_date_time', '$receive_by', '$rmk')";
		$sql1 = mysql_query($query1);
		
		$query2 = "UPDATE store_in SET sts = 1 WHERE id = '$p_id'";
		$sql2 = mysql_query($query2);
		$query3 = "INSERT INTO store_out (st_id, qty, out_date, out_by, out_date_time, receive_by, note) VALUES ('$p_id', '1', '$out_date', '$out_by', '$out_date_time', '$receive_by', '$rmk')";
		$sql3 = mysql_query($query3);
		
		if ($sql && $sql1 && $sql2 && $sql3){
			header("location: ProductOut");
		}else{
			echo 'Error, Please try again';
		}
	}else{
		echo 'Quentity out of stock';
	}
}

mysql_close($con);
?>