<?php
include("conn/connection.php") ;
extract($_POST);

if( empty($_POST['id']) || empty($_POST['rec_by']) ){
	echo 'Please Fill all fild and try again';
}
else{
	$sql = mysql_query("UPDATE collection SET rec_by = '$rec_by', note = '$note', sts = '1', rec_date_time = '$rec_date_time' WHERE id = '$id'");
}
if ($sql){
	header("location: CollectionReceive");
}
else{
	echo 'Error, Please try again'; 
}
mysql_close($con);
?>