<?php
include("conn/connection.php") ;
extract($_POST);

	$pass = sha1($passid);
	
$query=mysql_query("SELECT e_id FROM zone WHERE z_id = '$z_id'");
$row2ff = mysql_fetch_assoc($query);
$e_id = $row2ff['e_id'];

if($e_id == ''){
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, pw) VALUES ('$c_name', '$c_id', '$c_id', '$pass', 'client', '$passid')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
}
else{
				$query1 = "insert into login (user_name, e_id, user_id, password, user_type, pw, log_sts) VALUES ('$c_name', '$c_id', '$c_id', '$pass', 'client', '$passid', '1')";
				$result1 = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");
}
echo '<script type="text/javascript">window.close()</script>';



?>