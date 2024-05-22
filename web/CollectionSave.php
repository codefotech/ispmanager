<?php
include("conn/connection.php") ;
extract($_POST);

if( empty($_POST['ent_by']) || empty($_POST['c_clint']) || empty($_POST['c_amount']) ){
	echo 'Please Fill all fild and try again';
}
else{
	$sql = mysql_query("INSERT INTO collection (c_date, c_clint, c_amount, ent_by) VALUES ('$c_date', '$c_clint', '$c_amount', '$ent_by')");
}
if ($sql){
	header("location: Collection");
}
else{
	echo 'Error, Please try again';
}
mysql_close($con);
?>