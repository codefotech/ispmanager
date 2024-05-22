<?php
include("conn/connection.php") ;
$e_date = date('Y-m-d');
extract($_POST);
if( empty($_POST['c_id']) || empty($_POST['new_addr']) ){
	echo 'Please Fill all fild and try again';
}
else{
	$sql = mysql_query("UPDATE clients SET address = '$new_addr', old_address = '$old_addr', z_id = '$z_id' WHERE c_id = '$c_id'");
	$sql = mysql_query("UPDATE line_shift SET old_addr = '$old_addr', new_addr = '$new_addr', shift_date = '$shift_date', cont = '$cont', shift_sts = '$shift_sts' WHERE id = '$id'");
}
if ($sql){
	header("location: LocationChange");
}
else{
	echo 'Error, Please try again';
}
mysql_close($con);
?>