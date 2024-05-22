<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
	else{
include("conn/connection.php");
$tree_id = $_GET['id'];

		$query ="DELETE FROM network_tree_polyline WHERE tree_id = '$tree_id'";
		$result = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
		
echo '<script type="text/javascript">window.close()</script>';
echo("<meta http-equiv='refresh' content='1'>");
	}
?>
