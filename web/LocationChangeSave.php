<?php
include("conn/connection.php") ;
$e_date = date('Y-m-d');
extract($_POST);
if( empty($_POST['c_id']) || empty($_POST['new_addr']) ){
	echo 'Please Fill all fild and try again';
}
else{
	$sql = mysql_query("UPDATE clients SET address = '$new_addr', z_id = '$z_id' WHERE c_id = '$c_id'");
	$sql = mysql_query("INSERT INTO line_shift (rec_by , e_date, c_id, old_addr, new_addr, cont, shift_date, shift_sts) 
						VALUES 
						('$rec_by' , '$e_date', '$c_id', '$old_addr', '$new_addr', '$cont', '$shift_date', '$shift_sts')");
}
if ($sql){
	header("location: LocationChange");
}
else{
	echo 'Error, Please try again';
}
mysql_close($con);
?>