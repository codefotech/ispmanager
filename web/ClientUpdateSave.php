<?php
include("conn/connection.php") ;
extract($_POST);

		$query="UPDATE customer_info SET
				z_id = '$z_id',
				sz_id = '$sz_id',
				c_type = '$c_type',
				c_name = '$c_name',
				s_name = '$s_name',
				s_add = '$s_add',
				cont_per_name = '$cont_per_name',
				cont_no = '$cont_no',
				com_name = '$com_name',
				won_name = '$won_name',
				com_add = '$com_add',
				join_date = '$join_date',
				cont_no1 = '$cont_no1',
				cont_no2 = '$cont_no2',
				cont_no3 = '$cont_no3',
				email = '$email',
				website = '$website',
				postal = '$postal',
				month_cons = '$month_cons',
				note = '$note'
				WHERE c_id = '$c_id' ";

		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");

		if ($result){
				header('Location: clients');
			}
		else{
				echo 'Error, Please try again';
			}
mysql_close($con);
?>