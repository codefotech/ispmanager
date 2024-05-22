<?php
session_start(); // NEVER FORGET TO START THE SESSION!!!
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
	
include("conn/connection.php");
extract($_POST);

 if($_POST['pass1'] != '' &&  $_POST['pass2'] != ''){
	if($_POST['pass1'] == $_POST['pass2']){
	$cpass = sha1($pass2);
	$query ="update login set password = '$cpass', user_name = '$user_name', e_id = '$e_id', user_type = '$user_type' WHERE id = '$id'";
	$result1 = mysql_query($query) or die("inser_query failed: " . mysql_error() . "<br />");
?>
 <html>
<body>
     <form action="Users" method="post" name="ok">
       <input type="hidden" name="sts" value="edit">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php	}
	else{
		echo("Oops! Password did not match! Try again. ");
	}
}
elseif($_POST['pass1'] != '' && $_POST['pass2'] == ''){
	echo("Oops! Password did not match! Try again. ");
}
elseif($_POST['pass1'] == '' && $_POST['pass2'] != ''){
	echo("Oops! Password did not match! Try again. ");
}
else{
 if($user_name != '' && $e_id != '' && $user_type != ''){
	$query55 ="update login set user_name = '$user_name', e_id = '$e_id', user_type = '$user_type' WHERE id = '$id'";
	$result55 = mysql_query($query55) or die("inser_query failed: " . mysql_error() . "<br />");
?>
 <html>
<body>
     <form action="Users" method="post" name="ok">
       <input type="hidden" name="sts" value="edit">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php 
}
else{
	echo("Oops! Password did not match! Try again. ");
}

}
mysql_close($con);
?>
