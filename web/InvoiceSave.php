<?php
include("conn/connection.php") ;
extract($_POST);
$tbl_name="invoice_book";

if (empty($_POST['z_id']) || empty($_POST['st_num']) || empty($_POST['end_num']))
{}
else
{
	for($x = $st_num; $x <= $end_num; $x++)
	{
		$query="insert into $tbl_name (e_date, b_no, inv_no, z_id, ent_by) VALUES ('$date', '$b_no', '$x', '$z_id', '$ent_by')";

		$sql = mysql_query($query);
	}

	if ($sql)
		{
			header("location: Invoice");
		}
	else
		{
			echo 'Error, Please try again';
		}

}

sql_close($con);
?>