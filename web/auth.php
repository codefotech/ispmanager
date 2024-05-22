<?php
	//Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] != 'admin') {
		header("location: AccessDenied");
		exit();
	}
?>